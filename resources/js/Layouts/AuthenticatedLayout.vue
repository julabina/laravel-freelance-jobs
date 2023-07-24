<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-200">

            <header v-if="$slots.header" class="md:h-16 bg-white shadow">
                <div class="h-full max-w-7xl mx-auto">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main class="w-full grow max-w-7xl mx-auto px-4 pb-8 sm:px-6 lg:px-8">
                <slot name="main"/>
            </main>
        </div>
    </div>
</template>