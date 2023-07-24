<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>

        <template #header>
            <Menu position="dashboard"/>
        </template>

        <template #main>
           <h1 class="title mb-12 mt-8 ml-4">Tableau de bord</h1>
            <section class="bg-white rounded-lg py-12 px-10 shadow-lg">
                <h2 class="subtitle mb-8">Vos missions ({{ missions.length }})</h2>
                <Link v-if="user.role === 'client'" :href="route('mission.create')"><input type="button" value="Créer une mission" class="btn-primary mb-4"></Link>
                <div v-if="missions.length === 0" class="">
                    <p>{{ user.role === 'client' ? 'Aucune mission créée' : 'Aucune proposition en cour' }}</p>
                </div>
                <div v-else-if="user.role === 'client'">
                    <MissionCardClient v-for="(mission, ind) in missions" :key="'missionCardClient' + ind" :mission="mission"/>
                </div>
                <div v-else>
                    <MissionCardFreelance v-for="(mission, ind) in missions" :key="'missionCardFreelance' + ind" :mission="mission"  :status="mission.status" proposal/>
                </div>
            </section>
            <section class="bg-white rounded-lg py-12 px-10 shadow-lg mt-14" v-if="user.role === 'freelance' && fav.length > 0">
                <h2 class="subtitle mb-8">Vos favoris</h2>
                <MissionCardFreelance v-for="(mission, ind) in fav" :key="'missionCardFreelance' + ind" :mission="mission" fav />
            </section>
        </template>
    </AuthenticatedLayout>
</template>

<script setup>
    import Menu from '@/Components/Menu.vue';
    import MissionCardClient from '@/Components/MissionCardClient.vue';
    import MissionCardFreelance from '@/Components/MissionCardFreelance.vue';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, Link, usePage } from '@inertiajs/vue3';
    import { computed } from 'vue';

    const user = computed(() => usePage().props.auth.user);

    const props = defineProps({
        missions: Array,
        fav: Array,
    });
</script>