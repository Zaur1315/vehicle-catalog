<script setup>
import {Link, useForm, usePage} from '@inertiajs/vue3';
import {computed} from 'vue';
import SeoHead from '@/Components/SeoHead.vue';
import SiteLayout from '@/Layouts/SiteLayout.vue';

defineOptions({
    layout: SiteLayout,
});

const page = usePage();

const site = computed(() => page.props.site || {});

const form = useForm({
    first_name: '',
    last_name: '',
    email: '',
    phone: '',
    make: '',
    model: '',
    year: '',
    mileage: '',
    condition: '',
    vin: '',
    message: '',
});

const submit = () => {
    form.post('/trade-in', {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
    });
};

const scrollToForm = () => {
    document
        .getElementById('trade-in-form')
        ?.scrollIntoView({
            behavior: 'smooth',
            block: 'start',
        });
};

const processSteps = [
    {
        number: '01',
        title: 'Tell us about the vehicle',
        description:
            'Provide the year, make, model, mileage, condition, and VIN if available.',
    },
    {
        number: '02',
        title: 'We review the details',
        description:
            'Our team considers the information, market conditions, and current inventory needs.',
    },
    {
        number: '03',
        title: 'Continue the conversation',
        description:
            'We contact you to ask questions and discuss an in-person vehicle review.',
    },
    {
        number: '04',
        title: 'Receive the final value',
        description:
            'Final value depends on inspection, title status, history, condition, and the final agreement.',
    },
];

const valueFactors = [
    {
        title: 'Mileage',
        description:
            'Current odometer mileage is one of the primary factors in a vehicle review.',
    },
    {
        title: 'Mechanical condition',
        description:
            'Engine, transmission, warning lights, maintenance, and current drivability all matter.',
    },
    {
        title: 'Exterior and interior',
        description:
            'Body damage, paint condition, tires, upholstery, and general wear can affect value.',
    },
    {
        title: 'Title and history',
        description:
            'Title status, ownership records, accidents, and available service history may be reviewed.',
    },
];

const tradeFaq = [
    {
        question: 'Do I need to buy another vehicle?',
        answer:
            'You can submit your vehicle information even if you have not selected another vehicle. Our team will contact you to discuss the available next step.',
    },
    {
        question: 'Is the online request a final offer?',
        answer:
            'No. A final value requires verification of the vehicle, mileage, condition, title, history, and other relevant information.',
    },
    {
        question: 'Can I trade a vehicle that still has a loan?',
        answer:
            'Submit the vehicle details and mention the existing loan in the notes. Additional payoff and lender information may be required.',
    },
    {
        question: 'Where can I find the VIN?',
        answer:
            'The VIN is commonly visible through the windshield on the driver side, on the driver-door label, registration, title, or insurance documents.',
    },
];

const delivery3 = '/images/delivery/delivery-3.webp';

</script>

