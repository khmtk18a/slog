import { createRouter, createWebHashHistory } from "vue-router";
// import {useBaseStore} from "../stores/base"
// const baseStore = useBaseStore();

import HomeView from "../views/HomeView.vue";

const router = createRouter({
  history: createWebHashHistory(),
  routes: [
    {
      path: "/",
      name: "home",
      component: HomeView,
    },
    {
      path: "/upload",
      name: "upload",
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import("../views/UploadView.vue"),
    },
    {
      path: "/article/:id",
      name: "article",
      component: () => import("../views/ArticleView.vue"),
    },
    {
      path: "/summary",
      name: "summary",
      component: () => import("../views/SummaryView.vue"),
    },
    {
      path: "/about-me",
      name: "about-me",
      component: () => import("../views/AboutMeView.vue"),
    },
  ],
});

// router.beforeEach((to, from, next) => {
//     baseStore.overlayVisible = true;
//     next();
// //   if (to.name !== 'Login' && !isAuthenticated) next({ name: 'Login' })
// //   else next()
// })
export default router;
