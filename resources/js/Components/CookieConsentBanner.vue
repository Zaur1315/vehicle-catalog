<script setup>
import {Link, usePage} from '@inertiajs/vue3';
import {computed, onMounted, ref} from 'vue';

const CONSENT_KEY = 'kohl_auto_sales_cookie_consent';
const CONSENT_VERSION = '2026-07-28';
const CONSENT_MAX_AGE_DAYS = 180;

const page = usePage();

const readStoredConsent = () => {
    if (typeof window === 'undefined') {
        return null;
    }

    const rawConsent = window.localStorage.getItem(CONSENT_KEY);

    if (!rawConsent) {
        return null;
    }

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
const showSettings = ref(false);
const marketingEnabled = ref(
    hasCurrentConsent && Boolean(storedConsent.marketing),
);

const tracking = computed(() => page.props.tracking || {});

const setCookie = (name, value) => {
    if (typeof document === 'undefined') {
        return;
    }

    const maxAge = CONSENT_MAX_AGE_DAYS * 24 * 60 * 60;
    const secure = window.location.protocol === 'https:' ? '; Secure' : '';

    document.cookie = [
        `${name}=${encodeURIComponent(value)}`,
        `Max-Age=${maxAge}`,
        'Path=/',
        'SameSite=Lax',
        secure,
    ].join('; ');
};

const initializeMetaPixel = () => {
    if (
        typeof window === 'undefined'
        || !tracking.value.meta_pixel_enabled
        || !tracking.value.meta_pixel_id
        || typeof window.fbq === 'function'
    ) {
        return;
    }

    /* eslint-disable */
    !function (f, b, e, v, n, t, s) {
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
    }(
        window,
        document,
        'script',
        'https://connect.facebook.net/en_US/fbevents.js',
    );
    /* eslint-enable */

    window.fbq('init', tracking.value.meta_pixel_id);
    window.fbq('track', 'PageView');
};

const saveConsent = (marketing) => {
    if (typeof window === 'undefined') {
        return;
    }

    const consent = {
        version: CONSENT_VERSION,
        necessary: true,
        marketing,
        saved_at: new Date().toISOString(),
    };

    window.localStorage.setItem(
        CONSENT_KEY,
        JSON.stringify(consent),
    );

    setCookie('cookie_consent_status', 'configured');
    setCookie('cookie_marketing_consent', marketing ? '1' : '0');

    marketingEnabled.value = marketing;
    showSettings.value = false;
    isVisible.value = false;

    window.dispatchEvent(
        new CustomEvent('cookie-consent-updated', {
            detail: consent,
        }),
    );

    if (marketing) {
        initializeMetaPixel();
    }
};

const acceptAll = () => {
    saveConsent(true);
};

const rejectOptional = () => {
    saveConsent(false);
};

const saveChoices = () => {
    saveConsent(marketingEnabled.value);
};

onMounted(() => {
    if (hasCurrentConsent && storedConsent.marketing) {
        initializeMetaPixel();
    }
});
</script>

<template>
    <Transition
        enter-active-class="transition duration-500 ease-out"
        enter-from-class="translate-y-8 opacity-0"
        enter-to-class="translate-y-0 opacity-100"
        leave-active-class="transition duration-250 ease-in"
        leave-from-class="translate-y-0 opacity-100"
        leave-to-class="translate-y-8 opacity-0"
    >
        <aside
            v-if="isVisible"
            class="fixed inset-x-4 bottom-4 z-[100] mx-auto max-w-6xl overflow-hidden border border-kohl-line bg-white shadow-[10px_10px_0_rgba(16,42,86,.2)] sm:inset-x-6 sm:bottom-6"
            role="dialog"
            aria-modal="true"
            aria-labelledby="cookie-consent-title"
            aria-describedby="cookie-consent-description"
        >
            <div class="grid lg:grid-cols-[1fr_auto]">
                <div class="p-5 sm:p-7 lg:p-8">
                    <div class="flex items-start gap-4">
                        <div
                            class="hidden h-11 w-11 shrink-0 items-center justify-center bg-kohl-ink text-sm font-bold text-white sm:flex"
                            aria-hidden="true"
                        >
                            K
                        </div>

                        <div>
                            <p
                                class="text-[10px] font-bold uppercase tracking-[0.22em] text-kohl-yellow-deep"
                            >
                                Your privacy
                            </p>

                            <h2
                                id="cookie-consent-title"
                                class="mt-2 text-xl font-bold tracking-[-0.03em] text-kohl-ink sm:text-2xl"
                            >
                                Choose how we use cookies.
                            </h2>

                            <p
                                id="cookie-consent-description"
                                class="mt-3 max-w-3xl text-sm leading-6 text-kohl-muted"
                            >
                                Necessary cookies keep the website working.
                                With your permission, marketing cookies help
                                us measure visits and submitted forms.
                                You can change your choice later by clearing
                                this website’s stored data.
                            </p>

                            <Link
                                href="/privacy-policy"
                                class="mt-3 inline-flex text-xs font-bold text-kohl-ink underline decoration-kohl-yellow decoration-2 underline-offset-4 transition hover:text-kohl-yellow-deep"
                            >
                                Read our Privacy Policy
                            </Link>
                        </div>
                    </div>

                    <div
                        v-if="showSettings"
                        class="mt-6 grid gap-3 border-t border-kohl-line pt-6 md:grid-cols-2"
                    >
                        <div class="border border-kohl-line bg-kohl-paper p-4">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <h3 class="text-sm font-bold text-kohl-ink">
                                        Necessary
                                    </h3>

                                    <p class="mt-1 text-xs leading-5 text-kohl-muted">
                                        Required for security, forms, sessions,
                                        and basic website functionality.
                                    </p>
                                </div>

                                <span
                                    class="shrink-0 bg-kohl-ink px-3 py-1 text-[9px] font-bold uppercase tracking-wider text-white"
                                >
                                    Always on
                                </span>
                            </div>
                        </div>

                        <label
                            class="cursor-pointer border border-kohl-line bg-kohl-paper p-4 transition hover:border-kohl-ink"
                        >
                            <span class="flex items-start justify-between gap-4">
                                <span>
                                    <span
                                        class="block text-sm font-bold text-kohl-ink"
                                    >
                                        Marketing
                                    </span>

                                    <span
                                        class="mt-1 block text-xs leading-5 text-kohl-muted"
                                    >
                                        Allows Meta Pixel to measure page
                                        activity and lead submissions.
                                    </span>
                                </span>

                                <span class="relative mt-0.5 shrink-0">
                                    <input
                                        v-model="marketingEnabled"
                                        type="checkbox"
                                        class="peer sr-only"
                                    >

                                    <span
                                        class="block h-6 w-11 bg-stone-300 transition peer-checked:bg-kohl-yellow peer-focus-visible:outline-2 peer-focus-visible:outline-offset-2 peer-focus-visible:outline-kohl-yellow"
                                    ></span>

                                    <span
                                        class="absolute left-1 top-1 h-4 w-4 rounded-full bg-white shadow-sm transition peer-checked:translate-x-5"
                                    ></span>
                                </span>
                            </span>
                        </label>
                    </div>
                </div>

                <div
                    class="flex flex-col justify-center gap-3 border-t border-kohl-line bg-kohl-paper p-5 sm:flex-row lg:min-w-[260px] lg:flex-col lg:border-l lg:border-t-0 lg:p-7"
                >
                    <button
                        type="button"
                        class="btn-primary w-full"
                        @click="acceptAll"
                    >
                        Accept all
                    </button>

                    <button
                        v-if="showSettings"
                        type="button"
                        class="btn-secondary w-full"
                        @click="saveChoices"
                    >
                        Save choices
                    </button>

                    <button
                        v-else
                        type="button"
                        class="btn-secondary w-full"
                        @click="showSettings = true"
                    >
                        Manage cookies
                    </button>

                    <button
                        type="button"
                        class="px-4 py-2 text-xs font-bold text-kohl-muted transition hover:text-kohl-ink"
                        @click="rejectOptional"
                    >
                        Use necessary only
                    </button>
                </div>
            </div>
        </aside>
    </Transition>
</template>
