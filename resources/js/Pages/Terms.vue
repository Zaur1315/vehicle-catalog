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

const lastUpdated = 'July 20, 2026';

const termsSections = computed(() => [
    {
        id: 'acceptance',
        number: '01',
        title: 'Acceptance of these terms',
        paragraphs: [
            `These Terms of Use govern your access to and use of the ${site.value.name || 'Cars For Less'} website. By accessing or using the website, you acknowledge these terms.`,
            'If you do not agree with these terms, do not use the website or submit information through its forms.',
            'These website terms do not replace the written documents for a vehicle sale, financing arrangement, trade-in, delivery, warranty, service contract, or other transaction.',
        ],
    },
    {
        id: 'use-of-site',
        number: '02',
        title: 'Permitted use of the website',
        paragraphs: [
            'The website is provided to help visitors browse vehicle inventory, review dealership information, submit inquiries, request preliminary financing information, provide trade-in information, and contact the dealership.',
            'You may use the website only for lawful personal or business purposes consistent with its intended functionality.',
        ],
        bullets: [
            'Do not submit false, misleading, fraudulent, or unauthorized information.',
            'Do not interfere with website security or operation.',
            'Do not attempt unauthorized access to accounts, servers, databases, or administrative systems.',
            'Do not upload malicious code or use automated tools to overload the website.',
            'Do not copy or scrape website content for unauthorized commercial use.',
            'Do not impersonate another person or submit information without authorization.',
        ],
    },
    {
        id: 'vehicle-information',
        number: '03',
        title: 'Vehicle listings and information',
        paragraphs: [
            'Vehicle listings may include make, model, year, mileage, VIN, stock number, condition, photographs, features, descriptions, price, and other information.',
            'We make reasonable efforts to present useful information, but listing errors, omissions, delays, changes, and differences may occur.',
            'Photographs may not show every detail or current condition. Colors and appearance may vary because of lighting, camera settings, screen settings, vehicle preparation, and other factors.',
            'Confirm the vehicle identity, condition, mileage, equipment, features, options, title information, history, and other material details directly with the dealership before purchasing.',
        ],
    },
    {
        id: 'pricing-and-availability',
        number: '04',
        title: 'Pricing and availability',
        paragraphs: [
            'Vehicle prices and availability are subject to confirmation and may change without notice.',
            'A vehicle displayed online may already be sold, reserved, pending, unavailable, or incorrectly listed.',
            'Unless expressly confirmed in a signed written agreement, a website listing does not create a binding offer, reservation, purchase contract, price guarantee, or guarantee of availability.',
            'Displayed prices may not include taxes, registration, title charges, government fees, documentation charges, optional products, financing costs, transportation, delivery, or other applicable amounts. Request a complete explanation of the transaction before purchasing.',
        ],
    },
    {
        id: 'forms-and-communications',
        number: '05',
        title: 'Forms and communications',
        paragraphs: [
            'Submitting a contact form, vehicle inquiry, finance request, or trade-in request authorizes the dealership to respond using the contact information you provide.',
            'Form submission does not create a vehicle reservation, sale, financing approval, trade-in offer, service appointment, delivery agreement, warranty, or other contract.',
            'You are responsible for providing accurate and authorized information. Incomplete or inaccurate information may delay a response or affect any preliminary review.',
            'Website and email communications should not be used to send Social Security numbers, payment card information, bank account credentials, driver’s license images, or other highly sensitive information unless an appropriate secure process is provided.',
        ],
    },
    {
        id: 'financing',
        number: '06',
        title: 'Financing information',
        paragraphs: [
            'Financing information and payment estimates displayed on the website are provided for general informational and planning purposes.',
            'A calculator result is not a credit offer, loan approval, lender commitment, final interest rate, or guaranteed payment.',
            'Actual terms may depend on the selected vehicle, buyer qualification, credit information, lender requirements, down payment, APR, loan term, taxes, fees, optional products, documentation, and other factors.',
            'Submitting a preliminary financing form does not guarantee approval. Additional applications, notices, disclosures, identity verification, and documentation may be required.',
        ],
    },
    {
        id: 'trade-in',
        number: '07',
        title: 'Sell and trade-in information',
        paragraphs: [
            'Online trade-in submissions and discussions are preliminary unless confirmed in a signed written agreement.',
            'A final value may depend on physical inspection, mileage verification, title status, ownership, liens, payoff amount, history, condition, equipment, market conditions, and the final transaction.',
            'Submitting vehicle information does not require the dealership to purchase the vehicle or accept it as a trade-in.',
            'You are responsible for providing accurate information and disclosing known title, ownership, condition, damage, and payoff details.',
        ],
    },
    {
        id: 'delivery',
        number: '08',
        title: 'Vehicle pickup and delivery',
        paragraphs: [
            'Pickup and delivery availability must be confirmed for the specific vehicle and destination.',
            'Transport timing and cost may depend on distance, route, vehicle size, vehicle condition, destination access, transporter availability, weather, payment completion, documentation, and other circumstances.',
            'Any delivery date provided before final scheduling is an estimate unless expressly guaranteed in a signed written agreement.',
            'Review the vehicle condition and applicable transport documentation at pickup and delivery. Report concerns through the process described in the transport or transaction documents.',
        ],
    },
    {
        id: 'warranty-and-returns',
        number: '09',
        title: 'Warranty, service contracts, and returns',
        paragraphs: [
            'Warranty and service contract availability can vary by vehicle and transaction. Website summaries do not replace the actual written coverage documents.',
            'Review the provider, covered components, duration, mileage limits, deductible, exclusions, maintenance obligations, repair network, and claim procedure before purchasing coverage.',
            'Do not assume that a vehicle can be returned, exchanged, or cancelled after purchase. Any return or cancellation right should be confirmed in the signed purchase documents.',
            'If a vehicle is offered “as is,” review the applicable disclosure carefully and ask questions before completing the purchase.',
        ],
    },
    {
        id: 'service',
        number: '10',
        title: 'Automotive service information',
        paragraphs: [
            'Service availability, timing, scope, diagnosis, pricing, parts, and completion estimates must be confirmed directly with the dealership.',
            'Website content is not mechanical advice and should not be used as a substitute for an appropriate vehicle inspection or diagnosis.',
            'Contact the dealership before bringing in a vehicle. Submission of a contact form does not create a service appointment.',
        ],
    },
    {
        id: 'third-parties',
        number: '11',
        title: 'Third-party services and links',
        paragraphs: [
            'The website may display, embed, or link to services operated by other companies, including maps, analytics, advertising, email, transportation, financing, warranty, and social media services.',
            'Third-party services are governed by their own terms, policies, availability, and practices. A link or integration does not necessarily constitute an endorsement or guarantee.',
            `${site.value.name || 'Cars For Less'} is not responsible for the content, security, availability, or practices of independently operated third-party websites and services.`,
        ],
    },
    {
        id: 'intellectual-property',
        number: '12',
        title: 'Website content and intellectual property',
        paragraphs: [
            'The website design, branding, text, graphics, software, and other original content may be protected by copyright, trademark, and other applicable laws.',
            'Vehicle photographs and listing information may also be owned or licensed by the dealership, seller, photographer, platform, or another rights holder.',
            'You may view and use the website for its intended purpose. You may not reproduce, republish, sell, modify, distribute, or commercially exploit protected content without permission from the applicable rights holder.',
        ],
    },
    {
        id: 'availability-and-liability',
        number: '13',
        title: 'Website availability and limitation of liability',
        paragraphs: [
            'The website is provided on an “as available” basis. We do not guarantee uninterrupted operation, complete security, freedom from errors, or that all information will always be current.',
            'To the maximum extent permitted by applicable law, the dealership is not liable for indirect, incidental, special, consequential, or punitive damages arising solely from website use, technical failures, third-party services, or reliance on information that was not confirmed in writing.',
            'Nothing in these terms excludes or limits liability or consumer rights that cannot lawfully be excluded or limited.',
        ],
    },
    {
        id: 'indemnity',
        number: '14',
        title: 'Responsibility for misuse',
        paragraphs: [
            'To the extent permitted by applicable law, you are responsible for losses or claims arising from your unlawful misuse of the website, violation of these terms, infringement of another person’s rights, or submission of information without authorization.',
        ],
    },
    {
        id: 'changes-and-law',
        number: '15',
        title: 'Changes, severability, and applicable law',
        paragraphs: [
            'These terms may be updated to reflect changes to the website, dealership practices, services, or legal requirements. The revised terms will be posted on this page with an updated date.',
            'If a provision of these terms is found unenforceable, the remaining provisions will continue to apply to the extent permitted by law.',
            'These terms are governed by applicable federal law and the laws of the State of Connecticut, without limiting any mandatory rights or protections that apply under other law.',
        ],
    },
]);

