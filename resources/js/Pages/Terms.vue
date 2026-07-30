<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import Icon from '@/Components/Icon.vue';
import PageIntro from '@/Components/PageIntro.vue';
import SeoHead from '@/Components/SeoHead.vue';
import SiteLayout from '@/Layouts/SiteLayout.vue';

defineOptions({ layout: SiteLayout });
const site = computed(() => usePage().props.site || {});
</script>

<template>
    <SeoHead title="Terms of use" description="Terms of use for the Kohl Auto Sales website." />
    <PageIntro eyebrow="Legal" title="Terms of use" description="Terms for using the Kohl Auto Sales website and vehicle information." background="3" />
    <article class="site-section"><div class="site-container"><div class="legal-copy"><p>Effective date: July 28, 2026</p><h2>Website information</h2><p>Vehicle listings, prices, descriptions, specifications, images, and availability may change and should be confirmed directly with {{ site.name }}. Website content is provided for general information and does not create an offer, agreement, or reservation.</p><h2>Vehicle availability and pricing</h2><p>A listed vehicle may be sold, unavailable, or changed before a visitor contacts us. Taxes, title, registration, financing, and other applicable charges are not represented by website content unless specifically stated in writing by the dealership.</p><h2>Requests and communications</h2><p>Submitting a form does not create a purchase agreement, financing approval, appraisal, or vehicle reservation. We may contact you using the details you submit in response to your request.</p><h2>Third-party links</h2><p>This website may link to third-party websites, including mapping providers. {{ site.name }} does not control and is not responsible for third-party content or privacy practices.</p><h2>Contact</h2><p>For questions about these terms, contact {{ site.name }} at <a :href="`tel:${site.phone_tel}`" class="inline-flex items-center gap-1"><Icon name="phone" />{{ site.phone }}</a>.</p><p class="mt-10 text-sm">These terms should be reviewed and finalized by the business owner for the company’s actual operations and jurisdiction before publication.</p></div></div></article>
</template>
