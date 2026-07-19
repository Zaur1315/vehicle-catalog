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

const visitBg = '/images/visit-bg.webp';
const dealershipImage = '/images/delivery/delivery-4.webp';

const dealershipValues = [
    {
        number: '01',
        title: 'Clear vehicle information',
        description:
            'Review available photos, mileage, price, specifications, stock number, and vehicle details before contacting the dealership.',
    },
    {
        number: '02',
        title: 'Direct communication',
        description:
            'Call or send a request and speak with our team about inventory, financing, your current vehicle, or service availability.',
    },
    {
        number: '03',
        title: 'Practical options',
        description:
            'Explore available vehicles and ask about financing, trade-in, delivery, warranty information, and the next step.',
    },
    {
        number: '04',
        title: 'Local support',
        description:
            'Visit our East Granby location and continue the conversation directly with a local sales and service team.',
    },
];

const customerPaths = [
    {
        title: 'Shop current inventory',
        description:
            'Browse cars, SUVs, and trucks currently listed by the dealership.',
        href: '/inventory',
        linkLabel: 'Browse inventory',
    },
    {
        title: 'Explore financing',
        description:
            'Send a preliminary request and discuss available next steps with our team.',
        href: '/finance',
        linkLabel: 'Financing information',
    },
    {
        title: 'Sell or trade a vehicle',
        description:
            'Provide the details of your current vehicle for an initial review.',
        href: '/trade-in',
        linkLabel: 'Submit your vehicle',
    },
    {
        title: 'Ask about service',
        description:
            'Contact the dealership to confirm current automotive service availability.',
        href: '/service',
        linkLabel: 'Service information',
    },
];

const visitChecklist = [
    'Confirm that the vehicle is still available',
    'Bring your driver’s license for a test drive',
    'Prepare questions about condition and history',
    'Bring trade-in and payoff information if applicable',
    'Discuss financing before making a final decision',
];
</script>

