<script setup>
import {Link, usePage} from '@inertiajs/vue3';
import {computed, nextTick, onBeforeUnmount, onMounted, ref, watch} from 'vue';
import CookieConsentBanner from '@/Components/CookieConsentBanner.vue';
import Icon from '@/Components/Icon.vue';

const page = usePage();
const site = computed(() => page.props.site || {});
const mobileMenuOpen = ref(false);
const menuButton = ref(null);
const menuPanel = ref(null);
const isScrolled = ref(false);
const successFlash = computed(() => page.props.flash?.success || '');
const errorFlash = computed(() => page.props.flash?.error || '');
const showSuccessFlash = ref(false);
const showErrorFlash = ref(false);
let flashTimeout;

const primaryNav = [
    {label: 'Inventory', href: '/inventory'},
    {label: 'Financing Options', href: '/finance'},
    {label: 'Value Your Trade', href: '/trade-in'},
    {label: 'About Delmar', href: '/about'},
    {label: 'Contact Delmar', href: '/contact'},
];
const logoUrl = '/images/brand/delmar-logo.svg';
const markUrl = '/images/brand/delmar-mark.svg';
const isActive = (href) => page.url === href || page.url.startsWith(`${href}/`);
const closeMenu = () => {
    mobileMenuOpen.value = false;
};
const toggleMenu = async () => {
    mobileMenuOpen.value = !mobileMenuOpen.value;
    if (mobileMenuOpen.value) {
        await nextTick();
        menuPanel.value?.querySelector('a,button')?.focus();
    }
};
const handleKeydown = (event) => {
    if (!mobileMenuOpen.value) return;
    if (event.key === 'Escape') {
        closeMenu();
        menuButton.value?.focus();
        return;
    }
    if (event.key !== 'Tab') return;
    const focusable = [...(menuPanel.value?.querySelectorAll('a[href], button:not([disabled])') || [])];
    if (!focusable.length) return;
    const first = focusable[0];
    const last = focusable[focusable.length - 1];
    if (event.shiftKey && document.activeElement === first) {
        event.preventDefault();
        last.focus();
    }
    if (!event.shiftKey && document.activeElement === last) {
        event.preventDefault();
        first.focus();
    }
};
const handleScroll = () => {
    isScrolled.value = window.scrollY > 24;
};

watch(mobileMenuOpen, (open) => {
    document.body.style.overflow = open ? 'hidden' : '';
});
watch(() => page.url, closeMenu);
watch(() => [successFlash.value, errorFlash.value], () => {
    showSuccessFlash.value = Boolean(successFlash.value);
    showErrorFlash.value = Boolean(errorFlash.value);
    clearTimeout(flashTimeout);
    if (showSuccessFlash.value || showErrorFlash.value) flashTimeout = setTimeout(() => {
        showSuccessFlash.value = false;
        showErrorFlash.value = false;
    }, 5000);
}, {immediate: true});
const hasMarketingConsent = () => typeof window !== 'undefined' && document.cookie.split('; ').some((item) => item === 'cookie_marketing_consent=1');
watch(() => page.props.flash?.meta_event, (event) => {
    if (!event || typeof window === 'undefined' || typeof window.fbq !== 'function' || !hasMarketingConsent() || event.event_name !== 'Lead') return;
    window.fbq('track', 'Lead', {
        form_type: event.form_type,
        lead_type: event.form_type,
        content_category: event.form_type
    }, {eventID: event.event_id});
}, {immediate: true});
onBeforeUnmount(() => {
    document.body.style.overflow = '';
    clearTimeout(flashTimeout);
});
onMounted(() => {
    handleScroll();
    window.addEventListener('scroll', handleScroll, {passive: true});
});
onBeforeUnmount(() => window.removeEventListener('scroll', handleScroll));
</script>

