<script setup>
import {Link, usePage} from '@inertiajs/vue3';
import {ref} from 'vue';

const page = usePage();
const mobileMenuOpen = ref(false);

const navigation = [
    {label: 'Inventory', href: '/inventory'},
    {label: 'Finance', href: '/finance'},
    {label: 'Trade-In', href: '/trade-in'},
    {label: 'Delivery', href: '/delivery'},
    {label: 'Warranty', href: '/warranty-return'},
    {label: 'About', href: '/about'},
    {label: 'Contact', href: '/contact'},
];

const isActive = (href) => {
    return page.url === href || page.url.startsWith(`${href}/`);
};
</script>

<template>
    <div class="min-h-screen bg-[#0b0f14] text-white">
        <div class="border-b border-white/10 bg-[#080b0f]">
            <div
                class="site-container flex flex-col gap-2 py-3 text-xs text-slate-400 md:flex-row md:items-center md:justify-between">
                <p>Mon–Fri 9:00 AM – 5:00 PM</p>

                <div class="flex flex-wrap gap-x-6 gap-y-2">
                    <a href="tel:+10000000000" class="hover:text-white">
                        +1 (000) 000-0000
                    </a>

                    <a href="mailto:sales@example.com" class="hover:text-white">
                        sales@example.com
                    </a>

                    <span>Enclosed delivery available</span>
                </div>
            </div>
        </div>

        <header class="sticky top-0 z-50 border-b border-white/10 bg-[#0b0f14]/95 backdrop-blur">
            <div class="site-container flex items-center justify-between py-5">
                <Link href="/" class="group flex items-center gap-4">
                    <span
                        class="flex h-11 w-11 items-center justify-center rounded-xl border border-amber-300/40 bg-amber-300 font-black text-neutral-950">
                        AD
                    </span>

                    <span>
                        <span class="block text-sm font-black uppercase tracking-[0.28em]">
                            Auto Dealer
                        </span>
                        <span class="block text-xs text-slate-500">
                            Premium vehicle inventory
                        </span>
                    </span>
                </Link>

                <nav class="hidden items-center gap-1 xl:flex">
                    <Link
                        v-for="item in navigation"
                        :key="item.href"
                        :href="item.href"
                        class="rounded-lg px-3 py-2 text-xs font-bold uppercase tracking-wide transition"
                        :class="isActive(item.href) ? 'bg-white/10 text-amber-300' : 'text-slate-300 hover:bg-white/5 hover:text-white'"
                    >
                        {{ item.label }}
                    </Link>
                </nav>

                <div class="hidden items-center gap-3 xl:flex">
                    <Link href="/inventory" class="btn-secondary">
                        View Inventory
                    </Link>

                    <Link href="/contact" class="btn-primary">
                        Contact Sales
                    </Link>
                </div>

                <button
                    type="button"
                    class="rounded-xl border border-white/10 px-4 py-2 text-sm font-bold xl:hidden"
                    @click="mobileMenuOpen = !mobileMenuOpen"
                >
                    Menu
                </button>
            </div>

            <div v-if="mobileMenuOpen" class="border-t border-white/10 xl:hidden">
                <div class="site-container py-4">
                    <nav class="grid gap-2 sm:grid-cols-2">
                        <Link
                            v-for="item in navigation"
                            :key="item.href"
                            :href="item.href"
                            class="rounded-xl border border-white/10 px-4 py-3 text-sm font-bold"
                            :class="isActive(item.href) ? 'bg-white/10 text-amber-300' : 'text-slate-300'"
                            @click="mobileMenuOpen = false"
                        >
                            {{ item.label }}
                        </Link>
                    </nav>
                </div>
            </div>
        </header>

        <div
            v-if="page.props.flash?.success"
            class="site-container mt-6"
        >
            <div class="rounded-xl border border-emerald-400/30 bg-emerald-400/10 px-5 py-4 text-sm text-emerald-100">
                {{ page.props.flash.success }}
            </div>
        </div>

        <div
            v-if="page.props.flash?.error"
            class="site-container mt-6"
        >
            <div class="rounded-xl border border-red-400/30 bg-red-400/10 px-5 py-4 text-sm text-red-100">
                {{ page.props.flash.error }}
            </div>
        </div>

        <main>
            <slot/>
        </main>

        <footer class="border-t border-white/10 bg-[#080b0f]">
            <div class="site-container grid gap-10 py-12 lg:grid-cols-[1.4fr_0.8fr_0.8fr_0.8fr]">
                <div>
                    <div class="flex items-center gap-4">
                        <span
                            class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-300 font-black text-neutral-950">
                            AD
                        </span>

                        <div>
                            <p class="text-sm font-black uppercase tracking-[0.28em]">
                                Auto Dealer
                            </p>
                            <p class="text-xs text-slate-500">
                                Premium vehicle inventory
                            </p>
                        </div>
                    </div>

                    <p class="mt-5 max-w-md text-sm leading-6 text-slate-400">
                        Browse inspected vehicles, request information, and contact our sales team for delivery,
                        warranty, finance, and trade-in options.
                    </p>
                </div>

                <div>
                    <h3 class="text-sm font-black uppercase tracking-wide">
                        Inventory
                    </h3>

                    <div class="mt-4 flex flex-col gap-2 text-sm text-slate-400">
                        <Link href="/inventory" class="hover:text-white">Vehicles</Link>
                        <Link href="/finance" class="hover:text-white">Finance</Link>
                        <Link href="/trade-in" class="hover:text-white">Trade-In</Link>
                    </div>
                </div>

                <div>
                    <h3 class="text-sm font-black uppercase tracking-wide">
                        Company
                    </h3>

                    <div class="mt-4 flex flex-col gap-2 text-sm text-slate-400">
                        <Link href="/about" class="hover:text-white">About</Link>
                        <Link href="/delivery" class="hover:text-white">Delivery</Link>
                        <Link href="/warranty-return" class="hover:text-white">Warranty</Link>
                        <Link href="/contact" class="hover:text-white">Contact</Link>
                    </div>
                </div>

                <div>
                    <h3 class="text-sm font-black uppercase tracking-wide">
                        Legal
                    </h3>

                    <div class="mt-4 flex flex-col gap-2 text-sm text-slate-400">
                        <Link href="/privacy-policy" class="hover:text-white">Privacy Policy</Link>
                        <Link href="/terms" class="hover:text-white">Terms</Link>
                    </div>
                </div>
            </div>

            <div class="border-t border-white/10">
                <div
                    class="site-container flex flex-col gap-3 py-5 text-xs text-slate-500 md:flex-row md:items-center md:justify-between">
                    <p>© {{ new Date().getFullYear() }} Auto Dealer. All rights reserved.</p>
                    <p>Vehicle availability, pricing, mileage, and terms are subject to confirmation.</p>
                </div>
            </div>
        </footer>
    </div>
</template>
