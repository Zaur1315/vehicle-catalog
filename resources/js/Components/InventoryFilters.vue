<script setup>
defineProps({
    form: { type: Object, required: true },
    options: { type: Object, required: true },
    models: { type: Array, default: () => [] },
});
defineEmits(['apply', 'reset']);
</script>
<template>
    <form class="inventory-filters" @submit.prevent="$emit('apply')">
        <details class="filter-dropdown"><summary>Make &amp; model</summary><div class="filter-dropdown-panel">
            <label><span class="form-label">Make</span><select v-model="form.make" class="form-select-dark"><option value="">Any make</option><option v-for="make in options.makes" :key="make.slug" :value="make.slug">{{ make.name }}</option></select></label>
            <label><span class="form-label">Model</span><select v-model="form.model" class="form-select-dark"><option value="">Any model</option><option v-for="model in models" :key="model.make_slug + model.slug" :value="model.slug">{{ model.name }}</option></select></label>
        </div></details>
        <details class="filter-dropdown"><summary>Year</summary><div class="filter-dropdown-panel grid-cols-2">
            <label><span class="form-label">From</span><input v-model="form.year_from" type="number" min="1900" placeholder="Any" class="form-input-dark" /></label>
            <label><span class="form-label">To</span><input v-model="form.year_to" type="number" min="1900" placeholder="Any" class="form-input-dark" /></label>
        </div></details>
        <details class="filter-dropdown"><summary>Price &amp; mileage</summary><div class="filter-dropdown-panel grid-cols-2">
            <label><span class="form-label">Min price</span><input v-model="form.price_min" type="number" min="0" placeholder="Any" class="form-input-dark" /></label><label><span class="form-label">Max price</span><input v-model="form.price_max" type="number" min="0" placeholder="Any" class="form-input-dark" /></label>
            <label><span class="form-label">Min miles</span><input v-model="form.mileage_min" type="number" min="0" placeholder="Any" class="form-input-dark" /></label><label><span class="form-label">Max miles</span><input v-model="form.mileage_max" type="number" min="0" placeholder="Any" class="form-input-dark" /></label>
        </div></details>
        <details class="filter-dropdown"><summary>Vehicle details</summary><div class="filter-dropdown-panel">
            <label><span class="form-label">Body style</span><select v-model="form.body_type" class="form-select-dark"><option value="">Any</option><option v-for="(text, value) in options.bodyTypes" :key="value" :value="value">{{ text }}</option></select></label>
            <label><span class="form-label">Transmission</span><select v-model="form.transmission" class="form-select-dark"><option value="">Any</option><option v-for="(text, value) in options.transmissions" :key="value" :value="value">{{ text }}</option></select></label>
            <label><span class="form-label">Drivetrain</span><select v-model="form.drivetrain" class="form-select-dark"><option value="">Any</option><option v-for="(text, value) in options.drivetrains" :key="value" :value="value">{{ text }}</option></select></label>
            <label><span class="form-label">Exterior color</span><select v-model="form.color" class="form-select-dark"><option value="">Any color</option><option v-for="color in options.colors" :key="color">{{ color }}</option></select></label>
        </div></details>
        <button class="btn-primary" type="submit">Apply filters</button>
        <button class="clear-link" type="button" @click="$emit('reset')">Reset</button>
    </form>
</template>
