<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed, nextTick, onBeforeUnmount, ref, watch } from 'vue';
import CookieConsentBanner from '@/Components/CookieConsentBanner.vue';
import Icon from '@/Components/Icon.vue';

const page = usePage();
const site = computed(() => page.props.site || {});
const mobileMenuOpen = ref(false);
const menuButton = ref(null);
const menuPanel = ref(null);
const successFlash = computed(() => page.props.flash?.success || '');
const errorFlash = computed(() => page.props.flash?.error || '');
const showSuccessFlash = ref(false);
const showErrorFlash = ref(false);
let flashTimeout;

const primaryNav = [
    { label: 'Inventory', href: '/inventory' },
    { label: 'Financing', href: '/finance' },
    { label: 'Sell or trade', href: '/trade-in' },
    { label: 'About Kohl', href: '/about' },
    { label: 'Contact', href: '/contact' },
];
const isActive = (href) => page.url === href || page.url.startsWith(`${href}/`);
const closeMenu = () => { mobileMenuOpen.value = false; };
const toggleMenu = async () => {
    mobileMenuOpen.value = !mobileMenuOpen.value;
    if (mobileMenuOpen.value) { await nextTick(); menuPanel.value?.querySelector('a,button')?.focus(); }
};
const handleKeydown = (event) => {
    if (!mobileMenuOpen.value) return;
    if (event.key === 'Escape') { closeMenu(); menuButton.value?.focus(); return; }
    if (event.key !== 'Tab') return;
    const focusable = [...(menuPanel.value?.querySelectorAll('a[href], button:not([disabled])') || [])];
    if (!focusable.length) return;
    const first = focusable[0];
    const last = focusable[focusable.length - 1];
    if (event.shiftKey && document.activeElement === first) { event.preventDefault(); last.focus(); }
    if (!event.shiftKey && document.activeElement === last) { event.preventDefault(); first.focus(); }
};

watch(mobileMenuOpen, (open) => { document.body.style.overflow = open ? 'hidden' : ''; });
watch(() => page.url, () => closeMenu());
watch(() => [successFlash.value, errorFlash.value], () => {
    showSuccessFlash.value = Boolean(successFlash.value);
    showErrorFlash.value = Boolean(errorFlash.value);
    clearTimeout(flashTimeout);
    if (showSuccessFlash.value || showErrorFlash.value) flashTimeout = setTimeout(() => { showSuccessFlash.value = false; showErrorFlash.value = false; }, 5000);
}, { immediate: true });

const hasMarketingConsent = () => typeof window !== 'undefined' && document.cookie.split('; ').some((item) => item === 'cookie_marketing_consent=1');
watch(() => page.props.flash?.meta_event, (event) => {
    if (!event || typeof window === 'undefined' || typeof window.fbq !== 'function' || !hasMarketingConsent() || event.event_name !== 'Lead') return;
    window.fbq('track', 'Lead', { form_type: event.form_type, lead_type: event.form_type, content_category: event.form_type }, { eventID: event.event_id });
}, { immediate: true });
onBeforeUnmount(() => { document.body.style.overflow = ''; clearTimeout(flashTimeout); });
</script>

