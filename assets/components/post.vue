<script lang="ts" setup>
defineProps<{ data: Post }>()
</script>

<template>
  <div>
    <h2>{{ data.title }}</h2>
    <p>{{ data.content }}</p>
  </div>
</template>
