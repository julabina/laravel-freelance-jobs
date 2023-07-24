<template>
    <div class="flex items-center mt-2">
        <div :class="refused === true ? 'h-2.5  w-2.5 rounded-full bg-gray-400' : missionStatus === 'open' ? 'h-2.5  w-2.5 rounded-full bg-green-500' : missionStatus === 'closed' ? 'h-2.5  w-2.5 rounded-full bg-red-500' : 'h-2.5  w-2.5 rounded-full bg-blue-500'"></div>
        <p class="ml-1">{{ statusTranslate }} - {{ remuneration }} €</p>
    </div>
</template>

<script setup>
    import { onMounted, ref } from 'vue';
    import status from '../utils/translate.json';

    const props = defineProps({
        missionStatus: String,
        remuneration: String,
        refused: Boolean,
    });

    const statusTranslate = ref('');

    onMounted(() => {
        if (status.mission_status[props.missionStatus]) {
            statusTranslate.value = status.mission_status[props.missionStatus].translate;
        }
    });
</script>