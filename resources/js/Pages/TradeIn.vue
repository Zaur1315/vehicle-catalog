<script setup>
import { Link } from '@inertiajs/vue3';
import BrandImage from '@/Components/BrandImage.vue';
import FaqAccordion from '@/Components/FaqAccordion.vue';
import Icon from '@/Components/Icon.vue';
import TradeInForm from '@/Components/TradeInForm.vue';
import SeoHead from '@/Components/SeoHead.vue';
import SiteLayout from '@/Layouts/SiteLayout.vue';

defineOptions({ layout: SiteLayout });
const steps = [
    ['Tell us about your vehicle', 'Start with its year, make, model, mileage, and your contact information.'],
    ['Share the useful details', 'Describe its condition and history, and include the VIN if you have it nearby.'],
    ['Let our team review it', 'Southern York Motors will review what you send and follow up for any missing context.'],
    ['Discuss the next step', 'Continue the conversation around a vehicle in our inventory and a possible trade.'],
];
const valueFactors = [
    ['Vehicle basics', 'Make, model, model year, trim, and equipment help identify the vehicle accurately.'],
    ['Mileage and condition', 'Odometer mileage and the vehicle’s mechanical, interior, and exterior condition matter.'],
    ['History and ownership', 'Reported damage, maintenance context, title status, and an existing loan may affect the discussion.'],
    ['Current market', 'Availability and demand for similar vehicles can change over time.'],
];
const faqs = [
    ['Do I need to choose my next vehicle first?', 'No. You can submit the vehicle details while you browse. The current site workflow is intended to begin a possible trade-in conversation connected with your next purchase.'],
    ['What information should I provide?', 'Year, make, model, mileage, condition, and contact details are the best starting point. A VIN and additional notes are helpful when available.'],
    ['Can I submit a vehicle with an existing loan?', 'You may tell us that a loan exists in the notes. Our team will need more information before discussing how it could affect a possible transaction.'],
    ['Is the online submission a final value or offer?', 'No. The form does not produce an estimate, appraisal, or offer. Vehicle information and actual condition must be reviewed before any value can be discussed.'],
    ['What happens after I submit?', 'Southern York Motors receives the request and can contact you about the vehicle, missing details, and possible next steps.'],
];
</script>

<template>
    <SeoHead
        title="Sell or Trade"
        description="Tell Southern York Motors about the vehicle you may want to trade toward your next purchase in New Freedom, Pennsylvania."
        image="/images/southern-york/trade-1280.webp"
    />
    <section class="site-container split-intro">
        <div class="split-intro-media lg:order-1">
            <BrandImage name="trade" alt="A car key with a silver sedan softly in the background" eager />
        </div>
        <div class="lg:order-2">
            <p class="eyebrow">Sell or trade</p>
            <h1>Sell or trade your current vehicle.</h1>
            <p>
                Share a few useful details about what you drive today. Our
                current online process is designed to begin a possible trade-in
                discussion as you consider your next vehicle.
            </p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="#vehicle-request" class="btn-primary">Tell Us About Your Vehicle</a>
                <Link href="/inventory" class="btn-secondary">Browse Inventory</Link>
            </div>
        </div>
    </section>

    <section class="site-section bg-white">
        <div class="site-container">
            <div class="process-heading">
                <div>
                    <p class="eyebrow">How it works</p>
                    <h2 class="heading-lg">A straightforward trade process.</h2>
                </div>
                <p>The form collects the starting details. It does not create an instant valuation, final appraisal, or purchase offer.</p>
            </div>
            <ol class="numbered-process mt-10">
                <li v-for="step in steps" :key="step[0]">
                    <span aria-hidden="true"></span>
                    <h3>{{ step[0] }}</h3>
                    <p>{{ step[1] }}</p>
                </li>
            </ol>
        </div>
    </section>

    <section class="site-section site-container">
        <div class="section-header">
            <div><p class="eyebrow">Understanding value</p><h2 class="heading-lg">What can affect vehicle value.</h2></div>
            <p class="body-muted max-w-md">Online details help start the review. Actual condition and supporting information are still needed before value can be discussed with confidence.</p>
        </div>
        <div class="factor-grid">
            <article v-for="item in valueFactors" :key="item[0]">
                <Icon name="arrow-right" /><h3>{{ item[0] }}</h3><p>{{ item[1] }}</p>
            </article>
        </div>
    </section>

    <section class="home-principles">
        <div class="site-container grid gap-12 lg:grid-cols-[.85fr_1.15fr]">
            <div>
                <p class="eyebrow">Why consider a trade?</p>
                <h2 class="heading-lg">Keep both sides of the move together.</h2>
                <p class="mt-6 max-w-md leading-8 text-white/75">A possible trade lets you discuss the vehicle you have and the one you want as part of the same dealership visit.</p>
            </div>
            <div>
                <article v-for="item in [
                    ['A simpler conversation', 'Talk about your current vehicle and your next vehicle with the same team.'],
                    ['Less private-sale coordination', 'A trade may reduce the need to manage listings, inquiries, and meetings on your own.'],
                    ['Purchase context', 'If a trade is accepted, its agreed value may be considered as part of the next transaction.'],
                ]" :key="item[0]" class="principle">
                    <h3>{{ item[0] }}</h3><p>{{ item[1] }}</p>
                </article>
            </div>
        </div>
    </section>

    <section class="site-section bg-[#e9eddf]">
        <div class="site-container grid gap-12 lg:grid-cols-[.8fr_1.2fr]">
            <div><p class="eyebrow">Sell or trade questions</p><h2 class="heading-lg">A few things to know first.</h2></div>
            <FaqAccordion :items="faqs" />
        </div>
    </section>

    <section id="vehicle-request" class="site-section bg-white">
        <div class="site-container grid gap-12 lg:grid-cols-[.75fr_1.25fr]">
            <div>
                <p class="eyebrow">Tell us what you drive</p>
                <h2 class="heading-lg">Start with the vehicle in your driveway.</h2>
                <p class="mt-6 max-w-md leading-8 text-text-muted">Include what you know now. Our team can ask for additional details after reviewing the request.</p>
                <Link href="/inventory" class="btn-secondary mt-8">Browse Inventory <Icon name="arrow-right" /></Link>
            </div>
            <div class="form-surface"><TradeInForm /></div>
        </div>
    </section>
</template>
