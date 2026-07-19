<script setup>
import {Link, usePage} from '@inertiajs/vue3';
import {computed} from 'vue';
import SeoHead from '@/Components/SeoHead.vue';
import SiteLayout from '@/Layouts/SiteLayout.vue';

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

const page = usePage();

const site = computed(() => page.props.site || {});
const heroVehicle = computed(() => props.featuredVehicles[0] || null);

const homeSchema = computed(() => ({
    '@context': 'https://schema.org',
    '@type': 'AutoDealer',
    name: site.value.name || 'Cars For Less',
    description:
        'Used vehicle sales and automotive service in East Granby, Connecticut.',
    telephone: site.value.phone_tel || '+18604219675',
    email: site.value.email || 'carsforlesseric@gmail.com',
    url: typeof window !== 'undefined' ? window.location.origin : '',
    address: {
        '@type': 'PostalAddress',
        streetAddress: '108a Rainbow Rd',
        addressLocality: site.value.city || 'East Granby',
        addressRegion: site.value.state || 'CT',
        postalCode: site.value.zip || '06026',
        addressCountry: site.value.country || 'USA',
    },
}));

const vehicleCategories = [
    {
        title: 'Cars & Sedans',
        description: 'Comfortable and practical vehicles for everyday driving.',
        href: '/inventory?body_type=sedan',
    },
    {
        title: 'SUVs & Crossovers',
        description: 'Extra room and versatility for families and busy schedules.',
        href: '/inventory?body_type=suv',
    },
    {
        title: 'Pickup Trucks',
        description: 'Capable vehicles for work, hauling, and weekend projects.',
        href: '/inventory?body_type=truck',
    },
];

const buyingSteps = [
    {
        number: '01',
        title: 'Browse online',
        description:
            'Explore current inventory and compare price, mileage, specifications, and photos.',
    },
    {
        number: '02',
        title: 'Talk to our team',
        description:
            'Ask about availability, vehicle condition, financing, service, or your current trade.',
    },
    {
        number: '03',
        title: 'Visit the dealership',
        description:
            'See the vehicle in person and take a closer look before making your decision.',
    },
    {
        number: '04',
        title: 'Drive away',
        description:
            'Review the details, complete the purchase, and leave with a vehicle that works for you.',
    },
];

const serviceItems = [
    'Vehicle availability and condition questions',
    'Current automotive service information',
    'Support after purchasing your vehicle',
];

const visitBg = '/images/visit-bg.webp';
const delivery1 = '/images/delivery/delivery-1.webp';
const delivery2 = '/images/delivery/delivery-2.webp';
const delivery3 = '/images/delivery/delivery-3.webp';
const delivery4 = '/images/delivery/delivery-4.webp';

</script>

