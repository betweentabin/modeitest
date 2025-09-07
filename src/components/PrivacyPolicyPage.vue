<template>
  <div class="privacy-policy-page">
    <!-- Navigation -->
    <Navigation />
    
    <!-- Hero Section -->
    <HeroSection 
      :title="pageTitle"
      :subtitle="pageSubtitle"
      cms-page-key="privacy"
      heroImage="https://api.builder.io/api/v1/image/assets/TEMP/6ed4aab7cb9aa3b95164dd2e5f305cafc76aa530?width=2880"
      mediaKey="hero_privacy"
    />

    <!-- Breadcrumbs -->
    <Breadcrumbs :breadcrumbs="[pageTitle]" />

    <!-- Main Content -->
    <div class="main-content">
      <div class="content-header">
        <h2 class="page-title">{{ pageTitle }}</h2>
        <div class="title-decoration">
          <div class="line-left"></div>
          <span class="title-english">{{ pageSubtitle }}</span>
          <div class="line-right"></div>
        </div>
      </div>

      <CmsBlock page-key="privacy" wrapper-class="cms-body" />
      <div class="content-container" v-if="!hasHtml">
        <!-- Introduction -->
        <div class="intro-section">
          <p class="intro-text">
            当研究所では以下のプライバシーポリシーに基づき、お客様より提供を受けた個人情報を厳正な管理の元に保管し、
            当研究所の管理行においてのみ利用します。当研究所のサービスを利用した場合、当研究所のキャンペーンやアンケート等に応募した場合には、プライバシーポリシーに同意したものとみなされますので、本プライバシーポリシーの内容をご理解いただくようお願いいたします。
          </p>
        </div>

        <!-- Privacy Policy Sections -->
        <div class="policy-section">
          <h3 class="section-title">適切な取得</h3>
          <p class="section-content">
            当研究所では、当研究所の各種サービスをご利用いただくにあたって、個人の情報をお伺いする場合があります。お伺いする情報としては、会社名、役職、氏名、Ｅメールアドレス、電話番号などの個人情報が主なものとなります。また、それ以外にもアンケート調査のため、質問させていただくこともございます。これらの情報は、すべて下記の収集目的に従って、適法かつ公正な手段により収集されます。
          </p>
        </div>

        <div class="policy-section">
          <h3 class="section-title">個人情報を収集・利用する目的</h3>
          <p class="section-content">当研究所が個人情報を収集または利用する目的は以下のとおりです。</p>
          <div class="list-content">
            サービスの提供、キャンペーンなどを行うため<br>
            サービスに関する情報またはキャンペーン情報を提供するため<br>
            お客様から寄せられたご意見、ご要望にお答えするため<br>
            サービスの開発・改善を目的とした調査・検討を行うため<br>
            サービスに関する統計的資料を作成するため
          </div>
        </div>

        <div class="policy-section">
          <h3 class="section-title">情報の第三者への開示について</h3>
          <div class="list-content">
            法令により情報の開示が求められる場合<br>
            人の生命、身体または財産の保護のために必要があると当研究所が判断した場合<br>
            国の機関もしくは地方公共団体またはその委託を受けた者が法令の定める事務を遂行することに対して協力することその他公共の利益のために特に必要があると当研究所が判断した場合<br>
            お客様または当研究所の権利の確保のために必要であると当研究所が判断した場合<br>
            業務遂行に必要な限度で個人情報の取扱いを委託する場合
          </div>
        </div>

        <div class="policy-section">
          <h3 class="section-title">個人情報の訂正および削除</h3>
          <p class="section-content">
            お客様は、当研究所所定の手続きにより、以下の請求を行うことができます。                                                                          (1) 当研究所の保有する自己の個人情報が誤った情報でないことを確認すること                                                                             (2) 当研究所の保有する自己の個人情報が誤った情報である場合に、それを訂正または削除すること<br>
            当研究所は、前項(２)の個人情報の訂正または削除の可否を決定した場合には、遅滞なく、当該お客様に通知します。<br>
            これらの請求を希望される場合には、お問い合わせフォームよりご連絡ください。
          </p>
        </div>

        <div class="policy-section">
          <h3 class="section-title">免責事項</h3>
          <p class="section-content">
            当研究所では、お客様の個人情報を厳格に管理し、改ざん、漏えいや不正アクセス等の危険性に対して予防策を実施します。 個人情報の登録が発生するWebページではデータ送信の際にSSL(Secure Socket Layer)暗号化技術を使用しております。
          </p>
          <p class="section-content">
            ただし、各種申込フォームにお客様が入力されたメールアドレスが間違っている場合は責任を負いかねますのでご理解下さい。
          </p>
          <p class="section-content">
            ※各種申込フォームでは内容をお客様に確認していただくために、登録されたメールアドレスに申込情報を自動的に配信する仕組みになっています。そのため間違ったメールアドレスであっても、そのメールアドレスに申込情報が自動的に配信されます。
          </p>
        </div>

        <div class="policy-section">
          <h3 class="section-title">適切な取得</h3>
          <p class="section-content">
            当研究所サイトを利用された場合、お客様はプライバシーポリシーに同意して頂いたものと判断いたします。諸事情により、上記のプライバシーポリシーを部分的に変更、修正、 追加、削除させて頂くことがございます。加えて、プライバシーポリシーについては、変更等のご連絡をお客様にご連絡することはありません。随時、このページにてご確認ください。
          </p>
        </div>
      </div>
    </div>

    <!-- Access Section -->
    <AccessSection />

    <!-- Footer Navigation -->
    <Footer v-bind="frame132131753022Props" />

    <!-- Fixed Side Buttons -->
    <FixedSideButtons position="bottom" />
  </div>
