<script setup>
defineProps({
    featuredVehicles: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <main class="min-h-screen bg-neutral-950 text-white">
        <section class="mx-auto max-w-7xl px-6 py-24">
            <p class="mb-4 text-sm font-semibold uppercase tracking-[0.3em] text-amber-300">
                Auto Dealer Catalog
            </p>

            <h1 class="max-w-4xl text-5xl font-bold tracking-tight md:text-7xl">
                Find your next vehicle with confidence.
            </h1>

            <p class="mt-6 max-w-2xl text-lg text-neutral-300">
                Browse inspected vehicles, request information, and contact our sales team for delivery, warranty, and
                financing details.
            </p>

            <div class="mt-10 flex flex-wrap gap-4">
                <a
                    href="/inventory"
                    class="rounded-full bg-amber-300 px-6 py-3 font-semibold text-neutral-950 transition hover:bg-amber-200"
                >
                    View Inventory
                </a>

                <a
                    href="/contact"
                    class="rounded-full border border-white/20 px-6 py-3 font-semibold text-white transition hover:bg-white/10"
                >
                    Contact Us
                </a>
            </div>
        </section>
    </main>
</template>
