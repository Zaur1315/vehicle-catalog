<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed, onBeforeUnmount, onMounted, ref, watch } from 'vue';
import CookieConsentBanner from '@/Components/CookieConsentBanner.vue';
import SiteDialog from '@/Components/SiteDialog.vue';
import Icon from '@/Components/Icon.vue';
const page = usePage();
const site = computed(() => page.props.site || {});
const menuOpen = ref(false);
const scrolled = ref(false);
const consent = ref(null);
const nav = [
    { label: 'Home', href: '/' },
    { label: 'Inventory', href: '/inventory' },
    { label: 'Financing', href: '/finance' },
    { label: 'Sell / Trade', href: '/trade-in' },
    { label: 'About', href: '/about' },
    { label: 'Contact', href: '/contact' },
];
const active = (href) => {
    const path = page.url.split('?')[0];
    return href === '/' ? path === '/' : path === href || path.startsWith(href + '/');
};
const updateScroll = () => (scrolled.value = window.scrollY > 28);
onMounted(() => {
    updateScroll();
    window.addEventListener('scroll', updateScroll, { passive: true });
});
onBeforeUnmount(() => window.removeEventListener('scroll', updateScroll));
watch(() => page.url, () => (menuOpen.value = false));
watch(
    () => page.props.flash?.meta_event,
    (event) => {
        if (!event || typeof window === 'undefined' || typeof window.fbq !== 'function' || event.event_name !== 'Lead') return;
        if (!document.cookie.split('; ').includes('cookie_marketing_consent=1')) return;
        window.fbq('track', 'Lead', { form_type: event.form_type, lead_type: event.form_type, content_category: event.form_type }, { eventID: event.event_id });
    },
);
</script>

<template>
    <a href="#main-content" class="skip-link">Skip to content</a>
    <header class="site-header" :class="{ 'is-scrolled': scrolled }">
        <div class="site-container header-inner">
            <Link href="/" :aria-label="`${site.name} home`" class="brand-link"><img :src="site.logo" :alt="site.name" width="318" height="64" class="site-logo" /></Link>
            <div class="header-actions">
                <a :href="`tel:${site.phone_tel}`" class="header-phone"><small>Call us</small>{{ site.phone }}</a>
                <Link href="/inventory" class="btn-primary header-cta">Browse Inventory</Link>
                <button class="menu-trigger" type="button" aria-label="Open navigation" :aria-expanded="menuOpen" @click="menuOpen = true"><span></span><span></span><span></span></button>
            </div>
        </div>
    </header>
    <SiteDialog :open="menuOpen" title="Advantage Auto Sales navigation" drawer @close="menuOpen = false">
        <div class="mobile-menu-brand"><img :src="site.logo" :alt="site.name" width="318" height="64" /><p>Used vehicles in {{ site.city }}, {{ site.state }}.</p></div>
        <nav class="mobile-nav" aria-label="Mobile navigation">
            <Link v-for="item in nav" :key="item.href" :href="item.href" :aria-current="active(item.href) ? 'page' : undefined">{{ item.label }}<Icon name="arrow-right" /></Link>
        </nav>
        <Link href="/inventory" class="btn-primary mt-7 w-full">Browse Inventory <Icon name="arrow-right" /></Link>
        <div class="mobile-contact-grid">
            <a :href="`tel:${site.phone_tel}`"><small>Call</small>{{ site.phone }}</a>
            <a :href="`mailto:${site.email}`"><small>Email</small>{{ site.email }}</a>
            <a :href="site.maps_url" target="_blank" rel="noopener"><small>Visit</small>{{ site.address }}</a>
        </div>
    </SiteDialog>
    <main id="main-content" tabindex="-1">
        <p v-if="page.props.flash?.error" role="alert" class="site-container form-error py-4">{{ page.props.flash.error }}</p>
        <div :key="page.url.split('?')[0]" class="page-content"><slot /></div>
    </main>
    <footer class="site-footer">
        <div class="site-container footer-grid">
            <div class="footer-brand">
                <img :src="site.logo_light" :alt="site.name" width="318" height="64" />
                <p>A simpler way to shop for your next vehicle in Uniontown. Explore what is available, compare the details, and contact our team when you are ready.</p>
                <Link href="/inventory" class="btn-accent">Browse Inventory <Icon name="arrow-right" /></Link>
            </div>
            <nav aria-label="Footer navigation" class="footer-links"><p class="footer-label">Explore</p><Link v-for="item in nav" :key="item.href" :href="item.href">{{ item.label }}</Link></nav>
            <div class="footer-contact">
                <p class="footer-label">Talk with us</p>
                <a :href="`tel:${site.phone_tel}`" class="footer-phone">{{ site.phone }}</a>
                <a :href="`mailto:${site.email}`">{{ site.email }}</a>
                <a :href="site.maps_url" target="_blank" rel="noopener">{{ site.address }}</a>
            </div>
            <div class="footer-map"><iframe v-if="site.maps_embed_url" :src="site.maps_embed_url" title="Map showing Advantage Auto Sales at 1026 National Pike in Uniontown, Pennsylvania" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe></div>
        </div>
        <div class="site-container footer-bottom">
            <p>© {{ new Date().getFullYear() }} {{ site.name }}</p>
            <div><Link href="/privacy-policy">Privacy Policy</Link><Link href="/terms">Terms of Use</Link><button @click="consent?.openPreferences()">Cookie preferences</button></div>
        </div>
    </footer>
    <CookieConsentBanner ref="consent" />
</template>
