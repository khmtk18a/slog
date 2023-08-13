import { defineStore } from "pinia";
import { ref } from "vue";

type State = {
  user: User | null
}

export const useUserStore = defineStore("user", () => {
  const user = ref<User | null>(null)
  async function fetchUser() {
    const ret = await fetch('/user/info')
    const data = await ret.json() as State
    user.value = data.user
  }

  return { user, fetchUser }
});
