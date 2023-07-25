<template>
    <article :class="status === 'refused' ? 'relative flex flex-col md:flex-row justify-between p-6 border rounded border-opacity-60 border-gray-400 text-gray-400 pointer-events-none my-2' : 'relative flex flex-col md:flex-row justify-between p-6 border border-primary rounded border-opacity-60 my-2'">
        <div class="flex flex-col">
            <h2 class="subtitle">{{ mission.mission.title }}</h2>
            <MissionStatus :missionStatus="mission.mission.status" :remuneration="mission.mission.remuneration" :refused="status === 'refused' && true" />
            <p v-if="mission.mission.remote === true">En télétravail</p>
            <p v-else class="first-letter:uppercase">{{ mission.mission.city }} ({{ mission.mission.postalcode }})</p>
        </div>
        <div v-if="status !== 'refused'" class="flex flex-col mt-8 md:mt-0 md:items-end">
            <Link class="mb-2" v-if="mission.mission.status === 'open' || (mission.mission.status === 'granted' && mission.status === 'accepted')" :href="'/mission/' + mission.mission.id"><button class="btn-primary w-full">
                voir
            </button></Link>
            <p v-if="status === 'accepted'" class="text-green-500 text-lg font-semibold">Mission remporté</p>
            <button v-if="fav === true" @click="like" class="btn-secondary">Retirer des favoris</button>
            <button v-if="proposal === true && status !== 'accepted'" @click="removeProposal" class="btn-secondary">Retirer ma proposition</button>
        </div>
        <div v-if="status === 'refused'" class="absolute top-0 left-0 h-full w-full flex justify-center items-center text-red-400 uppercase font-bold text-lg">refusé</div>
    </article>
</template>

<script setup>
    import { Link, router } from '@inertiajs/vue3';
    import MissionStatus from './MissionStatus.vue';

    const props = defineProps({
        mission: Object,
        status: String|null,
        fav: Boolean,
        proposal: Boolean,
    });

    const like = () => {
        router.visit(route('mission.like', { id: props.mission.mission.id }) , {
            method: 'put',
            data: { home: true },
        });
    };
    
    const removeProposal = () => {
        router.visit(route('mission.remove', { id: props.mission.mission.id }) , {
            method: 'delete',
        });
    };
</script>