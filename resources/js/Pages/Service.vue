<script setup>
import {Link, usePage} from '@inertiajs/vue3';
import {computed} from 'vue';
import SeoHead from '@/Components/SeoHead.vue';
import SiteLayout from '@/Layouts/SiteLayout.vue';

defineOptions({layout: SiteLayout});

const page = usePage();
const site = computed(() => page.props.site || {});

const serviceItems = [
    {number: '01', title: 'Maintenance questions', text: 'Call our team to discuss current service availability and the needs of your vehicle.'},
    {number: '02', title: 'Vehicle inspections', text: 'Ask what inspection and preparation information is available for a vehicle in our inventory.'},
    {number: '03', title: 'After-sale support', text: 'Already purchased from us? Contact the dealership and we will help you understand the next step.'},
];
</script>

<template>
    <SeoHead title="Automotive Service" description="Contact Cars For Less Sales & Service in East Granby, CT for current automotive service availability and support." />

    <section class="bg-[#171717] text-white">
        <div class="site-container grid min-h-[560px] items-end gap-12 py-20 lg:grid-cols-[1.1fr_0.9fr] lg:py-28">
            <div>
                <p class="eyebrow !text-[#ff5a45]">Sales &amp; Service</p>
                <h1 class="mt-7 max-w-3xl text-6xl font-black leading-[0.86] tracking-[-0.07em] sm:text-7xl lg:text-8xl">Help for the road ahead.</h1>
            </div>
            <div class="border-l border-white/20 pl-7">
                <p class="max-w-lg text-lg leading-8 text-stone-300">Service availability may vary. Speak directly with our East Granby team before visiting so we can understand what your vehicle needs.</p>
                <a :href="`tel:${site.phone_tel}`" class="mt-8 inline-flex rounded-full bg-[#ff4f38] px-7 py-4 text-xs font-black uppercase tracking-wide text-white">Call about service</a>
            </div>
        </div>
    </section>

    <section class="site-section bg-[#f5f3ee]">
        <div class="site-container grid gap-12 lg:grid-cols-[0.7fr_1.3fr]">
            <div>
                <p class="eyebrow">Start with a conversation</p>
                <h2 class="mt-5 heading-lg">Tell us what is going on.</h2>
            </div>
            <div class="divide-y divide-black/15 border-y border-black/15">
                <article v-for="item in serviceItems" :key="item.number" class="grid gap-4 py-8 sm:grid-cols-[64px_1fr]">
                    <span class="text-xs font-black text-[#e9422c]">{{ item.number }}</span>
                    <div><h3 class="text-2xl font-black tracking-[-0.035em]">{{ item.title }}</h3><p class="mt-3 max-w-xl text-sm leading-7 text-stone-600">{{ item.text }}</p></div>
                </article>
            </div>
        </div>
    </section>

    <section class="bg-white py-16">
        <div class="site-container flex flex-col gap-7 md:flex-row md:items-center md:justify-between">
            <div><p class="text-xs font-black uppercase tracking-[0.2em] text-[#e9422c]">Looking for a vehicle?</p><h2 class="mt-3 text-3xl font-black tracking-[-0.04em]">See what is available today.</h2></div>
            <Link href="/inventory" class="btn-primary">Browse inventory</Link>
        </div>
    </section>
</template>
