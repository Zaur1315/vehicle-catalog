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

const serviceOptions = [
    {
        number: '01',
        title: 'Current service availability',
        description:
            'Call our team to explain what your vehicle needs and confirm whether we can assist before visiting.',
    },
    {
        number: '02',
        title: 'Maintenance questions',
        description:
            'Speak with the dealership about maintenance concerns, warning signs, or the appropriate next step for your vehicle.',
    },
    {
        number: '03',
        title: 'Inventory vehicle information',
        description:
            'Ask what inspection, preparation, condition, and service information is available for a vehicle in our inventory.',
    },
    {
        number: '04',
        title: 'After-sale support',
        description:
            'Already purchased a vehicle from Cars For Less? Contact us with questions and we will help clarify the next step.',
    },
];

const visitSteps = [
    {
        number: '01',
        title: 'Call the dealership',
        description:
            'Describe the vehicle, the issue, and any warning lights, sounds, or recent changes you have noticed.',
    },
    {
        number: '02',
        title: 'Confirm availability',
        description:
            'Our team will explain whether assistance is currently available and when you should visit.',
    },
    {
        number: '03',
        title: 'Bring the vehicle',
        description:
            'Arrive at the agreed time with any useful maintenance records or information about the concern.',
    },
];

const preparationItems = [
    'Vehicle year, make, and model',
    'Current mileage',
    'Description of the issue',
    'Warning lights or dashboard messages',
    'When the issue first appeared',
    'Recent maintenance or repairs',
];

const delivery3 = '/images/delivery/delivery-3.webp';
const visitBg = '/images/visit-bg.webp'

const serviceFaq = [
    {
        question: 'Do I need to call before visiting?',
        answer:
            'Yes. Service availability can change, so contact the dealership first to describe what your vehicle needs and confirm the appropriate time to visit.',
    },
    {
        question: 'Do you service vehicles purchased elsewhere?',
        answer:
            'Contact our team with the vehicle information and requested service. We will confirm whether assistance is currently available.',
    },
    {
        question: 'Can I ask about a vehicle before purchasing it?',
        answer:
            'Yes. Contact the sales team with the vehicle name or stock number and ask what condition, preparation, inspection, or service information is available.',
    },
    {
        question: 'What information should I provide?',
        answer:
            'Share the year, make, model, mileage, warning lights, symptoms, and any recent maintenance or repair information.',
    },
];
</script>

