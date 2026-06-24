<script setup>
import {Link, Head} from '@inertiajs/vue3';
import SiteLayout from '@/Layouts/SiteLayout.vue';

defineOptions({
    layout: SiteLayout,
});

defineProps({
    featuredVehicles: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <Head title="Home"/>

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
                            v-for="vehicle in featuredVehicles.slice(0, 4)"
                            :key="vehicle.id"
                            :href="`/inventory/${vehicle.slug}`"
                            class="grid gap-4 px-6 py-5 transition hover:bg-white/[0.04] sm:grid-cols-[1fr_auto]"
                        >
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
                    <span class="text-3xl font-black text-amber-300">01</span>
                    <h3 class="mt-6 text-xl font-black">Inspected inventory</h3>
                    <p class="mt-3 text-sm leading-6 text-slate-400">
                        Vehicle details, mileage, VIN, condition, and features are presented clearly.
                    </p>
                </article>

                <article class="dealer-card p-6">
                    <span class="text-3xl font-black text-amber-300">02</span>
                    <h3 class="mt-6 text-xl font-black">Enclosed delivery</h3>
                    <p class="mt-3 text-sm leading-6 text-slate-400">
                        Cars are transported in an enclosed trailer with insured coverage.
                    </p>
                </article>

                <article class="dealer-card p-6">
                    <span class="text-3xl font-black text-amber-300">03</span>
                    <h3 class="mt-6 text-xl font-black">Warranty terms</h3>
                    <p class="mt-3 text-sm leading-6 text-slate-400">
                        Warranty and return rules are explained before the purchase process.
                    </p>
                </article>

                <article class="dealer-card p-6">
                    <span class="text-3xl font-black text-amber-300">04</span>
                    <h3 class="mt-6 text-xl font-black">Sales support</h3>
                    <p class="mt-3 text-sm leading-6 text-slate-400">
                        Contact our team for availability, finance, trade-in, and delivery questions.
                    </p>
                </article>
            </div>
        </div>
    </section>

    <section class="site-section-tight border-y border-white/10 bg-white/[0.025]">
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
