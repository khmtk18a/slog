<script setup>
import { ref } from "vue";
import { useArticleStore } from "../stores/article";

const emits = defineEmits(["close", "search"]);
const articleStore = useArticleStore();
const searchValue = ref();
function handleSearch(keyword) {
  articleStore.search(keyword)
}
</script>
<template>
  <div class="fixed left-0 top-0 z-[100] h-[100vh] w-[100vw] bg-overlay-color" @click.self="emits('close')">
    <div class="relative w-full bg-white pt-[1rem] pb-[0rem] ">
      <i
        class="pi pi-search absolute top-[calc(50%+0.5rem)] ml-[3rem] translate-y-[-50%] text-[1.5rem] text-title-text-color"></i>
      <input v-model="searchValue" type="text"
        class="ml-[2rem] w-[calc(100vw-5rem)] rounded-[0.5rem] border-[1px] border-border-color px-[1rem]  py-[0.75rem] pl-[3rem] text-[1rem] text-normal-text-color outline-green-btn-text-color"
        @keypress.enter="handleSearch(searchValue)" />
      <div
        class="absolute w-full min-h-[5rem] bg-white py-[1rem] px-[2rem] top-full overflow-y-auto my-scrollbar max-h-[70vh]">
        <div class="m-auto w-fit" v-if="articleStore.searchResults === null">
          <i class="pi pi-spin pi-spinner text-[1.5rem]"></i>
        </div>
        <span v-if="articleStore.searchResults && articleStore.searchResults.length == 0">
          Không tìm thấy kết quả phù hợp
        </span>
        <ul v-if="articleStore.searchResults">
          <li v-for="sr in articleStore.searchResults">
            <a :href="`/article/${sr.id}`" class="py-[0.25rem] hover:bg-normal-btn-hover block">{{ sr.title }}</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>


<style scoped>
.my-scrollbar::-webkit-scrollbar {
  margin-left: -15px;
  width: 4px;
  /* Độ rộng của thanh cuộn */
  height: 6px;
  /* Chiều cao của thanh cuộn (chỉ áp dụng cho thanh cuộn ngang) */
}

.my-scrollbar::-webkit-scrollbar-thumb {
  background-color: #86efac;
  /* Màu sắc của thanh cuộn */
  border-radius: 4px;
  /* Độ cong viền của thanh cuộn */
}

.my-scrollbar::-webkit-scrollbar-track {
  opacity: 1;
}
</style>
