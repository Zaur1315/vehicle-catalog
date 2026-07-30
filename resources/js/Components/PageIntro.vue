<script setup>
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import Icon from '@/Components/Icon.vue';

const props = defineProps({
    eyebrow: { type: String, default: '' },
    title: { type: String, required: true },
    description: { type: String, default: '' },
    actionLabel: { type: String, default: '' },
    actionHref: { type: String, default: '' },
    background: { type: [String, Number], default: '1' },
});

const backgroundUrl = computed(() => `/images/background-${props.background}.webp`);
</script>

<template>
    <section class="page-intro">
        <div class="page-intro-media" :style="{ backgroundImage: `url(${backgroundUrl})` }"></div>
        <div class="page-intro-shade"></div>
        <div class="site-container relative z-10 grid gap-8 py-14 lg:grid-cols-[minmax(0,1fr)_250px] lg:items-end lg:py-20">
            <div class="max-w-4xl">
                <p v-if="eyebrow" class="eyebrow">{{ eyebrow }}</p>
                <h1 class="page-title mt-5">{{ title }}</h1>
                <p v-if="description" class="page-lede mt-6">{{ description }}</p>
            </div>
            <Link v-if="actionLabel && actionHref" :href="actionHref" class="btn-primary justify-self-start lg:justify-self-end">{{ actionLabel }} <Icon name="arrow-right" /></Link>
        </div>
    </section>
</template>
