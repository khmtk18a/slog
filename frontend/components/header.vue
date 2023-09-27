<script setup>
import { ref } from "vue";
import { storeToRefs } from "pinia";
import { useLSidebarStore } from "../stores/lSidebar";
import { useUserStore } from "../stores/user";
import { useArticleStore } from "../stores/article";
import mobileSearch from "./mobileSearch.vue";
import { useRouter } from "vue-router";

const router = useRouter();
const lSidebarStore = useLSidebarStore();
const userStore = useUserStore();
const moblieSearchVisible = ref();
const articleStore = useArticleStore();
const searchValue = ref();
const { isLogin } = storeToRefs(userStore);

function handleSearch(keyword) {
  articleStore.search(keyword);
  console.log("Handle search", keyword);
}

function handleLogin() {
  console.log("Handle login: ");
}

function handleOpenSummary() {
  window.location.href = "https://localhost:8000/post"
  console.log("Handle open summary");
}

function handleSignOut() {
  console.log("Handle sign out");
  userStore.logOut();
  window.location.href = `${window.location.origin}/user/logout`
}

function handleClick(articleId) {
  router.push({ name: 'article', params: { id: articleId } }).then(() => {
    window.location.reload();
  });
}

</script>

<template>
  <div
    class="fixed left-0 top-0 z-[300] flex h-[4rem] w-full items-center justify-between border-b-[1px] border-line-color bg-white px-[2rem] max-lg:px-[1rem] py-[8px]">
    <span class="flex items-center text-title-text-color">
      <button
        class="mr-[1rem] rounded-[1rem] p-[0.5rem] leading-[0] hover:bg-normal-bg active:bg-normal-btn-active lg:hidden"
        @click="lSidebarStore.isOpen = !lSidebarStore.isOpen">
        <i class="pi pi-bars text-[1.25rem]"></i>
      </button>
      <a href="/">
        <span class="text-[1.5rem] font-semibold">Slog</span>
      </a>
    </span>

    <span
      class="w-[calc(100vw-40rem)] text-normal-text-color max-lg:mx-[1rem] max-lg:flex-1 max-sm:hidden lg:absolute lg:left-[20rem] relative z-[20]">
      <i class="pi pi-search absolute top-[50%] ml-[1rem] translate-y-[-50%] text-[1.2rem] z-20"></i>
      <input v-model="searchValue" type="text"
        class="searchbox-openbtn w-full rounded-[2rem] bg-normal-bg py-[0.62rem] pl-[2.75rem] text-[1rem] outline-none focus:bg-gray-100 relative z-[10]"
        placeholder="Tìm kiếm..." @keypress.enter="handleSearch(searchValue)" />
      <div
        class="searchbox absolute w-full min-h-[5rem] bg-gray-100 top-0 rounded-tl-[2rem] shadow-lg  rounded-tr-[2rem] z-0 pt-[3rem] px-[1rem] py-[0.5rem]">
        <div class="m-auto w-fit" v-if="articleStore.searchResults === null">
          <i class="pi pi-spin pi-spinner text-[1.5rem]"></i>
        </div>
        <span v-if="articleStore.searchResults && articleStore.searchResults.length == 0">
          Không tìm thấy kết quả phù hợp
        </span>
        <ul v-if="articleStore.searchResults">
          <li v-for="sr in articleStore.searchResults">
            <a @click="handleClick(sr.id)" class="py-[0.25rem] hover:bg-normal-btn-hover block">{{ sr.title }}</a>
          </li>
        </ul>
      </div>
    </span>
    <span class="relative flex items-center">
      <button
        class="mr-[0.5rem] block h-[2rem] w-[2rem] rounded-[1rem] font-semibold leading-none text-title-text-color hover:bg-normal-btn-hover active:bg-normal-btn-active sm:hidden"
        @click="moblieSearchVisible = true">
        <i class="pi pi-search text-[1.5rem]"></i>
      </button>
      <mobile-search class="sm:hidden" v-if="moblieSearchVisible" @close="moblieSearchVisible = false"
        @search="handleSearch"></mobile-search>
      <a href="https://localhost:8000/google/login"
        class="rounded-[1rem] border-[1px] border-green-btn-text-color px-[1rem] py-[0.5rem] text-[1rem] leading-[110%] text-green-btn-text-color hover:bg-normal-btn-hover active:bg-normal-btn-active"
        @click="handleLogin" v-if="!isLogin">
        Đăng nhập
      </a>
      <button class="userbox-openbtn h-[2.5rem] w-[2.5rem] rounded-[2rem]" v-if="userStore.isLogin">
        <img :src="userStore.info.photo" alt="" class="rounded-[2rem]" />
      </button>
      <div
        class="userbox absolute right-0 top-[calc(100%+0.5rem)] z-[200] w-[15rem] bg-gray-50 py-[0.5rem] text-normal-text-color shadow-md">
        <button v-if="userStore.isAdmin"
          class="block w-full py-[1rem] pl-[1rem] text-left hover:bg-normal-btn-hover active:bg-normal-btn-active"
          @click="handleOpenSummary">
          <i class="pi pi-book"></i>
          <span class="ml-[0.5rem]">Trang quản trị</span>
        </button>
        <button class="block w-full py-[1rem] pl-[1rem] text-left hover:bg-normal-btn-hover active:bg-normal-btn-active"
          @click="handleSignOut">
          <i class="pi pi-sign-out"></i>
          <span class="ml-[0.5rem]">Đăng xuất</span>
        </button>
      </div>
    </span>
  </div>
</template>

<style scoped>
.userbox-openbtn:focus+.userbox {
  display: block;
}

.userbox {
  display: none;
}

.userbox:hover {
  display: block;
}

.searchbox-openbtn:focus+.searchbox {
  display: block;
}

.searchbox {
  display: none;
}

.searchbox:hover {
  display: block;
}
</style>
