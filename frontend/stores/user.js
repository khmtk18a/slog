import { defineStore } from "pinia";
import baseAxios from "../services/axios";

export const useUserStore = defineStore("user", {
  state: () => {
    return {
      isAdmin: false,
      info: null,
      isLogin: false,
    };
  },
  actions: {
    fetchInfor() {

      console.log("Fetch infor")
      baseAxios
        .get("/user/info")
        .then((res) => {
          this.info = res.data.user;
          if (this.info.roles.includes("ROLE_ADMIN")) {
            this.isAdmin = true;
          }
          console.log(this.info, this.isAdmin);
          this.isLogin = true;
        })
        .catch(() => {
          this.logOut();
        });
    },

    logOut() {
      this.isAdmin = false;
      this.isLogin = false;
      this.info = null;
    }
  },
});