</template>

<script>
import Navigation from "./Navigation";
import Footer from "./Footer";
import Group27 from "./Group27";
import AccessSection from "./AccessSection";
import HeroSection from "./HeroSection.vue";
import Breadcrumbs from "./Breadcrumbs.vue";
import FixedSideButtons from "./FixedSideButtons.vue";
import CmsBlock from './CmsBlock.vue'
import vector7 from "../../public/img/vector-7.svg";
import { frame132131753022Data } from "../data";
import { usePageText } from '@/composables/usePageText'

export default {
  name: "PrivacyPolicyPage",
  components: {
    Navigation,
    Footer,
    Group27,
    AccessSection,
    HeroSection,
    Breadcrumbs,
    FixedSideButtons,
    CmsBlock,
  },
  data() {
    return {
      vector7: vector7,
      frame132131753022Props: frame132131753022Data,
    };
  },
  computed: {
    _pageRef() { return this._pageText?.page?.value },
    pageTitle() { return this._pageText?.getText('page_title', 'プライバシーポリシー') || 'プライバシーポリシー' },
    pageSubtitle() { return this._pageText?.getText('page_subtitle', 'privacy policy') || 'privacy policy' },
    hasHtml() {
      try {
        const page = this._pageText?.page?.value
        const html = page?.content?.html
        return typeof html === 'string' && html.trim().length > 0
      } catch(_) { return false }
    }
  },
  mounted() {
    try {
      this._pageText = usePageText('privacy')
      this._pageText.load()
    } catch(e) { /* noop */ }
  },

};
</script>

<style scoped>
.privacy-policy-page {
  background: #ECECEC;
  min-height: 100vh;
  width: 100%;
}





/* Main Content */
.main-content {
  width: 100%;
  padding: 70px 50px;
  background: #ECECEC;
}

.content-header {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 29px;
  margin-bottom: 40px;
}

.page-title {
  font-family: Inter, -apple-system, Roboto, Helvetica, sans-serif;
  font-size: 36px;
  font-weight: 700;
  color: #1A1A1A;
  letter-spacing: -0.72px;
  text-align: center;
  margin: 0;
}

.title-decoration {
  display: flex;
  align-items: center;
  gap: 15px;
  width: auto;
  min-width: 306px;
}

.line-left, .line-right {
  width: 80px;
  height: 2px;
  background: #DA5761;
  flex-shrink: 0;
}

.title-english {
  font-family: Inter, -apple-system, Roboto, Helvetica, sans-serif;
  font-size: 20px;
  font-weight: 700;
  color: #DA5761;
}

.content-container {
  padding: 50px;
  border-radius: 20px;
  background: white;
  display: flex;
  flex-direction: column;
  gap: 50px;
  width: 100%;
  max-width: 2000px;
  margin: 0 auto;
}


