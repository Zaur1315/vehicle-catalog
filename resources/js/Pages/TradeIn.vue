<script setup>
import {Link, useForm} from '@inertiajs/vue3';
import SeoHead from '@/Components/SeoHead.vue';
import SiteLayout from '@/Layouts/SiteLayout.vue';

defineOptions({
    layout: SiteLayout,
});

const form = useForm({
    first_name: '',
    last_name: '',
    email: '',
    phone: '',
    make: '',
    model: '',
    year: '',
    mileage: '',
    condition: '',
    vin: '',
    message: '',
});

const submit = () => {
    form.post('/trade-in', {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
};

const processSteps = [
    {
        number: '01',
        title: 'Submit vehicle details',
        text: 'Tell us the make, model, year, mileage, condition, VIN, and any notes about your current vehicle.',
    },
    {
        number: '02',
        title: 'Initial review',
        text: 'Our team reviews market data, vehicle condition, mileage, history, and current inventory needs.',
    },
    {
        number: '03',
        title: 'Estimate discussion',
        text: 'We contact you with next steps and discuss how the trade-in may apply toward another vehicle.',
    },
    {
        number: '04',
        title: 'Final confirmation',
        text: 'A final trade-in value depends on inspection, title status, vehicle history, and purchase agreement.',
    },
];
</script>

<template>
    <SeoHead
        title="Trade-In"
        description="Request a trade-in estimate for your current vehicle by submitting make, model, year, mileage, condition, and VIN."
    />
    <section class="border-b border-white/10 bg-[#080b0f]">
        <div class="site-container py-10">
            <div class="grid gap-8 lg:grid-cols-[1fr_460px] lg:items-end">
                <div>
                    <p class="eyebrow">
                        Trade-In
                    </p>

                    <h1 class="mt-3 heading-lg">
                        Request a trade-in estimate for your current vehicle.
                    </h1>

                    <p class="mt-5 max-w-3xl body-muted">
                        Submit your vehicle details and our team will review the information before contacting you
                        about possible trade-in options.
                    </p>
                </div>

                <div class="border border-white/10 bg-white/[0.035] p-5">
                    <p class="text-xs font-black uppercase tracking-[0.24em] text-slate-500">
                        Trade-In Review
                    </p>

                    <p class="mt-2 text-4xl font-black text-amber-300">
                        4
                    </p>

                    <p class="mt-1 text-sm text-slate-400">
                        step estimate process
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
                            How It Works
                        </p>

                        <h2 class="mt-3 text-3xl font-black">
                            Trade-in value depends on details.
                        </h2>

                        <p class="mt-4 text-sm leading-6 text-slate-400">
                            The more accurate your vehicle information is, the better our team can prepare a useful
                            first review before inspection.
                        </p>
                    </div>

                    <div class="border border-white/10 bg-white/[0.025]">
                        <article
                            v-for="step in processSteps"
                            :key="step.number"
                            class="border-b border-white/10 p-5 last:border-b-0"
                        >
                            <p class="text-3xl font-black text-amber-300">
                                {{ step.number }}
                            </p>

                            <h3 class="mt-4 text-xl font-black">
                                {{ step.title }}
                            </h3>

                            <p class="mt-3 text-sm leading-6 text-slate-400">
                                {{ step.text }}
                            </p>
                        </article>
                    </div>

                    <div class="dealer-panel rounded-2xl">
                        <div class="border-b border-white/10 px-6 py-5">
                            <p class="text-xs font-black uppercase tracking-[0.24em] text-slate-500">
                                Helpful Information
                            </p>
                        </div>

                        <div class="divide-y divide-white/10">
                            <div class="px-6 py-5">
                                <h3 class="font-black">
                                    VIN
                                </h3>

                                <p class="mt-2 text-sm leading-6 text-slate-400">
                                    VIN helps check vehicle history, trim, title records, and specifications.
                                </p>
                            </div>

                            <div class="px-6 py-5">
                                <h3 class="font-black">
                                    Mileage
                                </h3>

                                <p class="mt-2 text-sm leading-6 text-slate-400">
                                    Accurate mileage is one of the most important factors in trade-in review.
                                </p>
                            </div>

                            <div class="px-6 py-5">
                                <h3 class="font-black">
                                    Condition
                                </h3>

                                <p class="mt-2 text-sm leading-6 text-slate-400">
                                    Mechanical condition, body condition, tire condition, interior wear, and accident
                                    history can affect value.
                                </p>
                            </div>
                        </div>
                    </div>
                </aside>

                <div class="dealer-panel rounded-2xl">
                    <div class="border-b border-white/10 px-6 py-5">
                        <p class="text-xs font-black uppercase tracking-[0.24em] text-slate-500">
                            Trade-In Form
                        </p>

                        <h2 class="mt-2 text-3xl font-black">
                            Submit your vehicle
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

                        <div class="mt-8 border-t border-white/10 pt-6">
                            <p class="text-xs font-black uppercase tracking-[0.24em] text-slate-500">
                                Vehicle Information
                            </p>
                        </div>

                        <div class="mt-5 grid gap-5 md:grid-cols-2">
                            <div>
                                <label class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-400">
                                    Make
                                </label>

                                <input
                                    v-model="form.make"
                                    required
                                    class="form-input-dark"
                                    placeholder="Toyota"
                                >

                                <p v-if="form.errors.make" class="mt-2 text-sm text-red-300">
                                    {{ form.errors.make }}
                                </p>
                            </div>

                            <div>
                                <label class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-400">
                                    Model
                                </label>

                                <input
                                    v-model="form.model"
                                    required
                                    class="form-input-dark"
                                    placeholder="Camry"
                                >

                                <p v-if="form.errors.model" class="mt-2 text-sm text-red-300">
                                    {{ form.errors.model }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-5 grid gap-5 md:grid-cols-2">
                            <div>
                                <label class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-400">
                                    Year
                                </label>

                                <input
                                    v-model="form.year"
                                    required
                                    type="number"
                                    min="1900"
                                    class="form-input-dark"
                                    placeholder="2020"
                                >

                                <p v-if="form.errors.year" class="mt-2 text-sm text-red-300">
                                    {{ form.errors.year }}
                                </p>
                            </div>

                            <div>
                                <label class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-400">
                                    Mileage
                                </label>

                                <input
                                    v-model="form.mileage"
                                    required
                                    type="number"
                                    min="0"
                                    class="form-input-dark"
                                    placeholder="45000"
                                >

                                <p v-if="form.errors.mileage" class="mt-2 text-sm text-red-300">
                                    {{ form.errors.mileage }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-5 grid gap-5 md:grid-cols-2">
                            <div>
                                <label class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-400">
                                    Condition
                                </label>

                                <select v-model="form.condition" class="form-select-dark">
                                    <option value="">Select condition</option>
                                    <option value="excellent">Excellent</option>
                                    <option value="good">Good</option>
                                    <option value="fair">Fair</option>
                                    <option value="poor">Poor</option>
                                </select>

                                <p v-if="form.errors.condition" class="mt-2 text-sm text-red-300">
                                    {{ form.errors.condition }}
                                </p>
                            </div>

                            <div>
                                <label class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-400">
                                    VIN
                                </label>

                                <input
                                    v-model="form.vin"
                                    class="form-input-dark"
                                    placeholder="Vehicle Identification Number"
                                >

                                <p v-if="form.errors.vin" class="mt-2 text-sm text-red-300">
                                    {{ form.errors.vin }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-5">
                            <label class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-400">
                                Notes
                            </label>

                            <textarea
                                v-model="form.message"
                                rows="6"
                                class="form-input-dark"
                                placeholder="Tell us about vehicle condition, title status, accident history, service history, or anything else we should know..."
                            />

                            <p v-if="form.errors.message" class="mt-2 text-sm text-red-300">
                                {{ form.errors.message }}
                            </p>
                        </div>

                        <div
                            class="mt-6 flex flex-col gap-4 border-t border-white/10 pt-6 md:flex-row md:items-center md:justify-between">
                            <p class="max-w-xl text-xs leading-5 text-slate-500">
                                This request is not a final offer. Final trade-in value depends on inspection, vehicle
                                history, title status, market conditions, and purchase agreement.
                            </p>

                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="btn-primary md:min-w-56 disabled:opacity-60"
                            >
                                Submit Trade-In
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section class="site-section-tight border-y border-white/10 bg-white/[0.025]">
        <div class="site-container">
            <div class="grid gap-8 lg:grid-cols-[1fr_auto] lg:items-center">
                <div>
                    <p class="eyebrow">
                        Upgrade Your Vehicle
                    </p>

                    <h2 class="mt-3 heading-lg">
                        Apply your trade-in toward current inventory.
                    </h2>

                    <p class="mt-5 max-w-3xl body-muted">
                        Browse available vehicles and contact our team to discuss purchase, finance, delivery, and
                        trade-in options together.
                    </p>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row">
                    <Link href="/inventory" class="btn-primary">
                        Browse Inventory
                    </Link>

                    <Link href="/finance" class="btn-secondary">
                        Finance Options
                    </Link>
                </div>
            </div>
        </div>
    </section>
</template>
