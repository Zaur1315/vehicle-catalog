<script setup>
import {Link, usePage} from '@inertiajs/vue3';
import {computed, ref, watch, onBeforeUnmount} from 'vue';
import CookieConsentBanner from "../Components/CookieConsentBanner.vue";

const page = usePage();

const showSuccessFlash = ref(false);
const showErrorFlash = ref(false);

let flashTimeout = null;

const successFlash = computed(() => page.props.flash?.success || '');
const errorFlash = computed(() => page.props.flash?.error || '');

const hideFlashMessages = () => {
    showSuccessFlash.value = false;
    showErrorFlash.value = false;
};

const startFlashTimer = () => {
    if (flashTimeout) {
        clearTimeout(flashTimeout);
    }

    flashTimeout = setTimeout(() => {
        hideFlashMessages();
    }, 4500);
};

watch(
    () => [successFlash.value, errorFlash.value, page.url],
    () => {
        showSuccessFlash.value = Boolean(successFlash.value);
        showErrorFlash.value = Boolean(errorFlash.value);

        if (showSuccessFlash.value || showErrorFlash.value) {
            startFlashTimer();
        }
    },
    {immediate: true},
);

onBeforeUnmount(() => {
    if (flashTimeout) {
        clearTimeout(flashTimeout);
    }
});

const mobileMenuOpen = ref(false);
const logoUrl = '/images/logo.png';

const navigation = [
    {label: 'Inventory', href: '/inventory'},
    {label: 'Finance', href: '/finance'},
    {label: 'Trade-In', href: '/trade-in'},
    {label: 'Delivery', href: '/delivery'},
    {label: 'Warranty', href: '/warranty-return'},
    {label: 'About', href: '/about'},
    {label: 'Contact', href: '/contact'},
];

const site = computed(() => page.props.site || {});

const isActive = (href) => {
    return page.url === href || page.url.startsWith(`${href}/`);
};

const hasMarketingConsent = () => {
    if (typeof window === 'undefined') {
        return false;
    }

    return document.cookie
        .split('; ')
        .some((item) => item === 'cookie_marketing_consent=1');
};

watch(
    () => page.props.flash?.meta_event,
    (event) => {
        if (
            !event
            || typeof window === 'undefined'
            || typeof window.fbq !== 'function'
            || !hasMarketingConsent()
        ) {
            return;
        }

        if (event.event_name !== 'Lead') {
            return;
        }

        window.fbq(
            'track',
            'Lead',
            {
                form_type: event.form_type,
                lead_type: event.form_type,
                content_category: event.form_type,
            },
            {
                eventID: event.event_id,
            },
        );
    },
    { immediate: true },
);

</script>

