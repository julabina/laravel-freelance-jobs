<template>
    <Head title="Créer une mission" />

    <AuthenticatedLayout>

        <template #header>
            <Menu position=""/>
        </template>

        <template #main>
            <h2 class="text-green-700 italic my-3" v-if="$page.props.flash.message">{{ $page.props.flash.message }}</h2>
            <section class="flex justify-between items-center mb-12 mt-8 mx-4">
                <h1 class="title">{{ mission.title }}</h1>
                <i v-if="$page.props.auth.user.role === 'freelance'" @click="like" :class="mission.mission_like.length === 1 ? 'cursor-pointer fa-solid fa-heart' : 'cursor-pointer fa-regular fa-heart'"></i>
            </section>
            <div class="ml-4 bg-white py-12 px-6 rounded-lg shadow-lg">
                <p class="first-letter:uppercase">{{ mission.description }}</p>
                <section class="flex justify-between mt-6 mb-9">
                    <p>Rémunération: {{ mission.remuneration }}€</p>
                    <p v-if="mission.remote === true">Offre en télétravail</p>
                    <p v-else>{{ mission.postalcode }} - {{ mission.city }}</p>
                </section>
                <section class="" v-if="$page.props.auth.user.role === 'freelance'">
                    <section v-if="mission.mission_proposal.length === 0" class="">
                        <input @click="toggleForm = true" v-if="toggleForm === false" type="button" value="Soumettre une proposition" class="btn-primary">
                        <form v-else @submit.prevent="proposal">
                            <div class="flex flex-col border-t border-gray-500 pt-4 mt-4">
                                <label class="font-semibold mb-1" for="proposalMessage">Votre proposition</label>
                                <textarea v-model="form.message" class="resize-y" id="proposalMessage"></textarea>
                                <span v-for="(error, ind) in v$.message.$errors" :key="'errorDesc' + ind" class="text-error pl-0.5">
                                    {{ error.$message }}
                                </span>
                            </div>
                            <div class="flex w-full justify-content mt-8">
                                <input @click="toggleForm = false" type="button" value="Annuler" class="btn-secondary mr-2">
                                <input type="submit" value="Envoyer" class="btn-primary">
                            </div>
                        </form>
                    </section>
                    <section v-else-if="$page.props.flash.message">
                        <h2 class="text-green-700 italic my-3">{{ $page.props.flash.message }}</h2>
                    </section>
                    <section v-else>
                        <h2 class="font-semibold text-center mt-12">Proposition envoyée</h2>
                    </section>
                </section>
                <section class="" v-if="$page.props.auth.user.role === 'client'">
                    <div class="flex items-center mb-8">
                        <div :class="mission.status === 'open' ? 'h-2.5  w-2.5 rounded-full bg-green-500' : mission.status === 'closed' ? 'h-2.5  w-2.5 rounded-full bg-red-500' : 'h-2.5  w-2.5 rounded-full bg-blue-500'"></div>
                        <p class="ml-1">{{ statusTranslate }}</p>
                        <button @click="updateStatus" v-if="mission.status !== 'granted'" class="btn-primary ml-6">{{ mission.status === 'open' ? 'Desactiver l\'offre' : 'Réouvrir l\'offre' }}</button>
                    </div>
                    <div class="flex flex-col">
                        <div class="flex flex-col-reverse md:flex-row justify-between">
                            <h3 class="text-lg font-semibold">Toutes les propositions</h3>
                            <div class="flex items-center">
                                <button @click="updateGrantedStatus" :class="mission.status === 'granted' ? 'mb-2 md:mb-0 md:ml-1.5 btn-primary' : 'mb-2 md:mb-0 md:ml-1.5 btn-secondary'">{{ mission.status === 'granted' ? 'Réouvrir la mission' : 'Rendre la mission pourvus' }}</button>
                            </div>
                        </div>
                        <div v-if="mission.mission_proposal.length > 0" class="flex flex-col">
                            <MissionProposal v-for="(proposal, ind) in mission.mission_proposal" :key="'missionProposal' + ind" :proposal="proposal" />
                        </div>
                        <p class="mt-16 text-center" v-else>Aucune proposition</p>
                    </div>
                </section>
            </div>
        </template>
    </AuthenticatedLayout>
</template>

<script setup>
    import Menu from '@/Components/Menu.vue';
    import MissionProposal from '@/Components/MissionProposal.vue';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { router, useForm } from '@inertiajs/vue3';
    import { ref, computed, onMounted } from 'vue';
    import { useVuelidate } from '@vuelidate/core'
    import { required } from '../../utils/i18n-validators';
    import status from '../../utils/translate.json';

    const props = defineProps({
        mission: Object,
    });
    
    const form = useForm({
        id: props.mission.id,
        message: '',
    });

    const toggleForm = ref(false);
    const statusTranslate = ref('');

    onMounted(() => {
        if (status.mission_status[props.mission.status]) {
            statusTranslate.value = status.mission_status[props.mission.status].translate;
        }
    });

    const rules = computed(() => {
        return {
            message: { required },
        }
    });
    const v$ = useVuelidate(rules, form);

    const like = () => {
        router.visit(route('mission.like', {'id': props.mission.id}) , {
            method: 'put',
        });
    };

    const proposal = async () => {
        const result = await v$.value.$validate();

        if (result) {   
            form.post(route('mission.proposal'));
        }
    };

    const updateStatus = () => {
        router.visit( route('mission.updateStatus', { id: props.mission.id }) , {
            method: 'put',
        });
    };

    const updateGrantedStatus = () => {
        router.visit(route('mission.updateGrantedStatus', { id: props.mission.id }) , {
            method: 'put',
        });
    };
</script>