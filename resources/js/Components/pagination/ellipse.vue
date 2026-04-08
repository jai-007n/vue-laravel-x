<template>
  <div class="flex items-center gap-1 mt-4 flex-wrap">

    <!-- Prev -->
    <button
      :disabled="!hasPrev"
      @click="go(currentPage - 1)"
      class="px-3 py-1 border rounded disabled:opacity-50"
    >
      Prev
    </button>

    <!-- First Page -->
    <button
      v-if="pages[0] !== 1"
      @click="go(1)"
      class="px-3 py-1 border rounded"
    >
      1
    </button>

    <!-- Left dots -->
    <span v-if="showLeftDots">...</span>

    <!-- Middle Pages -->
    <button
      v-for="page in pages"
      :key="page"
      @click="go(page)"
      :class="[
        'px-3 py-1 border rounded',
        page === currentPage ? 'bg-blue-500 text-white' : ''
      ]"
    >
      {{ page }}
    </button>

    <!-- Right dots -->
    <span v-if="showRightDots">...</span>

    <!-- Last Page -->
    <button
      v-if="pages[pages.length - 1] !== lastPage"
      @click="go(lastPage)"
      class="px-3 py-1 border rounded"
    >
      {{ lastPage }}
    </button>

    <!-- Next -->
    <button
      :disabled="!hasNext"
      @click="go(currentPage + 1)"
      class="px-3 py-1 border rounded disabled:opacity-50"
    >
      Next
    </button>

  </div>
</template>

<script setup>
import { computed } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
  currentPage: Number,
  lastPage: Number,
 routeName: {
    type: String,
    required: true
  },
  query: { // optional extra query parameters like search
    type: Object,
    default: () => ({})
  }
});

const windowSize = 5;

const pages = computed(() => {
  let start = Math.max(1, props.currentPage - Math.floor(windowSize / 2));
  let end = start + windowSize - 1;

  if (end > props.lastPage) {
    end = props.lastPage;
    start = Math.max(1, end - windowSize + 1);
  }

  return Array.from({ length: end - start + 1 }, (_, i) => start + i);
});

const showLeftDots = computed(() => pages.value[0] > 2);
const showRightDots = computed(() => pages.value.at(-1) < props.lastPage - 1);

const hasPrev = computed(() => props.currentPage > 1);
const hasNext = computed(() => props.currentPage < props.lastPage);

const go = (page) => {
  router.get(route(props.routeName), {...props.query, page }, {
    preserveState: true,
    preserveScroll: true
  });
};
</script>