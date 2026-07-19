<script setup>
import {Link, usePage} from '@inertiajs/vue3';
import {computed, onBeforeUnmount, ref, watch} from 'vue';
import CookieConsentBanner from '@/Components/CookieConsentBanner.vue';

const page = usePage();
const site = computed(() => page.props.site || {});

const mobileMenuOpen = ref(false);
const resourcesOpen = ref(false);
const showSuccessFlash = ref(false);
const showErrorFlash = ref(false);
let flashTimeout = null;

const successFlash = computed(() => page.props.flash?.success || '');
const errorFlash = computed(() => page.props.flash?.error || '');

const navigation = [
    {label: 'Inventory', href: '/inventory'},
    {label: 'Financing', href: '/finance'},
    {label: 'Sell Your Car', href: '/trade-in'},
    {label: 'Service', href: '/service'},
    {label: 'Our Dealership', href: '/about'},
    {label: 'Contact', href: '/contact'},
];

const buyerResources = [
    {label: 'Vehicle Delivery', href: '/delivery', text: 'Ask about pickup and delivery options.'},
    {label: 'Warranty Information', href: '/warranty-return', text: 'Understand coverage before you buy.'},
];

const isActive = (href) => page.url === href || page.url.startsWith(`${href}/`);
const resourcesActive = computed(() => buyerResources.some((item) => isActive(item.href)));

const closeMenus = () => {
    mobileMenuOpen.value = false;
    resourcesOpen.value = false;
};

watch(
    () => [successFlash.value, errorFlash.value, page.url],
    () => {
        closeMenus();
        showSuccessFlash.value = Boolean(successFlash.value);
        showErrorFlash.value = Boolean(errorFlash.value);

        if (flashTimeout) clearTimeout(flashTimeout);
        if (showSuccessFlash.value || showErrorFlash.value) {
            flashTimeout = setTimeout(() => {
                showSuccessFlash.value = false;
                showErrorFlash.value = false;
            }, 4500);
        }
    },
    {immediate: true},
);

onBeforeUnmount(() => {
    if (flashTimeout) clearTimeout(flashTimeout);
});

const hasMarketingConsent = () => {
    if (typeof window === 'undefined') return false;
    return document.cookie.split('; ').some((item) => item === 'cookie_marketing_consent=1');
};

watch(
    () => page.props.flash?.meta_event,
    (event) => {
        if (!event || typeof window === 'undefined' || typeof window.fbq !== 'function' || !hasMarketingConsent()) return;
        if (event.event_name !== 'Lead') return;

        window.fbq('track', 'Lead', {
            form_type: event.form_type,
            lead_type: event.form_type,
            content_category: event.form_type,
        }, {eventID: event.event_id});
    },
    {immediate: true},
);

const logoUrl = '/images/logo.png';

</script>

