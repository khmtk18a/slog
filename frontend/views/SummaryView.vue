<script setup>
import { useBaseStore } from "../stores/base";
import { useLSidebarStore } from "../stores/lSidebar";

const baseStore = useBaseStore();
const lSidebarStore = useLSidebarStore();

if (lSidebarStore.status != "admin-view") {
  lSidebarStore.initAdminView();
}

function handleUpdate() {
  console.log("Handle update");
}
</script>
<template>
  <div class="flex w-full flex-col items-center pb-[1rem] pt-[2rem] text-normal-text-color">
    <div
      class="mb-[0.5rem] flex w-[20rem] flex-col items-center rounded-[1rem] bg-normal-bg py-[2rem] text-title-text-color">
      <span class="mx-auto block text-[1.2rem] font-semibold"> Tác giả </span>
      <img :src="baseStore.author.avatar" class="my-[1rem] h-[5rem] w-[5rem] rounded-[2.5rem] bg-normal-btn-bg" alt="" />
      <span class="block w-full pl-[1.5rem] text-[1rem]">
        <span class="font-semibold">Tên:</span>
        <span class="ml-[0.5rem]">{{ baseStore.author.name }}</span>
      </span>
      <span class="block w-full pl-[1.5rem] text-[1rem]">
        <span class="font-semibold">Email:</span>
        <span class="ml-[0.5rem]">{{ baseStore.author.email }}</span>
      </span>
    </div>
    <div
      class="grid w-[20rem] grid-cols-2 grid-rows-2 gap-y-[0.5rem] text-center text-[1rem] font-semibold text-title-text-color">
      <span class="leading-[1.2rem]">
        Số lượng <br />
        bài viết
      </span>
      <span class="leading-[1.2rem]">
        Số lượng <br />
        người dùng
      </span>
      <span class="">100</span>
      <span class="">200</span>
    </div>
    <div class="relative max-lg:w-[calc(100vw-2rem)] lg:w-[calc(100vw-22rem)]">
      <div class="w-auto">
        <span class="mb-[0.25rem] block text-[1.2rem] font-semibold leading-none text-title-text-color">Tên</span>
        <input type="text"
          class="w-full rounded-[0.5rem] border-[2px] border-border-color py-[0.75rem] pl-[1rem] text-[1rem] text-title-text-color outline-normal-btn-active"
          placeholder="Tên..." />
      </div>
      <div class="my-[0.5rem] w-auto">
        <span class="mb-[0.25rem] block text-[1.2rem] font-semibold leading-none text-title-text-color">Email</span>
        <input type="text"
          class="w-full rounded-[0.5rem] border-[2px] border-border-color py-[0.75rem] pl-[1rem] text-[1rem] text-title-text-color outline-normal-btn-active"
          placeholder="Email..." />
      </div>
      <div class="w-auto">
        <span class="mb-[0.25rem] block text-[1.2rem] font-semibold leading-none text-title-text-color">Giới thiệu</span>
        <textarea
          class="w-full resize-none rounded-[0.5rem] border-[2px] border-border-color px-[1rem] py-[0.25rem] text-[1rem] text-normal-text-color outline-normal-btn-active"
          placeholder="Giới thiệu..." rows="3"></textarea>
      </div>
      <button
        class="mt-[0.5rem] w-full rounded-[0.5rem] bg-normal-btn-bg py-[0.5rem] text-[1.2rem] font-semibold text-normal-text-color hover:bg-normal-btn-hover active:bg-normal-btn-active"
        @click="handleUpdate">
        Cập nhật
      </button>
    </div>
  </div>
</template>
