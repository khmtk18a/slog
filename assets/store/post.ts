import { defineStore } from "pinia";
import { reactive, ref } from "vue";

export const usePostStore = defineStore('post', () => {
  const limit = 10;
  const posts: Post[] = reactive([])
  const canLoadMore = ref(true)

  let offset = 0;

  async function loadMore() {
    const newPosts = await (
      await fetch('/post/fetch?offset=' + offset + '&limit=' + limit)
    ).json() as Post[]

    if (newPosts.length === 0) {
      canLoadMore.value = false;
    }

    for (const post of newPosts) {
      posts.push(post)
    }

    offset += limit
  }

  function getPostAt(index: number) {
    return posts[index]
  }

  return { posts, canLoadMore, getPostAt, loadMore }
});
