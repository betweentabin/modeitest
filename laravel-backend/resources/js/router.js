import Vue from "vue";
import Router from "vue-router";
import Screen2 from "./components/Screen2.vue";
import { screen2Data } from "./data";

Vue.use(Router);

export default new Router({
  mode: "history",
  routes: [
    {
      path: "/",
      name: "home",
      component: Screen2,
      props: { ...screen2Data },
    },
    {
      path: "/about",
      name: "about",
      component: Screen2,
      props: { ...screen2Data },
    },
    {
      path: "/services",
      name: "services",
      component: Screen2,
      props: { ...screen2Data },
    },
    {
      path: "/news",
      name: "news",
      component: Screen2,
      props: { ...screen2Data },
    },
    {
      path: "/faq",
      name: "faq",
      component: Screen2,
      props: { ...screen2Data },
    },
    {
      path: "/contact",
      name: "contact",
      component: Screen2,
      props: { ...screen2Data },
    },
    {
      path: "*",
      redirect: "/"
    },
  ],
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) {
      return savedPosition;
    } else if (to.hash) {
      return {
        selector: to.hash,
        behavior: 'smooth'
      };
    } else {
      return { x: 0, y: 0 };
    }
  }
});