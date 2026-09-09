<script setup>
import { useSubmissionFeedback } from '@/useSubmissionFeedback.js';
const { submissionError, feedback } = useSubmissionFeedback();
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import VehicleGallery from '@/Components/VehicleGallery.vue';
import VehicleCard from '@/Components/VehicleCard.vue';
import VehicleInquiryModal from '@/Components/VehicleInquiryModal.vue';
import SeoHead from '@/Components/SeoHead.vue';
import SiteLayout from '@/Layouts/SiteLayout.vue';
defineOptions({ layout: SiteLayout });
const props = defineProps({
    vehicle: { type: Object, required: true },
    relatedVehicles: { type: Array, default: () => [] },
});
const site = computed(() => usePage().props.site || {});
const inquiryOpen = ref(false);
const inquirySuccess = ref(false);
const form = useForm({
    first_name: '',
    last_name: '',
    email: '',
    phone: '',
    preferred_contact_time: '',
    message: '',
});
const submit = () => {
    if (form.processing) return;
    form.post('/inventory/' + props.vehicle.slug + '/inquiry', {
        preserveScroll: true,
        ...feedback,
        onSuccess: () => {
            form.reset();
            inquirySuccess.value = true;
        },
    });
};
const openInquiry = () => {
    inquirySuccess.value = false;
    inquiryOpen.value = true;
};
const specs = computed(() =>
    [
        ['Mileage', props.vehicle.mileage],
        ['Transmission', props.vehicle.transmission],
        ['Drivetrain', props.vehicle.drivetrain],
        ['Engine', props.vehicle.engine],
        ['Body style', props.vehicle.body_type],
        ['Fuel type', props.vehicle.fuel_type],
        ['Exterior', props.vehicle.exterior_color],
        ['Interior', props.vehicle.interior_color],
        ['VIN', props.vehicle.vin],
        ['Stock number', props.vehicle.stock_number],
    ].filter(([, value]) => value && value !== '-'),
);
const schema = computed(() => ({
    '@context': 'https://schema.org',
    '@type': 'Vehicle',
    name: props.vehicle.name,
    vehicleIdentificationNumber: props.vehicle.vin || undefined,
    image: props.vehicle.main_image,
    brand: props.vehicle.make
        ? { '@type': 'Brand', name: props.vehicle.make }
        : undefined,
    model: props.vehicle.model,
    vehicleModelDate: String(props.vehicle.year),
}));
</script>
<template>
    <SeoHead
        :title="vehicle.seo_title || vehicle.name"
        :description="
            vehicle.seo_description || 'Explore ' +
            vehicle.name +
            ' at ' +
            site.name +
            '. View photos, specifications and availability, or contact our team in ' +
            site.city +
            '.'
        "
        :image="vehicle.main_image"
        type="product"
        :schema="schema"
    />
    <section class="site-container py-8">
        <nav
            aria-label="Breadcrumb"
            class="flex flex-wrap gap-2 text-xs text-text-muted"
        >
            <Link href="/">Home</Link>
            <span aria-hidden="true">/</span>
            <Link href="/inventory">Inventory</Link>
            <span aria-hidden="true">/</span>
            <span>{{ vehicle.name }}</span>
        </nav>
    </section>
    <section
        class="site-container grid gap-9 pb-16 lg:grid-cols-[1.5fr_1fr] lg:items-start"
    >
        <VehicleGallery :vehicle="vehicle" />
        <aside
            class="rounded-2xl border border-border bg-white p-6 sm:p-8 lg:sticky lg:top-28"
        >
            <p class="eyebrow">Available to explore</p>
            <h1
                class="mt-4 text-3xl font-semibold leading-tight tracking-tight sm:text-4xl"
            >
                {{ vehicle.name }}
            </h1>
            <p class="mt-4 text-sm text-text-muted">
                {{ vehicle.year }}
                <span v-if="vehicle.body_type">· {{ vehicle.body_type }}</span>
                <span v-if="vehicle.mileage && vehicle.mileage !== '-'">
                    · {{ vehicle.mileage }}
                </span>
            </p>
            <div class="my-7 border-y border-border py-6">
                <p class="text-xs text-text-muted">Listed price</p>
                <p class="mt-2 text-4xl font-semibold tracking-tight">
                    {{ vehicle.price }}
                </p>
            </div>
            <button class="btn-primary w-full" @click="openInquiry">
                Ask about this vehicle ↗
            </button>
            <a
                :href="'tel:' + site.phone_tel"
                class="btn-secondary mt-3 w-full"
            >
                Call {{ site.phone }}
            </a>
            <div class="mt-6 flex flex-wrap gap-5 text-xs font-bold">
                <Link
                    :href="
                        '/finance?vehicle=' + encodeURIComponent(vehicle.name)
                    "
                    class="underline underline-offset-4"
                >
                    Explore Auto Financing
                </Link>
                <Link href="/trade-in" class="underline underline-offset-4">
                    Sell or Trade
                </Link>
            </div>
            <p class="mt-6 text-xs leading-6 text-text-muted">
                Confirm availability and final purchase details with our team
                before you visit.
            </p>
        </aside>
    </section>
    <section class="border-y border-border bg-white">
        <div class="site-container grid gap-12 py-16 lg:grid-cols-2">
            <div>
                <p class="eyebrow">The details</p>
                <h2 class="heading-lg">Get to know this vehicle.</h2>
                <dl class="vehicle-spec-grid mt-7">
                    <div v-for="[label, value] in specs" :key="label">
                        <dt>{{ label }}</dt>
                        <dd>{{ value }}</dd>
                    </div>
                </dl>
            </div>
            <div>
                <div v-if="vehicle.description_html">
                    <h2 class="text-2xl font-semibold">A closer look</h2>
                    <div
                        class="vehicle-description"
                        v-html="vehicle.description_html"
                    ></div>
                </div>
                <p
                    v-else-if="vehicle.short_description"
                    class="leading-8 text-text-muted"
                >
                    {{ vehicle.short_description }}
                </p>
                <div v-if="vehicle.features?.length" class="mt-9">
                    <h2 class="text-2xl font-semibold">
                        Features & highlights
                    </h2>
                    <ul class="mt-5 grid gap-3 text-sm sm:grid-cols-2">
                        <li
                            v-for="(feature, index) in vehicle.features"
                            :key="index"
                            class="border-b border-border py-3"
                        >
                            {{
                                typeof feature === 'string'
                                    ? feature
                                    : feature.label || feature.name
                            }}
                        </li>
                    </ul>
                </div>
                <div class="mt-9 rounded-xl bg-surface-muted p-6">
                    <p class="eyebrow">See it for yourself</p>
                    <p class="mt-4 leading-7 text-text-muted">
                        A photo is a good start. A conversation can help you
                        decide what to do next.
                    </p>
                    <button class="btn-ghost mt-3" @click="openInquiry">
                        Talk to our team ↗
                    </button>
                </div>
            </div>
        </div>
    </section>
    <section v-if="relatedVehicles.length" class="site-container site-section">
        <div class="section-header">
            <div>
                <p class="eyebrow">Keep exploring</p>
                <h2 class="heading-lg">A few more possibilities.</h2>
            </div>
            <Link href="/inventory" class="btn-ghost">All inventory ↗</Link>
        </div>
        <div class="grid gap-6 md:grid-cols-3">
            <VehicleCard
                v-for="related in relatedVehicles"
                :key="related.id"
                :vehicle="related"
            />
        </div>
    </section>
    <VehicleInquiryModal
        :open="inquiryOpen"
        :vehicle="vehicle"
        :form="form"
        :success="inquirySuccess"
        :error="submissionError"
        @close="inquiryOpen = false"
        @submit="submit"
    />
</template>
