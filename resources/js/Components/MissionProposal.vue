<template>
    <article class="border-primary border rounded-lg border-opacity-25 p-6 mt-10">
        <p class="font-semibold">{{ statusTranslate }}</p>
        <p class="mb-6">Proposition envoyé par {{ proposal.user.name }}</p>
        <p class="border border-dashed p-2 mb-8 text-gray-700">{{ proposal.message }}</p>
        <div v-if="proposal.status === 'waiting'" class="flex justify-center mt-4">
            <button @click="negociated" class="btn-primary mx-1.5">Discuter avec le candidat</button>
            <button @click="refuse" class="btn-primary mx-1.5">Refuser le candidat</button>
        </div>
        <div v-if="proposal.status === 'negotiated'" class="flex justify-center mt-4">
            <button @click="accepted" class="btn-primary mx-1.5">Choisir le candidat</button>
            <button @click="refuse" class="btn-primary mx-1.5">Refuser le candidat</button>
        </div>
        <div v-if="proposal.status === 'accepted'" class="flex justify-center mt-4">
            <button @click="cancel" class="btn-primary mx-1.5">Annuler</button>
        </div>
    </article>
</template>

<script setup>
    import { ref, onMounted } from 'vue';
    import status from '../utils/translate.json';
    import { router } from '@inertiajs/vue3';

    const props = defineProps({
        proposal: Object,
    });

    const statusTranslate = ref('');

    onMounted(() => {
        if (status.proposal_status[props.proposal.status]) {
            statusTranslate.value = status.proposal_status[props.proposal.status].translate;
        }
    });

    const negociated = () => {
        router.visit('/mission/updateProposal/' + props.proposal.id , {
            method: 'put',
            data: { action: 'negotiated' }
        });
    };
    
    const refuse = () => {
        router.visit('/mission/updateProposal/' + props.proposal.id , {
            method: 'put',
            data: { action: 'refuse' }
        });
    };
    
    const accepted = () => {
        router.visit('/mission/updateProposal/' + props.proposal.id , {
            method: 'put',
            data: { action: 'accept' }
        });
    };
    
    const cancel = () => {
        router.visit('/mission/updateProposal/' + props.proposal.id , {
            method: 'put',
            data: { action: 'cancel' }
        });
    };
</script>