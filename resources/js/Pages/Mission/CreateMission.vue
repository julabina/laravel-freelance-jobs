<template>
    <Head title="Créer une mission" />

    <AuthenticatedLayout>

        <template #header>
            <Menu position=""/>
        </template>

        <template #main>
            <h1 class="title mb-12 mt-8 ml-4">Créer une mission</h1>
            <form class="px-8 py-10 bg-white rounded-lg shadow-lg" @submit.prevent="createMission">
                <div class="flex flex-col">
                    <label class="font-semibold mb-1" for="createMissionTitle">Intitulé de la mission</label>
                    <input v-model="form.title" type="text" id="createMissionTitle">
                    <span v-for="(error, ind) in v$.title.$errors" :key="'errorTitle' + ind" class="text-error pl-0.5">
                        {{ error.$message }}
                    </span>
                </div>
                <div class="flex flex-col">
                    <label class="font-semibold mb-1 mt-4" for="createMissionDescription">Description de la mission</label>
                    <textarea v-model="form.description" class="resize-y h-32" id="createMissionDescription"></textarea>
                    <span v-for="(error, ind) in v$.description.$errors" :key="'errorDesc' + ind" class="text-error pl-0.5">
                        {{ error.$message }}
                    </span>
                </div>
                <div class="flex items-center">
                    <div class="flex flex-col">
                        <label class="font-semibold mb-1 mt-4" for="createMissionRemuneration">Rémunération prévue</label>
                        <input v-model="form.remuneration" type="number" min="1" id="createMissionRemuneration">
                        <span v-for="(error, ind) in v$.remuneration.$errors" :key="'errorRemuneration' + ind" class="text-error pl-0.5">
                            {{ error.$message }}
                        </span>
                    </div>

                    <div class="flex items-center h-full ml-10 pt-10">
                        <input v-model="form.remote" type="checkbox" id="createMissionRemote">
                        <label class="font-semibold ml-2" for="createMissionRemote">Offre en télétravail</label>
                    </div>
                </div>
                <div v-if="form.remote === false" class="flex">
                    <div class="flex flex-col">
                        <label class="font-semibold mb-1 mt-4" for="createMissionPostalcode">Code postal</label>
                        <input v-model="form.postalCode" type="text" id="createMissionPostalcode">
                        <span v-for="(error, ind) in v$.postalCode.$errors" :key="'errorPostalCode' + ind" class="text-error pl-0.5">
                            {{ error.$message }}
                        </span>
                        <span v-if="errorPostal === true" class="text-error pl-0.5">Champ requis</span>
                    </div>
                    <div class="flex flex-col ml-10">
                        <label class="font-semibold mb-1 mt-4" for="createMissionCity">Ville</label>
                        <input v-model="form.city" type="text" id="createMissionCity">
                        <span v-if="errorCity === true" class="text-error pl-0.5">Champ requis</span>
                    </div>
                </div>
                <input type="submit" value="Créer" class="btn-primary mt-12">
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