import { defineStore } from "pinia";
import baseAxios from "../services/axios";

export const useBaseStore = defineStore("base", {
  state: () => {
    return {
      author: null,
      isLogin: false,
      overlayVisible: false,
      quote: null
    };
  },
  actions: {
    fetchQuote() {
      baseAxios.get("https://api.quotable.io/quotes/random").then(res => {
        this.quote = res.data[0]
      }).catch(err => {
        console.log(err)
      })
    }
  },
});