<template>
    <SeoHead
        :title="site.name"
        description="Shop used cars, SUVs, and trucks from Cars For Less Sales & Service in East Granby, CT. Browse inventory, explore financing, value your trade, and contact our service team."
        :schema="homeSchema"
    />

    <!-- Hero -->
    <section class="overflow-hidden border-b border-black/10 bg-[#f5f3ee]">
        <div
            class="site-container grid min-h-[720px] items-stretch  lg:grid-cols-[0.9fr_1.1fr]"
        >
            <div
                class="flex flex-col justify-center pb-16 pr-0 lg:pb-24 lg:pr-16 lg:pt-24 pt-20"
            >
                <p class="eyebrow">
                    Used cars in East Granby, CT
                </p>

                <h1
                    class="mt-7 max-w-3xl text-[clamp(3.7rem,5.5vw,6rem)] font-black leading-[0.83] tracking-[-0.075em] text-[#171717]"
                >
                    Find more car.
                    <span class="block text-[#ff4f38]">
                        Keep more money.
                    </span>
                </h1>

                <p class="mt-8 max-w-xl text-lg leading-8 text-stone-600">
                    Shop used cars, SUVs, and trucks with help from a local
                    dealership focused on straightforward answers and practical
                    options.
                </p>

                <div class="mt-9 flex flex-wrap items-center gap-4">
                    <Link href="/inventory" class="btn-primary">
                        Browse inventory
                    </Link>

                    <a
                        :href="`tel:${site.phone_tel}`"
                        class="group flex items-center gap-3 text-sm font-black"
                    >
                        <span
                            class="flex h-12 w-12 items-center justify-center rounded-full border border-black/20 transition group-hover:border-[#ff4f38] group-hover:bg-[#ff4f38] group-hover:text-white"
                        >
                            ↗
                        </span>

                        {{ site.phone }}
                    </a>
                </div>

                <div
                    class="mt-12 grid max-w-xl grid-cols-2 gap-px overflow-hidden border border-black/10 bg-black/10 sm:grid-cols-3"
                >
                    <Link
                        href="/finance"
                        class="bg-white p-4 transition hover:bg-[#ff4f38] hover:text-white"
                    >
                        <span
                            class="block text-[9px] font-black uppercase tracking-[0.16em] opacity-60"
                        >
                            Need financing?
                        </span>

                        <span class="mt-1 block text-sm font-black">
                            Start online
                        </span>
                    </Link>

                    <Link
                        href="/trade-in"
                        class="bg-white p-4 transition hover:bg-[#ff4f38] hover:text-white"
                    >
                        <span
                            class="block text-[9px] font-black uppercase tracking-[0.16em] opacity-60"
                        >
                            Have a vehicle?
                        </span>

                        <span class="mt-1 block text-sm font-black">
                            Value your trade
                        </span>
                    </Link>

                    <Link
                        href="/service"
                        class="col-span-2 bg-white p-4 transition hover:bg-[#ff4f38] hover:text-white sm:col-span-1"
                    >
                        <span
                            class="block text-[9px] font-black uppercase tracking-[0.16em] opacity-60"
                        >
                            Need assistance?
                        </span>

                        <span class="mt-1 block text-sm font-black">
                            Contact service
                        </span>
                    </Link>
                </div>
            </div>

            <div
                class="relative min-h-[480px] overflow-hidden bg-[#ded9cf] lg:min-h-full"
            >
                <img
                    v-if="heroVehicle?.image_medium"
                    :src="heroVehicle.image_medium"
                    :alt="heroVehicle.name"
                    class="absolute inset-0 h-full w-full object-cover"
                >

                <div
                    v-else
                    class="absolute inset-0 bg-[linear-gradient(135deg,#d6d0c5,#f0ede6)]"
                ></div>

                <div
                    class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/5 to-transparent"
                ></div>

                <div
                    class="absolute right-0 top-0 bg-[#ff4f38] px-5 py-3 text-[10px] font-black uppercase tracking-[0.2em] text-white"
                >
                    Cars For Less
                </div>

                <div
                    v-if="heroVehicle"
                    class="absolute inset-x-0 bottom-0 p-7 text-white sm:p-10"
                >
                    <p
                        class="text-[10px] font-black uppercase tracking-[0.24em] text-white/65"
                    >
                        Featured vehicle
                    </p>

                    <div
                        class="mt-3 flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between"
                    >
                        <div>
                            <h2
                                class="text-3xl font-black tracking-[-0.04em] sm:text-4xl"
                            >
                                {{ heroVehicle.name }}
                            </h2>

                            <p class="mt-2 text-sm text-white/70">
                                {{ heroVehicle.mileage }}
                                <span class="mx-2">·</span>
                                {{ heroVehicle.price }}
                            </p>
                        </div>

                        <Link
                            :href="`/inventory/${heroVehicle.slug}`"
                            class="shrink-0 rounded-full bg-white px-6 py-3 text-xs font-black uppercase tracking-wide text-black transition hover:bg-[#ff4f38] hover:text-white"
                        >
                            View details
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Vehicle categories -->
    <section class="bg-[#171717] py-10 text-white">
        <div class="site-container">
            <div class="grid lg:grid-cols-[0.55fr_1.45fr]">
                <div class="flex flex-col justify-center pb-7 lg:pb-0 lg:pr-10">
                    <p
                        class="text-[10px] font-black uppercase tracking-[0.24em] text-[#ff5a45]"
                    >
                        Shop your way
                    </p>

                    <p class="mt-2 text-sm text-stone-400">
                        Start with the body style that fits your life.
                    </p>
                </div>

                <div class="grid border-l border-white/10 md:grid-cols-3">
                    <Link
                        v-for="category in vehicleCategories"
                        :key="category.title"
                        :href="category.href"
                        class="group border-b border-r border-white/10 p-6 transition hover:bg-white/5 md:border-b-0"
                    >
                        <div class="flex items-start justify-between gap-4">
                            <h2 class="text-lg font-black">
                                {{ category.title }}
                            </h2>

                            <span
                                class="text-[#ff5a45] transition group-hover:translate-x-1"
                            >
                                →
                            </span>
                        </div>

                        <p class="mt-3 text-xs leading-5 text-stone-500">
                            {{ category.description }}
                        </p>
                    </Link>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured inventory -->
    <section class="site-section bg-white">
        <div class="site-container">
            <div class="section-header">
                <div>
                    <p class="eyebrow">
                        Available now
                    </p>

                    <h2 class="mt-5 heading-lg">
                        Fresh vehicles on the lot.
                    </h2>
                </div>

                <Link href="/inventory" class="btn-secondary">
                    View all inventory
                </Link>
            </div>

            <div
                v-if="featuredVehicles.length"
                class="grid gap-x-6 gap-y-10 md:grid-cols-2 xl:grid-cols-3"
            >
                <Link
                    v-for="(vehicle, index) in featuredVehicles.slice(0, 6)"
                    :key="vehicle.id"
                    :href="`/inventory/${vehicle.slug}`"
                    class="group"
                >
                    <div
                        class="relative aspect-[4/3] overflow-hidden bg-[#e5e1d8]"
                    >
                        <img
                            v-if="vehicle.image_medium || vehicle.image_thumb"
                            :src="vehicle.image_medium || vehicle.image_thumb"
                            :alt="vehicle.name"
                            class="h-full w-full object-cover transition duration-700 group-hover:scale-[1.04]"
                        >

                        <div
                            v-else
                            class="flex h-full items-center justify-center text-xs font-black uppercase tracking-widest text-stone-400"
                        >
                            Photo coming soon
                        </div>

                        <span
                            class="absolute left-4 top-4 rounded-full bg-white/95 px-3 py-1.5 text-[9px] font-black uppercase tracking-[0.14em] text-black"
                        >
                            {{ index === 0 ? 'Featured' : 'Available' }}
                        </span>
                    </div>

                    <div
                        class="flex items-start justify-between gap-5 border-b border-black/10 py-5"
                    >
                        <div>
                            <p
                                class="text-[10px] font-bold uppercase tracking-[0.18em] text-stone-500"
                            >
                                {{ vehicle.year }} · {{ vehicle.make }}
                            </p>

                            <h3
                                class="mt-2 text-xl font-black tracking-[-0.03em] transition group-hover:text-[#e9422c]"
                            >
                                {{ vehicle.name }}
                            </h3>

                            <p class="mt-2 text-sm text-stone-500">
                                {{ vehicle.mileage }}
                            </p>
                        </div>

                        <p class="shrink-0 text-lg font-black">
                            {{ vehicle.price }}
                        </p>
                    </div>
                </Link>
            </div>

            <div
                v-else
                class="border border-dashed border-black/20 bg-[#f5f3ee] p-12 text-center"
            >
                <h3 class="text-2xl font-black">
                    Inventory is being updated.
                </h3>

                <p class="mt-3 text-stone-600">
                    Call us for the latest vehicles available on the lot.
                </p>

                <a
                    :href="`tel:${site.phone_tel}`"
                    class="btn-primary mt-7"
                >
                    Call the dealership
                </a>
            </div>
        </div>
    </section>

    <!-- Dealership introduction -->
    <section class="overflow-hidden bg-[#f5f3ee]">
        <div class="site-container grid lg:grid-cols-2">
            <div class="relative min-h-[440px] lg:min-h-[650px]">
                <img
                    :src="visitBg"
                    alt="Cars For Less dealership"
                    class="absolute inset-0 h-full w-full object-cover"
                >

                <div
                    class="absolute inset-0 bg-gradient-to-t from-black/45 via-transparent to-white/10"
                ></div>

                <div
                    class="absolute bottom-0 left-0 bg-[#171717] p-6 text-white sm:p-8"
                >
                    <p
                        class="text-[10px] font-black uppercase tracking-[0.2em] text-[#e9422c]"
                    >
                        Local dealership
                    </p>

                    <p class="mt-2 max-w-xs text-lg font-black">
                        Serving drivers from East Granby and surrounding
                        Connecticut communities.
                    </p>
                </div>
            </div>

            <div
                class="flex flex-col justify-center py-16 lg:py-24 lg:pl-16"
            >
                <p class="eyebrow">
                    Why Cars For Less
                </p>

                <h2 class="mt-5 heading-lg">
                    Local people.<br>
                    Practical help.
                </h2>

                <p class="mt-7 max-w-xl text-base leading-8 text-stone-600">
                    Choosing a used vehicle should not feel confusing. Our team
                    helps you review current inventory, ask the right questions,
                    explore financing, and understand the next step.
                </p>

                <div class="mt-9 grid gap-5 sm:grid-cols-2">
                    <div class="border-t border-black/15 pt-5">
                        <p class="text-lg font-black">
                            Current inventory
                        </p>

                        <p class="mt-2 text-sm leading-6 text-stone-600">
                            Review available vehicles with photos, mileage,
                            specifications, and pricing.
                        </p>
                    </div>

                    <div class="border-t border-black/15 pt-5">
                        <p class="text-lg font-black">
                            Direct communication
                        </p>

                        <p class="mt-2 text-sm leading-6 text-stone-600">
                            Call or send a request and speak with the dealership
                            about the vehicle you are considering.
                        </p>
                    </div>
                </div>

                <Link href="/about" class="btn-secondary mt-10 self-start">
                    Meet the dealership
                </Link>
            </div>
        </div>
    </section>

    <!-- Finance -->
    <section class="overflow-hidden bg-white">
        <div class="site-container grid lg:grid-cols-[0.9fr_1.1fr]">
            <div
                class="flex flex-col justify-center py-16 lg:py-24 lg:pr-16"
            >
                <p class="eyebrow">
                    Financing
                </p>

                <h2 class="mt-5 heading-lg">
                    Start before you arrive.
                </h2>

                <p class="mt-7 max-w-xl text-base leading-8 text-stone-600">
                    Share a few details through our online financing form. Our
                    team can review your request and contact you to discuss the
                    available next steps.
                </p>

                <div class="mt-8 flex flex-wrap gap-3">
                    <Link href="/finance" class="btn-primary">
                        Apply for financing
                    </Link>

                    <a
                        :href="`tel:${site.phone_tel}`"
                        class="btn-secondary"
                    >
                        Ask a question
                    </a>
                </div>

                <p class="mt-5 text-xs leading-5 text-stone-500">
                    Submitting a request does not guarantee approval or specific
                    financing terms.
                </p>
            </div>

            <div class="relative min-h-[420px] lg:min-h-[620px]">
                <img
                    :src="delivery2"
                    alt="Vehicle financing at Cars For Less"
                    class="absolute inset-0 h-full w-full object-cover"
                >

                <div
                    class="absolute inset-0 bg-gradient-to-r from-white/20 via-transparent to-black/20"
                ></div>

                <div
                    class="absolute bottom-6 right-6 max-w-xs bg-[#171717] p-6 text-white sm:bottom-10 sm:right-10"
                >
                    <p
                        class="text-[9px] font-black uppercase tracking-[0.2em] text-[#ff5a45]"
                    >
                        Online request
                    </p>

                    <p class="mt-3 text-xl font-black leading-7">
                        Send the basics now. Continue the conversation with our
                        team.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Trade-in -->
    <section class="bg-[#ff4f38] text-white">
        <div
            class="site-container grid gap-10 py-16 lg:grid-cols-[1fr_auto] lg:items-center lg:py-20"
        >
            <div>
                <p
                    class="text-[10px] font-black uppercase tracking-[0.25em] text-white/65"
                >
                    Sell or trade your vehicle
                </p>

                <h2
                    class="mt-4 max-w-4xl text-4xl font-black leading-[0.95] tracking-[-0.055em] sm:text-6xl"
                >
                    Your current car could help you move into the next one.
                </h2>

                <p class="mt-6 max-w-2xl text-base leading-7 text-white/80">
                    Send us the year, make, model, mileage, and condition. We
                    will review the information and contact you.
                </p>
            </div>

            <Link
                href="/trade-in"
                class="inline-flex min-h-14 shrink-0 items-center justify-center rounded-full bg-[#171717] px-8 py-4 text-xs font-black uppercase tracking-wide text-white transition hover:bg-white hover:text-black"
            >
                Tell us about your car
            </Link>
        </div>
    </section>

    <!-- Service -->
    <section class="site-section bg-[#f5f3ee]">
        <div
            class="site-container grid gap-12 lg:grid-cols-[0.85fr_1.15fr] lg:items-center"
        >
            <div class="relative min-h-[440px] overflow-hidden">
                <img
                    :src="delivery3"
                    alt="Automotive service support"
                    class="absolute inset-0 h-full w-full object-cover"
                >

                <div
                    class="absolute inset-0 bg-gradient-to-t from-black/65 via-black/5 to-transparent"
                ></div>

                <div class="absolute inset-x-0 bottom-0 p-7 text-white">
                    <p
                        class="text-[10px] font-black uppercase tracking-[0.22em] text-[#ff6b57]"
                    >
                        Cars For Less Sales & Service
                    </p>

                    <p
                        class="mt-3 max-w-md text-2xl font-black tracking-[-0.03em]"
                    >
                        Support does not have to end when you leave the lot.
                    </p>
                </div>
            </div>

            <div>
                <p class="eyebrow">
                    Automotive service
                </p>

                <h2 class="mt-5 heading-lg">
                    Questions about your vehicle?
                </h2>

                <p class="mt-7 max-w-xl text-base leading-8 text-stone-600">
                    Contact our team to discuss current service availability,
                    vehicle preparation, maintenance questions, or support after
                    your purchase.
                </p>

                <ul class="mt-8 divide-y divide-black/10 border-y border-black/10">
                    <li
                        v-for="item in serviceItems"
                        :key="item"
                        class="flex items-center gap-4 py-4 text-sm font-bold"
                    >
                        <span
                            class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-[#ff4f38] text-[10px] text-white"
                        >
                            ✓
                        </span>

                        {{ item }}
                    </li>
                </ul>

                <div class="mt-9 flex flex-wrap gap-3">
                    <Link href="/service" class="btn-primary">
                        Service information
                    </Link>

                    <a
                        :href="`tel:${site.phone_tel}`"
                        class="btn-secondary"
                    >
                        Call service
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Delivery -->
    <section class="overflow-hidden bg-[#171717] text-white">
        <div class="site-container grid lg:grid-cols-2">
            <div class="flex flex-col justify-center py-16 lg:py-24 lg:pr-16">
                <p
                    class="text-[10px] font-black uppercase tracking-[0.25em] text-[#ff5a45]"
                >
                    Vehicle delivery
                </p>

                <h2
                    class="mt-5 text-5xl font-black leading-[0.92] tracking-[-0.06em] sm:text-6xl"
                >
                    Can’t make the drive?
                </h2>

                <p class="mt-7 max-w-xl text-base leading-8 text-stone-300">
                    Ask whether pickup or delivery options are available for the
                    vehicle you are considering. Availability, timing, distance,
                    and cost may vary.
                </p>

                <Link
                    href="/delivery"
                    class="mt-9 inline-flex self-start rounded-full bg-white px-7 py-4 text-xs font-black uppercase tracking-wide text-black transition hover:bg-[#ff4f38] hover:text-white"
                >
                    Explore delivery
                </Link>
            </div>

            <div class="relative min-h-[420px] lg:min-h-[600px]">
                <img
                    :src="delivery4"
                    alt="Vehicle delivery options"
                    class="absolute inset-0 h-full w-full object-cover"
                >

                <div
                    class="absolute inset-0 bg-gradient-to-r from-[#171717]/35 to-transparent"
                ></div>
            </div>
        </div>
    </section>

    <!-- Buying process -->
    <section class="site-section bg-white">
        <div
            class="site-container grid gap-12 lg:grid-cols-[0.7fr_1.3fr]"
        >
            <div>
                <p class="eyebrow">
                    How it works
                </p>

                <h2 class="mt-5 heading-lg">
                    Four clear steps.
                </h2>

                <p class="mt-7 max-w-md text-base leading-7 text-stone-600">
                    Start online and continue the conversation directly with
                    our dealership.
                </p>
            </div>

            <div class="divide-y divide-black/15 border-y border-black/15">
                <article
                    v-for="step in buyingSteps"
                    :key="step.number"
                    class="grid gap-4 py-8 sm:grid-cols-[70px_1fr_auto] sm:items-start"
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
                            class="mt-3 max-w-xl text-sm leading-6 text-stone-600"
                        >
                            {{ step.description }}
                        </p>
                    </div>

                    <span
                        class="hidden text-xl text-stone-300 sm:block"
                        aria-hidden="true"
                    >
                        ↗
                    </span>
                </article>
            </div>
        </div>
    </section>

    <!-- Reviews -->
    <section
        v-if="reviews.length"
        class="site-section border-t border-black/10 "
    >
        <div class="site-container">
            <div
                class="grid gap-10 lg:grid-cols-[0.6fr_1.4fr]"
            >
                <div>
                    <p class="eyebrow">
                        Customer feedback
                    </p>

                    <h2 class="mt-5 text-4xl font-black tracking-[-0.05em]">
                        What visitors say about us.
                    </h2>

                    <a
                        :href="site.maps_url"
                        target="_blank"
                        rel="noopener"
                        class="btn-secondary mt-8"
                    >
                        View on Google
                    </a>
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    <article
                        v-for="review in reviews.slice(0, 4)"
                        :key="review.id"
                        class="bg-white p-7"
                    >
                        <p
                            class="text-sm tracking-[0.18em] text-[#ff4f38]"
                            :aria-label="`${review.rating} out of 5 stars`"
                        >
                            {{ '★'.repeat(review.rating || 5) }}
                        </p>

                        <p class="mt-5 text-base leading-7 text-stone-700">
                            “{{ review.text }}”
                        </p>

                        <div
                            class="mt-6 flex items-center justify-between gap-4 border-t border-black/10 pt-5"
                        >
                            <p
                                class="text-xs font-black uppercase tracking-[0.14em]"
                            >
                                {{ review.author_name }}
                            </p>

                            <p class="text-xs text-stone-400">
                                {{ review.date }}
                            </p>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <!-- Location -->
    <section class="bg-[#f5f3ee]">
        <div class="site-container grid lg:grid-cols-[0.85fr_1.15fr]">
            <div class="flex flex-col justify-center py-16 lg:py-24 lg:pr-16">
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
                    title="Cars For Less location"
                    class="h-full min-h-[460px] w-full border-0 grayscale"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                ></iframe>
            </div>
        </div>
    </section>
</template>
