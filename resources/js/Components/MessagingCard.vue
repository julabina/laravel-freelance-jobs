<template>
    <article class="flex flex-col md:flex-row justify-between items-center py-6 px-8 border bg-white rounded-lg mb-8 shadow-lg">
        <div>
            <h2 class="subtitle mb-3">Mission : {{ messaging.mission.title }}</h2>
            <p>Conversation avec {{ $page.props.auth.user.role === 'freelance' ? messaging.user.name : $page.props.auth.user.role === 'client' && messaging.mission.user.name }}</p>
            <p>{{ messaging.message.length }} message<span v-if="messaging.message.length > 1">s</span></p>
        </div>
        <Link :href="route('messaging.show', { id: messaging.id })">
            <button class="btn-primary mt-5 md:mt-0">Voir</button>
        </Link>
    </article>
</template>

<script setup>
    import { Link } from '@inertiajs/vue3';

    const props = defineProps({
        messaging: Object,
    });
</script>