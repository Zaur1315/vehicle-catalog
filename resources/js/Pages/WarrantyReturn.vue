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

const warrantyImage = '/images/delivery/delivery-4.webp';
const inspectionImage = '/images/delivery/delivery-3.webp';

const reviewSteps = [
    {
        number: '01',
        title: 'Ask what applies',
        description:
            'Confirm whether the specific vehicle includes any dealer warranty, third-party coverage, or other protection.',
    },
    {
        number: '02',
        title: 'Read the documents',
        description:
            'Review the written terms, covered components, duration, mileage limits, exclusions, and claim process.',
    },
    {
        number: '03',
        title: 'Inspect the vehicle',
        description:
            'Review the vehicle condition, available history, warning lights, features, and current operation.',
    },
    {
        number: '04',
        title: 'Clarify return terms',
        description:
            'Do not assume that a vehicle can be returned. Ask whether any written cancellation or return terms apply.',
    },
];

const warrantyQuestions = [
    'Is any warranty included with this vehicle?',
    'Who provides or administers the coverage?',
    'Which parts and systems are covered?',
    'What exclusions or limitations apply?',
    'Are there time or mileage limits?',
    'Is a deductible required for a claim?',
    'Where can covered repairs be performed?',
    'What maintenance records must be kept?',
];

const buyerChecklist = [
    'Confirm the VIN and current mileage',
    'Review the vehicle description and photographs',
    'Ask about title and available history information',
    'Test available features and equipment',
    'Review all written warranty documents',
    'Ask about return or cancellation terms',
];

const warrantyFaq = [
    {
        question: 'Does every vehicle include a warranty?',
        answer:
            'Warranty availability can vary by vehicle and transaction. Ask the dealership what written coverage, if any, applies to the specific vehicle you are considering.',
    },
    {
        question: 'Can I return a vehicle after purchasing it?',
        answer:
            'Do not assume that a return is available. Any return or cancellation right should be confirmed in writing before completing the purchase.',
    },
    {
        question: 'What does “as is” mean?',
        answer:
            'An “as is” sale generally means the vehicle is sold without a dealer warranty, subject to applicable documents and law. Review all written disclosures and ask questions before purchasing.',
    },
    {
        question: 'Can I purchase additional protection?',
        answer:
            'Ask the dealership whether any optional third-party service contract or protection product is available for the specific vehicle.',
    },
    {
        question: 'Is a service contract the same as a warranty?',
        answer:
            'Not necessarily. A service contract may be a separate optional product with its own provider, cost, covered components, exclusions, and claim requirements.',
    },
    {
        question: 'What should I do if I have a coverage question after purchase?',
        answer:
            'Review the applicable documents and contact the provider or dealership using the instructions included with the coverage.',
    },
];
</script>

