<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    eyebrow: { type: String, default: '' },
    title: { type: String, required: true },
    description: { type: String, default: '' },
    actionLabel: { type: String, default: '' },
    actionHref: { type: String, default: '' },
});
</script>

<template>
    <section class="page-intro">
        <div class="site-container grid gap-8 py-14 lg:grid-cols-[minmax(0,1fr)_250px] lg:items-end lg:py-20">
            <div>
                <p v-if="eyebrow" class="eyebrow">{{ eyebrow }}</p>
                <h1 class="page-title mt-5">{{ title }}</h1>
                <p v-if="description" class="page-lede mt-6">{{ description }}</p>
            </div>
            <Link v-if="actionLabel && actionHref" :href="actionHref" class="btn-secondary justify-self-start lg:justify-self-end">{{ actionLabel }} <span aria-hidden="true">↗</span></Link>
        </div>
    </section>
</template>
