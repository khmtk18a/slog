import { defineStore } from "pinia";
import baseAxios from "../services/axios";
import { toast } from "vue3-toastify";

export const useCommentStore = defineStore("comment", {
  state: () => {
    return {
      comments: [],
      page: 1,
      sortBy: 0,
      isTyping: false
    };
  },
  actions: {
    firstFetch(articleId) {
      this.page = 1;
      this.comments = [];
      this.fetchComments(articleId)
    },

    fetchComments(articleId) {
      baseAxios
        .get(`api/comments?post=${articleId}&page=${this.page}${this.sortBy == 0 ? "&order[id]=asc" : "&order[id]=desc"}`)
        .then((res) => {
          this.comments.splice(this.comments.length, 0, ...res.data);
          this.page += 1;
        });
    },

    postComment(user, content, post, parent) {
      this.isTyping = true;
      const body = {
        content,
        user: `/api/users/${user}`,
        post,
        parent,
      };
      baseAxios
        .post("/api/comments", body)
        .then((response) => {
          this.isTyping = false;
          if (parent) {
            for (let i = 0; i < this.comments.length; i++) {
              if (this.comments[i].id == parent.split("/").at(-1)) {
                this.comments[i].comments.push(response.data);
                console.log("add reply: ", this.comments[i], response.data)
                return;
              }
            }
          }
          if (this.sortBy == 0) {
            this.comments.unshift(response.data);
          } else {
            if (this.comments.length < 5)
              this.comments.push(response.data)
          }

        })
        .catch((error) => {
          this.isTyping = false;
        });
    },

    deleteComment(id, post, parent) {
      baseAxios.delete(`/api/comments/${id}`).then(res => {

        console.log(res.data)
        if (parent) {
          parentLoop: for (let i = 0; i <= this.comments.length; i++) {
            if (this.comments[i].id == parent) {
              for (let j = 0; j <= this.comments[i].comments.length; j++) {
                if (this.comments[i].comments[j].id == id) {
                  this.comments[i].comments.splice(j, 1);
                  break parentLoop;
                }
              }
            }
          }
        } else {
          for (let i = 0; i <= this.comments.length; i++) {
            if (this.comments[i].id == id) {
              this.comments.splice(i, 1);
              break;
            }

          }
        }
        // console.log(post.split("/"))
        // this.firstFetch(post.split("/").at(-1))
      }).catch(err => {
        console.log(err)
        toast.error("Xóa comment thất bại.")
      })
    }
  },
});
