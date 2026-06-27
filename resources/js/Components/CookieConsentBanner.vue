<script setup>
import {computed, ref} from 'vue';
import {usePage} from '@inertiajs/vue3';

const CONSENT_KEY = 'marick_cookie_consent';
const CONSENT_VERSION = '2026-06-27';

const page = usePage();

const storedConsent = (() => {
    if (typeof window === 'undefined') {
        return null;
    }

    const raw = window.localStorage.getItem(CONSENT_KEY);

    if (!raw) {
        return null;
    }

    try {
        return JSON.parse(raw);
    } catch {
        return null;
    }
})();

const isVisible = ref(!storedConsent || storedConsent.version !== CONSENT_VERSION);
const showSettings = ref(false);

const marketingEnabled = ref(Boolean(storedConsent?.marketing));

const tracking = computed(() => page.props.tracking || {});

const setCookie = (name, value, maxAgeDays = 180) => {
    const maxAge = maxAgeDays * 24 * 60 * 60;

    document.cookie = `${name}=${value}; Max-Age=${maxAge}; Path=/; SameSite=Lax`;
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
            n.callMethod ?
                n.callMethod.apply(n, arguments) : n.queue.push(arguments)
        };
        if (!f._fbq) f._fbq = n;
        n.push = n;
        n.loaded = !0;
        n.version = '2.0';
        n.queue = [];
        t = b.createElement(e);
        t.async = !0;
        t.src = v;
        s = b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t, s);
    }(window, document, 'script', 'https://connect.facebook.net/en_US/fbevents.js');
    /* eslint-enable */

    window.fbq('init', tracking.value.meta_pixel_id);
    window.fbq('track', 'PageView');
};

const saveConsent = (marketing) => {
    const consent = {
        version: CONSENT_VERSION,
        necessary: true,
        marketing,
        saved_at: new Date().toISOString(),
    };

    window.localStorage.setItem(CONSENT_KEY, JSON.stringify(consent));

    setCookie('cookie_consent_status', 'configured');
    setCookie('cookie_marketing_consent', marketing ? '1' : '0');

    marketingEnabled.value = marketing;
    isVisible.value = false;

    window.dispatchEvent(new CustomEvent('cookie-consent-updated', {
        detail: consent,
    }));

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
</script>

<template>
    <Transition
        enter-active-class="transition duration-300 ease-out"
        enter-from-class="translate-y-8 opacity-0"
        enter-to-class="translate-y-0 opacity-100"
        leave-active-class="transition duration-200 ease-in"
        leave-from-class="translate-y-0 opacity-100"
        leave-to-class="translate-y-8 opacity-0"
    >
        <div
            v-if="isVisible"
            class="fixed inset-x-0 bottom-0 z-[95] border-t border-white/10 bg-[#080b0f]/95 px-4 py-4 shadow-2xl shadow-black/50 backdrop-blur-md"
        >
            <div class="mx-auto grid max-w-7xl gap-5 lg:grid-cols-[1fr_auto] lg:items-center">
                <div>
                    <p class="text-xs font-black uppercase tracking-[0.24em] text-amber-300">
                        Cookie Preferences
                    </p>

                    <h2 class="mt-2 text-xl font-black text-white">
                        We use cookies to improve your experience.
                    </h2>

                    <p class="mt-2 max-w-3xl text-sm leading-6 text-slate-300">
                        Necessary cookies keep the website working. With your permission, marketing cookies help us
                        measure form submissions and advertising performance.
                    </p>

                    <div
                        v-if="showSettings"
                        class="mt-5 grid gap-3 md:grid-cols-2"
                    >
                        <div class="rounded-xl border border-white/10 bg-white/[0.035] p-4">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="font-black text-white">
                                        Necessary cookies
                                    </p>

                                    <p class="mt-1 text-sm leading-5 text-slate-400">
                                        Required for core site functionality and security.
                                    </p>
                                </div>

                                <span class="rounded-full bg-slate-700 px-3 py-1 text-xs font-black text-white">
                                    Always on
                                </span>
                            </div>
                        </div>

                        <label class="cursor-pointer rounded-xl border border-white/10 bg-white/[0.035] p-4">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="font-black text-white">
                                        Marketing cookies
                                    </p>

                                    <p class="mt-1 text-sm leading-5 text-slate-400">
                                        Allows Meta Pixel measurement for leads and page activity.
                                    </p>
                                </div>

                                <input
                                    v-model="marketingEnabled"
                                    type="checkbox"
                                    class="mt-1 h-5 w-5 rounded border-white/20 bg-black text-amber-300 focus:ring-amber-300"
                                >
                            </div>
                        </label>
                    </div>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row lg:flex-col xl:flex-row">
                    <button
                        type="button"
                        class="btn-primary"
                        @click="acceptAll"
                    >
                        Accept All
                    </button>

                    <button
                        type="button"
                        class="btn-secondary"
                        @click="rejectOptional"
                    >
                        Reject
                    </button>

                    <button
                        v-if="!showSettings"
                        type="button"
                        class="btn-secondary"
                        @click="showSettings = true"
                    >
                        Manage
                    </button>

                    <button
                        v-else
                        type="button"
                        class="btn-secondary"
                        @click="saveChoices"
                    >
                        Save Choices
                    </button>
                </div>
            </div>
        </div>
    </Transition>
</template>
