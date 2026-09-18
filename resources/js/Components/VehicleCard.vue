<script setup>
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import Icon from '@/Components/Icon.vue';
defineProps({ vehicle: { type: Object, required: true } });
const failed = ref(false);
</script>
<template>
    <article class="vehicle-card group">
        <div class="vehicle-card-media">
            <Link :href="'/inventory/' + vehicle.slug" :aria-label="`View ${vehicle.name}`">
                <img v-if="!failed && (vehicle.image_medium || vehicle.image)" :src="vehicle.image_medium || vehicle.image" :alt="vehicle.name" width="800" height="600" loading="lazy" @error="failed = true" />
                <span v-else class="vehicle-placeholder">Photography coming soon</span>
            </Link>
            <span v-if="vehicle.body_type" class="vehicle-badge">{{ vehicle.body_type }}</span>
        </div>
        <div class="vehicle-card-body">
            <p class="vehicle-kicker">{{ vehicle.year }} · {{ vehicle.make || 'Pre-owned' }}</p>
            <h3><Link :href="'/inventory/' + vehicle.slug">{{ vehicle.name }}</Link></h3>
            <dl class="vehicle-card-specs">
                <div v-if="vehicle.mileage && vehicle.mileage !== '-'"><dt>Mileage</dt><dd>{{ vehicle.mileage }}</dd></div>
                <div v-if="vehicle.drivetrain"><dt>Drive</dt><dd>{{ vehicle.drivetrain }}</dd></div>
                <div v-if="vehicle.transmission"><dt>Transmission</dt><dd>{{ vehicle.transmission }}</dd></div>
            </dl>
            <div class="vehicle-card-footer">
                <p class="vehicle-price">{{ vehicle.price }}</p>
                <Link :href="'/inventory/' + vehicle.slug" class="vehicle-card-arrow" aria-label="View vehicle details"><Icon name="arrow-right" /></Link>
            </div>
        </div>
    </article>
</template>
