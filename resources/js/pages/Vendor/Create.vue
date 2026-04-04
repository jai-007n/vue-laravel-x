<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import UpdateVendorForm from './Partials/UpdateVendorForm.vue';
// import DeleteUserForm from './Partials/DeleteUserForm.vue';
const props = defineProps({
  vendor: {
    required: true
  }
});
</script>


<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Vendor Create
            </h2>

        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">

                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                    <UpdateVendorForm 
                    :vendor="vendor"
                    class="max-w-xl" />
                </div>

                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                    <!-- <DeleteUserForm class="max-w-xl" /> -->
                </div> 
            </div>
        </div>
    </AuthenticatedLayout>
</template>
