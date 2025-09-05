<template>
  <div class="terms-of-service-page">
    <!-- Navigation -->
    <navigation />
    
    <!-- Hero Section -->
    <HeroSection 
      :title="pageTitle"
      :subtitle="pageSubtitle"
      heroImage="https://api.builder.io/api/v1/image/assets/TEMP/6ed4aab7cb9aa3b95164dd2e5f305cafc76aa530?width=2880"
      mediaKey="hero_terms"
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

      <CmsBlock page-key="terms" wrapper-class="cms-body" />
      <div class="content-container">
        <!-- Introduction -->
        <div class="intro-section">
          <p class="intro-text">
            このウェブサイトhttp://www.chikugin-ri.co.jp/（以下｢当ウェブサイト｣といいます）は、株式会社 ちくぎん地域経済研究所（以下｢当研究所｣といいます）が運営しています。<br>
            ご利用にあたっては、以下の注意事項等をお読みになり、ご了解いただいたうえでご利用ください。なお、当研究所は当ウェブサイトの利用条件を予告なしに変更することがありますので、最新の利用条件をご確認ください。
          </p>
        </div>

        <!-- Terms of Service Sections -->
        <div class="policy-section">
          <h3 class="section-title">著作権等について</h3>
          <p class="section-content">
            当ウェブサイトに掲載された全ての内容（情報、商標、デザイン等）の著作権その他の知的財産権は、当研究所又は権限ある第三者に帰属します。したがって、それらを無断で使用、複製、改変することを禁じます。
          </p>
        </div>

        <div class="policy-section">
          <h3 class="section-title">リンクについて</h3>
          <p class="section-content">
            当ウェブサイトから、リンクやバナーによって他のウェブサイトへ移動できる場合があります。移動した先のウェブサイトは当研究所が運営するものではありません。したがって、その内容等について当研究所は責任を負いかねますのでご了承ください。
          </p>
        </div>

        <div class="policy-section">
          <h3 class="section-title">免責事項</h3>
          <p class="section-content">
            当ウェブサイトに掲載された情報、また、当ウェブサイトを利用することで生じたいかなるトラブル、損失、損害に対して、当研究所は責任を負いません。.6%の割合による遅延損害金を支払うものとします。<br>
            当ウェブサイトは、予告なしに運営の中断や、内容の変更を行うことがあります。これによって生じたいかなるトラブル、損失、損害に対しても、当研究所は責任を負いません。
          </p>
        </div>

        <div class="policy-section">
          <h3 class="section-title">セキュリティについて</h3>
          <p class="section-content">
            当ウェブサイトでは、不正アクセス、紛失、破壊、改ざん、漏えい等のトラブルを防止するために、セキュリティを高めるための取組みを継続的に実施していますが、かかる事故が一切発生しないことを保証するものではありません。<br>
            なお、当ウェブサイトからダウンロードする情報に含まれる可能性のあるコンピュータウィルス等への予防措置は利用者ご自身の責任でお取りください。
          </p>
        </div>

        <div class="policy-section">
          <h3 class="section-title">クッキー(Cookie)について</h3>
          <p class="section-content">
            当ウェブサイトでは、お客さまへの適切な情報の提供や、セキュリティの確保を目的に、クッキー(Cookie)を使用することがあります。<br>
            クッキー(Cookie)とは、お客さまがウェブサイトにアクセスする際に、ウェブサイトを通じてお客さまの端末に一定のテキストファイル(情報)を格納し、次回お客さまが同一のウェブサイトにアクセスする際にお客さまを識別できるようにする技術のことです。なお、ブラウザの設定によりクッキー(Cookie)の受入れを停止することもできます。
          </p>
        </div>

        <div class="policy-section">
          <h3 class="section-title">ご利用環境について</h3>
          <p class="section-content">
            このサイトはInternet Explorer7.0以上ならびにFirefox4.0以上のバージョンでのご利用を推奨しております。
          </p>
        </div>

        <div class="policy-section">
          <h3 class="section-title">禁止される行為</h3>
          <p class="section-content">
            当研究所は、利用者に通知することなく、本サービスの内容を変更しまたは本サービスの提供を中止することができるものとし、これによって利用者に生じた損害について一切の責任を負いません。
          </p>
        </div>

        <div class="policy-section">
          <h3 class="section-title">第8条（利用規約の変更）</h3>
          <p class="section-content">
            (1) 営利の目的で（但し、当研究所との取引を除く）、当ウェブサイト又は当ウェブサイト上の情報を使用又は複製すること<br>
            (2) 当ウェブサイト上の情報に何らかの改変を加えること<br>
            (3) 当研究所の事前の同意を得ることなく当ウェブサイトへのリンクを行うこと<br>
            (4) 当ウェブサイトのうち、一般からのアクセスが意図されていない部分にアクセスすること<br>
            (5) 当ウェブサイトのコードを複製すること<br>
            (6) システムの脆弱性を試すこと又はセキュリティもしくは認証システムを破ること<br>
            (7) 有害なコンピュータプログラム等を送信または書き込むこと<br>
            (8) 当研究所または第三者を誹謗中傷し、またはその名誉・信用を害すること<br>
            (9) 法令に違反する行為を行うこと<br>
            (10) その他当研究所が不適切と認める行為を行うこと<br>
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
  name: "TermsOfServicePage",
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
  mounted() {
    this.adjustRectangleHeight();
    window.addEventListener('resize', this.adjustRectangleHeight);
    try {
      this._pageText = usePageText('terms')
      this._pageText.load()
    } catch(e) { /* noop */ }
  },
  beforeDestroy() {
    window.removeEventListener('resize', this.adjustRectangleHeight);
  },
  computed: {
    _pageRef() { return this._pageText?.page?.value },
    pageTitle() { return this._pageText?.getText('page_title', '利用規約') || '利用規約' },
    pageSubtitle() { return this._pageText?.getText('page_subtitle', 'terms of service') || 'terms of service' },
  },
  methods: {
    adjustRectangleHeight() {
      this.$nextTick(() => {
        const frame1321317466 = this.$el.querySelector('.frame-1321317466');
        const rectangle3 = this.$el.querySelector('.rectangle-3');
        
        if (frame1321317466 && rectangle3) {
          const frameHeight = frame1321317466.offsetHeight;
          rectangle3.style.height = frameHeight + 'px';
        }
      });
    }
  }
};
</script>

