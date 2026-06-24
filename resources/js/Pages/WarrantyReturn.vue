<script setup>
import {Link} from '@inertiajs/vue3';
import SiteLayout from '@/Layouts/SiteLayout.vue';

defineOptions({
    layout: SiteLayout,
});

const warrantyItems = [
    {
        label: 'Coverage period',
        value: '90 days / 5,000 miles',
        text: 'Selected components may be covered for 90 days or 5,000 miles, whichever comes first.',
    },
    {
        label: 'Return window',
        value: '14 days',
        text: 'Eligible vehicles may be returned within the stated return period according to written return terms.',
    },
    {
        label: 'Refund handling',
        value: 'Full refund terms',
        text: 'Refund details, deductions, transport costs, and conditions are confirmed before purchase.',
    },
];

const exclusions = [
    'Damage caused after delivery or customer possession.',
    'Wear items, maintenance items, cosmetic imperfections, and consumables unless stated in writing.',
    'Vehicles modified, abused, misused, raced, or used outside normal road conditions.',
    'Issues not reported within the warranty or return period.',
];

const returnSteps = [
    {
        number: '01',
        title: 'Contact sales',
        text: 'Notify our team within the eligible return window and provide vehicle details.',
    },
    {
        number: '02',
        title: 'Review eligibility',
        text: 'Our team reviews purchase terms, vehicle condition, mileage, delivery status, and return requirements.',
    },
    {
        number: '03',
        title: 'Confirm logistics',
        text: 'Return transportation, inspection, refund timing, and any applicable costs are confirmed in writing.',
    },
    {
        number: '04',
        title: 'Complete return',
        text: 'After the vehicle is received and inspected, the refund process is completed according to the agreed terms.',
    },
];
</script>