<template>
    <div class="min-h-screen bg-[#f5f3ee] text-[#171717]">
        <div class="bg-[#171717] text-white">
            <div
                class="site-container flex min-h-10 items-center justify-between gap-5 py-2 text-[11px] font-semibold uppercase tracking-[0.12em]">
                <a :href="site.maps_url" target="_blank" rel="noopener"
                   class="hidden text-stone-300 transition hover:text-white md:block">
                    {{ site.address }}
                </a>
                <p class="text-stone-300 md:hidden">East Granby, Connecticut</p>

                <div class="flex items-center gap-5">
                    <span class="hidden text-stone-400 sm:inline">{{ site.business_hours }}</span>
                    <a :href="`tel:${site.phone_tel}`" class="text-[#ff5a45] transition hover:text-white">
                        {{ site.phone }}
                    </a>
                </div>
            </div>
        </div>

        <header class="relative z-50 border-b border-black/10 bg-[#f5f3ee]/95 backdrop-blur-xl">
            <div class="site-container flex min-h-[82px] items-center justify-between gap-8">
                <Link href="/" class="group flex shrink-0 items-center gap-3" aria-label="Cars For Less home">
                    <img
                        :src="logoUrl"
                        :alt="site.name"
                        class="w-30 logo"
                    />
                </Link>

                <nav class="hidden items-center gap-1 xl:flex" aria-label="Main navigation">
                    <Link
                        v-for="item in navigation"
                        :key="item.href"
                        :href="item.href"
                        class="rounded-full px-4 py-2.5 text-[12px] font-bold transition"
                        :class="isActive(item.href) ? 'bg-[#171717] text-white' : 'text-stone-700 hover:bg-black/5 hover:text-black'"
                    >
                        {{ item.label }}
                    </Link>

                    <div class="relative">
                        <button
                            type="button"
                            class="flex items-center gap-2 rounded-full px-4 py-2.5 text-[12px] font-bold transition"
                            :class="resourcesActive || resourcesOpen ? 'bg-[#171717] text-white' : 'text-stone-700 hover:bg-black/5 hover:text-black'"
                            :aria-expanded="resourcesOpen"
                            @click="resourcesOpen = !resourcesOpen"
                        >
                            More
                            <svg class="h-3 w-3 transition" :class="{'rotate-180': resourcesOpen}" viewBox="0 0 12 12"
                                 fill="none" aria-hidden="true">
                                <path d="m2 4 4 4 4-4" stroke="currentColor" stroke-width="1.5"/>
                            </svg>
                        </button>

                        <div v-if="resourcesOpen"
                             class="absolute right-0 top-[calc(100%+14px)] w-80 rounded-2xl border border-black/10 bg-white p-2 shadow-2xl shadow-black/15">
                            <Link
                                v-for="item in buyerResources"
                                :key="item.href"
                                :href="item.href"
                                class="block rounded-xl px-4 py-3 transition hover:bg-[#f5f3ee]"
                                @click="closeMenus"
                            >
                                <span class="block text-sm font-black">{{ item.label }}</span>
                                <span class="mt-1 block text-xs leading-5 text-stone-500">{{ item.text }}</span>
                            </Link>
                        </div>
                    </div>
                </nav>

                <div class="hidden shrink-0 items-center gap-3 xl:flex">
                    <a :href="`tel:${site.phone_tel}`" class="text-sm font-black">Call Sales</a>
                    <Link href="/inventory"
                          class="inline-flex items-center rounded-full bg-[#ff4f38] px-5 py-3 text-xs font-black uppercase tracking-wide text-white transition hover:bg-[#e93d29]">
                        Find a Car
                    </Link>
                </div>

                <button
                    type="button"
                    class="flex h-11 w-11 items-center justify-center rounded-full border border-black/15 xl:hidden"
                    :aria-expanded="mobileMenuOpen"
                    aria-label="Toggle menu"
                    @click="mobileMenuOpen = !mobileMenuOpen"
                >
                    <svg v-if="!mobileMenuOpen" class="h-5 w-5" viewBox="0 0 20 20" fill="none" aria-hidden="true">
                        <path d="M2 5h16M2 10h16M2 15h16" stroke="currentColor" stroke-width="1.8"/>
                    </svg>
                    <svg v-else class="h-5 w-5" viewBox="0 0 20 20" fill="none" aria-hidden="true">
                        <path d="m4 4 12 12M16 4 4 16" stroke="currentColor" stroke-width="1.8"/>
                    </svg>
                </button>
            </div>

            <div v-if="mobileMenuOpen" class="border-t border-black/10 bg-[#f5f3ee] xl:hidden">
                <div class="site-container py-5">
                    <nav class="grid gap-1" aria-label="Mobile navigation">
                        <Link
                            v-for="item in navigation"
                            :key="item.href"
                            :href="item.href"
                            class="flex items-center justify-between border-b border-black/10 py-4 text-lg font-black"
                            @click="closeMenus"
                        >
                            {{ item.label }} <span class="text-[#ff4f38]">↗</span>
                        </Link>
                        <p class="pb-1 pt-6 text-[10px] font-black uppercase tracking-[0.25em] text-stone-500">More</p>
                        <Link
                            v-for="item in buyerResources.slice(0, 2)"
                            :key="item.href"
                            :href="item.href"
                            class="py-2 text-sm font-bold text-stone-700"
                            @click="closeMenus"
                        >
                            {{ item.label }}
                        </Link>
                    </nav>
                    <a :href="`tel:${site.phone_tel}`"
                       class="mt-6 flex items-center justify-center rounded-full bg-[#ff4f38] px-6 py-4 text-sm font-black uppercase tracking-wide text-white">
                        Call {{ site.phone }}
                    </a>
                </div>
            </div>
        </header>

        <div class="pointer-events-none fixed right-5 top-5 z-[90] w-[calc(100%-2.5rem)] max-w-md space-y-3">
            <Transition enter-active-class="transition duration-300" enter-from-class="translate-x-6 opacity-0"
                        leave-active-class="transition duration-200" leave-to-class="translate-x-6 opacity-0">
                <div v-if="showSuccessFlash && successFlash"
                     class="pointer-events-auto rounded-2xl bg-[#173d2b] px-5 py-4 text-sm text-white shadow-2xl">
                    <div class="flex items-start gap-3"><span class="font-black text-[#77d7a4]">✓</span>
                        <p class="flex-1">{{ successFlash }}</p>
                        <button @click="showSuccessFlash = false">×</button>
                    </div>
                </div>
            </Transition>
            <Transition enter-active-class="transition duration-300" enter-from-class="translate-x-6 opacity-0"
                        leave-active-class="transition duration-200" leave-to-class="translate-x-6 opacity-0">
                <div v-if="showErrorFlash && errorFlash"
                     class="pointer-events-auto rounded-2xl bg-[#7d2118] px-5 py-4 text-sm text-white shadow-2xl">
                    <div class="flex items-start gap-3"><span class="font-black">!</span>
                        <p class="flex-1">{{ errorFlash }}</p>
                        <button @click="showErrorFlash = false">×</button>
                    </div>
                </div>
            </Transition>
        </div>

        <main>
            <slot/>
        </main>

        <footer class="bg-[#171717] text-white">
            <div class="site-container py-16 lg:py-20">
                <div class="grid gap-12 border-b border-white/15 pb-14 lg:grid-cols-[1.5fr_0.8fr_0.8fr]">
                    <div>
                        <p class="text-[11px] font-black uppercase tracking-[0.28em] text-[#ff5a45]">Your next car
                            starts here</p>
                        <h2 class="mt-5 max-w-xl text-4xl font-black tracking-[-0.05em] sm:text-5xl">Simple car
                            shopping. Local people. Real answers.</h2>
                        <div class="mt-8 flex flex-wrap gap-3">
                            <Link href="/inventory"
                                  class="rounded-full bg-[#ff4f38] px-6 py-3 text-xs font-black uppercase tracking-wide">
                                Browse Inventory
                            </Link>
                            <a :href="`tel:${site.phone_tel}`"
                               class="rounded-full border border-white/25 px-6 py-3 text-xs font-black uppercase tracking-wide">{{
                                    site.phone
                                }}</a>
                        </div>
                    </div>

                    <div>
                        <p class="text-xs font-black uppercase tracking-[0.2em] text-stone-500">Explore</p>
                        <nav class="mt-5 grid gap-3 text-sm font-bold">
                            <Link href="/inventory">Inventory</Link>
                            <Link href="/finance">Financing</Link>
                            <Link href="/trade-in">Sell Your Car</Link>
                            <Link href="/service">Service</Link>
                            <Link href="/about">Our Dealership</Link>
                            <Link href="/contact">Contact</Link>
                        </nav>
                    </div>

                    <div>
                        <p class="text-xs font-black uppercase tracking-[0.2em] text-stone-500">Visit us</p>
                        <a :href="site.maps_url" target="_blank" rel="noopener"
                           class="mt-5 block text-sm font-bold leading-6">{{ site.address }}</a>
                        <a :href="`mailto:${site.email}`" class="mt-4 block text-sm text-stone-400">{{ site.email }}</a>
                        <p class="mt-2 text-sm text-stone-400">{{ site.business_hours }}</p>
                    </div>
                </div>

                <div
                    class="flex flex-col gap-4 pt-7 text-[11px] text-stone-500 sm:flex-row sm:items-center sm:justify-between">
                    <p>© {{ new Date().getFullYear() }} Cars For Less Sales &amp; Service. All rights reserved.</p>
                    <div class="flex gap-5">
                        <Link href="/privacy-policy">Privacy</Link>
                        <Link href="/terms">Terms</Link>
                    </div>
                </div>
            </div>
        </footer>

        <CookieConsentBanner/>
    </div>
</template>
<style scoped>
.logo{
    margin-bottom: -40px;
}
</style>
