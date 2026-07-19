<script setup>
import {Link, usePage} from '@inertiajs/vue3';
import {computed} from 'vue';
import SiteLayout from '@/Layouts/SiteLayout.vue';
import SeoHead from '@/Components/SeoHead.vue';

defineOptions({layout: SiteLayout});

const props = defineProps({
    featuredVehicles: {type: Array, default: () => []},
    reviews: {type: Array, default: () => []},
});

const page = usePage();
const site = computed(() => page.props.site || {});
const heroVehicle = computed(() => props.featuredVehicles[0] || null);

const homeSchema = computed(() => ({
    '@context': 'https://schema.org',
    '@type': 'AutoDealer',
    name: site.value.name || 'Cars For Less',
    description: 'Used vehicle sales and automotive service in East Granby, Connecticut.',
    telephone: site.value.phone_tel || '+18604219675',
    email: site.value.email || 'carsforlesseric@gmail.com',
    url: typeof window !== 'undefined' ? window.location.origin : '',
    address: {
        '@type': 'PostalAddress',
        streetAddress: '108a Rainbow Rd',
        addressLocality: site.value.city || 'East Granby',
        addressRegion: site.value.state || 'CT',
        postalCode: site.value.zip || '06026',
        addressCountry: site.value.country || 'USA',
    },
}));

const shoppingPaths = [
    {label: 'Cars & Sedans', query: 'body_type=sedan', mark: '01'},
    {label: 'SUVs & Crossovers', query: 'body_type=suv', mark: '02'},
    {label: 'Trucks', query: 'body_type=truck', mark: '03'},
    {label: 'View Everything', query: '', mark: '04'},
];

const process = [
    {number: '01', title: 'Explore the lot', text: 'Browse current vehicles online, then narrow the list by price, mileage, make, model, and body style.'},
    {number: '02', title: 'Talk to a real person', text: 'Call or send an inquiry. We will answer questions about availability, condition, financing, and your trade.'},
    {number: '03', title: 'Take the next step', text: 'Visit us in East Granby, arrange a test drive, and review the vehicle and purchase details in person.'},
];
</script>

