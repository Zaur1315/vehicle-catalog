<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import VehicleCard from '@/Components/VehicleCard.vue';
import SeoHead from '@/Components/SeoHead.vue';
import Icon from '@/Components/Icon.vue';
import Reveal from '@/Components/Reveal.vue';
import SiteLayout from '@/Layouts/SiteLayout.vue';
defineOptions({ layout: SiteLayout });
defineProps({ featuredVehicles: { type: Array, default: () => [] } });
const site = computed(() => usePage().props.site || {});
const schema = computed(() => ({
    '@context': 'https://schema.org',
    '@type': 'AutoDealer',
    name: site.value.name,
    telephone: site.value.phone_tel,
    email: site.value.email,
    url: `https://${site.value.domain}`,
    image: `https://${site.value.domain}/images/advantage/home-hero-v2.webp`,
    address: {
        '@type': 'PostalAddress',
        streetAddress: site.value.street_address,
        addressLocality: site.value.city,
        addressRegion: site.value.state,
        postalCode: site.value.zip,
        addressCountry: site.value.country,
    },
}));
</script>

<template>
    <SeoHead title="Used Cars in Uniontown, PA" description="Explore available used cars, trucks, and SUVs at Advantage Auto Sales in Uniontown, Pennsylvania. View inventory details and contact our team when you are ready." image="/images/advantage/home-hero-v2.webp" preload-image :schema="schema" />
    <section class="adv-hero">
        <div class="site-container adv-hero-grid">
            <div class="adv-hero-copy">
                <p class="eyebrow">Advantage Auto Sales · Uniontown, PA</p>
                <h1>Find the right car.<br /><span>Drive with confidence.</span></h1>
                <p>Explore available vehicles, compare the details that matter, and talk directly with our Uniontown team when you are ready for the next step.</p>
                <div class="hero-actions">
                    <Link href="/inventory" class="btn-primary">Browse Inventory <Icon name="arrow-right" /></Link>
                    <Link href="/contact" class="text-link">Contact Our Team <Icon name="arrow-right" /></Link>
                </div>
                <div class="hero-meta">
                    <div><small>Located in</small><strong>Uniontown, Pennsylvania</strong></div>
                    <div><small>Questions?</small><a :href="`tel:${site.phone_tel}`">{{ site.phone }}</a></div>
                </div>
            </div>
            <div class="adv-hero-media">
                <img :src="'/images/advantage/home-hero-v2.webp'" alt="Bronze crossover displayed in an open-air automotive pavilion in Pennsylvania" width="1536" height="1024" fetchpriority="high" />
            </div>
        </div>
    </section>
    <section class="action-rail">
        <div class="site-container">
            <Link href="/inventory"><span>01</span><div><strong>Browse the lot</strong><small>See current inventory</small></div><Icon name="arrow-right" /></Link>
            <Link href="/finance"><span>02</span><div><strong>Discuss options</strong><small>Start a financing request</small></div><Icon name="arrow-right" /></Link>
            <Link href="/trade-in"><span>03</span><div><strong>Have a vehicle?</strong><small>Tell us about it</small></div><Icon name="arrow-right" /></Link>
        </div>
    </section>
    <section class="site-section site-container">
        <div class="section-header editorial-header">
            <div><p class="eyebrow">Available now</p><h2 class="heading-lg">Vehicles worth a closer look.</h2></div>
            <p>Real inventory, useful details, and a direct way to ask questions before you make the drive.</p>
        </div>
        <div v-if="featuredVehicles.length" class="vehicle-grid">
            <VehicleCard v-for="vehicle in featuredVehicles" :key="vehicle.id" :vehicle="vehicle" />
        </div>
        <div v-else class="empty-state"><p class="eyebrow">Inventory update</p><h3>New vehicles are being added.</h3><p>Contact our team for the latest availability.</p><Link href="/contact" class="btn-primary">Contact Us</Link></div>
        <div class="section-footer-link"><Link href="/inventory" class="text-link">View all inventory <Icon name="arrow-right" /></Link></div>
    </section>
    <Reveal tag="section" class="advantage-story">
        <div class="site-container story-grid">
            <div><p class="eyebrow">The Advantage approach</p><h2>A clear path from browsing to a real conversation.</h2></div>
            <div class="story-copy"><p>Start online. Look closely at the vehicles that fit. Reach a real person when a listing deserves your attention.</p><Link href="/about" class="text-link light">How we help <Icon name="arrow-right" /></Link></div>
        </div>
        <div class="site-container principles-row">
            <article><span>01</span><h3>Useful details first</h3><p>Review photos, mileage, price, and available specifications before you visit.</p></article>
            <article><span>02</span><h3>Direct communication</h3><p>Call or send a message about a vehicle, financing, or a possible trade.</p></article>
            <article><span>03</span><h3>Local and accessible</h3><p>Find us on National Pike in Uniontown, Pennsylvania.</p></article>
        </div>
    </Reveal>
    <Reveal tag="section" class="site-section site-container">
        <div class="split-callout">
            <div class="split-callout-image"><img :src="'/images/advantage/home-road.webp'" alt="A silver crossover on a road through southwestern Pennsylvania" width="1280" height="853" loading="lazy" /></div>
            <div class="split-callout-copy">
                <p class="eyebrow">Your next step, your choice</p>
                <h2>Shop at your own pace.</h2>
                <p>Browse what is available, ask a focused question, or stop by after confirming the vehicle you want to see.</p>
                <ul><li><span>01</span><Link href="/inventory">Compare available vehicles</Link></li><li><span>02</span><Link href="/finance">Talk about purchase options</Link></li><li><span>03</span><Link href="/trade-in">Discuss your current vehicle</Link></li></ul>
            </div>
        </div>
    </Reveal>
    <section class="home-contact-band">
        <div class="site-container"><div><p class="eyebrow">Ready when you are</p><h2>Let’s talk about the vehicle you have in mind.</h2></div><div><a :href="`tel:${site.phone_tel}`" class="btn-accent">Call {{ site.phone }}</a><Link href="/contact" class="text-link light">Send a message <Icon name="arrow-right" /></Link></div></div>
    </section>
</template>
