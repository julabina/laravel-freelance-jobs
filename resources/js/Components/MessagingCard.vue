<template>
    <article class="flex justify-between p-4 border mb-2">
        <div>
            <h2 class="subtitle">Mission : {{ messaging.mission.title }}</h2>
            <p>Conversation avec {{ $page.props.auth.user.role === 'freelance' ? messaging.user.name : $page.props.auth.user.role === 'client' && messaging.mission.user.name }}</p>
            <p>{{ messaging.message.length }} message<span v-if="messaging.message.length > 1">s</span></p>
        </div>
        <Link :href="route('messaging.show', { id: messaging.id })">
            <button class="btn-primary">Voir</button>
        </Link>
    </article>
</template>

<script setup>
    import { Link } from '@inertiajs/vue3';

    const props = defineProps({
        messaging: Object,
    });
</script>