<template>
    <SeoHead
        title="Our Dealership"
        description="Learn about Cars For Less Sales & Service, a local used vehicle dealership in East Granby, Connecticut. Browse inventory, financing, trade-in, and service information."
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
                        Our dealership
                    </p>

                    <h1
                        class="mt-5 max-w-5xl text-5xl font-black leading-[0.9] tracking-[-0.065em] sm:text-6xl lg:text-7xl"
                    >
                        Local vehicles.<br>

                        <span class="text-[#ff4f38]">
                            Real people. Clear answers.
                        </span>
                    </h1>

                    <p
                        class="mt-6 max-w-3xl text-base leading-7 text-stone-600"
                    >
                        Cars For Less Sales & Service helps drivers explore
                        used vehicles, ask informed questions, and understand
                        the next step before making a decision.
                    </p>
                </div>

                <div class="border-l border-black/15 pl-6">
                    <p
                        class="text-[10px] font-black uppercase tracking-[0.2em] text-stone-400"
                    >
                        Visit Cars For Less
                    </p>

                    <a
                        :href="site.maps_url"
                        target="_blank"
                        rel="noopener"
                        class="mt-3 block text-lg font-black leading-7 tracking-[-0.02em] transition hover:text-[#e9422c]"
                    >
                        {{ site.address }}
                    </a>

                    <p class="mt-2 text-sm text-stone-500">
                        {{ site.business_hours }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Dealership introduction -->
    <section class="overflow-hidden bg-white">
        <div class="site-container grid lg:grid-cols-2">
            <div class="relative min-h-[460px] lg:min-h-[680px]">
                <img
                    :src="visitBg"
                    alt="Cars For Less Sales and Service dealership"
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
                        East Granby, Connecticut
                    </p>

                    <p
                        class="mt-3 max-w-lg text-3xl font-black leading-[1.05] tracking-[-0.045em]"
                    >
                        A local destination for vehicle sales, questions, and
                        automotive support.
                    </p>
                </div>
            </div>

            <div
                class="flex flex-col justify-center py-16 lg:py-24 lg:pl-16"
            >
                <p class="eyebrow">
                    About Cars For Less
                </p>

                <h2 class="mt-5 heading-lg">
                    Car shopping should feel understandable.
                </h2>

                <p class="mt-7 max-w-xl text-base leading-8 text-stone-600">
                    A vehicle is a significant purchase. Buyers should have
                    time to review the available information, ask questions,
                    inspect the vehicle, and understand the purchase details.
                </p>

                <p class="mt-5 max-w-xl text-base leading-8 text-stone-600">
                    Our website gives you a place to begin. Browse current
                    inventory, compare vehicle details, explore financing,
                    provide trade-in information, and contact the dealership
                    before visiting.
                </p>

                <div class="mt-9 flex flex-wrap gap-3">
                    <Link href="/inventory" class="btn-primary">
                        Browse inventory
                    </Link>

                    <Link href="/contact" class="btn-secondary">
                        Contact our team
                    </Link>
                </div>
            </div>
        </div>
    </section>

    <!-- Values -->
    <section class="site-section bg-[#f5f3ee]">
        <div class="site-container">
            <div class="section-header">
                <div>
                    <p class="eyebrow">
                        What matters to us
                    </p>

                    <h2 class="mt-5 heading-lg">
                        A practical dealership experience.
                    </h2>
                </div>

                <p class="max-w-md text-sm leading-6 text-stone-500">
                    Online information helps you prepare. A direct
                    conversation helps you make the next decision.
                </p>
            </div>

            <div class="grid gap-px bg-black/10 md:grid-cols-2">
                <article
                    v-for="value in dealershipValues"
                    :key="value.number"
                    class="bg-white p-7 sm:p-9"
                >
                    <div class="flex items-start justify-between gap-5">
                        <h3
                            class="max-w-sm text-2xl font-black tracking-[-0.035em]"
                        >
                            {{ value.title }}
                        </h3>

                        <span
                            class="shrink-0 text-xs font-black text-[#e9422c]"
                        >
                            {{ value.number }}
                        </span>
                    </div>

                    <p class="mt-5 max-w-lg text-sm leading-7 text-stone-600">
                        {{ value.description }}
                    </p>
                </article>
            </div>
        </div>
    </section>

    <!-- Sales and service -->
    <section class="overflow-hidden bg-[#171717] text-white">
        <div class="site-container grid lg:grid-cols-2">
            <div
                class="flex flex-col justify-center py-16 lg:py-24 lg:pr-16"
            >
                <p
                    class="text-[10px] font-black uppercase tracking-[0.25em] text-[#ff5a45]"
                >
                    Sales & Service
                </p>

                <h2
                    class="mt-5 text-5xl font-black leading-[0.92] tracking-[-0.06em] sm:text-6xl"
                >
                    Support before and after the sale.
                </h2>

                <p class="mt-7 max-w-xl text-base leading-8 text-stone-300">
                    Contact our team with questions about available vehicles,
                    current service availability, financing requests,
                    trade-ins, or support after purchasing a vehicle.
                </p>

                <p class="mt-5 max-w-xl text-sm leading-7 text-stone-400">
                    Service availability can vary. Call before visiting so our
                    team can understand what your vehicle needs.
                </p>

                <div class="mt-9 flex flex-wrap gap-3">
                    <Link
                        href="/service"
                        class="inline-flex min-h-12 items-center justify-center rounded-full bg-[#ff4f38] px-7 py-3 text-xs font-black uppercase tracking-wide text-white transition hover:bg-white hover:text-black"
                    >
                        Service information
                    </Link>

                    <a
                        :href="`tel:${site.phone_tel}`"
                        class="inline-flex min-h-12 items-center justify-center rounded-full border border-white/30 px-7 py-3 text-xs font-black uppercase tracking-wide text-white transition hover:border-white hover:bg-white hover:text-black"
                    >
                        {{ site.phone }}
                    </a>
                </div>
            </div>

            <div class="relative min-h-[440px] lg:min-h-[650px]">
                <img
                    :src="dealershipImage"
                    alt="Vehicle sales and service support"
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
                        Call before visiting
                    </p>

                    <p
                        class="mt-3 text-xl font-black leading-7 tracking-[-0.03em]"
                    >
                        Confirm vehicle and service availability directly with
                        our team.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Customer paths -->
    <section class="site-section bg-white">
        <div class="site-container">
            <div class="section-header">
                <div>
                    <p class="eyebrow">
                        Start where you are
                    </p>

                    <h2 class="mt-5 heading-lg">
                        What can we help with?
                    </h2>
                </div>

                <p class="max-w-md text-sm leading-6 text-stone-500">
                    Choose the path that best matches what you need today.
                </p>
            </div>

            <div class="grid gap-px bg-black/10 md:grid-cols-2">
                <article
                    v-for="(item, index) in customerPaths"
                    :key="item.title"
                    class="group bg-[#f5f3ee] p-7 transition hover:bg-[#171717] hover:text-white sm:p-9"
                >
                    <div class="flex items-start justify-between gap-5">
                        <h3
                            class="text-2xl font-black tracking-[-0.035em]"
                        >
                            {{ item.title }}
                        </h3>

                        <span
                            class="text-xs font-black text-[#e9422c] group-hover:text-[#ff5a45]"
                        >
                            0{{ index + 1 }}
                        </span>
                    </div>

                    <p
                        class="mt-5 max-w-lg text-sm leading-7 text-stone-600 transition group-hover:text-stone-300"
                    >
                        {{ item.description }}
                    </p>

                    <Link
                        :href="item.href"
                        class="mt-7 inline-flex text-xs font-black uppercase tracking-wide underline decoration-[#ff4f38] decoration-2 underline-offset-8"
                    >
                        {{ item.linkLabel }}
                    </Link>
                </article>
            </div>
        </div>
    </section>

    <!-- Prepare for a visit -->
    <section class="site-section bg-[#f5f3ee]">
        <div
            class="site-container grid gap-12 lg:grid-cols-[0.7fr_1.3fr]"
        >
            <div>
                <p class="eyebrow">
                    Before you visit
                </p>

                <h2 class="mt-5 heading-lg">
                    Arrive ready to take a closer look.
                </h2>

                <p class="mt-6 max-w-md text-base leading-7 text-stone-600">
                    A little preparation can make your dealership visit more
                    useful and efficient.
                </p>
            </div>

            <div class="border-t border-black/15">
                <div
                    v-for="(item, index) in visitChecklist"
                    :key="item"
                    class="grid gap-4 border-b border-black/15 py-6 sm:grid-cols-[70px_1fr]"
                >
                    <span class="text-xs font-black text-[#e9422c]">
                        0{{ index + 1 }}
                    </span>

                    <p class="text-lg font-black">
                        {{ item }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Location -->
    <section class="overflow-hidden bg-white">
        <div class="site-container grid lg:grid-cols-[0.8fr_1.2fr]">
            <div
                class="flex flex-col justify-center py-16 lg:py-24 lg:pr-16"
            >
                <p class="eyebrow">
                    Visit the dealership
                </p>

                <h2 class="mt-5 heading-lg">
                    Find us in<br>
                    East Granby.
                </h2>

                <a
                    :href="site.maps_url"
                    target="_blank"
                    rel="noopener"
                    class="mt-8 max-w-sm text-lg font-black leading-7 transition hover:text-[#e9422c]"
                >
                    {{ site.address }}
                </a>

                <p class="mt-4 text-sm text-stone-500">
                    {{ site.business_hours }}
                </p>

                <div class="mt-8 flex flex-wrap gap-3">
                    <a
                        :href="site.maps_url"
                        target="_blank"
                        rel="noopener"
                        class="btn-primary"
                    >
                        Get directions
                    </a>

                    <Link href="/contact" class="btn-secondary">
                        Contact us
                    </Link>
                </div>
            </div>

            <div class="min-h-[460px] bg-stone-200">
                <iframe
                    :src="site.maps_embed_url"
                    title="Cars For Less dealership location"
                    class="h-full min-h-[460px] w-full border-0 grayscale"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                ></iframe>
            </div>
        </div>
    </section>

    <!-- Final CTA -->
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
                    Ready to see what is available?
                </h2>
            </div>

            <Link
                href="/inventory"
                class="inline-flex min-h-12 shrink-0 items-center justify-center rounded-full bg-[#171717] px-7 py-3 text-xs font-black uppercase tracking-wide text-white transition hover:bg-white hover:text-black"
            >
                Browse inventory
            </Link>
        </div>
    </section>
</template>
