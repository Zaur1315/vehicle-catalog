<template>
    <section class="site-section">
        <div class="site-container">
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-amber-300">
                About Us
            </p>

            <h1 class="mt-3 text-5xl font-bold">
                A dealership built on trust, service, and quality inventory.
            </h1>

            <p class="mt-6 max-w-3xl text-lg text-neutral-300">
                We help customers find inspected vehicles with clear information, straightforward communication,
                delivery support, warranty coverage, and a customer-first buying experience.
            </p>

            <div class="mt-10 grid gap-6 md:grid-cols-3">
                <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
                    <p class="text-4xl font-bold text-amber-300">500+</p>
                    <p class="mt-2 text-neutral-300">Vehicles sold</p>
                </div>

                <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
                    <p class="text-4xl font-bold text-amber-300">7+</p>
                    <p class="mt-2 text-neutral-300">Years in business</p>
                </div>

                <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
                    <p class="text-4xl font-bold text-amber-300">98%</p>
                    <p class="mt-2 text-neutral-300">Customer satisfaction</p>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import SiteLayout from '@/Layouts/SiteLayout.vue';

defineOptions({
    layout: SiteLayout,
});
</script>