<template>
    <SeoHead
        :title="site.name"
        description="Shop used vehicles from Cars For Less Sales & Service in East Granby, CT. Browse inventory, ask about financing, or value your trade."
        :schema="homeSchema"
    />

    <section class="overflow-hidden border-b border-black/10 bg-[#f5f3ee]">
        <div class="site-container grid min-h-[720px] items-stretch lg:grid-cols-[0.88fr_1.12fr]">
            <div class="flex flex-col justify-center py-16 pr-0 lg:py-24 lg:pr-14">
                <p class="flex items-center gap-3 text-[11px] font-black uppercase tracking-[0.26em] text-[#e9422c]">
                    <span class="h-px w-9 bg-[#e9422c]"></span>
                    Used cars in East Granby, CT
                </p>
                <h1 class="mt-7 max-w-3xl text-[clamp(3.7rem,7vw,7.4rem)] font-black leading-[0.82] tracking-[-0.075em] text-[#171717]">
                    More car.<br><span class="text-[#ff4f38]">Less runaround.</span>
                </h1>
                <p class="mt-8 max-w-xl text-lg leading-8 text-stone-600">
                    Straightforward used vehicle shopping from a local sales and service team. Find a car, ask about financing, or bring us your trade.
                </p>
                <div class="mt-9 flex flex-wrap items-center gap-4">
                    <Link href="/inventory" class="rounded-full bg-[#171717] px-7 py-4 text-xs font-black uppercase tracking-[0.08em] text-white transition hover:bg-[#ff4f38]">
                        Shop available cars
                    </Link>
                    <a :href="`tel:${site.phone_tel}`" class="group flex items-center gap-3 text-sm font-black">
                        <span class="flex h-12 w-12 items-center justify-center rounded-full border border-black/20 transition group-hover:border-[#ff4f38] group-hover:text-[#ff4f38]">↗</span>
                        {{ site.phone }}
                    </a>
                </div>
            </div>

            <div class="relative min-h-[480px] bg-[#d9d5cc] lg:min-h-full">
                <img
                    v-if="heroVehicle?.image_medium"
                    :src="heroVehicle.image_medium"
                    :alt="heroVehicle.name"
                    class="absolute inset-0 h-full w-full object-cover"
                >
                <div v-else class="absolute inset-0 bg-[linear-gradient(135deg,#cbc5b9,#eeeae1)]"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/5 to-transparent"></div>

                <div class="absolute left-0 top-0 bg-[#ff4f38] px-5 py-3 text-[10px] font-black uppercase tracking-[0.2em] text-white lg:left-auto lg:right-0">
                    Local dealer · East Granby
                </div>

                <div v-if="heroVehicle" class="absolute inset-x-0 bottom-0 p-7 text-white sm:p-10">
                    <p class="text-[10px] font-black uppercase tracking-[0.24em] text-white/65">Featured on the lot</p>
                    <div class="mt-3 flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <h2 class="text-3xl font-black tracking-[-0.04em] sm:text-4xl">{{ heroVehicle.name }}</h2>
                            <p class="mt-2 text-sm text-white/70">{{ heroVehicle.mileage }} · {{ heroVehicle.price }}</p>
                        </div>
                        <Link :href="`/inventory/${heroVehicle.slug}`" class="shrink-0 rounded-full bg-white px-6 py-3 text-xs font-black uppercase tracking-wide text-black transition hover:bg-[#ff4f38] hover:text-white">
                            View vehicle
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-[#171717] py-8 text-white">
        <div class="site-container grid gap-6 lg:grid-cols-[0.6fr_2.4fr] lg:items-center">
            <div>
                <p class="text-[10px] font-black uppercase tracking-[0.24em] text-[#ff5a45]">Start your search</p>
                <p class="mt-1 text-sm text-stone-400">Shop the way you want.</p>
            </div>
            <div class="grid border-l border-white/10 sm:grid-cols-2 lg:grid-cols-4">
                <Link
                    v-for="item in shoppingPaths"
                    :key="item.label"
                    :href="item.query ? `/inventory?${item.query}` : '/inventory'"
                    class="group flex items-center justify-between border-b border-r border-white/10 px-5 py-4 transition hover:bg-white/5 sm:border-b-0"
                >
                    <span class="text-sm font-black">{{ item.label }}</span>
                    <span class="text-[10px] text-stone-600 transition group-hover:text-[#ff5a45]">{{ item.mark }}</span>
                </Link>
            </div>
        </div>
    </section>

    <section class="bg-white py-20 lg:py-28">
        <div class="site-container">
            <div class="flex flex-col gap-6 border-b border-black/10 pb-8 md:flex-row md:items-end md:justify-between">
                <div>
                    <p class="text-[10px] font-black uppercase tracking-[0.25em] text-[#e9422c]">Fresh on the lot</p>
                    <h2 class="mt-4 text-4xl font-black tracking-[-0.055em] sm:text-6xl">Cars worth a closer look.</h2>
                </div>
                <Link href="/inventory" class="text-xs font-black uppercase tracking-[0.12em] underline decoration-[#ff4f38] decoration-2 underline-offset-8">View full inventory</Link>
            </div>

            <div v-if="featuredVehicles.length" class="mt-10 grid gap-x-6 gap-y-10 md:grid-cols-2 xl:grid-cols-3">
                <Link
                    v-for="(vehicle, index) in featuredVehicles.slice(0, 6)"
                    :key="vehicle.id"
                    :href="`/inventory/${vehicle.slug}`"
                    class="group"
                >
                    <div class="relative aspect-[4/3] overflow-hidden bg-[#e5e1d8]">
                        <img v-if="vehicle.image_medium || vehicle.image_thumb" :src="vehicle.image_medium || vehicle.image_thumb" :alt="vehicle.name" class="h-full w-full object-cover transition duration-700 group-hover:scale-[1.035]">
                        <div v-else class="flex h-full items-center justify-center text-xs font-black uppercase tracking-widest text-stone-400">Photo coming soon</div>
                        <span class="absolute left-4 top-4 rounded-full bg-white/95 px-3 py-1.5 text-[9px] font-black uppercase tracking-[0.14em] text-black">{{ index === 0 ? 'Featured' : 'Available' }}</span>
                    </div>
                    <div class="flex items-start justify-between gap-5 border-b border-black/10 py-5">
                        <div>
                            <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-stone-500">{{ vehicle.year }} · {{ vehicle.make }}</p>
                            <h3 class="mt-2 text-xl font-black tracking-[-0.03em] transition group-hover:text-[#e9422c]">{{ vehicle.name }}</h3>
                            <p class="mt-2 text-sm text-stone-500">{{ vehicle.mileage }}</p>
                        </div>
                        <p class="shrink-0 text-lg font-black">{{ vehicle.price }}</p>
                    </div>
                </Link>
            </div>

            <div v-else class="mt-10 border border-dashed border-black/20 p-12 text-center">
                <h3 class="text-2xl font-black">Inventory is being updated.</h3>
                <p class="mt-3 text-stone-500">Call us for the latest vehicles available on the lot.</p>
            </div>
        </div>
    </section>

    <section class="overflow-hidden bg-[#ff4f38] text-white">
        <div class="site-container grid lg:grid-cols-2">
            <div class="border-white/20 py-20 lg:border-r lg:py-28 lg:pr-16">
                <p class="text-[10px] font-black uppercase tracking-[0.25em] text-white/65">Financing</p>
                <h2 class="mt-5 max-w-xl text-5xl font-black leading-[0.92] tracking-[-0.06em] sm:text-6xl">A better car can start with one simple form.</h2>
                <p class="mt-7 max-w-lg text-base leading-7 text-white/80">Tell us what you are looking for and share the basics. Our team will follow up to discuss available financing paths.</p>
                <Link href="/finance" class="mt-9 inline-flex rounded-full bg-[#171717] px-7 py-4 text-xs font-black uppercase tracking-wide text-white">Start financing request</Link>
            </div>

            <div class="py-20 lg:py-28 lg:pl-16">
                <p class="text-[10px] font-black uppercase tracking-[0.25em] text-white/65">Have a vehicle?</p>
                <h2 class="mt-5 max-w-xl text-5xl font-black leading-[0.92] tracking-[-0.06em] sm:text-6xl">Trade it in. Move forward.</h2>
                <p class="mt-7 max-w-lg text-base leading-7 text-white/80">Send us your current vehicle details, mileage, and condition. We will review the information and get back to you.</p>
                <Link href="/trade-in" class="mt-9 inline-flex rounded-full border border-white/50 px-7 py-4 text-xs font-black uppercase tracking-wide text-white transition hover:bg-white hover:text-black">Tell us about your trade</Link>
            </div>
        </div>
    </section>

    <section class="bg-[#f5f3ee] py-20 lg:py-28">
        <div class="site-container grid gap-12 lg:grid-cols-[0.8fr_1.2fr]">
            <div>
                <p class="text-[10px] font-black uppercase tracking-[0.25em] text-[#e9422c]">How it works</p>
                <h2 class="mt-5 text-5xl font-black leading-[0.92] tracking-[-0.06em] sm:text-6xl">No maze.<br>No mystery.</h2>
                <p class="mt-7 max-w-md text-base leading-7 text-stone-600">A clear path from browsing online to seeing the vehicle in person.</p>
            </div>
            <div class="divide-y divide-black/15 border-y border-black/15">
                <article v-for="item in process" :key="item.number" class="grid gap-4 py-8 sm:grid-cols-[70px_1fr]">
                    <p class="text-xs font-black text-[#e9422c]">{{ item.number }}</p>
                    <div>
                        <h3 class="text-2xl font-black tracking-[-0.035em]">{{ item.title }}</h3>
                        <p class="mt-3 max-w-xl text-sm leading-6 text-stone-600">{{ item.text }}</p>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <section v-if="reviews.length" class="bg-white py-20 lg:py-24">
        <div class="site-container">
            <div class="grid gap-8 lg:grid-cols-[0.65fr_1.35fr]">
                <div>
                    <p class="text-[10px] font-black uppercase tracking-[0.25em] text-[#e9422c]">Customer feedback</p>
                    <h2 class="mt-4 text-4xl font-black tracking-[-0.05em]">From people who stopped by.</h2>
                </div>
                <div class="grid gap-5 md:grid-cols-2">
                    <article v-for="review in reviews.slice(0, 4)" :key="review.id" class="border border-black/10 p-7">
                        <p class="text-sm tracking-[0.2em] text-[#ff4f38]">★★★★★</p>
                        <p class="mt-5 text-base leading-7 text-stone-700">“{{ review.text }}”</p>
                        <p class="mt-6 text-xs font-black uppercase tracking-[0.15em]">{{ review.author_name }}</p>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-[#252525] text-white">
        <div class="site-container grid lg:grid-cols-[1fr_1fr]">
            <div class="py-20 lg:py-24 lg:pr-16">
                <p class="text-[10px] font-black uppercase tracking-[0.25em] text-[#ff5a45]">Come see us</p>
                <h2 class="mt-5 text-5xl font-black leading-[0.95] tracking-[-0.06em]">Right here in<br>East Granby.</h2>
                <a :href="site.maps_url" target="_blank" rel="noopener" class="mt-8 block max-w-sm text-lg font-bold leading-7">{{ site.address }}</a>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a :href="site.maps_url" target="_blank" rel="noopener" class="rounded-full bg-white px-6 py-3 text-xs font-black uppercase tracking-wide text-black">Get directions</a>
                    <a :href="`tel:${site.phone_tel}`" class="rounded-full border border-white/25 px-6 py-3 text-xs font-black uppercase tracking-wide">Call first</a>
                </div>
            </div>
            <div class="min-h-[420px] bg-stone-800">
                <iframe :src="site.maps_embed_url" title="Cars For Less location" class="h-full min-h-[420px] w-full border-0 grayscale" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>
</template>
