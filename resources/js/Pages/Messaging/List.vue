<template>
    <Head title="Messagerie" />

    <AuthenticatedLayout>

        <template #header>
            <Menu position="message"/>
        </template>

        <template #main>
            <h1 class="title mb-12 mt-8 ml-4">Messagerie de {{ $page.props.auth.user.name }}</h1>
            <p class="text-center mt-16 font-semibold" v-if="messagings.length === 0">Aucune conversation</p>
            <section v-else>
                <MessagingCard v-for="(messaging, ind) in messagings" :key="'messagingCard' + ind" :messaging="messaging" />
            </section>
        </template>
    </AuthenticatedLayout>
</template>

<script setup>
    import Menu from '@/Components/Menu.vue';
    import MessagingCard from '@/Components/MessagingCard.vue';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';;

    const props = defineProps({
        messagings: Object,
    });
</script>