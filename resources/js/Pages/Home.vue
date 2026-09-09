<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import BrandImage from '@/Components/BrandImage.vue';
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
    url: 'https://' + site.value.domain,
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
    <SeoHead
        :title="'Used vehicles in ' + site.city + ', ' + site.state"
        :description="
            'Discover pre-owned vehicles at ' +
            site.name +
            '. Browse current inventory, explore auto financing, or tell us about the vehicle you may want to trade.'
        "
        image="/images/southern-york/road-1280.webp"
        :schema="schema"
    />
    <section class="home-hero site-container">
        <div class="home-hero-copy">
            <p class="eyebrow">Southern York County, Pennsylvania</p>
            <h1>
                A new chapter.
                <br />
                A better
                <em>drive.</em>
            </h1>
            <p>
                For the everyday miles and the places you haven't been. Find a
                pre-owned vehicle that feels right for what comes next.
            </p>
            <div class="mt-8 flex flex-wrap items-center gap-x-8 gap-y-5">
                <Link href="/inventory" class="btn-primary">
                    Explore the inventory
                    <Icon name="arrow-right" />
                </Link>
                <Link href="/about" class="btn-ghost">
                    Why Southern York
                </Link>
            </div>
            <div class="hero-location">
                <Icon name="pin" />
                <span>
                    Your local dealership in {{ site.city }}, {{ site.state }}
                </span>
            </div>
        </div>
        <div class="home-hero-media">
            <BrandImage
                name="road"
                alt="A graphite crossover beside rolling Pennsylvania countryside"
                eager
            />
            <div class="hero-image-caption">
                <span>Southern York Motors</span>
                <span>Made for the road ahead ↗</span>
            </div>
        </div>
    </section>
    <section class="path-strip">
        <div class="site-container grid md:grid-cols-3">
            <Link
                v-for="item in [
                    [
                        '01',
                        'Find your fit',
                        'Browse available vehicles',
                        '/inventory',
                    ],
                    [
                        '02',
                        'Explore your options',
                        'Visit Auto Financing',
                        '/finance',
                    ],
                    [
                        '03',
                        'Bring your current vehicle',
                        'Start a sell or trade request',
                        '/trade-in',
                    ],
                ]"
                :key="item[0]"
                :href="item[3]"
                class="path-link"
            >
                <span class="path-number">{{ item[0] }}</span>
                <span>
                    <strong>{{ item[1] }}</strong>
                    <small>{{ item[2] }}</small>
                </span>
                <Icon name="arrow-right" />
            </Link>
        </div>
    </section>
    <section class="site-section site-container">
        <div class="section-header">
            <div>
                <p class="eyebrow">On the lot</p>
                <h2 class="heading-lg">Meet your next possibility.</h2>
            </div>
            <Link href="/inventory" class="btn-ghost">
                View all inventory
                <Icon name="arrow-right" />
            </Link>
        </div>
        <div
            v-if="featuredVehicles.length"
            class="grid gap-x-7 gap-y-10 md:grid-cols-2 xl:grid-cols-3"
        >
            <VehicleCard
                v-for="vehicle in featuredVehicles"
                :key="vehicle.id"
                :vehicle="vehicle"
            />
        </div>
        <div v-else class="empty-state">
            <h3 class="text-2xl">Let's find out what's available.</h3>
            <p>
                Our selection changes. Browse the full inventory or call our
                team for the latest details.
            </p>
            <Link href="/inventory" class="btn-primary">Browse inventory</Link>
        </div>
    </section>
    <Reveal tag="section" class="home-principles">
        <div class="site-container grid gap-12 lg:grid-cols-[1fr_1.1fr]">
            <div>
                <p class="eyebrow">Shop with confidence</p>
                <h2 class="heading-lg">A clearer way to move forward.</h2>
                <p class="mt-6 max-w-md leading-8">
                    Start online, look closely at the vehicles that interest
                    you, and reach a real person when you are ready. We keep
                    each next step easy to understand.
                </p>
                <Link href="/about" class="btn-light mt-8">
                    Why Southern York
                    <Icon name="arrow-right" />
                </Link>
            </div>
            <div>
                <article
                    v-for="item in [
                        [
                            'Straightforward shopping',
                            'Vehicle photos, listed prices, mileage and specifications give you useful information before you visit.',
                        ],
                        [
                            'Real support',
                            'Ask about availability, auto financing, or your current vehicle by phone or message before making the trip.',
                        ],
                        [
                            'Flexible next steps',
                            'Browse first, start a preliminary financing request, or tell us about a vehicle you may want to trade.',
                        ],
                        [
                            'Local convenience',
                            'Visit us in New Freedom, within reach of drivers across Southern York County and nearby Maryland communities.',
                        ],
                    ]"
                    :key="item[0]"
                    class="principle"
                >
                    <h3>{{ item[0] }}</h3>
                    <p>{{ item[1] }}</p>
                </article>
            </div>
        </div>
    </Reveal>
    <Reveal tag="section" class="site-section site-container">
        <div class="process-heading">
            <div>
                <p class="eyebrow">How buying a vehicle works</p>
                <h2 class="heading-lg">
                    A simple way to find your next vehicle.
                </h2>
            </div>
            <p>
                Use the site to narrow the search, then bring us into the
                conversation when you want details or help with the next step.
            </p>
        </div>
        <ol class="numbered-process mt-10">
            <li v-for="step in [
                ['Explore inventory', 'See what is currently available and narrow the list around your needs.'],
                ['Find the right fit', 'Review photos, mileage, features, pricing, and vehicle details.'],
                ['Talk with our team', 'Ask about a vehicle and discuss auto financing or a possible trade.'],
                ['Take the next step', 'Contact Southern York Motors to continue the purchase conversation.'],
            ]" :key="step[0]">
                <span aria-hidden="true"></span>
                <h3>{{ step[0] }}</h3>
                <p>{{ step[1] }}</p>
            </li>
        </ol>
    </Reveal>
    <Reveal tag="section" class="site-section home-services">
        <div class="site-container">
        <div class="section-header">
            <div>
                <p class="eyebrow">More than inventory</p>
                <h2 class="heading-lg">Choose where to begin.</h2>
            </div>
            <p class="body-muted max-w-md">
                Every shopper arrives at a different point. Start with the part
                of the process that matters to you now.
            </p>
        </div>
        <div class="service-paths">
            <article v-for="item in [
                ['Find your vehicle', 'Compare the pre-owned vehicles currently on the lot.', '/inventory', 'Browse Inventory'],
                ['Explore auto financing', 'Send a preliminary request and start a conversation about possible next steps.', '/finance', 'Auto Financing'],
                ['Sell or trade your car', 'Share the basics about your current vehicle so our team can follow up.', '/trade-in', 'Sell or Trade'],
            ]" :key="item[0]" class="service-path">
                <Icon name="arrow-right" />
                <h3>{{ item[0] }}</h3>
                <p>{{ item[1] }}</p>
                <Link :href="item[2]" class="btn-ghost">{{ item[3] }}</Link>
            </article>
        </div>
        </div>
    </Reveal>
    <Reveal tag="section" class="local-callout">
        <div class="site-container grid gap-8 lg:grid-cols-[1fr_auto] lg:items-end">
            <div>
                <p class="eyebrow">Serving drivers around Southern Pennsylvania</p>
                <h2 class="heading-lg">Local to New Freedom.</h2>
                <p class="mt-5 max-w-2xl leading-8 text-white/75">
                    Southern York Motors is located on Susquehanna Trail South,
                    convenient for shoppers in Southern York County, across York
                    County, and in nearby northern Maryland communities.
                </p>
            </div>
            <Link href="/contact" class="btn-light">Plan your visit</Link>
        </div>
    </Reveal>
</template>
