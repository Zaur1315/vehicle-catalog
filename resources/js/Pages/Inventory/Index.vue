<script setup>
import {Link, router} from '@inertiajs/vue3';
import {computed, reactive, ref, watch} from 'vue';
import SeoHead from '@/Components/SeoHead.vue';
import SiteLayout from '@/Layouts/SiteLayout.vue';

defineOptions({layout: SiteLayout});

const props = defineProps({
    vehicles: {type: Object, required: true},
    filters: {type: Object, default: () => ({})},
    filterOptions: {type: Object, default: () => ({})},
});

const mobileFiltersOpen = ref(false);

const form = reactive({
    make: props.filters.make || '', model: props.filters.model || '',
    year_from: props.filters.year_from || '', year_to: props.filters.year_to || '',
    price_min: props.filters.price_min || '', price_max: props.filters.price_max || '',
    mileage_min: props.filters.mileage_min || '', mileage_max: props.filters.mileage_max || '',
    body_type: props.filters.body_type || '', transmission: props.filters.transmission || '',
    drivetrain: props.filters.drivetrain || '', color: props.filters.color || '',
    sort: props.filters.sort || 'newest',
});

const availableModels = computed(() => !form.make
    ? props.filterOptions.models || []
    : (props.filterOptions.models || []).filter((model) => model.make_slug === form.make));

const activeFilters = computed(() => {
    const labels = {
        make: 'Make',
        model: 'Model',
        year_from: 'From',
        year_to: 'To',
        price_min: 'Min price',
        price_max: 'Max price',
        mileage_min: 'Min miles',
        mileage_max: 'Max miles',
        body_type: 'Body',
        transmission: 'Transmission',
        drivetrain: 'Drive',
        color: 'Color'
    };
    return Object.entries(form).filter(([key, value]) => key !== 'sort' && value !== '' && value !== null).map(([key, value]) => ({
        key,
        label: labels[key] || key,
        value
    }));
});

const applyFilters = () => {
    const query = {};
    Object.entries(form).forEach(([key, value]) => {
        if (value !== '' && value !== null) query[key] = value;
    });
    mobileFiltersOpen.value = false;
    router.get('/inventory', query, {preserveState: true, preserveScroll: true, replace: true});
};

const clearFilter = (key) => {
    form[key] = '';
    if (key === 'make') form.model = '';
    applyFilters();
};

const resetFilters = () => {
    Object.keys(form).forEach((key) => {
        form[key] = key === 'sort' ? 'newest' : '';
    });
    mobileFiltersOpen.value = false;
    router.get('/inventory', {}, {preserveState: true, preserveScroll: true, replace: true});
};

watch(() => form.make, () => {
    form.model = '';
});
</script>

