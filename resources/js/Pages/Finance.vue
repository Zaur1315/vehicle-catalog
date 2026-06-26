<script setup>
import {Link, useForm} from '@inertiajs/vue3';
import SeoHead from '@/Components/SeoHead.vue';
import {computed} from 'vue';
import SiteLayout from '@/Layouts/SiteLayout.vue';

defineOptions({
    layout: SiteLayout,
});

const form = useForm({
    form_type: 'finance',
    first_name: '',
    last_name: '',
    email: '',
    phone: '',
    vehicle_interest: '',
    amount: '',
    down_payment: '',
    term_months: '',
    credit_score_range: '',
    message: '',
});

const estimatedMonthlyPayment = computed(() => {
    const amount = Number(form.amount || 0);
    const downPayment = Number(form.down_payment || 0);
    const termMonths = Number(form.term_months || 0);

    if (amount <= 0 || termMonths <= 0) {
        return null;
    }

    const principal = Math.max(amount - downPayment, 0);

    if (principal <= 0) {
        return '$0';
    }

    const estimatedApr = 0.089;
    const monthlyRate = estimatedApr / 12;

    const payment = principal * (monthlyRate * ((1 + monthlyRate) ** termMonths)) / (((1 + monthlyRate) ** termMonths) - 1);

    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        maximumFractionDigits: 0,
    }).format(payment);
});

