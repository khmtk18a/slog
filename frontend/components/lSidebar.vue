<script setup>
import { ref } from "vue";
import { useLSidebarStore } from "../stores/lSidebar";
import { useTagStore } from "../stores/tag";
import { useArticleStore } from "../stores/article";
import { useRouter } from "vue-router";
const lSidebarStore = useLSidebarStore();
const articleStore = useArticleStore();

const tagStore = useTagStore();
const isHover = ref(false);
const router = useRouter();
function handleChangeRoute(nextRoute) {
  if (nextRoute == "/hot") {
    articleStore.sortBy = "Hot"
    articleStore.page = 1;
    articleStore.articles = [];
    nextRoute = "/"
  }
  router.push(nextRoute)

  lSidebarStore.isOpen = false
}
function handleChangeTag(id) {
  articleStore.fetchByTag(id);
  router.push("/");
  lSidebarStore.isOpen = false;
}
</script>

<template>
  <div class="fixed left-[20rem] top-[4rem] z-[110] h-full w-[100vw] bg-[rgba(0,0,0,0.2)] lg:hidden"
    v-if="lSidebarStore.isOpen" @click="lSidebarStore.isOpen = false"></div>
  <div
    class="lsidebar-transition normal-scrollbar fixed top-[4rem] z-[100] h-[calc(100vh-4rem)] w-[20rem] overflow-y-auto overflow-x-hidden border-r-[1px] border-r-line-color bg-white"
    :class="{
      'overflow-y-hidden': !isHover,
      'max-lg:left-0': lSidebarStore.isOpen,
      'max-lg:left-[-20rem]': !lSidebarStore.isOpen,
    }" @mouseenter="isHover = true" @mouseleave="isHover = false">
    <ul class="pb-[1rem] text-normal-text-color">
      <li v-for="(item, i) in lSidebarStore.items" :key="i">
        <template v-if="item.type == 'route'">
          <a @click.prevent="handleChangeRoute(item.route)"
            class="text-ntext flex w-full py-[1rem] pl-[2rem] hover:bg-normal-btn-hover active:bg-normal-btn-active">
            <i v-if="item.icon" :class="'pi pi-icons text-[1.5rem] ' + item.icon"></i>
            <span class="ml-[0.5rem]">
              {{ item.label }}
            </span>
          </a>
        </template>
        <template v-if="item.type == 'line'">
          <span class="mx-auto block h-[1px] w-[90%] bg-line-color max-lg:w-full"></span>
        </template>
        <template v-if="item.type == 'title'">
          <span class="mb-[0.5rem] ml-[1rem] mt-[1rem] block font-black leading-none text-title-text-color">
            {{ item.label }}
          </span>
        </template>
        <template v-if="item.type == 'tag-container'">
          <div class="block w-full overflow-hidden" :class="{ 'h-[10.5rem]': !lSidebarStore.isShowAllTags }">
            <div class="m-auto my-[3.25rem] block text-center" v-if="tagStore.tags.length == 0">
              <i class="pi pi-spin pi-spinner text-[2rem] text-title-text-color"></i>
            </div>
            <a v-for="(arrItem, arrIdx) in tagStore.tags" @click.prevent="handleChangeTag(arrItem.id)"
              class="text-ntext flex w-full py-[1rem] pl-[2rem] hover:bg-normal-btn-hover active:bg-normal-btn-active">
              <i class="pi pi-icons pi-hashtag text-[1.5rem]"></i>
              <span class="ml-[0.5rem]">
                {{ arrItem.name }}
              </span>
            </a>
          </div>

          <button v-if="tagStore.tags.length > 4" @click="lSidebarStore.isShowAllTags = !lSidebarStore.isShowAllTags"
            class="my-[1rem] w-[20rem] text-center font-black text-normal-text-color active:text-normal-btn-active">
            {{ lSidebarStore.isShowAllTags ? "Ẩn bớt" : "Xem thêm" }}
          </button>
        </template>
      </li>
    </ul>
  </div>
</template>

<style>
.lsidebar-transition {
  transition: left 0.2s ease;
}
</style>