<template>
    <div class="min-h-screen bg-[#0b0f14] text-white">
        <div class="border-b border-white/10 bg-[#080b0f]">
            <div
                class="site-container flex flex-col gap-2 py-3 text-xs text-slate-400 md:flex-row md:items-center md:justify-between">
                <p>{{ site.business_hours }}</p>

                <div class="flex flex-wrap gap-x-6 gap-y-2">
                    <a :href="`tel:${site.phone_tel}`" class="hover:text-white">
                        {{ site.phone }}
                    </a>

                    <a :href="`mailto:${site.email}`" class="hover:text-white">
                        {{ site.email }}
                    </a>

                    <span>Enclosed delivery available</span>
                </div>
            </div>
        </div>

        <header class="sticky top-0 z-50 border-b border-white/10 bg-[#0b0f14]/95 backdrop-blur">
            <div class="site-container flex items-center justify-between py-5">
                <Link href="/" class="group flex items-center gap-4">
                    <img
                        :src="logoUrl"
                        :alt="site.name"
                        class="h-11 w-auto"
                    />
                    <span>
                        <span class="block text-sm font-black uppercase tracking-[0.28em]">
                            {{ site.name }}
                        </span>
                        <span class="block text-xs text-slate-500">
                            Premium vehicle inventory
                        </span>
                    </span>
                </Link>

                <nav class="hidden items-center gap-1 xl:flex">
                    <Link
                        v-for="item in navigation"
                        :key="item.href"
                        :href="item.href"
                        class="rounded-lg px-3 py-2 text-xs font-bold uppercase tracking-wide transition"
                        :class="isActive(item.href) ? 'bg-white/10 text-amber-300' : 'text-slate-300 hover:bg-white/5 hover:text-white'"
                    >
                        {{ item.label }}
                    </Link>
                </nav>

                <div class="hidden items-center gap-3 xl:flex">
                    <Link href="/inventory" class="btn-secondary">
                        View Inventory
                    </Link>

                    <Link href="/contact" class="btn-primary">
                        Contact Sales
                    </Link>
                </div>

                <button
                    type="button"
                    class="rounded-xl border border-white/10 px-4 py-2 text-sm font-bold xl:hidden"
                    @click="mobileMenuOpen = !mobileMenuOpen"
                >
                    Menu
                </button>
            </div>

            <div v-if="mobileMenuOpen" class="border-t border-white/10 xl:hidden">
                <div class="site-container py-4">
                    <nav class="grid gap-2 sm:grid-cols-2">
                        <Link
                            v-for="item in navigation"
                            :key="item.href"
                            :href="item.href"
                            class="rounded-xl border border-white/10 px-4 py-3 text-sm font-bold"
                            :class="isActive(item.href) ? 'bg-white/10 text-amber-300' : 'text-slate-300'"
                            @click="mobileMenuOpen = false"
                        >
                            {{ item.label }}
                        </Link>
                    </nav>
                </div>
            </div>
        </header>

        <div
            class="pointer-events-none fixed right-5 top-5 z-[90] w-[calc(100%-2.5rem)] max-w-md space-y-3 sm:right-6 sm:top-6">
            <Transition
                enter-active-class="transition duration-300 ease-out"
                enter-from-class="translate-x-6 opacity-0"
                enter-to-class="translate-x-0 opacity-100"
                leave-active-class="transition duration-200 ease-in"
                leave-from-class="translate-x-0 opacity-100"
                leave-to-class="translate-x-6 opacity-0"
            >
                <div
                    v-if="showSuccessFlash && successFlash"
                    class="pointer-events-auto rounded-2xl border border-emerald-400/40 bg-emerald-950/95 px-5 py-4 text-sm text-emerald-50 shadow-2xl shadow-black/40 backdrop-blur"
                >
                    <div class="flex items-start gap-4">
                        <div
                            class="mt-0.5 flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-emerald-400 text-sm font-black text-emerald-950">
                            ✓
                        </div>

                        <div class="min-w-0 flex-1">
                            <p class="text-xs font-black uppercase tracking-[0.2em] text-emerald-300">
                                Success
                            </p>

                            <p class="mt-1 leading-6">
                                {{ successFlash }}
                            </p>
                        </div>

                        <button
                            type="button"
                            class="shrink-0 text-emerald-200/70 hover:text-white"
                            @click="showSuccessFlash = false"
                        >
                            ×
                        </button>
                    </div>
                </div>
            </Transition>

            <Transition
                enter-active-class="transition duration-300 ease-out"
                enter-from-class="translate-x-6 opacity-0"
                enter-to-class="translate-x-0 opacity-100"
                leave-active-class="transition duration-200 ease-in"
                leave-from-class="translate-x-0 opacity-100"
                leave-to-class="translate-x-6 opacity-0"
            >
                <div
                    v-if="showErrorFlash && errorFlash"
                    class="pointer-events-auto rounded-2xl border border-red-400/40 bg-red-950/95 px-5 py-4 text-sm text-red-50 shadow-2xl shadow-black/40 backdrop-blur"
                >
                    <div class="flex items-start gap-4">
                        <div
                            class="mt-0.5 flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-red-400 text-sm font-black text-red-950">
                            !
                        </div>

                        <div class="min-w-0 flex-1">
                            <p class="text-xs font-black uppercase tracking-[0.2em] text-red-300">
                                Error
                            </p>

                            <p class="mt-1 leading-6">
                                {{ errorFlash }}
                            </p>
                        </div>

                        <button
                            type="button"
                            class="shrink-0 text-red-200/70 hover:text-white"
                            @click="showErrorFlash = false"
                        >
                            ×
                        </button>
                    </div>
                </div>
            </Transition>
        </div>

        <div
            v-if="page.props.flash?.error"
            class="site-container mt-6"
        >
            <div class="rounded-xl border border-red-400/30 bg-red-400/10 px-5 py-4 text-sm text-red-100">
                {{ page.props.flash.error }}
            </div>
        </div>

        <main>
            <slot/>
        </main>

        <footer class="border-t border-white/10 bg-[#080b0f]">
            <div class="site-container padd-top padd-bottom grid gap-10 py-12 lg:grid-cols-[1.9fr_0.5fr_0.5fr_0.5fr]">
                <div>
                    <Link href="/" class="group flex items-center gap-4">
                        <img
                            :src="logoUrl"
                            :alt="site.name"
                            class="h-11 w-auto"
                        />
                        <span>
                        <span class="block text-sm font-black uppercase tracking-[0.28em]">
                            {{ site.name }}
                        </span>
                        <span class="block text-xs text-slate-500">
                            Premium vehicle inventory
                        </span>
                    </span>
                    </Link>

                    <p class="mt-5 max-w-md text-sm leading-6 text-slate-400">
                        Browse inspected vehicles, request information, and contact our sales team for delivery,
                        warranty, finance, and trade-in options.
                    </p>
                </div>

                <div>
                    <h3 class="text-sm font-black uppercase tracking-wide">
                        Inventory
                    </h3>

                    <div class="mt-4 flex flex-col gap-2 text-sm text-slate-400">
                        <Link href="/inventory" class="hover:text-white">Vehicles</Link>
                        <Link href="/finance" class="hover:text-white">Finance</Link>
                        <Link href="/trade-in" class="hover:text-white">Trade-In</Link>
                    </div>
                </div>

                <div>
                    <h3 class="text-sm font-black uppercase tracking-wide">
                        Company
                    </h3>

                    <div class="mt-4 flex flex-col gap-2 text-sm text-slate-400">
                        <Link href="/about" class="hover:text-white">About</Link>
                        <Link href="/delivery" class="hover:text-white">Delivery</Link>
                        <Link href="/warranty-return" class="hover:text-white">Warranty</Link>
                        <Link href="/contact" class="hover:text-white">Contact</Link>
                    </div>
                </div>

                <div>
                    <h3 class="text-sm font-black uppercase tracking-wide">
                        Legal
                    </h3>

                    <div class="mt-4 flex flex-col gap-2 text-sm text-slate-400">
                        <Link href="/privacy-policy" class="hover:text-white">Privacy Policy</Link>
                        <Link href="/terms" class="hover:text-white">Terms</Link>
                    </div>
                </div>
            </div>

            <div class="border-t border-white/10">
                <div
                    class="site-container flex flex-col gap-3 py-5 text-xs text-slate-500 md:flex-row md:items-center md:justify-between">
                    <p>© {{ new Date().getFullYear() }} {{ site.name }}. All rights reserved.</p>
                    <p>Vehicle availability, pricing, mileage, and terms are subject to confirmation.</p>
                </div>
            </div>
        </footer>
        <CookieConsentBanner />
    </div>
</template>
