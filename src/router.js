import Vue from "vue";
import Router from "vue-router";
import Screen2 from "./components/Screen2";
import AboutPage from "./components/AboutPage";
import ServicesPage from "./components/ServicesPage";
import NewsPage from "./components/NewsPage";
import FaqPage from "./components/FaqPage";
import { screen2Data } from "./data";

Vue.use(Router);

export default new Router({
  mode: "history",
  routes: [
    {
      path: "/",
      name: "top",
      component: Screen2,
      props: { ...screen2Data },
    },
    {
      path: "/about",
      name: "about",
      component: AboutPage,
    },
    {
      path: "/services",
      name: "services",
      component: ServicesPage,
    },
    {
      path: "/news",
      name: "news",
      component: NewsPage,
    },
    {
      path: "/faq",
      name: "faq",
      component: FaqPage,
    },
    {
      path: "*",
      redirect: "/",
    },
  ],
});
