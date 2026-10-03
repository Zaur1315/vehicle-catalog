<script setup>
import { Link } from '@inertiajs/vue3';
import Icon from '@/Components/Icon.vue';
import Reveal from '@/Components/Reveal.vue';

defineProps({
    members: { type: Array, default: () => [] },
    showCta: { type: Boolean, default: false },
});
</script>

<template>
    <section v-if="members.length" class="team-section" aria-labelledby="team-heading">
        <div class="site-container">
            <div class="team-heading">
                <div>
                    <p class="eyebrow">The people behind Delmar</p>
                    <h2 id="team-heading" class="mt-4 heading-lg">Our <span>team</span></h2>
                </div>
                <p class="max-w-xl text-base leading-7 text-text-muted sm:text-lg">Meet the local professionals ready to help you find the right vehicle and take the next step with confidence.</p>
            </div>

            <div class="team-grid">
                <Reveal v-for="(member, index) in members" :key="member.name" :style="{ '--reveal-delay': `${index * 80}ms` }">
                    <article class="team-card">
                        <div class="team-card-media">
                            <img :src="member.image" :alt="`${member.name}, ${member.role} at Delmar Auto Sale Inc.`" width="1024" height="1280" loading="lazy">
                            <span class="team-card-number" aria-hidden="true">{{ String(index + 1).padStart(2, '0') }}</span>
                        </div>
                        <div class="team-card-body">
                            <h3>{{ member.name }}</h3>
                            <p>{{ member.role }}</p>
                        </div>
                    </article>
                </Reveal>
            </div>

            <div v-if="showCta" class="team-cta">
                <div>
                    <p class="delmar-kicker">Talk to the team</p>
                    <h3>Ready to find your next vehicle?</h3>
                </div>
                <p>Explore our current pre-owned inventory or get in touch with the Delmar team today.</p>
                <Link href="/inventory" class="btn-primary">View inventory <Icon name="arrow-right" /></Link>
            </div>
        </div>
    </section>
</template>
