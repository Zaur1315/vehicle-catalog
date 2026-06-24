<script setup>
import {Link, router} from '@inertiajs/vue3';
import SeoHead from '@/Components/SeoHead.vue';
import {computed, reactive, watch} from 'vue';
import SiteLayout from '@/Layouts/SiteLayout.vue';

defineOptions({
    layout: SiteLayout,
});

const props = defineProps({
    vehicles: {
        type: Object,
        required: true,
    },
    filters: {
        type: Object,
        default: () => ({}),
    },
    filterOptions: {
        type: Object,
        default: () => ({}),
    },
});

const form = reactive({
    make: props.filters.make || '',
    model: props.filters.model || '',
    year_from: props.filters.year_from || '',
    year_to: props.filters.year_to || '',
    price_min: props.filters.price_min || '',
    price_max: props.filters.price_max || '',
    mileage_min: props.filters.mileage_min || '',
    mileage_max: props.filters.mileage_max || '',
    body_type: props.filters.body_type || '',
    transmission: props.filters.transmission || '',
    drivetrain: props.filters.drivetrain || '',
    color: props.filters.color || '',
    sort: props.filters.sort || 'newest',
});

const availableModels = computed(() => {
    if (!form.make) {
        return props.filterOptions.models || [];
    }

    return (props.filterOptions.models || []).filter((model) => model.make_slug === form.make);
});

const applyFilters = () => {
    const query = {};

    Object.entries(form).forEach(([key, value]) => {
        if (value !== '' && value !== null && value !== undefined) {
            query[key] = value;
        }
    });

    router.get('/inventory', query, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
    });
};

const resetFilters = () => {
    Object.keys(form).forEach((key) => {
        form[key] = key === 'sort' ? 'newest' : '';
    });

    router.get('/inventory', {}, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
    });
};

watch(
    () => form.make,
    () => {
        form.model = '';
    },
);
</script>

