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

const sections = [
    {
        id: 'scope',
        label: 'Scope',
    },
    {
        id: 'information-we-collect',
        label: 'Information We Collect',
    },
    {
        id: 'how-we-use-information',
        label: 'How We Use Information',
    },
    {
        id: 'cookies-and-advertising',
        label: 'Cookies and Advertising',
    },
    {
        id: 'sharing-information',
        label: 'Sharing Information',
    },
    {
        id: 'retention-and-security',
        label: 'Retention and Security',
    },
    {
        id: 'your-privacy-rights',
        label: 'Your Privacy Rights',
    },
    {
        id: 'children',
        label: 'Children’s Privacy',
    },
    {
        id: 'changes',
        label: 'Policy Changes',
    },
    {
        id: 'contact-privacy',
        label: 'Contact Us',
    },
];
</script>

<template>
    <SeoHead
        title="Privacy Policy"
        description="Read the Cars For Less Sales & Service Privacy Policy and learn how website, contact, vehicle inquiry, finance, trade-in, analytics, and cookie information may be handled."
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
                        Privacy Policy.
                    </h1>

                    <p
                        class="mt-6 max-w-3xl text-base leading-7 text-stone-600"
                    >
                        This policy explains how {{ site.name }} may collect,
                        use, store, and share information received through this
                        website.
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
                        Contact us if you have questions about this policy or
                        information you submitted.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Policy -->
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
                        Policy sections
                    </p>

                    <nav class="mt-5 flex flex-col">
                        <a
                            v-for="(section, index) in sections"
                            :key="section.id"
                            :href="`#${section.id}`"
                            class="group flex items-center gap-3 border-b border-black/10 py-3 text-sm font-bold transition last:border-b-0 hover:text-[#e9422c]"
                        >
                            <span
                                class="text-[9px] font-black text-stone-400 group-hover:text-[#e9422c]"
                            >
                                {{ String(index + 1).padStart(2, '0') }}
                            </span>

                            {{ section.label }}
                        </a>
                    </nav>
                </div>

                <div class="mt-5 border border-black/10 bg-white p-6">
                    <p
                        class="text-[10px] font-black uppercase tracking-[0.2em] text-stone-400"
                    >
                        Privacy questions
                    </p>

                    <a
                        :href="`mailto:${site.email}`"
                        class="mt-3 block break-all text-sm font-black transition hover:text-[#e9422c]"
                    >
                        {{ site.email }}
                    </a>

                    <a
                        :href="`tel:${site.phone_tel}`"
                        class="mt-2 block text-sm font-black transition hover:text-[#e9422c]"
                    >
                        {{ site.phone }}
                    </a>
                </div>
            </aside>

            <!-- Policy content -->
            <div class="min-w-0">
                <section
                    id="scope"
                    class="scroll-mt-32 border-t border-black/15 py-10 first:pt-0"
                >
                    <div class="grid gap-6 md:grid-cols-[70px_1fr]">
                        <p class="text-xs font-black text-[#e9422c]">
                            01
                        </p>

                        <div>
                            <h2
                                class="text-3xl font-black tracking-[-0.045em]"
                            >
                                Scope of this policy
                            </h2>

                            <div
                                class="mt-5 space-y-4 text-sm leading-7 text-stone-600"
                            >
                                <p>
                                    This Privacy Policy applies to information
                                    collected through this website, including
                                    vehicle inquiries, contact forms, finance
                                    requests, trade-in requests, cookie
                                    preferences, analytics, and advertising
                                    technologies.
                                </p>

                                <p>
                                    This policy does not necessarily apply to
                                    third-party websites, lenders, service
                                    contract providers, transport providers,
                                    social networks, or other companies that
                                    maintain their own privacy policies.
                                </p>
                            </div>
                        </div>
                    </div>
                </section>

                <section
                    id="information-we-collect"
                    class="scroll-mt-32 border-t border-black/15 py-10"
                >
                    <div class="grid gap-6 md:grid-cols-[70px_1fr]">
                        <p class="text-xs font-black text-[#e9422c]">
                            02
                        </p>

                        <div>
                            <h2
                                class="text-3xl font-black tracking-[-0.045em]"
                            >
                                Information we collect
                            </h2>

                            <div
                                class="mt-5 space-y-4 text-sm leading-7 text-stone-600"
                            >
                                <p>
                                    We may collect information you submit
                                    directly through the website, including:
                                </p>

                                <ul class="space-y-2 pl-5">
                                    <li class="list-disc">
                                        Name, telephone number, and email
                                        address.
                                    </li>

                                    <li class="list-disc">
                                        Messages, questions, and preferred
                                        contact information.
                                    </li>

                                    <li class="list-disc">
                                        Vehicle interests, stock numbers, and
                                        inventory inquiry details.
                                    </li>

                                    <li class="list-disc">
                                        Preliminary financing information,
                                        including vehicle amount, estimated
                                        down payment, preferred term, and
                                        self-selected credit range.
                                    </li>

                                    <li class="list-disc">
                                        Trade-in information, including make,
                                        model, year, mileage, condition, VIN,
                                        and vehicle notes.
                                    </li>
                                </ul>

                                <p>
                                    Do not submit Social Security numbers, bank
                                    account details, payment card information,
                                    driver’s license images, or other highly
                                    sensitive information through a general
                                    website form.
                                </p>

                                <p>
                                    We may automatically receive basic
                                    technical information such as IP address,
                                    browser type, device type, operating
                                    system, referring page, pages visited,
                                    approximate location, and website
                                    interactions.
                                </p>
                            </div>
                        </div>
                    </div>
                </section>

                <section
                    id="how-we-use-information"
                    class="scroll-mt-32 border-t border-black/15 py-10"
                >
                    <div class="grid gap-6 md:grid-cols-[70px_1fr]">
                        <p class="text-xs font-black text-[#e9422c]">
                            03
                        </p>

                        <div>
                            <h2
                                class="text-3xl font-black tracking-[-0.045em]"
                            >
                                How we use information
                            </h2>

                            <div
                                class="mt-5 space-y-4 text-sm leading-7 text-stone-600"
                            >
                                <p>
                                    We may use collected information to:
                                </p>

                                <ul class="space-y-2 pl-5">
                                    <li class="list-disc">
                                        Respond to questions and contact
                                        requests.
                                    </li>

                                    <li class="list-disc">
                                        Confirm vehicle availability, pricing,
                                        mileage, and inventory information.
                                    </li>

                                    <li class="list-disc">
                                        Review preliminary finance and
                                        trade-in requests.
                                    </li>

                                    <li class="list-disc">
                                        Discuss delivery, warranty, service,
                                        and dealership information.
                                    </li>

                                    <li class="list-disc">
                                        Store and manage customer leads.
                                    </li>

                                    <li class="list-disc">
                                        Send requested transactional or
                                        service-related communications.
                                    </li>

                                    <li class="list-disc">
                                        Detect spam, fraud, misuse, and
                                        technical problems.
                                    </li>

                                    <li class="list-disc">
                                        Maintain, analyze, and improve the
                                        website.
                                    </li>

                                    <li class="list-disc">
                                        Measure marketing and advertising
                                        performance when consent is provided.
                                    </li>

                                    <li class="list-disc">
                                        Comply with legal and recordkeeping
                                        obligations.
                                    </li>
                                </ul>

                                <p>
                                    Submitting a form does not create a vehicle
                                    reservation, purchase agreement, financing
                                    approval, trade-in offer, warranty,
                                    delivery contract, or service appointment.
                                </p>
                            </div>
                        </div>
                    </div>
                </section>

                <section
                    id="cookies-and-advertising"
                    class="scroll-mt-32 border-t border-black/15 py-10"
                >
                    <div class="grid gap-6 md:grid-cols-[70px_1fr]">
                        <p class="text-xs font-black text-[#e9422c]">
                            04
                        </p>

                        <div>
                            <h2
                                class="text-3xl font-black tracking-[-0.045em]"
                            >
                                Cookies, analytics, and advertising
                            </h2>

                            <div
                                class="mt-5 space-y-4 text-sm leading-7 text-stone-600"
                            >
                                <p>
                                    Necessary cookies and local browser storage
                                    may be used to support core functionality,
                                    sessions, security, forms, and saved cookie
                                    preferences.
                                </p>

                                <p>
                                    If you consent to marketing cookies, the
                                    website may use Meta Pixel or similar tools
                                    to measure page activity, advertising
                                    performance, and submitted lead events.
                                    These technologies may receive information
                                    about your browser, device, IP address,
                                    referral source, pages viewed, and actions
                                    taken.
                                </p>

                                <p>
                                    You may reject optional marketing cookies
                                    through the cookie banner. You can also
                                    clear cookies and local storage through
                                    your browser settings. Clearing stored data
                                    may cause the cookie banner to appear
                                    again.
                                </p>

                                <p>
                                    Embedded services such as Google Maps may
                                    process information under their own privacy
                                    terms when they are loaded or used.
                                </p>
                            </div>

                            <div
                                class="mt-6 border border-black/10 bg-[#f5f3ee] p-5"
                            >
                                <p class="text-sm font-black">
                                    Cookie preference
                                </p>

                                <p class="mt-2 text-sm leading-6 text-stone-600">
                                    Marketing measurement remains disabled
                                    unless you provide consent through the
                                    website’s cookie banner.
                                </p>
                            </div>
                        </div>
                    </div>
                </section>

                <section
                    id="sharing-information"
                    class="scroll-mt-32 border-t border-black/15 py-10"
                >
                    <div class="grid gap-6 md:grid-cols-[70px_1fr]">
                        <p class="text-xs font-black text-[#e9422c]">
                            05
                        </p>

                        <div>
                            <h2
                                class="text-3xl font-black tracking-[-0.045em]"
                            >
                                How information may be shared
                            </h2>

                            <div
                                class="mt-5 space-y-4 text-sm leading-7 text-stone-600"
                            >
                                <p>
                                    We do not sell personal information as a
                                    standalone business product.
                                </p>

                                <p>
                                    Information may be shared with vendors and
                                    service providers that support website
                                    hosting, email delivery, lead management,
                                    analytics, advertising, security, spam
                                    prevention, maintenance, and customer
                                    communications.
                                </p>

                                <p>
                                    Information may also be shared when
                                    reasonably necessary to:
                                </p>

                                <ul class="space-y-2 pl-5">
                                    <li class="list-disc">
                                        Comply with law, legal process, or a
                                        lawful government request.
                                    </li>

                                    <li class="list-disc">
                                        Protect the rights, safety, property,
                                        and security of users, the dealership,
                                        or others.
                                    </li>

                                    <li class="list-disc">
                                        Investigate fraud, abuse, security
                                        incidents, or misuse.
                                    </li>

                                    <li class="list-disc">
                                        Support a merger, acquisition, sale,
                                        financing, reorganization, or transfer
                                        of business assets.
                                    </li>
                                </ul>

                                <p>
                                    If you request financing, transportation,
                                    warranty products, or other third-party
                                    services, additional information sharing
                                    should be explained before proceeding with
                                    that service.
                                </p>
                            </div>
                        </div>
                    </div>
                </section>

                <section
                    id="retention-and-security"
                    class="scroll-mt-32 border-t border-black/15 py-10"
                >
                    <div class="grid gap-6 md:grid-cols-[70px_1fr]">
                        <p class="text-xs font-black text-[#e9422c]">
                            06
                        </p>

                        <div>
                            <h2
                                class="text-3xl font-black tracking-[-0.045em]"
                            >
                                Data retention and security
                            </h2>

                            <div
                                class="mt-5 space-y-4 text-sm leading-7 text-stone-600"
                            >
                                <p>
                                    Information may be retained for as long as
                                    reasonably necessary to respond to your
                                    request, manage dealership leads, maintain
                                    business records, resolve disputes,
                                    prevent fraud, enforce agreements, and
                                    satisfy legal obligations.
                                </p>

                                <p>
                                    We use reasonable administrative,
                                    technical, and organizational measures
                                    designed to protect website information.
                                    However, no website, server, database,
                                    email system, or internet transmission can
                                    be guaranteed completely secure.
                                </p>

                                <p>
                                    Email and general website forms should not
                                    be treated as secure channels for highly
                                    sensitive financial or identity
                                    information.
                                </p>
                            </div>
                        </div>
                    </div>
                </section>

                <section
                    id="your-privacy-rights"
                    class="scroll-mt-32 border-t border-black/15 py-10"
                >
                    <div class="grid gap-6 md:grid-cols-[70px_1fr]">
                        <p class="text-xs font-black text-[#e9422c]">
                            07
                        </p>

                        <div>
                            <h2
                                class="text-3xl font-black tracking-[-0.045em]"
                            >
                                Your privacy choices and rights
                            </h2>

                            <div
                                class="mt-5 space-y-4 text-sm leading-7 text-stone-600"
                            >
                                <p>
                                    Depending on applicable law and whether the
                                    law applies to our processing, you may have
                                    rights to request:
                                </p>

                                <ul class="space-y-2 pl-5">
                                    <li class="list-disc">
                                        Confirmation that personal information
                                        is being processed.
                                    </li>

                                    <li class="list-disc">
                                        Access to or a copy of certain personal
                                        information.
                                    </li>

                                    <li class="list-disc">
                                        Correction of inaccurate information.
                                    </li>

                                    <li class="list-disc">
                                        Deletion of certain information.
                                    </li>

                                    <li class="list-disc">
                                        Opt-out from certain targeted
                                        advertising, sale, or profiling
                                        activities where legally applicable.
                                    </li>
                                </ul>

                                <p>
                                    To submit a request, contact us using the
                                    information below. We may need to verify
                                    your identity before completing a request.
                                    Some information may be retained where
                                    permitted or required for legal,
                                    recordkeeping, security, fraud-prevention,
                                    or operational purposes.
                                </p>

                                <p>
                                    You may opt out of marketing
                                    communications by following the
                                    instructions in the communication or
                                    contacting us. We may still send messages
                                    needed to respond to your request.
                                </p>
                            </div>
                        </div>
                    </div>
                </section>

                <section
                    id="children"
                    class="scroll-mt-32 border-t border-black/15 py-10"
                >
                    <div class="grid gap-6 md:grid-cols-[70px_1fr]">
                        <p class="text-xs font-black text-[#e9422c]">
                            08
                        </p>

                        <div>
                            <h2
                                class="text-3xl font-black tracking-[-0.045em]"
                            >
                                Children’s privacy
                            </h2>

                            <div
                                class="mt-5 space-y-4 text-sm leading-7 text-stone-600"
                            >
                                <p>
                                    This website is intended for people
                                    researching vehicles and dealership
                                    services. It is not directed to children
                                    under 13, and we do not knowingly request
                                    personal information from children under
                                    13 through website forms.
                                </p>

                                <p>
                                    If you believe a child submitted personal
                                    information through this website, contact
                                    us so the matter can be reviewed.
                                </p>
                            </div>
                        </div>
                    </div>
                </section>

                <section
                    id="changes"
                    class="scroll-mt-32 border-t border-black/15 py-10"
                >
                    <div class="grid gap-6 md:grid-cols-[70px_1fr]">
                        <p class="text-xs font-black text-[#e9422c]">
                            09
                        </p>

                        <div>
                            <h2
                                class="text-3xl font-black tracking-[-0.045em]"
                            >
                                Changes to this policy
                            </h2>

                            <div
                                class="mt-5 space-y-4 text-sm leading-7 text-stone-600"
                            >
                                <p>
                                    This Privacy Policy may be updated to
                                    reflect changes to the website, business
                                    practices, service providers, or legal
                                    requirements.
                                </p>

                                <p>
                                    The updated version will be posted on this
                                    page with a revised “Last updated” date.
                                    Your continued use of the website after an
                                    update is subject to the revised policy.
                                </p>
                            </div>
                        </div>
                    </div>
                </section>

                <section
                    id="contact-privacy"
                    class="scroll-mt-32 border-y border-black/15 py-10"
                >
                    <div class="grid gap-6 md:grid-cols-[70px_1fr]">
                        <p class="text-xs font-black text-[#e9422c]">
                            10
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
                                Contact us with questions about this policy,
                                cookie preferences, or personal information you
                                previously submitted through the website.
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
                                        Mailing address
                                    </p>

                                    <p class="mt-3 text-sm font-black">
                                        {{ site.address }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <div
                    class="mt-10 flex flex-col gap-6 bg-[#171717] p-7 text-white sm:p-9 md:flex-row md:items-center md:justify-between"
                >
                    <div>
                        <p
                            class="text-[10px] font-black uppercase tracking-[0.2em] text-[#ff5a45]"
                        >
                            Need assistance?
                        </p>

                        <h2
                            class="mt-3 max-w-xl text-2xl font-black tracking-[-0.035em]"
                        >
                            Contact us before submitting sensitive information.
                        </h2>
                    </div>

                    <Link
                        href="/contact"
                        class="inline-flex min-h-12 shrink-0 items-center justify-center rounded-full bg-white px-7 py-3 text-xs font-black uppercase tracking-wide text-black transition hover:bg-[#ff4f38] hover:text-white"
                    >
                        Contact us
                    </Link>
                </div>
            </div>
        </div>
    </section>
</template>