<template>
    <SeoHead
        title="Warranty and Vehicle Purchase Information"
        description="Review important warranty, service contract, vehicle condition, and return questions before purchasing a used vehicle from Cars For Less."
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
                        Warranty information
                    </p>

                    <h1
                        class="mt-5 max-w-5xl text-5xl font-black leading-[0.9] tracking-[-0.065em] sm:text-6xl lg:text-7xl"
                    >
                        Understand the terms.<br>

                        <span class="text-[#ff4f38]">
                            Then make your decision.
                        </span>
                    </h1>

                    <p
                        class="mt-6 max-w-3xl text-base leading-7 text-stone-600"
                    >
                        Warranty, service contract, and return conditions can
                        vary. Review the written terms for the specific vehicle
                        before completing a purchase.
                    </p>
                </div>

                <div class="border-l border-black/15 pl-6">
                    <p
                        class="text-[10px] font-black uppercase tracking-[0.2em] text-stone-400"
                    >
                        Have a coverage question?
                    </p>

                    <a
                        :href="`tel:${site.phone_tel}`"
                        class="mt-3 block text-2xl font-black tracking-[-0.03em] transition hover:text-[#e9422c]"
                    >
                        {{ site.phone }}
                    </a>

                    <p class="mt-2 text-sm leading-6 text-stone-500">
                        Have the vehicle name, stock number, or VIN available
                        when contacting the dealership.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Introduction -->
    <section class="overflow-hidden bg-white">
        <div class="site-container grid lg:grid-cols-2">
            <div class="relative min-h-[460px] lg:min-h-[680px]">
                <img
                    :src="warrantyImage"
                    alt="Vehicle warranty and purchase information"
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
                        Before you purchase
                    </p>

                    <p
                        class="mt-3 max-w-lg text-3xl font-black leading-[1.05] tracking-[-0.045em]"
                    >
                        Ask questions and keep copies of the documents that
                        apply to your vehicle.
                    </p>
                </div>
            </div>

            <div
                class="flex flex-col justify-center py-16 lg:py-24 lg:pl-16"
            >
                <p class="eyebrow">
                    Written terms matter
                </p>

                <h2 class="mt-5 heading-lg">
                    Coverage is vehicle-specific.
                </h2>

                <p class="mt-7 max-w-xl text-base leading-8 text-stone-600">
                    A website page cannot replace the actual documents for a
                    vehicle purchase. Coverage may depend on the vehicle,
                    provider, age, mileage, eligibility, and final agreement.
                </p>

                <p class="mt-5 max-w-xl text-base leading-8 text-stone-600">
                    Ask the dealership what applies, request the written
                    information, and review it before signing or paying for
                    the vehicle.
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
        </div>
    </section>

    <!-- Review steps -->
    <section class="site-section bg-[#f5f3ee]">
        <div
            class="site-container grid gap-12 lg:grid-cols-[0.65fr_1.35fr]"
        >
            <div>
                <p class="eyebrow">
                    Before signing
                </p>

                <h2 class="mt-5 heading-lg">
                    Review more than the headline.
                </h2>

                <p class="mt-6 max-w-md text-base leading-7 text-stone-600">
                    A coverage name or duration does not explain everything.
                    The complete written terms determine what applies.
                </p>
            </div>

            <div class="divide-y divide-black/15 border-y border-black/15">
                <article
                    v-for="step in reviewSteps"
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

    <!-- Warranty vs service contract -->
    <section class="site-section bg-white">
        <div class="site-container">
            <div class="section-header">
                <div>
                    <p class="eyebrow">
                        Know the difference
                    </p>

                    <h2 class="mt-5 heading-lg">
                        Warranty and service contract.
                    </h2>
                </div>

                <p class="max-w-md text-sm leading-6 text-stone-500">
                    The provider, price, coverage, exclusions, and claim
                    process may be different.
                </p>
            </div>

            <div class="grid gap-px bg-black/10 md:grid-cols-2">
                <article class="bg-[#f5f3ee] p-7 sm:p-10">
                    <p
                        class="text-[10px] font-black uppercase tracking-[0.2em] text-[#e9422c]"
                    >
                        Warranty
                    </p>

                    <h3
                        class="mt-4 text-3xl font-black tracking-[-0.045em]"
                    >
                        Coverage included under stated terms.
                    </h3>

                    <p class="mt-5 text-sm leading-7 text-stone-600">
                        If a warranty applies, review who provides it, what it
                        covers, its duration, mileage limit, exclusions,
                        deductible, and claim instructions.
                    </p>

                    <p class="mt-4 text-sm leading-7 text-stone-600">
                        Never rely only on a verbal description. Ask for the
                        written warranty information.
                    </p>
                </article>

                <article class="bg-[#171717] p-7 text-white sm:p-10">
                    <p
                        class="text-[10px] font-black uppercase tracking-[0.2em] text-[#ff5a45]"
                    >
                        Service contract
                    </p>

                    <h3
                        class="mt-4 text-3xl font-black tracking-[-0.045em]"
                    >
                        A separate protection product.
                    </h3>

                    <p class="mt-5 text-sm leading-7 text-stone-300">
                        A service contract may be optional and may involve a
                        separate company, price, coverage period, deductible,
                        repair network, and approval process.
                    </p>

                    <p class="mt-4 text-sm leading-7 text-stone-300">
                        Review the complete contract before deciding whether
                        it fits your needs.
                    </p>
                </article>
            </div>
        </div>
    </section>

    <!-- Questions to ask -->
    <section class="site-section bg-[#f5f3ee]">
        <div
            class="site-container grid gap-12 lg:grid-cols-[0.75fr_1.25fr]"
        >
            <div>
                <p class="eyebrow">
                    Coverage checklist
                </p>

                <h2 class="mt-5 heading-lg">
                    Questions worth asking.
                </h2>

                <p class="mt-6 max-w-md text-base leading-7 text-stone-600">
                    Save the answers and compare them with the written
                    documents before purchasing.
                </p>
            </div>

            <div
                class="grid gap-px overflow-hidden border border-black/10 bg-black/10 sm:grid-cols-2"
            >
                <div
                    v-for="(question, index) in warrantyQuestions"
                    :key="question"
                    class="flex items-start gap-4 bg-white p-5"
                >
                    <span
                        class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#171717] text-[10px] font-black text-white"
                    >
                        0{{ index + 1 }}
                    </span>

                    <p class="pt-1 text-sm font-black leading-6">
                        {{ question }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Vehicle inspection -->
    <section class="overflow-hidden bg-[#171717] text-white">
        <div class="site-container grid lg:grid-cols-2">
            <div class="relative min-h-[440px] lg:min-h-[650px]">
                <img
                    :src="inspectionImage"
                    alt="Reviewing a used vehicle before purchase"
                    class="absolute inset-0 h-full w-full object-cover"
                >

                <div
                    class="absolute inset-0 bg-gradient-to-t from-black/65 via-transparent to-transparent"
                ></div>
            </div>

            <div
                class="flex flex-col justify-center py-16 lg:py-24 lg:pl-16"
            >
                <p
                    class="text-[10px] font-black uppercase tracking-[0.25em] text-[#ff5a45]"
                >
                    Vehicle condition
                </p>

                <h2
                    class="mt-5 text-5xl font-black leading-[0.92] tracking-[-0.06em] sm:text-6xl"
                >
                    Coverage does not replace inspection.
                </h2>

                <p class="mt-7 max-w-xl text-base leading-8 text-stone-300">
                    Review the vehicle itself, not only the available warranty
                    or protection options. Check the current condition,
                    operation, warning lights, features, tires, interior, and
                    exterior.
                </p>

                <p class="mt-5 max-w-xl text-sm leading-7 text-stone-400">
                    Ask what vehicle history, preparation, inspection, or
                    maintenance information is available.
                </p>

                <Link
                    href="/inventory"
                    class="mt-9 inline-flex min-h-12 self-start items-center justify-center rounded-full bg-[#ff4f38] px-7 py-3 text-xs font-black uppercase tracking-wide text-white transition hover:bg-white hover:text-black"
                >
                    View available vehicles
                </Link>
            </div>
        </div>
    </section>

    <!-- Buyer checklist -->
    <section class="site-section bg-white">
        <div
            class="site-container grid gap-12 lg:grid-cols-[0.75fr_1.25fr]"
        >
            <div>
                <p class="eyebrow">
                    Buyer checklist
                </p>

                <h2 class="mt-5 heading-lg">
                    Before completing the purchase.
                </h2>

                <p class="mt-6 max-w-md text-base leading-7 text-stone-600">
                    Take time to review the vehicle and the documents that
                    apply to the transaction.
                </p>
            </div>

            <div class="border-t border-black/15">
                <div
                    v-for="(item, index) in buyerChecklist"
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

    <!-- Return information -->
    <section class="bg-[#ff4f38] text-white">
        <div
            class="site-container grid gap-10 py-14 lg:grid-cols-[0.8fr_1.2fr] lg:items-center lg:py-16"
        >
            <div>
                <p
                    class="text-[10px] font-black uppercase tracking-[0.22em] text-white/60"
                >
                    Return information
                </p>

                <h2
                    class="mt-3 text-4xl font-black leading-[0.95] tracking-[-0.05em]"
                >
                    Do not assume a return is available.
                </h2>
            </div>

            <div>
                <p class="max-w-2xl text-sm leading-7 text-white/85">
                    Any return, cancellation, exchange, or cooling-off right
                    should be confirmed in the written purchase documents
                    before the transaction is completed.
                </p>

                <p class="mt-4 max-w-2xl text-sm leading-7 text-white/85">
                    Ask questions before signing and keep copies of all
                    documents provided to you.
                </p>
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
                    Warranty FAQ
                </p>

                <h2 class="mt-5 heading-lg">
                    Common coverage questions.
                </h2>

                <p class="mt-6 max-w-md text-base leading-7 text-stone-600">
                    Contact the dealership for information about a specific
                    vehicle.
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
                    v-for="item in warrantyFaq"
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
                    Ask before purchasing
                </p>

                <h2
                    class="mt-3 text-3xl font-black tracking-[-0.04em]"
                >
                    Need warranty information for a specific vehicle?
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