<template>
    <SeoHead
        title="Sell or Trade Your Vehicle"
        description="Tell Cars For Less Sales & Service about your current vehicle. Submit its make, model, year, mileage, condition, and VIN for review."
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
                        Sell or trade
                    </p>

                    <h1
                        class="mt-5 max-w-5xl text-5xl font-black leading-[0.9] tracking-[-0.065em] sm:text-6xl lg:text-7xl"
                    >
                        Your current vehicle<br>
                        <span class="text-[#ff4f38]">
                            could start the next chapter.
                        </span>
                    </h1>

                    <p
                        class="mt-6 max-w-3xl text-base leading-7 text-stone-600"
                    >
                        Send us the basic details about your car, SUV, or
                        truck. Our team will review the information and
                        contact you about the next step.
                    </p>
                </div>

                <div class="border-l border-black/15 pl-6">
                    <p
                        class="text-[10px] font-black uppercase tracking-[0.2em] text-stone-400"
                    >
                        Prefer to speak first?
                    </p>

                    <a
                        :href="`tel:${site.phone_tel}`"
                        class="mt-3 block text-2xl font-black tracking-[-0.03em] transition hover:text-[#e9422c]"
                    >
                        {{ site.phone }}
                    </a>

                    <p class="mt-2 text-sm leading-6 text-stone-500">
                        Call the dealership before submitting your vehicle
                        information.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Primary CTA strip -->
    <section class="bg-[#171717] py-8 text-white">
        <div
            class="site-container flex flex-col gap-6 md:flex-row md:items-center md:justify-between"
        >
            <div>
                <p
                    class="text-[10px] font-black uppercase tracking-[0.22em] text-[#ff5a45]"
                >
                    Start online
                </p>

                <p class="mt-2 text-lg font-black">
                    Vehicle details are enough to begin.
                </p>
            </div>

            <button
                type="button"
                class="inline-flex min-h-12 items-center justify-center rounded-full bg-[#ff4f38] px-7 py-3 text-xs font-black uppercase tracking-wide text-white transition hover:bg-white hover:text-black"
                @click="scrollToForm"
            >
                Submit your vehicle
            </button>
        </div>
    </section>

    <!-- Form and supporting information -->
    <section class="site-section bg-white">
        <div
            class="site-container grid gap-10 xl:grid-cols-[0.72fr_1.28fr]"
        >
            <aside class="space-y-6 xl:sticky xl:top-32 xl:h-fit">
                <div class="border border-black/10 bg-[#f5f3ee] p-6 sm:p-8">
                    <p class="eyebrow">
                        Before you begin
                    </p>

                    <h2
                        class="mt-5 text-3xl font-black tracking-[-0.045em]"
                    >
                        Accurate details help.
                    </h2>

                    <p class="mt-4 text-sm leading-7 text-stone-600">
                        The online request is an initial review. Give us the
                        most accurate information you currently have.
                    </p>

                    <ul
                        class="mt-7 divide-y divide-black/10 border-y border-black/10"
                    >
                        <li class="flex gap-4 py-4">
                            <span
                                class="font-black text-[#e9422c]"
                            >
                                01
                            </span>

                            <p class="text-sm leading-6 text-stone-600">
                                Check the current odometer mileage.
                            </p>
                        </li>

                        <li class="flex gap-4 py-4">
                            <span
                                class="font-black text-[#e9422c]"
                            >
                                02
                            </span>

                            <p class="text-sm leading-6 text-stone-600">
                                Find the VIN if it is easily available.
                            </p>
                        </li>

                        <li class="flex gap-4 py-4">
                            <span
                                class="font-black text-[#e9422c]"
                            >
                                03
                            </span>

                            <p class="text-sm leading-6 text-stone-600">
                                Mention damage, warning lights, title issues,
                                or an existing loan.
                            </p>
                        </li>
                    </ul>
                </div>

                <div class="border border-black/10 bg-white p-6">
                    <p
                        class="text-[10px] font-black uppercase tracking-[0.2em] text-[#e9422c]"
                    >
                        Looking for your next car?
                    </p>

                    <h2
                        class="mt-3 text-2xl font-black tracking-[-0.035em]"
                    >
                        Browse while we review.
                    </h2>

                    <p class="mt-3 text-sm leading-6 text-stone-600">
                        Explore currently available vehicles and save the
                        details of anything that interests you.
                    </p>

                    <Link
                        href="/inventory"
                        class="btn-secondary mt-6 w-full"
                    >
                        Browse inventory
                    </Link>
                </div>
            </aside>

            <div
                id="trade-in-form"
                class="scroll-mt-32 border border-black/10 bg-[#f5f3ee]"
            >
                <div class="border-b border-black/10 p-6 sm:p-8">
                    <p
                        class="text-[10px] font-black uppercase tracking-[0.2em] text-[#e9422c]"
                    >
                        Vehicle review request
                    </p>

                    <h2
                        class="mt-3 text-3xl font-black tracking-[-0.045em] sm:text-4xl"
                    >
                        Tell us about your vehicle.
                    </h2>

                    <p class="mt-4 max-w-2xl text-sm leading-6 text-stone-600">
                        Fields marked with an asterisk are required. This form
                        is not a guaranteed purchase or trade-in offer.
                    </p>
                </div>

                <form
                    class="p-6 sm:p-8"
                    @submit.prevent="submit"
                >
                    <fieldset>
                        <legend
                            class="text-xs font-black uppercase tracking-[0.16em]"
                        >
                            Your contact information
                        </legend>

                        <div class="mt-5 grid gap-5 md:grid-cols-2">
                            <div>
                                <label
                                    class="mb-2 block text-[10px] font-black uppercase tracking-wider text-stone-500"
                                >
                                    First name *
                                </label>

                                <input
                                    v-model="form.first_name"
                                    required
                                    autocomplete="given-name"
                                    class="form-input-dark"
                                    placeholder="John"
                                >

                                <p
                                    v-if="form.errors.first_name"
                                    class="mt-2 text-xs font-bold text-red-600"
                                >
                                    {{ form.errors.first_name }}
                                </p>
                            </div>

                            <div>
                                <label
                                    class="mb-2 block text-[10px] font-black uppercase tracking-wider text-stone-500"
                                >
                                    Last name
                                </label>

                                <input
                                    v-model="form.last_name"
                                    autocomplete="family-name"
                                    class="form-input-dark"
                                    placeholder="Smith"
                                >

                                <p
                                    v-if="form.errors.last_name"
                                    class="mt-2 text-xs font-bold text-red-600"
                                >
                                    {{ form.errors.last_name }}
                                </p>
                            </div>

                            <div>
                                <label
                                    class="mb-2 block text-[10px] font-black uppercase tracking-wider text-stone-500"
                                >
                                    Phone *
                                </label>

                                <input
                                    v-model="form.phone"
                                    required
                                    type="tel"
                                    autocomplete="tel"
                                    class="form-input-dark"
                                    placeholder="+1 (000) 000-0000"
                                >

                                <p
                                    v-if="form.errors.phone"
                                    class="mt-2 text-xs font-bold text-red-600"
                                >
                                    {{ form.errors.phone }}
                                </p>
                            </div>

                            <div>
                                <label
                                    class="mb-2 block text-[10px] font-black uppercase tracking-wider text-stone-500"
                                >
                                    Email
                                </label>

                                <input
                                    v-model="form.email"
                                    type="email"
                                    autocomplete="email"
                                    class="form-input-dark"
                                    placeholder="john@example.com"
                                >

                                <p
                                    v-if="form.errors.email"
                                    class="mt-2 text-xs font-bold text-red-600"
                                >
                                    {{ form.errors.email }}
                                </p>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="mt-9 border-t border-black/10 pt-8">
                        <legend
                            class="text-xs font-black uppercase tracking-[0.16em]"
                        >
                            Vehicle information
                        </legend>

                        <div class="mt-5 grid gap-5 md:grid-cols-2">
                            <div>
                                <label
                                    class="mb-2 block text-[10px] font-black uppercase tracking-wider text-stone-500"
                                >
                                    Make *
                                </label>

                                <input
                                    v-model="form.make"
                                    required
                                    class="form-input-dark"
                                    placeholder="Toyota"
                                >

                                <p
                                    v-if="form.errors.make"
                                    class="mt-2 text-xs font-bold text-red-600"
                                >
                                    {{ form.errors.make }}
                                </p>
                            </div>

                            <div>
                                <label
                                    class="mb-2 block text-[10px] font-black uppercase tracking-wider text-stone-500"
                                >
                                    Model *
                                </label>

                                <input
                                    v-model="form.model"
                                    required
                                    class="form-input-dark"
                                    placeholder="Camry"
                                >

                                <p
                                    v-if="form.errors.model"
                                    class="mt-2 text-xs font-bold text-red-600"
                                >
                                    {{ form.errors.model }}
                                </p>
                            </div>

                            <div>
                                <label
                                    class="mb-2 block text-[10px] font-black uppercase tracking-wider text-stone-500"
                                >
                                    Year *
                                </label>

                                <input
                                    v-model="form.year"
                                    required
                                    type="number"
                                    min="1900"
                                    max="2100"
                                    class="form-input-dark"
                                    placeholder="2020"
                                >

                                <p
                                    v-if="form.errors.year"
                                    class="mt-2 text-xs font-bold text-red-600"
                                >
                                    {{ form.errors.year }}
                                </p>
                            </div>

                            <div>
                                <label
                                    class="mb-2 block text-[10px] font-black uppercase tracking-wider text-stone-500"
                                >
                                    Mileage *
                                </label>

                                <input
                                    v-model="form.mileage"
                                    required
                                    type="number"
                                    min="0"
                                    class="form-input-dark"
                                    placeholder="45000"
                                >

                                <p
                                    v-if="form.errors.mileage"
                                    class="mt-2 text-xs font-bold text-red-600"
                                >
                                    {{ form.errors.mileage }}
                                </p>
                            </div>

                            <div>
                                <label
                                    class="mb-2 block text-[10px] font-black uppercase tracking-wider text-stone-500"
                                >
                                    Overall condition
                                </label>

                                <select
                                    v-model="form.condition"
                                    class="form-select-dark"
                                >
                                    <option value="">
                                        Select condition
                                    </option>

                                    <option value="excellent">
                                        Excellent
                                    </option>

                                    <option value="good">
                                        Good
                                    </option>

                                    <option value="fair">
                                        Fair
                                    </option>

                                    <option value="poor">
                                        Poor
                                    </option>
                                </select>

                                <p
                                    v-if="form.errors.condition"
                                    class="mt-2 text-xs font-bold text-red-600"
                                >
                                    {{ form.errors.condition }}
                                </p>
                            </div>

                            <div>
                                <label
                                    class="mb-2 block text-[10px] font-black uppercase tracking-wider text-stone-500"
                                >
                                    VIN
                                </label>

                                <input
                                    v-model="form.vin"
                                    maxlength="32"
                                    class="form-input-dark uppercase"
                                    placeholder="Vehicle identification number"
                                >

                                <p
                                    v-if="form.errors.vin"
                                    class="mt-2 text-xs font-bold text-red-600"
                                >
                                    {{ form.errors.vin }}
                                </p>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="mt-9 border-t border-black/10 pt-8">
                        <legend
                            class="text-xs font-black uppercase tracking-[0.16em]"
                        >
                            Vehicle notes
                        </legend>

                        <div class="mt-5">
                            <label
                                class="mb-2 block text-[10px] font-black uppercase tracking-wider text-stone-500"
                            >
                                Anything else we should know?
                            </label>

                            <textarea
                                v-model="form.message"
                                rows="6"
                                class="form-input-dark resize-y"
                                placeholder="Tell us about the title, existing loan, accident history, warning lights, mechanical issues, body damage, recent maintenance, or optional equipment."
                            ></textarea>

                            <p
                                v-if="form.errors.message"
                                class="mt-2 text-xs font-bold text-red-600"
                            >
                                {{ form.errors.message }}
                            </p>
                        </div>
                    </fieldset>

                    <div
                        class="mt-8 flex flex-col gap-5 border-t border-black/10 pt-7 md:flex-row md:items-center md:justify-between"
                    >
                        <p class="max-w-xl text-xs leading-5 text-stone-500">
                            This request is not a final purchase or trade-in
                            offer. Final value depends on inspection, vehicle
                            history, title status, condition, market factors,
                            and the final agreement.
                        </p>

                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="btn-primary shrink-0 md:min-w-56 disabled:cursor-not-allowed disabled:opacity-60"
                        >
                            {{
                                form.processing
                                    ? 'Sending…'
                                    : 'Submit vehicle'
                            }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- How it works -->
    <section class="site-section bg-[#f5f3ee]">
        <div
            class="site-container grid gap-12 lg:grid-cols-[0.65fr_1.35fr]"
        >
            <div>
                <p class="eyebrow">
                    What happens next
                </p>

                <h2 class="mt-5 heading-lg">
                    From online details to final review.
                </h2>

                <p class="mt-6 max-w-md text-base leading-7 text-stone-600">
                    A submitted form gives us a starting point. The final
                    value comes after the relevant information is verified.
                </p>
            </div>

            <div class="divide-y divide-black/15 border-y border-black/15">
                <article
                    v-for="step in processSteps"
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
                            class="mt-3 max-w-xl text-sm leading-6 text-stone-600"
                        >
                            {{ step.description }}
                        </p>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <!-- Value factors -->
    <section class="site-section bg-white">
        <div class="site-container">
            <div class="section-header">
                <div>
                    <p class="eyebrow">
                        Vehicle value
                    </p>

                    <h2 class="mt-5 heading-lg">
                        What can affect the review?
                    </h2>
                </div>

                <p class="max-w-md text-sm leading-6 text-stone-500">
                    No single detail determines the final value. The vehicle
                    is considered as a whole.
                </p>
            </div>

            <div class="grid gap-px bg-black/10 md:grid-cols-2">
                <article
                    v-for="(factor, index) in valueFactors"
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

                    <p class="mt-4 text-sm leading-7 text-stone-600">
                        {{ factor.description }}
                    </p>
                </article>
            </div>
        </div>
    </section>

    <!-- Image and inventory CTA -->
    <section class="overflow-hidden bg-[#171717] text-white">
        <div class="site-container grid lg:grid-cols-2">
            <div class="relative min-h-[420px] lg:min-h-[600px]">
                <img
                    :src="delivery3"
                    alt="Vehicle available from Cars For Less"
                    class="absolute inset-0 h-full w-full object-cover"
                >

                <div
                    class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"
                ></div>
            </div>

            <div class="flex flex-col justify-center py-16 lg:py-24 lg:pl-16">
                <p
                    class="text-[10px] font-black uppercase tracking-[0.25em] text-[#ff5a45]"
                >
                    Make your next move
                </p>

                <h2
                    class="mt-5 text-5xl font-black leading-[0.92] tracking-[-0.06em] sm:text-6xl"
                >
                    Apply your current vehicle toward the next one.
                </h2>

                <p class="mt-7 max-w-xl text-base leading-8 text-stone-300">
                    Browse our current inventory and contact the dealership
                    about combining a vehicle purchase, financing request, and
                    trade-in review.
                </p>

                <div class="mt-9 flex flex-wrap gap-3">
                    <Link
                        href="/inventory"
                        class="inline-flex min-h-12 items-center justify-center rounded-full bg-white px-7 py-3 text-xs font-black uppercase tracking-wide text-black transition hover:bg-[#ff4f38] hover:text-white"
                    >
                        Browse inventory
                    </Link>

                    <Link
                        href="/finance"
                        class="inline-flex min-h-12 items-center justify-center rounded-full border border-white/30 px-7 py-3 text-xs font-black uppercase tracking-wide text-white transition hover:border-white hover:bg-white hover:text-black"
                    >
                        Financing
                    </Link>
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
                    Sell or trade FAQ
                </p>

                <h2 class="mt-5 heading-lg">
                    Common questions.
                </h2>

                <a
                    :href="`tel:${site.phone_tel}`"
                    class="btn-secondary mt-8"
                >
                    Call {{ site.phone }}
                </a>
            </div>

            <div class="border-t border-black/15">
                <details
                    v-for="item in tradeFaq"
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
</template>
