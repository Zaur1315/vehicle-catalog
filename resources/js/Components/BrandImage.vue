<script setup>
defineProps({
    name: { type: String, required: true },
    alt: { type: String, default: '' },
    eager: Boolean,
});
</script>

<template>
    <img
        :src="`/images/southern-york/${name}-1280.webp`"
        :srcset="`/images/southern-york/${name}-640.webp 640w, /images/southern-york/${name}-1280.webp 1280w`"
        sizes="(max-width: 767px) 100vw, 60vw"
        :alt="alt"
        width="1536"
        height="1024"
        :loading="eager ? 'eager' : 'lazy'"
        :fetchpriority="eager ? 'high' : 'auto'"
        class="brand-image"
    />
</template>
