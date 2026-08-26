<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed, nextTick, onBeforeUnmount, onMounted, ref, watch } from 'vue';

const CONSENT_KEY = 'delmar_auto_sale_cookie_consent';
const CONSENT_VERSION = '2026-07-28';
const CONSENT_MAX_AGE_DAYS = 180;

const page = usePage();
const dialog = ref(null);
const previousFocus = ref(null);
const showSettings = ref(false);

const readStoredConsent = () => {
    if (typeof window === 'undefined') return null;
    const rawConsent = window.localStorage.getItem(CONSENT_KEY);
    if (!rawConsent) return null;
    try {
        return JSON.parse(rawConsent);
    } catch {
        window.localStorage.removeItem(CONSENT_KEY);
        return null;
    }
};

const storedConsent = readStoredConsent();
const hasCurrentConsent = storedConsent?.version === CONSENT_VERSION;
const isVisible = ref(!hasCurrentConsent);
const marketingEnabled = ref(hasCurrentConsent && Boolean(storedConsent.marketing));
const tracking = computed(() => page.props.tracking || {});
const logoUrl = '/images/brand/delmar-logo.svg';

const setCookie = (name, value) => {
    if (typeof document === 'undefined') return;
    const secure = window.location.protocol === 'https:' ? '; Secure' : '';
    document.cookie = [`${name}=${encodeURIComponent(value)}`, `Max-Age=${CONSENT_MAX_AGE_DAYS * 24 * 60 * 60}`, 'Path=/', 'SameSite=Lax', secure].join('; ');
};

const initializeMetaPixel = () => {
    if (typeof window === 'undefined' || !tracking.value.meta_pixel_enabled || !tracking.value.meta_pixel_id || typeof window.fbq === 'function') return;

    /* eslint-disable */
    !function (f, b, e, v, n, t, s) {
        if (f.fbq) return;
        n = f.fbq = function () { n.callMethod ? n.callMethod.apply(n, arguments) : n.queue.push(arguments); };
        if (!f._fbq) f._fbq = n;
        n.push = n; n.loaded = true; n.version = '2.0'; n.queue = [];
        t = b.createElement(e); t.async = true; t.src = v;
        s = b.getElementsByTagName(e)[0]; s.parentNode.insertBefore(t, s);
    }(window, document, 'script', 'https://connect.facebook.net/en_US/fbevents.js');
    /* eslint-enable */

    window.fbq('init', tracking.value.meta_pixel_id);
    window.fbq('track', 'PageView');
};

const lockBody = () => { document.body.style.overflow = 'hidden'; };
const unlockBody = () => { document.body.style.overflow = ''; };
const getFocusable = () => [...(dialog.value?.querySelectorAll('button, a[href], input, [tabindex]:not([tabindex="-1"])') || [])].filter((element) => !element.disabled);

const handleKeydown = (event) => {
    if (!isVisible.value) return;
    if (event.key === 'Escape') { event.preventDefault(); return; }
    if (event.key !== 'Tab') return;
    const focusable = getFocusable();
    if (!focusable.length) return;
    const first = focusable[0];
    const last = focusable[focusable.length - 1];
    if (event.shiftKey && document.activeElement === first) { event.preventDefault(); last.focus(); }
    if (!event.shiftKey && document.activeElement === last) { event.preventDefault(); first.focus(); }
};

const focusDialog = async () => {
    await nextTick();
    getFocusable()[0]?.focus();
};

const saveConsent = (marketing) => {
    if (typeof window === 'undefined') return;
    const consent = { version: CONSENT_VERSION, necessary: true, marketing, saved_at: new Date().toISOString() };
    window.localStorage.setItem(CONSENT_KEY, JSON.stringify(consent));
    setCookie('cookie_consent_status', 'configured');
    setCookie('cookie_marketing_consent', marketing ? '1' : '0');
    marketingEnabled.value = marketing;
    showSettings.value = false;
    isVisible.value = false;
    window.dispatchEvent(new CustomEvent('cookie-consent-updated', { detail: consent }));
    if (marketing) initializeMetaPixel();
};

watch(isVisible, async (visible) => {
    if (visible) { lockBody(); await focusDialog(); } else { unlockBody(); previousFocus.value?.focus?.(); }
});

onMounted(() => {
    if (isVisible.value) { previousFocus.value = document.activeElement; lockBody(); focusDialog(); }
    if (hasCurrentConsent && storedConsent.marketing) initializeMetaPixel();
    window.addEventListener('keydown', handleKeydown);
});

onBeforeUnmount(() => { unlockBody(); window.removeEventListener('keydown', handleKeydown); });
</script>

<template>
    <Transition name="cookie-consent">
        <div v-if="isVisible" class="cookie-consent-backdrop" aria-hidden="false">
            <section ref="dialog" class="cookie-consent-modal" role="dialog" aria-modal="true" aria-labelledby="cookie-consent-title" aria-describedby="cookie-consent-description">
                <div class="flex items-start justify-between gap-5">
                    <img :src="logoUrl" alt="Delmar Auto Sale Inc." class="h-9 w-auto max-w-[160px]">
                    <span class="cookie-consent-label">Privacy</span>
                </div>
                <div class="mt-9">
                    <p class="eyebrow">Your privacy choices</p>
                    <h2 id="cookie-consent-title" class="mt-3 text-3xl font-bold tracking-[-.05em] text-ink sm:text-4xl">Choose how we use cookies.</h2>
                    <p id="cookie-consent-description" class="mt-4 text-sm leading-7 text-text-muted">We use essential technologies to operate this website and may use optional technologies for analytics, advertising measurement, and related features. Choose whether to allow optional cookies.</p>
                    <Link href="/privacy-policy" class="mt-5 inline-flex items-center gap-2 text-sm font-bold text-ink underline decoration-brand decoration-2 underline-offset-4 transition hover:text-brand">Privacy Policy <span aria-hidden="true">→</span></Link>
                </div>

                <div v-if="showSettings" class="mt-7 grid gap-3 border-t border-border pt-6 sm:grid-cols-2">
                    <div class="cookie-consent-setting"><div><h3 class="text-sm font-bold text-ink">Necessary</h3><p class="mt-1 text-xs leading-5 text-text-muted">Required for security, forms, sessions, and basic website functionality.</p></div><span class="cookie-consent-badge">Always on</span></div>
                    <label class="cookie-consent-setting cursor-pointer"><span><span class="block text-sm font-bold text-ink">Marketing</span><span class="mt-1 block text-xs leading-5 text-text-muted">Allows Meta Pixel to measure page activity and lead submissions.</span></span><input v-model="marketingEnabled" type="checkbox" class="cookie-consent-checkbox" aria-label="Allow optional marketing cookies"></label>
                </div>

                <div class="mt-8 grid gap-3 sm:grid-cols-2">
                    <button type="button" class="btn-secondary w-full" @click="saveConsent(false)">Necessary only</button>
                    <button type="button" class="btn-primary w-full" @click="saveConsent(true)">Accept all</button>
                </div>
                <div class="mt-4 flex flex-wrap items-center justify-between gap-4">
                    <button type="button" class="btn-ghost" @click="showSettings = !showSettings">{{ showSettings ? 'Hide preferences' : 'Manage preferences' }}</button>
                    <button v-if="showSettings" type="button" class="text-xs font-bold uppercase tracking-[.1em] text-text-muted underline decoration-brand underline-offset-4 transition hover:text-brand" @click="saveConsent(marketingEnabled)">Save choices</button>
                </div>
            </section>
        </div>
    </Transition>
</template>
