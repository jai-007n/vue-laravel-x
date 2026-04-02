<script setup>
import { Link } from '@inertiajs/vue3';
import DangerButton from '@/Components/DangerButton.vue';
import axios from 'axios';
import { ref } from 'vue';

const props = defineProps({
  vendor: {
    type: Object,
    required: true
  }
});

console.log(props.vendor)
const handleDelete = async (id) => {
    if (confirm('Are you sure you want to delete this record?')) {
        try {
            await axios.post(route('vendor.destroy', id)).onSuccess(() => {
                console.log('Vendor deleted successfully');
            }).onError((errors) => {
                console.error(errors);
            }) //
            console.log(response.data);
            // Handle success (e.g., show a notification)
        } catch (error) {
            console.error("Error updating status:", error);
            // Handle error
        }
    }
};
</script>
<template>


    <td className="px-6 py-4 whitespace-nowrap">{{ vendor.name }}</td>
    <td className="px-6 py-4 whitespace-nowrap">{{ vendor.email }}</td>
    <td className="px-6 py-4 whitespace-nowrap">{{ vendor.mobile }}</td>
    <td className="px-6 py-4 whitespace-nowrap">
        <Link title="edit" :href="route('vendor.edit', vendor.id)"
            className="p-1 pl-4 mr-1 inline-block pr-4 bg-white border border-purple-400 rounded text-purple-800 font-medium">
            Edit
        </Link>
        <DangerButton @Click="handleDelete(vendor.id)">
            Delete
        </DangerButton>
    </td>


</template>