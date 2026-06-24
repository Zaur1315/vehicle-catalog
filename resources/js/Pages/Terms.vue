<script setup>
import {Link} from '@inertiajs/vue3';
import SeoHead from '@/Components/SeoHead.vue';
import SiteLayout from '@/Layouts/SiteLayout.vue';

defineOptions({
    layout: SiteLayout,
});
</script>

<template>
    <SeoHead
        title="Terms"
        description="Read website terms related to vehicle availability, pricing, mileage, specifications, warranty, delivery, returns, and purchase confirmation."
    />

    <section class="border-b border-white/10 bg-[#080b0f]">
        <div class="site-container py-10">
            <div class="max-w-4xl">
                <p class="eyebrow">
                    Terms
                </p>

                <h1 class="mt-3 heading-lg">
                    Website terms and vehicle information disclaimers.
                </h1>

                <p class="mt-5 body-muted">
                    These Terms explain how visitors may use this website and how vehicle information, pricing,
                    availability, finance, delivery, warranty, return, and trade-in information should be understood.
                </p>

                <p class="mt-5 text-sm text-slate-500">
                    Last updated: June 25, 2026
                </p>
            </div>
        </div>
    </section>

    <section class="site-section">
        <div class="site-container">
            <div class="grid gap-8 lg:grid-cols-[320px_1fr]">
                <aside class="h-fit border border-white/10 bg-white/[0.025] p-5 lg:sticky lg:top-32">
                    <p class="text-xs font-black uppercase tracking-[0.24em] text-slate-500">
                        Sections
                    </p>

                    <nav class="mt-5 flex flex-col gap-3 text-sm text-slate-400">
                        <a href="#use-of-site" class="hover:text-white">Use of Website</a>
                        <a href="#vehicle-information" class="hover:text-white">Vehicle Information</a>
                        <a href="#pricing" class="hover:text-white">Pricing and Availability</a>
                        <a href="#inquiries" class="hover:text-white">Inquiries and Forms</a>
                        <a href="#finance" class="hover:text-white">Finance Information</a>
                        <a href="#trade-in" class="hover:text-white">Trade-In Information</a>
                        <a href="#delivery" class="hover:text-white">Delivery</a>
                        <a href="#warranty" class="hover:text-white">Warranty and Returns</a>
                        <a href="#liability" class="hover:text-white">Limitation of Liability</a>
                        <a href="#contact-terms" class="hover:text-white">Contact</a>
                    </nav>
                </aside>

                <div class="space-y-6">
                    <section id="use-of-site" class="dealer-panel rounded-2xl p-6 lg:p-8">
                        <p class="eyebrow">
                            01
                        </p>

                        <h2 class="mt-3 text-3xl font-black">
                            Use of Website
                        </h2>

                        <div class="mt-5 space-y-4 text-sm leading-7 text-slate-300">
                            <p>
                                This website is provided for general informational purposes and to allow visitors to
                                browse vehicle inventory, submit inquiries, request finance information, request
                                trade-in review, and contact the dealership.
                            </p>

                            <p>
                                By using this website, you agree not to misuse the website, interfere with its
                                operation, submit false information, attempt unauthorized access, scrape data without
                                permission, or use the website for unlawful purposes.
                            </p>
                        </div>
                    </section>

                    <section id="vehicle-information" class="dealer-panel rounded-2xl p-6 lg:p-8">
                        <p class="eyebrow">
                            02
                        </p>

                        <h2 class="mt-3 text-3xl font-black">
                            Vehicle Information
                        </h2>

                        <div class="mt-5 space-y-4 text-sm leading-7 text-slate-300">
                            <p>
                                Vehicle listings may include make, model, year, mileage, VIN, stock number, condition,
                                photos, features, descriptions, price, and other details. We make reasonable efforts to
                                display accurate information, but errors, omissions, delays, and changes may occur.
                            </p>

                            <p>
                                Photos, descriptions, specifications, options, packages, colors, mileage, and features
                                must be confirmed with the dealership before purchase. Website information should not be
                                treated as a final representation unless confirmed in writing.
                            </p>
                        </div>
                    </section>

                    <section id="pricing" class="dealer-panel rounded-2xl p-6 lg:p-8">
                        <p class="eyebrow">
                            03
                        </p>

                        <h2 class="mt-3 text-3xl font-black">
                            Pricing and Availability
                        </h2>

                        <div class="mt-5 space-y-4 text-sm leading-7 text-slate-300">
                            <p>
                                Vehicle availability, pricing, mileage, incentives, fees, taxes, delivery costs,
                                warranty terms, and purchase terms are subject to confirmation and may change without
                                notice.
                            </p>

                            <p>
                                A vehicle displayed on the website may already be sold, reserved, pending, unavailable,
                                or incorrectly listed. No website listing creates a binding offer, purchase agreement,
                                reservation, or guarantee of availability.
                            </p>
                        </div>
                    </section>

                    <section id="inquiries" class="dealer-panel rounded-2xl p-6 lg:p-8">
                        <p class="eyebrow">
                            04
                        </p>

                        <h2 class="mt-3 text-3xl font-black">
                            Inquiries and Forms
                        </h2>

                        <div class="mt-5 space-y-4 text-sm leading-7 text-slate-300">
                            <p>
                                Submitting a contact form, vehicle inquiry, finance request, or trade-in request allows
                                our team to contact you about your request. Submission of a form does not create a sale,
                                financing approval, trade-in offer, delivery agreement, warranty approval, or contract.
                            </p>

                            <p>
                                You are responsible for providing accurate contact information and accurate vehicle or
                                trade-in details. False, incomplete, or inaccurate information may delay response or
                                affect any estimate, review, or final terms.
                            </p>
                        </div>
                    </section>

                    <section id="finance" class="dealer-panel rounded-2xl p-6 lg:p-8">
                        <p class="eyebrow">
                            05
                        </p>

                        <h2 class="mt-3 text-3xl font-black">
                            Finance Information
                        </h2>

                        <div class="mt-5 space-y-4 text-sm leading-7 text-slate-300">
                            <p>
                                Finance information shown on the website, including any estimated payment, is for
                                general informational purposes only. It is not a credit offer, loan approval, lender
                                commitment, or final payment quote.
                            </p>

                            <p>
                                Final finance terms depend on vehicle details, buyer qualification, credit profile,
                                lender approval, down payment, taxes, fees, term, APR, documentation, and other
                                applicable requirements.
                            </p>
                        </div>
                    </section>

                    <section id="trade-in" class="dealer-panel rounded-2xl p-6 lg:p-8">
                        <p class="eyebrow">
                            06
                        </p>

                        <h2 class="mt-3 text-3xl font-black">
                            Trade-In Information
                        </h2>

                        <div class="mt-5 space-y-4 text-sm leading-7 text-slate-300">
                            <p>
                                Trade-in requests and estimates are preliminary unless confirmed in writing after
                                review. Final trade-in value may depend on inspection, vehicle history, title status,
                                mileage, condition, market conditions, payoff status, and purchase agreement.
                            </p>

                            <p>
                                Submitting trade-in information does not require the dealership to purchase or accept
                                the vehicle as a trade-in.
                            </p>
                        </div>
                    </section>

                    <section id="delivery" class="dealer-panel rounded-2xl p-6 lg:p-8">
                        <p class="eyebrow">
                            07
                        </p>

                        <h2 class="mt-3 text-3xl font-black">
                            Delivery
                        </h2>

                        <div class="mt-5 space-y-4 text-sm leading-7 text-slate-300">
                            <p>
                                Delivery information, including estimated timing, enclosed transport availability, and
                                insurance details, is subject to route, carrier availability, location access, weather,
                                payment confirmation, documents, and written delivery terms.
                            </p>

                            <p>
                                Estimated delivery timing is not guaranteed unless expressly stated in a written
                                agreement. Additional costs may apply depending on buyer location and delivery
                                requirements.
                            </p>
                        </div>
                    </section>

                    <section id="warranty" class="dealer-panel rounded-2xl p-6 lg:p-8">
                        <p class="eyebrow">
                            08
                        </p>

                        <h2 class="mt-3 text-3xl font-black">
                            Warranty and Returns
                        </h2>

                        <div class="mt-5 space-y-4 text-sm leading-7 text-slate-300">
                            <p>
                                Warranty and return information shown on the website is a summary only. Final warranty
                                coverage, return eligibility, exclusions, limitations, timing, refund handling, and
                                buyer responsibilities must be confirmed in the written purchase documents.
                            </p>

                            <p>
                                Warranty and return terms may vary by vehicle, buyer location, delivery status,
                                mileage, condition, and purchase agreement.
                            </p>
                        </div>
                    </section>

                    <section id="liability" class="dealer-panel rounded-2xl p-6 lg:p-8">
                        <p class="eyebrow">
                            09
                        </p>

                        <h2 class="mt-3 text-3xl font-black">
                            Limitation of Liability
                        </h2>

                        <div class="mt-5 space-y-4 text-sm leading-7 text-slate-300">
                            <p>
                                The website is provided on an “as available” basis. We do not guarantee that the
                                website will always be uninterrupted, error-free, secure, or current.
                            </p>

                            <p>
                                To the maximum extent permitted by applicable law, Auto Dealer is not responsible for
                                losses resulting from website errors, delays, inaccurate listings, third-party tools,
                                technical issues, or reliance on information that has not been confirmed in writing.
                            </p>
                        </div>
                    </section>

                    <section id="contact-terms" class="dealer-panel rounded-2xl p-6 lg:p-8">
                        <p class="eyebrow">
                            10
                        </p>

                        <h2 class="mt-3 text-3xl font-black">
                            Contact Us
                        </h2>

                        <div class="mt-5 space-y-4 text-sm leading-7 text-slate-300">
                            <p>
                                If you have questions about these Terms or need confirmation about a specific vehicle,
                                contact our team before relying on website information.
                            </p>

                            <div class="border border-white/10 bg-white/[0.025] p-5">
                                <p>
                                    <span class="font-black text-white">Email:</span>
                                    <a href="mailto:sales@example.com" class="ml-2 text-amber-300 hover:text-amber-200">
                                        sales@example.com
                                    </a>
                                </p>

                                <p class="mt-2">
                                    <span class="font-black text-white">Phone:</span>
                                    <a href="tel:+10000000000" class="ml-2 text-amber-300 hover:text-amber-200">
                                        +1 (000) 000-0000
                                    </a>
                                </p>
                            </div>
                        </div>
                    </section>

                    <section class="border border-amber-300/30 bg-amber-300/[0.08] p-6 lg:p-8">
                        <div class="grid gap-6 lg:grid-cols-[1fr_auto] lg:items-center">
                            <div>
                                <p class="eyebrow">
                                    Before You Buy
                                </p>

                                <h2 class="mt-3 text-3xl font-black">
                                    Confirm vehicle details and written terms with our sales team.
                                </h2>
                            </div>

                            <Link href="/contact" class="btn-primary">
                                Contact Sales
                            </Link>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>
</template>
