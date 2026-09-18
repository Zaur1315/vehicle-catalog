<script setup>
import { useSubmissionFeedback } from '@/useSubmissionFeedback.js';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import VehicleGallery from '@/Components/VehicleGallery.vue';
import VehicleCard from '@/Components/VehicleCard.vue';
import VehicleInquiryModal from '@/Components/VehicleInquiryModal.vue';
import SeoHead from '@/Components/SeoHead.vue';
import Icon from '@/Components/Icon.vue';
import SiteLayout from '@/Layouts/SiteLayout.vue';
defineOptions({ layout: SiteLayout });
const props = defineProps({ vehicle: { type: Object, required: true }, relatedVehicles: { type: Array, default: () => [] } });
const site = computed(() => usePage().props.site || {});
const inquiryOpen = ref(false);
const inquirySuccess = ref(false);
const { submissionError, feedback } = useSubmissionFeedback();
const form = useForm({ first_name: '', last_name: '', email: '', phone: '', preferred_contact_time: '', message: '' });
const submit = () => {
    if (form.processing) return;
    form.post('/inventory/' + props.vehicle.slug + '/inquiry', { preserveScroll: true, ...feedback, onSuccess: () => { form.reset(); inquirySuccess.value = true; } });
};
const openInquiry = () => { inquirySuccess.value = false; inquiryOpen.value = true; };
const specs = computed(() => [
    ['Mileage', props.vehicle.mileage], ['Transmission', props.vehicle.transmission], ['Drivetrain', props.vehicle.drivetrain],
    ['Engine', props.vehicle.engine], ['Body style', props.vehicle.body_type], ['Fuel type', props.vehicle.fuel_type],
    ['Exterior', props.vehicle.exterior_color], ['Interior', props.vehicle.interior_color], ['VIN', props.vehicle.vin],
    ['Stock number', props.vehicle.stock_number],
].filter(([, value]) => value && value !== '-'));
const schema = computed(() => ({
    '@context': 'https://schema.org', '@type': 'Vehicle', name: props.vehicle.name,
    vehicleIdentificationNumber: props.vehicle.vin || undefined, image: props.vehicle.main_image,
    brand: props.vehicle.make ? { '@type': 'Brand', name: props.vehicle.make } : undefined,
    model: props.vehicle.model, vehicleModelDate: String(props.vehicle.year),
}));
</script>

<template>
    <SeoHead :title="vehicle.seo_title || vehicle.name" :description="vehicle.seo_description || `View photos and details for ${vehicle.name} at ${site.name} in ${site.city}, Pennsylvania.`" :image="vehicle.main_image" type="product" :schema="schema" />
    <section class="vehicle-page-head">
        <div class="site-container">
            <nav aria-label="Breadcrumb" class="breadcrumbs"><Link href="/">Home</Link><span>/</span><Link href="/inventory">Inventory</Link><span>/</span><span aria-current="page">{{ vehicle.name }}</span></nav>
            <div class="vehicle-title-row"><div><p class="eyebrow">{{ vehicle.make }} {{ vehicle.model }}</p><h1>{{ vehicle.name }}</h1><p><span v-if="vehicle.mileage && vehicle.mileage !== '-'">{{ vehicle.mileage }}</span><span v-if="vehicle.stock_number">Stock #{{ vehicle.stock_number }}</span></p></div><div class="vehicle-price-block"><small>Listed price</small><strong>{{ vehicle.price }}</strong></div></div>
        </div>
    </section>
    <section class="site-container vehicle-main-grid">
        <VehicleGallery :vehicle="vehicle" />
        <aside class="vehicle-action-panel">
            <p class="eyebrow">Interested in this vehicle?</p>
            <h2>Get the details directly from our team.</h2>
            <p>Confirm availability, ask a question, or arrange a time to take a closer look.</p>
            <button class="btn-primary w-full" @click="openInquiry">Contact About This Vehicle <Icon name="arrow-right" /></button>
            <a :href="`tel:${site.phone_tel}`" class="btn-secondary w-full"><Icon name="phone" /> Call {{ site.phone }}</a>
            <div class="action-panel-links"><Link :href="`/finance?vehicle=${encodeURIComponent(vehicle.name)}`">Financing</Link><Link href="/trade-in">Sell / Trade</Link></div>
            <p class="action-note">Please confirm availability and final purchase details before visiting.</p>
        </aside>
    </section>
    <section class="vehicle-information">
        <div class="site-container details-grid">
            <div><p class="eyebrow">Vehicle details</p><h2 class="heading-lg">The information that matters.</h2><dl class="vehicle-spec-grid"><div v-for="[label, value] in specs" :key="label"><dt>{{ label }}</dt><dd>{{ value }}</dd></div></dl></div>
            <div>
                <div v-if="vehicle.description_html"><p class="eyebrow">Overview</p><h2 class="detail-heading">A closer look</h2><div class="vehicle-description" v-html="vehicle.description_html"></div></div>
                <p v-else-if="vehicle.short_description" class="detail-summary">{{ vehicle.short_description }}</p>
                <div v-if="vehicle.features?.length" class="feature-list"><h2>Features & highlights</h2><ul><li v-for="(feature, index) in vehicle.features" :key="index">{{ typeof feature === 'string' ? feature : feature.label || feature.name }}</li></ul></div>
            </div>
        </div>
    </section>
    <section v-if="relatedVehicles.length" class="site-container site-section">
        <div class="section-header"><div><p class="eyebrow">Keep exploring</p><h2 class="heading-lg">More vehicles to consider.</h2></div><Link href="/inventory" class="text-link">All inventory <Icon name="arrow-right" /></Link></div>
        <div class="vehicle-grid related-grid"><VehicleCard v-for="related in relatedVehicles" :key="related.id" :vehicle="related" /></div>
    </section>
    <div class="mobile-vehicle-actions"><a :href="`tel:${site.phone_tel}`"><Icon name="phone" /> Call</a><button @click="openInquiry">Contact</button></div>
    <VehicleInquiryModal :open="inquiryOpen" :vehicle="vehicle" :form="form" :success="inquirySuccess" :error="submissionError" @close="inquiryOpen = false" @submit="submit" />
</template>
