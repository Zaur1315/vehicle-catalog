<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import Icon from '@/Components/Icon.vue';
import SeoHead from '@/Components/SeoHead.vue';
import SiteLayout from '@/Layouts/SiteLayout.vue';
defineOptions({ layout: SiteLayout });
const site = computed(() => usePage().props.site || {});
const principles = [
    ['Start with the vehicle', 'Review real photos, listed pricing, mileage, and available specifications before deciding what deserves a closer look.'],
    ['Ask a direct question', 'Reach our team by phone or message when you want to confirm availability or understand the next step.'],
    ['Keep the process clear', 'Browse, discuss purchase options, or tell us about a possible trade without navigating unnecessary steps.'],
];
</script>
<template>
    <SeoHead title="About Advantage Auto Sales" description="Learn about the straightforward vehicle shopping experience at Advantage Auto Sales in Uniontown, Pennsylvania." image="/images/advantage/about.webp" />
    <section class="inner-hero site-container">
        <div><p class="eyebrow">About Advantage Auto Sales</p><h1>Local dealership.<br />Straightforward experience.</h1><p>We help Uniontown-area shoppers explore available vehicles, understand the useful details, and reach a real person when it is time to continue.</p><div class="hero-actions"><Link href="/inventory" class="btn-primary">Browse Inventory</Link><Link href="/contact" class="text-link">Contact Our Team <Icon name="arrow-right" /></Link></div></div>
        <div class="inner-hero-image"><img :src="'/images/advantage/about.webp'" alt="A selection of used cars and SUVs at a Pennsylvania dealership" width="1280" height="853" fetchpriority="high" /></div>
    </section>
    <section class="about-statement"><div class="site-container"><h2>A simpler way to shop for your next vehicle.</h2><p>Good decisions start with useful information and clear communication. Explore online first, compare what fits, and bring us into the conversation when you are ready.</p></div></section>
    <section class="site-section site-container">
        <div class="section-header"><div><p class="eyebrow">What to expect</p><h2 class="heading-lg">Built around the questions shoppers actually have.</h2></div></div>
        <div class="principle-cards"><article v-for="(item, index) in principles" :key="item[0]"><span>0{{ index + 1 }}</span><h3>{{ item[0] }}</h3><p>{{ item[1] }}</p></article></div>
    </section>
    <section class="location-feature">
        <div class="site-container"><div><p class="eyebrow">Find us in Uniontown</p><h2>Close enough for a real conversation.</h2><p>Call before your visit to confirm availability and make sure the vehicle you want to see is ready for a closer look.</p></div><div class="location-panel"><address>{{ site.address }}</address><a :href="`tel:${site.phone_tel}`">{{ site.phone }}</a><a :href="site.maps_url" target="_blank" rel="noopener" class="btn-accent">Get Directions <Icon name="arrow-right" /></a></div></div>
    </section>
</template>
