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
        title="Privacy Policy"
        description="Read our privacy policy and learn how contact form, lead, analytics, and website information may be handled."
    />

    <section class="border-b border-white/10 bg-[#080b0f]">
        <div class="site-container py-10">
            <div class="max-w-4xl">
                <p class="eyebrow">
                    Privacy Policy
                </p>

                <h1 class="mt-3 heading-lg">
                    How we collect, use, and protect website information.
                </h1>

                <p class="mt-5 body-muted">
                    This Privacy Policy explains how Auto Dealer collects and uses information submitted through this
                    website, including inventory inquiries, contact forms, finance requests, trade-in requests,
                    analytics, and advertising tools.
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
                        <a href="#information-we-collect" class="hover:text-white">Information We Collect</a>
                        <a href="#how-we-use-information" class="hover:text-white">How We Use Information</a>
                        <a href="#leads-and-forms" class="hover:text-white">Leads and Forms</a>
                        <a href="#analytics-and-ads" class="hover:text-white">Analytics and Advertising</a>
                        <a href="#sharing-information" class="hover:text-white">Sharing Information</a>
                        <a href="#data-security" class="hover:text-white">Data Security</a>
                        <a href="#your-choices" class="hover:text-white">Your Choices</a>
                        <a href="#contact-privacy" class="hover:text-white">Contact</a>
                    </nav>
                </aside>

                <div class="space-y-6">
                    <section id="information-we-collect" class="dealer-panel rounded-2xl p-6 lg:p-8">
                        <p class="eyebrow">
                            01
                        </p>

                        <h2 class="mt-3 text-3xl font-black">
                            Information We Collect
                        </h2>

                        <div class="mt-5 space-y-4 text-sm leading-7 text-slate-300">
                            <p>
                                We may collect information that you submit directly through the website. This may
                                include your name, phone number, email address, message, vehicle interest, finance
                                request details, trade-in vehicle details, and other information you choose to provide.
                            </p>

                            <p>
                                We may also collect basic technical information such as IP address, browser type,
                                device information, referring pages, pages visited, form interactions, and general
                                website usage data.
                            </p>
                        </div>
                    </section>

                    <section id="how-we-use-information" class="dealer-panel rounded-2xl p-6 lg:p-8">
                        <p class="eyebrow">
                            02
                        </p>

                        <h2 class="mt-3 text-3xl font-black">
                            How We Use Information
                        </h2>

                        <div class="mt-5 space-y-4 text-sm leading-7 text-slate-300">
                            <p>
                                We use submitted information to respond to inquiries, confirm vehicle availability,
                                provide pricing information, discuss delivery, explain warranty or return terms,
                                review finance requests, review trade-in requests, and communicate with potential
                                buyers.
                            </p>

                            <p>
                                We may also use information to improve website performance, measure marketing
                                effectiveness, prevent spam, maintain records, and support normal dealership
                                operations.
                            </p>
                        </div>
                    </section>

                    <section id="leads-and-forms" class="dealer-panel rounded-2xl p-6 lg:p-8">
                        <p class="eyebrow">
                            03
                        </p>

                        <h2 class="mt-3 text-3xl font-black">
                            Leads and Website Forms
                        </h2>

                        <div class="mt-5 space-y-4 text-sm leading-7 text-slate-300">
                            <p>
                                When you submit a contact form, vehicle inquiry, finance request, or trade-in request,
                                the submitted information may be stored as a lead so that our sales team can follow up
                                with you.
                            </p>

                            <p>
                                Submitting a form does not create a purchase agreement, financing approval, trade-in
                                offer, warranty approval, or delivery contract. Final terms must be confirmed in writing
                                by the dealership.
                            </p>
                        </div>
                    </section>

                    <section id="analytics-and-ads" class="dealer-panel rounded-2xl p-6 lg:p-8">
                        <p class="eyebrow">
                            04
                        </p>

                        <h2 class="mt-3 text-3xl font-black">
                            Analytics, Cookies, and Advertising
                        </h2>

                        <div class="mt-5 space-y-4 text-sm leading-7 text-slate-300">
                            <p>
                                This website may use cookies, pixels, analytics tools, advertising tools, or similar
                                technologies to understand website activity, improve user experience, measure
                                advertising performance, and support remarketing campaigns.
                            </p>

                            <p>
                                These tools may collect information about pages viewed, actions taken on the website,
                                approximate location, device type, browser type, and referral source. You can usually
                                control cookies through your browser settings.
                            </p>
                        </div>
                    </section>

                    <section id="sharing-information" class="dealer-panel rounded-2xl p-6 lg:p-8">
                        <p class="eyebrow">
                            05
                        </p>

                        <h2 class="mt-3 text-3xl font-black">
                            Sharing Information
                        </h2>

                        <div class="mt-5 space-y-4 text-sm leading-7 text-slate-300">
                            <p>
                                We do not sell personal information as a standalone business product. We may share
                                information with service providers that help operate the website, manage leads, provide
                                hosting, analytics, advertising, email delivery, CRM functionality, fraud prevention,
                                or customer communication.
                            </p>

                            <p>
                                We may also disclose information if required by law, to protect our rights, to prevent
                                misuse of the website, or as part of a business transfer such as a merger, sale, or
                                reorganization.
                            </p>
                        </div>
                    </section>

                    <section id="data-security" class="dealer-panel rounded-2xl p-6 lg:p-8">
                        <p class="eyebrow">
                            06
                        </p>

                        <h2 class="mt-3 text-3xl font-black">
                            Data Security
                        </h2>

                        <div class="mt-5 space-y-4 text-sm leading-7 text-slate-300">
                            <p>
                                We use reasonable administrative, technical, and organizational measures designed to
                                protect information submitted through the website. However, no website, server, email
                                system, or internet transmission can be guaranteed to be completely secure.
                            </p>

                            <p>
                                You should avoid submitting sensitive personal, financial, or confidential information
                                through general website forms unless specifically requested through an appropriate
                                secure process.
                            </p>
                        </div>
                    </section>

                    <section id="your-choices" class="dealer-panel rounded-2xl p-6 lg:p-8">
                        <p class="eyebrow">
                            07
                        </p>

                        <h2 class="mt-3 text-3xl font-black">
                            Your Choices
                        </h2>

                        <div class="mt-5 space-y-4 text-sm leading-7 text-slate-300">
                            <p>
                                You may contact us to request access, correction, or deletion of information you
                                previously submitted, subject to legal, operational, fraud-prevention, and recordkeeping
                                requirements.
                            </p>

                            <p>
                                You may opt out of marketing communications by following the instructions in the
                                message or by contacting us directly. Transactional or service-related messages may
                                still be sent when necessary to respond to your request.
                            </p>
                        </div>
                    </section>

                    <section id="contact-privacy" class="dealer-panel rounded-2xl p-6 lg:p-8">
                        <p class="eyebrow">
                            08
                        </p>

                        <h2 class="mt-3 text-3xl font-black">
                            Contact Us
                        </h2>

                        <div class="mt-5 space-y-4 text-sm leading-7 text-slate-300">
                            <p>
                                If you have questions about this Privacy Policy or how website information is handled,
                                contact us using the information below.
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
                                    Questions?
                                </p>

                                <h2 class="mt-3 text-3xl font-black">
                                    Contact our team before submitting sensitive information.
                                </h2>
                            </div>

                            <Link href="/contact" class="btn-primary">
                                Contact Us
                            </Link>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>
</template>
