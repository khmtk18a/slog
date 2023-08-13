<script lang="ts" setup>
import { storeToRefs } from 'pinia';
import Post from '../components/post.vue';
import { usePostStore } from '../store/post';

const postStore = usePostStore()
const { posts, canLoadMore } = storeToRefs(postStore)

postStore.loadMore()

</script>
<template>
  <div>
    <div v-if="posts">
        <Post v-for="post in posts" :data="post"></Post>
    </div>
    <button @click="postStore.loadMore" v-if="canLoadMore">Load more...</button>
  </div>
</template>
