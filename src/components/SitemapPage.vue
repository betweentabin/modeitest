<template>
  <div class="sitemap-page">
    <!-- Navigation -->
    <navigation />
    
    <!-- Hero Section -->
    <HeroSection 
      :title="pageTitle"
      :subtitle="pageSubtitle"
      cms-page-key="sitemap"
      heroImage="https://api.builder.io/api/v1/image/assets/TEMP/6ed4aab7cb9aa3b95164dd2e5f305cafc76aa530?width=2880"
      mediaKey="hero_sitemap"
    />

    <!-- Breadcrumbs -->
    <Breadcrumbs :breadcrumbs="[pageTitle]" />

    <!-- Main Content -->
    <div class="main-content">
      <div class="content-header">
        <h2 class="page-title">
          <CmsText pageKey="sitemap" fieldKey="page_title" tag="span" :fallback="pageTitle" />
        </h2>
        <div class="title-decoration">
          <div class="line-left"></div>
          <span class="title-english">
            <CmsText pageKey="sitemap" fieldKey="page_subtitle" tag="span" :fallback="pageSubtitle" />
          </span>
          <div class="line-right"></div>
        </div>
      </div>
      <!-- CMS Body (optional) -->
      <!-- CMS Body removed -->

      <div class="content-container">
                 <!-- Sitemap Content -->
         <div class="sitemap-section">
           <div class="sitemap-content">
            <p class="section-content">
              <CmsText pageKey="sitemap" fieldKey="intro" tag="span" :fallback="'当サイトの構造をご案内いたします。'" />
            </p>
            
            <!-- Sitemap Links -->
            <div class="sitemap-links">
              <div class="sitemap-category">
                <h4 class="category-title">
                  <CmsText pageKey="sitemap" fieldKey="cat_main" tag="span" :fallback="'メインページ'" />
                </h4>
                <ul class="link-list">
                  <li>
                    <router-link to="/" class="sitemap-link">
                      <CmsText pageKey="sitemap" fieldKey="link_home" tag="span" :fallback="'トップページ'" />
                    </router-link>
                  </li>
                  <li>
                    <router-link to="/company" class="sitemap-link">
                      <CmsText pageKey="sitemap" fieldKey="link_company" tag="span" :fallback="'会社概要'" />
                    </router-link>
                  </li>
                  <li>
                    <router-link to="/aboutus" class="sitemap-link">
                      <CmsText pageKey="sitemap" fieldKey="link_about" tag="span" :fallback="'研究所について'" />
                    </router-link>
                  </li>
                </ul>
              </div>
              
              <div class="sitemap-category">
                <h4 class="category-title">
                  <CmsText pageKey="sitemap" fieldKey="cat_services" tag="span" :fallback="'サービス'" />
                </h4>
                <ul class="link-list">
                  <li><router-link to="/seminar" class="sitemap-link"><CmsText pageKey="sitemap" fieldKey="link_seminar" tag="span" :fallback="'セミナー'" /></router-link></li>
                  <li><router-link to="/publication" class="sitemap-link"><CmsText pageKey="sitemap" fieldKey="link_publications" tag="span" :fallback="'刊行物'" /></router-link></li>
                  <li><router-link to="/consulting" class="sitemap-link"><CmsText pageKey="sitemap" fieldKey="link_consulting" tag="span" :fallback="'経営コンサルティング'" /></router-link></li>
                  <li><router-link to="/research" class="sitemap-link"><CmsText pageKey="sitemap" fieldKey="link_research" tag="span" :fallback="'調査・研究'" /></router-link></li>
                  <li><router-link to="/training" class="sitemap-link"><CmsText pageKey="sitemap" fieldKey="link_training" tag="span" :fallback="'人材育成'" /></router-link></li>
                </ul>
              </div>
              
              <div class="sitemap-category">
                <h4 class="category-title">
                  <CmsText pageKey="sitemap" fieldKey="cat_membership" tag="span" :fallback="'会員サービス'" />
                </h4>
                <ul class="link-list">
                  <li><router-link to="/membership" class="sitemap-link"><CmsText pageKey="sitemap" fieldKey="link_membership" tag="span" :fallback="'入会案内'" /></router-link></li>
                </ul>
              </div>
              
              <div class="sitemap-category">
                <h4 class="category-title">
                  <CmsText pageKey="sitemap" fieldKey="cat_info" tag="span" :fallback="'各種情報'" />
                </h4>
                <ul class="link-list">
                  <li><router-link to="/economic-indicators" class="sitemap-link"><CmsText pageKey="sitemap" fieldKey="link_indicators" tag="span" :fallback="'経済指標一覧'" /></router-link></li>
                  <li><router-link to="/economic-surveys" class="sitemap-link"><CmsText pageKey="sitemap" fieldKey="link_surveys" tag="span" :fallback="'経済調査統計一覧'" /></router-link></li>
                </ul>
              </div>
              
              <div class="sitemap-category">
                <h4 class="category-title">
                  <CmsText pageKey="sitemap" fieldKey="cat_support" tag="span" :fallback="'お知らせ・サポート'" />
                </h4>
                <ul class="link-list">
                  <li><router-link to="/news" class="sitemap-link"><CmsText pageKey="sitemap" fieldKey="link_news" tag="span" :fallback="'お知らせ'" /></router-link></li>
                  <li><router-link to="/faq" class="sitemap-link"><CmsText pageKey="sitemap" fieldKey="link_faq" tag="span" :fallback="'よくあるご質問'" /></router-link></li>
                  <li><router-link to="/contact" class="sitemap-link"><CmsText pageKey="sitemap" fieldKey="link_contact" tag="span" :fallback="'お問い合わせ'" /></router-link></li>
                </ul>
              </div>
              
              <div class="sitemap-category">
                <h4 class="category-title">
                  <CmsText pageKey="sitemap" fieldKey="cat_legal" tag="span" :fallback="'法的情報'" />
                </h4>
                <ul class="link-list">
                  <li><router-link to="/privacy" class="sitemap-link"><CmsText pageKey="sitemap" fieldKey="link_privacy" tag="span" :fallback="'プライバシーポリシー'" /></router-link></li>
                  <li><router-link to="/terms" class="sitemap-link"><CmsText pageKey="sitemap" fieldKey="link_terms" tag="span" :fallback="'利用規約'" /></router-link></li>
                  <li><router-link to="/legal" class="sitemap-link"><CmsText pageKey="sitemap" fieldKey="link_legal" tag="span" :fallback="'特定商取引法に関する表記'" /></router-link></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Action Button Section -->
    <ActionButton 
      :primaryText="ctaPrimaryText"
      :secondaryText="ctaSecondaryText"
      max-width="1200px"
      @primary-click="handleContactClick"
      @secondary-click="handleJoinClick"
    />

    <!-- Access Section -->
    <AccessSection />

    <!-- Footer Navigation -->
    <Footer v-bind="frame132131753022Props" />

    <!-- Fixed Side Buttons -->
    <FixedSideButtons position="bottom" />
  </div>
