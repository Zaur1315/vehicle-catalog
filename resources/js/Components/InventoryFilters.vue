<script setup>
defineProps({
    form: { type: Object, required: true },
    options: { type: Object, required: true },
    models: { type: Array, default: () => [] },
});
defineEmits(['apply', 'reset']);
const ranges = [
    ['price_min', 'Min price', 0],
    ['price_max', 'Max price', 0],
    ['mileage_min', 'Min miles', 0],
    ['mileage_max', 'Max miles', 0],
    ['year_from', 'Year from', 1900],
    ['year_to', 'Year to', 1900],
];
const selects = [
    ['body_type', 'Body style', 'bodyTypes'],
    ['transmission', 'Transmission', 'transmissions'],
    ['drivetrain', 'Drivetrain', 'drivetrains'],
];
</script>
<template>
    <form class="grid gap-5" @submit.prevent="$emit('apply')">
        <label>
            <span class="form-label">Make</span>
            <select v-model="form.make" class="form-select-dark">
                <option value="">Any make</option>
                <option
                    v-for="make in options.makes"
                    :key="make.slug"
                    :value="make.slug"
                >
                    {{ make.name }}
                </option>
            </select>
        </label>
        <label>
            <span class="form-label">Model</span>
            <select v-model="form.model" class="form-select-dark">
                <option value="">Any model</option>
                <option
                    v-for="model in models"
                    :key="model.make_slug + model.slug"
                    :value="model.slug"
                >
                    {{ model.name }}
                </option>
            </select>
        </label>
        <div class="grid grid-cols-2 gap-3">
            <label v-for="[key, label, min] in ranges" :key="key">
                <span class="form-label">{{ label }}</span>
                <input
                    v-model="form[key]"
                    type="number"
                    :min="min"
                    placeholder="Any"
                    class="form-input-dark"
                />
            </label>
        </div>
        <details class="border-y border-border py-4">
            <summary class="text-sm font-bold">More details</summary>
            <div class="mt-5 grid gap-5">
                <label v-for="[key, label, source] in selects" :key="key">
                    <span class="form-label">{{ label }}</span>
                    <select v-model="form[key]" class="form-select-dark">
                        <option value="">Any</option>
                        <option
                            v-for="(text, value) in options[source]"
                            :key="value"
                            :value="value"
                        >
                            {{ text }}
                        </option>
                    </select>
                </label>
                <label>
                    <span class="form-label">Exterior color</span>
                    <select v-model="form.color" class="form-select-dark">
                        <option value="">Any color</option>
                        <option v-for="color in options.colors" :key="color">
                            {{ color }}
                        </option>
                    </select>
                </label>
            </div>
        </details>
        <button class="btn-primary w-full" type="submit">
            Show matching vehicles
        </button>
        <button class="clear-link" type="button" @click="$emit('reset')">
            Reset filters
        </button>
    </form>
</template>
