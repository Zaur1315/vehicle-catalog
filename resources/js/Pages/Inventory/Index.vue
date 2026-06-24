<script setup>
defineProps({
    vehicles: {
        type: Object,
        required: true,
    },
    filters: {
        type: Object,
        default: () => ({}),
    },
    filterOptions: {
        type: Object,
        default: () => ({}),
    },
});
</script>

<template>
    <main class="min-h-screen bg-neutral-950 px-6 py-12 text-white">
        <section class="mx-auto max-w-7xl">
            <div class="mb-10 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.3em] text-amber-300">
                        Inventory
                    </p>
                    <h1 class="mt-3 text-4xl font-bold">
                        Vehicles for Sale
                    </h1>
                </div>

                <a href="/" class="text-sm text-neutral-300 hover:text-white">
                    Back home
                </a>
            </div>

            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                <article
                    v-for="vehicle in vehicles.data"
                    :key="vehicle.id"
                    class="overflow-hidden rounded-3xl border border-white/10 bg-white/5"
                >
                    <img
                        :src="vehicle.image"
                        :alt="vehicle.name"
                        class="h-56 w-full object-cover"
                    >

                    <div class="p-6">
                        <p class="text-sm text-neutral-400">
                            {{ vehicle.year }} · {{ vehicle.make }} {{ vehicle.model }}
                        </p>

                        <h2 class="mt-2 text-xl font-semibold">
                            {{ vehicle.name }}
                        </h2>

                        <div class="mt-4 flex items-center justify-between">
                            <span class="text-lg font-bold text-amber-300">
                                {{ vehicle.price }}
                            </span>

                            <span class="text-sm text-neutral-300">
                                {{ vehicle.mileage }}
                            </span>
                        </div>

                        <a
                            :href="`/inventory/${vehicle.slug}`"
                            class="mt-6 inline-flex rounded-full bg-amber-300 px-5 py-2 text-sm font-semibold text-neutral-950 hover:bg-amber-200"
                        >
                            View Details
                        </a>
                    </div>
                </article>
            </div>
        </section>
    </main>
</template>
