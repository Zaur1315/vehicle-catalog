<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Mail\LeadNotificationMail;
use App\Models\Lead;
use App\Models\Vehicle;
use App\Models\VehicleMake;
use App\Models\VehicleModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

final class SouthernYorkTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Mail::fake();
        Http::preventStrayRequests();
        config([
            'lead.notification_email' => 'dealer@example.test',
            'services.meta.capi_enabled' => false,
            'inertia.pages.paths' => [resource_path('js/Pages')],
        ]);
    }

    private function vehicle(array $attributes = []): Vehicle
    {
        $make = VehicleMake::firstOrCreate(['slug' => 'test-make'], ['name' => 'Test Make', 'is_active' => true]);
        $model = VehicleModel::firstOrCreate(['slug' => 'test-model', 'vehicle_make_id' => $make->id], ['name' => 'Test Model', 'is_active' => true]);

        return Vehicle::create([
            'vehicle_make_id' => $make->id,
            'vehicle_model_id' => $model->id,
            'name' => '2022 Test Vehicle',
            'slug' => 'test-'.Vehicle::count(),
            'year' => 2022,
            'price' => 20000,
            'mileage' => 30000,
            'status' => 'available',
            'is_active' => true,
            'is_featured' => true,
            ...$attributes,
        ]);
    }

    public function test_inventory_filters_sorting_and_private_vehicles(): void
    {
        $cheap = $this->vehicle(['price' => 12000]);
        $this->vehicle(['price' => 30000]);
        $sold = $this->vehicle(['status' => 'sold']);
        $hidden = $this->vehicle(['is_active' => false]);

        $this->get('/inventory?make=test-make&price_max=15000&sort=price_asc')
            ->assertInertia(fn (Assert $page) => $page->component('Inventory/Index')
                ->has('vehicles.data', 1)->where('vehicles.data.0.id', $cheap->id));
        $this->get('/inventory?sort=price_asc')->assertInertia(fn (Assert $page) => $page
            ->has('vehicles.data', 2)->where('vehicles.data.0.id', $cheap->id));
        foreach ([$sold, $hidden] as $vehicle) {
            $this->get('/inventory/'.$vehicle->slug)->assertNotFound();
            $this->post('/inventory/'.$vehicle->slug.'/inquiry', ['first_name' => 'Test', 'phone' => '7175550100'])->assertNotFound();
        }
        $this->assertDatabaseCount('leads', 0);
    }

    public function test_all_four_forms_validate_then_persist_and_notify(): void
    {
        $vehicle = $this->vehicle();
        $flows = [
            ['/contact', Lead::TYPE_CONTACT, []],
            ['/finance', Lead::TYPE_FINANCE, ['vehicle_interest' => $vehicle->name, 'amount' => 15000]],
            ['/trade-in', Lead::TYPE_TRADE_IN, ['make' => 'Test', 'model' => 'Car', 'year' => 2020, 'mileage' => 50000]],
            ['/inventory/'.$vehicle->slug.'/inquiry', Lead::TYPE_VEHICLE_INQUIRY, []],
        ];
        foreach ($flows as [$url, $type, $extra]) {
            $this->from($url)->post($url, [])->assertSessionHasErrors(['first_name', 'phone']);
            $this->from($url)->post($url, ['first_name' => 'Test', 'phone' => '7175550100', 'email' => 'invalid', ...$extra])->assertSessionHasErrors('email');
        }
        $this->assertDatabaseCount('leads', 0);
        Mail::assertNothingSent();

        foreach ($flows as [$url, $type, $extra]) {
            $this->from('/contact')->post($url, [
                'first_name' => 'Test',
                'last_name' => 'Buyer',
                'phone' => '7175550100',
                'email' => 'buyer@example.test',
                'message' => 'Please tell me more.',
                ...$extra,
            ])->assertRedirect('/contact')->assertSessionHasNoErrors()->assertSessionHas('success')->assertSessionHas('meta_event.event_id');
            $this->assertDatabaseHas('leads', ['type' => $type, 'email' => 'buyer@example.test']);
        }
        $this->assertDatabaseCount('leads', 4);
        $this->assertDatabaseHas('leads', ['vehicle_id' => $vehicle->id, 'type' => Lead::TYPE_VEHICLE_INQUIRY]);
        Mail::assertSent(LeadNotificationMail::class, 4);
        Http::assertNothingSent();
    }

    public function test_canonical_sitemap_and_no_inherited_reviews(): void
    {
        config(['site.domain' => 'southernyorkmotors.com']);
        $vehicle = $this->vehicle();
        $this->get('/')->assertInertia(fn (Assert $page) => $page->missing('reviews')->has('featuredVehicles', 1));
        $this->get('/sitemap.xml')->assertSee('https://southernyorkmotors.com/inventory/'.$vehicle->slug, false);
        $this->get('/robots.txt')->assertSee('https://southernyorkmotors.com/sitemap.xml', false);
    }

    public function test_mail_failure_does_not_lose_saved_lead(): void
    {
        Mail::shouldReceive('to')->once()->andThrow(new \RuntimeException('Simulated provider failure'));
        $this->from('/contact')->post('/contact', ['first_name' => 'Test', 'phone' => '7175550100'])
            ->assertRedirect('/contact')->assertSessionHas('success');
        $this->assertDatabaseCount('leads', 1);
    }

    public function test_meta_failure_does_not_interrupt_saved_lead_or_mail(): void
    {
        config([
            'services.meta.capi_enabled' => true,
            'services.meta.pixel_id' => 'test-pixel',
            'services.meta.capi_access_token' => 'test-token',
        ]);
        Http::fake(fn () => throw new ConnectionException('Simulated connection failure'));
        $this->withCookie('cookie_marketing_consent', '1')->from('/contact')
            ->post('/contact', ['first_name' => 'Test', 'phone' => '7175550100'])
            ->assertRedirect('/contact')->assertSessionHas('success');
        $this->assertDatabaseCount('leads', 1);
        Mail::assertSent(LeadNotificationMail::class, 1);
    }

    public function test_browser_and_server_share_the_same_lead_event_id(): void
    {
        config([
            'services.meta.capi_enabled' => true,
            'services.meta.pixel_id' => 'test-pixel',
            'services.meta.capi_access_token' => 'test-token',
        ]);
        Http::fake(['graph.facebook.com/*' => Http::response(['events_received' => 1])]);
        $this->withCookie('cookie_marketing_consent', '1')->from('/contact')
            ->post('/contact', ['first_name' => 'Test', 'phone' => '7175550100', 'subject' => 'Finance question'])
            ->assertSessionHas('meta_event.form_type', 'finance');
        $eventId = session('meta_event.event_id');
        Http::assertSent(fn ($request) => $request['data'][0]['event_id'] === $eventId
            && $request['data'][0]['event_name'] === 'Lead');
    }

    public function test_imported_marketing_is_hidden_without_changing_inventory(): void
    {
        $description = '<p>This 2022 Test Vehicle has been prepared for sale and is available from a previous dealer.</p><p>Contact our sales team for current availability, pricing confirmation, delivery options, warranty details, finance questions, and trade-in review.</p>';
        $vehicle = $this->vehicle(['description' => $description]);
        $this->get('/inventory/'.$vehicle->slug)->assertInertia(fn (Assert $page) => $page
            ->where('vehicle.description_html', '')
            ->where('vehicle.seo_title', '2022 Test Vehicle in New Freedom, PA'));
        $this->assertSame($description, $vehicle->fresh()->description);
        $vehicle->update(['description' => '<p>Recent tires. Service records available.</p>']);
        $this->get('/inventory/'.$vehicle->slug)->assertInertia(fn (Assert $page) => $page
            ->where('vehicle.description_html', '<p>Recent tires. Service records available.</p>'));
    }
}