<template>
    <div class="min-h-screen bg-kohl-paper text-kohl-ink" @keydown="handleKeydown">
        <div class="border-b border-white/10 bg-kohl-ink text-white">
            <div class="site-container flex min-h-10 items-center justify-between gap-4 py-2 text-[10px] font-bold uppercase tracking-[.14em]">
                <a :href="site.maps_url" target="_blank" rel="noopener" class="flex min-w-0 items-center gap-2 truncate text-white/70 transition hover:text-white"><Icon name="pin" />{{ site.city || site.address }}</a>
                <a :href="`tel:${site.phone_tel}`" class="flex shrink-0 items-center gap-2 text-kohl-yellow hover:text-white"><Icon name="phone" />{{ site.phone }}</a>
            </div>
        </div>

        <header class="sticky top-0 z-40 border-b border-kohl-line bg-kohl-paper/95 backdrop-blur">
            <div class="site-container flex min-h-[76px] items-center justify-between gap-6">
                <Link href="/" class="group flex items-center gap-3" :aria-label="`${site.name} home`">
                    <img :src="site.logo || '/images/kohl-mark.svg'" :alt="site.name" class="h-10 w-10">
                    <span><span class="block text-lg font-bold tracking-[-.05em]">{{ site.short_name || 'Kohl' }}</span><span class="block text-[9px] font-bold uppercase tracking-[.18em] text-kohl-muted">Auto Sales</span></span>
                </Link>
                <nav class="hidden items-center gap-1 lg:flex" aria-label="Primary navigation">
                    <Link v-for="item in primaryNav" :key="item.href" :href="item.href" class="px-3 py-2 text-xs font-bold uppercase tracking-[.1em] transition" :class="isActive(item.href) ? 'text-kohl-yellow-deep' : 'hover:text-kohl-yellow-deep'">{{ item.label }}</Link>
                </nav>
                <div class="hidden lg:block"><Link href="/inventory" class="btn-primary">Find a vehicle <Icon name="arrow-right" /></Link></div>
                <button ref="menuButton" type="button" class="grid h-11 w-11 place-items-center border border-kohl-ink lg:hidden" :aria-expanded="mobileMenuOpen" aria-controls="mobile-navigation" aria-label="Toggle menu" @click="toggleMenu"><span class="text-xl leading-none">{{ mobileMenuOpen ? '×' : '☰' }}</span></button>
            </div>
        </header>

        <Transition enter-active-class="transition duration-200" enter-from-class="opacity-0" leave-active-class="transition duration-150" leave-to-class="opacity-0">
            <div v-if="mobileMenuOpen" class="fixed inset-0 z-50 bg-kohl-ink/55 lg:hidden" @click.self="closeMenu">
                <aside id="mobile-navigation" ref="menuPanel" class="ml-auto flex h-full w-[min(86vw,380px)] flex-col overflow-y-auto bg-kohl-paper p-6 shadow-2xl" aria-label="Mobile navigation">
                    <div class="flex items-center justify-between border-b border-kohl-line pb-6"><span class="text-sm font-bold">{{ site.name }}</span><button type="button" class="text-2xl" aria-label="Close menu" @click="closeMenu">×</button></div>
                    <nav class="mt-6 grid" aria-label="Mobile primary navigation"><Link v-for="item in primaryNav" :key="item.href" :href="item.href" class="group flex items-center justify-between border-b border-kohl-line py-4 text-xl font-bold" :class="isActive(item.href) ? 'text-kohl-yellow-deep' : ''">{{ item.label }} <Icon name="arrow-right" class="transition group-hover:translate-x-1" /></Link></nav>
                    <Link href="/inventory" class="btn-primary mt-7">Find a vehicle <Icon name="arrow-right" /></Link>
                    <div class="mt-auto border-t border-kohl-line pt-6 text-sm"><a :href="`tel:${site.phone_tel}`" class="flex items-center gap-2 font-bold"><Icon name="phone" />{{ site.phone }}</a><a :href="site.maps_url" target="_blank" rel="noopener" class="mt-3 flex items-center gap-2 leading-6 text-kohl-muted">Get directions <Icon name="pin" /></a></div>
                </aside>
            </div>
        </Transition>

        <div class="pointer-events-none fixed right-5 top-24 z-[60] w-[calc(100%-2.5rem)] max-w-md space-y-3" aria-live="polite">
            <div v-if="showSuccessFlash && successFlash" class="pointer-events-auto border-l-4 border-[#70a17f] bg-kohl-ink px-5 py-4 text-sm text-white shadow-xl"><div class="flex gap-3"><span>✓</span><p class="flex-1">{{ successFlash }}</p><button aria-label="Dismiss" @click="showSuccessFlash = false">×</button></div></div>
            <div v-if="showErrorFlash && errorFlash" class="pointer-events-auto border-l-4 border-kohl-yellow bg-kohl-ink px-5 py-4 text-sm text-white shadow-xl"><div class="flex gap-3"><span>!</span><p class="flex-1">{{ errorFlash }}</p><button aria-label="Dismiss" @click="showErrorFlash = false">×</button></div></div>
        </div>

        <main><slot /></main>

        <footer class="bg-kohl-ink text-white">
            <div class="site-container py-14 lg:py-20"><div class="grid gap-10 border-b border-white/15 pb-12 lg:grid-cols-[1.5fr_.8fr_.8fr]">
                <div><p class="kohl-kicker">Kohl Auto Sales</p><h2 class="mt-5 max-w-md text-4xl font-bold leading-[.96] tracking-[-.055em]">Your next vehicle starts with a real conversation.</h2><div class="mt-7 flex flex-wrap gap-3"><Link href="/inventory" class="btn-primary">Browse inventory <Icon name="arrow-right" /></Link><a :href="`tel:${site.phone_tel}`" class="btn-secondary border-white/40 text-white hover:bg-white hover:text-kohl-ink"><Icon name="phone" />Call us</a></div></div>
                <div><p class="text-[10px] font-bold uppercase tracking-[.2em] text-white/45">Explore</p><nav class="mt-5 grid gap-3 text-sm font-bold"><Link href="/inventory">Inventory</Link><Link href="/finance">Financing</Link><Link href="/trade-in">Sell or trade</Link><Link href="/about">About Kohl</Link><Link href="/contact">Contact & directions</Link></nav></div>
                <div><p class="text-[10px] font-bold uppercase tracking-[.2em] text-white/45">Visit</p><a :href="site.maps_url" target="_blank" rel="noopener" class="mt-5 flex items-start gap-2 text-sm font-bold leading-6"><Icon name="pin" class="mt-0.5" />{{ site.address }}</a><p class="mt-3 text-sm text-white/55">{{ site.business_hours }}</p><a v-if="site.email" :href="`mailto:${site.email}`" class="mt-3 flex items-start gap-2 break-all text-sm text-white/70"><Icon name="mail" class="mt-0.5" />{{ site.email }}</a></div>
            </div><div class="flex flex-col gap-4 pt-6 text-[11px] text-white/45 sm:flex-row sm:justify-between"><p>© {{ new Date().getFullYear() }} {{ site.name }}. All rights reserved.</p><div class="flex gap-5"><Link href="/privacy-policy">Privacy</Link><Link href="/terms">Terms</Link><a href="/sitemap.xml">Sitemap</a></div></div></div>
        </footer>
        <CookieConsentBanner />
    </div>
</template>
