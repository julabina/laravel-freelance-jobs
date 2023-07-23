<template>
    <article :class="message.user_id === $page.props.auth.user.id ? 'bg-primary p-3 mb-3 rounded text-white' : 'bg-secondary p-3 mb-3 rounded text-white'">
        <p class="text-sm">Message envoyé par {{ message.user.name }} le XXXXXXX</p>
        <p>{{ message.message }}</p>
    </article>
</template>

<script setup>
    const props = defineProps({
        message: Object,
    });
</script>