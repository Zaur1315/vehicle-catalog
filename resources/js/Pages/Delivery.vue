<script setup>
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import SeoHead from '@/Components/SeoHead.vue';
import SiteLayout from '@/Layouts/SiteLayout.vue';

defineOptions({
    layout: SiteLayout,
});

const selectedGalleryImage = ref(null);

const steps = [
    {
        number: '01',
        icon: '✓',
        title: 'Vehicle selection',
        text: 'Choose a vehicle from current inventory and confirm availability, price, delivery location, and purchase terms.',
    },
    {
        number: '02',
        icon: '▣',
        title: 'Documents and payment',
        text: 'Our team prepares the required documents and confirms payment instructions before transportation begins.',
    },
    {
        number: '03',
        icon: '↥',
        title: 'Enclosed trailer loading',
        text: 'The vehicle is loaded into an enclosed auto transport trailer for additional protection during transit.',
    },
    {
        number: '04',
        icon: '→',
        title: 'Insured transportation',
        text: 'Transportation is covered by insurance and typically takes 7–14 business days after payment confirmation.',
    },
    {
        number: '05',
        icon: '★',
        title: 'Customer delivery',
        text: 'The vehicle is delivered to the customer at the agreed destination, subject to route and carrier access.',
    },
];

const deliveryGallery = [
    {
        src: '/images/delivery/delivery-1.webp',
        title: 'Vehicle loaded to enclosed trailer',
        caption: 'Example of an enclosed trailer loading process before long-distance delivery.',
    },
    {
        src: '/images/delivery/delivery-2.webp',
        title: 'Protected transport setup',
        caption: 'Vehicles are transported inside an enclosed carrier to reduce exposure during transit.',
    },
    {
        src: '/images/delivery/delivery-3.webp',
        title: 'Carrier inspection before route',
        caption: 'Pickup condition and delivery details are confirmed before transportation begins.',
    },
    {
        src: '/images/delivery/delivery-4.webp',
        title: 'Delivery preparation',
        caption: 'The delivery process is coordinated after payment confirmation and documentation.',
    },
];

const openGalleryImage = (image) => {
    selectedGalleryImage.value = image;
};

const closeGalleryImage = () => {
    selectedGalleryImage.value = null;
};
</script>

<template>
    <SeoHead
        title="Delivery"
        description="Learn about enclosed vehicle delivery, insured transportation, estimated timing, and buyer delivery confirmation steps."
    />
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
                    A clear step-by-step process helps out-of-state buyers understand what happens before the vehicle leaves the dealership.
                </p>
            </div>

            <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-5">
                <article
                    v-for="step in steps"
                    :key="step.number"
                    class="dealer-card relative overflow-hidden p-6"
                >
                    <div class="absolute right-4 top-4 text-5xl font-black text-white/[0.035]">
                        {{ step.number }}
                    </div>

                    <div class="flex h-12 w-12 items-center justify-center rounded-xl border border-amber-300/40 bg-amber-300/10 text-xl font-black text-amber-300">
                        {{ step.icon }}
                    </div>

                    <p class="mt-6 text-xs font-black uppercase tracking-[0.24em] text-slate-500">
                        Step {{ step.number }}
                    </p>

                    <h3 class="mt-3 text-xl font-black">
                        {{ step.title }}
                    </h3>

                    <p class="mt-4 text-sm leading-6 text-slate-400">
                        {{ step.text }}
                    </p>
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
            <div class="section-header">
                <div>
                    <p class="eyebrow">
                        How It Looks
                    </p>

                    <h2 class="mt-3 heading-lg">
                        Enclosed transport photo examples.
                    </h2>
                </div>

                <p class="max-w-xl body-muted">
                    Real delivery photos help buyers understand how vehicles are prepared, loaded, and transported in an enclosed auto carrier.
                </p>
            </div>

            <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-4" style="align-items: start;">
                <button
                    v-for="image in deliveryGallery"
                    :key="image.src"
                    type="button"
                    class="group text-left"
                    @click="openGalleryImage(image)"
                >
                    <div class="overflow-hidden rounded-2xl border border-white/10 bg-black/30">
                        <img
                            :src="image.src"
                            :alt="image.title"
                            class="h-64 w-full object-cover transition duration-500 group-hover:scale-[1.04]"
                        >
                    </div>

                    <div class="mt-4 border-l border-amber-300/50 pl-4">
                        <h3 class="text-lg font-black group-hover:text-amber-300">
                            {{ image.title }}
                        </h3>

                        <p class="mt-2 text-sm leading-6 text-slate-400">
                            {{ image.caption }}
                        </p>
                    </div>
                </button>
            </div>

            <div class="mt-8 rounded-2xl border border-white/10 bg-white/[0.025] p-6">
                <div class="grid gap-5 lg:grid-cols-[280px_1fr] lg:items-center">
                    <div>
                        <p class="text-xs font-black uppercase tracking-[0.24em] text-slate-500">
                            Photo Confirmation
                        </p>

                        <h3 class="mt-3 text-2xl font-black">
                            Visual proof before delivery.
                        </h3>
                    </div>

                    <p class="text-sm leading-6 text-slate-400">
                        Delivery photos may be used to show loading, enclosed carrier preparation, and vehicle condition before transportation. Final delivery documentation and carrier details are confirmed during the purchase process.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="relative overflow-hidden border-t border-white/10">

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
