<template>
  <div class="sitemap-page">
    <!-- Navigation -->
    <navigation />
    
    <!-- Hero Section -->
    <HeroSection 
      title="サイトマップ"
      subtitle="sitemap"
      heroImage="https://api.builder.io/api/v1/image/assets/TEMP/6ed4aab7cb9aa3b95164dd2e5f305cafc76aa530?width=2880"
    />

    <!-- Breadcrumbs -->
    <Breadcrumbs :breadcrumbs="['サイトマップ']" />

    <!-- Main Content -->
    <div class="main-content">
      <div class="content-header">
        <h2 class="page-title">サイトマップ</h2>
        <div class="title-decoration">
          <div class="line-left"></div>
          <span class="title-english">sitemap</span>
          <div class="line-right"></div>
        </div>
      </div>

      <div class="content-container">
                 <!-- Sitemap Content -->
         <div class="sitemap-section">
           <div class="sitemap-content">
            <p class="section-content">
              当サイトの構造をご案内いたします。
            </p>
            
            <!-- Sitemap Links -->
            <div class="sitemap-links">
              <div class="sitemap-category">
                <h4 class="category-title">メインページ</h4>
                <ul class="link-list">
                  <li><router-link to="/" class="sitemap-link">トップページ</router-link></li>
                  <li><router-link to="/company-profile" class="sitemap-link">会社概要</router-link></li>
                  <li><router-link to="/about-institute" class="sitemap-link">研究所について</router-link></li>
                </ul>
              </div>
              
              <div class="sitemap-category">
                <h4 class="category-title">サービス</h4>
                <ul class="link-list">
                  <li><router-link to="/seminar" class="sitemap-link">セミナー</router-link></li>
                  <li><router-link to="/publications" class="sitemap-link">刊行物</router-link></li>
                  <li><router-link to="/consulting" class="sitemap-link">経営コンサルティング</router-link></li>
                  <li><router-link to="/research" class="sitemap-link">調査・研究</router-link></li>
                  <li><router-link to="/training" class="sitemap-link">人材育成</router-link></li>
                </ul>
              </div>
              
              <div class="sitemap-category">
                <h4 class="category-title">会員サービス</h4>
                <ul class="link-list">
                  <li><router-link to="/member-pr" class="sitemap-link">会員PR</router-link></li>
                  <li><router-link to="/member-pr-dotcom" class="sitemap-link">会員PRどっとコム</router-link></li>
                  <li><router-link to="/membership" class="sitemap-link">入会案内</router-link></li>
                </ul>
              </div>
              
              <div class="sitemap-category">
                <h4 class="category-title">各種情報</h4>
                <ul class="link-list">
                  <li><router-link to="/economic-indicators" class="sitemap-link">経済指標一覧</router-link></li>
                  <li><router-link to="/economic-surveys" class="sitemap-link">経済調査統計一覧</router-link></li>
                </ul>
              </div>
              
              <div class="sitemap-category">
                <h4 class="category-title">お知らせ・サポート</h4>
                <ul class="link-list">
                  <li><router-link to="/news" class="sitemap-link">お知らせ</router-link></li>
                  <li><router-link to="/faq" class="sitemap-link">よくあるご質問</router-link></li>
                  <li><router-link to="/contact" class="sitemap-link">お問い合わせ</router-link></li>
                </ul>
              </div>
              
              <div class="sitemap-category">
                <h4 class="category-title">法的情報</h4>
                <ul class="link-list">
                  <li><router-link to="/privacy-policy" class="sitemap-link">プライバシーポリシー</router-link></li>
                  <li><router-link to="/terms-of-service" class="sitemap-link">利用規約</router-link></li>
                  <li><router-link to="/transaction-law" class="sitemap-link">特定商取引法に関する表記</router-link></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Action Button Section -->
    <ActionButton 
      primary-text="お問い合わせはコチラ"
      secondary-text="入会はコチラ"
      max-width="1200px"
      @primary-click="handleContactClick"
      @secondary-click="handleJoinClick"
    />

    <!-- Access Section -->
    <AccessSection />

    <!-- Footer Navigation -->
    <div class="navigation-footer">
      <Footer v-bind="frame132131753022Props" />
      <div class="vector-7-1"></div>
      <group27 />
    </div>

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
    ActionButton
  },
  data() {
    return {
      vector7: vector7,
      frame132131753022Props: frame132131753022Data,
      
    };
  },
  methods: {
    handleContactClick() {
      this.$router.push('/contact');
    },
    handleJoinClick() {
      this.$router.push('/register');
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
}

.title-decoration {
  display: flex;
  align-items: center;
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
  font-size: 16px;
  font-weight: 400;
  line-height: 150%;
  margin-bottom: 30px;
}

.sitemap-links {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 40px;
}

.sitemap-category {
  display: flex;
  flex-direction: column;
  gap: 15px;
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
.navigation-footer {
  background: #CFCFCF;
  padding: 100px;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 50px;
  width: 100%;
  max-width: 100vw;
  box-sizing: border-box;
}

.navigation-footer .frame132131753022 {
  width: 100%;
  max-width: 1000px;
}

.navigation-footer .vector-7-1 {
  height: 1px;
  background-color: #B2B2B2;
  position: relative;
  width: 100%;
  max-width: 1240px;
}

.navigation-footer .group27 {
  width: 100%;
  max-width: 1000px;
}



 /* Responsive Design */
 
 @media (max-width: 768px) {
   .main-content {
     padding: 40px 20px;
   }
   
   .sitemap-section {
     padding: 30px 20px;
   }
   
   .sitemap-links {
     grid-template-columns: 1fr;
     gap: 30px;
   }
   
   .hero-title {
     font-size: 28px;
   }
   
   .hero-subtitle {
     font-size: 18px;
   }
   
   .page-title {
     font-size: 28px;
   }
   
   .content-view-2 {
     padding: 40px 20px;
   }
   
   .navigation-footer {
     padding: 50px 20px;
   }
   

 }
</style>
