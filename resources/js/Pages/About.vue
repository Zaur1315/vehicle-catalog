<script setup>
import {Link} from '@inertiajs/vue3';
import SeoHead from '@/Components/SeoHead.vue';
import SiteLayout from '@/Layouts/SiteLayout.vue';

defineOptions({
    layout: SiteLayout,
});

const principles = [
    {
        number: '01',
        title: 'Clear vehicle information',
        text: 'We present mileage, VIN, stock number, photos, features, condition details, and pricing as clearly as possible before a buyer contacts us.',
    },
    {
        number: '02',
        title: 'Buyer-first communication',
        text: 'Our sales process is built around answering questions about availability, delivery, warranty, returns, financing, and trade-in options.',
    },
    {
        number: '03',
        title: 'Out-of-state confidence',
        text: 'We support buyers who need enclosed delivery, remote purchase coordination, and written terms before making a decision.',
    },
];

const process = [
    'Vehicle information is prepared for the inventory page.',
    'Photos, key specifications, mileage, VIN, and stock number are reviewed.',
    'Sales team confirms current availability and purchase terms.',
    'Delivery, warranty, return, finance, and trade-in questions are handled before purchase.',
];
</script>

<template>
    <SeoHead
        title="About"
        description="Learn about our dealership approach, vehicle inventory standards, buyer support, delivery, warranty, finance, and trade-in options."
    />
    <section class="border-b border-white/10 bg-[#080b0f]">
        <div class="site-container py-10">
            <div class="grid gap-8 lg:grid-cols-[1fr_460px] lg:items-end">
                <div>
                    <p class="eyebrow">
                        About
                    </p>

                    <h1 class="mt-3 heading-lg">
                        A vehicle dealership built around clarity and buyer confidence.
                    </h1>

                    <p class="mt-5 max-w-3xl body-muted">
                        We help buyers review available vehicles, ask the right questions, understand purchase terms,
                        and coordinate delivery, warranty, finance, and trade-in options before moving forward.
                    </p>
                </div>

                <div class="grid grid-cols-2 border border-white/10 bg-white/[0.035]">
                    <div class="p-6">
                        <p class="text-xs font-black uppercase tracking-[0.24em] text-slate-500">
                            Focus
                        </p>

                        <p class="mt-2 text-3xl font-black text-amber-300">
                            Auto
                        </p>

                        <p class="mt-1 text-sm text-slate-400">
                            dealer inventory
                        </p>
                    </div>

                    <div class="border-l border-white/10 p-6">
                        <p class="text-xs font-black uppercase tracking-[0.24em] text-slate-500">
                            Support
                        </p>

                        <p class="mt-2 text-3xl font-black text-amber-300">
                            Sales
                        </p>

                        <p class="mt-1 text-sm text-slate-400">
                            delivery and finance
                        </p>
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
                        Dealer Approach
                    </p>

                    <h2 class="mt-3 heading-lg">
                        What makes the buying process simpler.
                    </h2>
                </div>

                <p class="max-w-xl body-muted">
                    The site is designed to reduce back-and-forth by showing useful information before a buyer submits
                    a request.
                </p>
            </div>

            <div class="grid gap-5 lg:grid-cols-3">
                <article
                    v-for="principle in principles"
                    :key="principle.number"
                    class="dealer-card p-6"
                >
                    <p class="text-4xl font-black text-amber-300">
                        {{ principle.number }}
                    </p>

                    <h3 class="mt-6 text-2xl font-black">
                        {{ principle.title }}
                    </h3>

                    <p class="mt-4 text-sm leading-6 text-slate-400">
                        {{ principle.text }}
                    </p>
                </article>
            </div>
        </div>
    </section>

    <section class="site-section-tight border-y border-white/10 bg-white/[0.025]">
        <div class="site-container">
            <div class="grid gap-8 lg:grid-cols-[0.85fr_1.15fr]">
                <div>
                    <p class="eyebrow">
                        Inventory Standards
                    </p>

                    <h2 class="mt-3 heading-lg">
                        Vehicle listings should answer real buyer questions.
                    </h2>

                    <p class="mt-5 body-muted">
                        A good inventory page should not only show photos. It should help buyers understand the vehicle,
                        compare options, and know what to ask before purchase.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-4">
                        <Link href="/inventory" class="btn-primary">
                            View Inventory
                        </Link>

                        <Link href="/contact" class="btn-secondary">
                            Contact Sales
                        </Link>
                    </div>
                </div>

                <div class="dealer-panel rounded-2xl">
                    <div class="border-b border-white/10 px-6 py-5">
                        <p class="text-xs font-black uppercase tracking-[0.24em] text-slate-500">
                            Listing Checklist
                        </p>
                    </div>

                    <div class="divide-y divide-white/10">
                        <div class="grid gap-3 px-6 py-5 md:grid-cols-[220px_1fr]">
                            <p class="font-black">
                                Identification
                            </p>

                            <p class="text-sm leading-6 text-slate-400">
                                VIN, stock number, year, make, model, and trim-level information where available.
                            </p>
                        </div>

                        <div class="grid gap-3 px-6 py-5 md:grid-cols-[220px_1fr]">
                            <p class="font-black">
                                Condition
                            </p>

                            <p class="text-sm leading-6 text-slate-400">
                                Mileage, exterior color, interior color, body type, drivetrain, and transmission.
                            </p>
                        </div>

                        <div class="grid gap-3 px-6 py-5 md:grid-cols-[220px_1fr]">
                            <p class="font-black">
                                Photos
                            </p>

                            <p class="text-sm leading-6 text-slate-400">
                                Main vehicle image and gallery images for closer review before inquiry.
                            </p>
                        </div>

                        <div class="grid gap-3 px-6 py-5 md:grid-cols-[220px_1fr]">
                            <p class="font-black">
                                Buyer options
                            </p>

                            <p class="text-sm leading-6 text-slate-400">
                                Finance, delivery, warranty, return, trade-in, and direct sales contact options.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="site-section">
        <div class="site-container">
            <div class="grid gap-8 lg:grid-cols-[1.1fr_0.9fr]">
                <div class="dealer-panel rounded-2xl p-6 lg:p-8">
                    <p class="eyebrow">
                        Process
                    </p>

                    <h2 class="mt-3 text-3xl font-black lg:text-4xl">
                        How we support a buyer from inventory to delivery.
                    </h2>

                    <div class="mt-8 divide-y divide-white/10">
                        <div
                            v-for="(item, index) in process"
                            :key="item"
                            class="grid gap-4 py-5 first:pt-0 last:pb-0 md:grid-cols-[90px_1fr]"
                        >
                            <p class="text-2xl font-black text-amber-300">
                                {{ String(index + 1).padStart(2, '0') }}
                            </p>

                            <p class="text-sm leading-6 text-slate-300">
                                {{ item }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="space-y-5">
                    <article class="dealer-card p-6">
                        <p class="text-xs font-black uppercase tracking-[0.24em] text-slate-500">
                            Delivery
                        </p>

                        <h3 class="mt-3 text-2xl font-black">
                            Enclosed transport available
                        </h3>

                        <p class="mt-4 text-sm leading-6 text-slate-400">
                            Buyers can ask about insured enclosed transportation and estimated delivery timing.
                        </p>

                        <Link href="/delivery" class="btn-ghost mt-5">
                            Delivery Details →
                        </Link>
                    </article>

                    <article class="dealer-card p-6">
                        <p class="text-xs font-black uppercase tracking-[0.24em] text-slate-500">
                            Warranty
                        </p>

                        <h3 class="mt-3 text-2xl font-black">
                            Coverage and return terms
                        </h3>

                        <p class="mt-4 text-sm leading-6 text-slate-400">
                            Warranty and return pages help buyers understand coverage, limitations, and process.
                        </p>

                        <Link href="/warranty-return" class="btn-ghost mt-5">
                            Warranty Details →
                        </Link>
                    </article>

                    <article class="dealer-card p-6">
                        <p class="text-xs font-black uppercase tracking-[0.24em] text-slate-500">
                            Finance & Trade-In
                        </p>

                        <h3 class="mt-3 text-2xl font-black">
                            Flexible purchase support
                        </h3>

                        <p class="mt-4 text-sm leading-6 text-slate-400">
                            Submit finance and trade-in requests so the team can review your situation before purchase.
                        </p>

                        <div class="mt-5 flex flex-wrap gap-4">
                            <Link href="/finance" class="btn-ghost">
                                Finance →
                            </Link>

                            <Link href="/trade-in" class="btn-ghost">
                                Trade-In →
                            </Link>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <section class="site-section-tight border-y border-white/10 bg-[#080b0f]">
        <div class="site-container">
            <div class="grid gap-8 lg:grid-cols-[1fr_auto] lg:items-center">
                <div>
                    <p class="eyebrow">
                        Start Here
                    </p>

                    <h2 class="mt-3 heading-lg">
                        Find a vehicle and ask our team for the details.
                    </h2>

                    <p class="mt-5 max-w-3xl body-muted">
                        Browse current inventory or contact sales directly if you need help choosing a vehicle.
                    </p>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row">
                    <Link href="/inventory" class="btn-primary">
                        Browse Inventory
                    </Link>

                    <Link href="/contact" class="btn-secondary">
                        Contact Sales
                    </Link>
                </div>
            </div>
        </div>
    </section>
</template>
