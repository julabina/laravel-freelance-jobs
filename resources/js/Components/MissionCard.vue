<template>
    <article class="relative border px-8 py-4 mb-8 bg-white rounded-lg shadow-lg">
        <h2 class="subtitle mb-2">{{ mission.title }}</h2>
        <Link class="link-primary" :href="route('mission.show', { id: mission.id })">Voir l'offre</Link>
        <MissionStatus :missionStatus="mission.status" :remuneration="mission.remuneration"/>
        <p v-if="mission.remote === true">Télétravail</p>
        <p v-else>{{ mission.postalcode }} - <span class="first-letter:uppercase">{{ mission.city }}</span></p>
        <p class="mt-5">Il y a {{ mission.proposal_count }} proposition pour cette mission.</p>
        <i @click="like" :class="mission.mission_like.length === 1 ? 'bg-white absolute top-6 right-8 cursor-pointer fa-solid fa-heart' : 'bg-white absolute top-6 right-8 cursor-pointer fa-regular fa-heart'"></i>
    </article>
</template>

<script setup>
    import { Link, router } from '@inertiajs/vue3';
    import MissionStatus from './MissionStatus.vue';

    const props = defineProps({
        mission: Object,
    });

    const like = () => {
        router.visit(route('mission.like', {'id': props.mission.id}) , {
            method: 'put',
            data: { card: true },
        });
    };
</script>