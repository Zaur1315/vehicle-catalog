<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import BrandImage from '@/Components/BrandImage.vue';
import Icon from '@/Components/Icon.vue';
import SeoHead from '@/Components/SeoHead.vue';
import SiteLayout from '@/Layouts/SiteLayout.vue';

defineOptions({ layout: SiteLayout });
const site = computed(() => usePage().props.site || {});

const principles = [
    ['Clear communication', 'Ask a direct question and get the context you need to decide what to do next.'],
    ['Useful vehicle information', 'Start with real photos, mileage, pricing, specifications, and the details available for each vehicle.'],
    ['Respect for your time', 'Explore online first, narrow the selection, and contact us when a vehicle deserves a closer look.'],
    ['A comfortable process', 'Move from browsing to questions, auto financing, or a possible trade at a pace that makes sense for you.'],
    ['Local accessibility', 'Find the dealership in New Freedom and reach the team by phone, email, message, or an in-person visit.'],
];
</script>

<template>
    <SeoHead
        title="Why Southern York"
        :description="'See how ' + site.name + ' makes pre-owned vehicle shopping more straightforward through useful information, responsive communication, and clear next steps in ' + site.city + ', Pennsylvania.'"
        image="/images/southern-york/countryside-1280.webp"
    />

    <section class="site-container py-14 md:py-20">
        <div class="mx-auto max-w-3xl text-center">
            <p class="eyebrow">Why Southern York</p>
            <h1 class="page-title mt-5">Why Southern York</h1>
            <h2 class="mx-auto mt-5 max-w-2xl text-2xl font-semibold tracking-tight sm:text-3xl">
                A more straightforward way to shop for a vehicle.
            </h2>
            <p class="mx-auto mt-6 max-w-2xl leading-8 text-text-muted">
                Useful information should come before pressure. Southern York
                Motors gives you room to explore, compare, ask questions, and
                choose the next step that fits your search.
            </p>
            <div class="mt-8 flex flex-wrap justify-center gap-3">
                <Link href="/inventory" class="btn-primary">Explore Inventory</Link>
                <Link href="/contact" class="btn-secondary">Contact Southern York Motors</Link>
            </div>
        </div>
        <div class="mt-12 aspect-[3/2] overflow-hidden rounded-2xl md:aspect-[21/8]">
            <BrandImage name="countryside" alt="A quiet road through rolling Pennsylvania farmland" eager />
        </div>
    </section>

    <section class="site-section bg-white">
        <div class="site-container grid gap-12 lg:grid-cols-[.75fr_1.25fr]">
            <div>
                <p class="eyebrow">What matters to us</p>
                <h2 class="heading-lg">Make every step useful.</h2>
                <p class="mt-6 max-w-md leading-8 text-text-muted">
                    The goal is practical: help you understand what is
                    available, answer the questions that shape your decision,
                    and make the route forward clear.
                </p>
            </div>
            <div class="principles-list">
                <article v-for="(item, index) in principles" :key="item[0]">
                    <span>{{ String(index + 1).padStart(2, '0') }}</span>
                    <div><h3>{{ item[0] }}</h3><p>{{ item[1] }}</p></div>
                </article>
            </div>
        </div>
    </section>

    <section class="home-principles">
        <div class="site-container grid gap-12 lg:grid-cols-[1fr_.85fr] lg:items-center">
            <div>
                <p class="eyebrow">Local to New Freedom</p>
                <h2 class="heading-lg">Close enough for a real conversation.</h2>
                <p class="mt-6 max-w-xl leading-8 text-white/75">
                    Our location on Susquehanna Trail South is a practical stop
                    for shoppers in Southern York County, across York County,
                    nearby Pennsylvania communities, and northern Maryland.
                </p>
            </div>
            <div class="location-card">
                <p class="eyebrow">Visit Southern York Motors</p>
                <address>{{ site.address }}</address>
                <div class="mt-7 flex flex-wrap gap-3">
                    <a :href="site.maps_url" target="_blank" rel="noopener" class="btn-light">Get Directions</a>
                    <a :href="'tel:' + site.phone_tel" class="btn-ghost !text-white">Call {{ site.phone }}</a>
                </div>
            </div>
        </div>
    </section>

    <section class="site-section site-container">
        <div class="section-header">
            <div>
                <p class="eyebrow">From browsing to buying</p>
                <h2 class="heading-lg">Keep the whole search connected.</h2>
            </div>
            <p class="body-muted max-w-md">
                Compare vehicles first, then use the service that matches the
                question in front of you.
            </p>
        </div>
        <div class="journey-links">
            <Link v-for="item in [
                ['Browse and compare', 'See current vehicles, photos, features, mileage, and pricing.', '/inventory', 'Inventory'],
                ['Plan the purchase', 'Start a preliminary request and understand what may come next.', '/finance', 'Auto Financing'],
                ['Bring your vehicle', 'Share information about a vehicle you may want to trade.', '/trade-in', 'Sell or Trade'],
                ['Ask a question', 'Reach Southern York Motors before you visit or when you are ready to proceed.', '/contact', 'Contact'],
            ]" :key="item[0]" :href="item[2]">
                <div><h3>{{ item[0] }}</h3><p>{{ item[1] }}</p></div>
                <span>{{ item[3] }} <Icon name="arrow-right" /></span>
            </Link>
        </div>
    </section>
</template>
