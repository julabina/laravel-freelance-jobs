<template>
    <article class="flex justify-between p-4 border my-2">
        <div class="flex flex-col">
            <h2 class="subtitle">{{ mission.title }}</h2>
            <MissionStatus :missionStatus="mission.status" :remuneration="mission.remuneration" />
            <p v-if="mission.remote === true">En télétravail</p>
            <p v-else class="first-letter:uppercase">{{ mission.city }} ({{ mission.postalcode }})</p>
            <p class="mt-2">{{ mission.proposal_count }} proposition<span v-if="mission.proposal_count > 1">s</span></p>
        </div>
        <div class="flex flex-col">
            <Link :href="'/mission/' + mission.id"><button class="btn-primary">
                voir
            </button></Link>
        </div>
    </article>
</template>

<script setup>
    import { Link } from '@inertiajs/vue3';
    import MissionStatus from './MissionStatus.vue';

    const props = defineProps({
        mission: Object,
    });
</script>