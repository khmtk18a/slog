<script lang="ts" setup>
defineProps<{ data: Post }>()
</script>

<template>
  <div>
    <h2>{{ data.title }}</h2>
    <h3>{{ data.user.name }}</h3>
    <p>{{ data.content }}</p>
  </div>
</template>
