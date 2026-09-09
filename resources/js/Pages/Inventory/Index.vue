<script setup>
import { Link, router } from '@inertiajs/vue3';
import {
    computed,
    onBeforeUnmount,
    onMounted,
    reactive,
    ref,
    watch,
} from 'vue';
import Icon from '@/Components/Icon.vue';
import InventoryFilters from '@/Components/InventoryFilters.vue';
import SiteDialog from '@/Components/SiteDialog.vue';
import SeoHead from '@/Components/SeoHead.vue';
import SiteLayout from '@/Layouts/SiteLayout.vue';
import VehicleCard from '@/Components/VehicleCard.vue';

defineOptions({ layout: SiteLayout });
const props = defineProps({
    vehicles: { type: Object, required: true },
    filters: { type: Object, default: () => ({}) },
    filterOptions: { type: Object, default: () => ({}) },
});
const filtersOpen = ref(false);
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
const models = computed(() =>
    !form.make
        ? props.filterOptions.models || []
        : (props.filterOptions.models || []).filter(
              (model) => model.make_slug === form.make,
          ),
);
const filterLabels = {
    make: 'Make',
    model: 'Model',
    year_from: 'Year from',
    year_to: 'Year to',
    price_min: 'Min price',
    price_max: 'Max price',
    mileage_min: 'Min mileage',
    mileage_max: 'Max mileage',
    body_type: 'Body style',
    transmission: 'Transmission',
    drivetrain: 'Drivetrain',
    color: 'Color',
};
const activeFilters = computed(() =>
    Object.entries(form)
        .filter(
            ([key, value]) => key !== 'sort' && value !== '' && value !== null,
        )
        .map(([key, value]) => ({
            key,
            value,
            label: filterLabels[key] || key,
        })),
);
const apply = () => {
    const query = {};
    Object.entries(form).forEach(([key, value]) => {
        if (value !== '' && value !== null) query[key] = value;
    });
    filtersOpen.value = false;
    router.get('/inventory', query, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
    });
};
const reset = () => {
    Object.keys(form).forEach((key) => {
        form[key] = key === 'sort' ? 'newest' : '';
    });
    filtersOpen.value = false;
    router.get(
        '/inventory',
        {},
        { preserveState: true, preserveScroll: true, replace: true },
    );
};
const remove = (key) => {
    form[key] = '';
    if (key === 'make') form.model = '';
    apply();
};
watch(
    () => form.make,
    () => {
        if (!models.value.some((model) => model.slug === form.model))
            form.model = '';
    },
);
</script>
<template>
    <SeoHead
        title="Find your next vehicle"
        description="Explore available pre-owned cars, trucks and SUVs at Southern York Motors in New Freedom, PA. Filter by the details that matter to you."
    />
    <section class="site-container pb-16 pt-12">
        <p class="eyebrow">The Southern York selection</p>
        <div class="mb-9 mt-4 flex flex-wrap items-end justify-between gap-5">
            <h1 class="page-title">Find your kind of drive.</h1>
            <p class="text-sm text-text-muted">
                {{ vehicles.total }} vehicle{{
                    vehicles.total === 1 ? '' : 's'
                }}
                available
            </p>
        </div>
        <div class="inventory-toolbar">
            <button class="btn-secondary lg:hidden" @click="filtersOpen = true">
                <Icon name="sliders" />
                Filters
                {{
                    activeFilters.length ? '(' + activeFilters.length + ')' : ''
                }}
            </button>
            <p class="hidden text-sm text-text-muted lg:block">
                A closer look starts with the details.
            </p>
            <label
                class="flex flex-wrap items-center gap-3 text-xs font-semibold"
            >
                <span>Sort by</span>
                <select
                    v-model="form.sort"
                    class="form-select-dark !w-auto !text-sm"
                    @change="apply"
                >
                    <option value="newest">Newest listed</option>
                    <option value="price_asc">Price: low to high</option>
                    <option value="price_desc">Price: high to low</option>
                    <option value="year_desc">Year: newest</option>
                    <option value="year_asc">Year: oldest</option>
                    <option value="mileage_asc">Mileage: lowest</option>
                    <option value="mileage_desc">Mileage: highest</option>
                </select>
            </label>
        </div>
        <div class="grid items-start gap-8 lg:grid-cols-[260px_minmax(0,1fr)]">
            <aside class="filter-panel hidden lg:block">
                <h2 class="mb-6 text-lg font-semibold">Narrow your search</h2>
                <InventoryFilters
                    :form="form"
                    :options="filterOptions"
                    :models="models"
                    @apply="apply"
                    @reset="reset"
                />
            </aside>
            <div class="min-w-0">
                <div
                    v-if="activeFilters.length"
                    class="mb-6 flex flex-wrap gap-2"
                >
                    <button
                        v-for="filter in activeFilters"
                        :key="filter.key"
                        class="filter-chip"
                        @click="remove(filter.key)"
                    >
                        {{ filter.label }}: {{ filter.value }} ×
                    </button>
                    <button class="clear-link" @click="reset">Clear all</button>
                </div>
                <div
                    v-if="vehicles.data.length"
                    class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3"
                >
                    <VehicleCard
                        v-for="vehicle in vehicles.data"
                        :key="vehicle.id"
                        :vehicle="vehicle"
                    />
                </div>
                <div v-else class="empty-state">
                    <h2 class="text-2xl font-semibold">
                        Let's widen the search.
                    </h2>
                    <p>
                        No vehicles match those details right now. Clear a
                        filter or contact us to talk about what you're looking
                        for.
                    </p>
                    <button class="btn-primary" @click="reset">
                        Clear filters
                    </button>
                    <Link href="/contact" class="btn-ghost ml-5">
                        Ask our team
                    </Link>
                </div>
                <nav
                    v-if="vehicles.links?.length > 3"
                    class="inventory-pagination"
                    aria-label="Inventory pagination"
                >
                    <component
                        :is="link.url ? Link : 'span'"
                        v-for="link in vehicles.links"
                        :key="link.label"
                        :href="link.url || undefined"
                        :aria-current="link.active ? 'page' : undefined"
                        class="pagination-link"
                        :class="
                            link.active
                                ? 'is-active'
                                : !link.url
                                  ? 'is-disabled'
                                  : ''
                        "
                        v-html="link.label"
                    />
                </nav>
            </div>
        </div>
    </section>
    <SiteDialog
        :open="filtersOpen"
        title="Find your fit"
        drawer
        @close="filtersOpen = false"
    >
        <InventoryFilters
            :form="form"
            :options="filterOptions"
            :models="models"
            @apply="apply"
            @reset="reset"
        />
    </SiteDialog>
</template>
