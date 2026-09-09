<script setup>
import { nextTick, onBeforeUnmount, ref, watch } from 'vue';
const props = defineProps({
    open: Boolean,
    title: { type: String, required: true },
    drawer: Boolean,
});
const emit = defineEmits(['close']);
const dialog = ref(null);
let previousFocus;
watch(
    () => props.open,
    async (open) => {
        await nextTick();
        if (open && !dialog.value.open) {
            previousFocus = document.activeElement;
            dialog.value.showModal();
            document.documentElement.classList.add('dialog-open');
        } else if (!open && dialog.value.open) {
            dialog.value.close();
            document.documentElement.classList.remove('dialog-open');
            previousFocus?.focus?.();
        }
    },
    { immediate: true },
);
onBeforeUnmount(() => document.documentElement.classList.remove('dialog-open'));
</script>
<template>
    <Teleport to="body">
        <dialog
            ref="dialog"
            class="site-dialog"
            :class="{ 'site-dialog-drawer': drawer }"
            :aria-label="title"
            @cancel.prevent="emit('close')"
            @click="
                (event) => {
                    if (event.target === dialog) emit('close');
                }
            "
        >
            <div class="dialog-inner">
                <header class="mb-7 flex items-center justify-between gap-5">
                    <h2 class="text-2xl font-semibold">{{ title }}</h2>
                    <button
                        type="button"
                        class="icon-button shrink-0"
                        aria-label="Close dialog"
                        @click="emit('close')"
                    >
                        ×
                    </button>
                </header>
                <slot />
            </div>
        </dialog>
    </Teleport>
</template>
