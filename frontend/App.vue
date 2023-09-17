<script setup>
import { RouterView } from "vue-router";
import { onBeforeMount, onMounted } from "vue";
import { storeToRefs } from "pinia";
import myHeader from "./components/header.vue";
import lSidebar from "./components/lSidebar.vue";
import { useUserStore } from "./stores/user";
import { useBaseStore } from "./stores/base";
import overlay from "./components/overlay.vue";

const userStore = useUserStore();
const baseStore = useBaseStore();

const { overlayVisible } = storeToRefs(baseStore);

onBeforeMount(() => {
  console.log("before mounted");
  overlayVisible.value = true;
});

onMounted(() => {
  console.log("mounted");
  overlayVisible.value = false;
});

userStore.fetchInfor();

</script>

<template>
  <my-header></my-header>
  <l-sidebar></l-sidebar>

  <div class="relative left-[20rem] mt-[4rem] w-[calc(100vw-21rem)] max-lg:left-0 max-lg:w-[100vw]">
    <overlay v-if="overlayVisible"></overlay>
    <RouterView />
  </div>
</template>

<style scoped></style>
