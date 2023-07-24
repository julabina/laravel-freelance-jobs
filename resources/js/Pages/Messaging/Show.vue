<template>
    <Head title="Messagerie" />

    <AuthenticatedLayout>

        <template #header>
            <Menu position="message"/>
        </template>

        <template #main>
            <section class="flex justify-between">
                <div class="mb-12 mt-8 ml-4">
                    <h1 class="title">Messagerie de l'offre: </h1>
                    <h2 class="subtitle">"{{ messaging.mission.title }}"</h2>
                </div>
                <Link class="mt-8 mr-4" :href="route('messaging.list')">
                    <button class="btn-secondary">Retour</button>
                </Link>
            </section>
            <section class="bg-white px-8 py-12 rounded-lg shadow-lg">
                <ProposalMessage v-for="(message, ind) in messaging.message" :key="'messageMessaging' + ind" :message="message" />
                <div v-if="messaging.message.length === 0" class="flex justify-center items-center">
                    <h3>Aucun messages</h3>
                </div>
                <div class="flex w-full mt-9">
                    <input v-model="message" class="w-full border-2 border-primary mr-2 rounded-l-full pl-6 font-medium" type="text">
                    <button @click="postMessage" class="btn-primary rounded-r-full h-12">Envoyer</button>
                </div>
                <p v-text="error" v-if="messageError === true" class="text-error"></p>
            </section>
        </template>
    </AuthenticatedLayout>
</template>

<script setup>
    import Menu from '@/Components/Menu.vue';
    import ProposalMessage from '@/Components/ProposalMessage.vue';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Link, router } from '@inertiajs/vue3';
    import { ref } from 'vue';

    const props = defineProps({
        messaging: Object,
    });

    const error = ref(null);
    const messageError = ref(false);
    const message = ref('');
    
    const postMessage = () => {
        messageError.value = false;

        if (message.value !== "" && message.value.length < 255) {
            router.visit('/message/' + props.messaging.id , {
            method: 'post',
            data: { message: message.value }
        });
        } else {
            error.value = "";
            
            if (message.value === "") {
                error.value = "Le message ne peut pas être vide";
            } else if (message.value.length < 255) {
                error.value = "La taille du message doit être inférieur à 255 caractères";
            }

            messageError.value = true;
        }
    };
</script>