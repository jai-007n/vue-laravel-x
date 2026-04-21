<script setup>
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TableList from './Partials/TableList.vue';
import Pagination from '@/Components/pagination/ellipse.vue';
import { ref, watch, onMounted } from 'vue';
import { router } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3'
import { useToast } from 'vue-toastification'

const toast = useToast()
const page = usePage()

const roomId = ref(1);

watch(
    () => page.props,
    (props) => {
        const flash = props.flash

        if (flash?.success) {
            toast.success(flash.success)
        }

        if (flash?.error) {
            toast.error(flash.error)
        }
    },
    { deep: true, immediate: true }
)
const props = defineProps({
    vendors: {
        type: Object,
        default: () => ({ data: [] })
    },
    filters: Object
});

const search = ref(props.filters.search || '');
import debounce from 'lodash/debounce';

const updateSearch = debounce(() => {
    router.get(route('vendor.list'), { search: search.value }, {
        preserveState: true,
        replace: true
    });
}, 300);

const loading = ref(false);

onMounted(() => {
    router.on('start', () => loading.value = true);
    router.on('finish', () => loading.value = false);

    window.Echo.channel('chat')
        .listen('MessageSent', (e) => {
            console.log('New message:', e.message);
            toast.success(e.message)

            // axios.post('/api/message-received', {
            //     id: e.id
            // });
        });

    window.Echo.private(`room.${roomId.value}`)
        .listen('MessageSent', (e) => {
            console.log('New message:', e.message);
            toast.success(e.message.message)
        });
});
</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Vendors List
            </h2>
        </template>

        <div v-if="loading" class="text-center py-2">
            Loading...
        </div>

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <!-- Search -->
                <input v-model="search" @input="updateSearch" placeholder="Search..."
                    class="border rounded-md p-2 mb-4 w-1/4" />
            </div>
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <Link :href="route('vendor.create')"
                                class="border-indigo-400 text-gray-900 focus:border-indigo-700  items-center inline-flex">
                                Add Vendor
                            </Link>
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-200">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Name</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Email</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Mobile</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody className="bg-white divide-y divide-gray-200">

                                    <tr v-for="(vendor, index) in vendors?.data || []" :key="vendor?.id">
                                        <TableList :vendor="vendor" />
                                    </tr>
                                </tbody>
                                <Pagination :currentPage="vendors.current_page" :lastPage="vendors.last_page"
                                    route-name="vendor.list" :query="{ search: search }" />
                            </table>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
