<script lang="ts" setup>
import './main.css'
import { useUserStore } from './store/user'

const userStore = useUserStore()
userStore.fetchUser()

</script>

<template>
  <h1 v-if="userStore.user">{{ userStore.user.name }}</h1>
  <RouterView></RouterView>
</template>

<style scoped></style>
