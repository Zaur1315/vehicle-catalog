<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import BrandImage from '@/Components/BrandImage.vue';
import FaqAccordion from '@/Components/FaqAccordion.vue';
import FinanceForm from '@/Components/FinanceForm.vue';
import Icon from '@/Components/Icon.vue';
import SeoHead from '@/Components/SeoHead.vue';
import SiteLayout from '@/Layouts/SiteLayout.vue';

defineOptions({ layout: SiteLayout });
const site = computed(() => usePage().props.site || {});

const steps = [
    ['Choose a vehicle', 'Start with a vehicle in our inventory, or tell us what kind of vehicle you are considering.'],
    ['Share your information', 'Send the preliminary request with the contact and purchase details you are comfortable providing.'],
    ['Review the next steps', 'Our team will follow up and explain what additional information or separate credit process may be needed.'],
    ['Move forward', 'If the available path fits your plans, continue the vehicle purchase process with our team.'],
];
const preparation = [
    ['Contact details', 'A reliable phone number and email address.'],
    ['Employment and income', 'Basic employment and income details may be requested later in the process.'],
    ['Housing information', 'Your current housing situation may be relevant to a separate application.'],
    ['Identification', 'Valid identification may be needed if you decide to move forward.'],
    ['Current vehicle', 'If you have a possible trade, bring its mileage, payoff context, and general condition.'],
];
const faqs = [
    ['Can I submit a request before choosing a vehicle?', 'Yes. Tell us what type of vehicle you are looking for, or browse the current inventory first. Choosing a specific vehicle can make the follow-up conversation more focused.'],
    ['Can auto financing be discussed for a used vehicle?', 'Yes. The request on this page is designed for vehicles in our pre-owned inventory. Any available terms depend on the vehicle, applicant information, and a separate review.'],
    ['Can I include a vehicle I may want to trade?', 'Yes. Mention it in your request, then use the Sell or Trade page to share the vehicle details our team will need for a useful follow-up.'],
    ['What happens after I submit the form?', 'Southern York Motors receives your preliminary request and can contact you about the vehicle, your questions, and any additional steps that may apply.'],
    ['Does submitting a request guarantee approval?', 'No. This form is not a credit application, approval, rate quote, or financing commitment. Any separate credit process will be explained before you proceed.'],
];
</script>

<template>
    <SeoHead
        title="Auto Financing"
        :description="'Explore auto financing for a pre-owned vehicle with ' + site.name + ' in ' + site.city + ', Pennsylvania. Learn what to expect and start a preliminary request.'"
        image="/images/southern-york/interior-1280.webp"
    />
    <section class="site-container split-intro">
        <div>
            <p class="eyebrow">Auto financing</p>
            <h1>Auto financing for your next vehicle.</h1>
            <p>
                Tell us what you are considering and where you are in the
                process. We will use your preliminary request to start a
                focused conversation about the next steps.
            </p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="#financing-request" class="btn-primary">Start Financing Request</a>
                <Link href="/inventory" class="btn-secondary">Browse Inventory</Link>
            </div>
            <p class="!text-xs">A preliminary request, not a credit application or approval.</p>
        </div>
        <div class="split-intro-media">
            <BrandImage name="interior" alt="Warm leather seats and a sunlit vehicle interior" eager />
        </div>
    </section>

    <section class="site-section bg-white">
        <div class="site-container">
            <div class="process-heading">
                <div>
                    <p class="eyebrow">How auto financing works</p>
                    <h2 class="heading-lg">A process without the guesswork.</h2>
                </div>
                <p>
                    The online form starts the conversation. It gives our team
                    enough context to respond without asking you to send
                    sensitive financial information through the website.
                </p>
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
        <div class="preparation-panel">
            <div>
                <p class="eyebrow">Prepare at your pace</p>
                <h2 class="heading-lg">What you may want to have ready.</h2>
                <p class="mt-6 max-w-lg leading-8 text-text-muted">
                    You do not need to upload these items with the preliminary
                    form. If you continue into a separate financing process,
                    having the basics nearby may make the conversation easier.
                </p>
                <p class="mt-5 text-sm leading-7 text-text-muted">
                    Never send a Social Security number, banking details, or
                    identification documents through the message field.
                </p>
            </div>
            <ul class="preparation-list">
                <li v-for="item in preparation" :key="item[0]">
                    <span><Icon name="arrow-right" /></span>
                    <div><h3>{{ item[0] }}</h3><p>{{ item[1] }}</p></div>
                </li>
            </ul>
        </div>
    </section>

    <section class="site-section bg-[#e9eddf]">
        <div class="site-container grid gap-12 lg:grid-cols-[.8fr_1.2fr]">
            <div>
                <p class="eyebrow">Questions about auto financing</p>
                <h2 class="heading-lg">Know what the form does.</h2>
                <p class="mt-6 max-w-md leading-8 text-text-muted">
                    These answers explain the preliminary request on this site.
                    Specific terms can only be discussed after the relevant
                    information is reviewed.
                </p>
            </div>
            <FaqAccordion :items="faqs" />
        </div>
    </section>

    <section id="financing-request" class="site-section bg-white">
        <div class="site-container grid gap-12 lg:grid-cols-[.8fr_1.2fr]">
            <div>
                <p class="eyebrow">Ready to explore your options?</p>
                <h2 class="heading-lg">Start with a few useful details.</h2>
                <p class="mt-6 max-w-md leading-8 text-text-muted">
                    Share how we can reach you, the vehicle you are considering,
                    and any questions you want our team to address first.
                </p>
                <Link href="/inventory" class="btn-secondary mt-8">
                    Browse Inventory <Icon name="arrow-right" />
                </Link>
            </div>
            <div class="form-surface"><FinanceForm /></div>
        </div>
    </section>
</template>