.intro-section {
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.intro-text {
  font-family: Inter, -apple-system, Roboto, Helvetica, sans-serif;
  font-size: 18px;
  font-weight: 400;
  color: #3F3F3F;
  line-height: normal;
  margin: 0;
}

.policy-section {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.section-title {
  font-family: Inter, -apple-system, Roboto, Helvetica, sans-serif;
  font-size: 32px;
  font-weight: 700;
  color: #1A1A1A;
  margin: 0;
}

.section-content {
  font-family: Inter, -apple-system, Roboto, Helvetica, sans-serif;
  font-size: 18px;
  font-weight: 400;
  color: #3F3F3F;
  line-height: normal;
  margin: 0;
}

.list-content {
  font-family: Inter, -apple-system, Roboto, Helvetica, sans-serif;
  font-size: 18px;
  font-weight: 400;
  color: #3F3F3F;
  line-height: normal;
  margin: 0;
}

/* CMS body safe defaults (prevent layout break) */
.cms-body {
  width: 100%;
  max-width: 2000px;
  background: #FFF;
  border-radius: 20px;
  padding: 30px;
  overflow-wrap: anywhere;
}
.cms-body h1, .cms-body h2, .cms-body h3, .cms-body h4, .cms-body h5, .cms-body h6 {
  margin: 0.6em 0 0.4em;
  line-height: 1.3;
}
.cms-body p { margin: 0.6em 0; line-height: 1.6; }
.cms-body ul, .cms-body ol { padding-left: 1.4em; margin: 0.6em 0; }
.cms-body img { max-width: 100%; height: auto; }
.cms-body table { width: 100%; border-collapse: collapse; margin: 0.8em 0; }
.cms-body th, .cms-body td { border: 1px solid #E5E5E5; padding: 8px 10px; text-align: left; vertical-align: top; }

/* Footer Navigation */



/* Responsive Design */
@media (max-width: 1150px) {
  .main-content {
    padding: 50px 30px !important;
  }
  
  .content-container {
    padding: 30px 20px !important;
  }
  
  .content-header {
    gap: 25px !important;
  }
  
  .hero-title {
    font-size: 32px !important;
  }
  
  .page-title {
    font-size: 32px !important;
  }
  
  .section-title {
    font-size: 29px !important;
  }
  
  .intro-text {
    font-size: 18px !important;
  }
  
  .section-content {
    font-size: 18px !important;
  }
  
  .list-content {
    font-size: 18px !important;
  }
  
  .hero-overlay {
    padding: 50px 30px !important;
  }
}

@media (max-width: 900px) {
  .main-content {
    padding: 30px 20px !important;
  }
  
  .content-container {
    padding: 30px 20px !important;
  }
  
  .content-header {
    gap: 22px !important;
  }
  
  .hero-title {
    font-size: 29px !important;
  }
  
  .page-title {
    font-size: 29px !important;
  }
  
  .section-title {
    font-size: 27px !important;
  }
  
  .intro-text {
    font-size: 17px !important;
  }
  
  .section-content {
    font-size: 17px !important;
  }
  
  .list-content {
    font-size: 17px !important;
  }
  
  .hero-overlay {
    padding: 45px 25px !important;
  }
}

@media (max-width: 768px) {
  .main-content {
    padding: 30px 20px !important;
  }
  
  .content-container {
    padding: 30px 20px !important;
  }
  
  .content-header {
    gap: 20px !important;
  }
  
  .hero-title {
    font-size: 27px !important;
  }
  
  .page-title {
    font-size: 27px !important;
  }
  
  .section-title {
    font-size: 24px !important;
  }
  
  .intro-text {
    font-size: 16px !important;
  }
  
  .section-content {
    font-size: 16px !important;
  }
  
  .list-content {
    font-size: 16px !important;
  }
  
  .hero-overlay {
    padding: 30px 20px !important;
  }
}

@media (max-width: 480px) {
  .main-content {
    padding: 20px 15px !important;
  }
  
  .content-container {
    padding: 20px 15px !important;
  }
  
  .content-header {
    gap: 18px !important;
  }
  
  .hero-title {
    font-size: 22px !important;
  }
  
  .page-title {
    font-size: 22px !important;
  }
  
  .section-title {
    font-size: 20px !important;
  }
  
  .intro-text {
    font-size: 13px !important;
  }
  
  .section-content {
    font-size: 13px !important;
  }
  
  .list-content {
    font-size: 13px !important;
  }
  
  .hero-overlay {
    padding: 20px 15px !important;
  }
}
</style>
