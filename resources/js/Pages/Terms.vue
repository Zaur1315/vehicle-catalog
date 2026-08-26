<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import LegalPageLayout from '@/Components/LegalPageLayout.vue';
import SiteLayout from '@/Layouts/SiteLayout.vue';

defineOptions({ layout: SiteLayout });
const site = computed(() => usePage().props.site || {});
const sections = [
    { id: 'acceptance', label: 'Acceptance of Terms' },
    { id: 'website', label: 'About This Website' },
    { id: 'listings', label: 'Vehicle Listings' },
    { id: 'pricing', label: 'Pricing and Availability' },
    { id: 'financing', label: 'Financing Information' },
    { id: 'trade-in', label: 'Trade-In Information' },
    { id: 'forms', label: 'Forms and Communications' },
    { id: 'third-party', label: 'Third-Party Services and Links' },
    { id: 'use', label: 'Acceptable Use' },
    { id: 'intellectual-property', label: 'Intellectual Property' },
    { id: 'availability', label: 'Website Availability' },
    { id: 'changes-contact', label: 'Changes and Contact' },
];
</script>

<template>
    <LegalPageLayout title="Terms of Use" description="These terms explain the conditions that apply when you use the Delmar Auto Sale Inc. website and its online features." seo-title="Terms of Use | Delmar Auto Sale Inc." seo-description="Review the Terms of Use that apply to the Delmar Auto Sale Inc. website, vehicle listings, online forms and related website features." hero-image="/images/sections/terms-of-use-hero.webp" last-updated="August 27, 2026" :sections="sections" contact-title="Questions about these terms?">
        <section id="acceptance" class="legal-section"><h2>Acceptance of Terms</h2><p>By accessing or using {{ site.domain }}, you agree to use the website consistently with these Terms of Use. If you do not agree, please do not use the site or submit its forms.</p></section>
        <section id="website" class="legal-section"><h2>About This Website</h2><p>{{ site.name }} provides a public website for browsing available pre-owned vehicles and starting conversations about vehicle inquiries, financing options, trade-ins, and general dealership questions. Website content is for general shopping and informational purposes.</p></section>
        <section id="listings" class="legal-section"><h2>Vehicle Listings</h2><p>Listings may include vehicle names, photos, descriptions, specifications, mileage, prices, and availability. These details are published to help you explore inventory, but may be incomplete, changed, or unavailable by the time you contact the dealership.</p><p>Vehicle information should be reviewed and confirmed directly with {{ site.name }} before you rely on it or make a purchase decision. Vehicle names and manufacturer marks belong to their respective owners.</p></section>
        <section id="pricing" class="legal-section"><h2>Pricing and Availability</h2><p>Prices and inventory status may change without notice. Website content does not create an offer, purchase agreement, reservation, or guarantee that a vehicle will remain available. Final transaction details must be confirmed with the dealership.</p><p>Taxes, title, registration, financing, and other transaction details are not represented by website content unless {{ site.name }} specifically confirms them in writing.</p></section>
        <section id="financing" class="legal-section"><h2>Financing Information</h2><p>The Financing Options page and its form provide a way to send preliminary information to {{ site.name }}. They do not constitute a loan approval, credit offer, guaranteed financing, specific interest rate, or binding financing commitment.</p><p>Submitting a financing request does not itself guarantee a result or mean that {{ site.name }} makes a credit decision. Any financing discussion and final terms must be handled through the applicable dealership process.</p></section>
        <section id="trade-in" class="legal-section"><h2>Trade-In Information</h2><p>The Value Your Trade page collects vehicle information so {{ site.name }} can follow up about a trade-in request. An online request is not a final appraisal, guaranteed offer, or guaranteed value.</p><p>Additional information, an in-person review, and the vehicle’s actual condition may affect any later discussion. No trade-in transaction is created by submitting the form.</p></section>
        <section id="forms" class="legal-section"><h2>Website Forms and Communications</h2><p>When you submit a contact, vehicle inquiry, financing, or trade-in form, you provide information for {{ site.name }} to respond to the request and discuss relevant next steps. You are responsible for providing information that is accurate to the best of your knowledge and for using forms for genuine requests.</p><p>Submitting a form is not a purchase agreement, vehicle reservation, financing application approval, or appraisal. The dealership may contact you using the details you provide.</p></section>
        <section id="third-party" class="legal-section"><h2>Third-Party Services and Links</h2><p>The website may link to third-party services such as Google Maps and may rely on configured providers for email delivery, analytics, advertising measurement, or review synchronization. Third-party services operate under their own terms and privacy practices.</p></section>
        <section id="use" class="legal-section"><h2>Acceptable Use</h2><p>You may not interfere with the website’s operation, seek unauthorized access, submit fraudulent or malicious information, abuse automated requests, introduce harmful code, or use the site in a way that violates applicable law or the rights of others.</p></section>
        <section id="intellectual-property" class="legal-section"><h2>Intellectual Property</h2><p>Website design, original text, branding, logos, and original media are owned by or used by {{ site.name }} or their respective rights holders and may not be copied or reused without permission. Vehicle manufacturer names, logos, and related marks remain the property of their respective owners.</p></section>
        <section id="availability" class="legal-section"><h2>Website Availability and Disclaimers</h2><p>We work to keep the website useful and available, but pages, listings, integrations, and forms may occasionally be interrupted, changed, or unavailable. The site and its content are provided for general informational purposes without a promise that every page or detail will always be complete, current, or error-free.</p><p>To the extent permitted by applicable law, {{ site.name }} is not responsible for losses arising solely from reliance on changing website content or third-party services. Nothing here limits rights that cannot lawfully be limited.</p></section>
        <section id="changes-contact" class="legal-section"><h2>Changes to These Terms</h2><p>These Terms of Use may be updated when the website or its operations change. The “Last updated” date identifies the current version. Continued use of the site after an update means you accept the revised terms.</p><h2>Contact Information</h2><p>Questions about these terms can be directed to {{ site.name }} at {{ site.address }}, <a :href="`mailto:${site.email}`">{{ site.email }}</a>, or <a :href="`tel:${site.phone_tel}`">{{ site.phone }}</a>.</p></section>
    </LegalPageLayout>
</template>
