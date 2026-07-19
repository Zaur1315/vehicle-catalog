<script setup>
import {Link, useForm, usePage} from '@inertiajs/vue3';
import {computed} from 'vue';
import SeoHead from '@/Components/SeoHead.vue';
import SiteLayout from '@/Layouts/SiteLayout.vue';

defineOptions({
    layout: SiteLayout,
});

const page = usePage();

const site = computed(() => page.props.site || {});

const contactImage = '/images/visit-bg.webp';

const form = useForm({
    first_name: '',
    last_name: '',
    email: '',
    phone: '',
    subject: '',
    message: '',
});

const mapsEmbedUrl = computed(() => {
    if (site.value.maps_embed_url) {
        return site.value.maps_embed_url;
    }

    const address =
        site.value.address
        || '108a Rainbow Rd, East Granby, CT 06026, USA';

    return `https://www.google.com/maps?q=${encodeURIComponent(address)}&output=embed`;
});

const submit = () => {
    form.post('/contact', {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
    });
};

const contactOptions = [
    {
        number: '01',
        title: 'Vehicle sales',
        description:
            'Ask about availability, condition, mileage, price, stock number, or arranging a visit.',
        subject: 'Vehicle availability',
    },
    {
        number: '02',
        title: 'Financing',
        description:
            'Ask about the preliminary financing request and available next steps.',
        subject: 'Finance question',
    },
    {
        number: '03',
        title: 'Sell or trade',
        description:
            'Contact us about submitting your current vehicle for an initial review.',
        subject: 'Trade-in question',
    },
    {
        number: '04',
        title: 'General assistance',
        description:
            'Send a general question about the dealership, service availability, or your recent purchase.',
        subject: 'General question',
    },
];

const selectSubject = (subject) => {
    form.subject = subject;

    document
        .getElementById('contact-form')
        ?.scrollIntoView({
            behavior: 'smooth',
            block: 'start',
        });
};
</script>

