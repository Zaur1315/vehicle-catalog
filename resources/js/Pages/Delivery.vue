<script setup>
import {Link, usePage} from '@inertiajs/vue3';
import {computed} from 'vue';
import SeoHead from '@/Components/SeoHead.vue';
import SiteLayout from '@/Layouts/SiteLayout.vue';

defineOptions({
    layout: SiteLayout,
});

const page = usePage();

const site = computed(() => page.props.site || {});

const deliveryHeroImage = '/images/delivery/delivery-1.webp';
const deliveryProcessImage = '/images/delivery/delivery-2.webp';

const deliverySteps = [
    {
        number: '01',
        title: 'Choose a vehicle',
        description:
            'Browse current inventory and confirm the vehicle’s availability with our sales team.',
    },
    {
        number: '02',
        title: 'Share the destination',
        description:
            'Provide the delivery address and any relevant access or scheduling information.',
    },
    {
        number: '03',
        title: 'Review availability and cost',
        description:
            'Our team will explain whether delivery is available and discuss the estimated timing and cost.',
    },
    {
        number: '04',
        title: 'Confirm the arrangements',
        description:
            'Review the purchase and delivery details before the vehicle is scheduled for transport.',
    },
];

const deliveryFactors = [
    {
        title: 'Distance',
        description:
            'The distance between the dealership and destination can affect availability, timing, and cost.',
    },
    {
        title: 'Vehicle type',
        description:
            'Vehicle dimensions, weight, condition, and operability may affect available transport options.',
    },
    {
        title: 'Destination access',
        description:
            'Large transport vehicles may need a safe and accessible location for loading or unloading.',
    },
    {
        title: 'Scheduling',
        description:
            'Pickup and arrival dates depend on purchase completion, transporter availability, route, and conditions.',
    },
];

const preparationItems = [
    'Confirm the complete delivery address',
    'Provide a working contact phone number',
    'Share access restrictions or narrow roads',
    'Review the vehicle condition before transport',
    'Keep purchase and delivery documentation',
    'Inspect the vehicle when it arrives',
];

const deliveryFaq = [
    {
        question: 'Is delivery available for every vehicle?',
        answer:
            'Delivery availability can depend on the vehicle, destination, distance, timing, and transport options. Contact the dealership for confirmation.',
    },
    {
        question: 'How much does vehicle delivery cost?',
        answer:
            'Cost can vary based on distance, vehicle size, transport method, route, and scheduling. A delivery estimate should be reviewed before arrangements are confirmed.',
    },
    {
        question: 'How long does delivery take?',
        answer:
            'Timing varies by destination, route, transporter availability, weather, purchase completion, and other conditions. Any date provided before scheduling should be treated as an estimate.',
    },
    {
        question: 'Can I pick up the vehicle myself?',
        answer:
            'Ask the dealership about arranging an in-person pickup after the purchase details and pickup time have been confirmed.',
    },
    {
        question: 'Should I inspect the vehicle when it arrives?',
        answer:
            'Yes. Review the vehicle condition and transport documentation at delivery and report any concerns through the appropriate process.',
    },
];
</script>

