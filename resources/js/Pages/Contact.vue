<script setup>
import {useForm, usePage} from '@inertiajs/vue3';
import SeoHead from '@/Components/SeoHead.vue';
import SiteLayout from '@/Layouts/SiteLayout.vue';
import {computed} from "vue";

defineOptions({
    layout: SiteLayout,
});

const page = usePage();

const site = computed(() => page.props.site || {});

const form = useForm({
    form_type: 'contact',
    first_name: '',
    last_name: '',
    email: '',
    phone: '',
    subject: '',
    message: '',
});

const submit = () => {
    form.post('/contact', {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
};

const mapsEmbedUrl = computed(() => {
    if (site.value.maps_embed_url) {
        return site.value.maps_embed_url;
    }

    const address = site.value.address || '197 Pratt St, Meriden, CT 06450, USA';

    return `https://www.google.com/maps?q=${encodeURIComponent(address)}&output=embed`;
});
</script>

<template>
    <SeoHead
        title="Contact"
        description="Contact our sales team about vehicle availability, pricing, delivery, warranty, finance, trade-in, or general purchase questions."
    />
    <section class="border-b border-white/10 bg-[#080b0f]">
        <div class="site-container py-10">
            <div class="grid gap-8 lg:grid-cols-[1fr_460px] lg:items-end">
                <div>
                    <p class="eyebrow">
                        Contact
                    </p>

                    <h1 class="mt-3 heading-lg">
                        Speak with our sales team.
                    </h1>

                    <p class="mt-5 max-w-3xl body-muted">
                        Contact us about vehicle availability, pricing, delivery, warranty, finance, trade-in,
                        or general purchase questions.
                    </p>
                </div>

                <div class="border border-white/10 bg-white/[0.035] p-5">
                    <p class="text-xs font-black uppercase tracking-[0.24em] text-slate-500">
                        Sales Hours
                    </p>

                    <p class="mt-2 text-2xl font-black text-white">
                        Mon–Fri
                    </p>

                    <p class="mt-1 text-sm text-slate-400">
                        9:00 AM – 5:00 PM
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="site-section">
        <div class="site-container">
            <div class="grid gap-8 xl:grid-cols-[0.85fr_1.15fr]">
                <aside class="space-y-5">
                    <div class="dealer-panel rounded-2xl p-6">
                        <p class="eyebrow">
                            Dealer Contact
                        </p>

                        <div class="mt-6 divide-y divide-white/10">
                            <div class="py-4 first:pt-0">
                                <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-500">
                                    Phone
                                </p>

                                <a
                                    :href="`tel:${site.phone_tel}`"
                                    class="mt-2 block text-2xl font-black text-white hover:text-amber-300"
                                >
                                    {{ site.phone }}
                                </a>
                            </div>

                            <div class="py-4">
                                <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-500">
                                    Email
                                </p>

                                <a
                                    :href="`mailto:${site.email}`"
                                    class="mt-2 block text-lg font-bold text-white hover:text-amber-300"
                                >
                                    {{site.email}}
                                </a>
                            </div>

                            <div class="py-4 last:pb-0">
                                <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-500">
                                    Location
                                </p>

                                <a
                                    :href="site.maps_url"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="mt-2 block text-sm leading-6 text-slate-300 hover:text-amber-300"
                                >
                                    {{ site.address }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="grid gap-5 sm:grid-cols-3 xl:grid-cols-1">
                        <article class="dealer-card p-5">
                            <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-500">
                                Sales
                            </p>

                            <h3 class="mt-3 text-xl font-black">
                                Availability & pricing
                            </h3>

                            <p class="mt-3 text-sm leading-6 text-slate-400">
                                Confirm vehicle status, stock number, price, mileage, and purchase terms.
                            </p>
                        </article>

                        <article class="dealer-card p-5">
                            <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-500">
                                Delivery
                            </p>

                            <h3 class="mt-3 text-xl font-black">
                                Enclosed transport
                            </h3>

                            <p class="mt-3 text-sm leading-6 text-slate-400">
                                Ask about insured enclosed delivery and estimated transport timing.
                            </p>
                        </article>

                        <article class="dealer-card p-5">
                            <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-500">
                                Warranty
                            </p>

                            <h3 class="mt-3 text-xl font-black">
                                Coverage questions
                            </h3>

                            <p class="mt-3 text-sm leading-6 text-slate-400">
                                Review warranty, return terms, exclusions, and eligibility before purchase.
                            </p>
                        </article>
                    </div>
                </aside>

                <div class="dealer-panel rounded-2xl">
                    <div class="border-b border-white/10 px-6 py-5">
                        <p class="text-xs font-black uppercase tracking-[0.24em] text-slate-500">
                            Send Message
                        </p>

                        <h2 class="mt-2 text-3xl font-black">
                            Request more information
                        </h2>
                    </div>

                    <form class="p-6" @submit.prevent="submit">
                        <div class="grid gap-5 md:grid-cols-2">
                            <div>
                                <label class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-400">
                                    First Name
                                </label>

                                <input
                                    v-model="form.first_name"
                                    required
                                    class="form-input-dark"
                                    placeholder="John"
                                >

                                <p v-if="form.errors.first_name" class="mt-2 text-sm text-red-300">
                                    {{ form.errors.first_name }}
                                </p>
                            </div>

                            <div>
                                <label class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-400">
                                    Last Name
                                </label>

                                <input
                                    v-model="form.last_name"
                                    class="form-input-dark"
                                    placeholder="Smith"
                                >

                                <p v-if="form.errors.last_name" class="mt-2 text-sm text-red-300">
                                    {{ form.errors.last_name }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-5 grid gap-5 md:grid-cols-2">
                            <div>
                                <label class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-400">
                                    Phone
                                </label>

                                <input
                                    v-model="form.phone"
                                    required
                                    class="form-input-dark"
                                    placeholder="+1 (000) 000-0000"
                                >

                                <p v-if="form.errors.phone" class="mt-2 text-sm text-red-300">
                                    {{ form.errors.phone }}
                                </p>
                            </div>

                            <div>
                                <label class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-400">
                                    Email
                                </label>

                                <input
                                    v-model="form.email"
                                    type="email"
                                    class="form-input-dark"
                                    placeholder="john@example.com"
                                >

                                <p v-if="form.errors.email" class="mt-2 text-sm text-red-300">
                                    {{ form.errors.email }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-5">
                            <label class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-400">
                                Subject
                            </label>

                            <select
                                v-model="form.subject"
                                class="form-select-dark"
                            >
                                <option value="">Select topic</option>
                                <option value="Vehicle availability">Vehicle availability</option>
                                <option value="Delivery question">Delivery question</option>
                                <option value="Warranty or return question">Warranty or return question</option>
                                <option value="Finance question">Finance question</option>
                                <option value="Trade-in question">Trade-in question</option>
                                <option value="General question">General question</option>
                            </select>

                            <p v-if="form.errors.subject" class="mt-2 text-sm text-red-300">
                                {{ form.errors.subject }}
                            </p>
                        </div>

                        <div class="mt-5">
                            <label class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-400">
                                Message
                            </label>

                            <textarea
                                v-model="form.message"
                                rows="7"
                                class="form-input-dark"
                                placeholder="Tell us what vehicle or service you are interested in..."
                            />

                            <p v-if="form.errors.message" class="mt-2 text-sm text-red-300">
                                {{ form.errors.message }}
                            </p>
                        </div>

                        <div
                            class="mt-6 flex flex-col gap-4 border-t border-white/10 pt-6 md:flex-row md:items-center md:justify-between">
                            <p class="max-w-xl text-xs leading-5 text-slate-500">
                                By submitting this form, you agree to be contacted about your request. Vehicle pricing,
                                availability, mileage, and terms are subject to confirmation.
                            </p>

                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="btn-primary md:min-w-52 disabled:opacity-60"
                            >
                                Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section class="site-section-tight border-y border-white/10 bg-white/[0.025]">
        <div class="site-container">
            <div class="section-header">
                <div>
                    <p class="eyebrow">
                        Find Us
                    </p>

                    <h2 class="mt-3 heading-lg">
                        Visit our dealership in {{ site.city }}, {{ site.state }}.
                    </h2>
                </div>

                <p class="max-w-xl body-muted">
                    Use the map below for directions, then contact our sales team to confirm vehicle availability before visiting.
                </p>
            </div>

            <div class="grid gap-8 lg:grid-cols-[1fr_360px]">
                <div class="overflow-hidden rounded-2xl border border-white/10 bg-black shadow-2xl shadow-black/30">
                    <iframe
                        :src="mapsEmbedUrl"
                        class="h-[420px] w-full border-0"
                        loading="lazy"
                        allowfullscreen
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Marick Auto Sales Google Map"
                    />
                </div>

                <div class="dealer-panel rounded-2xl p-6">
                    <p class="text-xs font-black uppercase tracking-[0.24em] text-slate-500">
                        Dealership Location
                    </p>

                    <h3 class="mt-3 text-2xl font-black">
                        {{ site.name }}
                    </h3>

                    <div class="mt-6 space-y-5">
                        <div>
                            <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-500">
                                Address
                            </p>

                            <a
                                :href="site.maps_url"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="mt-2 block text-sm leading-6 text-slate-300 hover:text-amber-300"
                            >
                                {{ site.address }}
                            </a>
                        </div>

                        <div>
                            <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-500">
                                Hours
                            </p>

                            <p class="mt-2 text-sm leading-6 text-slate-300">
                                {{ site.business_hours }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-8 flex flex-col gap-3">
                        <a
                            :href="site.maps_url"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="btn-primary w-full"
                        >
                            Open in Google Maps
                        </a>

                        <a
                            :href="`tel:${site.phone_tel}`"
                            class="btn-secondary w-full"
                        >
                            Call Now
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="site-section-tight border-y border-white/10 bg-white/[0.025]">
        <div class="site-container">
            <div class="grid gap-8 lg:grid-cols-[1fr_auto] lg:items-center">
                <div>
                    <p class="eyebrow">
                        Need a specific vehicle?
                    </p>

                    <h2 class="mt-3 heading-lg">
                        Browse inventory before contacting sales.
                    </h2>

                    <p class="mt-5 max-w-3xl body-muted">
                        You can open a vehicle page and send a request directly for that stock number.
                    </p>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row">
                    <a href="/inventory" class="btn-primary">
                        View Inventory
                    </a>

                    <a href="/finance" class="btn-secondary">
                        Finance Options
                    </a>
                </div>
            </div>
        </div>
    </section>
</template>
