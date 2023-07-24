<template>
    <article :class="message.user_id === $page.props.auth.user.id ? 'bg-primary p-3 mb-3 rounded text-white' : 'bg-secondary p-3 mb-3 rounded text-white'">
        <p class="text-sm">Message envoyé par {{ message.user.name }} à {{ messageDate !== null && messageDate.getHours() }}h{{ messageDate !== null && messageDate.getMinutes() }} le {{ messageDate !== null && messageDate.toLocaleDateString('FR') }}</p>
        <p class="mt-3">{{ message.message }}</p>
    </article>
</template>

<script setup>
    import { ref, onMounted } from 'vue';

    const props = defineProps({
        message: Object,
    });

    const messageDate = ref(null);

    onMounted(() => {
        messageDate.value = new Date(props.message.created_at);
    });
</script>