<template>
    <SeoHead
        title="Contact Cars For Less"
        description="Contact Cars For Less Sales & Service in East Granby, CT about vehicle availability, financing, trade-ins, service availability, delivery, or general questions."
    />

    <!-- Light banner -->
    <section class="border-b border-black/10 bg-[#f5f3ee]">
        <div
            class="site-container pb-12 pt-12 lg:pb-16 lg:pt-16"
        >
            <div
                class="grid gap-8 lg:grid-cols-[1fr_380px] lg:items-end"
            >
                <div>
                    <p class="eyebrow">
                        Contact Cars For Less
                    </p>

                    <h1
                        class="mt-5 max-w-5xl text-5xl font-black leading-[0.9] tracking-[-0.065em] sm:text-6xl lg:text-7xl"
                    >
                        Let’s talk about<br>

                        <span class="text-[#ff4f38]">
                            what you need.
                        </span>
                    </h1>

                    <p
                        class="mt-6 max-w-3xl text-base leading-7 text-stone-600"
                    >
                        Contact our East Granby team about current inventory,
                        financing, your vehicle, service availability, or
                        general dealership questions.
                    </p>
                </div>

                <div class="border-l border-black/15 pl-6">
                    <p
                        class="text-[10px] font-black uppercase tracking-[0.2em] text-stone-400"
                    >
                        Call the dealership
                    </p>

                    <a
                        :href="`tel:${site.phone_tel}`"
                        class="mt-3 block text-2xl font-black tracking-[-0.03em] transition hover:text-[#e9422c]"
                    >
                        {{ site.phone }}
                    </a>

                    <p class="mt-2 text-sm leading-6 text-stone-500">
                        {{ site.business_hours }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact options -->
    <section class="bg-[#171717] text-white">
        <div
            class="site-container grid divide-y divide-white/10 md:grid-cols-2 md:divide-x md:divide-y-0 xl:grid-cols-4"
        >
            <button
                v-for="item in contactOptions"
                :key="item.number"
                type="button"
                class="group p-6 text-left transition hover:bg-white/5 lg:p-7"
                @click="selectSubject(item.subject)"
            >
                <div class="flex items-start justify-between gap-4">
                    <h2 class="text-lg font-black">
                        {{ item.title }}
                    </h2>

                    <span
                        class="text-[10px] font-black text-[#ff5a45]"
                    >
                        {{ item.number }}
                    </span>
                </div>

                <p class="mt-3 text-xs leading-5 text-stone-500">
                    {{ item.description }}
                </p>

                <span
                    class="mt-5 inline-flex text-[10px] font-black uppercase tracking-wider text-white underline decoration-[#ff4f38] decoration-2 underline-offset-8"
                >
                    Send a message
                </span>
            </button>
        </div>
    </section>

    <!-- Contact information and form -->
    <section class="site-section bg-white">
        <div
            class="site-container grid gap-10 xl:grid-cols-[0.72fr_1.28fr]"
        >
            <aside class="space-y-6">
                <div class="border border-black/10 bg-[#f5f3ee] p-6 sm:p-8">
                    <p class="eyebrow">
                        Contact information
                    </p>

                    <div class="mt-7 divide-y divide-black/10">
                        <div class="pb-6">
                            <p
                                class="text-[9px] font-black uppercase tracking-[0.2em] text-stone-400"
                            >
                                Phone
                            </p>

                            <a
                                :href="`tel:${site.phone_tel}`"
                                class="mt-3 block text-2xl font-black tracking-[-0.03em] transition hover:text-[#e9422c]"
                            >
                                {{ site.phone }}
                            </a>
                        </div>

                        <div class="py-6">
                            <p
                                class="text-[9px] font-black uppercase tracking-[0.2em] text-stone-400"
                            >
                                Email
                            </p>

                            <a
                                :href="`mailto:${site.email}`"
                                class="mt-3 block break-all text-lg font-black transition hover:text-[#e9422c]"
                            >
                                {{ site.email }}
                            </a>
                        </div>

                        <div class="py-6">
                            <p
                                class="text-[9px] font-black uppercase tracking-[0.2em] text-stone-400"
                            >
                                Address
                            </p>

                            <a
                                :href="site.maps_url"
                                target="_blank"
                                rel="noopener"
                                class="mt-3 block max-w-sm text-base font-black leading-7 transition hover:text-[#e9422c]"
                            >
                                {{ site.address }}
                            </a>
                        </div>

                        <div class="pt-6">
                            <p
                                class="text-[9px] font-black uppercase tracking-[0.2em] text-stone-400"
                            >
                                Business hours
                            </p>

                            <p class="mt-3 text-base font-black">
                                {{ site.business_hours }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-8 flex flex-col gap-3">
                        <a
                            :href="`tel:${site.phone_tel}`"
                            class="btn-primary w-full"
                        >
                            Call now
                        </a>

                        <a
                            :href="site.maps_url"
                            target="_blank"
                            rel="noopener"
                            class="btn-secondary w-full"
                        >
                            Get directions
                        </a>
                    </div>
                </div>

                <div class="relative min-h-[340px] overflow-hidden">
                    <img
                        :src="contactImage"
                        alt="Visit Cars For Less in East Granby"
                        class="absolute inset-0 h-full w-full object-cover"
                    >

                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/10 to-transparent"
                    ></div>

                    <div class="absolute inset-x-0 bottom-0 p-7 text-white">
                        <p
                            class="text-[9px] font-black uppercase tracking-[0.2em] text-[#ff6b57]"
                        >
                            Visit the dealership
                        </p>

                        <p
                            class="mt-3 text-2xl font-black leading-7 tracking-[-0.035em]"
                        >
                            See the vehicle and speak directly with our team.
                        </p>
                    </div>
                </div>
            </aside>

            <!-- Contact form -->
            <div
                id="contact-form"
                class="scroll-mt-32 border border-black/10 bg-[#f5f3ee]"
            >
                <div class="border-b border-black/10 p-6 sm:p-8">
                    <p
                        class="text-[10px] font-black uppercase tracking-[0.2em] text-[#e9422c]"
                    >
                        Send a message
                    </p>

                    <h2
                        class="mt-3 text-3xl font-black tracking-[-0.045em] sm:text-4xl"
                    >
                        How can we help?
                    </h2>

                    <p class="mt-4 max-w-2xl text-sm leading-6 text-stone-600">
                        Fields marked with an asterisk are required. Include a
                        vehicle name or stock number when asking about
                        inventory.
                    </p>
                </div>

                <form
                    class="p-6 sm:p-8"
                    @submit.prevent="submit"
                >
                    <fieldset>
                        <legend
                            class="text-xs font-black uppercase tracking-[0.16em]"
                        >
                            Contact information
                        </legend>

                        <div class="mt-5 grid gap-5 md:grid-cols-2">
                            <div>
                                <label
                                    class="mb-2 block text-[10px] font-black uppercase tracking-wider text-stone-500"
                                >
                                    First name *
                                </label>

                                <input
                                    v-model="form.first_name"
                                    required
                                    autocomplete="given-name"
                                    class="form-input-dark"
                                    placeholder="John"
                                >

                                <p
                                    v-if="form.errors.first_name"
                                    class="mt-2 text-xs font-bold text-red-600"
                                >
                                    {{ form.errors.first_name }}
                                </p>
                            </div>

                            <div>
                                <label
                                    class="mb-2 block text-[10px] font-black uppercase tracking-wider text-stone-500"
                                >
                                    Last name
                                </label>

                                <input
                                    v-model="form.last_name"
                                    autocomplete="family-name"
                                    class="form-input-dark"
                                    placeholder="Smith"
                                >

                                <p
                                    v-if="form.errors.last_name"
                                    class="mt-2 text-xs font-bold text-red-600"
                                >
                                    {{ form.errors.last_name }}
                                </p>
                            </div>

                            <div>
                                <label
                                    class="mb-2 block text-[10px] font-black uppercase tracking-wider text-stone-500"
                                >
                                    Phone *
                                </label>

                                <input
                                    v-model="form.phone"
                                    required
                                    type="tel"
                                    autocomplete="tel"
                                    class="form-input-dark"
                                    placeholder="+1 (000) 000-0000"
                                >

                                <p
                                    v-if="form.errors.phone"
                                    class="mt-2 text-xs font-bold text-red-600"
                                >
                                    {{ form.errors.phone }}
                                </p>
                            </div>

                            <div>
                                <label
                                    class="mb-2 block text-[10px] font-black uppercase tracking-wider text-stone-500"
                                >
                                    Email
                                </label>

                                <input
                                    v-model="form.email"
                                    type="email"
                                    autocomplete="email"
                                    class="form-input-dark"
                                    placeholder="john@example.com"
                                >

                                <p
                                    v-if="form.errors.email"
                                    class="mt-2 text-xs font-bold text-red-600"
                                >
                                    {{ form.errors.email }}
                                </p>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="mt-9 border-t border-black/10 pt-8">
                        <legend
                            class="text-xs font-black uppercase tracking-[0.16em]"
                        >
                            Your request
                        </legend>

                        <div class="mt-5">
                            <label
                                class="mb-2 block text-[10px] font-black uppercase tracking-wider text-stone-500"
                            >
                                Topic
                            </label>

                            <select
                                v-model="form.subject"
                                class="form-select-dark"
                            >
                                <option value="">
                                    Select a topic
                                </option>

                                <option value="Vehicle availability">
                                    Vehicle availability
                                </option>

                                <option value="Finance question">
                                    Financing question
                                </option>

                                <option value="Trade-in question">
                                    Sell or trade question
                                </option>

                                <option value="Delivery question">
                                    Delivery question
                                </option>

                                <option value="Warranty or return question">
                                    Warranty question
                                </option>

                                <option value="General question">
                                    Service or general question
                                </option>
                            </select>

                            <p
                                v-if="form.errors.subject"
                                class="mt-2 text-xs font-bold text-red-600"
                            >
                                {{ form.errors.subject }}
                            </p>
                        </div>

                        <div class="mt-5">
                            <label
                                class="mb-2 block text-[10px] font-black uppercase tracking-wider text-stone-500"
                            >
                                Message
                            </label>

                            <textarea
                                v-model="form.message"
                                rows="7"
                                class="form-input-dark resize-y"
                                placeholder="Tell us which vehicle or service you are interested in and how we can help."
                            ></textarea>

                            <p
                                v-if="form.errors.message"
                                class="mt-2 text-xs font-bold text-red-600"
                            >
                                {{ form.errors.message }}
                            </p>
                        </div>
                    </fieldset>

                    <div
                        class="mt-8 flex flex-col gap-5 border-t border-black/10 pt-7 md:flex-row md:items-center md:justify-between"
                    >
                        <p class="max-w-xl text-xs leading-5 text-stone-500">
                            By submitting this form, you agree to be contacted
                            about your request. Vehicle availability, price,
                            mileage, specifications, and other details remain
                            subject to confirmation.
                        </p>

                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="btn-primary shrink-0 md:min-w-52 disabled:cursor-not-allowed disabled:opacity-60"
                        >
                            {{
                                form.processing
                                    ? 'Sending…'
                                    : 'Send message'
                            }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Map -->
    <section class="overflow-hidden border-y border-black/10 bg-[#f5f3ee]">
        <div
            class="site-container grid lg:grid-cols-[1.2fr_0.8fr]"
        >
            <div class="min-h-[460px] bg-stone-200">
                <iframe
                    :src="mapsEmbedUrl"
                    class="h-full min-h-[460px] w-full border-0 grayscale"
                    loading="lazy"
                    allowfullscreen
                    referrerpolicy="no-referrer-when-downgrade"
                    title="Cars For Less dealership location"
                ></iframe>
            </div>

            <div
                class="flex flex-col justify-center py-14 lg:py-20 lg:pl-14"
            >
                <p class="eyebrow">
                    Find us
                </p>

                <h2
                    class="mt-5 text-4xl font-black leading-[0.95] tracking-[-0.055em] sm:text-5xl"
                >
                    Visit us in<br>
                    {{ site.city }}.
                </h2>

                <a
                    :href="site.maps_url"
                    target="_blank"
                    rel="noopener"
                    class="mt-7 max-w-sm text-lg font-black leading-7 transition hover:text-[#e9422c]"
                >
                    {{ site.address }}
                </a>

                <p class="mt-4 text-sm text-stone-500">
                    {{ site.business_hours }}
                </p>

                <a
                    :href="site.maps_url"
                    target="_blank"
                    rel="noopener"
                    class="btn-primary mt-8 self-start"
                >
                    Open in Google Maps
                </a>
            </div>
        </div>
    </section>

    <!-- Inventory CTA -->
    <section class="bg-[#ff4f38] py-14 text-white">
        <div
            class="site-container flex flex-col gap-7 md:flex-row md:items-center md:justify-between"
        >
            <div>
                <p
                    class="text-[10px] font-black uppercase tracking-[0.22em] text-white/60"
                >
                    Looking for a vehicle?
                </p>

                <h2
                    class="mt-3 text-3xl font-black tracking-[-0.04em]"
                >
                    Browse inventory before contacting sales.
                </h2>
            </div>

            <Link
                href="/inventory"
                class="inline-flex min-h-12 shrink-0 items-center justify-center rounded-full bg-[#171717] px-7 py-3 text-xs font-black uppercase tracking-wide text-white transition hover:bg-white hover:text-black"
            >
                View inventory
            </Link>
        </div>
    </section>
</template>
