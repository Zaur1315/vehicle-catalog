<script setup>
import { onMounted, onBeforeUnmount, ref } from 'vue';

const element = ref(null);
const visible = ref(true);
defineProps({ tag: { type: String, default: 'div' } });
let observer;

onMounted(() => {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return;
    }

    if (!('IntersectionObserver' in window)) return;
    visible.value = false;
    observer = new IntersectionObserver(([entry]) => {
        if (entry.isIntersecting) {
            visible.value = true;
            observer.disconnect();
        }
    }, { threshold: 0, rootMargin: '0px 0px -35px 0px' });
    if (element.value) observer.observe(element.value);
});

onBeforeUnmount(() => observer?.disconnect());
</script>

<template>
    <component :is="tag" ref="element" class="reveal" :class="{ 'is-visible': visible }" @focusin="visible = true"><slot /></component>
</template>
