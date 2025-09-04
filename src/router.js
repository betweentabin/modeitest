import Vue from "vue";
import Router from "vue-router";
import HomePage from "./components/HomePage";
import CompanyProfile from "./components/CompanyProfile";
import AboutInstitutePage from "./components/AboutInstitutePage";
// ServicesPage import removed - replaced with MembershipPage
import NewsPage from "./components/NewsPage";
import FaqPage from "./components/FaqPage";
import PublicationsMemberPage from "./components/PublicationsMemberPage";
import PublicationsPublicPage from "./components/PublicationsPublicPage";
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
import EconomicReportManagement from "./views/admin/EconomicReportManagement";
import NoticeManagement from "./views/admin/NoticeManagement";
import InquiryManagement from "./views/admin/InquiryManagement";
import MediaManagement from "./views/admin/MediaManagement";
import PageEditForm from "./views/admin/PageEditForm";
import NewPageEditForm from "./views/admin/NewPageEditForm";
import SeminarEditForm from "./views/admin/SeminarEditForm";
import SeminarRegistrationApproval from "./views/admin/SeminarRegistrationApproval";
import PublicationEditForm from "./views/admin/PublicationEditForm";
import NoticeEditForm from "./views/admin/NoticeEditForm";
import MediaEditForm from "./views/admin/MediaEditForm";
import MailGroupManagement from "./views/admin/MailGroupManagement";
import EmailCampaignManagement from "./views/admin/EmailCampaignManagement";
import PublicationDetailPage from "./components/PublicationDetailPage";
import NewsDetailPage from "./components/NewsDetailPage";
import SeminarPage from "./components/SeminarPage";
import CurrentSeminarsPage from "./components/CurrentSeminarsPage";
import PastSeminarsPage from "./components/PastSeminarsPage";
import SeminarDetailPage from "./components/SeminarDetailPage";
import SeminarDetailReservedPage from "./components/SeminarDetailReservedPage";
import SeminarDetailJoinPage from "./components/SeminarDetailJoinPage";
import GlossaryPage from "./components/GlossaryPage";
import EconomicIndicatorsPage from "./components/EconomicIndicatorsPage";
import EconomicStatisticsPage from "./components/EconomicStatisticsPage";
import EconomicStatisticsDetailPage from "./components/EconomicStatisticsDetailPage";
import EconomicStatisticsDetailPageGuest from "./components/EconomicStatisticsDetailPageGuest";
import TransactionLawPage from "./components/TransactionLawPage";
import PrivacyPolicyPage from "./components/PrivacyPolicyPage";
import TermsOfServicePage from "./components/TermsOfServicePage";
import CriConsultingPage from "./components/CRIConsultingPage";
import SitemapPage from "./components/SitemapPage";
import FinancialReportPage from "./components/FinancialReportPage";
import TestPage from "./components/TestPage";
import ContactFormPage from "./components/ContactFormPage";
import ContactConfirmPage from "./components/ContactConfirmPage";
import ContactCompletePage from "./components/ContactCompletePage";
import MemberLoginPage from "./views/MemberLoginPage";

