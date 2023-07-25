<template>
    <i @click="toggleMobileMenu = true" v-if="toggleMobileMenu === false" class="h-14 cursor-pointer fa-solid fa-bars pt-3 pl-4 text-lg md:hidden"></i>
    <section :class="toggleMobileMenu === false ? 'md:flex flex-col md:flex-row md:justify-between px-4 pt-3 md:pt-0 md:px-10 md:items-center h-screen md:h-full bg-white md:bg-none hidden' : 'flex flex-col md:flex-row md:justify-between px-4 pt-3 md:pt-0 md:px-10 md:items-center h-screen md:h-auto bg-white md:bg-none'">
        <i @click="toggleMobileMenu = false" v-if="toggleMobileMenu === true" class="cursor-pointer fa-solid fa-xmark text-lg md:hidden"></i>
        <Link :href="route('dashboard')">
            <h2 class="mt-4 md:mt-0 text-3xl font-extrabold">Laravel jobs</h2>
        </Link>
        <nav>
            <ul class="flex flex-col md:flex-row">
                <Link :href="route('dashboard')"><li :class="position === 'dashboard' ? 'text-2xl md:text-base mt-10 md:mt-0 ml-4 hover:text-secondary hover:transition-colors transition-colors font-bold underline' : 'text-2xl md:text-base mt-10 md:mt-0 ml-4 hover:text-secondary hover:transition-colors transition-colors'">Dashboard</li></Link>
                <Link v-if="$page.props.auth.user.role === 'freelance'" :href="route('mission.list')"><li :class="position === 'jobslist' ? 'text-2xl md:text-base mt-3 md:mt-0 ml-4 hover:text-secondary hover:transition-colors transition-colors font-bold underline' : 'text-2xl md:text-base mt-3 md:mt-0 ml-4 hover:text-secondary hover:transition-colors transition-colors'">Toutes les missions</li></Link>
                <Link :href="route('messaging.list')"><li :class="position === 'message' ? 'text-2xl md:text-base mt-3 md:mt-0 ml-4 hover:text-secondary hover:transition-colors transition-colors font-bold underline' : 'text-2xl md:text-base mt-3 md:mt-0 ml-4 hover:text-secondary hover:transition-colors transition-colors'">Mes messages</li></Link>
                <Link :href="route('profile.edit')"><li :class="position === 'profile' ? 'text-2xl md:text-base mt-3 md:mt-0 ml-4 hover:text-secondary hover:transition-colors transition-colors font-bold underline' : 'text-2xl md:text-base mt-3 md:mt-0 ml-4 hover:text-secondary hover:transition-colors transition-colors'">Mon compte</li></Link>
                <Link :href="route('logout')" method="post"><li class="text-2xl md:text-base mt-3 md:mt-0 ml-4 hover:text-secondary hover:transition-colors transition-colors">Se deconnecter</li></Link>
            </ul>
        </nav>
    </section>
</template>

<script setup>
    import { Link } from '@inertiajs/vue3';
    import { ref } from 'vue';

    const props = defineProps({
        position: String,
    });

    const toggleMobileMenu = ref(false);
</script>