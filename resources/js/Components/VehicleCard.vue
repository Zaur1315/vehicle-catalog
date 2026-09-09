<script setup>
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import Icon from '@/Components/Icon.vue';
defineProps({ vehicle: { type: Object, required: true } });
const failed = ref(false);
</script>
<template>
    <Link :href="'/inventory/' + vehicle.slug" class="vehicle-card group">
        <div class="vehicle-card-media">
            <img
                v-if="!failed && (vehicle.image_medium || vehicle.image)"
                :src="vehicle.image_medium || vehicle.image"
                :alt="vehicle.name"
                width="800"
                height="600"
                loading="lazy"
                @error="failed = true"
            />
            <span v-else class="text-sm text-text-muted">
                Photography coming soon
            </span>
            <span class="vehicle-card-arrow"><Icon name="arrow-right" /></span>
        </div>
        <div class="vehicle-card-body">
            <p class="eyebrow">
                {{ vehicle.make || 'Pre-owned' }}
                <span v-if="vehicle.body_type">/ {{ vehicle.body_type }}</span>
            </p>
            <h3>{{ vehicle.name }}</h3>
            <p class="mt-3 text-sm text-text-muted">
                {{
                    vehicle.mileage && vehicle.mileage !== '-'
                        ? vehicle.mileage
                        : 'Ask about mileage'
                }}
                <span v-if="vehicle.transmission">
                    · {{ vehicle.transmission }}
                </span>
            </p>
            <div
                class="mt-5 flex flex-wrap items-end justify-between gap-3 border-t border-border pt-4"
            >
                <p class="vehicle-price">{{ vehicle.price }}</p>
                <span class="text-xs font-semibold text-brand">
                    View details ↗
                </span>
            </div>
        </div>
    </Link>
</template>
