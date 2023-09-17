<script setup>
import { useBaseStore } from "../stores/base";
import { useLSidebarStore } from "../stores/lSidebar";
import { useTagStore } from "../stores/tag";


const baseStore = useBaseStore();
const lSidebarStore = useLSidebarStore();
const tagStore = useTagStore();
if (lSidebarStore.status != "user-view") {
    lSidebarStore.initUserView();
    tagStore.fetchTags();
}

</script>

<template>
    <div
        class="flex w-full flex-col items-center px-[1rem] pt-[2rem] text-title-text-color text-[1.2rem] lead-[1.2] text-justify italic leading-8">
        <h1 class="text-[2.5rem] mb-[2rem]">Gửi các bạn</h1>
        &nbsp; &nbsp; &nbsp; &nbsp;Chào mừng bạn đến với blog cá nhân của tôi!
        <br>

        &nbsp; &nbsp; &nbsp; &nbsp;Trong blog của tôi, bạn sẽ tìm thấy một loạt các bài viết về công nghệ thông tin, cuộc
        sống
        hàng ngày,
        sở thích cá
        nhân, du lịch, ẩm
        thực, và nhiều chủ đề khác nữa. Tôi hy vọng rằng những bài viết này sẽ cung cấp cho bạn những thông tin hữu ích và
        có giá trị.
        <br>

        &nbsp; &nbsp; &nbsp; &nbsp;Nếu bạn quan tâm đến những gì tôi viết và muốn thảo luận hoặc chia sẻ ý kiến, hãy để lại
        nhận xét hoặc
        liên hệ với
        tôi qua các kênh mạng xã hội. Tôi rất mong được nghe từ bạn!
        <br>
        &nbsp; &nbsp; &nbsp; &nbsp;Cảm ơn bạn đã ghé thăm blog của tôi. Hãy trải nghiệm và tận hưởng những bài viết tại đây!
        <br>
        <span class="text-right w-full pr-[3rem]">
            Trân trọng.
        </span>
        <!-- <div
      class="mb-[1rem] flex w-[20rem] flex-col items-center rounded-[1rem] bg-normal-bg py-[2rem] text-title-text-color">
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
    </div> -->

        <!-- <div class="relative max-lg:w-[calc(100vw-2rem)] lg:w-[calc(100vw-22rem)]">
      <span class="absolute left-[2rem] translate-y-[-50%] text-[1.2rem] font-semibold text-title-text-color">Giới
        thiệu</span>
      <span class="block h-[20rem] w-full rounded-[1rem] border-[2px] border-normal-btn-bg bg-normal-bg p-[1rem]">
        {{ baseStore.author.description }}
      </span>
    </div> -->
    </div>
</template>
