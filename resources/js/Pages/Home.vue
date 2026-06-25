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

defineProps({
    featuredVehicles: {
        type: Array,
        default: () => [],
    },
    reviews: {
        type: Array,
        default: () => [],
    },
});

const homeSchema = {
    '@context': 'https://schema.org',
    '@type': 'AutoDealer',
    name: site.name,
    description: 'Vehicle dealership offering inspected vehicle inventory, delivery, warranty, finance, and trade-in options.',
    telephone: site.phone_tel,
    email: site.email,
    url: typeof window !== 'undefined' ? window.location.origin : '',
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
};
</script>

<template>
    <SeoHead
        :title=site.name
        description="Browse inspected vehicles, request information, and contact our sales team for delivery, warranty, finance, and trade-in options."
        :schema="homeSchema"
    />

    <section class="relative overflow-hidden border-b border-white/10">
        <div
            class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(251,191,36,0.16),transparent_34%),linear-gradient(135deg,#0b0f14_0%,#111827_52%,#05070a_100%)]"/>

        <div class="site-container relative grid min-h-[720px] items-center gap-12 py-16 lg:grid-cols-[0.95fr_1.05fr]">
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
                    <Link href="/inventory" class="btn-primary">
                        Browse Inventory
                    </Link>

                    <Link href="/finance" class="btn-secondary">
                        Finance Options
                    </Link>
                </div>
            </div>

            <div class="lg:pl-8">
                <div class="dealer-panel relative overflow-hidden rounded-2xl">
                    <div class="border-b border-white/10 px-6 py-5">
                        <p class="text-xs font-black uppercase tracking-[0.28em] text-slate-400">
                            Featured vehicles
                        </p>
                    </div>

                    <div class="divide-y divide-white/10">
                        <Link
                            v-for="vehicle in featuredVehicles.slice(0, 3)"
                            :key="vehicle.id"
                            :href="`/inventory/${vehicle.slug}`"
                            class="grid gap-4 px-6 py-5 transition hover:bg-white/[0.04] sm:grid-cols-[96px_1fr_auto]"
                        >
                            <div class="overflow-hidden rounded-xl border border-white/10 bg-black/30">
                                <img
                                    v-if="vehicle.image_thumb"
                                    :src="vehicle.image_thumb"
                                    :alt="vehicle.name"
                                    class="h-24 w-full object-cover transition duration-500 hover:scale-105"
                                >

                                <div
                                    v-else
                                    class="flex h-24 items-center justify-center bg-white/[0.03] text-xs font-bold uppercase tracking-wide text-slate-600"
                                >
                                    No Photo
                                </div>
                            </div>

                            <div>
                                <p class="text-sm text-slate-400">
                                    {{ vehicle.year }} · {{ vehicle.make }} {{ vehicle.model }}
                                </p>

                                <h3 class="mt-1 text-xl font-black">
                                    {{ vehicle.name }}
                                </h3>

                                <p class="mt-2 text-sm text-slate-500">
                                    {{ vehicle.mileage }}
                                </p>
                            </div>

                            <div class="sm:text-right">
                                <p class="text-xl font-black text-amber-300">
                                    {{ vehicle.price }}
                                </p>

                                <p class="mt-2 text-xs font-bold uppercase tracking-wide text-slate-500">
                                    View details
                                </p>
                            </div>
                        </Link>

                        <div
                            v-if="featuredVehicles.length === 0"
                            class="px-6 py-10 text-slate-400"
                        >
                            Featured vehicles will appear here after inventory is added.
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

    <section class="site-section">
        <div class="site-container">
            <div class="section-header">
                <div>
                    <p class="eyebrow">
                        Why buyers choose us
                    </p>

                    <h2 class="mt-3 heading-lg">
                        Built for out-of-state confidence.
                    </h2>
                </div>

                <p class="max-w-xl body-muted">
                    We focus on clear vehicle information, written terms, insured transportation, and responsive
                    communication from the first inquiry to delivery.
                </p>
            </div>

            <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-4">
                <article class="dealer-card p-6">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl border border-amber-300/40 bg-amber-300/10 text-xl text-amber-300">
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
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl border border-amber-300/40 bg-amber-300/10 text-xl text-amber-300">
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
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl border border-amber-300/40 bg-amber-300/10 text-xl text-amber-300">
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
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl border border-amber-300/40 bg-amber-300/10 text-xl text-amber-300">
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
    <section class="site-section-tight border-y border-white/10 bg-white/[0.025]">
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
                    We display Google Business reviews with a rating of 4 stars and higher.
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
    <section class="site-section">
        <div class="site-container">
            <div class="grid gap-6 lg:grid-cols-[0.9fr_1.1fr] lg:items-center">
                <div>
                    <p class="eyebrow">
                        Next step
                    </p>

                    <h2 class="mt-3 heading-lg">
                        Ready to compare available vehicles?
                    </h2>
                </div>

                <div class="flex flex-col gap-4 sm:flex-row lg:justify-end">
                    <Link href="/inventory" class="btn-primary">
                        Open Inventory
                    </Link>

                    <Link href="/contact" class="btn-secondary">
                        Speak With Sales
                    </Link>
                </div>
            </div>
        </div>
    </section>
</template>
