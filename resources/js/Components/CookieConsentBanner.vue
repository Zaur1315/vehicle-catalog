<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed, onMounted, ref } from 'vue';
import SiteDialog from '@/Components/SiteDialog.vue';
const KEY = 'southern_york_cookie_consent';
const VERSION = '2026-09-09';
const page = usePage();
const tracking = computed(() => page.props.tracking || {});
const visible = ref(false);
const preferences = ref(false);
const marketing = ref(false);
const setCookie = (name, value) => {
    document.cookie =
        name +
        '=' +
        value +
        '; Max-Age=15552000; Path=/; SameSite=Lax' +
        (location.protocol === 'https:' ? '; Secure' : '');
};
const initializeMetaPixel = () => {
    if (
        typeof window === 'undefined' ||
        !tracking.value.meta_pixel_enabled ||
        !tracking.value.meta_pixel_id ||
        typeof window.fbq === 'function'
    )
        return;

    /* eslint-disable */
    !(function (f, b, e, v, n, t, s) {
        if (f.fbq) return;
        n = f.fbq = function () {
            n.callMethod
                ? n.callMethod.apply(n, arguments)
                : n.queue.push(arguments);
        };
        if (!f._fbq) f._fbq = n;
        n.push = n;
        n.loaded = true;
        n.version = '2.0';
        n.queue = [];
        t = b.createElement(e);
        t.async = true;
        t.src = v;
        s = b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t, s);
    })(
        window,
        document,
        'script',
        'https://connect.facebook.net/en_US/fbevents.js',
    );
    /* eslint-enable */

    window.fbq('init', tracking.value.meta_pixel_id);
    window.fbq('track', 'PageView');
};

const save = (allowed) => {
    const choice = { version: VERSION, marketing: allowed, saved: Date.now() };
    try {
        localStorage.setItem(KEY, JSON.stringify(choice));
    } catch {
        /* Consent still applies to this visit. */
    }
    setCookie('cookie_consent_status', 'configured');
    setCookie('cookie_marketing_consent', allowed ? '1' : '0');
    marketing.value = allowed;
    visible.value = false;
    preferences.value = false;
    if (typeof window.fbq === 'function')
        window.fbq('consent', allowed ? 'grant' : 'revoke');
    if (allowed) initializeMetaPixel();
};
const openPreferences = () => {
    preferences.value = true;
};
defineExpose({ openPreferences });
onMounted(() => {
    let saved;
    try {
        saved = JSON.parse(localStorage.getItem(KEY) || 'null');
    } catch {
        saved = null;
    }
    if (saved?.version === VERSION && Date.now() - saved.saved < 15552000000) {
        marketing.value = Boolean(saved.marketing);
        setCookie('cookie_marketing_consent', marketing.value ? '1' : '0');
        if (marketing.value) initializeMetaPixel();
    } else {
        visible.value = true;
        setCookie('cookie_marketing_consent', '0');
    }
});
</script>
<template>
    <section v-if="visible" class="cookie-banner" aria-label="Cookie choices">
        <h2 class="text-base font-bold">
            A little privacy, before the open road.
        </h2>
        <p class="mt-2 text-xs leading-6 text-text-muted">
            We use essential cookies to run this site. Optional marketing
            cookies help measure visits and inquiries.
            <Link href="/privacy-policy" class="underline">Privacy Policy</Link>
        </p>
        <div class="mt-5 flex flex-wrap items-center gap-x-6 gap-y-4">
            <button class="btn-secondary !min-h-11 !px-4" @click="save(false)">
                Necessary only
            </button>
            <button class="btn-primary !min-h-11 !px-4" @click="save(true)">
                Accept optional
            </button>
            <button class="btn-ghost !min-h-11" @click="openPreferences">
                Preferences
            </button>
        </div>
    </section>
    <SiteDialog
        :open="preferences"
        title="Your cookie preferences"
        @close="preferences = false"
    >
        <p class="text-sm leading-7 text-text-muted">
            Choose whether to allow optional marketing measurement. Essential
            cookies keep forms and website security working.
        </p>
        <div class="my-6 rounded-xl border border-border p-5">
            <h3 class="text-sm font-bold">Necessary · always on</h3>
            <p class="mt-2 text-xs leading-6 text-text-muted">
                Security, sessions and your privacy choice.
            </p>
        </div>
        <label
            class="flex items-start gap-4 rounded-xl border border-border p-5"
        >
            <input
                v-model="marketing"
                type="checkbox"
                class="mt-1 size-5 accent-brand"
            />
            <span>
                <strong class="text-sm">Optional marketing</strong>
                <span class="mt-2 block text-xs leading-6 text-text-muted">
                    Allows Meta measurement when the dealership has enabled it.
                </span>
            </span>
        </label>
        <button class="btn-primary mt-7 w-full" @click="save(marketing)">
            Save my preferences
        </button>
    </SiteDialog>
</template>
