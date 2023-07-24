<template>
    <section class="flex justify-between px-10 items-center h-full">
        <Link :href="route('dashboard')">
            <h2 class="text-3xl font-extrabold">Laravel jobs</h2>
        </Link>
        <nav>
            <ul class="flex">
                <Link :href="route('dashboard')"><li :class="position === 'dashboard' ? 'ml-4 hover:text-secondary hover:transition-colors transition-colors font-bold underline' : 'ml-4 hover:text-secondary hover:transition-colors transition-colors'">Dashboard</li></Link>
                <Link v-if="$page.props.auth.user.role === 'freelance'" :href="route('mission.list')"><li :class="position === 'jobslist' ? 'ml-4 hover:text-secondary hover:transition-colors transition-colors font-bold underline' : 'ml-4 hover:text-secondary hover:transition-colors transition-colors'">Toutes les missions</li></Link>
                <Link :href="route('messaging.list')"><li :class="position === 'message' ? 'ml-4 hover:text-secondary hover:transition-colors transition-colors font-bold underline' : 'ml-4 hover:text-secondary hover:transition-colors transition-colors'">Mes messages</li></Link>
                <Link :href="route('profile.edit')"><li :class="position === 'profile' ? 'ml-4 hover:text-secondary hover:transition-colors transition-colors font-bold underline' : 'ml-4 hover:text-secondary hover:transition-colors transition-colors'">Mon compte</li></Link>
                <Link :href="route('logout')" method="post"><li class="ml-4 hover:text-secondary hover:transition-colors transition-colors">Se deconnecter</li></Link>
            </ul>
        </nav>
    </section>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

    const props = defineProps({
        position: String,
    });
</script>