<template>
    <section class="border-b border-white/10 bg-[#080b0f]">
        <div class="site-container py-10">
            <div class="grid gap-8 lg:grid-cols-[1fr_460px] lg:items-end">
                <div>
                    <p class="eyebrow">
                        Warranty & Return
                    </p>

                    <h1 class="mt-3 heading-lg">
                        Clear warranty and return terms before you buy.
                    </h1>

                    <p class="mt-5 max-w-3xl body-muted">
                        We provide written warranty and return information so buyers understand coverage,
                        eligibility, timing, exclusions, and next steps before completing a purchase.
                    </p>
                </div>

                <div class="grid grid-cols-2 border border-white/10 bg-white/[0.035]">
                    <div class="p-6">
                        <p class="text-xs font-black uppercase tracking-[0.24em] text-slate-500">
                            Warranty
                        </p>

                        <p class="mt-2 text-4xl font-black text-amber-300">
                            90
                        </p>

                        <p class="mt-1 text-sm text-slate-400">
                            days / 5,000 miles
                        </p>
                    </div>

                    <div class="border-l border-white/10 p-6">
                        <p class="text-xs font-black uppercase tracking-[0.24em] text-slate-500">
                            Return
                        </p>

                        <p class="mt-2 text-4xl font-black text-amber-300">
                            14
                        </p>

                        <p class="mt-1 text-sm text-slate-400">
                            day return window
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
                        Coverage Summary
                    </p>

                    <h2 class="mt-3 heading-lg">
                        Key buyer protection points.
                    </h2>
                </div>

                <p class="max-w-xl body-muted">
                    Final terms depend on the specific vehicle, purchase agreement, buyer location, delivery status,
                    and written documentation.
                </p>
            </div>

            <div class="grid gap-5 lg:grid-cols-3">
                <article
                    v-for="item in warrantyItems"
                    :key="item.label"
                    class="dealer-card p-6"
                >
                    <p class="text-xs font-black uppercase tracking-[0.24em] text-slate-500">
                        {{ item.label }}
                    </p>

                    <h3 class="mt-4 text-3xl font-black text-amber-300">
                        {{ item.value }}
                    </h3>

                    <p class="mt-5 text-sm leading-6 text-slate-400">
                        {{ item.text }}
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
                        Warranty Details
                    </p>

                    <h2 class="mt-3 heading-lg">
                        What the warranty is designed to cover.
                    </h2>

                    <p class="mt-5 body-muted">
                        Warranty coverage is intended to provide confidence on selected components for eligible
                        vehicles. Specific coverage should always be reviewed in the final written terms.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-4">
                        <Link href="/inventory" class="btn-primary">
                            Browse Vehicles
                        </Link>

                        <Link href="/contact" class="btn-secondary">
                            Ask About Coverage
                        </Link>
                    </div>
                </div>

                <div class="dealer-panel rounded-2xl">
                    <div class="border-b border-white/10 px-6 py-5">
                        <h3 class="text-sm font-black uppercase tracking-[0.24em]">
                            Coverage checklist
                        </h3>
                    </div>

                    <div class="divide-y divide-white/10">
                        <div class="grid gap-3 px-6 py-5 md:grid-cols-[220px_1fr]">
                            <p class="font-black">
                                Eligible vehicles
                            </p>

                            <p class="text-sm leading-6 text-slate-400">
                                Warranty terms apply only to eligible vehicles and should be confirmed before purchase.
                            </p>
                        </div>

                        <div class="grid gap-3 px-6 py-5 md:grid-cols-[220px_1fr]">
                            <p class="font-black">
                                Selected components
                            </p>

                            <p class="text-sm leading-6 text-slate-400">
                                Covered components and exclusions are defined in the written warranty terms.
                            </p>
                        </div>

                        <div class="grid gap-3 px-6 py-5 md:grid-cols-[220px_1fr]">
                            <p class="font-black">
                                Claim timing
                            </p>

                            <p class="text-sm leading-6 text-slate-400">
                                Any issue should be reported within the warranty period as soon as it is discovered.
                            </p>
                        </div>

                        <div class="grid gap-3 px-6 py-5 md:grid-cols-[220px_1fr]">
                            <p class="font-black">
                                Verification
                            </p>

                            <p class="text-sm leading-6 text-slate-400">
                                Claims may require inspection, documentation, mileage confirmation, and purchase review.
                            </p>
                        </div>
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
                        Return Process
                    </p>

                    <h2 class="mt-3 heading-lg">
                        How return requests are handled.
                    </h2>
                </div>

                <p class="max-w-xl body-muted">
                    Return eligibility and refund timing depend on purchase terms, vehicle condition, mileage,
                    transport status, and written return documentation.
                </p>
            </div>

            <div class="border border-white/10 bg-white/[0.025]">
                <article
                    v-for="step in returnSteps"
                    :key="step.number"
                    class="grid gap-5 border-b border-white/10 p-6 last:border-b-0 lg:grid-cols-[140px_1fr]"
                >
                    <p class="text-4xl font-black text-amber-300">
                        {{ step.number }}
                    </p>

                    <div>
                        <h3 class="text-2xl font-black">
                            {{ step.title }}
                        </h3>

                        <p class="mt-3 max-w-3xl text-sm leading-6 text-slate-400">
                            {{ step.text }}
                        </p>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <section class="site-section-tight border-y border-white/10 bg-[#080b0f]">
        <div class="site-container">
            <div class="grid gap-8 lg:grid-cols-[0.9fr_1.1fr]">
                <div>
                    <p class="eyebrow">
                        Important Exclusions
                    </p>

                    <h2 class="mt-3 heading-lg">
                        What may not be covered.
                    </h2>

                    <p class="mt-5 body-muted">
                        This page is a summary. Final exclusions, limitations, and return conditions must be confirmed
                        in the written purchase and warranty documents.
                    </p>
                </div>

                <div class="dealer-panel rounded-2xl">
                    <div
                        v-for="exclusion in exclusions"
                        :key="exclusion"
                        class="border-b border-white/10 px-6 py-5 last:border-b-0"
                    >
                        <p class="text-sm leading-6 text-slate-300">
                            {{ exclusion }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="site-section">
        <div class="site-container">
            <div class="border border-amber-300/30 bg-amber-300/[0.08] p-8 lg:p-10">
                <div class="grid gap-8 lg:grid-cols-[1fr_auto] lg:items-center">
                    <div>
                        <p class="eyebrow">
                            Before Purchase
                        </p>

                        <h2 class="mt-3 text-3xl font-black lg:text-4xl">
                            Ask our team to confirm warranty and return terms for a specific vehicle.
                        </h2>

                        <p class="mt-5 max-w-3xl text-sm leading-6 text-slate-300">
                            Warranty and return terms may vary. Always request the final written details before
                            completing payment or arranging delivery.
                        </p>
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row lg:flex-col">
                        <Link href="/contact" class="btn-primary">
                            Contact Sales
                        </Link>

                        <Link href="/inventory" class="btn-secondary">
                            View Inventory
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