const submit = () => {
    form.post('/finance', {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <SeoHead
        title="Finance"
        description="Submit a vehicle finance request and learn about estimated payments, down payment, term options, and next steps."
    />
    <section class="border-b border-white/10 bg-[#080b0f]">
        <div class="site-container py-10">
            <div class="grid gap-8 lg:grid-cols-[1fr_460px] lg:items-end">
                <div>
                    <p class="eyebrow">
                        Finance
                    </p>

                    <h1 class="mt-3 heading-lg">
                        Vehicle financing with clear next steps.
                    </h1>

                    <p class="mt-5 max-w-3xl body-muted">
                        Submit a preliminary finance request and our team will contact you to discuss available
                        options, required documents, estimated terms, and next steps.
                    </p>
                </div>

                <div class="border border-white/10 bg-white/[0.035] p-5">
                    <p class="text-xs font-black uppercase tracking-[0.24em] text-slate-500">
                        Finance Request
                    </p>

                    <p class="mt-2 text-4xl font-black text-amber-300">
                        Fast
                    </p>

                    <p class="mt-1 text-sm text-slate-400">
                        preliminary review by the sales team
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
                            Payment Estimate
                        </p>

                        <h2 class="mt-3 text-3xl font-black">
                            Estimate your monthly payment.
                        </h2>

                        <p class="mt-4 text-sm leading-6 text-slate-400">
                            This is only a rough estimate. Final payment depends on approved APR, term, credit profile,
                            taxes, fees, vehicle price, down payment, and lender approval.
                        </p>

                        <div class="mt-6 border border-white/10 bg-[#080b0f] p-5">
                            <p class="text-xs font-black uppercase tracking-[0.24em] text-slate-500">
                                Estimated Monthly Payment
                            </p>

                            <p class="mt-3 text-4xl font-black text-amber-300">
                                {{ estimatedMonthlyPayment || '—' }}
                            </p>

                            <p class="mt-3 text-xs leading-5 text-slate-500">
                                Estimate uses a sample APR for display only. This is not a credit offer.
                            </p>
                        </div>
                    </div>

                    <div class="dealer-panel rounded-2xl">
                        <div class="border-b border-white/10 px-6 py-5">
                            <p class="text-xs font-black uppercase tracking-[0.24em] text-slate-500">
                                Finance Checklist
                            </p>
                        </div>

                        <div class="divide-y divide-white/10">
                            <div class="px-6 py-5">
                                <h3 class="font-black">
                                    Vehicle information
                                </h3>

                                <p class="mt-2 text-sm leading-6 text-slate-400">
                                    Tell us which vehicle you are interested in or provide a stock number.
                                </p>
                            </div>

                            <div class="px-6 py-5">
                                <h3 class="font-black">
                                    Contact details
                                </h3>

                                <p class="mt-2 text-sm leading-6 text-slate-400">
                                    A valid phone number helps our team confirm the request faster.
                                </p>
                            </div>

                            <div class="px-6 py-5">
                                <h3 class="font-black">
                                    Down payment and term
                                </h3>

                                <p class="mt-2 text-sm leading-6 text-slate-400">
                                    Add an estimated down payment and preferred loan term if you already know them.
                                </p>
                            </div>

                            <div class="px-6 py-5">
                                <h3 class="font-black">
                                    Final approval
                                </h3>

                                <p class="mt-2 text-sm leading-6 text-slate-400">
                                    Final financing depends on lender review and complete documentation.
                                </p>
                            </div>
                        </div>
                    </div>
                </aside>

                <div class="dealer-panel rounded-2xl">
                    <div class="border-b border-white/10 px-6 py-5">
                        <p class="text-xs font-black uppercase tracking-[0.24em] text-slate-500">
                            Application
                        </p>

                        <h2 class="mt-2 text-3xl font-black">
                            Request finance information
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
                                Vehicle Interest
                            </label>

                            <input
                                v-model="form.vehicle_interest"
                                class="form-input-dark"
                                placeholder="Example: 2021 Toyota Camry SE or stock number"
                            >

                            <p v-if="form.errors.vehicle_interest" class="mt-2 text-sm text-red-300">
                                {{ form.errors.vehicle_interest }}
                            </p>
                        </div>

                        <div class="mt-5 grid gap-5 md:grid-cols-3">
                            <div>
                                <label class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-400">
                                    Vehicle Amount
                                </label>

                                <input
                                    v-model="form.amount"
                                    type="number"
                                    min="0"
                                    class="form-input-dark"
                                    placeholder="35000"
                                >

                                <p v-if="form.errors.amount" class="mt-2 text-sm text-red-300">
                                    {{ form.errors.amount }}
                                </p>
                            </div>

                            <div>
                                <label class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-400">
                                    Down Payment
                                </label>

                                <input
                                    v-model="form.down_payment"
                                    type="number"
                                    min="0"
                                    class="form-input-dark"
                                    placeholder="5000"
                                >

                                <p v-if="form.errors.down_payment" class="mt-2 text-sm text-red-300">
                                    {{ form.errors.down_payment }}
                                </p>
                            </div>

                            <div>
                                <label class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-400">
                                    Term
                                </label>

                                <select v-model="form.term_months" class="form-select-dark">
                                    <option value="">Select term</option>
                                    <option value="24">24 months</option>
                                    <option value="36">36 months</option>
                                    <option value="48">48 months</option>
                                    <option value="60">60 months</option>
                                    <option value="72">72 months</option>
                                    <option value="84">84 months</option>
                                </select>

                                <p v-if="form.errors.term_months" class="mt-2 text-sm text-red-300">
                                    {{ form.errors.term_months }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-5">
                            <label class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-400">
                                Credit Score Range
                            </label>

                            <select v-model="form.credit_score_range" class="form-select-dark">
                                <option value="">Select range</option>
                                <option value="excellent">Excellent</option>
                                <option value="good">Good</option>
                                <option value="fair">Fair</option>
                                <option value="poor">Poor</option>
                                <option value="unknown">Not sure</option>
                            </select>

                            <p v-if="form.errors.credit_score_range" class="mt-2 text-sm text-red-300">
                                {{ form.errors.credit_score_range }}
                            </p>
                        </div>

                        <div class="mt-5">
                            <label class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-400">
                                Message
                            </label>

                            <textarea
                                v-model="form.message"
                                rows="6"
                                class="form-input-dark"
                                placeholder="Tell us about your financing questions..."
                            />

                            <p v-if="form.errors.message" class="mt-2 text-sm text-red-300">
                                {{ form.errors.message }}
                            </p>
                        </div>

                        <div
                            class="mt-6 flex flex-col gap-4 border-t border-white/10 pt-6 md:flex-row md:items-center md:justify-between">
                            <p class="max-w-xl text-xs leading-5 text-slate-500">
                                This form is not a credit application or approval. Final terms depend on lender review,
                                documentation, taxes, fees, vehicle details, and buyer qualification.
                            </p>

                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="btn-primary md:min-w-56 disabled:opacity-60"
                            >
                                Submit Request
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
                        Inventory First
                    </p>

                    <h2 class="mt-3 heading-lg">
                        Finance a specific vehicle from current inventory.
                    </h2>

                    <p class="mt-5 max-w-3xl body-muted">
                        You can browse current vehicles first, then submit an inquiry from the vehicle page.
                    </p>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row">
                    <Link href="/inventory" class="btn-primary">
                        Browse Inventory
                    </Link>

                    <Link href="/trade-in" class="btn-secondary">
                        Trade-In Request
                    </Link>
                </div>
            </div>
        </div>
    </section>
</template>
