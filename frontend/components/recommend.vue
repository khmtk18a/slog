<script setup>
import { computed } from "vue";
import { useRouter } from "vue-router";
import { useBaseStore } from "../stores/base";

const baseStore = useBaseStore();

const props = defineProps(["recommend"]);
console.log(props.recommend)
const router = useRouter();
const shortTitle = computed(() => {
  const maxCharacters = 60;
  if (props.recommend.title.length <= maxCharacters) {
    return props.recommend.title;
  } else {
    return props.recommend.title.substring(0, maxCharacters) + "  ...";
  }
});

function handleClick(articleId) {
  router.push({ name: 'article', params: { id: articleId } }).then(() => {
    window.location.reload();
  });
}

</script>
<template>
  <div class="w-full">
    <div class="text-ntext flex flex-col justify-between">
      <span class="flex w-full items-center">
        <a @click.prevent="console.log('click')" href="/"
          class="text-ntext z-[20] flex h-[2rem] w-full items-center rounded-[2rem] hover:text-green-500">
          <img class="mr-[0.5rem] h-full w-[2rem] rounded-[2rem] bg-green-100" :src="props.recommend.user.photo" alt="" />
          <span>{{ props.recommend.user.name }}</span>
        </a>
      </span>
      <a :title="props.recommend.title" @click="handleClick(props.recommend.id)"
        class="text-ntext my-[0.5rem] block text-[1rem] font-[500] hover:underline max-lg:hidden">{{ shortTitle }}
      </a>
      <a :title="props.recommend.title" @click="handleClick(props.recommend.id)"
        class="text-ntext my-[0.5rem] block text-[1rem] font-[500] hover:underline lg:hidden">{{ props.recommend.title }}
      </a>
      <span class="text-ntext text-[0.9rem]">{{ props.recommend.score }} rates &nbsp&nbsp•&nbsp&nbsp
        {{ props.recommend.comments.length }} comments</span>
    </div>
  </div>
</template>
