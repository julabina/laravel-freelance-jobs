<template>
    <article class="relative border p-4">
        <h2>{{ mission.title }}</h2>
        <Link :href="'/mission/' + mission.id">Voir l'offre</Link>
        <MissionStatus :missionStatus="mission.status" :remuneration="mission.remuneration"/>
        <p v-if="mission.remote === true">Télétravail</p>
        <p v-else>{{ mission.postalcode }} - <span class="first-letter:uppercase">{{ mission.city }}</span></p>
        <p class="mt-5">Il y a {{ mission.proposal_count }} proposition pour cette mission.</p>
        <i @click="like" :class="mission.mission_like.length === 1 ? 'absolute top-4 right-4 cursor-pointer fa-solid fa-heart' : 'absolute top-4 right-4 cursor-pointer fa-regular fa-heart'"></i>
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