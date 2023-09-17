<script setup>
import { onMounted, ref, watch, nextTick, computed } from "vue";
import card from "../assets/svg/card.vue";
import classic from "../assets/svg/classic.vue";

import { useArticleStore } from "../stores/article";
import { storeToRefs } from "pinia";

const articleStore = useArticleStore();

const { viewType, sortBy } = storeToRefs(articleStore);

const sortboxItems = ref(["New", "Hot"]);

sortBy.value = window.localStorage.getItem("sortBy") || "New";
viewType.value = window.localStorage.getItem("viewType") || "Card";

const viewTypeIcon = computed(() => {
  return viewType.value == "Card" ? "pi-card" : "pi-classic";
});

async function handleChangeSortBy(event) {
  sortBy.value = event.target.textContent;
  articleStore.page = 1;
  articleStore.articles = [];
  window.localStorage.setItem("sortBy", sortBy.value);
}

function handleChangeViewType(newValue) {
  viewType.value = newValue;
  window.localStorage.setItem("viewType", viewType.value);
}
</script>

<template>
  <div class="flex w-full items-center justify-between py-[0.5rem] text-normal-text-color">
    <div class="relative flex items-center">
      <span class="mr-[0.5rem] text-[1rem]">Sắp xếp theo:</span>
      <button
        class="sortbox-openbtn flex items-center rounded-[1rem] px-[0.5rem] py-[0.25rem] text-[1rem] hover:bg-normal-btn-hover focus:bg-normal-btn-hover active:bg-normal-btn-active">
        <span class="">{{ sortBy }}</span>
        <i class="pi pi-chevron-down ml-[0.25rem] text-[0.75rem]"></i>
      </button>
      <div class="sortbox absolute right-0 top-[2.5rem] z-30 w-[10rem] bg-gray-50 py-[0.5rem] shadow-md"
        @click="handleChangeSortBy">
        <button
          class="block w-full px-[1rem] py-[0.5rem] text-left text-[1rem] hover:bg-normal-btn-hover active:bg-normal-btn-active disabled:bg-normal-btn-hover disabled:text-green-btn-text-color"
          v-for="item in sortboxItems" :disabled="item == sortBy">
          {{ item }}
        </button>
      </div>
    </div>
    <span class="mx-[0.5rem] block h-[1px] flex-1 bg-line-color"></span>
    <span class="relative">
      <button
        class="viewbox-openbtn flex items-center rounded-[1rem] px-[0.5rem] py-[0.25rem] hover:bg-normal-btn-hover focus:bg-normal-btn-hover active:bg-normal-btn-active">
        <i :class="'pi text-normal-text-color ' + viewTypeIcon"></i>
        <i class="pi pi-chevron-down ml-[0.25rem] text-[0.75rem]"></i>
      </button>
      <div class="viewbox absolute right-0 top-[2.5rem] z-30 w-[10rem] bg-gray-50 py-[0.5rem] shadow-md">
        <button
          class="flex w-full items-center px-[1rem] py-[0.5rem] text-left text-[1rem] hover:bg-normal-btn-hover active:bg-normal-btn-active disabled:bg-normal-btn-hover disabled:text-green-btn-text-color"
          :disabled="'Card' == viewType" @click="handleChangeViewType('Card')">
          <card :class="{ 'bg-black text-white': 'Card' == viewType }"></card>
          <span class="ml-[0.5rem]"> Card </span>
        </button>
        <button
          class="flex w-full items-center px-[1rem] py-[0.5rem] text-left text-[1rem] hover:bg-normal-btn-hover active:bg-normal-btn-active disabled:bg-normal-btn-hover disabled:text-green-btn-text-color"
          :disabled="'Classic' == viewType" @click="handleChangeViewType('Classic')">
          <classic :class="{ 'bg-black text-white': 'Classic' == viewType }"></classic>
          <span class="ml-[0.5rem]"> Classic </span>
        </button>
      </div>
    </span>
  </div>
</template>

<style>
.sortbox-openbtn:focus+.sortbox {
  display: block;
}

.sortbox {
  display: none;
}

.sortbox:hover {
  display: block;
}

.sortbox:focus::after {
  display: none;
}

.viewbox-openbtn:focus+.viewbox {
  display: block;
}

.viewbox {
  display: none;
}

.viewbox:hover {
  display: block;
}
</style>
