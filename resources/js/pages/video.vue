<template>
    <div class="p-4">
        <video controls class="w-full max-w-3xl rounded" :src="videoUrl" />
    </div>
</template>

<script setup>
const videoUrl = '/video/stream'
</script>