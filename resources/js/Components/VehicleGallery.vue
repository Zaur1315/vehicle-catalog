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
    const all = props.vehicle.main_image ? [{ url: props.vehicle.main_image, alt: `${props.vehicle.name} front view` }] : [];
    for (const image of props.vehicle.images || []) if (image.url && !all.some((item) => item.url === image.url)) all.push({ ...image, alt: image.alt || props.vehicle.name });
    return all;
});
const current = computed(() => images.value[active.value]);
const move = (direction) => { if (images.value.length) active.value = (active.value + direction + images.value.length) % images.value.length; };
const selectAndOpen = (index) => { active.value = index; expanded.value = true; };
watch(() => props.vehicle.id, () => { active.value = 0; expanded.value = false; });
watch(active, () => (failed.value = false));
const swipe = (event) => { const delta = event.changedTouches[0].clientX - startX; if (Math.abs(delta) > 50) move(delta < 0 ? 1 : -1); };
</script>

<template>
    <div class="vehicle-gallery" tabindex="0" aria-label="Vehicle photo gallery" @keydown.left.prevent="move(-1)" @keydown.right.prevent="move(1)">
        <button v-if="current && !failed" class="gallery-main" aria-label="Open full vehicle gallery" @click="expanded = true" @touchstart.passive="startX = $event.changedTouches[0].clientX" @touchend.passive="swipe">
            <img :src="current.url" :alt="current.alt" width="1200" height="900" fetchpriority="high" @error="failed = true" />
            <span class="gallery-expand">View gallery <Icon name="arrow-right" /></span>
            <span v-if="images.length > 1" class="gallery-count">{{ active + 1 }} / {{ images.length }}</span>
        </button>
        <div v-else class="gallery-main gallery-empty">Photographs are currently unavailable. Ask our team for more details.</div>
        <div v-if="images.length > 1" class="gallery-thumbs">
            <button v-for="(image, index) in images" :key="image.url" :class="{ 'is-active': active === index }" :aria-label="`View photo ${index + 1}`" :aria-pressed="active === index" @click="active = index">
                <img :src="image.url" :alt="image.alt" width="320" height="240" loading="lazy" />
            </button>
        </div>
        <div v-if="images.length > 1" class="gallery-mobile-controls"><button aria-label="Previous photo" @click="move(-1)"><Icon name="arrow-left" /></button><span>{{ active + 1 }} / {{ images.length }}</span><button aria-label="Next photo" @click="move(1)"><Icon name="arrow-right" /></button></div>
        <SiteDialog :open="expanded" :title="`${vehicle.name} — photos`" @close="expanded = false">
            <div class="gallery-dialog-image" @touchstart.passive="startX = $event.changedTouches[0].clientX" @touchend.passive="swipe"><img v-if="current" :src="current.url" :alt="current.alt" width="1200" height="900" /></div>
            <div class="gallery-dialog-controls"><button aria-label="Previous photo" @click="move(-1)"><Icon name="arrow-left" /></button><p>{{ active + 1 }} / {{ images.length }}</p><button aria-label="Next photo" @click="move(1)"><Icon name="arrow-right" /></button></div>
            <div class="gallery-dialog-thumbs"><button v-for="(image, index) in images" :key="image.url" :class="{ 'is-active': active === index }" @click="selectAndOpen(index)"><img :src="image.url" :alt="image.alt" width="160" height="120" loading="lazy" /></button></div>
        </SiteDialog>
    </div>
</template>
