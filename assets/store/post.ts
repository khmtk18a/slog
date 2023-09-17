import { defineStore } from "pinia";
import { reactive, ref } from "vue";

export const usePostStore = defineStore('post', () => {
  let page = 1;
  const posts: Post[] = reactive([])
  const canLoadMore = ref(true)

  async function loadMore() {
    const newPosts = await (
      await fetch('/api/posts?page=' + page, {
        headers: {
          'accept': 'application/json'
        }
      })
    ).json() as Post[]

    if (newPosts.length === 0) {
      canLoadMore.value = false;
    }

    for (const post of newPosts) {
      posts.push(post)
    }

    ++page
  }

  function getPostAt(index: number) {
    return posts[index]
  }

  return { posts, canLoadMore, getPostAt, loadMore }
});