</template>

<script>
import AccessSection from './AccessSection.vue';
import Navigation from "./Navigation";
import Footer from "./Footer";
import Group27 from "./Group27";
import HeroSection from "./HeroSection.vue";
import Breadcrumbs from "./Breadcrumbs.vue";
import FixedSideButtons from "./FixedSideButtons.vue";
import ActionButton from "./ActionButton.vue";
import CmsText from '@/components/CmsText.vue'
import CmsBlock from '@/components/CmsBlock.vue'
import { usePageText } from '@/composables/usePageText'

import vector7 from "../../public/img/vector-7.svg";
import { frame132131753022Data } from "../data";

export default {
  name: "SitemapPage",
  components: {
    Navigation,
    Footer,
    Group27,
    AccessSection,
    HeroSection,
    Breadcrumbs,
    FixedSideButtons,
    ActionButton,
    CmsText,
    CmsBlock
  },
  data() {
    return {
      vector7: vector7,
      frame132131753022Props: frame132131753022Data,
      
    };
  },
  computed: {
    _pageRef() { return this._pageText?.page?.value },
    pageTitle() { return this._pageText?.getText('page_title', 'サイトマップ') || 'サイトマップ' },
    pageSubtitle() { return this._pageText?.getText('page_subtitle', 'sitemap') || 'sitemap' },
    ctaPrimaryText() { return this._pageText?.getText('cta_primary', 'お問い合わせはこちら') || 'お問い合わせはこちら' },
    ctaSecondaryText() { return this._pageText?.getText('cta_secondary', '入会はこちら') || '入会はこちら' },
  },
  mounted() {
    try {
      this._pageText = usePageText('sitemap')
      this._pageText.load()
    } catch(e) { /* noop */ }
  },
  methods: {
    handleContactClick() {
      const link = this._pageText?.getLink('cta_primary', '/contact') || '/contact'
      this.$router.push(link);
    },
    handleJoinClick() {
      const link = this._pageText?.getLink('cta_secondary', '/register') || '/register'
      this.$router.push(link);
    }
  }

};
</script>

<style scoped>
.sitemap-page {
  background: #ECECEC;
  min-height: 100vh;
  width: 100%;
}





/* Main Content */
.main-content {
  width: 100%;
  padding: 50px;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 40px;
}

.content-header {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 29px;
}

.page-title {
  color: #1A1A1A;
  font-family: var(--font-family-inter);
  font-size: 36px;
  font-weight: 700;
  line-height: 150%;
  margin: 0;
  text-align: center;
}

.title-decoration {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 20px;
  width: auto;
  min-width: 306px;
}

.line-left,
.line-right {
  width: 80px;
  height: 2px;
  background: #DA5761;
  flex-shrink: 0;
}

.title-english {
  color: #DA5761;
  font-family: var(--font-family-inter);
  font-size: 18px;
  font-weight: 400;
  line-height: 150%;
  text-transform: uppercase;
}

