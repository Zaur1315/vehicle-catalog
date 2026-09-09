<script setup>
defineProps({
    eyebrow: { type: String, default: '' },
    title: { type: String, required: true },
    description: { type: String, default: '' },
    id: { type: String, default: '' },
});
</script>

<template>
    <section :id="id || undefined" class="lead-form-section">
        <div class="site-container grid gap-12 py-16 lg:grid-cols-[.7fr_1.3fr] lg:py-24">
            <div class="lead-form-section-copy lg:pt-4">
                <p v-if="eyebrow" class="eyebrow">{{ eyebrow }}</p>
                <h2 class="mt-4 text-4xl font-bold tracking-[-.05em] text-white sm:text-5xl">{{ title }}</h2>
                <p v-if="description" class="mt-6 max-w-xl text-lg leading-8 text-white/70">{{ description }}</p>
                <div v-if="$slots.aside" class="mt-9 border-t border-white/15 pt-6 text-sm leading-7 text-white/60"><slot name="aside" /></div>
            </div>
            <div class="lead-form-surface"><slot /></div>
        </div>
    </section>
</template>
