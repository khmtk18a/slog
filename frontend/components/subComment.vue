<script setup>
import { useRoute } from "vue-router"
import { useUserStore } from "../stores/user";
import { useCommentStore } from "../stores/comment";

const { comment } = defineProps(["comment"]);
const userStore = useUserStore();
const commentStore = useCommentStore();

const route = useRoute();

function handleDeleteUser() {
  console.log("Delete user: ");
}

function handleDeleteReply(_id) {
  commentStore.deleteComment(_id, `/${route.params.id}`, comment.parent.split("/").at(-1));
}

</script>
<template>
  <div class="mb-[0rem] flex flex-col items-start text-normal-text-color">
    <span class="relative flex w-full justify-between">
      <div class="flex items-start">
        <img class="h-[2rem] w-[2rem] rounded-[2rem] bg-gray-300" :src="comment.user.photo" alt="" />
        <span class="ml-[0.5rem] block leading-none">
          {{ comment.user.name }}
          {{ comment.createdAt }}
        </span>
      </div>
      <button
        class="editbox-openbtn z-[20] h-[2rem] w-[2rem] rounded-[1rem] hover:bg-normal-btn-hover focus:bg-normal-btn-hover active:bg-normal-btn-active"
        v-if="userStore.isAdmin">
        <i class="pi pi-ellipsis-v"></i>
      </button>
      <div v-if="userStore.isAdmin"
        class="editbox absolute right-0 top-[calc(100%+0.5rem)] z-30 w-[10rem] bg-gray-50 py-[0.5rem] shadow-md">
        <button
          class="block w-full px-[1rem] py-[0.5rem] text-left text-[1rem] text-error-color hover:bg-normal-btn-hover active:bg-normal-btn-active disabled:bg-normal-btn-hover disabled:text-green-btn-text-color"
          @click="handleDeleteUser">
          Xóa tài khoản
        </button>
      </div>
    </span>

    <span class="mb-[0.5rem] ml-[2.5rem] w-full pr-[2.5rem]">
      {{ comment.content }}
    </span>
    <span class="ml-[2.5rem] flex w-full justify-end pr-[3.5rem]">
      <button
        class="z-20 ml-[0.5rem] flex w-fit items-center rounded-[1rem] border-[1px] border-error-color px-[1rem] py-[0.5rem] text-[1rem] leading-none text-error-color hover:bg-red-200 active:bg-red-300"
        @click="handleDeleteReply(comment.id)" v-if="userStore.isAdmin">
        <i class="pi pi-trash mr-[0.25rem]"></i>
        <span>Xóa</span>
      </button>
    </span>
  </div>
</template>

<style scoped>
.editbox-openbtn:focus+.editbox {
  display: block;
}

.editbox {
  display: none;
}

.editbox:hover {
  display: block;
}
</style>
