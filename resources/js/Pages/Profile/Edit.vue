<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import Menu from '@/Components/Menu.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
</script>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <template #header>
            <Menu position="profile"/>
        </template>
        
        <template #main>
            <h1 class="title mb-12 mt-8 ml-4">Mon compte</h1>
            <div>
                <div class="max-w-7xl mx-auto space-y-6">
                    <div class="p-4 sm:p-10 bg-white shadow-lg rounded-lg mb-10">
                        <UpdateProfileInformationForm
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                        class=""
                        />
                    </div>
                    
                    <div class="p-4 sm:p-10 bg-white shadow-lg rounded-lg mb-10">
                        <UpdatePasswordForm class="" />
                    </div>
                    
                    <!-- <div class="p-4 sm:p-8 bg-white shadow-lg rounded-lg">
                        <DeleteUserForm class="" />
                    </div> -->
                </div>
            </div>
        </template>
    </AuthenticatedLayout>
</template>
