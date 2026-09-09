<script setup>
import SubmissionError from '@/Components/SubmissionError.vue';
import { useSubmissionFeedback } from '@/useSubmissionFeedback.js';
const { submissionError, feedback } = useSubmissionFeedback();
import { useForm, usePage } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import Icon from '@/Components/Icon.vue';

const submitted = ref(false);
const page = usePage();
const form = useForm({
    first_name: '',
    last_name: '',
    email: '',
    phone: '',
    vehicle_interest: '',
    amount: '',
    down_payment: '',
    term_months: '',
    credit_score_range: '',
    message: '',
});
onMounted(() => {
    form.vehicle_interest =
        new URLSearchParams(location.search).get('vehicle') || '';
});
const submit = () => {
    if (form.processing) return;
    form.post('/finance', {
        preserveScroll: true,
        ...feedback,
        onSuccess: () => {
            form.reset();
            submitted.value = true;
        },
    });
};
</script>

<template>
    <div v-if="submitted" class="py-8" role="status">
        <p class="eyebrow">Request received</p>
        <h3 class="mt-3 text-3xl font-bold">Thanks for reaching out.</h3>
        <p class="mt-4 leading-7 text-text-muted">
            Our team will contact you soon to discuss your request and next
            steps.
        </p>
        <button
            type="button"
            class="btn-primary mt-7"
            @click="submitted = false"
        >
            Send another request
        </button>
    </div>
    <form v-else @submit.prevent="submit">
        <SubmissionError :message="submissionError" />
        <p class="eyebrow">Preliminary request</p>
        <h3 class="mt-3 text-2xl font-bold">Tell us what you’re planning.</h3>
        <p class="mt-2 text-sm leading-6 text-text-muted">
            Fields marked with * are required.
        </p>
        <div class="mt-7 grid gap-4 sm:grid-cols-2">
            <label>
                <span class="form-label">First name *</span>
                <input
                    v-model="form.first_name"
                    required
                    autocomplete="given-name"
                    class="form-input-dark"
                />
                <p v-if="form.errors.first_name" class="form-error">
                    {{ form.errors.first_name }}
                </p>
            </label>
            <label>
                <span class="form-label">Last name</span>
                <input
                    v-model="form.last_name"
                    autocomplete="family-name"
                    class="form-input-dark"
                />
                <p v-if="form.errors.last_name" class="form-error">
                    {{ form.errors.last_name }}
                </p>
            </label>
            <label>
                <span class="form-label">Phone *</span>
                <input
                    v-model="form.phone"
                    required
                    type="tel"
                    autocomplete="tel"
                    class="form-input-dark"
                />
                <p v-if="form.errors.phone" class="form-error">
                    {{ form.errors.phone }}
                </p>
            </label>
            <label>
                <span class="form-label">Email</span>
                <input
                    v-model="form.email"
                    type="email"
                    autocomplete="email"
                    class="form-input-dark"
                />
                <p v-if="form.errors.email" class="form-error">
                    {{ form.errors.email }}
                </p>
            </label>
        </div>
        <label class="mt-4 block">
            <span class="form-label">Vehicle of interest</span>
            <input
                v-model="form.vehicle_interest"
                placeholder="Year, make, model — if known"
                class="form-input-dark"
            />
            <p v-if="form.errors.vehicle_interest" class="form-error">
                {{ form.errors.vehicle_interest }}
            </p>
        </label>
        <div class="mt-4 grid gap-4 sm:grid-cols-2">
            <label>
                <span class="form-label">Target amount</span>
                <input
                    v-model="form.amount"
                    type="number"
                    min="0"
                    inputmode="decimal"
                    class="form-input-dark"
                />
                <p v-if="form.errors.amount" class="form-error">
                    {{ form.errors.amount }}
                </p>
            </label>
            <label>
                <span class="form-label">Down payment</span>
                <input
                    v-model="form.down_payment"
                    type="number"
                    min="0"
                    inputmode="decimal"
                    class="form-input-dark"
                />
                <p v-if="form.errors.down_payment" class="form-error">
                    {{ form.errors.down_payment }}
                </p>
            </label>
            <label>
                <span class="form-label">Preferred term</span>
                <select v-model="form.term_months" class="form-select-dark">
                    <option value="">Select</option>
                    <option value="36">36 months</option>
                    <option value="48">48 months</option>
                    <option value="60">60 months</option>
                    <option value="72">72 months</option>
                </select>
                <p v-if="form.errors.term_months" class="form-error">
                    {{ form.errors.term_months }}
                </p>
            </label>
            <label>
                <span class="form-label">Credit score range</span>
                <select
                    v-model="form.credit_score_range"
                    class="form-select-dark"
                >
                    <option value="">Prefer not to say</option>
                    <option>Excellent</option>
                    <option>Good</option>
                    <option>Fair</option>
                    <option>Building credit</option>
                </select>
                <p v-if="form.errors.credit_score_range" class="form-error">
                    {{ form.errors.credit_score_range }}
                </p>
            </label>
        </div>
        <label class="mt-4 block">
            <span class="form-label">Additional context</span>
            <textarea
                v-model="form.message"
                rows="4"
                placeholder="Anything you would like us to know?"
                class="form-input-dark"
            ></textarea>
            <p v-if="form.errors.message" class="form-error">
                {{ form.errors.message }}
            </p>
        </label>
        <button class="btn-primary mt-6 w-full" :disabled="form.processing">
            {{
                form.processing
                    ? 'Sending request…'
                    : 'Submit auto financing request'
            }}
            <Icon name="send" />
        </button>
        <p class="form-help">
            By submitting, you ask {{ page.props.site.name }} to contact you
            about this auto financing request.
        </p>
    </form>
</template>
