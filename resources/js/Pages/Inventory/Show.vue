<script setup>
import {Link, useForm, usePage} from '@inertiajs/vue3';
import SeoHead from '@/Components/SeoHead.vue';
import {computed, nextTick, onBeforeUnmount, onMounted, ref} from 'vue';
import SiteLayout from '@/Layouts/SiteLayout.vue';

defineOptions({
    layout: SiteLayout,
});

const props = defineProps({
    vehicle: {
        type: Object,
        required: true,
    },
    relatedVehicles: {
        type: Array,
        default: () => [],
    },
});

const page = usePage();

const site = computed(() => page.props.site || {});

const dealerPhoneLabel = computed(() => {
    return site.value.phone || site.value.phone_display || site.value.phone_tel || '';
});

const dealerPhoneHref = computed(() => {
    const phone = site.value.phone_tel || dealerPhoneLabel.value;
    const normalizedPhone = String(phone || '').replace(/[^\d+]/g, '');

    return normalizedPhone ? `tel:${normalizedPhone}` : null;
});

const numericPrice = computed(() => {
    if (!props.vehicle.price) {
        return null;
    }

    const value = String(props.vehicle.price).replace(/[^\d.]/g, '');

    return value ? Number(value) : null;
});

const vehicleSchema = computed(() => {
    const schema = {
        '@context': 'https://schema.org',
        '@type': 'Vehicle',
        name: props.vehicle.name,
        description: props.vehicle.short_description || props.vehicle.description || props.vehicle.name,
        brand: {
            '@type': 'Brand',
            name: props.vehicle.make || 'Vehicle',
        },
        model: props.vehicle.model || undefined,
        vehicleModelDate: props.vehicle.year ? String(props.vehicle.year) : undefined,
        mileageFromOdometer: props.vehicle.mileage
            ? {
                '@type': 'QuantitativeValue',
                value: String(props.vehicle.mileage).replace(/[^\d]/g, ''),
                unitCode: 'SMI',
            }
            : undefined,
        vehicleTransmission: props.vehicle.transmission || undefined,
        fuelType: props.vehicle.fuel_type || undefined,
        color: props.vehicle.exterior_color || undefined,
        vehicleIdentificationNumber: props.vehicle.vin || undefined,
        image: galleryImages.value.map((image) => image.url),
        offers: {
            '@type': 'Offer',
            availability: 'https://schema.org/InStock',
            priceCurrency: 'USD',
            price: numericPrice.value || undefined,
            url: typeof window !== 'undefined' ? window.location.href : undefined,
        },
    };

    Object.keys(schema).forEach((key) => {
        if (schema[key] === undefined || schema[key] === null || schema[key] === '') {
            delete schema[key];
        }
    });

    return schema;
});

const activeImageIndex = ref(0);
const isLightboxOpen = ref(false);
const touchStartX = ref(0);
const touchStartY = ref(0);
const touchDeltaX = ref(0);
const touchDeltaY = ref(0);
const didSwipe = ref(false);
const isInquiryFormVisible = ref(false);

const SWIPE_THRESHOLD = 50;

const galleryImages = computed(() => {
    const images = [];

    if (props.vehicle.main_image) {
        images.push({
            url: props.vehicle.main_image,
            alt: props.vehicle.name,
        });
    }

    props.vehicle.images.forEach((image) => {
        if (!images.some((item) => item.url === image.url)) {
            images.push({
                url: image.url,
                alt: image.alt || props.vehicle.name,
            });
        }
    });

    return images;
});

const activeImage = computed(() => {
    return galleryImages.value[activeImageIndex.value] || {
        url: props.vehicle.main_image,
        alt: props.vehicle.name,
    };
});

const normalizedFeatures = computed(() => {
    return (props.vehicle.features || []).map((feature) => {
        if (typeof feature === 'string') {
            return feature;
        }

        return feature.label || feature.name || '';
    }).filter(Boolean);
});

const form = useForm({
    first_name: '',
    last_name: '',
    email: '',
    phone: '',
    preferred_contact_time: '',
    message: '',
});

