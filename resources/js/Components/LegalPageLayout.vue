<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import SeoHead from '@/Components/SeoHead.vue';
defineProps({
    title: String,
    description: String,
    seoTitle: String,
    seoDescription: String,
    lastUpdated: String,
    sections: Array,
    contactTitle: String,
});
const site = computed(() => usePage().props.site || {});
</script>
<template>
    <SeoHead :title="seoTitle" :description="seoDescription" />
    <section class="site-container py-14 md:py-20">
        <p class="eyebrow">Information & policies</p>
        <h1 class="page-title mt-5">{{ title }}</h1>
        <p class="mt-6 max-w-2xl leading-8 text-text-muted">
            {{ description }}
        </p>
        <p class="mt-5 text-xs text-text-muted">
            Last updated: {{ lastUpdated }}
        </p>
    </section>
    <div class="border-t border-border bg-white">
        <div
            class="site-container grid gap-10 py-10 lg:grid-cols-[240px_minmax(0,1fr)] lg:gap-16"
        >
            <aside class="lg:sticky lg:top-28 lg:self-start">
                <details class="rounded-xl border border-border p-5" open>
                    <summary class="text-sm font-bold">On this page</summary>
                    <nav
                        class="mt-5 grid gap-3 text-xs leading-6"
                        aria-label="On this page"
                    >
                        <a
                            v-for="section in sections"
                            :key="section.id"
                            :href="'#' + section.id"
                            class="hover:underline"
                        >
                            {{ section.label }}
                        </a>
                    </nav>
                </details>
            </aside>
            <article class="min-w-0 max-w-3xl">
                <slot />
                <section class="my-10 rounded-2xl bg-surface-muted p-6 sm:p-9">
                    <h2 class="text-2xl font-semibold">{{ contactTitle }}</h2>
                    <p class="mt-4 text-sm leading-7">
                        {{ site.name }}
                        <br />
                        {{ site.address }}
                    </p>
                    <a
                        :href="'mailto:' + site.email"
                        class="mt-4 block break-all text-sm underline"
                    >
                        {{ site.email }}
                    </a>
                    <a
                        :href="'tel:' + site.phone_tel"
                        class="mt-3 block text-sm underline"
                    >
                        {{ site.phone }}
                    </a>
                    <Link href="/contact" class="btn-primary mt-6">
                        Contact our team ↗
                    </Link>
                </section>
            </article>
        </div>
    </div>
</template>
