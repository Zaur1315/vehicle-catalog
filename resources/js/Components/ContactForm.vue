<script setup>
import { useForm } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import Icon from '@/Components/Icon.vue';

const props = defineProps({ topics: { type: Array, default: () => [] } });
const submitted = ref(false);
const form = useForm({ first_name: '', last_name: '', email: '', phone: '', subject: '', message: '' });
onMounted(() => {
    const subject = new URLSearchParams(window.location.search).get('subject');
    if (subject && props.topics.some((topic) => topic[0] === subject)) form.subject = subject;
});
const submit = () => form.post('/contact', { preserveScroll: true, onSuccess: () => { form.reset(); submitted.value = true; } });
</script>

<template>
    <div v-if="submitted" class="py-8"><p class="eyebrow">Message received</p><h3 class="mt-3 text-3xl font-bold">Thanks for reaching out.</h3><p class="mt-4 leading-7 text-text-muted">Our team will contact you soon about your message.</p><button type="button" class="btn-primary mt-7" @click="submitted = false">Send another message</button></div>
    <form v-else @submit.prevent="submit"><p class="eyebrow">Send a message</p><h3 class="mt-3 text-2xl font-bold">How can we help?</h3><p class="mt-2 text-sm leading-6 text-text-muted">Fields marked with * are required.</p><div class="mt-7 grid gap-4 sm:grid-cols-2"><label><span class="form-label">First name *</span><input v-model="form.first_name" required autocomplete="given-name" class="form-input-dark"><p v-if="form.errors.first_name" class="form-error">{{ form.errors.first_name }}</p></label><label><span class="form-label">Last name</span><input v-model="form.last_name" autocomplete="family-name" class="form-input-dark"><p v-if="form.errors.last_name" class="form-error">{{ form.errors.last_name }}</p></label><label><span class="form-label">Phone *</span><input v-model="form.phone" required type="tel" autocomplete="tel" class="form-input-dark"><p v-if="form.errors.phone" class="form-error">{{ form.errors.phone }}</p></label><label><span class="form-label">Email</span><input v-model="form.email" type="email" autocomplete="email" class="form-input-dark"><p v-if="form.errors.email" class="form-error">{{ form.errors.email }}</p></label></div><label class="mt-4 block"><span class="form-label">Topic</span><select v-model="form.subject" class="form-select-dark"><option value="">Select a topic</option><option v-for="topic in props.topics" :key="topic[0]" :value="topic[0]">{{ topic[0] }}</option></select><p v-if="form.errors.subject" class="form-error">{{ form.errors.subject }}</p></label><label class="mt-4 block"><span class="form-label">Message</span><textarea v-model="form.message" rows="6" class="form-input-dark"></textarea><p v-if="form.errors.message" class="form-error">{{ form.errors.message }}</p></label><button class="btn-primary mt-6 w-full" :disabled="form.processing">{{ form.processing ? 'Sending message…' : 'Send message' }} <Icon name="send" /></button><p class="form-help">By submitting this form, you’re asking Delmar Auto Sale Inc. to contact you about your message.</p></form>
</template>
