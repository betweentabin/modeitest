import Vue from "vue";
import Router from "vue-router";
import HomePage from "./components/HomePage";
import AboutPage from "./components/AboutPage";
import ServicesPage from "./components/ServicesPage";
import NewsPage from "./components/NewsPage";
import FaqPage from "./components/FaqPage";
import PublicationsPage from "./components/PublicationsPage";
import ApplicationFormPage from "./components/ApplicationFormPage";
import SeminarRegistrationPage from "./components/SeminarRegistrationPage";
import AdminLoginPage from "./views/admin/AdminLoginPage";
import SimpleAdminLogin from "./views/admin/SimpleAdminLogin";
import NewAdminLogin from "./views/admin/NewAdminLogin";
import AdminDashboard from "./views/admin/AdminDashboard";
import NewAdminDashboard from "./views/admin/NewAdminDashboard";
import MemberManagement from "./views/admin/MemberManagement";
import SeminarManagement from "./views/admin/SeminarManagement";
import PublicationManagement from "./views/admin/PublicationManagement";
import NoticeManagement from "./views/admin/NoticeManagement";
import MediaManagement from "./views/admin/MediaManagement";
import PageEditForm from "./views/admin/PageEditForm";
import NewPageEditForm from "./views/admin/NewPageEditForm";
import SeminarEditForm from "./views/admin/SeminarEditForm";
import PublicationEditForm from "./views/admin/PublicationEditForm";
import NoticeEditForm from "./views/admin/NoticeEditForm";
import MediaEditForm from "./views/admin/MediaEditForm";
import PublicationDetailPage from "./components/PublicationDetailPage";
import NewsDetailPage from "./components/NewsDetailPage";
import TestPage from "./components/TestPage";
import MemberLoginPage from "./views/MemberLoginPage";
import MemberRegisterPage from "./views/MemberRegisterPage";

Vue.use(Router);

export default new Router({
  mode: "hash",
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
      path: "/news/:id",
      name: "newsDetail",
      component: NewsDetailPage,
    },
    {
      path: "/faq",
      name: "faq",
      component: FaqPage,
    },
    {
      path: "/publications",
      name: "publications",
      component: PublicationsPage,
    },
    {
      path: "/publications/:id",
      name: "publicationDetail",
      component: PublicationDetailPage,
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
      component: NewAdminLogin,
    },
    {
      path: "/admin/dashboard",
      name: "adminDashboard",
      component: MemberManagement,
    },
    {
      path: "/admin/members",
      name: "memberManagement",
      component: MemberManagement,
    },
    {
      path: "/admin/seminars",
      name: "seminarManagement",
      component: SeminarManagement,
    },
    {
      path: "/admin/seminars/:id/edit",
      name: "seminarEdit",
      component: SeminarEditForm,
    },
    {
      path: "/admin/seminars/new",
      name: "seminarNew",
      component: SeminarEditForm,
    },
    {
      path: "/admin/publications",
      name: "publicationManagement",
      component: PublicationManagement,
    },
    {
      path: "/admin/publications/new",
      name: "publicationNew",
      component: PublicationEditForm,
    },
    {
      path: "/admin/publications/:id/edit",
      name: "publicationEdit",
      component: PublicationEditForm,
    },
    {
      path: "/admin/notices",
      name: "noticeManagement",
      component: NoticeManagement,
    },
    {
      path: "/admin/notices/:id/edit",
      name: "noticeEdit",
      component: NoticeEditForm,
    },
    {
      path: "/admin/notices/new",
      name: "noticeNew",
      component: NoticeEditForm,
    },
    {
      path: "/admin/media",
      name: "mediaManagement",
      component: MediaManagement,
    },
    {
      path: "/admin/media/:id/edit",
      name: "mediaEdit",
      component: MediaEditForm,
    },
    {
      path: "/admin/media/new",
      name: "mediaNew",
      component: MediaEditForm,
    },
    {
      path: "/admin/pages",
      name: "pageManagement",
      component: NewAdminDashboard,
    },
    {
      path: "/admin/pages/:pageKey/edit",
      name: "pageEdit",
      component: NewPageEditForm,
    },
    {
      path: "/admin/pages/new",
      name: "pageNew",
      component: NewPageEditForm,
    },
    {
      path: "/login",
      name: "memberLogin",
      component: MemberLoginPage,
    },
    {
      path: "/register",
      name: "memberRegister",
      component: MemberRegisterPage,
    },
    {
      path: "*",
      redirect: "/",
    },
  ],
});
