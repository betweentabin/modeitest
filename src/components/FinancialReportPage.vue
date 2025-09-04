<template>
  <div class="page-container">
    <Navigation />
    
    <!-- Hero Section -->
    <HeroSection 
      :title="pageTitle"
      :subtitle="pageSubtitle"
      heroImage="/img/hero-image.png"
    />
    
    <!-- Breadcrumbs -->
    <Breadcrumbs :breadcrumbs="[pageTitle]" />

    <div class="page-content">
      <div class="content-header">
        <h2 class="page-title">{{ pageTitle }}</h2>
        <div class="title-decoration">
          <div class="line-left"></div>
          <span class="title-english">{{ pageSubtitle }}</span>
          <div class="line-right"></div>
        </div>
      </div>

      <!-- CMS Body (optional) -->
      <CmsBlock page-key="financial-reports" wrapper-class="cms-body" />

      <!-- Financial Reports -->
      <div class="reports-container">
        <!-- 2025年3月期 -->
        <div class="report-section">
          <h3 class="report-year">2025年3月期</h3>
          <div class="report-date">決算短信（2020年5月12日）</div>
          <ul class="report-list">
            <li class="report-item">
              <span class="report-title">決算短信（2020年5月12日）</span>
            </li>
            <li class="report-item">
              <span class="report-title">決算説明資料（PDF・1,285KB・全3ページ）</span>
            </li>
            <li class="report-item">
              <span class="report-title">決算説明資料【第2期（決算説明）資料】（PDF・334KB・全2ページ）</span>
            </li>
            <li class="report-item">
              <span class="report-title">決算報告書【第1期（決算メンバー）】スピーチ（PDF・626KB・全1ページ）</span>
            </li>
            <li class="report-item">
              <span class="report-title">メディアの売上実績配信の利益を見いただいたより上げす</span>
            </li>
          </ul>
        </div>

        <!-- 2024年3月期 -->
        <div class="report-section">
          <h3 class="report-year">2024年3月期</h3>
          <div class="report-date">決算短信（2020年5月12日）</div>
          <ul class="report-list">
            <li class="report-item">
              <span class="report-title">決算短信（2020年5月12日）</span>
            </li>
            <li class="report-item">
              <span class="report-title">決算説明（PDF・1,285KB・全3ページ）</span>
            </li>
            <li class="report-item">
              <span class="report-title">決算説明資料【第2期（決算説明）資料】（PDF・334KB・全2ページ）</span>
            </li>
            <li class="report-item">
              <span class="report-title">決算報告書【第1期（決算メンバー）】スピーチ（PDF・626KB・全1ページ）</span>
            </li>
            <li class="report-item">
              <span class="report-title">メディアの売上実績配信の利益を見いただいたより上げす</span>
            </li>
          </ul>
        </div>

        <!-- 2023年3月期 -->
        <div class="report-section">
          <h3 class="report-year">2023年3月期</h3>
          <div class="report-date">決算短信（2020年5月12日）</div>
          <ul class="report-list">
            <li class="report-item">
              <span class="report-title">決算短信（2020年5月12日）</span>
            </li>
            <li class="report-item">
              <span class="report-title">決算説明（PDF・1,285KB・全3ページ）</span>
            </li>
            <li class="report-item">
              <span class="report-title">決算説明資料【第2期（決算説明）資料】（PDF・334KB・全2ページ）</span>
            </li>
            <li class="report-item">
              <span class="report-title">決算報告書【第1期（決算メンバー）】スピーチ（PDF・626KB・全1ページ）</span>
            </li>
            <li class="report-item">
              <span class="report-title">メディアの売上実績配信の利益を見いただいたより上げす</span>
            </li>
          </ul>
        </div>
      </div>

      <!-- Action Buttons -->
      <ActionButton 
        :primaryText="ctaPrimaryText"
        :secondaryText="ctaSecondaryText"
        maxWidth="1500px"
        @primary-click="goToContact"
        @secondary-click="goToMember"
      />
    </div>

    <!-- Contact CTA Section -->
    <ContactSection />

    <!-- Access Section -->
    <AccessSection />

    <!-- Footer Navigation -->
    <Footer v-bind="frame132131753022Props" />

    <!-- Fixed Side Buttons -->
    <FixedSideButtons position="bottom" />
  </div>
</template>

<script>
import Navigation from "./Navigation.vue";
import Footer from "./Footer.vue";
import Group27 from "./Group27.vue";
import HeroSection from "./HeroSection.vue";
import Breadcrumbs from "./Breadcrumbs.vue";
import ContactSection from "./ContactSection.vue";
import AccessSection from "./AccessSection.vue";
import FixedSideButtons from "./FixedSideButtons.vue";
import ActionButton from "./ActionButton.vue";
import { frame132131753022Data } from "../data.js";
import { usePageText } from '@/composables/usePageText'

