<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import UpdateVendorForm from './Partials/UpdateVendorForm.vue';

</script>
<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Vendor Create
            </h2>

        </template>
        <div className="py-12">
            <div className="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">

                <div className="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                    <UpdateVendorForm vendor={vendor} edit={edit} className="max-w-xl" />
                </div>

                <div className="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                    <DeleteUserForm className="max-w-xl" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>