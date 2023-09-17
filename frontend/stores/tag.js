import { defineStore } from "pinia";
import baseAxios from "../services/axios";

export const useTagStore = defineStore("tag", {
  state: () => {
    return {
      tags: [],
    };
  },
  actions: {
    fetchTags() {
      baseAxios.get("/api/tags").then((res) => {
        this.tags = res.data;

      });
    },
  },
});
