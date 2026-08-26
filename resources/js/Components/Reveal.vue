<script setup>
import { onMounted, onBeforeUnmount, ref } from 'vue';

const element = ref(null);
let observer;

onMounted(() => {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        element.value?.classList.add('is-visible');
        return;
    }

    observer = new IntersectionObserver(([entry]) => {
        if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
            observer.disconnect();
        }
    }, { threshold: 0.12 });
    if (element.value) observer.observe(element.value);
});

onBeforeUnmount(() => observer?.disconnect());
</script>

<template>
    <div ref="element" class="reveal"><slot /></div>
</template>
