<script setup>
import { Link } from '@inertiajs/vue3';
import Icon from '@/Components/Icon.vue';

defineProps({ vehicle: { type: Object, required: true } });
</script>

<template>
    <Link :href="`/inventory/${vehicle.slug}`" class="vehicle-card group overflow-hidden">
        <div class="vehicle-card-media">
            <img v-if="vehicle.image || vehicle.image_medium || vehicle.image_thumb" :src="vehicle.image_medium || vehicle.image || vehicle.image_thumb" :alt="vehicle.name" loading="lazy" width="800" height="600" class="h-full w-full object-cover transition duration-700 ease-out-premium group-hover:scale-[1.045] group-hover:brightness-105">
            <span v-else class="text-xs font-bold uppercase tracking-[.18em] text-text-muted">Image coming soon</span>
            <span class="vehicle-card-status">Available</span>
        </div>
        <div class="vehicle-card-body">
            <div class="flex items-start justify-between gap-4">
                <div><p class="vehicle-card-meta">{{ vehicle.year }} · {{ vehicle.make || 'Pre-owned' }}</p><h3 class="mt-2 text-xl font-bold leading-tight tracking-[-.035em] transition-colors group-hover:text-brand">{{ vehicle.name }}</h3></div>
                <p class="shrink-0 text-lg font-bold tracking-[-.03em]">{{ vehicle.price }}</p>
            </div>
            <div class="mt-5 flex items-center justify-between border-t border-border pt-4 text-xs font-bold text-text-muted"><span>{{ vehicle.mileage || 'Mileage available on request' }}</span><span class="inline-flex items-center gap-2 text-ink transition group-hover:text-brand">View vehicle <Icon name="arrow-right" class="transition-transform group-hover:translate-x-1" /></span></div>
        </div>
    </Link>
</template>
