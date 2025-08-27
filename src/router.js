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
import MyAccountPage from "./views/MyAccountPage";
import UpgradePage from "./views/UpgradePage";

Vue.use(Router);

const router = new Router({
  mode: "hash",
  routes: [
    {
      path: "/",
      name: "top",
      component: HomePage,
      meta: { title: "ちくぎん地域経済研究所" }
    },
    {
      path: "/about",
      name: "about",
      component: AboutPage,
      meta: { title: "会社概要 - ちくぎん地域経済研究所" }
    },
    {
      path: "/services",
      name: "services",
      component: ServicesPage,
      meta: { title: "サービス案内 - ちくぎん地域経済研究所" }
    },
    {
      path: "/news",
      name: "news",
      component: NewsPage,
      meta: { title: "ニュース - ちくぎん地域経済研究所" }
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
      meta: { title: "管理者ログイン - ちくぎん地域経済研究所" }
    },
    {
      path: "/admin/dashboard",
      name: "adminDashboard",
      component: MemberManagement,
      meta: { title: "管理ダッシュボード - ちくぎん地域経済研究所" }
    },
    {
      path: "/admin/members",
      name: "memberManagement",
      component: MemberManagement,
      meta: { title: "会員管理 - ちくぎん地域経済研究所" }
    },
    {
      path: "/admin/seminars",
      name: "seminarManagement",
      component: SeminarManagement,
      meta: { title: "セミナー管理 - ちくぎん地域経済研究所" }
    },
    {
      path: "/admin/seminars/new",
      name: "seminarNew",
      component: SeminarEditForm,
      meta: { title: "セミナー新規作成 - ちくぎん地域経済研究所" }
    },
    {
      path: "/admin/seminars/:id/edit",
      name: "seminarEdit",
      component: SeminarEditForm,
      meta: { title: "セミナー編集 - ちくぎん地域経済研究所" }
    },
    {
      path: "/admin/publications",
      name: "publicationManagement",
      component: PublicationManagement,
      meta: { title: "刊行物管理 - ちくぎん地域経済研究所" }
    },
    {
      path: "/admin/publications/new",
      name: "publicationNew",
      component: PublicationEditForm,
      meta: { title: "刊行物新規作成 - ちくぎん地域経済研究所" }
    },
    {
      path: "/admin/publications/:id/edit",
      name: "publicationEdit",
      component: PublicationEditForm,
      meta: { title: "刊行物編集 - ちくぎん地域経済研究所" }
    },
    {
      path: "/admin/notices",
      name: "noticeManagement",
      component: NoticeManagement,
      meta: { title: "お知らせ管理 - ちくぎん地域経済研究所" }
    },
    {
      path: "/admin/notices/new",
      name: "noticeNew",
      component: NoticeEditForm,
      meta: { title: "お知らせ新規作成 - ちくぎん地域経済研究所" }
    },
    {
      path: "/admin/notices/:id/edit",
      name: "noticeEdit",
      component: NoticeEditForm,
      meta: { title: "お知らせ編集 - ちくぎん地域経済研究所" }
    },
    {
      path: "/admin/media",
      name: "mediaManagement",
      component: MediaManagement,
      meta: { title: "メディア管理 - ちくぎん地域経済研究所" }
    },
    {
      path: "/admin/media/new",
      name: "mediaNew",
      component: MediaEditForm,
      meta: { title: "メディア新規追加 - ちくぎん地域経済研究所" }
    },
    {
      path: "/admin/media/:id/edit",
      name: "mediaEdit",
      component: MediaEditForm,
      meta: { title: "メディア編集 - ちくぎん地域経済研究所" }
    },
    {
      path: "/admin/pages",
      name: "pageManagement",
      component: NewAdminDashboard,
      meta: { title: "ページ管理 - ちくぎん地域経済研究所" }
    },
    {
      path: "/admin/pages/:pageKey/edit",
      name: "pageEdit",
      component: NewPageEditForm,
      meta: { title: "ページ編集 - ちくぎん地域経済研究所" }
    },
    {
      path: "/admin/pages/new",
      name: "pageNew",
      component: NewPageEditForm,
      meta: { title: "ページ新規作成 - ちくぎん地域経済研究所" }
    },
    {
      path: "/login",
      name: "memberLogin",
      component: MemberLoginPage,
      meta: { title: "会員ログイン - ちくぎん地域経済研究所" }
    },
    {
      path: "/register",
      name: "memberRegister",
      component: MemberRegisterPage,
      meta: { title: "会員登録 - ちくぎん地域経済研究所" }
    },
    {
      path: "/my-account",
      name: "myAccount",
      component: MyAccountPage,
      meta: { title: "マイアカウント - ちくぎん地域経済研究所" }
    },
    {
      path: "/upgrade",
      name: "upgrade",
      component: UpgradePage,
      meta: { title: "プランアップグレード - ちくぎん地域経済研究所" }
    },
    {
      path: "*",
      redirect: "/",
    },
  ],
});

// ページタイトルを自動更新するナビゲーションガード
router.beforeEach((to, from, next) => {
  // ルートのメタ情報からタイトルを取得
  const title = to.meta?.title || 'ちくぎん地域経済研究所 - CMS管理システム';
  document.title = title;
  next();
});

export default router;
