<script setup>
import { storeToRefs } from "pinia";
import { useRoute } from "vue-router";
import { ref, computed, onMounted } from "vue";
import { useVuelidate } from "@vuelidate/core";
import { required, minLength } from "@vuelidate/validators";
import { formatDistanceToNow } from "date-fns";
import { toast } from "vue3-toastify";

import { useArticleStore } from "../stores/article";
import { useLSidebarStore } from "../stores/lSidebar";
import { useCommentStore } from "../stores/comment";
import { useUserStore } from "../stores/user";
import { useTagStore } from "../stores/tag"
import commentFilter from "../components/commentFilter.vue";
import comment from "../components/comment.vue";
import recommend from "../components/recommend.vue";

const route = useRoute();
const articleStore = useArticleStore();
const lSidebarStore = useLSidebarStore();
const commentStore = useCommentStore();
const userStore = useUserStore();
const tagStore = useTagStore();

const { article } = storeToRefs(articleStore);
const { comments, isTyping } = storeToRefs(commentStore);
const showAll = ref(false);
const isHover = ref(false);
const commentValue = ref("");

onMounted(() => {
  window.scrollTo(0, 0);

})


const commentRules = computed(() => {
  return {
    commentValue: {
      required,
      minLength: minLength(1),
    },
  };
});
const $v1 = useVuelidate(commentRules, { commentValue });


if (lSidebarStore.status != "user-view") {
  lSidebarStore.initUserView();
  tagStore.fetchTags();
}
articleStore.fetchArticle(route.params.id);
articleStore.fetchRecommends();
commentStore.firstFetch(route.params.id);

const agoTime = computed(() => {
  if (article.value.createdAt) {
    return formatDistanceToNow(new Date(article.value.createdAt), {
      addSuffix: true,
    });
  }
  return 0;
});


async function handleComment() {
  const isValid = await $v1.value.$validate();
  if (!$v1.value.commentValue.$error) {
    if (userStore.info) {
      commentStore.postComment(userStore.info.id, commentValue.value, `/api/posts/${route.params.id}`);
      commentValue.value = "";
      $v1.value.$reset()
    } else {
      toast.error("Bạn chưa đăng nhập", { autoClose: 2000 })
    }
  }
}

</script>

<template>
  <div class="relative flex w-full text-normal-text-color max-lg:flex-col">
    <div class="flex-1 px-[1rem] py-[1rem] max-lg:pr-[2rem] " :class="{ 'flex flex-col': !article }">
      <div class="m-auto w-fit h-fit" v-if="!article">
        <i class="pi pi-spin pi-spinner text-[3rem] font-semibold"></i>
      </div>
      <template v-if="article">
        <div class="flex items-start text-normal-text-color">
          <img class="h-[2rem] w-[2rem] rounded-[2rem] bg-gray-300" :src="article.user ? article.user.photo : ''"
            alt="" />
          <span class="ml-[0.5rem] block leading-none">
            {{ article.user ? article.user.name : "" }} &nbsp • &nbsp
            {{ agoTime }}
          </span>
        </div>
        <span class="my-[0.5rem] block text-[1.5rem] font-semibold text-title-text-color">{{ article.title }}</span>
        <div :innerHTML="article.content" class="overflow-y-hidden text-justify"></div>
        <div class="h-boxshadow relative mt-[-4rem] h-[4rem] w-full px-[1rem]" v-if="article.toHide && showAll == false">
        </div>
        <a @click.prevent="showAll = true" class="mb-[0.5rem] block cursor-pointer text-blue-500"
          v-if="article.toHide && showAll == false">Xem toàn bộ</a>
        <div class="mt-[0.5rem] flex items-center">
          <span
            class="flex w-fit items-center rounded-[1rem] bg-green-100 px-[1rem] py-[0.25rem] text-[1rem] text-normal-text-color">
            <button class="z-20 leading-none hover:bg-normal-btn-hover active:bg-normal-btn-active"
              @click="articleStore.postVote(1, article.id)">
              <i class="pi pi-arrow-up"></i>
            </button>
            <span class="z-20 mx-[0.25rem]">{{ article.score }}</span>
            <button class="z-20 leading-none hover:bg-normal-btn-hover active:bg-normal-btn-active"
              @click="articleStore.postVote(-1, article.id)">
              <i class="pi pi-arrow-down"></i>
            </button>
          </span>
          <!-- <button
          class="z-20 ml-[0.5rem] flex w-fit items-center rounded-[1rem] bg-green-100 px-[1rem] py-[0.25rem] text-[1rem] text-normal-text-color hover:bg-normal-btn-hover active:bg-normal-btn-active"
          @click="handleViewComments">
          <i class="pi pi-comments"></i>
          <span>{{ article.comments }}</span>
        </button> -->
        </div>
        <comment-filter :comments="article.comments"></comment-filter>

        <span class="relative block">
          <textarea
            class="w-full resize-none rounded-[1rem]  border-[2px] border-border-color px-[1rem] py-[0.25rem] text-[1rem] text-normal-text-color outline-normal-btn-active"
            :class="{ 'outline-red-500 border-red-500': $v1.commentValue.$error }" placeholder="Comment..." rows="2"
            v-model="commentValue"></textarea>
          <button class="absolute right-[1rem] top-[50%] translate-y-[-50%] text-green-btn-text-color"
            @click="handleComment">
            <i class="pi text-[1.5rem]" :class="{
              'pi-spin pi-spinner': isTyping,
              ' pi-send': !isTyping
            }"></i>
          </button>
        </span>
        <span class="my-[0.5rem] block h-[1px] w-full bg-line-color"></span>
        <div class="block w-full">
          <template v-for="comment in comments">
            <comment :comment="comment"> </comment>
            <span class="my-[0.5rem] block h-[1px] w-full bg-line-color"></span>
          </template>
          <button class="text-[1rem] text-error-color" @click="commentStore.fetchComments(route.params.id)"
            v-if="comments.length < article.comments.length">
            Xem thêm
          </button>
        </div>
      </template>
    </div>
    <div class="sticky top-[4rem] h-[calc(100vh-4rem)] w-[20rem] px-[1rem] pr-[2rem] pt-[2rem] max-lg:w-full">
      <span class="mb-[1rem] block text-[1.2rem] font-semibold">
        Có thể bạn sẽ thích</span>
      <div class="m-auto w-fit h-fit" v-if="!articleStore.recommends">
        <i class="pi pi-spin pi-spinner text-[2rem]"></i>
      </div>
      <template v-if="articleStore.recommends">
        <div :class="{ 'overflow-y-hidden': !isHover }" @mouseenter="isHover = true" @mouseleave="isHover = false"
          class="normal-scrollbar sticky top-[6rem] w-full overflow-y-auto lg:h-[calc(100vh-8rem)]">
          <ul>
            <template v-for="recommend in articleStore.recommends">
              <li>
                <recommend :recommend="recommend"></recommend>
              </li>
              <span class="bg-line-color-200 mx-auto my-[1rem] block h-[1px] w-[100%] max-lg:w-full"></span>
            </template>
          </ul>
        </div>
      </template>
    </div>
  </div>
</template>

<style scoped>
.h-boxshadow {
  background-image: linear-gradient(to top,
      rgb(255, 255, 255),
      rgba(255, 255, 255, 0));
}
</style>
