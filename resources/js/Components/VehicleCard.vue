<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({ vehicle: { type: Object, required: true } });
</script>

<template>
    <Link :href="`/inventory/${vehicle.slug}`" class="vehicle-card group">
        <div class="vehicle-card-media">
            <img v-if="vehicle.image || vehicle.image_medium || vehicle.image_thumb" :src="vehicle.image || vehicle.image_medium || vehicle.image_thumb" :alt="vehicle.name" loading="lazy" class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.035]">
            <span v-else class="text-xs font-bold uppercase tracking-[.18em] text-kohl-muted">Image coming soon</span>
            <span class="vehicle-card-status">Available</span>
        </div>
        <div class="vehicle-card-body">
            <p class="vehicle-card-meta">{{ vehicle.year }} · {{ vehicle.make || 'Pre-owned' }}</p>
            <div class="mt-2 flex items-start justify-between gap-4">
                <h3 class="text-xl font-bold leading-tight tracking-[-.035em]">{{ vehicle.name }}</h3>
                <p class="shrink-0 text-base font-bold">{{ vehicle.price }}</p>
            </div>
            <div class="mt-5 flex flex-wrap gap-x-4 gap-y-2 border-t border-kohl-line pt-4 text-xs font-bold text-kohl-muted">
                <span v-if="vehicle.mileage">{{ vehicle.mileage }}</span>
                <span v-if="vehicle.transmission">{{ vehicle.transmission }}</span>
                <span v-if="vehicle.drivetrain">{{ vehicle.drivetrain }}</span>
            </div>
        </div>
    </Link>
</template>