<template>
    <SeoHead title="Used Vehicle Inventory"
             description="Browse used cars, SUVs, and trucks available from Cars For Less in East Granby, Connecticut."/>

    <section class="border-b border-black/10 bg-[#f5f3ee]">
        <div class="site-container py-14 lg:py-20">
            <div class="grid gap-8 lg:grid-cols-[1fr_auto] lg:items-end">
                <div>
                    <p class="eyebrow">Current inventory</p>
                    <h1 class="mt-5 max-w-4xl text-6xl font-black leading-[0.88] tracking-[-0.07em] sm:text-7xl lg:text-8xl">
                        Find your next car.</h1>
                    <p class="mt-6 max-w-2xl text-base leading-7 text-stone-600">Search the vehicles currently available
                        at our East Granby dealership.</p>
                </div>
                <div class="flex items-baseline gap-2 border-l border-black/15 pl-6"><strong
                    class="text-5xl font-black tracking-[-0.06em]">{{ vehicles.total }}</strong><span
                    class="text-xs font-bold uppercase tracking-wider text-stone-500">available</span></div>
            </div>
        </div>
    </section>

    <section class="bg-white py-6 lg:sticky lg:top-[82px] lg:z-30 lg:border-b lg:border-black/10">
        <div class="site-container flex flex-wrap items-center justify-between gap-4">
            <button type="button" class="btn-secondary lg:hidden" @click="mobileFiltersOpen = !mobileFiltersOpen">
                Filters <span v-if="activeFilters.length">({{ activeFilters.length }})</span></button>
            <div class="hidden text-xs font-black uppercase tracking-[0.18em] text-stone-500 lg:block">Refine your
                search
            </div>
            <label class="flex items-center gap-3 text-xs font-black uppercase tracking-wider text-stone-500">
                Sort
                <select v-model="form.sort"
                        class="border-0 bg-transparent py-2 pr-8 text-sm font-black normal-case text-black focus:ring-0"
                        @change="applyFilters">
                    <option value="newest">Newest listed</option>
                    <option value="price_asc">Price: low to high</option>
                    <option value="price_desc">Price: high to low</option>
                    <option value="year_desc">Year: newest</option>
                    <option value="mileage_asc">Mileage: lowest</option>
                </select>
            </label>
        </div>
    </section>

    <section class="site-section bg-[#f5f3ee]">
        <div class="site-container grid gap-10 lg:grid-cols-[290px_1fr] xl:grid-cols-[320px_1fr]">
            <aside :class="mobileFiltersOpen ? 'block' : 'hidden lg:block'"
                   class="h-fit bg-white p-6 lg:sticky lg:top-44">
                <div class="flex items-center justify-between border-b border-black/10 pb-5"><h2
                    class="text-sm font-black uppercase tracking-[0.16em]">Filter vehicles</h2>
                    <button v-if="activeFilters.length" type="button" class="text-xs font-bold text-[#e9422c]"
                            @click="resetFilters">Clear all
                    </button>
                </div>
                <form class="mt-6 space-y-5" @submit.prevent="applyFilters">
                    <div><label
                        class="mb-2 block text-[10px] font-black uppercase tracking-wider text-stone-500">Make</label><select
                        v-model="form.make" class="form-select-dark">
                        <option value="">All makes</option>
                        <option v-for="make in filterOptions.makes" :key="make.slug" :value="make.slug">{{
                                make.name
                            }}
                        </option>
                    </select></div>
                    <div><label
                        class="mb-2 block text-[10px] font-black uppercase tracking-wider text-stone-500">Model</label><select
                        v-model="form.model" class="form-select-dark">
                        <option value="">All models</option>
                        <option v-for="model in availableModels" :key="`${model.make_slug}-${model.slug}`"
                                :value="model.slug">{{ model.name }}
                        </option>
                    </select></div>
                    <div><label class="mb-2 block text-[10px] font-black uppercase tracking-wider text-stone-500">Body
                        style</label><select v-model="form.body_type" class="form-select-dark">
                        <option value="">All body styles</option>
                        <option v-for="(label, value) in filterOptions.bodyTypes" :key="value" :value="value">{{
                                label
                            }}
                        </option>
                    </select></div>
                    <div class="grid grid-cols-2 gap-3">
                        <div><label class="mb-2 block text-[10px] font-black uppercase tracking-wider text-stone-500">Year
                            from</label><input v-model="form.year_from" type="number" class="form-input-dark"
                                               placeholder="2015"></div>
                        <div><label class="mb-2 block text-[10px] font-black uppercase tracking-wider text-stone-500">Year
                            to</label><input v-model="form.year_to" type="number" class="form-input-dark"
                                             placeholder="2026"></div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div><label class="mb-2 block text-[10px] font-black uppercase tracking-wider text-stone-500">Min
                            price</label><input v-model="form.price_min" type="number" class="form-input-dark"
                                                placeholder="$0"></div>
                        <div><label class="mb-2 block text-[10px] font-black uppercase tracking-wider text-stone-500">Max
                            price</label><input v-model="form.price_max" type="number" class="form-input-dark"
                                                placeholder="Any"></div>
                    </div>
                    <details class="border-t border-black/10 pt-5">
                        <summary class="cursor-pointer text-xs font-black uppercase tracking-wider">More filters
                        </summary>
                        <div class="mt-5 space-y-5"><select v-model="form.transmission" class="form-select-dark">
                            <option value="">Any transmission</option>
                            <option v-for="(label, value) in filterOptions.transmissions" :key="value" :value="value">
                                {{ label }}
                            </option>
                        </select><select v-model="form.drivetrain" class="form-select-dark">
                            <option value="">Any drivetrain</option>
                            <option v-for="(label, value) in filterOptions.drivetrains" :key="value" :value="value">
                                {{ label }}
                            </option>
                        </select><select v-model="form.color" class="form-select-dark">
                            <option value="">Any exterior color</option>
                            <option v-for="color in filterOptions.colors" :key="color" :value="color">{{
                                    color
                                }}
                            </option>
                        </select></div>
                    </details>
                    <button type="submit" class="btn-primary w-full">Show vehicles</button>
                </form>
            </aside>

            <div>
                <div v-if="activeFilters.length" class="mb-7 flex flex-wrap gap-2">
                    <button v-for="filter in activeFilters" :key="filter.key" type="button"
                            class="rounded-full border border-black/15 bg-white px-4 py-2 text-xs font-bold transition hover:border-[#ff4f38]"
                            @click="clearFilter(filter.key)">{{ filter.label }}: {{ filter.value }} <span
                        class="ml-2 text-stone-400">×</span></button>
                </div>

                <div v-if="vehicles.data.length" class="grid gap-x-6 gap-y-10 md:grid-cols-2 xl:grid-cols-3">
                    <Link v-for="vehicle in vehicles.data" :key="vehicle.id" :href="`/inventory/${vehicle.slug}`"
                          class="group">
                        <div class="relative aspect-[4/3] overflow-hidden bg-[#ddd8ce]"><img v-if="vehicle.image"
                                                                                             :src="vehicle.image"
                                                                                             :alt="vehicle.name"
                                                                                             class="h-full w-full object-cover transition duration-700 group-hover:scale-[1.035]">
                            <div v-else
                                 class="flex h-full items-center justify-center text-xs font-black uppercase tracking-wider text-stone-400">
                                Photo coming soon
                            </div>
                            <span
                                class="absolute left-4 top-4 rounded-full bg-white/95 px-3 py-1.5 text-[9px] font-black uppercase tracking-[0.14em]">Available</span>
                        </div>
                        <div class="border-b border-black/15 py-5"><p
                            class="text-[10px] font-black uppercase tracking-[0.18em] text-stone-500">{{ vehicle.year }}
                            · {{ vehicle.make }} · {{ vehicle.body_type }}</p>
                            <div class="mt-2 flex items-start justify-between gap-4"><h2
                                class="text-xl font-black tracking-[-0.03em] transition group-hover:text-[#e9422c]">
                                {{ vehicle.name }}</h2>
                                <p class="shrink-0 text-lg font-black">{{ vehicle.price }}</p></div>
                            <div class="mt-4 flex gap-4 text-xs text-stone-500"><span>{{ vehicle.mileage }}</span><span>{{
                                    vehicle.transmission
                                }}</span><span>{{ vehicle.drivetrain }}</span></div>
                        </div>
                    </Link>
                </div>
                <div v-else class="border border-dashed border-black/20 bg-white p-12 text-center"><h2
                    class="text-3xl font-black tracking-[-0.04em]">No exact matches.</h2>
                    <p class="mt-3 text-stone-600">Clear a few filters or call us for the latest arrivals.</p>
                    <button type="button" class="btn-primary mt-7" @click="resetFilters">Reset search</button>
                </div>

                <nav v-if="vehicles.links?.length > 3" class="mt-14 flex flex-wrap justify-center gap-2"
                     aria-label="Pagination">
                    <Link v-for="link in vehicles.links" :key="link.label" :href="link.url || '#'" preserve-scroll
                          class="flex min-h-11 min-w-11 items-center justify-center rounded-full border px-4 text-sm font-black"
                          :class="[link.active ? 'border-[#171717] bg-[#171717] text-white' : 'border-black/15 bg-white', !link.url ? 'pointer-events-none opacity-35' : 'hover:border-[#ff4f38]']"
                          v-html="link.label"/>
                </nav>
            </div>
        </div>
    </section>
</template>
