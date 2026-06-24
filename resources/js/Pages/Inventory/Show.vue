<script setup>
import {useForm} from '@inertiajs/vue3';

const props = defineProps({
    vehicle: {
        type: Object,
        required: true,
    },
    relatedVehicles: {
        type: Array,
        default: () => [],
    },
});

const form = useForm({
    first_name: '',
    last_name: '',
    email: '',
    phone: '',
    preferred_contact_time: '',
    message: '',
});

const submit = () => {
    form.post(`/inventory/${props.vehicle.slug}/inquiry`, {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <main class="min-h-screen bg-neutral-950 px-6 py-12 text-white">
        <section class="mx-auto grid max-w-7xl gap-10 lg:grid-cols-[1.3fr_0.7fr]">
            <div>
                <a href="/inventory" class="text-sm text-neutral-300 hover:text-white">
                    ← Back to inventory
                </a>

                <img
                    :src="vehicle.main_image"
                    :alt="vehicle.name"
                    class="mt-8 h-[520px] w-full rounded-3xl object-cover"
                >

                <div v-if="vehicle.images.length" class="mt-4 grid grid-cols-4 gap-3">
                    <img
                        v-for="image in vehicle.images"
                        :key="image.url"
                        :src="image.url"
                        :alt="image.alt || vehicle.name"
                        class="h-28 rounded-2xl object-cover"
                    >
                </div>
            </div>

            <aside class="rounded-3xl border border-white/10 bg-white/5 p-6">
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-amber-300">
                    {{ vehicle.year }} {{ vehicle.make }} {{ vehicle.model }}
                </p>

                <h1 class="mt-3 text-4xl font-bold">
                    {{ vehicle.name }}
                </h1>

                <p class="mt-4 text-3xl font-bold text-amber-300">
                    {{ vehicle.price }}
                </p>

                <dl class="mt-8 grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <dt class="text-neutral-400">Mileage</dt>
                        <dd>{{ vehicle.mileage }}</dd>
                    </div>
                    <div>
                        <dt class="text-neutral-400">VIN</dt>
                        <dd>{{ vehicle.vin || '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-neutral-400">Body</dt>
                        <dd>{{ vehicle.body_type || '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-neutral-400">Transmission</dt>
                        <dd>{{ vehicle.transmission || '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-neutral-400">Drivetrain</dt>
                        <dd>{{ vehicle.drivetrain || '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-neutral-400">Engine</dt>
                        <dd>{{ vehicle.engine || '-' }}</dd>
                    </div>
                </dl>

                <form class="mt-8 space-y-4" @submit.prevent="submit">
                    <h2 class="text-xl font-semibold">
                        Request Information
                    </h2>

                    <div class="grid grid-cols-2 gap-3">
                        <input v-model="form.first_name" required placeholder="First name"
                               class="rounded-xl border-white/10 bg-white/10 px-4 py-3">
                        <input v-model="form.last_name" placeholder="Last name"
                               class="rounded-xl border-white/10 bg-white/10 px-4 py-3">
                    </div>

                    <input v-model="form.phone" required placeholder="Phone"
                           class="w-full rounded-xl border-white/10 bg-white/10 px-4 py-3">
                    <input v-model="form.email" type="email" placeholder="Email"
                           class="w-full rounded-xl border-white/10 bg-white/10 px-4 py-3">
                    <input v-model="form.preferred_contact_time" placeholder="Preferred contact time"
                           class="w-full rounded-xl border-white/10 bg-white/10 px-4 py-3">
                    <textarea v-model="form.message" placeholder="Message" rows="4"
                              class="w-full rounded-xl border-white/10 bg-white/10 px-4 py-3"/>

                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full rounded-full bg-amber-300 px-6 py-3 font-semibold text-neutral-950 hover:bg-amber-200 disabled:opacity-60"
                    >
                        Send Request
                    </button>
                </form>
            </aside>
        </section>
    </main>
</template>
