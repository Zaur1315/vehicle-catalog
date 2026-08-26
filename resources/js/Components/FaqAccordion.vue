<script setup>
import { ref } from 'vue';

defineProps({
    items: { type: Array, default: () => [] },
});

const openIndex = ref(0);
</script>

<template>
    <div class="border-t border-border">
        <article v-for="(item, index) in items" :key="item[0]" class="border-b border-border" :class="openIndex === index ? 'bg-white' : ''">
            <button :id="`faq-button-${index}`" class="flex min-h-16 w-full items-center justify-between gap-6 px-1 py-5 text-left font-semibold transition-colors hover:text-brand" :aria-expanded="openIndex === index" :aria-controls="`faq-panel-${index}`" @click="openIndex = openIndex === index ? -1 : index">
                <span>{{ item[0] }}</span>
                <span :class="['faq-icon text-brand', openIndex === index ? 'is-open' : '']" aria-hidden="true"></span>
            </button>
            <div :id="`faq-panel-${index}`" class="faq-panel" :class="openIndex === index ? 'is-open' : ''" role="region" :aria-labelledby="`faq-button-${index}`"><div><p class="max-w-2xl px-1 pb-5 leading-7 text-text-muted">{{ item[1] }}</p></div></div>
        </article>
    </div>
</template>
