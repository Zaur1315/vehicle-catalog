<script setup>
import {useForm} from '@inertiajs/vue3';

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
</script>

<template>
    <main class="min-h-screen bg-neutral-950 px-6 py-12 text-white">
        <section class="mx-auto grid max-w-6xl gap-10 lg:grid-cols-2">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-amber-300">
                    Trade-In
                </p>

                <h1 class="mt-3 text-5xl font-bold">
                    Get an estimate for your trade-in
                </h1>

                <p class="mt-6 text-neutral-300">
                    Tell us about your current vehicle and our team will contact you with the next steps.
                </p>
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

                <div class="mt-4 grid grid-cols-2 gap-4">
                    <input v-model="form.make" required placeholder="Vehicle make"
                           class="rounded-xl border-white/10 bg-white/10 px-4 py-3">
                    <input v-model="form.model" required placeholder="Vehicle model"
                           class="rounded-xl border-white/10 bg-white/10 px-4 py-3">
                </div>

                <div class="mt-4 grid grid-cols-2 gap-4">
                    <input v-model="form.year" required type="number" min="1900" placeholder="Year"
                           class="rounded-xl border-white/10 bg-white/10 px-4 py-3">
                    <input v-model="form.mileage" required type="number" min="0" placeholder="Mileage"
                           class="rounded-xl border-white/10 bg-white/10 px-4 py-3">
                </div>

                <select v-model="form.condition" class="mt-4 w-full rounded-xl border-white/10 bg-white/10 px-4 py-3">
                    <option value="">Condition</option>
                    <option value="excellent">Excellent</option>
                    <option value="good">Good</option>
                    <option value="fair">Fair</option>
                    <option value="poor">Poor</option>
                </select>

                <input v-model="form.vin" placeholder="VIN"
                       class="mt-4 w-full rounded-xl border-white/10 bg-white/10 px-4 py-3">

                <textarea v-model="form.message" placeholder="Message" rows="5"
                          class="mt-4 w-full rounded-xl border-white/10 bg-white/10 px-4 py-3"/>

                <button
                    type="submit"
                    :disabled="form.processing"
                    class="mt-6 w-full rounded-full bg-amber-300 px-6 py-3 font-semibold text-neutral-950 hover:bg-amber-200 disabled:opacity-60"
                >
                    Submit Trade-In Request
                </button>
            </form>
        </section>
    </main>
</template>