export default {
  name: "FinancialReportPage",
  components: {
    Navigation,
    Footer,
    Group27,
    HeroSection,
    Breadcrumbs,
    ContactSection,
    AccessSection,
    FixedSideButtons,
    ActionButton
  },
  mounted() {
    try {
      this._pageText = usePageText(this.pageKey)
      this._pageText.load()
    } catch(e) { /* noop */ }
  },
  data() {
    return {
      pageKey: 'financial-reports',
      frame132131753022Props: frame132131753022Data,
    };
  },
  computed: {
    _pageRef() { return this._pageText?.page?.value },
    pageTitle() { return this._pageText?.getText('page_title', '決算報告') || '決算報告' },
    pageSubtitle() { return this._pageText?.getText('page_subtitle', 'Financial Report') || 'Financial Report' },
    ctaPrimaryText() { return this._pageText?.getText('cta_primary', 'お問い合わせはコチラ') || 'お問い合わせはコチラ' },
    ctaSecondaryText() { return this._pageText?.getText('cta_secondary', '入会はコチラ') || '入会はコチラ' },
  },
  methods: {
    goToContact() {
      const link = this._pageText?.getLink('cta_primary', '/contact') || '/contact'
      this.$router.push(link);
    },
    goToMember() {
      const link = this._pageText?.getLink('cta_secondary', '/register') || '/register'
      this.$router.push(link);
    }
  }
};
</script>

<style scoped>
.page-container {
  min-height: 100vh;
  background-color: #ECECEC;
}

/* Page Content */
.page-content {
  width: 100%;
  margin: 0 auto;
  padding: 70px 50px;
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
  justify-content: center;
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

/* Reports Container */
.reports-container {
  background: white;
  max-width: 1500px;
  margin: 0 auto 50px;
  padding: 50px;
  border-radius: 15px;
}

.report-section {
  padding: 30px;
  border-bottom: 0.5px dashed #B0B0B0;
}

.report-section:first-child {
  border-top: 0.5px dashed #B0B0B0;
}

.report-year {
  font-size: 1.3rem;
  color: #1A1A1A;
  font-weight: bold;
  margin-bottom: 15px;
}

.report-date {
  color: #666;
  font-size: 0.95rem;
  margin-bottom: 20px;
}

.report-list {
  list-style: none;
}

.report-item {
  padding: 12px 0;
  position: relative;
  padding-left: 20px;
}

.report-item:before {
  content: '•';
  position: absolute;
  left: 0;
  color: #0066cc;
  font-size: 1.2rem;
  font-weight: bold;
}

.report-item:last-child {
  border-bottom: none;
}

.report-title {
  color: #0066cc;
  font-size: 0.95rem;
  line-height: 1.6;
  cursor: pointer;
  transition: color 0.3s;
}

.report-title:hover {
  color: #da5761;
}



/* Responsive Design */
@media (max-width: 1150px) {
  .page-content {
    padding: 60px 40px !important;
  }
  
  .page-title {
    font-size: 32px !important;
  }
  
  .title-english {
    font-size: 18px !important;
  }
  
  .reports-container {
    padding: 45px 40px !important;
  }
  
  .report-year {
    font-size: 22px !important;
  }
  
  .report-date {
    font-size: 18px !important;
  }
  
  .report-title {
    font-size: 18px !important;
  }
}

@media (max-width: 900px) {
  .page-content {
    padding: 55px 35px !important;
  }
  
  .page-title {
    font-size: 29px !important;
  }
  
  .title-english {
    font-size: 17px !important;
  }
  
  .reports-container {
    padding: 40px 35px !important;
  }
  
  .report-year {
    font-size: 20px !important;
  }
  
  .report-date {
    font-size: 17px !important;
  }
  
  .report-title {
    font-size: 17px !important;
  }
}

@media (max-width: 768px) {
  .page-content {
    padding: 40px 15px !important;
  }
  
  .page-title {
    font-size: 27px !important;
  }
  
  .title-english {
    font-size: 16px !important;
  }
  
  .reports-container {
    padding: 30px 20px !important;
  }
  
  .report-section {
    padding: 20px !important;
  }
  
  .report-year {
    font-size: 19px !important;
  }
  
  .report-date {
    font-size: 16px !important;
  }
  
  .report-title {
    font-size: 16px !important;
  }
}

@media (max-width: 480px) {
  .page-content {
    padding: 30px 15px !important;
  }
  
  .page-title {
    font-size: 22px !important;
  }
  
  .title-english {
    font-size: 13px !important;
  }
  
  .reports-container {
    padding: 20px 15px !important;
  }
  
  .report-section {
    padding: 15px !important;
  }
  
  .report-year {
    font-size: 18px !important;
  }
  
  .report-date {
    font-size: 13px !important;
  }
  
  .report-title {
    font-size: 13px !important;
  }
}


</style>
