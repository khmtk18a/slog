import { defineStore } from "pinia";

export const useLSidebarStore = defineStore("lSidebar", {
  state: () => {
    return {
      isOpen: false,
      items: [],
      isShowAllTags: false,
      tags: [],
      status: null
    };
  },
  actions: {
    initUserView() {
      this.status = "user-view";
      this.items = [
        { label: "Trang chủ", type: "route", icon: "pi-home", route: "/" },
        {
          label: "Phổ biến nhất",
          type: "route",
          icon: "pi-arrow-up-right",
          route: "/hot",
        },
        { type: "line" },
        { label: "THỂ LOẠI", type: "title" },
        { type: "tag-container" },
        { type: "toggle", label: "Xem thêm", callback: this.limitAmountTags },
        { type: "line" },
        { label: "TÀI NGUYÊN", type: "title" },
        {
          label: "About me",
          type: "route",
          icon: "pi-prime",
          route: "/about-me",
        },
      ];
    },

    initAdminView() {
      this.status = "admin-view";
      this.items = [
        { label: "Trang chủ", type: "route", icon: "pi-home", route: "/" },
        {
          label: "Tổng quan",
          type: "route",
          icon: "pi-desktop",
          route: "/summary",
        },
        { type: "line" },
        { label: "BÀI VIẾT", type: "title" },
        {
          label: "Thêm bài viết",
          type: "route",
          icon: "pi-plus",
          route: "/upload",
        },
        { type: "line" },
        { label: "TÀI NGUYÊN", type: "title" },
        {
          label: "About me",
          type: "route",
          icon: "pi-prime",
          route: "/about-me",
        },
      ];
    },
  },
});
