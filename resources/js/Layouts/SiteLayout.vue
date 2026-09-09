<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';
import CookieConsentBanner from '@/Components/CookieConsentBanner.vue';
import SiteDialog from '@/Components/SiteDialog.vue';
import Icon from '@/Components/Icon.vue';
const page = usePage();
const site = computed(() => page.props.site || {});
const menuOpen = ref(false);
const consent = ref(null);
const nav = [
    { label: 'Inventory', href: '/inventory' },
    { label: 'Auto Financing', href: '/finance' },
    { label: 'Sell or Trade', href: '/trade-in' },
    { label: 'Why Southern York', href: '/about' },
    { label: 'Contact', href: '/contact' },
];
const active = (href) =>
    page.url.split('?')[0] === href || page.url.startsWith(href + '/');
watch(
    () => page.url,
    () => {
        menuOpen.value = false;
    },
);
watch(
    () => page.props.flash?.meta_event,
    (event) => {
        if (
            !event ||
            typeof window === 'undefined' ||
            typeof window.fbq !== 'function' ||
            event.event_name !== 'Lead'
        )
            return;
        if (!document.cookie.split('; ').includes('cookie_marketing_consent=1'))
            return;
        window.fbq(
            'track',
            'Lead',
            {
                form_type: event.form_type,
                lead_type: event.form_type,
                content_category: event.form_type,
            },
            { eventID: event.event_id },
        );
    },
);
</script>
<template>
    <a href="#main-content" class="skip-link">Skip to content</a>
    <div class="announcement">
        <div class="site-container flex items-center justify-between gap-4">
            <span>
                {{ site.city }}, {{ site.state }}
                <span class="hidden sm:inline">
                    · A local start to your next adventure
                </span>
            </span>
            <a :href="'tel:' + site.phone_tel">{{ site.phone }} ↗</a>
        </div>
    </div>
    <header class="site-header">
        <div
            class="site-container flex min-h-24 items-center justify-between gap-5"
        >
            <Link href="/" :aria-label="site.name + ' home'" class="shrink-0">
                <img
                    :src="site.logo"
                    :alt="site.name"
                    width="300"
                    height="64"
                    class="site-logo"
                />
            </Link>
            <nav
                class="hidden items-center gap-7 xl:flex"
                aria-label="Main navigation"
            >
                <Link
                    v-for="item in nav"
                    :key="item.href"
                    :href="item.href"
                    :aria-current="active(item.href) ? 'page' : undefined"
                    class="nav-link"
                >
                    {{ item.label }}
                </Link>
            </nav>
            <Link href="/inventory" class="btn-primary hidden md:inline-flex">
                Find your vehicle
                <Icon name="arrow-right" />
            </Link>
            <button
                class="icon-button xl:hidden"
                aria-label="Open navigation"
                :aria-expanded="menuOpen"
                @click="menuOpen = true"
            >
                <Icon name="menu" />
            </button>
        </div>
    </header>
    <SiteDialog
        :open="menuOpen"
        title="Explore Southern York"
        drawer
        @close="menuOpen = false"
    >
        <nav class="grid" aria-label="Mobile navigation">
            <Link
                v-for="item in nav"
                :key="item.href"
                :href="item.href"
                :aria-current="active(item.href) ? 'page' : undefined"
                class="flex items-center justify-between border-b border-border py-5 text-2xl font-display"
            >
                {{ item.label }}
                <Icon name="arrow-right" />
            </Link>
        </nav>
        <a :href="'tel:' + site.phone_tel" class="btn-primary mt-8 w-full">
            <Icon name="phone" />
            {{ site.phone }}
        </a>
        <p class="mt-7 text-sm leading-7 text-text-muted">
            {{ site.address }}
        </p>
    </SiteDialog>
    <main id="main-content" tabindex="-1">
        <p
            v-if="page.props.flash?.error"
            role="alert"
            class="site-container form-error py-4"
        >
            {{ page.props.flash.error }}
        </p>
        <div :key="page.url.split('?')[0]" class="page-content">
            <slot />
        </div>
    </main>
    <footer class="site-footer">
        <div class="site-container">
            <div class="footer-invitation">
                <div>
                    <p class="eyebrow">The road ahead starts here</p>
                    <h2>Let's find your next chapter.</h2>
                </div>
                <Link href="/inventory" class="btn-light">
                    Explore inventory
                    <Icon name="arrow-right" />
                </Link>
            </div>
            <div
                class="grid gap-10 py-12 md:grid-cols-3 lg:grid-cols-[1.2fr_.8fr_1fr]"
            >
                <div>
                    <img
                        :src="'/images/brand/southern-york-logo-light.svg'"
                        :alt="site.name"
                        width="300"
                        height="64"
                        class="w-64"
                    />
                    <p class="mt-6 max-w-xs text-sm leading-7 text-white/70">
                        Pre-owned vehicles. Personal conversations. Right here
                        in {{ site.city }}.
                    </p>
                </div>
                <nav
                    aria-label="Footer navigation"
                    class="grid content-start gap-3"
                >
                    <p class="footer-label">Make your next move</p>
                    <Link
                        v-for="item in nav"
                        :key="item.href"
                        :href="item.href"
                    >
                        {{ item.label }}
                    </Link>
                </nav>
                <div>
                    <p class="footer-label">Come say hello</p>
                    <a
                        :href="site.maps_url"
                        target="_blank"
                        rel="noopener"
                        class="block max-w-xs leading-7"
                    >
                        {{ site.address }} ↗
                    </a>
                    <a :href="'tel:' + site.phone_tel" class="mt-5 block">
                        {{ site.phone }}
                    </a>
                    <a
                        :href="'mailto:' + site.email"
                        class="mt-2 block break-all"
                    >
                        {{ site.email }}
                    </a>
                    <p v-if="site.business_hours" class="mt-4 text-sm">
                        {{ site.business_hours }}
                    </p>
                </div>
            </div>
            <div
                class="flex flex-col justify-between gap-4 border-t border-white/20 py-6 text-xs text-white/65 md:flex-row"
            >
                <p>© {{ new Date().getFullYear() }} {{ site.name }}</p>
                <div class="flex flex-wrap gap-5">
                    <Link href="/privacy-policy">Privacy Policy</Link>
                    <Link href="/terms">Terms of Use</Link>
                    <button @click="consent?.openPreferences()">
                        Cookie preferences
                    </button>
                </div>
            </div>
        </div>
    </footer>
    <CookieConsentBanner ref="consent" />
</template>
