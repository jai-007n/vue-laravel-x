<template>
    <div class="flex flex-wrap gap-1 mt-4">
        <template v-for="(link, key) in links" :key="key">

            <button v-if="link.url" @click="visit(link.url)" v-html="link.label" :class="[
                'px-3 py-1 border rounded',
                link.active ? 'bg-blue-500 text-white' : 'bg-white'
            ]" />

            <span v-else v-html="link.label" class="px-3 py-1 text-gray-400" />

        </template>
    </div>
</template>

<script setup>
import { router } from '@inertiajs/vue3';

defineProps({
    links: Array
});

const visit = (url) => {
    router.visit(url, {
        preserveScroll: true,
        preserveState: true
    });
};
</script>