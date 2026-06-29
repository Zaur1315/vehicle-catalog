<script setup>
import {Link, usePage} from '@inertiajs/vue3';
import SiteLayout from '@/Layouts/SiteLayout.vue';
import SeoHead from "@/Components/SeoHead.vue";
import {computed} from "vue";

const page = usePage();

const site = computed(() => page.props.site || {});

defineOptions({
    layout: SiteLayout,
});

const props = defineProps({
    featuredVehicles: {
        type: Array,
        default: () => [],
    },
    reviews: {
        type: Array,
        default: () => [],
    },
});

const heroVehicle = computed(() => props.featuredVehicles[0] || null);

const homeSchema = computed(() => ({
    '@context': 'https://schema.org',
    '@type': 'AutoDealer',
    name: site.value.name || 'Marick Auto Sales',
    description: 'Vehicle dealership offering inspected vehicle inventory, delivery, warranty, finance, and trade-in options.',
    telephone: site.value.phone_tel || '+12036302886',
    email: site.value.email || 'sales@marickautosales.com',
    url: typeof window !== 'undefined' ? window.location.origin : '',
    address: {
        '@type': 'PostalAddress',
        streetAddress: '197 Pratt St',
        addressLocality: site.value.city || 'Meriden',
        addressRegion: site.value.state || 'CT',
        postalCode: site.value.zip || '06450',
        addressCountry: site.value.country || 'USA',
    },
    openingHoursSpecification: [
        {
            '@type': 'OpeningHoursSpecification',
            dayOfWeek: [
                'Monday',
                'Tuesday',
                'Wednesday',
                'Thursday',
                'Friday',
            ],
            opens: '09:00',
            closes: '17:00',
        },
    ],
}));

const uspItems = [
    {
        title: 'Inspected vehicle inventory',
        text: 'Review mileage, VIN, stock number, photos, pricing, and vehicle details before contacting sales.',
    },
    {
        title: 'Remote buyer support',
        text: 'Ask about delivery, warranty, return terms, finance, and trade-in options before moving forward.',
    },
    {
        title: 'Meriden, CT dealership',
        text: 'Marick Auto Sales helps local and out-of-state buyers compare vehicles with clear next steps.',
    },
];

const buyingSteps = [
    {
        number: '01',
        title: 'Choose a vehicle',
        text: 'Browse inventory and open a vehicle page to review photos, specs, mileage, price, and features.',
    },
    {
        number: '02',
        title: 'Send an inquiry',
        text: 'Contact sales from the vehicle page or use the contact form for availability and purchase questions.',
    },
    {
        number: '03',
        title: 'Confirm the terms',
        text: 'Review pricing, warranty, delivery, return, finance, and trade-in details before purchase.',
    },
    {
        number: '04',
        title: 'Pickup or delivery',
        text: 'Coordinate local pickup or ask about enclosed delivery options for out-of-state buyers.',
    },
];

</script>

