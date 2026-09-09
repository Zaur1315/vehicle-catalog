<script setup>
import { ref, useId } from 'vue';

defineProps({
    items: { type: Array, default: () => [] },
});

const openIndex = ref(0);
const id = useId();
</script>

<template>
    <div class="space-y-3">
        <article
            v-for="(item, index) in items"
            :key="item[0]"
            class="overflow-hidden rounded-xl border border-border transition-colors duration-300"
            :class="openIndex === index ? 'bg-white' : ''"
        >
            <button
                :id="`${id}-faq-button-${index}`"
                type="button"
                class="flex min-h-20 w-full items-center justify-between gap-5 px-5 py-6 text-left font-semibold transition-colors hover:text-brand sm:px-7"
                :aria-expanded="openIndex === index"
                :aria-controls="`${id}-faq-panel-${index}`"
                @click="openIndex = openIndex === index ? -1 : index"
            >
                <span>{{ item[0] }}</span>
                <span class="faq-toggle" :class="{ 'is-open': openIndex === index }" aria-hidden="true"></span>
            </button>
            <div
                :id="`${id}-faq-panel-${index}`"
                class="faq-answer"
                :class="{ 'is-open': openIndex === index }"
                :inert="openIndex !== index"
                :aria-hidden="openIndex !== index"
                role="region"
                :aria-labelledby="`${id}-faq-button-${index}`"
            >
                <div class="faq-answer-inner">
                <p class="max-w-2xl px-5 pb-7 pt-1 text-sm leading-8 text-text-muted sm:px-7">
                    {{ item[1] }}
                </p>
                </div>
            </div>
        </article>
    </div>
</template>
