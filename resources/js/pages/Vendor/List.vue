<script setup>
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TableList from './Partials/TableList.vue';
import CursorPagination from '@/Components/pagination/cursorPagination.vue';
import { ref, watch, onMounted, onUnmounted } from 'vue';
import { router } from '@inertiajs/vue3';
import NProgress from 'nprogress';
import { reactive } from 'vue';
const props = defineProps({
    vendors: Object,
    filters: Object
});

import debounce from 'lodash/debounce';

const items = ref([...props.vendors?.data]);          // store vendors initally
const nextUrl = ref(props.vendors.nextCursor || null);
const hasMore = ref(!!nextUrl.value);
const search = ref(props.filters?.search || '');
const loading = ref(false);

const itemCheck = ref(5);

const updateSearch = debounce(() => {
    items.value = [];
    nextUrl.value = null;
    loading.value = true;

    // fetch first page with new search
    router.get(route('vendor.list'), { search: search.value }, {
        preserveScroll: true,
        preserveState: true,
        only: ['vendors'],
        onSuccess: (page) => {
            if (page.props.vendors && page.props.vendors?.data.length > 0) {
                items.value = [...page.props.vendors.data];
                nextUrl.value = page.props.vendors.nextCursor || null;
                hasMore.value = !!nextCursor.value;
            } else {
                nextUrl.value = null;
            }

        },
        onFinish: () => {
            loading.value = false;
        }
    });
}, 300);

// console.log(1111,props.vendors)



const loadMore = async () => {
    if (!nextUrl.value || loading.value || !hasMore.value) return;
    loading.value = true;

    NProgress.start();
    router.get(route('vendor.list'), { cursor: nextUrl.value, search: search.value }, {
        preserveState: true,
        preserveScroll: true,
        replace: false,
        only: ['vendors'],
        replace: false,
        onSuccess: (page) => {
            // page.props.vendors contains the new data
            if (page.props.vendors?.data.length === 0) {
                hasMore.value = false; // stop infinite scroll
            } else {
                console.log("old value", items.value)
                items.value = [...items.value, ...page.props.vendors?.data];
                // items.value = [...items.value, ...page.props.vendors.data.map(v => reactive(v))];
                console.log("new value", items.value)
                nextUrl.value = page.props.vendors?.nextCursor || null;
                hasMore.value = nextUrl.value !== null;
                itemCheck.value += 5;
            }
            console.log('updated vendors length:', items.value.length, itemCheck);
        },
        onFinish: () => {
            NProgress.done();
            loading.value = false;
        }
    });
};

// onMounted(() => loadMore());

const handleScroll = debounce(() => {
    const scrollY = window.scrollY;
    const viewportHeight = window.innerHeight;
    const fullHeight = document.body.offsetHeight;

    if (scrollY + viewportHeight >= fullHeight - 300) { // 300px from bottom
        loadMore();
    }
}, 100);

onMounted(() => window.addEventListener('scroll', handleScroll));
onUnmounted(() => window.removeEventListener('scroll', handleScroll));

</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Vendors List
            </h2>
        </template>



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
                                Add Vendor {{ itemCheck }}
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

                                    <tr v-for="vendor in items" :key="vendor.id">
                                        <TableList :vendor="vendor" />
                                    </tr>
                                </tbody>
                                <!-- <Pagination :currentPage="vendors.current_page" :lastPage="vendors.last_page"
                                    route-name="vendor.list" :query="{ search: searchTerm }" /> -->
                                <!-- <CursorPagination :data="items" route-name="vendor.list"
                                    :query="{ search: search }" /> -->
                            </table>
                        </div>
                    </div>
                    <div v-if="loading" class="text-center py-2">
                        Loading...
                    </div>
                    <!-- <button v-if="hasMore && !loading" @click="loadMore">Load More</button> -->

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
