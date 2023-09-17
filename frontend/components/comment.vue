<script setup>
import { ref, computed } from "vue";
import { toast } from "vue3-toastify";
import { useUserStore } from "../stores/user";
import { useCommentStore } from "../stores/comment";
import { storeToRefs } from "pinia";
import subComment from "./subComment.vue";
import { useVuelidate } from "@vuelidate/core";
import { required, minLength } from "@vuelidate/validators";

const { comment } = defineProps(["comment"]);
const userStore = useUserStore();
const commentStore = useCommentStore();
const { isTyping } = storeToRefs(commentStore);

const replyValue = ref("");
const showReplies = ref(false);




const replyRules = computed(() => {
  return {
    replyValue: {
      required,
      minLength: minLength(1),
    },
  };
});

const $v2 = useVuelidate(replyRules, { replyValue });



function handleDeleteComment(_id) {
  // console.log(comment)
  commentStore.deleteComment(_id, comment.post)

}

function handleViewReplies() {
  console.log("View repies: ");
  showReplies.value = !showReplies.value;
}

async function handleReply(_id) {
  const isValid = await $v2.value.$validate();
  if (!$v2.value.replyValue.$error) {
    if (userStore.info) {
      commentStore.postComment(userStore.info.id, replyValue.value, null, `/api/comments/${_id}`);
      replyValue.value = "";
      $v2.value.$reset();
    } else {
      toast.error("Bạn chưa đăng nhập", { autoClose: 2000 })
    }
  }
}

</script>
<template>
  <div class="mb-[1rem] flex flex-col items-start text-normal-text-color">
    <span class="relative flex w-full justify-between">
      <div class="flex items-start">
        <img class="h-[2rem] w-[2rem] rounded-[2rem] bg-gray-300" :src="comment.user.photo" alt="" />
        <span class="ml-[0.5rem] block leading-none">
          {{ comment.user.name }}
          {{ comment.createAt }}
        </span>
      </div>
      <button
        class="editbox-openbtn z-[20] h-[2rem] w-[2rem] rounded-[1rem] hover:bg-normal-btn-hover focus:bg-normal-btn-hover active:bg-normal-btn-active"
        v-if="userStore.isAdmin">
        <i class="pi pi-ellipsis-v"></i>
      </button>
      <div v-if="userStore.isAdmin"
        class="editbox absolute right-0 top-[calc(100%+0.5rem)] z-30 w-[10rem] bg-gray-50 py-[0.5rem] shadow-md">
        <!-- <button
          class="block w-full px-[1rem] py-[0.5rem] text-left text-[1rem] text-error-color hover:bg-normal-btn-hover active:bg-normal-btn-active disabled:bg-normal-btn-hover disabled:text-green-btn-text-color"
          @click="handleDeleteUser">
          chưa cập nhật
        </button> -->
      </div>
    </span>

    <span class="mb-[0.5rem] ml-[2.5rem] w-full pr-[2.5rem]">
      {{ comment.content }}
    </span>
    <span class="ml-[2.5rem] flex w-full pr-[3.5rem]" :class="{
      'justify-end': comment.comments.length == 0,
      'justify-between': comment.comments.length > 0,
    }">
      <button class="text-blue-500" @click="handleViewReplies" v-if="comment.comments.length > 0">
        {{
          showReplies
          ? "Ẩn phản hồi"
          : `Xem ${comment.comments.length} phản hồi`
        }}
      </button>
      <span class="flex">

        <button
          class="z-20 ml-[0.5rem] flex w-fit items-center rounded-[1rem] px-[1rem] py-[0.5rem] text-[1rem] leading-none text-normal-text-color hover:bg-normal-btn-hover active:bg-normal-btn-active"
          @click="showReplies = !showReplies">
          <i class="pi pi-comment mr-[0.25rem]"></i>
          <span>{{ showReplies ? "Ẩn phản hồi" : "Phản hồi" }}</span>
        </button>
        <button
          class="z-20 ml-[0.5rem] flex w-fit items-center rounded-[1rem] border-[1px] border-error-color px-[1rem] py-[0.5rem] text-[1rem] leading-none text-error-color hover:bg-red-200 active:bg-red-300"
          @click="handleDeleteComment(comment.id)" v-if="userStore.isAdmin">
          <i class="pi pi-trash mr-[0.25rem]"></i>
          <span>Xóa</span>
        </button>
      </span>
    </span>
    <div class="ml-[2.5rem] mt-[0.5rem] w-full pr-[2.5rem]" v-if="showReplies">
      <sub-comment :comment="reply" v-for="reply in   comment.comments  "></sub-comment>
      <span class="relative block" :class="{ 'mt-[0.5rem]': comment.comments.length > 0 }">
        <textarea v-model="replyValue"
          class="w-full resize-none rounded-[1rem] border-[2px] border-border-color px-[1rem] py-[0.25rem] text-[1rem] text-normal-text-color outline-normal-btn-active"
          placeholder="Phản hồi..." rows="2"
          :class="{ 'outline-red-500 border-red-500': $v2.replyValue.$error }"></textarea>
        <button class="absolute right-[1rem] top-[50%] translate-y-[-50%] text-green-btn-text-color"
          @click="handleReply(comment.id)">
          <i class="pi pi-send text-[1.5rem]" :class="{
            'pi-spin pi-spinner': isTyping,
            ' pi-send': !isTyping
          }"></i>
        </button>
      </span>
    </div>
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
