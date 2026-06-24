<script setup>
import {useForm} from '@inertiajs/vue3';

const form = useForm({
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

const submit = () => {
    form.post('/finance', {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <main class="min-h-screen bg-neutral-950 px-6 py-12 text-white">
        <section class="mx-auto grid max-w-6xl gap-10 lg:grid-cols-2">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-amber-300">
                    Finance
                </p>

                <h1 class="mt-3 text-5xl font-bold">
                    Apply for vehicle financing
                </h1>

                <p class="mt-6 text-neutral-300">
                    Submit a preliminary financing request and our team will contact you with available options.
                </p>

                <div class="mt-8 rounded-3xl border border-white/10 bg-white/5 p-6">
                    <h2 class="text-xl font-semibold">
                        Monthly payment estimate
                    </h2>

                    <p class="mt-3 text-neutral-300">
                        A full payment calculator will be added during the frontend design stage.
                    </p>
                </div>
            </div>

            <form class="rounded-3xl border border-white/10 bg-white/5 p-6" @submit.prevent="submit">
                <div class="grid grid-cols-2 gap-4">
                    <input v-model="form.first_name" required placeholder="First name"
                           class="rounded-xl border-white/10 bg-white/10 px-4 py-3">
                    <input v-model="form.last_name" placeholder="Last name"
                           class="rounded-xl border-white/10 bg-white/10 px-4 py-3">
                </div>

                <input v-model="form.phone" required placeholder="Phone"
                       class="mt-4 w-full rounded-xl border-white/10 bg-white/10 px-4 py-3">
                <input v-model="form.email" type="email" placeholder="Email"
                       class="mt-4 w-full rounded-xl border-white/10 bg-white/10 px-4 py-3">

                <input v-model="form.vehicle_interest" placeholder="Vehicle interest"
                       class="mt-4 w-full rounded-xl border-white/10 bg-white/10 px-4 py-3">

                <div class="mt-4 grid grid-cols-3 gap-4">
                    <input v-model="form.amount" type="number" min="0" placeholder="Amount"
                           class="rounded-xl border-white/10 bg-white/10 px-4 py-3">
                    <input v-model="form.down_payment" type="number" min="0" placeholder="Down payment"
                           class="rounded-xl border-white/10 bg-white/10 px-4 py-3">
                    <input v-model="form.term_months" type="number" min="12" max="96" placeholder="Term months"
                           class="rounded-xl border-white/10 bg-white/10 px-4 py-3">
                </div>

                <select v-model="form.credit_score_range"
                        class="mt-4 w-full rounded-xl border-white/10 bg-white/10 px-4 py-3">
                    <option value="">Credit score range</option>
                    <option value="excellent">Excellent</option>
                    <option value="good">Good</option>
                    <option value="fair">Fair</option>
                    <option value="poor">Poor</option>
                    <option value="unknown">Not sure</option>
                </select>

                <textarea v-model="form.message" placeholder="Message" rows="5"
                          class="mt-4 w-full rounded-xl border-white/10 bg-white/10 px-4 py-3"/>

                <button
                    type="submit"
                    :disabled="form.processing"
                    class="mt-6 w-full rounded-full bg-amber-300 px-6 py-3 font-semibold text-neutral-950 hover:bg-amber-200 disabled:opacity-60"
                >
                    Submit Finance Request
                </button>
            </form>
        </section>
    </main>
</template>
