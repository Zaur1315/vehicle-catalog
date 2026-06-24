<script setup>
import {Link, Head} from '@inertiajs/vue3';
import SiteLayout from '@/Layouts/SiteLayout.vue';

defineOptions({
    layout: SiteLayout,
});

const steps = [
    {
        number: '01',
        title: 'Vehicle selection',
        text: 'Choose a vehicle from current inventory and confirm availability, price, delivery location, and purchase terms.',
    },
    {
        number: '02',
        title: 'Documents and payment',
        text: 'Our team prepares the required documents and confirms payment instructions before transportation begins.',
    },
    {
        number: '03',
        title: 'Enclosed trailer loading',
        text: 'The vehicle is loaded into an enclosed auto transport trailer for additional protection during transit.',
    },
    {
        number: '04',
        title: 'Insured transportation',
        text: 'Transportation is covered by insurance and typically takes 7–14 business days after payment confirmation.',
    },
    {
        number: '05',
        title: 'Customer delivery',
        text: 'The vehicle is delivered to the customer at the agreed destination, subject to route and carrier access.',
    },
];
</script>

<template>
    <Head title="Delivery"/>

    <section class="border-b border-white/10 bg-[#080b0f]">
        <div class="site-container py-10">
            <div class="grid gap-8 lg:grid-cols-[1fr_420px] lg:items-end">
                <div>
                    <p class="eyebrow">
                        Delivery
                    </p>

                    <h1 class="mt-3 heading-lg">
                        Enclosed vehicle delivery with insured transportation.
                    </h1>

                    <p class="mt-5 max-w-3xl body-muted">
                        We help out-of-state buyers receive their vehicle through a clear delivery process using
                        enclosed auto transport and insured carrier coverage.
                    </p>
                </div>

                <div class="border border-white/10 bg-white/[0.035] p-5">
                    <p class="text-xs font-black uppercase tracking-[0.24em] text-slate-500">
                        Estimated Transit
                    </p>

                    <p class="mt-2 text-4xl font-black text-amber-300">
                        7–14
                    </p>

                    <p class="mt-1 text-sm text-slate-400">
                        business days from payment confirmation
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="site-section">
        <div class="site-container">
            <div class="section-header">
                <div>
                    <p class="eyebrow">
                        Delivery Process
                    </p>

                    <h2 class="mt-3 heading-lg">
                        From vehicle selection to final delivery.
                    </h2>
                </div>

                <p class="max-w-xl body-muted">
                    The process is designed to give buyers clear expectations before the vehicle leaves the dealership.
                </p>
            </div>

            <div class="border border-white/10 bg-white/[0.025]">
                <article
                    v-for="(step, index) in steps"
                    :key="step.number"
                    class="grid gap-5 border-b border-white/10 p-6 last:border-b-0 lg:grid-cols-[140px_1fr_280px]"
                >
                    <div>
                        <p class="text-4xl font-black text-amber-300">
                            {{ step.number }}
                        </p>
                    </div>

                    <div>
                        <h3 class="text-2xl font-black">
                            {{ step.title }}
                        </h3>

                        <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-400">
                            {{ step.text }}
                        </p>
                    </div>

                    <div class="flex items-center lg:justify-end">
                        <p class="border border-white/10 px-4 py-3 text-xs font-bold uppercase tracking-wide text-slate-400">
                            Step {{ index + 1 }} of {{ steps.length }}
                        </p>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <section class="site-section-tight border-y border-white/10 bg-white/[0.025]">
        <div class="site-container">
            <div class="grid gap-8 lg:grid-cols-3">
                <article class="border-l border-amber-300/50 pl-6">
                    <p class="text-xs font-black uppercase tracking-[0.24em] text-slate-500">
                        Carrier Type
                    </p>

                    <h3 class="mt-3 text-2xl font-black">
                        Enclosed trailer
                    </h3>

                    <p class="mt-4 text-sm leading-6 text-slate-400">
                        Vehicles are transported inside an enclosed auto carrier to reduce exposure to road debris,
                        weather, and open-road conditions.
                    </p>
                </article>

                <article class="border-l border-amber-300/50 pl-6">
                    <p class="text-xs font-black uppercase tracking-[0.24em] text-slate-500">
                        Protection
                    </p>

                    <h3 class="mt-3 text-2xl font-black">
                        Insured cargo
                    </h3>

                    <p class="mt-4 text-sm leading-6 text-slate-400">
                        Transportation is handled with carrier insurance coverage. Final coverage terms are confirmed
                        during delivery arrangement.
                    </p>
                </article>

                <article class="border-l border-amber-300/50 pl-6">
                    <p class="text-xs font-black uppercase tracking-[0.24em] text-slate-500">
                        Timeline
                    </p>

                    <h3 class="mt-3 text-2xl font-black">
                        7–14 business days
                    </h3>

                    <p class="mt-4 text-sm leading-6 text-slate-400">
                        Delivery timing may vary by route, carrier schedule, weather, location access, and documentation
                        completion.
                    </p>
                </article>
            </div>
        </div>
    </section>

    <section class="site-section">
        <div class="site-container">
            <div class="grid gap-8 lg:grid-cols-[0.9fr_1.1fr]">
                <div>
                    <p class="eyebrow">
                        Delivery Confirmation
                    </p>

                    <h2 class="mt-3 heading-lg">
                        What buyers should confirm before transport.
                    </h2>

                    <p class="mt-5 body-muted">
                        Before the vehicle is released to the carrier, our team confirms the delivery destination,
                        payment status, documents, and written delivery terms.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-4">
                        <Link href="/inventory" class="btn-primary">
                            Browse Inventory
                        </Link>

                        <Link href="/contact" class="btn-secondary">
                            Ask About Delivery
                        </Link>
                    </div>
                </div>

                <div class="dealer-panel rounded-2xl">
                    <div class="border-b border-white/10 px-6 py-5">
                        <h3 class="text-sm font-black uppercase tracking-[0.24em]">
                            Buyer checklist
                        </h3>
                    </div>

                    <div class="divide-y divide-white/10">
                        <div class="grid gap-3 px-6 py-5 md:grid-cols-[220px_1fr]">
                            <p class="font-black">
                                Destination
                            </p>

                            <p class="text-sm leading-6 text-slate-400">
                                Confirm exact delivery address and whether the carrier can safely access the location.
                            </p>
                        </div>

                        <div class="grid gap-3 px-6 py-5 md:grid-cols-[220px_1fr]">
                            <p class="font-black">
                                Documents
                            </p>

                            <p class="text-sm leading-6 text-slate-400">
                                Confirm that all required purchase and delivery documents are completed before pickup.
                            </p>
                        </div>

                        <div class="grid gap-3 px-6 py-5 md:grid-cols-[220px_1fr]">
                            <p class="font-black">
                                Insurance
                            </p>

                            <p class="text-sm leading-6 text-slate-400">
                                Confirm transportation coverage and ask any questions before the vehicle leaves.
                            </p>
                        </div>

                        <div class="grid gap-3 px-6 py-5 md:grid-cols-[220px_1fr]">
                            <p class="font-black">
                                Timing
                            </p>

                            <p class="text-sm leading-6 text-slate-400">
                                Delivery estimates are provided in business days and may depend on the carrier route.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
