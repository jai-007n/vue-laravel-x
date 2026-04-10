<script setup>
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TableList from './Partials/TableList.vue';
import Pagination from '@/Components/pagination/ellipse.vue';
import { ref, watch, onMounted } from 'vue';
import { router } from '@inertiajs/vue3';
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

const results = ref([])
console.log(props.vendors)
const items = ref([props.vendors?.data || []])
let timeout = null

const onInput = () => {
    clearTimeout(timeout)

    timeout = setTimeout(async () => {
        if (!search.value) {
            results.value = []
            return
        }

        router.get(route('vendor.autoComplete'), { search: search.value }, {
            preserveState: true,
            replace: true,
            onSuccess: (page) => {
                console.log(page?.props)
                results.value = page.props?.vendors?.data
            }
        });
        // const res = await axios.get('/api/vendors/autocomplete', {
        //     params: { q: search.value }
        // })
    }, 300) // debounce
}

const selectss = (item) => {
    search.value = item.name
    results.value = []
}

const select = debounce((item) => {
    console.log(item)
    search.value = item.name
    router.get(route('vendor.list'), { search: item.name }, {
        preserveState: true,
        replace: true,
        only: ['vendors'],
        onSuccess: (page) => {
            items.value = page.props?.vendors?.data
        }
    });
    results.value = []
}, 300);

const loading = ref(false);

onMounted(() => {
    router.on('start', () => loading.value = true);
    router.on('finish', () => loading.value = false);
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
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8 autoComplete">
                <!-- Search -->
                <input v-model="search" @input="onInput" placeholder="Search..."
                    class="border rounded-md p-2 mb-4 w-1/4" />
                <ul v-if="results?.length" class="dropdown">
                    <li v-for="item in results" :key="item.id" @click="select(item)">
                        {{ item.name }}
                    </li>
                </ul>
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

                                    <tr v-for="(vendor, index) in items" :key="vendor.id">
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
