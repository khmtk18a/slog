<script setup>
import { onMounted, nextTick } from "vue";
import articleFilter from "../components/articleFilter.vue";
import articleSkeleton from "../components/articleSkeleton.vue";
import myArticle from "../components/article.vue";

import { useBaseStore } from "../stores/base";
import { useTagStore } from "../stores/tag";
import { useLSidebarStore } from "../stores/lSidebar";
import { useArticleStore } from "../stores/article";


const baseStore = useBaseStore();
const tagStore = useTagStore();
const lSidebarStore = useLSidebarStore();
const articleStore = useArticleStore();

if (lSidebarStore.status != "user-view") {
  lSidebarStore.initUserView();
  tagStore.fetchTags();
}

articleStore.tag = null;
baseStore.fetchQuote();

onMounted(async () => {
  const options = {
    root: null,
    rootMargin: "0px",
    threshold: 0.5,
  };

  const observer = new IntersectionObserver(handleIntersection, options);
  function handleIntersection(entries, _) {
    entries.forEach((entry) => {
      if (entry.isIntersecting && entry.intersectionRatio > 0) {
        articleStore.fetchArticles();
      }
    });
  }
  await nextTick();
  const skeleton = document.getElementById("user-skeleton");
  observer.observe(skeleton);
});
</script>

<template>
  <div class="relative flex w-full">
    <div class="flex-1 px-[1rem]">
      <article-filter></article-filter>
      <div class="w-full">
        <template v-for="article in articleStore.articles">
          <my-article :article="article"></my-article>
          <span class="my-[1rem] block h-[1px] w-full bg-line-color"></span>
        </template>
        <article-skeleton></article-skeleton>
        <template v-if="articleStore.articles.length == 0">
          <span class="my-[1rem] block h-[1px] bg-line-color"></span>
          <article-skeleton></article-skeleton>
        </template>
      </div>
    </div>
    <div class="relative h-[calc(100vh-4rem)] w-[20rem] px-[1rem] pr-[2rem] pt-[2rem] max-lg:hidden">
      <div class="flex w-auto flex-col items-center rounded-[1rem] bg-normal-bg py-[2rem] text-title-text-color">
        <div class="m-auto">
          <i class="pi pi-spin pi-spinner text-[2rem] text-title-text-color" v-if="!baseStore.quote"></i>
        </div>
        <template v-if="baseStore.quote">
          <span class="mx-auto block text-[1.2rem] font-semibold"> Quote </span>
          <img src="@/assets/svg/anonymous.svg" class="my-[1rem] h-[5rem] w-[5rem] rounded-[2.5rem] bg-normal-btn-bg"
            alt="" />
          <span class="block w-full pl-[1.5rem] text-[1rem]">
            {{ baseStore.quote.content }}
            <!-- <span class="font-semibold">Tên:</span>
            <span class="ml-[0.5rem]"></span> -->
          </span>
          <span class="block w-full  text-[1rem] text-center font-semibold">
            {{ baseStore.quote.author }}
          </span>
        </template>
      </div>
    </div>
  </div>
</template>