<template>
    <SeoHead
        title="Inventory"
        description="Browse available vehicles by make, model, year, price, mileage, body type, transmission, drivetrain, and color."
    />
    <section class="border-b border-white/10 bg-[#080b0f]">
        <div class="site-container py-10">
            <div class="grid gap-6 lg:grid-cols-[1fr_auto] lg:items-end">
                <div>
                    <p class="eyebrow">
                        Inventory
                    </p>

                    <h1 class="mt-3 heading-lg">
                        Available Vehicles
                    </h1>

                    <p class="mt-4 max-w-2xl body-muted">
                        Search current inventory by make, model, year, price, mileage, body type, transmission,
                        drivetrain, and color.
                    </p>
                </div>

                <div class="border border-white/10 bg-white/[0.035] px-5 py-4">
                    <p class="text-sm text-slate-400">
                        Showing
                        <span class="font-black text-white">{{ vehicles.total }}</span>
                        vehicles
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="site-section">
        <div class="site-container">
            <div class="grid gap-8 xl:grid-cols-[340px_1fr]">
                <aside class="h-fit border border-white/10 bg-white/[0.025]">
                    <div class="border-b border-white/10 px-5 py-4">
                        <h2 class="text-sm font-black uppercase tracking-[0.24em]">
                            Refine Search
                        </h2>
                    </div>

                    <form class="space-y-5 p-5" @submit.prevent="applyFilters">
                        <div>
                            <label class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-400">
                                Make
                            </label>

                            <select v-model="form.make" class="form-select-dark">
                                <option value="">Any make</option>
                                <option
                                    v-for="make in filterOptions.makes"
                                    :key="make.slug"
                                    :value="make.slug"
                                >
                                    {{ make.name }}
                                </option>
                            </select>
                        </div>

                        <div>
                            <label class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-400">
                                Model
                            </label>

                            <select v-model="form.model" class="form-select-dark">
                                <option value="">Any model</option>
                                <option
                                    v-for="model in availableModels"
                                    :key="`${model.make_slug}-${model.slug}`"
                                    :value="model.slug"
                                >
                                    {{ model.name }}
                                </option>
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-400">
                                    Year from
                                </label>
                                <input v-model="form.year_from" type="number" class="form-input-dark">
                            </div>

                            <div>
                                <label class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-400">
                                    Year to
                                </label>
                                <input v-model="form.year_to" type="number" class="form-input-dark">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-400">
                                    Price min
                                </label>
                                <input v-model="form.price_min" type="number" class="form-input-dark">
                            </div>

                            <div>
                                <label class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-400">
                                    Price max
                                </label>
                                <input v-model="form.price_max" type="number" class="form-input-dark">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-400">
                                    Mileage min
                                </label>
                                <input v-model="form.mileage_min" type="number" class="form-input-dark">
                            </div>

                            <div>
                                <label class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-400">
                                    Mileage max
                                </label>
                                <input v-model="form.mileage_max" type="number" class="form-input-dark">
                            </div>
                        </div>

                        <div>
                            <label class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-400">
                                Body type
                            </label>

                            <select v-model="form.body_type" class="form-select-dark">
                                <option value="">Any body</option>
                                <option
                                    v-for="(label, value) in filterOptions.bodyTypes"
                                    :key="value"
                                    :value="value"
                                >
                                    {{ label }}
                                </option>
                            </select>
                        </div>

                        <div>
                            <label class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-400">
                                Transmission
                            </label>

                            <select v-model="form.transmission" class="form-select-dark">
                                <option value="">Any transmission</option>
                                <option
                                    v-for="(label, value) in filterOptions.transmissions"
                                    :key="value"
                                    :value="value"
                                >
                                    {{ label }}
                                </option>
                            </select>
                        </div>

                        <div>
                            <label class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-400">
                                Drivetrain
                            </label>

                            <select v-model="form.drivetrain" class="form-select-dark">
                                <option value="">Any drivetrain</option>
                                <option
                                    v-for="(label, value) in filterOptions.drivetrains"
                                    :key="value"
                                    :value="value"
                                >
                                    {{ label }}
                                </option>
                            </select>
                        </div>

                        <div>
                            <label class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-400">
                                Exterior color
                            </label>

                            <select v-model="form.color" class="form-select-dark">
                                <option value="">Any color</option>
                                <option
                                    v-for="color in filterOptions.colors"
                                    :key="color"
                                    :value="color"
                                >
                                    {{ color }}
                                </option>
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-3 pt-2">
                            <button type="submit" class="btn-primary">
                                Apply
                            </button>

                            <button type="button" class="btn-secondary" @click="resetFilters">
                                Reset
                            </button>
                        </div>
                    </form>
                </aside>

                <div>
                    <div
                        class="mb-5 flex flex-col gap-4 border-b border-white/10 pb-5 md:flex-row md:items-center md:justify-between">
                        <p class="text-sm text-slate-400">
                            {{ vehicles.from || 0 }}–{{ vehicles.to || 0 }} of {{ vehicles.total }} vehicles
                        </p>

                        <div class="flex items-center gap-3">
                            <label class="text-xs font-bold uppercase tracking-wide text-slate-400">
                                Sort
                            </label>

                            <select v-model="form.sort" class="form-select-dark min-w-56" @change="applyFilters">
                                <option value="newest">Newest</option>
                                <option value="price_asc">Price: Low to High</option>
                                <option value="price_desc">Price: High to Low</option>
                                <option value="year_desc">Year: Newest</option>
                                <option value="year_asc">Year: Oldest</option>
                                <option value="mileage_asc">Mileage: Low to High</option>
                                <option value="mileage_desc">Mileage: High to Low</option>
                            </select>
                        </div>
                    </div>

                    <div class="space-y-5">
                        <article
                            v-for="vehicle in vehicles.data"
                            :key="vehicle.id"
                            class="group grid overflow-hidden border border-white/10 bg-white/[0.025] transition hover:border-amber-300/40 hover:bg-white/[0.045] lg:grid-cols-[280px_1fr_220px]"
                        >
                            <Link :href="`/inventory/${vehicle.slug}`" class="block bg-black/30">
                                <img
                                    :src="vehicle.image"
                                    :alt="vehicle.name"
                                    class="h-64 w-full object-cover transition duration-500 group-hover:scale-[1.03] lg:h-full"
                                >
                            </Link>

                            <div class="border-y border-white/10 p-5 lg:border-x lg:border-y-0">
                                <p class="text-xs font-bold uppercase tracking-[0.2em] text-slate-500">
                                    {{ vehicle.year }} · {{ vehicle.make }} {{ vehicle.model }}
                                </p>

                                <h2 class="mt-2 text-2xl font-black tracking-tight">
                                    <Link :href="`/inventory/${vehicle.slug}`" class="hover:text-amber-300">
                                        {{ vehicle.name }}
                                    </Link>
                                </h2>

                                <div class="mt-5 grid gap-3 text-sm text-slate-300 sm:grid-cols-2 xl:grid-cols-3">
                                    <div>
                                        <span
                                            class="block text-xs uppercase tracking-wide text-slate-500">Mileage</span>
                                        {{ vehicle.mileage }}
                                    </div>

                                    <div>
                                        <span class="block text-xs uppercase tracking-wide text-slate-500">Body</span>
                                        {{ vehicle.body_type || '-' }}
                                    </div>

                                    <div>
                                        <span
                                            class="block text-xs uppercase tracking-wide text-slate-500">Transmission</span>
                                        {{ vehicle.transmission || '-' }}
                                    </div>

                                    <div>
                                        <span
                                            class="block text-xs uppercase tracking-wide text-slate-500">Drivetrain</span>
                                        {{ vehicle.drivetrain || '-' }}
                                    </div>

                                    <div>
                                        <span class="block text-xs uppercase tracking-wide text-slate-500">Color</span>
                                        {{ vehicle.exterior_color || '-' }}
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col justify-between p-5">
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-slate-500">
                                        Internet Price
                                    </p>

                                    <p class="mt-2 text-3xl font-black text-amber-300">
                                        {{ vehicle.price }}
                                    </p>
                                </div>

                                <div class="mt-6 space-y-3">
                                    <Link :href="`/inventory/${vehicle.slug}`" class="btn-primary w-full">
                                        Details
                                    </Link>

                                    <Link href="/contact" class="btn-secondary w-full">
                                        Contact
                                    </Link>
                                </div>
                            </div>
                        </article>

                        <div
                            v-if="vehicles.data.length === 0"
                            class="border border-white/10 bg-white/[0.025] px-6 py-16 text-center"
                        >
                            <h2 class="text-2xl font-black">
                                No vehicles found
                            </h2>

                            <p class="mt-3 text-slate-400">
                                Try adjusting filters or resetting search.
                            </p>

                            <button type="button" class="btn-primary mt-6" @click="resetFilters">
                                Reset Filters
                            </button>
                        </div>
                    </div>

                    <div v-if="vehicles.links?.length > 3" class="mt-8 flex flex-wrap gap-2">
                        <Link
                            v-for="link in vehicles.links"
                            :key="link.label"
                            :href="link.url || '#'"
                            class="rounded-lg border border-white/10 px-4 py-2 text-sm font-bold"
                            :class="[
                                link.active ? 'bg-amber-300 text-neutral-950' : 'text-slate-300 hover:bg-white/5',
                                !link.url ? 'pointer-events-none opacity-40' : '',
                            ]"
                            v-html="link.label"
                        />
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
