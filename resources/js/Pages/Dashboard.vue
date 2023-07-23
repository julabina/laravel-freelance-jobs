<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>

        <template #header>
            <Menu position="dashboard"/>
        </template>

        <template #main>
           <h1 class="title">Tableau de bord</h1>
            <section>
                <!-- <h2 class="subtitle">Vos missions ({{ missions.length }})</h2> -->
                <Link v-if="user.role === 'client'" :href="route('mission.create')"><input type="button" value="Créer une mission" class="btn-primary"></Link>
                <!-- <div v-if="missions.length === 0" class="">
                    <p>{{ user.role === 'client' ? 'Aucune mission créée' : 'Aucune proposition en cour' }}</p>
                </div>
                <div v-else-if="user.role === 'client'">
                    <MissionCardClient v-for="(mission, ind) in missions" :key="'missionCardClient' + ind" :mission="mission"/>
                </div>
                <div v-else>
                    <MissionCardFreelance v-for="(mission, ind) in missions" :key="'missionCardFreelance' + ind" :mission="mission"  :status="mission.status"/>
                </div> -->
            </section>
            <!-- <section v-if="user.role === 'freelance'">
                <h2 class="subtitle">Vos favoris</h2>
                <MissionCardFreelance v-for="(mission, ind) in fav" :key="'missionCardFreelance' + ind" :mission="mission" fav />
            </section> -->
        </template>
    </AuthenticatedLayout>
</template>

<script setup>
    import Menu from '@/Components/Menu.vue';
    /* import MissionCardClient from '@/Components/MissionCardClient.vue';
    import MissionCardFreelance from '@/Components/MissionCardFreelance.vue'; */
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, Link, usePage } from '@inertiajs/vue3';
    import { computed } from 'vue';

    const user = computed(() => usePage().props.auth.user);

    /* const props = defineProps({
        missions: Array,
        fav: Array,
    }); */
</script>