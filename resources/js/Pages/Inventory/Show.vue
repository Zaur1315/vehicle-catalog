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
        :description="vehicle.seo_description || vehicle.short_description || `View price, mileage, photos, specifications, and inquiry options for ${vehicle.name}.`"
        :image="vehicle.main_image"
        type="product"
        :schema="vehicleSchema"
    />

    <!-- Light vehicle banner -->
    <section class="border-b border-black/10 bg-[#f5f3ee]">
        <div class="site-container pb-12 pt-12 lg:pb-16 lg:pt-16">
            <nav
                class="flex flex-wrap items-center gap-2 text-xs font-bold text-stone-500"
                aria-label="Breadcrumb"
            >
                <Link
                    href="/"
                    class="transition hover:text-[#e9422c]"
                >
                    Home
                </Link>

                <span>/</span>

                <Link
                    href="/inventory"
                    class="transition hover:text-[#e9422c]"
                >
                    Inventory
                </Link>

                <span>/</span>

                <span class="text-stone-400">
                    {{ vehicle.name }}
                </span>
            </nav>

            <div
                class="mt-10 grid gap-8 lg:grid-cols-[1fr_auto] lg:items-end"
            >
                <div>
                    <p class="eyebrow">
                        Available vehicle
                    </p>

                    <h1
                        class="mt-5 max-w-5xl text-5xl font-black leading-[0.9] tracking-[-0.065em] sm:text-6xl lg:text-7xl"
                    >
                        {{ vehicle.name }}
                    </h1>

                    <p
                        v-if="vehicle.short_description"
                        class="mt-6 max-w-3xl text-base leading-7 text-stone-600"
                    >
                        {{ vehicle.short_description }}
                    </p>
                </div>

                <div
                    class="grid grid-cols-3 divide-x divide-black/10 border border-black/10 bg-white"
                >
                    <div class="px-5 py-4">
                        <p
                            class="text-[9px] font-black uppercase tracking-[0.15em] text-stone-400"
                        >
                            Year
                        </p>

                        <p class="mt-2 text-base font-black">
                            {{ vehicle.year || '—' }}
                        </p>
                    </div>

                    <div class="px-5 py-4">
                        <p
                            class="text-[9px] font-black uppercase tracking-[0.15em] text-stone-400"
                        >
                            Mileage
                        </p>

                        <p class="mt-2 text-base font-black">
                            {{ vehicle.mileage || '—' }}
                        </p>
                    </div>

                    <div class="px-5 py-4">
                        <p
                            class="text-[9px] font-black uppercase tracking-[0.15em] text-stone-400"
                        >
                            Stock
                        </p>

                        <p class="mt-2 text-base font-black">
                            {{ vehicle.stock_number || '—' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery and purchase panel -->
    <section class="bg-white py-10 lg:py-16">
        <div class="site-container">
            <div class="grid gap-8 xl:grid-cols-[1fr_390px]">
                <div>
                    <div class="overflow-hidden bg-[#e3dfd7]">
                        <div
                            class="relative touch-pan-y select-none"
                            @touchstart.passive="handleGalleryTouchStart"
                            @touchmove.passive="handleGalleryTouchMove"
                            @touchend="handleGalleryTouchEnd"
                        >
                            <img
                                v-if="activeImage.url"
                                :src="activeImage.url"
                                :alt="activeImage.alt"
                                class="h-[360px] w-full cursor-zoom-in object-cover sm:h-[520px] lg:h-[650px]"
                                draggable="false"
                                @click="handleMainImageClick"
                            >

                            <div
                                v-else
                                class="flex h-[360px] items-center justify-center text-xs font-black uppercase tracking-widest text-stone-400 sm:h-[520px] lg:h-[650px]"
                            >
                                Photo coming soon
                            </div>

                            <span
                                class="absolute left-5 top-5 rounded-full bg-white/95 px-4 py-2 text-[10px] font-black uppercase tracking-[0.14em] text-black shadow-sm"
                            >
                                {{ activeImageIndex + 1 }}
                                /
                                {{ galleryImages.length || 1 }}
                            </span>

                            <button
                                v-if="activeImage.url"
                                type="button"
                                class="absolute bottom-5 right-5 rounded-full bg-[#171717]/90 px-5 py-3 text-[10px] font-black uppercase tracking-[0.14em] text-white backdrop-blur transition hover:bg-[#ff4f38]"
                                @click="handleMainImageClick"
                            >
                                Expand photo
                            </button>

                            <div
                                v-if="galleryImages.length > 1"
                                class="pointer-events-none absolute inset-x-5 top-1/2 flex -translate-y-1/2 justify-between"
                            >
                                <button
                                    type="button"
                                    aria-label="Previous image"
                                    class="pointer-events-auto flex h-12 w-12 items-center justify-center rounded-full bg-white/90 text-2xl font-black text-black shadow-lg transition hover:bg-[#ff4f38] hover:text-white"
                                    @click.stop="previousImage"
                                >
                                    ‹
                                </button>

                                <button
                                    type="button"
                                    aria-label="Next image"
                                    class="pointer-events-auto flex h-12 w-12 items-center justify-center rounded-full bg-white/90 text-2xl font-black text-black shadow-lg transition hover:bg-[#ff4f38] hover:text-white"
                                    @click.stop="nextImage"
                                >
                                    ›
                                </button>
                            </div>
                        </div>

                        <div
                            v-if="galleryImages.length > 1"
                            class="grid grid-cols-4 gap-2 border-t border-black/10 bg-[#f5f3ee] p-3 sm:grid-cols-6 lg:grid-cols-8"
                        >
                            <button
                                v-for="(image, index) in galleryImages"
                                :key="image.url"
                                type="button"
                                class="relative overflow-hidden border-2 transition"
                                :class="activeImageIndex === index
                                    ? 'border-[#ff4f38]'
                                    : 'border-transparent opacity-65 hover:opacity-100'"
                                :aria-label="`View image ${index + 1}`"
                                @click="activeImageIndex = index"
                            >
                                <img
                                    :src="image.url"
                                    :alt="image.alt"
                                    class="aspect-[4/3] w-full object-cover"
                                >
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sticky purchase card -->
                <aside class="xl:sticky xl:top-32 xl:h-fit">
                    <div class="border border-black/10 bg-[#f5f3ee]">
                        <div class="border-b border-black/10 p-6">
                            <p
                                class="text-[10px] font-black uppercase tracking-[0.2em] text-[#e9422c]"
                            >
                                Listed price
                            </p>

                            <p
                                class="mt-3 text-5xl font-black tracking-[-0.06em]"
                            >
                                {{ vehicle.price }}
                            </p>

                            <p class="mt-3 text-xs leading-5 text-stone-500">
                                Contact the dealership to confirm current
                                availability and final purchase details.
                            </p>
                        </div>

                        <div
                            class="grid grid-cols-2 divide-x divide-black/10 border-b border-black/10 bg-white"
                        >
                            <div class="p-5">
                                <p
                                    class="text-[9px] font-black uppercase tracking-[0.15em] text-stone-400"
                                >
                                    Condition
                                </p>

                                <p class="mt-2 font-black capitalize">
                                    {{ vehicle.condition || '—' }}
                                </p>
                            </div>

                            <div class="p-5">
                                <p
                                    class="text-[9px] font-black uppercase tracking-[0.15em] text-stone-400"
                                >
                                    Stock number
                                </p>

                                <p class="mt-2 font-black">
                                    {{ vehicle.stock_number || '—' }}
                                </p>
                            </div>
                        </div>

                        <div class="space-y-3 p-6">
                            <button
                                type="button"
                                class="btn-primary w-full"
                                @click="showInquiryForm"
                            >
                                Request information
                            </button>

                            <a
                                v-if="dealerPhoneHref"
                                :href="dealerPhoneHref"
                                class="btn-secondary w-full"
                            >
                                Call {{ dealerPhoneLabel }}
                            </a>
                        </div>
                    </div>

                    <div
                        class="mt-4 border border-black/10 bg-white p-5"
                    >
                        <p
                            class="text-[10px] font-black uppercase tracking-[0.18em] text-stone-400"
                        >
                            Before visiting
                        </p>

                        <ul
                            class="mt-4 space-y-3 text-sm leading-6 text-stone-600"
                        >
                            <li class="flex gap-3">
                                <span class="font-black text-[#ff4f38]">01</span>
                                Confirm that the vehicle is still available.
                            </li>

                            <li class="flex gap-3">
                                <span class="font-black text-[#ff4f38]">02</span>
                                Ask about financing or your current trade.
                            </li>

                            <li class="flex gap-3">
                                <span class="font-black text-[#ff4f38]">03</span>
                                Arrange a convenient time to see the vehicle.
                            </li>
                        </ul>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    <!-- Inquiry form -->
    <Transition
        enter-active-class="transition duration-300 ease-out"
        enter-from-class="translate-y-4 opacity-0"
        enter-to-class="translate-y-0 opacity-100"
    >
        <section
            v-if="isInquiryFormVisible"
            id="vehicle-inquiry-form"
            class="border-y border-black/10 bg-[#f5f3ee] py-14 lg:py-20"
        >
            <div
                class="site-container grid gap-10 lg:grid-cols-[0.7fr_1.3fr]"
            >
                <div>
                    <p class="eyebrow">
                        Vehicle inquiry
                    </p>

                    <h2 class="mt-5 heading-lg">
                        Interested in this vehicle?
                    </h2>

                    <p class="mt-6 max-w-md text-base leading-7 text-stone-600">
                        Send your contact information and questions. Our
                        dealership will follow up about availability and the
                        next step.
                    </p>

                    <div class="mt-8 border-t border-black/10 pt-6">
                        <p
                            class="text-[10px] font-black uppercase tracking-[0.16em] text-stone-400"
                        >
                            Vehicle
                        </p>

                        <p class="mt-2 text-lg font-black">
                            {{ vehicle.name }}
                        </p>

                        <p class="mt-1 text-sm text-stone-500">
                            Stock #{{ vehicle.stock_number || '—' }}
                        </p>
                    </div>
                </div>

                <form
                    class="border border-black/10 bg-white p-6 sm:p-8"
                    @submit.prevent="submit"
                >
                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label
                                class="mb-2 block text-[10px] font-black uppercase tracking-wider text-stone-500"
                            >
                                First name *
                            </label>

                            <input
                                v-model="form.first_name"
                                required
                                autocomplete="given-name"
                                class="form-input-dark"
                                placeholder="John"
                            >

                            <p
                                v-if="form.errors.first_name"
                                class="mt-2 text-xs font-bold text-red-600"
                            >
                                {{ form.errors.first_name }}
                            </p>
                        </div>

                        <div>
                            <label
                                class="mb-2 block text-[10px] font-black uppercase tracking-wider text-stone-500"
                            >
                                Last name
                            </label>

                            <input
                                v-model="form.last_name"
                                autocomplete="family-name"
                                class="form-input-dark"
                                placeholder="Smith"
                            >

                            <p
                                v-if="form.errors.last_name"
                                class="mt-2 text-xs font-bold text-red-600"
                            >
                                {{ form.errors.last_name }}
                            </p>
                        </div>

                        <div>
                            <label
                                class="mb-2 block text-[10px] font-black uppercase tracking-wider text-stone-500"
                            >
                                Phone *
                            </label>

                            <input
                                v-model="form.phone"
                                required
                                type="tel"
                                autocomplete="tel"
                                class="form-input-dark"
                                placeholder="+1 (000) 000-0000"
                            >

                            <p
                                v-if="form.errors.phone"
                                class="mt-2 text-xs font-bold text-red-600"
                            >
                                {{ form.errors.phone }}
                            </p>
                        </div>

                        <div>
                            <label
                                class="mb-2 block text-[10px] font-black uppercase tracking-wider text-stone-500"
                            >
                                Email
                            </label>

                            <input
                                v-model="form.email"
                                type="email"
                                autocomplete="email"
                                class="form-input-dark"
                                placeholder="john@example.com"
                            >

                            <p
                                v-if="form.errors.email"
                                class="mt-2 text-xs font-bold text-red-600"
                            >
                                {{ form.errors.email }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-5">
                        <label
                            class="mb-2 block text-[10px] font-black uppercase tracking-wider text-stone-500"
                        >
                            Preferred contact time
                        </label>

                        <input
                            v-model="form.preferred_contact_time"
                            class="form-input-dark"
                            placeholder="Morning, afternoon, or evening"
                        >
                    </div>

                    <div class="mt-5">
                        <label
                            class="mb-2 block text-[10px] font-black uppercase tracking-wider text-stone-500"
                        >
                            Questions or comments
                        </label>

                        <textarea
                            v-model="form.message"
                            rows="5"
                            class="form-input-dark resize-y"
                            :placeholder="`I am interested in the ${vehicle.name}.`"
                        ></textarea>

                        <p
                            v-if="form.errors.message"
                            class="mt-2 text-xs font-bold text-red-600"
                        >
                            {{ form.errors.message }}
                        </p>
                    </div>

                    <div
                        class="mt-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
                    >
                        <p class="max-w-md text-xs leading-5 text-stone-500">
                            Submitting this form does not reserve the vehicle
                            or guarantee financing.
                        </p>

                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="btn-primary shrink-0 disabled:cursor-not-allowed disabled:opacity-60"
                        >
                            {{ form.processing ? 'Sending…' : 'Send inquiry' }}
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </Transition>

    <!-- Specifications -->
    <section class="site-section bg-[#f5f3ee]">
        <div class="site-container">
            <div class="section-header">
                <div>
                    <p class="eyebrow">
                        Vehicle information
                    </p>

                    <h2 class="mt-5 heading-lg">
                        Details at a glance.
                    </h2>
                </div>

                <p class="max-w-md text-sm leading-6 text-stone-500">
                    Specifications should be confirmed with the dealership
                    before completing a purchase.
                </p>
            </div>

            <div class="grid gap-7 lg:grid-cols-[0.9fr_1.1fr]">
                <section class="border border-black/10 bg-white p-6 sm:p-8">
                    <h3
                        class="text-xl font-black tracking-[-0.03em]"
                    >
                        Specifications
                    </h3>

                    <dl class="mt-6 divide-y divide-black/10">
                        <div class="grid grid-cols-2 gap-4 py-4">
                            <dt class="text-sm text-stone-500">Make</dt>
                            <dd class="text-right text-sm font-black">
                                {{ vehicle.make || '—' }}
                            </dd>
                        </div>

                        <div class="grid grid-cols-2 gap-4 py-4">
                            <dt class="text-sm text-stone-500">Model</dt>
                            <dd class="text-right text-sm font-black">
                                {{ vehicle.model || '—' }}
                            </dd>
                        </div>

                        <div class="grid grid-cols-2 gap-4 py-4">
                            <dt class="text-sm text-stone-500">Body style</dt>
                            <dd class="text-right text-sm font-black capitalize">
                                {{ vehicle.body_type || '—' }}
                            </dd>
                        </div>

                        <div class="grid grid-cols-2 gap-4 py-4">
                            <dt class="text-sm text-stone-500">Transmission</dt>
                            <dd class="text-right text-sm font-black capitalize">
                                {{ vehicle.transmission || '—' }}
                            </dd>
                        </div>

                        <div class="grid grid-cols-2 gap-4 py-4">
                            <dt class="text-sm text-stone-500">Drivetrain</dt>
                            <dd class="text-right text-sm font-black uppercase">
                                {{ vehicle.drivetrain || '—' }}
                            </dd>
                        </div>

                        <div class="grid grid-cols-2 gap-4 py-4">
                            <dt class="text-sm text-stone-500">Engine</dt>
                            <dd class="text-right text-sm font-black">
                                {{ vehicle.engine || '—' }}
                            </dd>
                        </div>

                        <div class="grid grid-cols-2 gap-4 py-4">
                            <dt class="text-sm text-stone-500">Fuel type</dt>
                            <dd class="text-right text-sm font-black capitalize">
                                {{ vehicle.fuel_type || '—' }}
                            </dd>
                        </div>

                        <div class="grid grid-cols-2 gap-4 py-4">
                            <dt class="text-sm text-stone-500">Exterior</dt>
                            <dd class="text-right text-sm font-black">
                                {{ vehicle.exterior_color || '—' }}
                            </dd>
                        </div>

                        <div class="grid grid-cols-2 gap-4 py-4">
                            <dt class="text-sm text-stone-500">Interior</dt>
                            <dd class="text-right text-sm font-black">
                                {{ vehicle.interior_color || '—' }}
                            </dd>
                        </div>

                        <div class="grid grid-cols-2 gap-4 py-4">
                            <dt class="text-sm text-stone-500">VIN</dt>
                            <dd
                                class="break-all text-right text-sm font-black"
                            >
                                {{ vehicle.vin || '—' }}
                            </dd>
                        </div>
                    </dl>
                </section>

                <section class="border border-black/10 bg-white p-6 sm:p-8">
                    <h3
                        class="text-xl font-black tracking-[-0.03em]"
                    >
                        Equipment and features
                    </h3>

                    <div
                        v-if="normalizedFeatures.length"
                        class="mt-6 grid gap-px overflow-hidden border border-black/10 bg-black/10 sm:grid-cols-2"
                    >
                        <div
                            v-for="feature in normalizedFeatures"
                            :key="feature"
                            class="flex items-center gap-3 bg-[#f5f3ee] px-4 py-4 text-sm font-bold"
                        >
                            <span
                                class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-[#ff4f38] text-[9px] text-white"
                            >
                                ✓
                            </span>

                            {{ feature }}
                        </div>
                    </div>

                    <div
                        v-else
                        class="mt-6 border border-dashed border-black/20 bg-[#f5f3ee] p-7"
                    >
                        <p class="text-sm leading-6 text-stone-600">
                            Contact our team for the current equipment and
                            feature list for this vehicle.
                        </p>
                    </div>
                </section>
            </div>
        </div>
    </section>

    <!-- Vehicle description -->
    <section
        v-if="vehicle.description"
        class="site-section border-t border-black/10 bg-white"
    >
        <div
            class="site-container grid gap-10 lg:grid-cols-[0.65fr_1.35fr]"
        >
            <div>
                <p class="eyebrow">
                    Vehicle overview
                </p>

                <h2 class="mt-5 heading-lg">
                    About this vehicle.
                </h2>
            </div>

            <div
                class="vehicle-description"
                v-html="vehicle.description"
            ></div>
        </div>
    </section>

    <!-- Additional actions -->
    <section class="bg-[#ff4f38] text-white">
        <div
            class="site-container grid divide-y divide-white/20 lg:grid-cols-3 lg:divide-x lg:divide-y-0"
        >
            <article class="py-10 lg:pr-8">
                <p
                    class="text-[10px] font-black uppercase tracking-[0.2em] text-white/60"
                >
                    Financing
                </p>

                <h2 class="mt-3 text-2xl font-black">
                    Need payment options?
                </h2>

                <p class="mt-3 text-sm leading-6 text-white/80">
                    Start a financing request online and continue the
                    conversation with our team.
                </p>

                <Link
                    href="/finance"
                    class="mt-6 inline-flex text-xs font-black uppercase tracking-wide underline decoration-white decoration-2 underline-offset-8"
                >
                    Explore financing
                </Link>
            </article>

            <article class="py-10 lg:px-8">
                <p
                    class="text-[10px] font-black uppercase tracking-[0.2em] text-white/60"
                >
                    Trade-in
                </p>

                <h2 class="mt-3 text-2xl font-black">
                    Have a vehicle to trade?
                </h2>

                <p class="mt-3 text-sm leading-6 text-white/80">
                    Send us the basic information about your current vehicle
                    for review.
                </p>

                <Link
                    href="/trade-in"
                    class="mt-6 inline-flex text-xs font-black uppercase tracking-wide underline decoration-white decoration-2 underline-offset-8"
                >
                    Tell us about it
                </Link>
            </article>

            <article class="py-10 lg:pl-8">
                <p
                    class="text-[10px] font-black uppercase tracking-[0.2em] text-white/60"
                >
                    Questions
                </p>

                <h2 class="mt-3 text-2xl font-black">
                    Want to speak directly?
                </h2>

                <p class="mt-3 text-sm leading-6 text-white/80">
                    Call the dealership to confirm availability or arrange
                    a visit.
                </p>

                <a
                    v-if="dealerPhoneHref"
                    :href="dealerPhoneHref"
                    class="mt-6 inline-flex text-xs font-black uppercase tracking-wide underline decoration-white decoration-2 underline-offset-8"
                >
                    {{ dealerPhoneLabel }}
                </a>
            </article>
        </div>
    </section>

    <!-- Related vehicles -->
    <section
        v-if="relatedVehicles.length"
        class="site-section bg-[#f5f3ee]"
    >
        <div class="site-container">
            <div class="section-header">
                <div>
                    <p class="eyebrow">
                        More inventory
                    </p>

                    <h2 class="mt-5 heading-lg">
                        Similar vehicles.
                    </h2>
                </div>

                <Link href="/inventory" class="btn-secondary">
                    View all inventory
                </Link>
            </div>

            <div class="grid gap-x-6 gap-y-10 md:grid-cols-3">
                <Link
                    v-for="relatedVehicle in relatedVehicles"
                    :key="relatedVehicle.id"
                    :href="`/inventory/${relatedVehicle.slug}`"
                    class="group"
                >
                    <div
                        class="relative aspect-[4/3] overflow-hidden bg-[#ddd8ce]"
                    >
                        <img
                            v-if="relatedVehicle.image"
                            :src="relatedVehicle.image"
                            :alt="relatedVehicle.name"
                            class="h-full w-full object-cover transition duration-700 group-hover:scale-[1.04]"
                        >

                        <div
                            v-else
                            class="flex h-full items-center justify-center text-xs font-black uppercase tracking-wider text-stone-400"
                        >
                            Photo coming soon
                        </div>

                        <span
                            class="absolute bottom-4 right-4 flex h-11 w-11 items-center justify-center rounded-full bg-[#171717] text-white transition group-hover:bg-[#ff4f38]"
                        >
                            ↗
                        </span>
                    </div>

                    <div class="border-b border-black/15 py-5">
                        <p
                            class="text-[10px] font-black uppercase tracking-[0.18em] text-stone-500"
                        >
                            {{ relatedVehicle.year }}
                        </p>

                        <h3
                            class="mt-2 text-xl font-black tracking-[-0.03em] transition group-hover:text-[#e9422c]"
                        >
                            {{ relatedVehicle.name }}
                        </h3>

                        <div
                            class="mt-4 flex items-center justify-between gap-4"
                        >
                            <p class="font-black">
                                {{ relatedVehicle.price }}
                            </p>

                            <p class="text-sm text-stone-500">
                                {{ relatedVehicle.mileage }}
                            </p>
                        </div>
                    </div>
                </Link>
            </div>
        </div>
    </section>

    <!-- Lightbox -->
    <div
        v-if="isLightboxOpen"
        class="fixed inset-0 z-[110] flex touch-pan-y select-none items-center justify-center bg-black/95 p-4"
        role="dialog"
        aria-modal="true"
        aria-label="Vehicle image gallery"
        @click.self="closeLightbox"
        @touchstart.passive="handleGalleryTouchStart"
        @touchmove.passive="handleGalleryTouchMove"
        @touchend="handleGalleryTouchEnd"
    >
        <button
            type="button"
            aria-label="Close gallery"
            class="absolute right-5 top-5 z-10 flex h-12 w-12 items-center justify-center rounded-full border border-white/20 bg-black/60 text-3xl font-black text-white transition hover:bg-white hover:text-black"
            @click="closeLightbox"
        >
            ×
        </button>

        <span
            class="absolute left-5 top-5 rounded-full bg-white/10 px-4 py-2 text-xs font-black text-white backdrop-blur"
        >
            {{ activeImageIndex + 1 }} / {{ galleryImages.length }}
        </span>

        <button
            v-if="galleryImages.length > 1"
            type="button"
            aria-label="Previous image"
            class="absolute left-5 top-1/2 z-10 flex h-12 w-12 -translate-y-1/2 items-center justify-center rounded-full border border-white/20 bg-black/60 text-3xl font-black text-white transition hover:bg-white hover:text-black"
            @click="previousImage"
        >
            ‹
        </button>

        <img
            :src="activeImage.url"
            :alt="activeImage.alt"
            class="max-h-[90vh] max-w-full object-contain"
            draggable="false"
        >

        <button
            v-if="galleryImages.length > 1"
            type="button"
            aria-label="Next image"
            class="absolute right-5 top-1/2 z-10 flex h-12 w-12 -translate-y-1/2 items-center justify-center rounded-full border border-white/20 bg-black/60 text-3xl font-black text-white transition hover:bg-white hover:text-black"
            @click="nextImage"
        >
            ›
        </button>
    </div>
</template>
