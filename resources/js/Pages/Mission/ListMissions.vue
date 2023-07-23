<template>
    <Head title="Toutes les missions" />

    <AuthenticatedLayout>

        <template #header>
            <Menu position="jobslist"/>
        </template>

        <template #main>
            <h1 class="title">Toutes les missions disponibles</h1>
            <section>
                <MissionCard v-for="(mission, ind) in missions.data" :key="'missionCard' + ind" :mission="mission" />
            </section>
        </template>
    </AuthenticatedLayout>
</template>

<script setup>
    import Menu from '@/Components/Menu.vue';
    import MissionCard from '@/Components/MissionCard.vue';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

    const props = defineProps({
        missions: Array,
    });
</script>