<template>
    <SeoHead
        title="Vehicle Delivery"
        description="Ask Cars For Less Sales & Service about vehicle pickup and delivery availability, estimated timing, transport arrangements, and destination requirements."
    />

    <!-- Light banner -->
    <section class="border-b border-black/10 bg-[#f5f3ee]">
        <div
            class="site-container pb-12 pt-12 lg:pb-16 lg:pt-16"
        >
            <div
                class="grid gap-8 lg:grid-cols-[1fr_380px] lg:items-end"
            >
                <div>
                    <p class="eyebrow">
                        Vehicle delivery
                    </p>

                    <h1
                        class="mt-5 max-w-5xl text-5xl font-black leading-[0.9] tracking-[-0.065em] sm:text-6xl lg:text-7xl"
                    >
                        Found the right vehicle?<br>

                        <span class="text-[#ff4f38]">
                            Ask how to get it home.
                        </span>
                    </h1>

                    <p
                        class="mt-6 max-w-3xl text-base leading-7 text-stone-600"
                    >
                        Contact our dealership to discuss pickup or delivery
                        availability, estimated transport timing, destination
                        details, and possible costs.
                    </p>
                </div>

                <div class="border-l border-black/15 pl-6">
                    <p
                        class="text-[10px] font-black uppercase tracking-[0.2em] text-stone-400"
                    >
                        Delivery questions
                    </p>

                    <a
                        :href="`tel:${site.phone_tel}`"
                        class="mt-3 block text-2xl font-black tracking-[-0.03em] transition hover:text-[#e9422c]"
                    >
                        {{ site.phone }}
                    </a>

                    <p class="mt-2 text-sm leading-6 text-stone-500">
                        Have the vehicle name, stock number, and destination
                        ready when you call.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Delivery introduction -->
    <section class="overflow-hidden bg-white">
        <div class="site-container grid lg:grid-cols-2">
            <div class="relative min-h-[460px] lg:min-h-[680px]">
                <img
                    :src="deliveryHeroImage"
                    alt="Vehicle prepared for delivery"
                    class="absolute inset-0 h-full w-full object-cover"
                >

                <div
                    class="absolute inset-0 bg-gradient-to-t from-black/65 via-black/5 to-white/10"
                ></div>

                <div
                    class="absolute inset-x-0 bottom-0 p-7 text-white sm:p-10"
                >
                    <p
                        class="text-[10px] font-black uppercase tracking-[0.22em] text-[#ff6b57]"
                    >
                        Pickup or delivery
                    </p>

                    <p
                        class="mt-3 max-w-lg text-3xl font-black leading-[1.05] tracking-[-0.045em]"
                    >
                        The right option depends on the vehicle, destination,
                        and timing.
                    </p>
                </div>
            </div>

            <div
                class="flex flex-col justify-center py-16 lg:py-24 lg:pl-16"
            >
                <p class="eyebrow">
                    Delivery availability
                </p>

                <h2 class="mt-5 heading-lg">
                    Start with the destination.
                </h2>

                <p class="mt-7 max-w-xl text-base leading-8 text-stone-600">
                    After choosing a vehicle, tell our team where it needs to
                    go. The destination, vehicle size, distance, access, and
                    schedule can all affect the available options.
                </p>

                <p class="mt-5 max-w-xl text-base leading-8 text-stone-600">
                    Delivery should be discussed and confirmed separately from
                    the vehicle listing. Do not assume that a quoted vehicle
                    price includes transportation.
                </p>

                <div class="mt-9 flex flex-wrap gap-3">
                    <Link href="/inventory" class="btn-primary">
                        Choose a vehicle
                    </Link>

                    <Link href="/contact" class="btn-secondary">
                        Ask about delivery
                    </Link>
                </div>
            </div>
        </div>
    </section>

    <!-- Process -->
    <section class="site-section bg-[#f5f3ee]">
        <div
            class="site-container grid gap-12 lg:grid-cols-[0.65fr_1.35fr]"
        >
            <div>
                <p class="eyebrow">
                    Delivery process
                </p>

                <h2 class="mt-5 heading-lg">
                    From the dealership to your destination.
                </h2>

                <p class="mt-6 max-w-md text-base leading-7 text-stone-600">
                    Transport arrangements begin after the vehicle,
                    destination, and purchase details are reviewed.
                </p>
            </div>

            <div class="divide-y divide-black/15 border-y border-black/15">
                <article
                    v-for="step in deliverySteps"
                    :key="step.number"
                    class="grid gap-4 py-8 sm:grid-cols-[70px_1fr]"
                >
                    <p class="text-xs font-black text-[#e9422c]">
                        {{ step.number }}
                    </p>

                    <div>
                        <h3
                            class="text-2xl font-black tracking-[-0.035em]"
                        >
                            {{ step.title }}
                        </h3>

                        <p
                            class="mt-3 max-w-xl text-sm leading-7 text-stone-600"
                        >
                            {{ step.description }}
                        </p>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <!-- Delivery factors -->
    <section class="site-section bg-white">
        <div class="site-container">
            <div class="section-header">
                <div>
                    <p class="eyebrow">
                        What affects delivery?
                    </p>

                    <h2 class="mt-5 heading-lg">
                        Every route is different.
                    </h2>
                </div>

                <p class="max-w-md text-sm leading-6 text-stone-500">
                    Availability, timing, and cost should be confirmed for the
                    specific vehicle and destination.
                </p>
            </div>

            <div class="grid gap-px bg-black/10 md:grid-cols-2">
                <article
                    v-for="(factor, index) in deliveryFactors"
                    :key="factor.title"
                    class="bg-[#f5f3ee] p-7 sm:p-9"
                >
                    <div class="flex items-start justify-between gap-5">
                        <h3
                            class="text-2xl font-black tracking-[-0.035em]"
                        >
                            {{ factor.title }}
                        </h3>

                        <span
                            class="text-xs font-black text-[#e9422c]"
                        >
                            0{{ index + 1 }}
                        </span>
                    </div>

                    <p class="mt-5 text-sm leading-7 text-stone-600">
                        {{ factor.description }}
                    </p>
                </article>
            </div>
        </div>
    </section>

    <!-- Image section -->
    <section class="overflow-hidden bg-[#171717] text-white">
        <div class="site-container grid lg:grid-cols-2">
            <div
                class="flex flex-col justify-center py-16 lg:py-24 lg:pr-16"
            >
                <p
                    class="text-[10px] font-black uppercase tracking-[0.25em] text-[#ff5a45]"
                >
                    Before scheduling
                </p>

                <h2
                    class="mt-5 text-5xl font-black leading-[0.92] tracking-[-0.06em] sm:text-6xl"
                >
                    Review the vehicle first.
                </h2>

                <p class="mt-7 max-w-xl text-base leading-8 text-stone-300">
                    Confirm the vehicle details, current condition, price, and
                    purchase terms before finalizing transportation.
                </p>

                <p class="mt-5 max-w-xl text-sm leading-7 text-stone-400">
                    Ask what documentation is available and how the vehicle
                    condition will be recorded before it leaves the dealership.
                </p>

                <Link
                    href="/inventory"
                    class="mt-9 inline-flex min-h-12 self-start items-center justify-center rounded-full bg-[#ff4f38] px-7 py-3 text-xs font-black uppercase tracking-wide text-white transition hover:bg-white hover:text-black"
                >
                    Browse inventory
                </Link>
            </div>

            <div class="relative min-h-[440px] lg:min-h-[650px]">
                <img
                    :src="deliveryProcessImage"
                    alt="Vehicle transportation planning"
                    class="absolute inset-0 h-full w-full object-cover"
                >

                <div
                    class="absolute inset-0 bg-gradient-to-r from-[#171717]/35 via-transparent to-transparent"
                ></div>

                <div
                    class="absolute bottom-7 right-7 max-w-xs bg-white p-6 text-[#171717] sm:bottom-10 sm:right-10"
                >
                    <p
                        class="text-[9px] font-black uppercase tracking-[0.2em] text-[#e9422c]"
                    >
                        Confirm before transport
                    </p>

                    <p
                        class="mt-3 text-xl font-black leading-7 tracking-[-0.03em]"
                    >
                        Vehicle, destination, timing, cost, and delivery
                        arrangements should all be documented.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Delivery preparation -->
    <section class="site-section bg-[#f5f3ee]">
        <div
            class="site-container grid gap-12 lg:grid-cols-[0.75fr_1.25fr]"
        >
            <div>
                <p class="eyebrow">
                    Prepare for delivery
                </p>

                <h2 class="mt-5 heading-lg">
                    A simple delivery checklist.
                </h2>

                <p class="mt-6 max-w-md text-base leading-7 text-stone-600">
                    Keep the relevant details and documents available until
                    the vehicle has arrived and been reviewed.
                </p>
            </div>

            <div
                class="grid gap-px overflow-hidden border border-black/10 bg-black/10 sm:grid-cols-2"
            >
                <div
                    v-for="(item, index) in preparationItems"
                    :key="item"
                    class="flex items-center gap-4 bg-white p-5"
                >
                    <span
                        class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#171717] text-[10px] font-black text-white"
                    >
                        0{{ index + 1 }}
                    </span>

                    <p class="text-sm font-black">
                        {{ item }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Local pickup -->
    <section class="bg-[#ff4f38] text-white">
        <div
            class="site-container grid gap-10 py-14 lg:grid-cols-[1fr_auto] lg:items-center lg:py-16"
        >
            <div>
                <p
                    class="text-[10px] font-black uppercase tracking-[0.22em] text-white/60"
                >
                    Local pickup
                </p>

                <h2
                    class="mt-3 max-w-3xl text-4xl font-black leading-[0.95] tracking-[-0.05em]"
                >
                    Prefer to collect the vehicle yourself?
                </h2>

                <p class="mt-5 max-w-2xl text-sm leading-7 text-white/80">
                    Contact the dealership to confirm the purchase status,
                    required documents, and a convenient pickup time before
                    traveling.
                </p>
            </div>

            <a
                :href="site.maps_url"
                target="_blank"
                rel="noopener"
                class="inline-flex min-h-12 shrink-0 items-center justify-center rounded-full bg-[#171717] px-7 py-3 text-xs font-black uppercase tracking-wide text-white transition hover:bg-white hover:text-black"
            >
                Get directions
            </a>
        </div>
    </section>

    <!-- FAQ -->
    <section class="site-section bg-white">
        <div
            class="site-container grid gap-12 lg:grid-cols-[0.65fr_1.35fr]"
        >
            <div>
                <p class="eyebrow">
                    Delivery FAQ
                </p>

                <h2 class="mt-5 heading-lg">
                    Before arranging transport.
                </h2>

                <p class="mt-6 max-w-md text-base leading-7 text-stone-600">
                    Contact the dealership for an answer specific to your
                    vehicle and destination.
                </p>

                <a
                    :href="`tel:${site.phone_tel}`"
                    class="btn-secondary mt-8"
                >
                    Call {{ site.phone }}
                </a>
            </div>

            <div class="border-t border-black/15">
                <details
                    v-for="item in deliveryFaq"
                    :key="item.question"
                    class="group border-b border-black/15"
                >
                    <summary
                        class="flex cursor-pointer list-none items-center justify-between gap-6 py-6 text-lg font-black"
                    >
                        {{ item.question }}

                        <span
                            class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full border border-black/15 text-lg transition group-open:rotate-45 group-open:border-[#ff4f38] group-open:bg-[#ff4f38] group-open:text-white"
                        >
                            +
                        </span>
                    </summary>

                    <p
                        class="max-w-2xl pb-6 pr-12 text-sm leading-7 text-stone-600"
                    >
                        {{ item.answer }}
                    </p>
                </details>
            </div>
        </div>
    </section>

    <!-- Final CTA -->
    <section class="bg-[#171717] py-14 text-white">
        <div
            class="site-container flex flex-col gap-7 md:flex-row md:items-center md:justify-between"
        >
            <div>
                <p
                    class="text-[10px] font-black uppercase tracking-[0.22em] text-[#ff5a45]"
                >
                    Have a destination in mind?
                </p>

                <h2
                    class="mt-3 text-3xl font-black tracking-[-0.04em]"
                >
                    Ask about delivery for a specific vehicle.
                </h2>
            </div>

            <Link
                href="/contact"
                class="inline-flex min-h-12 shrink-0 items-center justify-center rounded-full bg-white px-7 py-3 text-xs font-black uppercase tracking-wide text-black transition hover:bg-[#ff4f38] hover:text-white"
            >
                Contact the dealership
            </Link>
        </div>
    </section>
</template>
