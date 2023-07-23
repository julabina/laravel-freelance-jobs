<template>
    <Head title="Créer une mission" />

    <AuthenticatedLayout>

        <template #header>
            <Menu position=""/>
        </template>

        <template #main>
            <h1 class="title">Créer une mission</h1>
            <form @submit.prevent="createMission">
                <div class="flex flex-col">
                    <label for="createMissionTitle">Intitulé de la mission</label>
                    <input v-model="form.title" type="text" id="createMissionTitle">
                    <span v-for="(error, ind) in v$.title.$errors" :key="'errorTitle' + ind" class="text-error pl-0.5">
                        {{ error.$message }}
                    </span>
                </div>
                <div class="flex flex-col">
                    <label for="createMissionDescription">Description de la mission</label>
                    <textarea v-model="form.description" class="resize-y" id="createMissionDescription"></textarea>
                    <span v-for="(error, ind) in v$.description.$errors" :key="'errorDesc' + ind" class="text-error pl-0.5">
                        {{ error.$message }}
                    </span>
                </div>
                <div class="flex">
                    <div class="flex flex-col">
                        <label for="createMissionRemuneration">Rémunération prévue</label>
                        <input v-model="form.remuneration" type="number" min="1" id="createMissionRemuneration">
                        <span v-for="(error, ind) in v$.remuneration.$errors" :key="'errorRemuneration' + ind" class="text-error pl-0.5">
                            {{ error.$message }}
                        </span>
                    </div>

                    <div class="flex">
                        <input v-model="form.remote" type="checkbox" id="createMissionRemote">
                        <label for="createMissionRemote">Offre en télétravail</label>
                    </div>
                </div>
                <div v-if="form.remote === false" class="flex">
                    <div class="flex flex-col">
                        <label for="createMissionPostalcode">Code postal</label>
                        <input v-model="form.postalCode" type="text" id="createMissionPostalcode">
                        <span v-for="(error, ind) in v$.postalCode.$errors" :key="'errorPostalCode' + ind" class="text-error pl-0.5">
                            {{ error.$message }}
                        </span>
                        <span v-if="errorPostal === true" class="text-error pl-0.5">Champ requis</span>
                    </div>
                    <div class="flex flex-col">
                        <label for="createMissionCity">Ville</label>
                        <input v-model="form.city" type="text" id="createMissionCity">
                        <span v-if="errorCity === true" class="text-error pl-0.5">Champ requis</span>
                    </div>
                </div>
                <input type="submit" value="Créer" class="btn-primary">
            </form>
        </template>
    </AuthenticatedLayout>
</template>

<script setup>
    import Menu from '@/Components/Menu.vue';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { useForm } from '@inertiajs/vue3';
    import { useVuelidate } from '@vuelidate/core'
    import { required, postalCode } from '../../utils/i18n-validators';
    import { computed, ref } from 'vue';

    const form = useForm({
        title: "",
        description: "",
        postalCode: "",
        city: "",
        remote: false,
        remuneration: 1,
    })

    const errorPostal = ref(false);
    const errorCity = ref(false);

    const rules = computed(() => {
        return {
            title: { required },
            description : { required },
            postalCode: { postalCode },
            remuneration: { required },
        }
    });
    const v$ = useVuelidate(rules, form);

    const createMission = async () => {
        const result = await v$.value.$validate();

        errorCity.value = false;
        errorPostal.value = false;

        if (result) {
            if (form.remote === false) {
                if (form.city === "" || form.postalCode === "") {
                    if (form.city === "") {
                        errorCity.value = true;
                    }
                    if (form.postalCode === "") {
                        errorPostal.value = true;
                    }
                    return;
                }
            }

            form.post(route('mission.store'));
        }
    };
</script>