<script setup>
import {useForm} from '@inertiajs/vue3';

const form = useForm({
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
</script>

<template>
    <main class="min-h-screen bg-neutral-950 px-6 py-12 text-white">
        <section class="mx-auto grid max-w-6xl gap-10 lg:grid-cols-2">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-amber-300">
                    Contact
                </p>

                <h1 class="mt-3 text-5xl font-bold">
                    Contact our sales team
                </h1>

                <p class="mt-6 text-neutral-300">
                    Send us a message and we will contact you about availability, delivery, warranty, financing, or
                    trade-in options.
                </p>

                <div class="mt-8 space-y-3 text-neutral-300">
                    <p>Phone: <a href="tel:+10000000000" class="text-white">+1 (000) 000-0000</a></p>
                    <p>Email: <a href="mailto:sales@example.com" class="text-white">sales@example.com</a></p>
                    <p>Hours: Mon–Fri, 9:00 AM – 5:00 PM</p>
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
                <input v-model="form.subject" placeholder="Subject"
                       class="mt-4 w-full rounded-xl border-white/10 bg-white/10 px-4 py-3">
                <textarea v-model="form.message" placeholder="Message" rows="5"
                          class="mt-4 w-full rounded-xl border-white/10 bg-white/10 px-4 py-3"/>

                <button
                    type="submit"
                    :disabled="form.processing"
                    class="mt-6 w-full rounded-full bg-amber-300 px-6 py-3 font-semibold text-neutral-950 hover:bg-amber-200 disabled:opacity-60"
                >
                    Send Message
                </button>
            </form>
        </section>
    </main>
</template>