const navigationSections = computed(() => {
    return termsSections.value.map((section) => ({
        id: section.id,
        number: section.number,
        title: section.title,
    }));
});
</script>

<template>
    <SeoHead
        title="Website Terms of Use"
        description="Read the Cars For Less website terms covering vehicle listings, pricing, availability, financing, trade-ins, delivery, warranty information, and website use."
    />

    <!-- Light banner -->
    <section class="border-b border-black/10 bg-[#f5f3ee]">
        <div
            class="site-container pb-12 pt-12 lg:pb-16 lg:pt-16"
        >
            <div
                class="grid gap-8 lg:grid-cols-[1fr_340px] lg:items-end"
            >
                <div>
                    <p class="eyebrow">
                        Legal information
                    </p>

                    <h1
                        class="mt-5 max-w-5xl text-5xl font-black leading-[0.9] tracking-[-0.065em] sm:text-6xl lg:text-7xl"
                    >
                        Website Terms of Use.
                    </h1>

                    <p
                        class="mt-6 max-w-3xl text-base leading-7 text-stone-600"
                    >
                        These terms explain how the website may be used and
                        how online vehicle, financing, trade-in, delivery,
                        warranty, and service information should be
                        understood.
                    </p>
                </div>

                <div class="border-l border-black/15 pl-6">
                    <p
                        class="text-[10px] font-black uppercase tracking-[0.2em] text-stone-400"
                    >
                        Last updated
                    </p>

                    <p
                        class="mt-3 text-xl font-black tracking-[-0.03em]"
                    >
                        {{ lastUpdated }}
                    </p>

                    <p class="mt-2 text-sm leading-6 text-stone-500">
                        Confirm all material vehicle and transaction details
                        directly with the dealership.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Important notice -->
    <section class="bg-[#171717] py-8 text-white">
        <div
            class="site-container flex flex-col gap-5 md:flex-row md:items-center md:justify-between"
        >
            <div>
                <p
                    class="text-[10px] font-black uppercase tracking-[0.2em] text-[#ff5a45]"
                >
                    Important
                </p>

                <p class="mt-2 max-w-3xl text-sm font-bold leading-6">
                    Website content is informational. Signed transaction
                    documents control if they conflict with a website summary.
                </p>
            </div>

            <Link
                href="/contact"
                class="shrink-0 text-xs font-black uppercase tracking-wide underline decoration-[#ff4f38] decoration-2 underline-offset-8"
            >
                Contact the dealership
            </Link>
        </div>
    </section>

    <!-- Terms -->
    <section class="site-section bg-white">
        <div
            class="site-container grid gap-10 lg:grid-cols-[280px_1fr] xl:grid-cols-[320px_1fr]"
        >
            <!-- Navigation -->
            <aside class="h-fit lg:sticky lg:top-32">
                <div class="border border-black/10 bg-[#f5f3ee] p-6">
                    <p
                        class="text-[10px] font-black uppercase tracking-[0.2em] text-[#e9422c]"
                    >
                        Terms sections
                    </p>

                    <nav class="mt-5 max-h-[65vh] overflow-y-auto pr-2">
                        <a
                            v-for="section in navigationSections"
                            :key="section.id"
                            :href="`#${section.id}`"
                            class="group flex items-start gap-3 border-b border-black/10 py-3 text-sm font-bold leading-5 transition last:border-b-0 hover:text-[#e9422c]"
                        >
                            <span
                                class="mt-0.5 shrink-0 text-[9px] font-black text-stone-400 group-hover:text-[#e9422c]"
                            >
                                {{ section.number }}
                            </span>

                            {{ section.title }}
                        </a>
                    </nav>
                </div>

                <div class="mt-5 border border-black/10 bg-white p-6">
                    <p
                        class="text-[10px] font-black uppercase tracking-[0.2em] text-stone-400"
                    >
                        Need confirmation?
                    </p>

                    <a
                        :href="`tel:${site.phone_tel}`"
                        class="mt-3 block text-lg font-black transition hover:text-[#e9422c]"
                    >
                        {{ site.phone }}
                    </a>

                    <a
                        :href="`mailto:${site.email}`"
                        class="mt-2 block break-all text-sm font-bold text-stone-500 transition hover:text-[#e9422c]"
                    >
                        {{ site.email }}
                    </a>
                </div>
            </aside>

            <!-- Sections -->
            <div class="min-w-0">
                <section
                    v-for="section in termsSections"
                    :id="section.id"
                    :key="section.id"
                    class="scroll-mt-32 border-t border-black/15 py-10 first:pt-0"
                >
                    <div class="grid gap-6 md:grid-cols-[70px_1fr]">
                        <p class="text-xs font-black text-[#e9422c]">
                            {{ section.number }}
                        </p>

                        <div>
                            <h2
                                class="text-3xl font-black tracking-[-0.045em]"
                            >
                                {{ section.title }}
                            </h2>

                            <div
                                class="mt-5 space-y-4 text-sm leading-7 text-stone-600"
                            >
                                <p
                                    v-for="paragraph in section.paragraphs"
                                    :key="paragraph"
                                >
                                    {{ paragraph }}
                                </p>

                                <ul
                                    v-if="section.bullets?.length"
                                    class="space-y-2 pl-5"
                                >
                                    <li
                                        v-for="bullet in section.bullets"
                                        :key="bullet"
                                        class="list-disc"
                                    >
                                        {{ bullet }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Contact -->
                <section
                    id="contact-terms"
                    class="scroll-mt-32 border-y border-black/15 py-10"
                >
                    <div class="grid gap-6 md:grid-cols-[70px_1fr]">
                        <p class="text-xs font-black text-[#e9422c]">
                            16
                        </p>

                        <div>
                            <h2
                                class="text-3xl font-black tracking-[-0.045em]"
                            >
                                Contact us
                            </h2>

                            <p
                                class="mt-5 max-w-2xl text-sm leading-7 text-stone-600"
                            >
                                Contact the dealership if you have questions
                                about these terms or need confirmation about a
                                vehicle, price, financing request, trade-in,
                                delivery, warranty, or service information.
                            </p>

                            <div
                                class="mt-6 grid gap-px overflow-hidden border border-black/10 bg-black/10 sm:grid-cols-2"
                            >
                                <div class="bg-[#f5f3ee] p-5">
                                    <p
                                        class="text-[9px] font-black uppercase tracking-[0.18em] text-stone-400"
                                    >
                                        Email
                                    </p>

                                    <a
                                        :href="`mailto:${site.email}`"
                                        class="mt-3 block break-all text-sm font-black transition hover:text-[#e9422c]"
                                    >
                                        {{ site.email }}
                                    </a>
                                </div>

                                <div class="bg-[#f5f3ee] p-5">
                                    <p
                                        class="text-[9px] font-black uppercase tracking-[0.18em] text-stone-400"
                                    >
                                        Phone
                                    </p>

                                    <a
                                        :href="`tel:${site.phone_tel}`"
                                        class="mt-3 block text-sm font-black transition hover:text-[#e9422c]"
                                    >
                                        {{ site.phone }}
                                    </a>
                                </div>

                                <div class="bg-[#f5f3ee] p-5 sm:col-span-2">
                                    <p
                                        class="text-[9px] font-black uppercase tracking-[0.18em] text-stone-400"
                                    >
                                        Address
                                    </p>

                                    <p class="mt-3 text-sm font-black">
                                        {{ site.address }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Final callout -->
                <div
                    class="mt-10 flex flex-col gap-6 bg-[#ff4f38] p-7 text-white sm:p-9 md:flex-row md:items-center md:justify-between"
                >
                    <div>
                        <p
                            class="text-[10px] font-black uppercase tracking-[0.2em] text-white/60"
                        >
                            Before purchasing
                        </p>

                        <h2
                            class="mt-3 max-w-xl text-2xl font-black tracking-[-0.035em]"
                        >
                            Confirm vehicle details, total price, and written
                            transaction terms.
                        </h2>
                    </div>

                    <Link
                        href="/contact"
                        class="inline-flex min-h-12 shrink-0 items-center justify-center rounded-full bg-[#171717] px-7 py-3 text-xs font-black uppercase tracking-wide text-white transition hover:bg-white hover:text-black"
                    >
                        Contact our team
                    </Link>
                </div>
            </div>
        </div>
    </section>
</template>
