<template>
    <section class="flex justify-between">
        <Link href="/">
            <h2>LOGO</h2>
        </Link>
        <nav>
            <ul class="flex">
                <Link href="/"><li :class="position === 'dashboard' ? 'ml-4 font-bold underline' : 'ml-4'">Dashboard</li></Link>
                <Link v-if="$page.props.auth.user.role === 'freelance'" href="/mission"><li :class="position === 'jobslist' ? 'ml-4 font-bold underline' : 'ml-4'">Toutes les missions</li></Link>
                <Link href="/messagerie"><li :class="position === 'message' ? 'ml-4 font-bold underline' : 'ml-4'">Mes messages</li></Link>
                <Link href="#"><li :class="position === 'profil' ? 'ml-4 font-bold underline' : 'ml-4'">Mon compte</li></Link>
                <Link :href="route('logout')" method="post"><li class="ml-4">Se deconnecter</li></Link>
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