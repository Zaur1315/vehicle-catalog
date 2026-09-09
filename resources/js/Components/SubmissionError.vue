<script setup>
defineProps({ message: { type: String, default: '' } });
</script>
<template>
    <p
        v-if="message"
        role="alert"
        class="mb-5 rounded-lg border border-red-200 bg-red-50 p-4 text-sm leading-6 text-red-800"
    >
        {{ message }}
    </p>
</template>
