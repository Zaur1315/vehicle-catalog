<script setup>
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import ContactForm from '@/Components/ContactForm.vue';
import Icon from '@/Components/Icon.vue';
import SeoHead from '@/Components/SeoHead.vue';
import SiteLayout from '@/Layouts/SiteLayout.vue';
defineOptions({ layout: SiteLayout });
const site = computed(() => usePage().props.site || {});
const topics = [['Vehicle availability'], ['Finance question'], ['Sell or trade question'], ['General question']];
</script>
<template>
    <SeoHead title="Contact Advantage Auto Sales" :description="`Contact Advantage Auto Sales in Uniontown, PA. Call ${site.phone}, send a message, or get directions to 1026 National Pike.`" image="/images/advantage/contact.webp" />
    <section class="contact-hero site-container">
        <div><p class="eyebrow">Contact Advantage Auto Sales</p><h1>Let’s talk about your next vehicle.</h1><p>Ask about availability, plan a visit, or tell us what you are looking for. Our Uniontown team is easy to reach.</p></div>
        <div class="contact-hero-image"><img :src="'/images/advantage/contact.webp'" alt="Entrance to a clean independent Pennsylvania auto dealership" width="1280" height="853" fetchpriority="high" /></div>
    </section>
    <section class="contact-methods site-container">
        <a :href="`tel:${site.phone_tel}`"><span>01 / Call</span><strong>{{ site.phone }}</strong><Icon name="arrow-right" /></a>
        <a :href="`mailto:${site.email}`"><span>02 / Email</span><strong>{{ site.email }}</strong><Icon name="arrow-right" /></a>
        <a :href="site.maps_url" target="_blank" rel="noopener"><span>03 / Visit</span><strong>{{ site.address }}</strong><Icon name="arrow-right" /></a>
    </section>
    <section class="contact-main">
        <div class="site-container contact-main-grid">
            <div><p class="eyebrow">Send a message</p><h2>What can we help with?</h2><p>Share the basics and the best way to reach you. We will use your message to follow up about the question you selected.</p><div id="contact-message" class="form-surface"><ContactForm :topics="topics" /></div></div>
            <aside><p class="eyebrow">Plan your visit</p><h2>1026 National Pike<br />Uniontown, PA 15401</h2><p>Call before you make the trip to confirm current vehicle availability.</p><div class="contact-map"><iframe v-if="site.maps_embed_url" :src="site.maps_embed_url" title="Map showing Advantage Auto Sales in Uniontown, Pennsylvania" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe></div><a :href="site.maps_url" target="_blank" rel="noopener" class="btn-secondary">Open in Google Maps <Icon name="arrow-right" /></a></aside>
        </div>
    </section>
</template>
