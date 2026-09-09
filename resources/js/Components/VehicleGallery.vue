<script setup>
import { computed, ref, watch } from 'vue';
import SiteDialog from '@/Components/SiteDialog.vue';
import Icon from '@/Components/Icon.vue';
const props = defineProps({ vehicle: { type: Object, required: true } });
const active = ref(0);
const expanded = ref(false);
const failed = ref(false);
let startX = 0;
const images = computed(() => {
    const all = props.vehicle.main_image
        ? [{ url: props.vehicle.main_image, alt: props.vehicle.name }]
        : [];
    for (const image of props.vehicle.images || [])
        if (image.url && !all.some((item) => item.url === image.url))
            all.push({ ...image, alt: image.alt || props.vehicle.name });
    return all;
});
const current = computed(() => images.value[active.value]);
const move = (direction) => {
    if (images.value.length)
        active.value =
            (active.value + direction + images.value.length) %
            images.value.length;
};
watch(
    () => props.vehicle.id,
    () => {
        active.value = 0;
        expanded.value = false;
    },
);
watch(active, () => {
    failed.value = false;
});
const swipe = (event) => {
    const delta = event.changedTouches[0].clientX - startX;
    if (Math.abs(delta) > 50) move(delta < 0 ? 1 : -1);
};
</script>
<template>
    <div
        class="min-w-0"
        @keydown.left.prevent="move(-1)"
        @keydown.right.prevent="move(1)"
    >
        <div
            class="relative aspect-[4/3] overflow-hidden rounded-2xl bg-[#e8eae3]"
            @touchstart.passive="startX = $event.changedTouches[0].clientX"
            @touchend.passive="swipe"
        >
            <button
                v-if="current && !failed"
                class="h-full w-full"
                aria-label="Enlarge vehicle photograph"
                @click="expanded = true"
            >
                <img
                    :src="current.url"
                    :alt="current.alt"
                    width="1200"
                    height="900"
                    fetchpriority="high"
                    class="h-full w-full object-cover"
                    @error="failed = true"
                />
            </button>
            <div
                v-else
                class="grid h-full place-items-center p-8 text-center text-sm text-text-muted"
            >
                Photographs are currently unavailable. Ask our team for more
                details.
            </div>
            <div
                v-if="images.length > 1"
                class="absolute bottom-4 left-4 right-4 flex items-center justify-between"
            >
                <span class="rounded-full bg-white px-4 py-2 text-xs">
                    {{ active + 1 }} / {{ images.length }}
                </span>
                <div class="flex gap-2">
                    <button
                        class="gallery-control"
                        aria-label="Previous photo"
                        @click="move(-1)"
                    >
                        <Icon name="arrow-left" />
                    </button>
                    <button
                        class="gallery-control"
                        aria-label="Next photo"
                        @click="move(1)"
                    >
                        <Icon name="arrow-right" />
                    </button>
                </div>
            </div>
        </div>
        <div
            v-if="images.length > 1"
            class="mt-3 flex gap-3 overflow-x-auto pb-2"
        >
            <button
                v-for="(image, index) in images"
                :key="image.url"
                class="gallery-thumbnail"
                :class="{ 'is-active': active === index }"
                :aria-label="'View photo ' + (index + 1)"
                :aria-pressed="active === index"
                @click="active = index"
            >
                <img
                    :src="image.url"
                    :alt="image.alt"
                    width="112"
                    height="80"
                    loading="lazy"
                    class="h-full w-full object-cover"
                />
            </button>
        </div>
        <SiteDialog
            :open="expanded"
            :title="vehicle.name + ' — photos'"
            @close="expanded = false"
        >
            <div
                @touchstart.passive="startX = $event.changedTouches[0].clientX"
                @touchend.passive="swipe"
            >
                <img
                    v-if="current"
                    :src="current.url"
                    :alt="current.alt"
                    width="1200"
                    height="900"
                    class="max-h-[60dvh] w-full object-cover"
                />
            </div>
            <div class="mt-5 flex items-center justify-between">
                <button
                    class="gallery-control"
                    aria-label="Previous photo"
                    @click="move(-1)"
                >
                    <Icon name="arrow-left" />
                </button>
                <p class="text-sm">{{ active + 1 }} / {{ images.length }}</p>
                <button
                    class="gallery-control"
                    aria-label="Next photo"
                    @click="move(1)"
                >
                    <Icon name="arrow-right" />
                </button>
            </div>
        </SiteDialog>
    </div>
</template>
