<template>
  <div class="sitemap-page">
    <!-- Navigation -->
    <navigation />
    
    <!-- Hero Section -->
    <div class="hero-section">
      <div class="hero-overlay">
        <div class="hero-content">
          <div class="hero-subtitle">sitemap</div>
          <h1 class="hero-title">サイトマップ</h1>
        </div>
      </div>
    </div>

    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
      <router-link to="/" class="breadcrumb-item">トップ</router-link>
      <span class="breadcrumb-separator">></span>
      <span class="breadcrumb-item current">サイトマップ</span>
    </div>

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

    <!-- button Section -->
    <div class="button-section">
      <div class="button-container">
        <button class="cta-button primary">
          <span class="button-text">お問い合わせはコチラ</span>
          <div class="arrow-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <rect width="24" height="24" rx="4" fill="#FFFFFF"/>
              <path d="M9.5 6L15.5 12L9.5 18" stroke="#DA5761" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
        </button>
        <button class="cta-button secondary">
          <span class="button-text">入会はコチラ</span>
          <div class="arrow-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <rect width="24" height="24" rx="4" fill="#FFFFFF"/>
              <path d="M9.5 6L15.5 12L9.5 18" stroke="#9C3940" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
        </button>
      </div>
    </div>

    <!-- Access Section -->
    <div class="content-view-2">
      <div class="frame-1321317467-2">
        <group10 />
        <div class="frame-1321317467-1">
          <img class="rectangle-3" :src="rectangle3" alt="Rectangle 3" />
          <div class="frame-1321317466">
            <div class="group-container">
              <div class="group-12">
                <div class="text-3 valign-text-middle inter-bold-mandy-20px">{{ text75 }}</div>
                <p class="x12km-14 valign-text-middle inter-normal-ship-gray-16px">{{ text77 }}</p>
                <div class="text-11 valign-text-middle inter-normal-ship-gray-16px" v-html="text76"></div>
                <p class="x12km-14-1 valign-text-middle inter-normal-ship-gray-16px">{{ phone }}</p>
                <p class="x19km-23 valign-text-middle inter-normal-ship-gray-16px">{{ x900 }}</p>
              </div>
              <div class="group-12">
                <div class="text-3 valign-text-middle inter-bold-mandy-20px">{{ text74 }}</div>
                <p class="x12km-14 valign-text-middle inter-normal-ship-gray-16px">{{ x12Km141 }}</p>
                <p class="x12km-14-1 valign-text-middle inter-normal-ship-gray-16px">{{ x12Km142 }}</p>
                <p class="x19km-23 valign-text-middle inter-normal-ship-gray-16px">{{ x19Km23 }}</p>
              </div>
              <div class="group-12">
                <div class="text-3 valign-text-middle inter-bold-mandy-20px">{{ text78 }}</div>
                <p class="x12km-14 valign-text-middle inter-normal-ship-gray-16px">{{ x497M6 }}</p>
                <p class="x12km-14-1 valign-text-middle inter-normal-ship-gray-16px">{{ x811M10 }}</p>
                <p class="x19km-23 valign-text-middle inter-normal-ship-gray-16px">{{ d1830M10 }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Footer Navigation -->
    <div class="navigation-footer">
      <Footer v-bind="frame132131753022Props" />
      <div class="vector-7-1"></div>
      <group27 />
    </div>



    <!-- Fixed Action Buttons -->
    <FixedActionButtons />
  </div>
</template>

<script>
import Navigation from "./Navigation";
import Footer from "./Footer";
import Group27 from "./Group27";
import Group10 from "./Group10";
import FixedActionButtons from "./FixedActionButtons.vue";
import vector7 from "../../public/img/vector-7.svg";
import { frame132131753022Data } from "../data";
import { homePageData } from "../data";

export default {
  name: "SitemapPage",
  components: {
    Navigation,
    Footer,
    Group27,
    Group10,
    FixedActionButtons,
  },
  data() {
    return {
      vector7: vector7,
      frame132131753022Props: frame132131753022Data,
      // content-view-2に必要なデータ
      rectangle3: homePageData.rectangle3,
      text75: homePageData.text75,
      text77: homePageData.text77,
      text76: homePageData.text76,
      phone: homePageData.phone,
      x900: homePageData.x900,
      text74: homePageData.text74,
      x12Km141: homePageData.x12Km141,
      x12Km142: homePageData.x12Km142,
      x19Km23: homePageData.x19Km23,
      text78: homePageData.text78,
      x497M6: homePageData.x497M6,
      x811M10: homePageData.x811M10,
      d1830M10: homePageData.d1830M10,
    };
  },
  mounted() {
    this.adjustRectangleHeight();
    window.addEventListener('resize', this.adjustRectangleHeight);
  },
  beforeDestroy() {
    window.removeEventListener('resize', this.adjustRectangleHeight);
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
.sitemap-page {
  background: #ECECEC;
  min-height: 100vh;
  width: 100%;
}

/* Hero Section */
.hero-section {
  width: 100%;
  height: 400px;
  background: url('https://api.builder.io/api/v1/image/assets/TEMP/6ed4aab7cb9aa3b95164dd2e5f305cafc76aa530?width=2880') lightgray center/cover no-repeat;
  box-shadow: 0 4px 4px 0 rgba(0, 0, 0, 0.25);
  position: relative;
}

.hero-overlay {
  width: 100%;
  height: 100%;
  background: rgba(77, 77, 77, 0.70);
  display: flex;
  align-items: flex-end;
  padding: 50px 30px;
}

.hero-content {
  color: white;
}

.hero-subtitle {
  font-family: Inter, -apple-system, Roboto, Helvetica, sans-serif;
  font-size: 24px;
  font-weight: 700;
  line-height: 150%;
  letter-spacing: -0.48px;
  margin-bottom: 10px;
}

.hero-title {
  font-family: Inter, -apple-system, Roboto, Helvetica, sans-serif;
  font-size: 40px;
  font-weight: 700;
  line-height: 150%;
  letter-spacing: -0.8px;
  margin: 0;
}

/* Breadcrumbs */
.breadcrumbs {
  padding: 24px 46px;
  display: flex;
  align-items: center;
  gap: 8px;
}

.breadcrumb-item {
  color: #3F3F3F;
  font-size: 12px;
  font-weight: 300;
  line-height: 5;
  text-decoration: none;
  transition: color 0.3s ease;
}

.breadcrumb-item:hover {
  color: #DA5761;
  text-decoration: underline;
}

.breadcrumb-item.current {
  color: #1A1A1A;
  font-weight: 500;
  cursor: default;
}

.breadcrumb-item.current:hover {
  color: #1A1A1A;
  text-decoration: none;
}

.breadcrumb-separator {
  color: #3F3F3F;
  font-size: 12px;
  font-weight: 300;
  line-height: 5;
}

/* Main Content */
.main-content {
  width: 100%;
  padding: 70px 50px 80px 50px;
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
}

.line-left,
.line-right {
  width: 60px;
  height: 2px;
  background: #DA5761;
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
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
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

/* Content View 2 */
.content-view-2 {
  align-items: center;
  background-color: var(--white);
  display: flex;
  flex-direction: column;
  gap: 24px;
  padding: 80px 50px;
  position: relative;
  width: 100%;
  z-index: 3;
  box-sizing: border-box;
}

.frame-1321317467-2 {
  align-items: flex-start;
  background-color: var(--white);
  display: flex;
  flex-direction: column;
  gap: 24px;
  position: relative;
  width: 100%;
  max-width: 2000px;
  z-index: 3;
  box-sizing: border-box;
}

.frame-1321317467-1 {
  align-items: flex-start;
  align-self: stretch;
  display: flex;
  flex: 0 0 auto;
  gap: 40px;
  position: relative;
  width: 100%;
  min-height: auto;
}

.rectangle-3 {
  height: 100%;
  object-fit: cover;
  position: relative;
  width: 45%;
  max-width: 692px;
  flex-shrink: 0;
  border-radius: 10px;
}

.frame-1321317466 {
  display: flex;
  align-items: flex-start;
  position: relative;
  width: auto;
  flex-shrink: 0;
  box-sizing: border-box;
  height: auto;
}

.group-container {
  align-items: flex-start;
  display: flex;
  flex-direction: column;
  gap: 30px;
  height: fit-content;
  position: relative;
  width: fit-content;
}

.group-12 {
  align-items: flex-start;
  display: flex;
  flex-direction: column;
  height: fit-content;
  width: fit-content;
}

.text-3 {
  letter-spacing: 0;
  line-height: 40px;
  margin-bottom: 3px;
  white-space: normal;
  word-wrap: break-word;
  overflow-wrap: break-word;
}

.x12km-14,
.x12km-14-1,
.x19km-23 {
  letter-spacing: 0;
  line-height: 20px;
  margin-bottom: 2px;
  margin-top: 3px;
  white-space: normal;
  word-wrap: break-word;
  overflow-wrap: break-word;
}

.text-11 {
  letter-spacing: 0;
  line-height: 18px;
  margin-top: 3px;
  margin-bottom: 2px;
  white-space: normal;
  word-wrap: break-word;
  overflow-wrap: break-word;
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

/* Button Section */
.button-section {
  background: #ECECEC;
  padding: 50px 50px 70px 50px;
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
}

.button-container {
  display: flex;
  flex-direction: column;
  gap: 20px;
  align-items: center;
  width: 100%;
  max-width: 1200px;
}

.cta-button {
  width: 300px;
  padding: 20px 40px;
  border: none;
  border-radius: 10px;
  font-family: 'Inter', Helvetica, sans-serif;
  font-size: 18px;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.3s ease;
  text-align: center;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 30px;
}

.button-text {
  width: auto;
  text-align: center;
}

.arrow-icon {
  flex-shrink: 0;
  display: flex;
  align-items: center;
  justify-content: center;
}

.cta-button.primary {
  background-color: #DA5761;
  color: #FFFFFF;
  width: 100%;
}

.cta-button.primary:hover {
  background-color: #c44a54;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(218, 87, 97, 0.3);
}

.cta-button.secondary {
  background-color: #9C3940;
  color: #FFFFFF;
  width: 100%;
}

.cta-button.secondary:hover {
  background-color: #8a3238;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(156, 57, 64, 0.3);
}

/* Access Section */
.content-view-2 {
  background: white;
  padding: 50px 0;
  width: 100%;
}

.frame-1321317467-2 {
  align-items: flex-start;
  background-color: var(--white);
  display: flex;
  flex-direction: column;
  gap: 24px;
  position: relative;
  width: 100%;
  max-width: 2000px;
  z-index: 3;
  box-sizing: border-box;
}

.frame-1321317467-1 {
  align-items: flex-start;
  align-self: stretch;
  display: flex;
  flex: 0 0 auto;
  gap: 40px;
  position: relative;
  width: 100%;
  min-height: auto;
}

.rectangle-3 {
  height: 100%;
  object-fit: cover;
  position: relative;
  width: 45%;
  max-width: 692px;
  flex-shrink: 0;
  border-radius: 10px;
}

.frame-1321317466 {
  display: flex;
  align-items: flex-start;
  position: relative;
  width: auto;
  flex-shrink: 0;
  box-sizing: border-box;
  height: auto;
}

.group-container {
  display: flex;
  flex-direction: column;
  gap: 30px;
}

.group-12 {
  align-items: flex-start;
  display: flex;
  flex-direction: column;
  height: fit-content;
  width: fit-content;
}

.text-3 {
  color: #DA5761;
  font-size: 20px;
  font-weight: 700;
  line-height: 1.5;
}

.x12km-14, .x12km-14-1, .x19km-23 {
  color: #3F3F3F;
  font-size: 16px;
  font-weight: 400;
  line-height: 1.6;
}

.text-11 {
  color: #3F3F3F;
  font-size: 16px;
  font-weight: 400;
  line-height: 1.6;
}

/* Fixed Side Buttons */
.fixed-side-buttons {
  position: fixed;
  right: 20px;
  bottom: 20px;
  display: flex;
  flex-direction: column;
  gap: 10px;
  z-index: 1000;
}

.side-button {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 5px;
  width: 100px;
  height: 100px;
  border-radius: 50%;
  border: none;
  cursor: pointer;
  transition: transform 0.3s ease;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.side-button:hover {
  transform: scale(1.1);
}

.login-side {
  background: #DA5761;
  color: white;
}

.contact-side {
  background: #4A90E2;
  color: white;
}

.side-button span {
  font-size: 12px;
  font-weight: 700;
  line-height: 1;
}

 /* Responsive Design */
 @media (max-width: 1150px) {
   .frame-1321317467-1 {
     flex-direction: column;
     gap: 20px;
   }
   
   .rectangle-3 {
     width: 100%;
     max-width: none;
     order: 2;
   }
   
   .frame-1321317466 {
     order: 1;
   }
 }
 
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
   
   .fixed-side-buttons {
     right: 10px;
     bottom: 10px;
   }
   
   .side-button {
     width: 80px;
     height: 80px;
   }
 }
</style>
