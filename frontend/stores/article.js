import { defineStore } from "pinia";
import baseAxios from "../services/axios";
import { toast } from "vue3-toastify";

export const useArticleStore = defineStore("article", {
  state: () => {
    return {
      article: null,
      subArticles: [],
      articles: [],
      viewType: "Card",
      sortBy: "New",
      editArticle: null,
      recommends: null,
      searchResults: false,
      page: 1,
      tag: null,
      keyword: null
    };
  },
  actions: {
    fetchArticles() {
      baseAxios
        .get(
          `/api/posts?page=${this.page}${this.tag ? "&tags=" + this.tag : ""}${this.sortBy == "Hot" ? '&order[score]=desc' : '&order[createdAt]=desc'}`,
        )
        .then((res) => {
          this.articles.splice(this.articles.length, 0, ...res.data);
          this.page += 1;
          console.log(this.articles);
        });
    },
    fetchArticle(articleId) {
      for (const article of this.articles) {
        if (article.id == articleId) {
          this.article = JSON.parse(JSON.stringify(article));
          return true;
        }
      }
      baseAxios.get(`/api/posts/${articleId}`).then((res) => {
        this.article = res.data;
        this.fetchVotes(this.article.id, true);
      });
    },
    postVote(value, post) {
      const body = {
        value,
        user: `/api/users/1`,
        post: `/api/posts/${post}`,
      };
      baseAxios.post(`/api/votes`, body).then((res) => {
        for (let i = 0; i < this.articles.length; i++) {
          if (this.articles[i].id == post) {
            this.articles[i].score += value;
            break;
          }
        }
        console.log(res);
      }).catch(err => {
        toast.error("Vote thất bại.", { autoClose: 2000 })
      });
    },
    fetchVotes(post, single = false) {
      baseAxios
        .get(`/api/votes?post=${post}`)
        .then((res) => {
          if (single) {
            this.article.votes = res.data.length;
          } else {
            for (const article of this.articles) {
              // console.log("Id: ",article.id, ' ', post, ' ',res.data)
              if (article.id == post) {
                article.votes = res.data.length;
                break;
              }
            }
          }
        })
        .catch(() => {
          if (single) {
            this.article.votes = 0;
          } else {
            for (const article of this.articles) {
              if (article.id == post) {
                article.votes = 0;
                break;
              }
            }
          }
        });
    },

    fetchByTag(tagId) {
      this.tag = tagId;
      this.page = 1;
      if (this.articles.length == 0) {
        this.fetchArticles();
      }
      this.articles = [];
    },

    fetchRecommends() {
      const min = Math.ceil(1);
      const max = Math.floor(5);
      const page = Math.floor(Math.random() * (max - min + 1)) + min;
      baseAxios.get(`/api/posts?page=${page}`).then(res => {
        console.log(res.data)
        this.recommends = res.data
      })
      console.log("Fetch recommends");

    },

    search(keyword) {
      this.searchResults = null;

      baseAxios.get(`/api/posts?title=${keyword}`).then(res => {
        this.searchResults = res.data;
      }).catch(error => {
        // this.searchResults = [];
        this.searchResults = [
        ]
      });

    }


  },
});
