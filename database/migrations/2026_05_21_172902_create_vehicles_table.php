<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('vehicle_make_id')
                ->constrained('vehicle_makes')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('vehicle_model_id')
                ->constrained('vehicle_models')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('name');
            $table->string('slug')->unique();

            $table->string('stock_number')->nullable()->unique();
            $table->string('vin', 32)->nullable()->unique();

            $table->unsignedSmallInteger('year')->nullable();

            $table->decimal('price', 12, 2)->nullable();
            $table->boolean('price_on_request')->default(false);

            $table->unsignedInteger('mileage')->nullable();

            $table->string('condition')->default('used');
            $table->string('body_type')->nullable();
            $table->string('transmission')->nullable();
            $table->string('drivetrain')->nullable();
            $table->string('engine')->nullable();
            $table->string('fuel_type')->nullable();
            $table->string('exterior_color')->nullable();
            $table->string('interior_color')->nullable();

            $table->string('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->json('features')->nullable();

            $table->string('main_image')->nullable();

            $table->string('status')->default('available');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamp('published_at')->nullable();

            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();

            $table->timestamps();

            $table->index(['vehicle_make_id', 'is_active']);
            $table->index(['vehicle_model_id', 'is_active']);
            $table->index(['status', 'is_active']);
            $table->index(['is_featured', 'is_active']);
            $table->index('price');
            $table->index('year');
            $table->index('mileage');
            $table->index('body_type');
            $table->index('transmission');
            $table->index('drivetrain');
            $table->index('exterior_color');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
