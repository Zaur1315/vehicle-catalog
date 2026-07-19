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
    vehicle_interest: '',
    amount: '',
    down_payment: '',
    term_months: '',
    credit_score_range: '',
    message: '',
});

const estimatedMonthlyPayment = computed(() => {
    const amount = Number(form.amount || 0);
    const downPayment = Number(form.down_payment || 0);
    const termMonths = Number(form.term_months || 0);

    if (amount <= 0 || termMonths <= 0) {
        return null;
    }

    const principal = Math.max(amount - downPayment, 0);

    if (principal <= 0) {
        return '$0';
    }

    const estimatedApr = 0.089;
    const monthlyRate = estimatedApr / 12;

    const payment =
        principal
        * (
            monthlyRate
            * ((1 + monthlyRate) ** termMonths)
        )
        / (
            ((1 + monthlyRate) ** termMonths) - 1
        );

    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        maximumFractionDigits: 0,
    }).format(payment);
});

const estimatedAmountFinanced = computed(() => {
    const amount = Number(form.amount || 0);
    const downPayment = Number(form.down_payment || 0);

    if (amount <= 0) {
        return null;
    }

    const financed = Math.max(amount - downPayment, 0);

    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        maximumFractionDigits: 0,
    }).format(financed);
});

const submit = () => {
    form.post('/finance', {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
    });
};

const financeSteps = [
    {
        number: '01',
        title: 'Choose a vehicle',
        description:
            'Browse our current inventory or tell us what type of vehicle you are looking for.',
    },
    {
        number: '02',
        title: 'Send your request',
        description:
            'Provide your contact details, expected down payment, and preferred financing term.',
    },
    {
        number: '03',
        title: 'Speak with our team',
        description:
            'We will contact you to discuss the request, documentation, and available next steps.',
    },
    {
        number: '04',
        title: 'Review the details',
        description:
            'Final terms depend on the selected vehicle, lender review, documentation, taxes, and fees.',
    },
];

const financeFaq = [
    {
        question: 'Does submitting this form affect my credit score?',
        answer:
            'This website form is a preliminary request for information, not a complete credit application. If a credit check becomes necessary, the dealership or lender should explain it before proceeding.',
    },
    {
        question: 'Can I submit a request before choosing a vehicle?',
        answer:
            'Yes. You can leave the vehicle field open or describe the type of car, SUV, or truck you are considering.',
    },
    {
        question: 'Can I include a trade-in?',
        answer:
            'Yes. Submit the finance request first, then use our Sell Your Car page to provide information about your current vehicle.',
    },
    {
        question: 'Is the calculated monthly payment guaranteed?',
        answer:
            'No. The calculator provides a general estimate using a sample APR. Actual payments depend on approval, rate, term, taxes, fees, and other factors.',
    },
];

const delivery2 = '/images/delivery/delivery-2.webp';

</script>