<template>
    <div class="min-h-screen bg-surface-muted text-text" @keydown="handleKeydown">
        <header
            :class="['site-header', { 'site-header-home': page.component === 'Home', 'is-scrolled': page.component === 'Home' && isScrolled, 'sticky top-0 border-b z-40 border-white/10 bg-ink text-white': page.component !== 'Home' }]"
            @keydown="handleKeydown">
            <div class="site-container flex min-h-[72px] items-center justify-between gap-6">
                <Link href="/" class="group flex items-center gap-3" :aria-label="`${site.name} home`">
                    <img :src="logoUrl" :alt="site.name"
                         class="hidden h-10 w-auto transition group-hover:opacity-80 sm:block"><img :src="markUrl"
                                                                                                    :alt="site.name"
                                                                                                    class="h-10 w-10 transition group-hover:opacity-80 sm:hidden">
                </Link>
                <div class="flex items-center gap-3"><a :href="`tel:${site.phone_tel}`"
                                                        class="header-muted hidden items-center gap-2 text-xs font-bold transition hover:text-brand sm:inline-flex">
                    <Icon name="phone"/>
                    {{ site.phone }}</a>
                    <Link href="/inventory" class="btn-primary hidden sm:inline-flex">Browse inventory
                        <Icon name="arrow-right"/>
                    </Link>
                    <button ref="menuButton" type="button" class="menu-trigger" :aria-expanded="mobileMenuOpen"
                            aria-controls="mobile-navigation" aria-label="Open menu" @click="toggleMenu"><span
                        class="menu-lines" aria-hidden="true"><i></i><i></i></span><span
                        class="hidden text-[10px] font-bold uppercase tracking-[.16em] sm:inline">Menu</span></button>
                </div>
            </div>
        </header>

        <Transition enter-active-class="transition duration-300" enter-from-class="opacity-0"
                    leave-active-class="transition duration-200" leave-to-class="opacity-0">
            <div v-if="mobileMenuOpen" class="fixed inset-0 z-50 bg-ink/60" @click.self="closeMenu">
                <aside id="mobile-navigation" ref="menuPanel"
                       class="ml-auto flex h-full w-[min(92vw,460px)] flex-col overflow-y-auto bg-surface-muted p-6 shadow-2xl"
                       aria-label="Main navigation">
                    <div class="flex items-center justify-between border-b border-border pb-6"><span
                        class="text-sm font-bold">{{ site.name }}</span>
                        <button type="button" class="text-2xl" aria-label="Close menu" @click="closeMenu">×</button>
                    </div>
                    <nav class="mt-6 grid" aria-label="Primary navigation">
                        <Link v-for="(item, index) in primaryNav" :key="item.href" :href="item.href"
                              class="flex items-center justify-between border-b border-border py-5 text-2xl font-bold"
                              :class="isActive(item.href) ? 'text-brand' : ''"><span><small
                            class="mr-3 text-xs font-bold tracking-widest text-brand">0{{
                                index + 1
                            }}</small>{{ item.label }}</span>
                            <Icon name="arrow-right"/>
                        </Link>
                    </nav>
                    <Link href="/inventory" class="btn-primary mt-7">Browse inventory
                        <Icon name="arrow-right"/>
                    </Link>
                    <div class="mt-auto border-t border-border pt-6 text-sm"><a :href="`tel:${site.phone_tel}`"
                                                                                class="flex items-center gap-2 font-bold sm:hidden">
                        <Icon name="phone"/>
                        {{ site.phone }}</a><a v-if="site.maps_url" :href="site.maps_url" target="_blank" rel="noopener"
                                               class="mt-4 flex items-start gap-2 leading-6 text-text-muted">
                        <Icon name="pin"/>
                        Get directions</a><a v-if="site.email" :href="`mailto:${site.email}`"
                                             class="mt-4 block break-all text-text-muted sm:mt-0">{{ site.email }}</a>
                        <p class="mt-4 text-text-muted sm:mt-2">{{ site.business_hours }}</p></div>
                </aside>
            </div>
        </Transition>

        <div class="pointer-events-none fixed right-5 top-24 z-[60] w-[calc(100%-2.5rem)] max-w-md space-y-3"
             aria-live="polite">
            <div v-if="showSuccessFlash && successFlash"
                 class="pointer-events-auto border-l-4 border-emerald-600 bg-ink px-5 py-4 text-sm text-white shadow-xl">
                <div class="flex gap-3"><span>✓</span>
                    <p class="flex-1">{{ successFlash }}</p>
                    <button aria-label="Dismiss" @click="showSuccessFlash = false">×</button>
                </div>
            </div>
            <div v-if="showErrorFlash && errorFlash"
                 class="pointer-events-auto border-l-4 border-brand bg-ink px-5 py-4 text-sm text-white shadow-xl">
                <div class="flex gap-3"><span>!</span>
                    <p class="flex-1">{{ errorFlash }}</p>
                    <button aria-label="Dismiss" @click="showErrorFlash = false">×</button>
                </div>
            </div>
        </div>
        <main>
            <slot/>
        </main>

        <footer class="text-white">
            <div class="footer-main">
                <div class="site-container py-16 lg:py-24">
                    <div class="grid gap-12 pb-14 lg:grid-cols-[1.3fr_.7fr_.9fr]">
                        <div><img :src="logoUrl" alt="Delmar Auto Sale Inc." class="h-10 w-auto brightness-0 invert">
                            <h3 class="mt-5 max-w-lg text-2xl font-bold leading-[.94] tracking-[-.06em] sm:text-4xl">A
                                better way to start your next vehicle search.</h3>
                            <div class="mt-8 flex flex-wrap gap-3">
                                <Link href="/inventory" class="btn-primary">Browse inventory
                                    <Icon name="arrow-right"/>
                                </Link>
                                <a :href="`tel:${site.phone_tel}`" class="btn-light">
                                    <Icon name="phone"/>
                                    Call us</a></div>
                        </div>
                        <div><p class="text-[10px] font-bold uppercase tracking-[.2em] text-white/45">Explore</p>
                            <nav class="mt-5 grid gap-4 text-sm font-semibold">
                                <Link v-for="item in primaryNav" :key="item.href" :href="item.href"
                                      class="transition hover:text-red-300">{{ item.label }}
                                </Link>
                            </nav>
                        </div>
                        <div><p class="text-[10px] font-bold uppercase tracking-[.2em] text-white/45">Visit us</p><a
                            v-if="site.maps_url" :href="site.maps_url" target="_blank" rel="noopener"
                            class="mt-5 flex items-start gap-2 text-sm font-semibold leading-6">
                            <Icon name="pin" class="mt-0.5 shrink-0"/>
                            {{ site.address }}</a>
                            <p v-else class="mt-5 text-sm font-semibold leading-6">{{ site.address }}</p>
                            <p class="mt-4 text-sm text-white/60">{{ site.business_hours }}</p><a
                                :href="`tel:${site.phone_tel}`" class="mt-4 block text-sm text-white/75">{{
                                    site.phone
                                }}</a><a v-if="site.email" :href="`mailto:${site.email}`"
                                         class="mt-2 block break-all text-sm text-white/75">{{ site.email }}</a></div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div
                    class="site-container flex flex-col gap-4 py-5 text-[11px] text-white/50 sm:flex-row sm:items-center sm:justify-between">
                    <p>©
                        {{ new Date().getFullYear() }} {{ site.name }}. All rights reserved.</p>
                    <div class="flex gap-5">
                        <Link href="/privacy-policy">Privacy Policy</Link>
                        <Link href="/terms">Terms of Use</Link>
                        <a href="/sitemap.xml">Sitemap</a></div>
                </div>
            </div>
        </footer>
        <CookieConsentBanner/>
    </div>
</template>