<style scoped>
.terms-of-service-page {
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
  white-space: nowrap;
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



/* Footer Navigation */



/* Responsive Design */
@media (max-width: 1150px) {
  .frame-1321317467-1 {
    flex-direction: column !important;
    gap: 20px !important;
  }
  
  .rectangle-3 {
    width: 100% !important;
    max-width: none !important;
    order: 2 !important;
  }
  
  .frame-1321317466 {
    order: 1 !important;
  }
  
  .hero-title {
    font-size: 32px !important;
  }
  
  .hero-subtitle {
    font-size: 18px !important;
  }
  
  .main-content {
    padding: 50px 30px !important;
  }
  
  .content-container {
    padding: 30px 20px !important;
  }
  
  .content-header {
    gap: 25px !important;
  }
  
  .page-title {
    font-size: 32px !important;
  }
  
  .decoration-text {
    font-size: 18px !important;
  }
  
  .transaction-law-table {
    padding: 50px 30px !important;
  }
  
  .table-label {
    font-size: 18px !important;
  }
  
  .table-value {
    font-size: 18px !important;
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
  
  .company-address {
    font-size: 18px !important;
  }
  
  .copyright {
    font-size: 18px !important;
  }
  
  .footer-section {
    padding: 50px 30px !important;
  }
}

@media (max-width: 900px) {
  .hero-title {
    font-size: 29px !important;
  }
  
  .hero-subtitle {
    font-size: 17px !important;
  }
  
  .main-content {
    padding: 30px 20px !important;
  }
  
  .content-container {
    padding: 30px 20px !important;
  }
  
  .content-header {
    gap: 22px !important;
  }
  
  .page-title {
    font-size: 29px !important;
  }
  
  .decoration-text {
    font-size: 17px !important;
  }
  
  .transaction-law-table {
    padding: 45px 25px !important;
  }
  
  .table-label {
    font-size: 17px !important;
  }
  
  .table-value {
    font-size: 17px !important;
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
  
  .company-address {
    font-size: 17px !important;
  }
  
  .copyright {
    font-size: 17px !important;
  }
  
  .footer-section {
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
  
  .page-title {
    font-size: 27px !important;
  }
  
  .decoration-text {
    font-size: 16px !important;
  }
  
  .transaction-law-table {
    padding: 30px 20px !important;
  }
  
  .table-row {
    flex-direction: column !important;
    gap: 10px !important;
  }
  
  .table-label {
    min-width: auto !important;
    font-size: 16px !important;
  }
  
  .table-value {
    max-width: none !important;
    font-size: 16px !important;
  }
  
  .table-value-with-button {
    flex-direction: column !important;
    gap: 15px !important;
    width: 100% !important;
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

  .hero-title {
    font-size: 27px !important;
  }
  
  .hero-subtitle {
    font-size: 16px !important;
  }
  
  .company-address {
    font-size: 16px !important;
  }
  
  .copyright {
    font-size: 16px !important;
  }

  .footer-section {
    padding: 30px 20px !important;
  }

  .footer-navigation {
    flex-direction: column !important;
    gap: 30px !important;
  }

  .footer-column {
    width: 100% !important;
  }

  .company-logo-section {
    flex-direction: column !important;
    text-align: center !important;
  }
}

@media (max-width: 480px) {
  .hero-title {
    font-size: 22px !important;
  }
  
  .hero-subtitle {
    font-size: 13px !important;
  }
  
  .main-content {
    padding: 20px 15px !important;
  }
  
  .content-container {
    padding: 20px 15px !important;
  }
  
  .content-header {
    gap: 18px !important;
  }
  
  .page-title {
    font-size: 22px !important;
  }
  
  .decoration-text {
    font-size: 13px !important;
  }
  
  .transaction-law-table {
    padding: 20px 15px !important;
  }
  
  .table-label {
    font-size: 13px !important;
  }
  
  .table-value {
    font-size: 13px !important;
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
  
  .company-address {
    font-size: 13px !important;
  }
  
  .copyright {
    font-size: 13px !important;
  }
  
  .footer-section {
    padding: 20px 15px !important;
  }
}
</style>