<template>
    <SeoHead
        :title=site.name
        description="Browse inspected vehicles, request information, and contact our sales team for delivery, warranty, finance, and trade-in options."
        :schema="homeSchema"
    />

    <section class="relative overflow-hidden  border-white/10">
        <div
            class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(251,191,36,0.16),transparent_34%),linear-gradient(135deg,#0b0f14_0%,#111827_52%,#05070a_100%)]"/>

        <div class="site-container relative grid padd-top padd-bottom min-h-[720px] items-center gap-12 py-16 lg:grid-cols-[0.95fr_1.05fr]">
            <div>
                <p class="eyebrow">
                    Trusted Auto Dealer
                </p>

                <h1 class="mt-5 heading-xl">
                    Inspected vehicles. Clear terms. Straightforward delivery.
                </h1>

                <p class="mt-7 max-w-2xl text-lg leading-8 text-slate-300">
                    Browse available vehicles, request information, review warranty coverage, and get help with
                    enclosed delivery, financing, and trade-in options.
                </p>

                <div class="mt-10 flex flex-wrap gap-4">
                    <a href="tel:+12036302886" class="btn-primary">
                        Call us now
                    </a>

                    <Link href="/inventory" class="btn-secondary">
                        Browse Inventory
                    </Link>
                </div>
            </div>

            <div class="lg:pl-8">
                <div class="dealer-panel overflow-hidden rounded-2xl">
                    <div class="relative bg-black">
                        <img
                            v-if="heroVehicle?.image_medium"
                            :src="heroVehicle.image_medium"
                            :alt="heroVehicle.name"
                            class="h-[320px] w-full object-cover lg:h-[360px]"
                        >

                        <div
                            v-else
                            class="flex h-[320px] items-center justify-center bg-gradient-to-br from-slate-900 to-black text-slate-600 lg:h-[360px]"
                        >
                            Vehicle photo will appear here
                        </div>

                        <div
                            class="absolute left-5 top-5 rounded-xl bg-black/70 px-4 py-2 text-xs font-black uppercase tracking-wide text-white backdrop-blur">
                            hot offer
                        </div>
                    </div>

                    <div
                        v-if="heroVehicle"
                        class="grid gap-4 border-t border-white/10 bg-[#080b0f] p-5 sm:grid-cols-[1fr_auto]"
                    >
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.2em] text-slate-500">
                                Featured vehicle
                            </p>

                            <h3 class="mt-2 text-2xl font-black">
                                {{ heroVehicle.name }}
                            </h3>

                            <p class="mt-2 text-sm text-slate-400">
                                {{ heroVehicle.year }} · {{ heroVehicle.make }} {{ heroVehicle.model }} ·
                                {{ heroVehicle.mileage }}
                            </p>
                        </div>

                        <div class="sm:text-right">
                            <p class="text-2xl font-black text-amber-300">
                                {{ heroVehicle.price }}
                            </p>

                            <Link
                                :href="`/inventory/${heroVehicle.slug}`"
                                class="btn-ghost mt-3"
                            >
                                View Details →
                            </Link>
                        </div>
                    </div>
                </div>

                <div class="mt-5 grid grid-cols-3 border border-white/10 bg-black/20">
                    <div class="stat-tile">
                        <p class="text-3xl font-black text-white">90</p>
                        <p class="mt-1 text-xs uppercase tracking-wide text-slate-500">Day warranty</p>
                    </div>

                    <div class="stat-tile">
                        <p class="text-3xl font-black text-white">14</p>
                        <p class="mt-1 text-xs uppercase tracking-wide text-slate-500">Day return</p>
                    </div>

                    <div class="stat-tile">
                        <p class="text-3xl font-black text-white">7–14</p>
                        <p class="mt-1 text-xs uppercase tracking-wide text-slate-500">Delivery days</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="site-section-tight border-y border-white/10 bg-white/[0.025]">
        <div class="site-container">
            <div class="grid gap-5 lg:grid-cols-3">
                <article
                    v-for="item in uspItems"
                    :key="item.title"
                    class="border-l border-amber-300/50 bg-white/[0.025] p-6"
                >
                    <h2 class="text-2xl font-black">
                        {{ item.title }}
                    </h2>

                    <p class="mt-4 text-sm leading-6 text-slate-400">
                        {{ item.text }}
                    </p>
                </article>
            </div>
        </div>
    </section>

    <section class="site-section">
        <div class="site-container">
            <div class="section-header">
                <div>
                    <p class="eyebrow">
                        Featured Inventory
                    </p>

                    <h2 class="mt-3 heading-lg">
                        Vehicles selected for quick review.
                    </h2>
                </div>

                <Link href="/inventory" class="btn-secondary">
                    View All Vehicles
                </Link>
            </div>

            <div
                v-if="featuredVehicles.length"
                class="grid gap-5 lg:grid-cols-2"
            >
                <Link
                    v-for="vehicle in featuredVehicles.slice(0, 4)"
                    :key="vehicle.id"
                    :href="`/inventory/${vehicle.slug}`"
                    class="group grid overflow-hidden border border-white/10 bg-white/[0.025] transition hover:border-amber-300/40 hover:bg-white/[0.045] sm:grid-cols-[180px_1fr]"
                >
                    <div class="bg-black/30">
                        <img
                            v-if="vehicle.image_thumb"
                            :src="vehicle.image_thumb"
                            :alt="vehicle.name"
                            class="h-48 w-full object-cover transition duration-500 group-hover:scale-[1.04] sm:h-full"
                        >

                        <div
                            v-else
                            class="flex h-48 items-center justify-center bg-white/[0.03] text-xs font-bold uppercase tracking-wide text-slate-600 sm:h-full"
                        >
                            No Photo
                        </div>
                    </div>

                    <div class="flex flex-col justify-between p-5">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.2em] text-slate-500">
                                {{ vehicle.year }} · {{ vehicle.make }} {{ vehicle.model }}
                            </p>

                            <h3 class="mt-2 text-2xl font-black group-hover:text-amber-300">
                                {{ vehicle.name }}
                            </h3>

                            <p class="mt-3 text-sm text-slate-400">
                                {{ vehicle.mileage }}
                            </p>
                        </div>

                        <div class="mt-6 flex items-center justify-between border-t border-white/10 pt-5">
                            <p class="text-2xl font-black text-amber-300">
                                {{ vehicle.price }}
                            </p>

                            <p class="text-xs font-black uppercase tracking-wide text-slate-500">
                                Details →
                            </p>
                        </div>
                    </div>
                </Link>
            </div>

            <div
                v-else
                class="border border-white/10 bg-white/[0.025] p-8 text-center"
            >
                <h3 class="text-2xl font-black">
                    Featured vehicles will appear here soon.
                </h3>

                <p class="mt-3 text-sm text-slate-400">
                    Add vehicles in the admin panel and mark them as featured.
                </p>
            </div>
        </div>
    </section>

    <section class="site-section border-y border-white/10 bg-white/[0.025]">
        <div class="site-container">
            <div class="section-header">
                <div>
                    <p class="eyebrow">
                        Buying Process
                    </p>

                    <h2 class="mt-3 heading-lg">
                        A simple path from inventory to keys.
                    </h2>
                </div>

                <p class="max-w-xl body-muted">
                    Our process is built to help buyers understand vehicle details, confirm terms, and coordinate the next step with sales.
                </p>
            </div>

            <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-4">
                <article
                    v-for="step in buyingSteps"
                    :key="step.number"
                    class="dealer-card p-6"
                >
                    <p class="text-4xl font-black text-amber-300">
                        {{ step.number }}
                    </p>

                    <h3 class="mt-6 text-xl font-black">
                        {{ step.title }}
                    </h3>

                    <p class="mt-3 text-sm leading-6 text-slate-400">
                        {{ step.text }}
                    </p>
                </article>
            </div>
        </div>
    </section>

    <section class="site-section">
        <div class="site-container">
            <div class="section-header">
                <div>
                    <p class="eyebrow">
                        Buyer Confidence
                    </p>

                    <h2 class="mt-3 heading-lg">
                        Support before and after purchase.
                    </h2>
                </div>

                <p class="max-w-xl body-muted">
                    From warranty questions to delivery coordination, our team helps buyers understand the full purchase path.
                </p>
            </div>
            <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-4">
                <article class="dealer-card p-6">
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-xl border border-amber-300/40 bg-amber-300/10 text-xl text-amber-300">
                        ✅
                    </div>

                    <h3 class="mt-6 text-xl font-black">
                        Warranty
                    </h3>

                    <p class="mt-3 text-sm leading-6 text-slate-400">
                        90 days / 5,000 miles warranty coverage on selected components.
                    </p>
                </article>

                <article class="dealer-card p-6">
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-xl border border-amber-300/40 bg-amber-300/10 text-xl text-amber-300">
                        🚚
                    </div>

                    <h3 class="mt-6 text-xl font-black">
                        Delivery
                    </h3>

                    <p class="mt-3 text-sm leading-6 text-slate-400">
                        Enclosed trailer delivery with insured transportation options.
                    </p>
                </article>

                <article class="dealer-card p-6">
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-xl border border-amber-300/40 bg-amber-300/10 text-xl text-amber-300">
                        ↪
                    </div>

                    <h3 class="mt-6 text-xl font-black">
                        Return Policy
                    </h3>

                    <p class="mt-3 text-sm leading-6 text-slate-400">
                        14-day return policy terms explained before purchase confirmation.
                    </p>
                </article>

                <article class="dealer-card p-6">
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-xl border border-amber-300/40 bg-amber-300/10 text-xl text-amber-300">
                        🎧
                    </div>

                    <h3 class="mt-6 text-xl font-black">
                        Support
                    </h3>

                    <p class="mt-3 text-sm leading-6 text-slate-400">
                        Sales support for availability, finance, trade-in, warranty, and delivery questions.
                    </p>
                </article>
            </div>
        </div>
    </section>
    <section class="site-section-tight border-y padd-top padd-bottom border-white/10 bg-white/[0.025]">
        <div class="site-container">
            <div class="section-header">
                <div>
                    <p class="eyebrow">
                        Google Reviews
                    </p>

                    <h2 class="mt-3 heading-lg">
                        What buyers say about us.
                    </h2>
                </div>

                <p class="max-w-xl body-muted">
                    Recent customer feedback from Google Business.
                </p>
            </div>

            <div
                v-if="reviews.length"
                class="grid gap-5 md:grid-cols-2 xl:grid-cols-3"
            >
                <article
                    v-for="review in reviews"
                    :key="review.id"
                    class="dealer-card p-6"
                >
                    <div class="flex items-start gap-4">
                        <a
                            v-if="review.author_url"
                            :href="review.author_url"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="shrink-0"
                        >
                            <img
                                v-if="review.author_photo_url"
                                :src="review.author_photo_url"
                                :alt="review.author_name"
                                class="h-12 w-12 rounded-full object-cover"
                            >

                            <div
                                v-else
                                class="flex h-12 w-12 items-center justify-center rounded-full bg-amber-300 font-black text-neutral-950"
                            >
                                {{ review.author_name.charAt(0) }}
                            </div>
                        </a>

                        <div v-else class="shrink-0">
                            <img
                                v-if="review.author_photo_url"
                                :src="review.author_photo_url"
                                :alt="review.author_name"
                                class="h-12 w-12 rounded-full object-cover"
                            >

                            <div
                                v-else
                                class="flex h-12 w-12 items-center justify-center rounded-full bg-amber-300 font-black text-neutral-950"
                            >
                                {{ review.author_name.charAt(0) }}
                            </div>
                        </div>

                        <div>
                            <a
                                v-if="review.author_url"
                                :href="review.author_url"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="font-black hover:text-amber-300"
                            >
                                {{ review.author_name }}
                            </a>

                            <p v-else class="font-black">
                                {{ review.author_name }}
                            </p>

                            <p class="mt-1 text-xs text-slate-500">
                                {{ review.date }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-5 flex gap-1 text-amber-300">
                    <span
                        v-for="star in review.rating"
                        :key="star"
                    >
                        ★
                    </span>
                    </div>

                    <p class="mt-4 line-clamp-6 text-sm leading-6 text-slate-300">
                        {{ review.text }}
                    </p>
                </article>
            </div>

            <div
                v-else
                class="border border-white/10 bg-white/[0.025] p-8 text-center"
            >
                <h3 class="text-2xl font-black">
                    Google reviews will appear here soon.
                </h3>

                <p class="mt-3 text-sm leading-6 text-slate-400">
                    Reviews are imported from Google Business and filtered to show ratings of 4 stars and higher.
                </p>
            </div>
        </div>
    </section>

    <section class="relative overflow-hidden border-white/10">
        <div
            class="absolute inset-0 bg-cover bg-center bg-no-repeat"
            style="background-image: url('/images/visit-bg.webp'); background-size: cover;"
        />

        <div class="absolute inset-0 bg-[#080b0f]/82" />

        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(251,191,36,0.20),transparent_34%),linear-gradient(90deg,rgba(8,11,15,0.98)_0%,rgba(8,11,15,0.90)_42%,rgba(8,11,15,0.74)_100%)]" />

        <div class="site-container padd-top padd-bottom relative py-20 lg:py-28">
            <div class="grid gap-8 lg:grid-cols-[0.9fr_1.1fr]">
                <div>
                    <p class="eyebrow">
                        Visit Marick Auto Sales
                    </p>

                    <h2 class="mt-3 heading-lg">
                        Located in {{ site.city }}, {{ site.state }}.
                    </h2>

                    <p class="mt-5 max-w-2xl text-base leading-7 text-slate-300">
                        Contact our team before visiting to confirm vehicle availability, current pricing, and appointment options.
                        We are located at {{ site.address }}.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-4">
                        <a
                            :href="site.maps_url"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="btn-primary"
                        >
                            Open Google Maps
                        </a>

                        <Link href="/contact" class="btn-secondary">
                            Contact Us
                        </Link>
                    </div>
                </div>

                <div class="rounded-2xl border border-white/10 bg-[#080b0f]/80 shadow-2xl shadow-black/30 backdrop-blur-md">
                    <div class="border-b border-white/10 px-6 py-5">
                        <p class="text-xs font-black uppercase tracking-[0.24em] text-slate-500">
                            Dealer Information
                        </p>
                    </div>

                    <div class="divide-y divide-white/10">
                        <div class="grid gap-3 px-6 py-5 md:grid-cols-[160px_1fr]">
                            <p class="font-black">
                                Address
                            </p>

                            <a
                                :href="site.maps_url"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="text-sm leading-6 text-slate-300 hover:text-amber-300"
                            >
                                {{ site.address }}
                            </a>
                        </div>

                        <div class="grid gap-3 px-6 py-5 md:grid-cols-[160px_1fr]">
                            <p class="font-black">
                                Phone
                            </p>

                            <a
                                :href="`tel:${site.phone_tel}`"
                                class="text-sm leading-6 text-slate-300 hover:text-amber-300"
                            >
                                {{ site.phone }}
                            </a>
                        </div>

                        <div class="grid gap-3 px-6 py-5 md:grid-cols-[160px_1fr]">
                            <p class="font-black">
                                Email
                            </p>

                            <a
                                :href="`mailto:${site.email}`"
                                class="text-sm leading-6 text-slate-300 hover:text-amber-300"
                            >
                                {{ site.email }}
                            </a>
                        </div>

                        <div class="grid gap-3 px-6 py-5 md:grid-cols-[160px_1fr]">
                            <p class="font-black">
                                Hours
                            </p>

                            <p class="text-sm leading-6 text-slate-300">
                                {{ site.business_hours }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