<template>
    <SeoHead
        title="Vehicle Financing"
        description="Start a vehicle financing request with Cars For Less Sales & Service in East Granby, CT. Estimate a payment and send your information online."
    />

    <!-- Light page banner -->
    <section class="border-b border-black/10 bg-[#f5f3ee]">
        <div
            class="site-container pb-12 pt-12 lg:pb-16 lg:pt-16"
        >
            <div
                class="grid gap-8 lg:grid-cols-[1fr_380px] lg:items-end"
            >
                <div>
                    <p class="eyebrow">
                        Vehicle financing
                    </p>

                    <h1
                        class="mt-5 max-w-5xl text-5xl font-black leading-[0.9] tracking-[-0.065em] sm:text-6xl lg:text-7xl"
                    >
                        Start with a vehicle.<br>
                        <span class="text-[#ff4f38]">
                            Build a clear next step.
                        </span>
                    </h1>

                    <p
                        class="mt-6 max-w-3xl text-base leading-7 text-stone-600"
                    >
                        Send a preliminary financing request before visiting
                        the dealership. Our team will contact you to discuss
                        the vehicle, documentation, and available options.
                    </p>
                </div>

                <div class="border-l border-black/15 pl-6">
                    <p
                        class="text-[10px] font-black uppercase tracking-[0.2em] text-stone-400"
                    >
                        Have questions?
                    </p>

                    <a
                        :href="`tel:${site.phone_tel}`"
                        class="mt-3 block text-2xl font-black tracking-[-0.03em] transition hover:text-[#e9422c]"
                    >
                        {{ site.phone }}
                    </a>

                    <p class="mt-2 text-sm leading-6 text-stone-500">
                        Speak directly with the dealership before submitting
                        your request.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Intro strip -->
    <section class="bg-[#171717] py-8 text-white">
        <div
            class="site-container grid gap-6 sm:grid-cols-3"
        >
            <div class="border-white/10 sm:border-r sm:pr-6">
                <p
                    class="text-[9px] font-black uppercase tracking-[0.2em] text-[#ff5a45]"
                >
                    Step one
                </p>

                <p class="mt-2 text-sm font-black">
                    Choose a vehicle or describe what you need.
                </p>
            </div>

            <div class="border-white/10 sm:border-r sm:px-6">
                <p
                    class="text-[9px] font-black uppercase tracking-[0.2em] text-[#ff5a45]"
                >
                    Step two
                </p>

                <p class="mt-2 text-sm font-black">
                    Send your preliminary information securely.
                </p>
            </div>

            <div class="sm:pl-6">
                <p
                    class="text-[9px] font-black uppercase tracking-[0.2em] text-[#ff5a45]"
                >
                    Step three
                </p>

                <p class="mt-2 text-sm font-black">
                    Continue the conversation with our team.
                </p>
            </div>
        </div>
    </section>

    <!-- Calculator and finance form -->
    <section class="site-section bg-white">
        <div
            class="site-container grid gap-10 xl:grid-cols-[0.78fr_1.22fr]"
        >
            <!-- Payment calculator -->
            <aside class="space-y-6 xl:sticky xl:top-32 xl:h-fit">
                <div class="border border-black/10 bg-[#f5f3ee] p-6 sm:p-8">
                    <p class="eyebrow">
                        Payment calculator
                    </p>

                    <h2
                        class="mt-5 text-3xl font-black tracking-[-0.045em]"
                    >
                        Build a rough estimate.
                    </h2>

                    <p class="mt-4 text-sm leading-6 text-stone-600">
                        Enter the estimated vehicle price, down payment, and
                        term in the form. The calculator will update
                        automatically.
                    </p>

                    <div
                        class="mt-7 border border-black/10 bg-white p-6"
                    >
                        <p
                            class="text-[9px] font-black uppercase tracking-[0.2em] text-stone-400"
                        >
                            Estimated monthly payment
                        </p>

                        <p
                            class="mt-3 text-5xl font-black tracking-[-0.06em] text-[#ff4f38]"
                        >
                            {{ estimatedMonthlyPayment || '—' }}
                        </p>

                        <div
                            class="mt-6 grid grid-cols-2 divide-x divide-black/10 border-t border-black/10 pt-5"
                        >
                            <div class="pr-4">
                                <p
                                    class="text-[9px] font-black uppercase tracking-wider text-stone-400"
                                >
                                    Amount financed
                                </p>

                                <p class="mt-2 font-black">
                                    {{ estimatedAmountFinanced || '—' }}
                                </p>
                            </div>

                            <div class="pl-4">
                                <p
                                    class="text-[9px] font-black uppercase tracking-wider text-stone-400"
                                >
                                    Example APR
                                </p>

                                <p class="mt-2 font-black">
                                    8.9%
                                </p>
                            </div>
                        </div>
                    </div>

                    <p class="mt-5 text-xs leading-5 text-stone-500">
                        This estimate uses a sample APR for illustration only.
                        It is not a financing offer, approval, or guaranteed
                        payment.
                    </p>
                </div>

                <div class="border border-black/10 bg-white p-6">
                    <p
                        class="text-[10px] font-black uppercase tracking-[0.2em] text-[#e9422c]"
                    >
                        Before you begin
                    </p>

                    <ul class="mt-5 space-y-4">
                        <li class="flex gap-4">
                            <span
                                class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-[#171717] text-[10px] font-black text-white"
                            >
                                1
                            </span>

                            <p class="text-sm leading-6 text-stone-600">
                                Have a vehicle or general price range in mind.
                            </p>
                        </li>

                        <li class="flex gap-4">
                            <span
                                class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-[#171717] text-[10px] font-black text-white"
                            >
                                2
                            </span>

                            <p class="text-sm leading-6 text-stone-600">
                                Add a working phone number so our team can
                                contact you.
                            </p>
                        </li>

                        <li class="flex gap-4">
                            <span
                                class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-[#171717] text-[10px] font-black text-white"
                            >
                                3
                            </span>

                            <p class="text-sm leading-6 text-stone-600">
                                Use estimates if you do not know the exact
                                down payment or term.
                            </p>
                        </li>
                    </ul>
                </div>
            </aside>

            <!-- Form -->
            <div class="border border-black/10 bg-[#f5f3ee]">
                <div class="border-b border-black/10 p-6 sm:p-8">
                    <p
                        class="text-[10px] font-black uppercase tracking-[0.2em] text-[#e9422c]"
                    >
                        Preliminary request
                    </p>

                    <h2
                        class="mt-3 text-3xl font-black tracking-[-0.045em] sm:text-4xl"
                    >
                        Tell us what you’re looking for.
                    </h2>

                    <p class="mt-4 max-w-2xl text-sm leading-6 text-stone-600">
                        Fields marked with an asterisk are required. This form
                        does not reserve a vehicle or guarantee financing.
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
                            Contact information
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
                            Vehicle and payment
                        </legend>

                        <div class="mt-5">
                            <label
                                class="mb-2 block text-[10px] font-black uppercase tracking-wider text-stone-500"
                            >
                                Vehicle interest
                            </label>

                            <input
                                v-model="form.vehicle_interest"
                                class="form-input-dark"
                                placeholder="Vehicle name, model, or stock number"
                            >

                            <p
                                v-if="form.errors.vehicle_interest"
                                class="mt-2 text-xs font-bold text-red-600"
                            >
                                {{ form.errors.vehicle_interest }}
                            </p>
                        </div>

                        <div class="mt-5 grid gap-5 md:grid-cols-3">
                            <div>
                                <label
                                    class="mb-2 block text-[10px] font-black uppercase tracking-wider text-stone-500"
                                >
                                    Vehicle price
                                </label>

                                <div class="relative">
                                    <span
                                        class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-sm font-black text-stone-400"
                                    >
                                        $
                                    </span>

                                    <input
                                        v-model="form.amount"
                                        type="number"
                                        min="0"
                                        class="form-input-dark !pl-8"
                                        placeholder="25000"
                                    >
                                </div>

                                <p
                                    v-if="form.errors.amount"
                                    class="mt-2 text-xs font-bold text-red-600"
                                >
                                    {{ form.errors.amount }}
                                </p>
                            </div>

                            <div>
                                <label
                                    class="mb-2 block text-[10px] font-black uppercase tracking-wider text-stone-500"
                                >
                                    Down payment
                                </label>

                                <div class="relative">
                                    <span
                                        class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-sm font-black text-stone-400"
                                    >
                                        $
                                    </span>

                                    <input
                                        v-model="form.down_payment"
                                        type="number"
                                        min="0"
                                        class="form-input-dark !pl-8"
                                        placeholder="3000"
                                    >
                                </div>

                                <p
                                    v-if="form.errors.down_payment"
                                    class="mt-2 text-xs font-bold text-red-600"
                                >
                                    {{ form.errors.down_payment }}
                                </p>
                            </div>

                            <div>
                                <label
                                    class="mb-2 block text-[10px] font-black uppercase tracking-wider text-stone-500"
                                >
                                    Preferred term
                                </label>

                                <select
                                    v-model="form.term_months"
                                    class="form-select-dark"
                                >
                                    <option value="">
                                        Select term
                                    </option>

                                    <option value="24">
                                        24 months
                                    </option>

                                    <option value="36">
                                        36 months
                                    </option>

                                    <option value="48">
                                        48 months
                                    </option>

                                    <option value="60">
                                        60 months
                                    </option>

                                    <option value="72">
                                        72 months
                                    </option>

                                    <option value="84">
                                        84 months
                                    </option>
                                </select>

                                <p
                                    v-if="form.errors.term_months"
                                    class="mt-2 text-xs font-bold text-red-600"
                                >
                                    {{ form.errors.term_months }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-5">
                            <label
                                class="mb-2 block text-[10px] font-black uppercase tracking-wider text-stone-500"
                            >
                                Estimated credit range
                            </label>

                            <select
                                v-model="form.credit_score_range"
                                class="form-select-dark"
                            >
                                <option value="">
                                    Select a range
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

                                <option value="unknown">
                                    Not sure
                                </option>
                            </select>

                            <p
                                v-if="form.errors.credit_score_range"
                                class="mt-2 text-xs font-bold text-red-600"
                            >
                                {{ form.errors.credit_score_range }}
                            </p>
                        </div>
                    </fieldset>

                    <fieldset class="mt-9 border-t border-black/10 pt-8">
                        <legend
                            class="text-xs font-black uppercase tracking-[0.16em]"
                        >
                            Additional information
                        </legend>

                        <div class="mt-5">
                            <label
                                class="mb-2 block text-[10px] font-black uppercase tracking-wider text-stone-500"
                            >
                                Questions or comments
                            </label>

                            <textarea
                                v-model="form.message"
                                rows="5"
                                class="form-input-dark resize-y"
                                placeholder="Tell us about the vehicle or financing options you are considering."
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
                            This form is a request for information and not a
                            credit application or approval. Final terms depend
                            on lender review, documentation, taxes, fees,
                            vehicle details, and buyer qualification.
                        </p>

                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="btn-primary shrink-0 md:min-w-56 disabled:cursor-not-allowed disabled:opacity-60"
                        >
                            {{
                                form.processing
                                    ? 'Sending…'
                                    : 'Submit request'
                            }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Finance process -->
    <section class="site-section bg-[#f5f3ee]">
        <div
            class="site-container grid gap-12 lg:grid-cols-[0.65fr_1.35fr]"
        >
            <div>
                <p class="eyebrow">
                    What happens next
                </p>

                <h2 class="mt-5 heading-lg">
                    A straightforward process.
                </h2>

                <p class="mt-6 max-w-md text-base leading-7 text-stone-600">
                    Start online, then work directly with the dealership to
                    review the details.
                </p>
            </div>

            <div class="divide-y divide-black/15 border-y border-black/15">
                <article
                    v-for="step in financeSteps"
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

    <!-- Inventory image section -->
    <section class="overflow-hidden bg-white">
        <div class="site-container grid lg:grid-cols-2">
            <div class="relative min-h-[420px] lg:min-h-[600px]">
                <img
                    :src="delivery2"
                    alt="Vehicle available from Cars For Less"
                    class="absolute inset-0 h-full w-full object-cover"
                >

                <div
                    class="absolute inset-0 bg-gradient-to-t from-black/55 via-transparent to-transparent"
                ></div>

                <p
                    class="absolute bottom-7 left-7 max-w-sm text-2xl font-black tracking-[-0.04em] text-white sm:bottom-10 sm:left-10"
                >
                    Find the vehicle first, then build your request around it.
                </p>
            </div>

            <div class="flex flex-col justify-center py-16 lg:py-24 lg:pl-16">
                <p class="eyebrow">
                    Shop before applying
                </p>

                <h2 class="mt-5 heading-lg">
                    Financing starts with the right vehicle.
                </h2>

                <p class="mt-7 max-w-xl text-base leading-8 text-stone-600">
                    Browse our available vehicles and review the price,
                    mileage, photos, and specifications. You can then submit
                    an inquiry directly from the vehicle page.
                </p>

                <div class="mt-9 flex flex-wrap gap-3">
                    <Link href="/inventory" class="btn-primary">
                        Browse inventory
                    </Link>

                    <Link href="/trade-in" class="btn-secondary">
                        Value your trade
                    </Link>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="site-section bg-[#f5f3ee]">
        <div
            class="site-container grid gap-12 lg:grid-cols-[0.65fr_1.35fr]"
        >
            <div>
                <p class="eyebrow">
                    Financing FAQ
                </p>

                <h2 class="mt-5 heading-lg">
                    Common questions.
                </h2>

                <p class="mt-6 max-w-md text-base leading-7 text-stone-600">
                    Need help with something not covered here? Call the
                    dealership and speak with our team.
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
                    v-for="item in financeFaq"
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
    <section class="bg-[#ff4f38] py-14 text-white">
        <div
            class="site-container flex flex-col gap-7 md:flex-row md:items-center md:justify-between"
        >
            <div>
                <p
                    class="text-[10px] font-black uppercase tracking-[0.22em] text-white/60"
                >
                    Ready to start?
                </p>

                <h2
                    class="mt-3 text-3xl font-black tracking-[-0.04em]"
                >
                    Send your preliminary financing request.
                </h2>
            </div>

            <button
                type="button"
                class="inline-flex min-h-12 shrink-0 items-center justify-center rounded-full bg-[#171717] px-7 py-3 text-xs font-black uppercase tracking-wide text-white transition hover:bg-white hover:text-black"
                @click="window.scrollTo({
                    top: 520,
                    behavior: 'smooth',
                })"
            >
                Return to the form
            </button>
        </div>
    </section>
</template>