<template>
    <SeoHead
        title="Automotive Service"
        description="Contact Cars For Less Sales & Service in East Granby, CT to ask about current automotive service availability, vehicle maintenance questions, and after-sale support."
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
                        Automotive service
                    </p>

                    <h1
                        class="mt-5 max-w-5xl text-5xl font-black leading-[0.9] tracking-[-0.065em] sm:text-6xl lg:text-7xl"
                    >
                        Help for your vehicle.<br>

                        <span class="text-[#ff4f38]">
                            Answers from a local team.
                        </span>
                    </h1>

                    <p
                        class="mt-6 max-w-3xl text-base leading-7 text-stone-600"
                    >
                        Contact Cars For Less to discuss current service
                        availability, maintenance concerns, inventory vehicle
                        information, or questions after your purchase.
                    </p>
                </div>

                <div class="border-l border-black/15 pl-6">
                    <p
                        class="text-[10px] font-black uppercase tracking-[0.2em] text-stone-400"
                    >
                        Call before visiting
                    </p>

                    <a
                        :href="`tel:${site.phone_tel}`"
                        class="mt-3 block text-2xl font-black tracking-[-0.03em] transition hover:text-[#e9422c]"
                    >
                        {{ site.phone }}
                    </a>

                    <p class="mt-2 text-sm leading-6 text-stone-500">
                        Explain what your vehicle needs and confirm current
                        availability with our team.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Service introduction -->
    <section class="overflow-hidden bg-white">
        <div class="site-container grid lg:grid-cols-2">
            <div class="relative min-h-[440px] lg:min-h-[650px]">
                <img
                    :src="delivery3"
                    alt="Automotive service support at Cars For Less"
                    class="absolute inset-0 h-full w-full object-cover"
                >

                <div
                    class="absolute inset-0 bg-gradient-to-t from-black/65 via-black/10 to-white/10"
                ></div>

                <div
                    class="absolute inset-x-0 bottom-0 p-7 text-white sm:p-10"
                >
                    <p
                        class="text-[10px] font-black uppercase tracking-[0.22em] text-[#ff6b57]"
                    >
                        Cars For Less Sales & Service
                    </p>

                    <p
                        class="mt-3 max-w-lg text-3xl font-black leading-[1.05] tracking-[-0.045em]"
                    >
                        Start with a conversation before bringing in your
                        vehicle.
                    </p>
                </div>
            </div>

            <div
                class="flex flex-col justify-center py-16 lg:py-24 lg:pl-16"
            >
                <p class="eyebrow">
                    Start here
                </p>

                <h2 class="mt-5 heading-lg">
                    Tell us what is happening.
                </h2>

                <p class="mt-7 max-w-xl text-base leading-8 text-stone-600">
                    Strange noise, dashboard warning, maintenance question, or
                    concern about a vehicle you purchased? Call the dealership
                    and describe the situation as clearly as possible.
                </p>

                <p class="mt-5 max-w-xl text-base leading-8 text-stone-600">
                    Our team will confirm whether assistance is available and
                    explain what you should do next.
                </p>

                <div class="mt-9 flex flex-wrap gap-3">
                    <a
                        :href="`tel:${site.phone_tel}`"
                        class="btn-primary"
                    >
                        Call about service
                    </a>

                    <Link href="/contact" class="btn-secondary">
                        Contact the dealership
                    </Link>
                </div>

                <p class="mt-5 text-xs leading-5 text-stone-500">
                    Service availability, timing, and scope may vary. Contact
                    the dealership before visiting.
                </p>
            </div>
        </div>
    </section>

    <!-- Service options -->
    <section class="site-section bg-[#f5f3ee]">
        <div class="site-container">
            <div class="section-header">
                <div>
                    <p class="eyebrow">
                        How we can help
                    </p>

                    <h2 class="mt-5 heading-lg">
                        Support for drivers and buyers.
                    </h2>
                </div>

                <p class="max-w-md text-sm leading-6 text-stone-500">
                    Call first so our team can understand the request and
                    confirm current service availability.
                </p>
            </div>

            <div class="grid gap-px bg-black/10 md:grid-cols-2">
                <article
                    v-for="item in serviceOptions"
                    :key="item.number"
                    class="bg-white p-7 sm:p-9"
                >
                    <div class="flex items-start justify-between gap-5">
                        <h3
                            class="max-w-sm text-2xl font-black tracking-[-0.035em]"
                        >
                            {{ item.title }}
                        </h3>

                        <span
                            class="shrink-0 text-xs font-black text-[#e9422c]"
                        >
                            {{ item.number }}
                        </span>
                    </div>

                    <p class="mt-5 max-w-lg text-sm leading-7 text-stone-600">
                        {{ item.description }}
                    </p>
                </article>
            </div>
        </div>
    </section>

    <!-- Preparation -->
    <section class="site-section bg-white">
        <div
            class="site-container grid gap-12 lg:grid-cols-[0.75fr_1.25fr]"
        >
            <div>
                <p class="eyebrow">
                    Before you call
                </p>

                <h2 class="mt-5 heading-lg">
                    A few details can save time.
                </h2>

                <p class="mt-6 max-w-md text-base leading-7 text-stone-600">
                    You do not need to diagnose the vehicle yourself. Just
                    share what you know and what you have noticed.
                </p>
            </div>

            <div
                class="grid gap-px overflow-hidden border border-black/10 bg-black/10 sm:grid-cols-2"
            >
                <div
                    v-for="(item, index) in preparationItems"
                    :key="item"
                    class="flex items-center gap-4 bg-[#f5f3ee] p-5"
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

    <!-- Visit process -->
    <section class="site-section bg-[#171717] text-white">
        <div
            class="site-container grid gap-12 lg:grid-cols-[0.65fr_1.35fr]"
        >
            <div>
                <p
                    class="text-[10px] font-black uppercase tracking-[0.25em] text-[#ff5a45]"
                >
                    Service process
                </p>

                <h2
                    class="mt-5 text-5xl font-black leading-[0.92] tracking-[-0.06em] sm:text-6xl"
                >
                    Call first.<br>
                    Visit prepared.
                </h2>

                <p class="mt-7 max-w-md text-base leading-7 text-stone-300">
                    Confirming availability before your visit helps avoid
                    unnecessary waiting or travel.
                </p>
            </div>

            <div class="divide-y divide-white/15 border-y border-white/15">
                <article
                    v-for="step in visitSteps"
                    :key="step.number"
                    class="grid gap-4 py-8 sm:grid-cols-[70px_1fr]"
                >
                    <p class="text-xs font-black text-[#ff5a45]">
                        {{ step.number }}
                    </p>

                    <div>
                        <h3
                            class="text-2xl font-black tracking-[-0.035em]"
                        >
                            {{ step.title }}
                        </h3>

                        <p
                            class="mt-3 max-w-xl text-sm leading-7 text-stone-400"
                        >
                            {{ step.description }}
                        </p>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <!-- Sales connection -->
    <section class="overflow-hidden bg-[#f5f3ee]">
        <div class="site-container grid lg:grid-cols-2">
            <div
                class="flex flex-col justify-center py-16 lg:py-24 lg:pr-16"
            >
                <p class="eyebrow">
                    Shopping for a vehicle?
                </p>

                <h2 class="mt-5 heading-lg">
                    Ask about condition before you buy.
                </h2>

                <p class="mt-7 max-w-xl text-base leading-8 text-stone-600">
                    Every vehicle page includes available mileage,
                    specifications, photographs, and inventory information.
                    Contact the sales team if you need additional condition or
                    preparation details.
                </p>

                <div class="mt-9 flex flex-wrap gap-3">
                    <Link href="/inventory" class="btn-primary">
                        Browse inventory
                    </Link>

                    <Link href="/contact" class="btn-secondary">
                        Ask a question
                    </Link>
                </div>
            </div>

            <div class="relative min-h-[420px] lg:min-h-[600px]">
                <img
                    :src="visitBg"
                    alt="Cars For Less vehicle inventory"
                    class="absolute inset-0 h-full w-full object-cover"
                >

                <div
                    class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-white/10"
                ></div>

                <div
                    class="absolute bottom-7 right-7 max-w-xs bg-white p-6 text-[#171717] sm:bottom-10 sm:right-10"
                >
                    <p
                        class="text-[9px] font-black uppercase tracking-[0.2em] text-[#e9422c]"
                    >
                        Current inventory
                    </p>

                    <p
                        class="mt-3 text-xl font-black leading-7 tracking-[-0.03em]"
                    >
                        Review the available information, then speak directly
                        with our team.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="site-section bg-white">
        <div
            class="site-container grid gap-12 lg:grid-cols-[0.65fr_1.35fr]"
        >
            <div>
                <p class="eyebrow">
                    Service FAQ
                </p>

                <h2 class="mt-5 heading-lg">
                    Before your visit.
                </h2>

                <p class="mt-6 max-w-md text-base leading-7 text-stone-600">
                    Call us if your question is not covered here.
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
                    v-for="item in serviceFaq"
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

    <!-- Location CTA -->
    <section class="bg-[#ff4f38] py-14 text-white">
        <div
            class="site-container flex flex-col gap-7 md:flex-row md:items-center md:justify-between"
        >
            <div>
                <p
                    class="text-[10px] font-black uppercase tracking-[0.22em] text-white/60"
                >
                    Cars For Less Sales & Service
                </p>

                <h2
                    class="mt-3 text-3xl font-black tracking-[-0.04em]"
                >
                    Call before bringing in your vehicle.
                </h2>

                <p class="mt-2 text-sm text-white/75">
                    {{ site.address }}
                </p>
            </div>

            <a
                :href="`tel:${site.phone_tel}`"
                class="inline-flex min-h-12 shrink-0 items-center justify-center rounded-full bg-[#171717] px-7 py-3 text-xs font-black uppercase tracking-wide text-white transition hover:bg-white hover:text-black"
            >
                {{ site.phone }}
            </a>
        </div>
    </section>
</template>
