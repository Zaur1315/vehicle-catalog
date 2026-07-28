<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import PageIntro from '@/Components/PageIntro.vue';
import SeoHead from '@/Components/SeoHead.vue';
import SiteLayout from '@/Layouts/SiteLayout.vue';

defineOptions({ layout: SiteLayout });
const site = computed(() => usePage().props.site || {});
</script>

<template>
    <SeoHead title="Privacy policy" description="Privacy policy for Kohl Auto Sales." />
    <PageIntro eyebrow="Legal" title="Privacy policy" description="How Kohl Auto Sales handles information submitted through this website." />
    <article class="site-section"><div class="site-container"><div class="legal-copy"><p>Effective date: July 28, 2026</p><h2>Information we collect</h2><p>When you submit a contact, vehicle inquiry, financing, or sell-or-trade form, we collect the information you provide, such as your name, phone number, email address, vehicle details, and message.</p><h2>How information is used</h2><p>We use submitted information to respond to your request, discuss a vehicle or related next step, maintain our dealership records, and operate this website. We do not sell personal information submitted through this website.</p><h2>Service providers and analytics</h2><p>This website may use service providers that support hosting, form delivery, email notifications, security, and optional analytics or advertising measurement. Those providers may process information only as needed to provide their services.</p><h2>Cookies</h2><p>This site uses essential cookies for its operation. Where optional marketing cookies are enabled, the cookie consent control lets you choose whether to allow them.</p><h2>Your choices</h2><p>You may contact us to request access to, correction of, or deletion of personal information we hold, subject to applicable legal and business requirements.</p><h2>Contact</h2><p>For privacy questions, contact {{ site.name }} by phone at <a :href="`tel:${site.phone_tel}`">{{ site.phone }}</a><span v-if="site.email"> or email <a :href="`mailto:${site.email}`">{{ site.email }}</a></span>.</p><p class="mt-10 text-sm">This policy should be reviewed and finalized by the business owner before publication, particularly after the company email, address, domain, and analytics choices are confirmed.</p></div></div></article>
</template>
