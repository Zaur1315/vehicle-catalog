<script setup>
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import BrandImage from '@/Components/BrandImage.vue';
import ContactForm from '@/Components/ContactForm.vue';
import SeoHead from '@/Components/SeoHead.vue';
import SiteLayout from '@/Layouts/SiteLayout.vue';
defineOptions({ layout: SiteLayout });
const site = computed(() => usePage().props.site || {});
const topics = [
    ['Vehicle availability'],
    ['Finance question'],
    ['Sell or trade question'],
    ['General question'],
];
</script>
<template>
    <SeoHead
        title="Let's talk about your next vehicle"
        :description="
            'Contact ' +
            site.name +
            ' in ' +
            site.city +
            '. Call ' +
            site.phone +
            ', send a message or get directions to the dealership.'
        "
        image="/images/southern-york/visit-1280.webp"
    />
    <section class="site-container py-14 md:py-20">
        <div class="max-w-3xl">
            <p class="eyebrow">We're here to help</p>
            <h1 class="page-title mt-5">
                A question today.
                <br />
                A clearer road ahead.
            </h1>
            <p class="mt-6 max-w-xl leading-8 text-text-muted">
                Ask about a vehicle, plan a visit, or tell us what you're
                looking for. We'd like to hear from you.
            </p>
        </div>
        <div class="mt-10 grid gap-5 md:grid-cols-3">
            <a :href="'tel:' + site.phone_tel" class="purchase-option !p-6">
                <p class="eyebrow">Give us a call ↗</p>
                <span class="mt-4 text-xl font-semibold">{{ site.phone }}</span>
            </a>
            <a :href="'mailto:' + site.email" class="purchase-option !p-6">
                <p class="eyebrow">Drop us a line ↗</p>
                <span class="mt-4 break-all text-base font-semibold">
                    {{ site.email }}
                </span>
            </a>
            <a
                :href="site.maps_url"
                target="_blank"
                rel="noopener"
                class="purchase-option !p-6"
            >
                <p class="eyebrow">Come see us ↗</p>
                <span class="mt-4 text-sm font-semibold leading-7">
                    {{ site.address }}
                </span>
            </a>
        </div>
    </section>
    <section class="site-container grid gap-10 pb-20 lg:grid-cols-2">
        <div>
            <div class="aspect-[5/4] overflow-hidden rounded-2xl">
                <BrandImage
                    name="visit"
                    alt="A pickup beside a tree-lined country road"
                />
            </div>
            <h2 class="mt-7 text-2xl font-semibold">
                Make the trip with a plan.
            </h2>
            <p class="mt-4 max-w-lg leading-8 text-text-muted">
                Call before you visit to confirm vehicle availability and
                arrange a convenient time to stop by.
            </p>
            <p v-if="site.business_hours" class="mt-4 text-sm">
                {{ site.business_hours }}
            </p>
        </div>
        <div id="contact-message" class="form-surface">
            <ContactForm :topics="topics" />
        </div>
    </section>
</template>
