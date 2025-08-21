import Vue from "vue";
import Router from "vue-router";
import Screen2 from "./components/Screen2";
import { screen2Data } from "./data";

Vue.use(Router);

export default new Router({
  mode: "history",
  routes: [
    {
      path: "*",
      component: Screen2,
      props: { ...screen2Data },
    },
  ],
});