import MyAccountPage from "./views/MyAccountPage";
import UpgradePage from "./views/UpgradePage";
import MembershipPage from "./components/MembershipPage";
import PremiumMembershipPage from "./components/PremiumMembershipPage.vue";

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
      component: CompanyProfile,
      meta: { title: "会社概要 - ちくぎん地域経済研究所" }
    },
    {
      path: "/about-institute",
      name: "aboutInstitute",
      component: AboutInstitutePage,
      meta: { title: "ちくぎん地域経済研究所について - ちくぎん地域経済研究所" }
    },
    {
      path: "/company-profile",
      name: "companyProfile",
      component: CompanyProfile,
      meta: { title: "会社概要 - ちくぎん地域経済研究所" }
    },
    {
      path: "/services",
      name: "services",
      component: MembershipPage,
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
      meta: { title: "よくある質問 - ちくぎん地域経済研究所" }
    },
    {
      path: "/publications",
      name: "publications",
      component: PublicationsMemberPage,
      meta: { title: "刊行物（会員） - ちくぎん地域経済研究所" }
    },
    {
      path: "/publications-public",
      name: "publicationsPublic",
      component: PublicationsPublicPage,
      meta: { title: "刊行物（一般） - ちくぎん地域経済研究所" }
    },
    {
      path: "/publications/:id",
      name: "publicationDetail",
      component: PublicationDetailPage,
    },
    {
      path: "/publications-public/:id",
      name: "publicationPublicDetail",
      component: PublicationDetailPage,
    },
    {
      path: "/seminars",
      name: "seminars",
      component: SeminarPage,
      meta: { title: "セミナー - ちくぎん地域経済研究所" }
    },
    {
      path: "/seminars/current",
      name: "currentSeminars",
      component: CurrentSeminarsPage,
      meta: { title: "受付中のセミナー - ��くぎん地域経済研究所" }
    },
    {
      path: "/seminars/past",
      name: "pastSeminars",
      component: PastSeminarsPage,
      meta: { title: "過去のセミナー - ちくぎん地域経済研究所" }
    },
    {
      path: "/seminars/:id",
      name: "seminarDetail",
      component: SeminarDetailPage,
      meta: { title: "セミナー詳細（予約受付中） - ちくぎん地域経済研究所" }
    },
    {
      path: "/seminars/:id/reserved",
      name: "seminarDetailReserved",
      component: SeminarDetailReservedPage,
      meta: { title: "セミナー詳細（予約済み） - ちくぎん地域経済研究所" }
    },
    {
      path: "/seminars/:id/join",
      name: "seminarDetailJoin",
      component: SeminarDetailJoinPage,
      meta: { title: "セミナー詳細（今すぐ参加） - ちくぎん地域経済研究所" }
    },
    {
      path: "/apply",
      name: "apply",
      component: ApplicationFormPage,
    },
    {
      path: "/glossary",
      name: "glossary",
      component: GlossaryPage,
      meta: { title: "用語集 - ちくぎん地域経済研究所" }
    },
    {
      path: "/economic-indicators",
      name: "economicIndicators",
      component: EconomicIndicatorsPage,
      meta: { title: "経済指標一覧 - ちくぎん地域経済研究所" }
    },
    {
      path: "/statistics",
      name: "statistics",
      component: EconomicStatisticsPage,
      meta: { title: "経済・調査統計 - ちくぎん地域経済研究所" }
    },
    {
      path: "/economic-statistics/:id/detail",
      name: "economicStatisticsDetail",
      component: EconomicStatisticsDetailPage,
      meta: { title: "経済・調査統計詳細 - ちくぎん地域経済研究所" }
    },
    {
      path: "/economic-statistics/:id/detail-guest",
      name: "economicStatisticsDetailGuest",
      component: EconomicStatisticsDetailPageGuest,
      meta: { title: "経済・調査統計詳細 - ちくぎん地域経済研究所" }
    },
    {
      path: "/transaction-law",
      name: "transactionLaw",
      component: TransactionLawPage,
      meta: { title: "特定商取引法に関する表記 - ちくぎん地域経済研究所" }
    },
    {
      path: "/privacy-policy",
      name: "privacyPolicy",
      component: PrivacyPolicyPage,
      meta: { title: "プライバシーポリシー - ちくぎん地域経済研究所" }
    },
    {
      path: "/terms-of-service",
      name: "termsOfService",
      component: TermsOfServicePage,
      meta: { title: "利用規約 - ちくぎん地域経済研究所" }
    },
    {
      path: "/cri-consulting",
      name: "criConsulting",
      component: CriConsultingPage,
      meta: { title: "CRI経営コンサルティング - ちくぎん地域経���研究所" }
    },
    {
      path: "/contact",
      name: "contact",
      component: ContactFormPage,
      meta: { title: "お問い合わせ - ちくぎん地域経済研究所" }
    },
    {
      path: "/contact/confirm",
      name: "contactConfirm",
      component: ContactConfirmPage,
      meta: { title: "お問い合わせ確認 - ちくぎん地域経済研究所" }
    },
    {
      path: "/contact/complete",
      name: "contactComplete",
      component: ContactCompletePage,
      meta: { title: "お問い合わせ完了 - ちくぎん地域経済研究所" }
    },
    {
      path: "/sitemap",
      name: "sitemap",
      component: SitemapPage,
      meta: { title: "サイトマップ - ちくぎん地域経済研究所" }
    },
    {
      path: "/financial-reports",
      name: "financialReports",
      component: FinancialReportPage,
      meta: { title: "決算報告 - ちくぎん地域経済研究所" }
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
      meta: { title: "管理ダッシュボード - ちくぎん地��経済研究所" }
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
      path: "/admin/seminars/:id/registrations",
      name: "seminarRegistrations",
      component: SeminarRegistrationApproval,
      meta: { title: "セミナー申込承認 - ちくぎん地域経済研究所" }
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
      path: "/admin/economic-reports",
      name: "economicReportManagement",
      component: EconomicReportManagement,
      meta: { title: "経済統計レポート管理 - ちくぎん地域経済研究所" }
    },
    {
      path: "/admin/notices",
      name: "noticeManagement",
      component: NoticeManagement,
      meta: { title: "お知らせ管理 - ちくぎん地域経済研究所" }
    },
    {
      path: "/admin/mail-groups",
      name: "mailGroupManagement",
      component: MailGroupManagement,
      meta: { title: "メールグループ管理 - ちくぎん地域経済研究所" }
    },
    {
      path: "/admin/emails",
      name: "emailCampaignManagement",
      component: EmailCampaignManagement,
      meta: { title: "メール配信 - ちくぎん地域経済研究所" }
    },
    // Mail magazine route aliases
    {
      path: "/admin/mailmagazine",
      name: "mailMagazine",
      component: EmailCampaignManagement,
      meta: { title: "一括メール管理 - ちくぎん地域経済研究所" }
    },
    {
      path: "/admin/mailmagazine/new",
      name: "mailMagazineNew",
      component: EmailCampaignManagement,
      meta: { title: "一括メール新規作成 - ちくぎん地域経済研究所" }
    },
    {
      path: "/admin/mailmagazine/edit",
      name: "mailMagazineEdit",
      component: EmailCampaignManagement,
      meta: { title: "一括メール編集 - ちくぎん地域経済研究所" }
    },
    {
      path: "/admin/mailmagazine/preview",
      name: "mailMagazinePreview",
      component: EmailCampaignManagement,
      meta: { title: "一括メールプレビュー - ちくぎん地域経済研究所" }
    },
    {
      path: "/admin/mailmagazine/group",
      name: "mailMagazineGroup",
      component: MailGroupManagement,
      meta: { title: "一括メール送信グループ管理 - ちくぎん地域経済研究所" }
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
      path: "/admin/inquiries",
      name: "inquiryManagement",
      component: InquiryManagement,
      meta: { title: "お問い合わせ管理 - ちくぎん地域経済研究所" }
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
      component: MembershipPage,
      meta: { title: "入会案内 - ちくぎん地域経済研究所" }
    },
    {
      path: "/membership",
      name: "membership",
      component: MembershipPage,
      meta: { title: "入会案内 - ちくぎん地域経済研究所" }
    },
    {
      path: "/membership/standard",
      name: "standardMembership",
      component: MembershipPage,
      meta: { title: "スタンダード会員のご案内 - ちくぎん地域経済研究所" }
    },
    {
      path: "/membership/premium",
      name: "premiumMembership",
      component: PremiumMembershipPage,
      meta: { title: "プレミアム会員の特典 - ちくぎん地域経済研究所" }
    },
    {
      path: "/my-account",
      name: "myAccount",
      component: MyAccountPage,
      meta: { title: "マイアカウント - ちくぎん地域経済研究所" }
    },
    {
      path: "/member-directory",
      name: "memberDirectory",
      component: () => import('./views/MemberDirectoryPage.vue'),
      meta: { title: "会員名簿 - ちくぎん地域経済研究所" }
    },
    {
      path: "/member-favorites",
      name: "memberFavorites",
      component: () => import('./views/MemberFavoritesPage.vue'),
      meta: { title: "お気に入り会員 - ちくぎん地域経済研究所" }
    },
    {
      path: "/upgrade",
      name: "upgrade",
      component: UpgradePage,
      meta: { title: "プランアップグレード - ちくぎん地域経済研究所" }
    },
    {
      path: "/seminar-join/:id",
      name: "seminarJoin",
      component: SeminarDetailJoinPage,
      meta: { title: "セミナー参加 - ちくぎん地域経済研究所" }
    },
    {
      path: "/seminar-room/:id",
      name: "seminarRoom",
      component: SeminarDetailJoinPage,
      meta: { title: "セミナールーム - ちくぎん地域経済研究所" }
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
