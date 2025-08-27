import Vue from "vue";
import Router from "vue-router";
import HomePage from "./components/HomePage";
import AboutPage from "./components/AboutPage";
import ServicesPage from "./components/ServicesPage";
import NewsPage from "./components/NewsPage";
import FaqPage from "./components/FaqPage";
import ApplicationFormPage from "./components/ApplicationFormPage";
import SeminarRegistrationPage from "./components/SeminarRegistrationPage";
import AdminLoginPage from "./views/admin/AdminLoginPage";
import AdminDashboard from "./views/admin/AdminDashboard";
import PageEditForm from "./views/admin/PageEditForm";

Vue.use(Router);

export default new Router({
  mode: "history",
  routes: [
    {
      path: "/",
      name: "top",
      component: HomePage
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
      path: "/apply",
      name: "apply",
      component: ApplicationFormPage,
    },
    {
      path: "/seminar-registration",
      name: "seminarRegistration",
      component: SeminarRegistrationPage,
    },
    {
      path: "/admin/login",
      name: "adminLogin",
      component: AdminLoginPage,
    },
    {
      path: "/admin/dashboard",
      name: "adminDashboard",
      component: AdminDashboard,
    },
    {
      path: "/admin/pages/:pageKey/edit",
      name: "pageEdit",
      component: PageEditForm,
    },
    {
      path: "/admin/pages/new",
      name: "pageNew",
      component: PageEditForm,
    },
    {
      path: "*",
      redirect: "/",
    },
  ],
});