const submit = () => {
    form.post(`/inventory/${props.vehicle.slug}/inquiry`, {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
};

const showInquiryForm = async () => {
    isInquiryFormVisible.value = true;

    await nextTick();

    document.getElementById('vehicle-inquiry-form')?.scrollIntoView({
        behavior: 'smooth',
        block: 'start',
    });
};

const openLightbox = (index = activeImageIndex.value) => {
    if (galleryImages.value.length === 0) {
        return;
    }

    activeImageIndex.value = index;
    isLightboxOpen.value = true;
};

const closeLightbox = () => {
    isLightboxOpen.value = false;
};

const handleMainImageClick = () => {
    if (didSwipe.value) {
        return;
    }

    openLightbox();
};

const previousImage = () => {
    if (galleryImages.value.length === 0) {
        return;
    }

    activeImageIndex.value = activeImageIndex.value === 0
        ? galleryImages.value.length - 1
        : activeImageIndex.value - 1;
};

const nextImage = () => {
    if (galleryImages.value.length === 0) {
        return;
    }

    activeImageIndex.value = activeImageIndex.value === galleryImages.value.length - 1
        ? 0
        : activeImageIndex.value + 1;
};

const resetTouchState = () => {
    touchStartX.value = 0;
    touchStartY.value = 0;
    touchDeltaX.value = 0;
    touchDeltaY.value = 0;
};

const handleGalleryTouchStart = (event) => {
    if (galleryImages.value.length < 2) {
        return;
    }

    const touch = event.changedTouches[0];

    touchStartX.value = touch.clientX;
    touchStartY.value = touch.clientY;
    touchDeltaX.value = 0;
    touchDeltaY.value = 0;
};

const handleGalleryTouchMove = (event) => {
    if (galleryImages.value.length < 2 || touchStartX.value === 0) {
        return;
    }

    const touch = event.changedTouches[0];

    touchDeltaX.value = touch.clientX - touchStartX.value;
    touchDeltaY.value = touch.clientY - touchStartY.value;
};

const handleGalleryTouchEnd = () => {
    if (galleryImages.value.length < 2) {
        return;
    }

    const horizontalMove = Math.abs(touchDeltaX.value);
    const verticalMove = Math.abs(touchDeltaY.value);
    const isHorizontalSwipe = horizontalMove >= SWIPE_THRESHOLD && horizontalMove > verticalMove;

    if (!isHorizontalSwipe) {
        resetTouchState();

        return;
    }

    didSwipe.value = true;

    if (touchDeltaX.value < 0) {
        nextImage();
    } else {
        previousImage();
    }

    resetTouchState();

    window.setTimeout(() => {
        didSwipe.value = false;
    }, 250);
};

const handleGalleryKeydown = (event) => {
    if (!isLightboxOpen.value) {
        return;
    }

    if (event.key === 'Escape') {
        closeLightbox();
    }

    if (event.key === 'ArrowLeft') {
        previousImage();
    }

    if (event.key === 'ArrowRight') {
        nextImage();
    }
};

onMounted(() => {
    window.addEventListener('keydown', handleGalleryKeydown);
});

onBeforeUnmount(() => {
    window.removeEventListener('keydown', handleGalleryKeydown);
});
</script>

<template>
    <SeoHead
        :title="vehicle.seo_title || vehicle.name"
        :description="vehicle.seo_description || vehicle.short_description || `View details, price, mileage, photos, and inquiry options for ${vehicle.name}.`"
        :image="vehicle.main_image"
        type="product"
        :schema="vehicleSchema"
    />
    <section class="border-b border-white/10 bg-[#080b0f]">
        <div class="site-container py-8">
            <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <div class="flex flex-wrap items-center gap-2 text-sm text-slate-400">
                        <Link href="/" class="hover:text-white">
                            Home
                        </Link>

                        <span>/</span>

                        <Link href="/inventory" class="hover:text-white">
                            Inventory
                        </Link>

                        <span>/</span>

                        <span class="text-slate-500">
                            {{ vehicle.name }}
                        </span>
                    </div>

                    <p class="eyebrow mt-7">
                        Vehicle Details
                    </p>

                    <h1 class="mt-3 heading-lg">
                        {{ vehicle.name }}
                    </h1>

                    <p class="mt-4 max-w-3xl body-muted">
                        {{
                            vehicle.short_description || 'Review vehicle details, photos, features, warranty information, and contact our sales team for availability.'
                        }}
                    </p>
                </div>

                <div class="grid grid-cols-2 border border-white/10 bg-white/[0.035] sm:grid-cols-4" style="max-width: 600px;">
                    <div class="stat-tile border-b border-white/10 sm:border-b-0">
                        <p class="text-xs uppercase tracking-wide text-slate-500">
                            Year
                        </p>
                        <p class="mt-1 text-lg font-black">
                            {{ vehicle.year || '-' }}
                        </p>
                    </div>

                    <div class="stat-tile border-b border-white/10 sm:border-b-0">
                        <p class="text-xs uppercase tracking-wide text-slate-500">
                            Mileage
                        </p>
                        <p class="mt-1 text-lg font-black">
                            {{ vehicle.mileage }}
                        </p>
                    </div>

                    <div class="stat-tile !border-l-0 sm:!border-l">
                        <p class="text-xs uppercase tracking-wide text-slate-500">
                            VIN
                        </p>
                        <p class="mt-1 text-lg font-black">
                            {{ vehicle.vin || '-' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="site-section">
        <div class="site-container">
            <div class="grid gap-8 xl:grid-cols-[1fr_420px]">
                <div>
                    <div class="dealer-panel overflow-hidden rounded-2xl">
                        <div
                            class="relative touch-pan-y select-none bg-black"
                            @touchstart.passive="handleGalleryTouchStart"
                            @touchmove.passive="handleGalleryTouchMove"
                            @touchend="handleGalleryTouchEnd"
                        >
                            <img
                                :src="activeImage.url"
                                :alt="activeImage.alt"
                                class="h-[360px] w-full cursor-zoom-in object-cover sm:h-[520px] lg:h-[640px]"
                                draggable="false"
                                @click="handleMainImageClick"
                            >

                            <div
                                class="absolute left-5 top-5 rounded-xl bg-black/70 px-4 py-2 text-xs font-black uppercase tracking-wide text-white backdrop-blur">
                                {{ activeImageIndex + 1 }} / {{ galleryImages.length || 1 }}
                            </div>

                            <div
                                v-if="galleryImages.length > 1"
                                class="absolute inset-x-5 top-1/2 flex -translate-y-1/2 justify-between"
                            >
                                <button
                                    type="button"
                                    aria-label="Previous image"
                                    class="flex h-11 w-11 items-center justify-center rounded-xl border border-white/20 bg-black/60 text-xl font-black text-white backdrop-blur transition hover:bg-black"
                                    @click.stop="previousImage"
                                >
                                    ‹
                                </button>

                                <button
                                    type="button"
                                    aria-label="Next image"
                                    class="flex h-11 w-11 items-center justify-center rounded-xl border border-white/20 bg-black/60 text-xl font-black text-white backdrop-blur transition hover:bg-black"
                                    @click.stop="nextImage"
                                >
                                    ›
                                </button>
                            </div>
                        </div>

                        <div
                            v-if="galleryImages.length > 1"
                            class="grid grid-cols-3 gap-3 border-t border-white/10 bg-[#080b0f] p-4 sm:grid-cols-5 lg:grid-cols-6"
                        >
                            <button
                                v-for="(image, index) in galleryImages"
                                :key="image.url"
                                type="button"
                                class="overflow-hidden rounded-xl border transition"
                                :class="activeImageIndex === index ? 'border-amber-300' : 'border-white/10 opacity-70 hover:opacity-100'"
                                :aria-label="`View image ${index + 1}`"
                                @click="openLightbox(index)"
                            >
                                <img
                                    :src="image.url"
                                    :alt="image.alt"
                                    class="h-20 w-full object-cover"
                                >
                            </button>
                        </div>
                    </div>

                    <div class="mt-5 grid gap-3 sm:grid-cols-2">
                        <button
                            type="button"
                            class="btn-primary w-full"
                            @click="showInquiryForm"
                        >
                            Request more information
                        </button>

                        <a
                            v-if="dealerPhoneHref"
                            :href="dealerPhoneHref"
                            class="btn-secondary w-full"
                        >
                            Call us now: {{ dealerPhoneLabel }}
                        </a>
                    </div>

                    <Transition
                        enter-active-class="transition duration-200 ease-out"
                        enter-from-class="opacity-0 translate-y-2"
                        enter-to-class="opacity-100 translate-y-0"
                    >
                        <form
                            v-if="isInquiryFormVisible"
                            id="vehicle-inquiry-form"
                            class="dealer-panel mt-5 space-y-4 rounded-2xl p-6"
                            @submit.prevent="submit"
                        >
                            <div>
                                <label class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-400">
                                    First Name
                                </label>
                                <input
                                    v-model="form.first_name"
                                    required
                                    class="form-input-dark"
                                    placeholder="John"
                                >
                                <p v-if="form.errors.first_name" class="mt-2 text-sm text-red-300">
                                    {{ form.errors.first_name }}
                                </p>
                            </div>

                            <div>
                                <label class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-400">
                                    Last Name
                                </label>
                                <input
                                    v-model="form.last_name"
                                    class="form-input-dark"
                                    placeholder="Smith"
                                >
                            </div>

                            <div>
                                <label class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-400">
                                    Phone
                                </label>
                                <input
                                    v-model="form.phone"
                                    required
                                    class="form-input-dark"
                                    placeholder="+1 (000) 000-0000"
                                >
                                <p v-if="form.errors.phone" class="mt-2 text-sm text-red-300">
                                    {{ form.errors.phone }}
                                </p>
                            </div>

                            <div>
                                <label class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-400">
                                    Email
                                </label>
                                <input
                                    v-model="form.email"
                                    type="email"
                                    class="form-input-dark"
                                    placeholder="john@example.com"
                                >
                                <p v-if="form.errors.email" class="mt-2 text-sm text-red-300">
                                    {{ form.errors.email }}
                                </p>
                            </div>

                            <div>
                                <label class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-400">
                                    Preferred Contact Time
                                </label>
                                <input
                                    v-model="form.preferred_contact_time"
                                    class="form-input-dark"
                                    placeholder="Morning, afternoon, evening..."
                                >
                            </div>

                            <div>
                                <label class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-400">
                                    Message
                                </label>
                                <textarea
                                    v-model="form.message"
                                    rows="4"
                                    class="form-input-dark"
                                    :placeholder="`I am interested in the ${vehicle.name}.`"
                                />
                            </div>

                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="btn-primary w-full disabled:opacity-60"
                            >
                                Request Information
                            </button>
                        </form>
                    </Transition>

                    <div class="mt-8 grid gap-6 lg:grid-cols-[0.9fr_1.1fr]">
                        <section class="dealer-panel rounded-2xl p-6">
                            <p class="eyebrow">
                                Specifications
                            </p>

                            <dl class="mt-6 divide-y divide-white/10">
                                <div class="grid grid-cols-2 gap-4 py-4">
                                    <dt class="text-sm text-slate-500">Make</dt>
                                    <dd class="text-sm font-bold text-white">{{ vehicle.make || '-' }}</dd>
                                </div>

                                <div class="grid grid-cols-2 gap-4 py-4">
                                    <dt class="text-sm text-slate-500">Model</dt>
                                    <dd class="text-sm font-bold text-white">{{ vehicle.model || '-' }}</dd>
                                </div>

                                <div class="grid grid-cols-2 gap-4 py-4">
                                    <dt class="text-sm text-slate-500">Body Type</dt>
                                    <dd class="text-sm font-bold text-white">{{ vehicle.body_type || '-' }}</dd>
                                </div>

                                <div class="grid grid-cols-2 gap-4 py-4">
                                    <dt class="text-sm text-slate-500">Transmission</dt>
                                    <dd class="text-sm font-bold text-white">{{ vehicle.transmission || '-' }}</dd>
                                </div>

                                <div class="grid grid-cols-2 gap-4 py-4">
                                    <dt class="text-sm text-slate-500">Drivetrain</dt>
                                    <dd class="text-sm font-bold text-white">{{ vehicle.drivetrain || '-' }}</dd>
                                </div>

                                <div class="grid grid-cols-2 gap-4 py-4">
                                    <dt class="text-sm text-slate-500">Engine</dt>
                                    <dd class="text-sm font-bold text-white">{{ vehicle.engine || '-' }}</dd>
                                </div>

                                <div class="grid grid-cols-2 gap-4 py-4">
                                    <dt class="text-sm text-slate-500">Fuel Type</dt>
                                    <dd class="text-sm font-bold text-white">{{ vehicle.fuel_type || '-' }}</dd>
                                </div>

                                <div class="grid grid-cols-2 gap-4 py-4">
                                    <dt class="text-sm text-slate-500">Exterior Color</dt>
                                    <dd class="text-sm font-bold text-white">{{ vehicle.exterior_color || '-' }}</dd>
                                </div>

                                <div class="grid grid-cols-2 gap-4 py-4">
                                    <dt class="text-sm text-slate-500">Interior Color</dt>
                                    <dd class="text-sm font-bold text-white">{{ vehicle.interior_color || '-' }}</dd>
                                </div>
                            </dl>
                        </section>

                        <section class="dealer-panel rounded-2xl p-6">
                            <p class="eyebrow">
                                Features
                            </p>

                            <div
                                v-if="normalizedFeatures.length"
                                class="mt-6 grid gap-3 sm:grid-cols-2"
                            >
                                <div
                                    v-for="feature in normalizedFeatures"
                                    :key="feature"
                                    class="border border-white/10 bg-white/[0.035] px-4 py-3 text-sm font-bold text-slate-200"
                                >
                                    {{ feature }}
                                </div>
                            </div>

                            <p v-else class="mt-6 text-sm text-slate-400">
                                Feature list will be updated soon.
                            </p>
                        </section>
                    </div>

                    <section class="dealer-panel mt-8 rounded-2xl p-6">
                        <div class="section-header mb-0">
                            <div>
                                <p class="eyebrow">
                                    Vehicle Overview
                                </p>

                                <h2 class="mt-3 text-3xl font-black">
                                    Description
                                </h2>
                            </div>
                        </div>

                        <div
                            v-if="vehicle.description"
                            class="vehicle-description mt-6"
                            v-html="vehicle.description"
                        />

                        <p v-else class="mt-6 body-muted">
                            Contact our sales team for additional information about this vehicle.
                        </p>
                    </section>

                    <section class="mt-8 grid gap-5 md:grid-cols-3">
                        <article class="dealer-card p-6">
                            <p class="text-3xl font-black text-amber-300">
                                14
                            </p>
                            <h3 class="mt-4 text-lg font-black">
                                Day Return
                            </h3>
                            <p class="mt-3 text-sm leading-6 text-slate-400">
                                Return policy terms are explained before purchase confirmation.
                            </p>
                        </article>

                        <article class="dealer-card p-6">
                            <p class="text-3xl font-black text-amber-300">
                                90
                            </p>
                            <h3 class="mt-4 text-lg font-black">
                                Day Warranty
                            </h3>
                            <p class="mt-3 text-sm leading-6 text-slate-400">
                                90 days / 5,000 miles warranty coverage for selected components.
                            </p>
                        </article>

                        <article class="dealer-card p-6">
                            <p class="text-3xl font-black text-amber-300">
                                7–14
                            </p>
                            <h3 class="mt-4 text-lg font-black">
                                Delivery Days
                            </h3>
                            <p class="mt-3 text-sm leading-6 text-slate-400">
                                Enclosed trailer delivery is available for out-of-state buyers.
                            </p>
                        </article>
                    </section>
                </div>

                <aside class="xl:sticky xl:top-32 xl:h-fit">
                    <div class="dealer-panel overflow-hidden rounded-2xl">
                        <div class="border-b border-white/10 bg-[#080b0f] px-6 py-5">
                            <p class="text-xs font-black uppercase tracking-[0.24em] text-slate-500">
                                Internet Price
                            </p>

                            <p class="mt-2 text-4xl font-black text-amber-300">
                                {{ vehicle.price }}
                            </p>
                        </div>

                        <div class="grid grid-cols-2 divide-x divide-white/10 border-b border-white/10">
                            <div class="p-5">
                                <p class="text-xs uppercase tracking-wide text-slate-500">
                                    Condition
                                </p>
                                <p class="mt-1 font-black capitalize">
                                    {{ vehicle.condition || '-' }}
                                </p>
                            </div>

                            <div class="p-5">
                                <p class="text-xs uppercase tracking-wide text-slate-500">
                                    Stock #
                                </p>
                                <p class="mt-1 font-black">
                                    {{ vehicle.stock_number || '-' }}
                                </p>
                            </div>
                        </div>

                    </div>

                    <div class="mt-5 border border-white/10 bg-white/[0.025] p-5">
                        <p class="text-xs font-black uppercase tracking-[0.24em] text-slate-500">
                            Buyer Notes
                        </p>

                        <ul class="mt-4 space-y-3 text-sm leading-6 text-slate-400">
                            <li>Vehicle availability must be confirmed with the sales team.</li>
                            <li>Delivery, warranty, and return terms may depend on buyer location.</li>
                            <li>Pricing, mileage, and specifications are subject to final verification.</li>
                        </ul>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    <div
        v-if="isLightboxOpen"
        class="fixed inset-0 z-50 flex touch-pan-y select-none items-center justify-center bg-black/90 p-4"
        @click.self="closeLightbox"
        @touchstart.passive="handleGalleryTouchStart"
        @touchmove.passive="handleGalleryTouchMove"
        @touchend="handleGalleryTouchEnd"
    >
        <button
            type="button"
            aria-label="Close gallery"
            class="absolute right-5 top-5 z-10 flex h-11 w-11 items-center justify-center rounded-xl border border-white/20 bg-black/60 text-3xl font-black leading-none text-white backdrop-blur transition hover:bg-black"
            @click="closeLightbox"
        >
            ×
        </button>

        <button
            v-if="galleryImages.length > 1"
            type="button"
            aria-label="Previous image"
            class="absolute left-5 top-1/2 z-10 flex h-12 w-12 -translate-y-1/2 items-center justify-center rounded-xl border border-white/20 bg-black/60 text-3xl font-black text-white backdrop-blur transition hover:bg-black"
            @click="previousImage"
        >
            ‹
        </button>

        <img
            :src="activeImage.url"
            :alt="activeImage.alt"
            class="max-h-[90vh] max-w-full rounded-2xl object-contain"
            draggable="false"
        >

        <button
            v-if="galleryImages.length > 1"
            type="button"
            aria-label="Next image"
            class="absolute right-5 top-1/2 z-10 flex h-12 w-12 -translate-y-1/2 items-center justify-center rounded-xl border border-white/20 bg-black/60 text-3xl font-black text-white backdrop-blur transition hover:bg-black"
            @click="nextImage"
        >
            ›
        </button>
    </div>

    <section v-if="relatedVehicles.length" class="site-section-tight border-t border-white/10 bg-white/[0.025]">
        <div class="site-container">
            <div class="section-header">
                <div>
                    <p class="eyebrow">
                        Related Inventory
                    </p>

                    <h2 class="mt-3 heading-lg">
                        Similar vehicles
                    </h2>
                </div>

                <Link href="/inventory" class="btn-secondary">
                    View All Inventory
                </Link>
            </div>

            <div class="grid gap-5 md:grid-cols-3">
                <Link
                    v-for="relatedVehicle in relatedVehicles"
                    :key="relatedVehicle.id"
                    :href="`/inventory/${relatedVehicle.slug}`"
                    class="dealer-card overflow-hidden"
                >
                    <img
                        :src="relatedVehicle.image"
                        :alt="relatedVehicle.name"
                        class="h-56 w-full object-cover"
                    >

                    <div class="p-5">
                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-slate-500">
                            {{ relatedVehicle.year }}
                        </p>

                        <h3 class="mt-2 text-xl font-black">
                            {{ relatedVehicle.name }}
                        </h3>

                        <div class="mt-5 flex items-center justify-between">
                            <p class="font-black text-amber-300">
                                {{ relatedVehicle.price }}
                            </p>

                            <p class="text-sm text-slate-400">
                                {{ relatedVehicle.mileage }}
                            </p>
                        </div>
                    </div>
                </Link>
            </div>
        </div>
    </section>
</template>
