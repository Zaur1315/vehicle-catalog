<script setup>
import {Head, usePage} from '@inertiajs/vue3';
import {computed} from 'vue';

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    description: {
        type: String,
        default: '',
    },
    canonical: {
        type: String,
        default: '',
    },
    image: {
        type: String,
        default: '',
    },
    type: {
        type: String,
        default: 'website',
    },
    schema: {
        type: [Object, Array],
        default: null,
    },
});

const page = usePage();

const site = computed(() => page.props.site || {})

const siteName = site.name;

const fullTitle = computed(() => {
    return props.title === siteName ? siteName : `${props.title} | ${siteName}`;
});

const canonicalUrl = computed(() => {
    if (props.canonical) {
        return props.canonical;
    }

    if (typeof window === 'undefined') {
        return '';
    }

    const cleanPath = page.url.split('?')[0];

    return `${window.location.origin}${cleanPath}`;
});

const absoluteImage = computed(() => {
    if (!props.image || typeof window === 'undefined') {
        return '';
    }

    if (props.image.startsWith('http')) {
        return props.image;
    }

    return `${window.location.origin}${props.image}`;
});

const jsonLd = computed(() => {
    if (!props.schema) {
        return '';
    }

    return JSON.stringify(props.schema, null, 2).replace(/</g, '\\u003c');
});
</script>

<template>
    <Head :title="fullTitle">
        <meta
            v-if="description"
            name="description"
            :content="description"
        >

        <link
            v-if="canonicalUrl"
            rel="canonical"
            :href="canonicalUrl"
        >

        <meta property="og:title" :content="fullTitle">
        <meta v-if="description" property="og:description" :content="description">
        <meta property="og:type" :content="type">
        <meta v-if="canonicalUrl" property="og:url" :content="canonicalUrl">
        <meta property="og:site_name" :content="siteName">
        <meta v-if="absoluteImage" property="og:image" :content="absoluteImage">

        <meta name="twitter:card" :content="absoluteImage ? 'summary_large_image' : 'summary'">
        <meta name="twitter:title" :content="fullTitle">
        <meta v-if="description" name="twitter:description" :content="description">
        <meta v-if="absoluteImage" name="twitter:image" :content="absoluteImage">

        <component
            :is="'script'"
            v-if="schema"
            head-key="json-ld"
            type="application/ld+json"
            v-html="jsonLd"
        />
    </Head>
</template>
