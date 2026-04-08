<template>
  <div class="mt-4 flex justify-between items-center flex-wrap gap-2">

    <!-- Prev Button -->
    <button
      :disabled="!prevUrl || loading"
      @click="go(prevUrl)"
      class="px-4 py-2 border rounded disabled:opacity-50"
    >
      {{ loading && lastClicked === 'prev' ? 'Loading...' : 'Prev' }}
    </button>

    <!-- Next Button -->
    <button
      :disabled="!nextUrl || loading"
      @click="go(nextUrl)"
      class="px-4 py-2 border rounded disabled:opacity-50"
    >
      {{ loading && lastClicked === 'next' ? 'Loading...' : 'Next' }}
    </button>

  </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import NProgress from 'nprogress';

const props = defineProps({
  data: { type: Object, required: true }, // cursor-paginated object
  routeName: { type: String, required: true },
  query: { type: Object, default: () => ({}) }
});

const loading = ref(false);
const lastClicked = ref(null);

const nextUrl = ref(props.data.next_page_url);
const prevUrl = ref(props.data.prev_page_url);

// Watch for updates from parent
watch(() => props.data, (newData) => {
  nextUrl.value = newData.next_page_url;
  prevUrl.value = newData.prev_page_url;
});

// Navigate
const go = (url) => {
  if (!url) return;
  lastClicked.value = url === nextUrl.value ? 'next' : 'prev';
  loading.value = true;
  NProgress.start();

  router.get(url, { ...props.query }, {
    preserveScroll: true,
    preserveState: true,
    onFinish: () => {
      loading.value = false;
      NProgress.done();
    }
  });
};
</script>