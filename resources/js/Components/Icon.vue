<script setup>
defineOptions({ inheritAttrs: false });

defineProps({
    name: { type: String, required: true },
});
</script>

<template>
    <svg
        :class="['h-4 w-4 shrink-0', $attrs.class]"
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        stroke-width="1.8"
        stroke-linecap="round"
        stroke-linejoin="round"
        aria-hidden="true"
        focusable="false"
    >
        <template v-if="name === 'menu'">
            <path d="M4 7h16M4 12h16M4 17h16" />
        </template>
        <template v-else-if="name === 'arrow-right'">
            <path d="M4 12h15" />
            <path d="m13 6 6 6-6 6" />
        </template>
        <template v-else-if="name === 'arrow-left'">
            <path d="M20 12H5" />
            <path d="m11 6-6 6 6 6" />
        </template>
        <template v-else-if="name === 'chevron-right'">
            <path d="m9 5 7 7-7 7" />
        </template>
        <template v-else-if="name === 'phone'">
            <path d="M6.7 3.8 9.3 3l2 4.8-2.2 1.6a15.5 15.5 0 0 0 5.5 5.5l1.6-2.2 4.8 2-.8 2.6a2 2 0 0 1-2 1.4C10.7 18.7 5.3 13.3 5.3 5.8a2 2 0 0 1 1.4-2Z" />
        </template>
        <template v-else-if="name === 'mail'">
            <rect x="3.5" y="5" width="17" height="14" rx="1.5" />
            <path d="m4.5 7 7.5 5.5L19.5 7" />
        </template>
        <template v-else-if="name === 'pin'">
            <path d="M19 10.2c0 5-7 10.3-7 10.3S5 15.2 5 10.2a7 7 0 1 1 14 0Z" />
            <circle cx="12" cy="10" r="2.2" />
        </template>
        <template v-else-if="name === 'external-link'">
            <path d="M14 4h6v6" />
            <path d="m20 4-9 9" />
            <path d="M18 13v5a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h5" />
        </template>
        <template v-else-if="name === 'send'">
            <path d="m21 3-7.5 18-3.3-7.2L3 10.5 21 3Z" />
            <path d="M10.2 13.8 21 3" />
        </template>
        <template v-else-if="name === 'sliders'">
            <path d="M4 7h16" />
            <path d="M4 17h16" />
            <circle cx="9" cy="7" r="2" />
            <circle cx="15" cy="17" r="2" />
        </template>
    </svg>
</template>
