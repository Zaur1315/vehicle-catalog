<script setup>
import { computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import Icon from '@/Components/Icon.vue';
import Reveal from '@/Components/Reveal.vue';
import SeoHead from '@/Components/SeoHead.vue';

defineProps({
    title: { type: String, required: true },
    description: { type: String, default: '' },
    seoTitle: { type: String, required: true },
    seoDescription: { type: String, required: true },
    heroImage: { type: String, required: true },
    lastUpdated: { type: String, required: true },
    sections: { type: Array, default: () => [] },
    contactTitle: { type: String, default: 'Questions about this document?' },
});

const site = computed(() => usePage().props.site || {});
</script>

<template>
    <SeoHead :title="seoTitle" :description="seoDescription" :image="heroImage" />
    <section class="legal-hero">
        <img :src="heroImage" alt="" class="legal-hero-image" aria-hidden="true">
        <div class="legal-hero-overlay" aria-hidden="true"></div>
        <div class="site-container relative z-10 flex min-h-[430px] items-end py-16 lg:min-h-[500px] lg:items-center lg:py-24">
            <div class="max-w-3xl text-white"><p class="delmar-kicker">Legal</p><h1 class="mt-5 text-5xl font-bold leading-[.94] tracking-[-.06em] sm:text-6xl lg:text-8xl">{{ title }}</h1><p v-if="description" class="mt-6 max-w-2xl text-lg leading-8 text-white/70">{{ description }}</p></div>
        </div>
    </section>
    <main class="legal-page">
        <div class="site-container grid gap-12 py-16 lg:grid-cols-[minmax(0,1fr)_260px] lg:gap-20 lg:py-24">
            <article class="legal-document">
                <div class="legal-document-meta">Last updated: {{ lastUpdated }}</div>
                <Reveal><slot /></Reveal>
                <section class="legal-contact-callout" aria-labelledby="legal-contact-title"><p class="eyebrow">Need help?</p><h2 id="legal-contact-title" class="mt-3 text-2xl font-bold">{{ contactTitle }}</h2><p class="mt-3 max-w-2xl leading-7 text-text-muted">Contact {{ site.name }} with questions about this website or the information in this document.</p><div class="mt-6 flex flex-wrap gap-x-6 gap-y-3 text-sm font-semibold"><a v-if="site.email" :href="`mailto:${site.email}`" class="inline-flex items-center gap-2 transition hover:text-brand"><Icon name="mail" />{{ site.email }}</a><a v-if="site.phone" :href="`tel:${site.phone_tel}`" class="inline-flex items-center gap-2 transition hover:text-brand"><Icon name="phone" />{{ site.phone }}</a></div><p class="mt-4 text-sm leading-6 text-text-muted">{{ site.address }}</p></section>
                <div class="mt-8 flex flex-wrap gap-5 text-sm font-semibold"><Link v-if="title === 'Privacy Policy'" href="/terms" class="text-ink underline decoration-brand decoration-2 underline-offset-4 transition hover:text-brand">Read Terms of Use</Link><Link v-else href="/privacy-policy" class="text-ink underline decoration-brand decoration-2 underline-offset-4 transition hover:text-brand">Read Privacy Policy</Link><Link href="/contact" class="text-ink underline decoration-brand decoration-2 underline-offset-4 transition hover:text-brand">Contact Delmar</Link></div>
            </article>
            <details class="legal-toc-mobile"><summary>On this page</summary><nav aria-label="On this page" class="mt-4 grid gap-3"><a v-for="section in sections" :key="section.id" :href="`#${section.id}`">{{ section.label }}</a></nav></details>
            <aside class="legal-toc" aria-label="On this page"><p class="eyebrow">On this page</p><nav class="mt-5 grid gap-3 border-t border-border pt-5"><a v-for="section in sections" :key="section.id" :href="`#${section.id}`">{{ section.label }}</a></nav></aside>
        </div>
    </main>
</template>