.content-container {
  width: 100%;
  max-width: 1200px;
  display: flex;
  flex-direction: column;
  gap: 40px;
}

/* Sitemap Section */
.sitemap-section {
  background: white;
  border-radius: 20px;
  padding: 50px;
}

.section-title {
  color: #1A1A1A;
  font-family: var(--font-family-inter);
  font-size: 24px;
  font-weight: 700;
  line-height: 150%;
  margin: 0 0 30px 0;
}

.section-content {
  color: #3F3F3F;
  font-family: var(--font-family-inter);
  font-size: 20px;
  font-weight: 400;
  line-height: 150%;
  margin-bottom: 30px;
}

.sitemap-links {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 40px;
}

.sitemap-category {
  display: flex;
  flex-direction: column;
  gap: 15px;
  position: relative;
  padding-right: 20px;
}

/* 3列の時: 1列目と2列目に縦線 */
@media (min-width: 500px) {
  .sitemap-category:nth-child(3n+1):not(:last-child)::after,
  .sitemap-category:nth-child(3n+2)::after {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 1px;
    height: 100%;
    background-color: #E0E0E0;
  }
}

.category-title {
  color: #DA5761;
  font-family: var(--font-family-inter);
  font-size: 18px;
  font-weight: 700;
  line-height: 150%;
  margin: 0;
  border-bottom: 2px solid #DA5761;
  padding-bottom: 5px;
}

.link-list {
  list-style: none;
  padding: 0;
  margin: 0;
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.sitemap-link {
  color: #3F3F3F;
  font-family: var(--font-family-inter);
  font-size: 16px;
  font-weight: 400;
  line-height: 150%;
  text-decoration: none;
  transition: color 0.3s ease;
  padding: 5px 0;
}

.sitemap-link:hover {
  color: #DA5761;
  text-decoration: underline;
}



/* Footer Navigation */



 /* Responsive Design */
 
 @media (max-width: 1150px) {
  .main-content {
    padding: 50px 30px !important;
  }

  .content-header {
    gap: 25px !important;
  }
  
  .page-title {
    font-size: 32px !important;
  }
  
  .title-english {
    font-size: 18px !important;
  }
  
  .section-content {
    font-size: 18px !important;
  }
  
  .sitemap-section {
    padding: 40px 30px;
  }
}

 @media (max-width: 900px) {
  .main-content {
    padding: 30px 20px !important;
  }
  
  .content-header {
    gap: 22px !important;
  }
  
  .page-title {
    font-size: 29px !important;
  }
  
  .title-english {
    font-size: 17px !important;
  }
  
  .section-content {
    font-size: 17px !important;
  }
  
  .sitemap-section {
    padding: 30px 20px;
  }
  
  .sitemap-links {
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 30px;
  }
  
  .sitemap-category {
    padding-right: 15px;
  }
  
  /* 2列の時: 1、3、5個目に縦線 */
  .sitemap-category:nth-child(1)::after {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 1px;
    height: 100%;
    background-color: #F0F0F0;
  }
  
  .sitemap-category:nth-child(3)::after {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 1px;
    height: 100%;
    background-color: #F0F0F0;
  }
  
  .sitemap-category:nth-child(5)::after {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 1px;
    height: 100%;
    background-color: #F0F0F0;
  }
  
  /* 2、4番目の縦線を非表示 */
  .sitemap-category:nth-child(2)::after,
  .sitemap-category:nth-child(4)::after {
    display: none;
  }
}

 @media (max-width: 768px) {
  .main-content {
    padding: 30px 20px !important;
  }
  
  .sitemap-category {
    padding-right: 0;
  }
  
  .sitemap-category:nth-child(3n+1):not(:last-child)::after,
  .sitemap-category:nth-child(3n+2)::after {
    display: none;
  }
  
  .content-header {
    gap: 20px !important;
  }
  
  .page-title {
    font-size: 27px !important;
  }
  
  .title-english {
    font-size: 16px !important;
  }
  
  .section-content {
    font-size: 16px !important;
  }
  
  .sitemap-section {
    padding: 30px 15px;
  }
  
  .sitemap-links {
    grid-template-columns: 1fr;
    gap: 25px;
  }
  
  .category-title {
    font-size: 16px !important;
  }
  
  .sitemap-link {
    font-size: 15px !important;
  }
}

 @media (max-width: 480px) {
  .main-content {
    padding: 20px 15px !important;
  }
  
  .content-header {
    gap: 18px !important;
    margin-bottom: 20px;
  }
  
  .page-title {
    font-size: 22px !important;
  }
  
  .title-english {
    font-size: 13px !important;
  }
  
  .sitemap-section {
    padding: 20px 15px;
  }
  
  .sitemap-links {
    gap: 20px;
  }
  
  .category-title {
    font-size: 15px !important;
  }
  
  .sitemap-link {
    font-size: 13px !important;
  }
  
  .section-content {
    font-size: 13px !important;
  }
}
</style>
