<template>
  <div class="membership-page">
    <!-- Navigation -->
    <Navigation />
    
    <!-- Hero Section -->
    <div class="hero-section">
      <div class="hero-overlay">
        <div class="hero-content">
          <p class="hero-subtitle">premium membership</p>
          <h1 class="hero-title">プレミアム会員</h1>
        </div>
      </div>
    </div>

    <!-- Breadcrumbs -->
    <Breadcrumbs :breadcrumbs="['入会案内', 'プレミアム会員の特典']" />

    <!-- Introduction Section -->
    <section class="introduction-section">
      <div class="container">
        <div class="intro-content">
          <h2 class="intro-title">プレミアム会員について</h2>
          <p class="intro-text">
            ちくぎん地域経済研究所のプレミアム会員に参加すると、より多くの優良情報やサポートが受けられるようになります。
          </p>
        </div>
      </div>
    </section>

    <!-- Featured Publication Section -->
    <section class="publications-section">
      <div class="container">
        <div class="section-header">
          <h2 class="section-title">話題の特典</h2>
          <div class="section-decoration">
            <div class="decoration-line"></div>
            <span class="decoration-text">benefits</span>
            <div class="decoration-line"></div>
          </div>
        </div>

        <!-- Featured Publication -->
        <div class="featured-publication">
          <div class="featured-content">
            <div class="featured-image">
              <img src="/img/image-1.png" alt="話題の特典" />
            </div>
                         <div class="featured-info">
               <div class="content-box">
                 <h3 class="content-title">日経トップリーダービジネスで勝ち抜くヒント集
                    毎月、日経トップリーダーをお届けします。</h3>
                 <div class="content-body">
                   <p>経営トップに役立つ実践的な情報を厳選し、混迷の時代を勝ち 抜き、未来を切り開くヒントとなる情報を提供する月刊誌です。毎 月、月初に郵送にてお届けします。</p>
                 </div>
               </div>

              <button class="download-btn">日経トップリーダーを確認する
                <div class="icon-box">
                  <svg class="arrow-icon" width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="23" height="23" rx="5" fill="white"/>
                    <path d="M17.5302 11.9415L13.0581 16.5412C12.9649 16.6371 12.8384 16.691 12.7066 16.691C12.5747 16.691 12.4482 16.6371 12.355 16.5412C12.2618 16.4453 12.2094 16.3152 12.2094 16.1796C12.2094 16.044 12.2618 15.9139 12.355 15.818L15.9793 12.0909L6.2469 12.0909C6.11511 12.0909 5.98872 12.0371 5.89554 11.9413C5.80235 11.8454 5.75 11.7154 5.75 11.5799C5.75 11.4443 5.80235 11.3143 5.89554 11.2185C5.98872 11.1226 6.11511 11.0688 6.2469 11.0688L15.9793 11.0688L12.355 7.34171C12.2618 7.24581 12.2094 7.11574 12.2094 6.98012C12.2094 6.84449 12.2618 6.71443 12.355 6.61853C12.4482 6.52263 12.5747 6.46875 12.7066 6.46875C12.8384 6.46875 12.9649 6.52263 13.0581 6.61853L17.5302 11.2183C17.5764 11.2657 17.613 11.3221 17.638 11.3841C17.6631 11.4462 17.6759 11.5127 17.6759 11.5799C17.6759 11.647 17.6631 11.7135 17.638 11.7756C17.613 11.8376 17.5764 11.894 17.5302 11.9415Z" fill="#1A1A1A"/>
                  </svg>
                </div>
              </button>
            </div>
          </div>
        </div>
      </div>
    </section>

         <!-- CTA Section -->
     <ActionButton 
       primary-text="プレミアム会員特典についてお問い合わせ"
       secondary-text="プレミアム会員入会はコチラ"
       @primary-click="handleContactClick"
       @secondary-click="handleJoinClick"
     />

    <!-- Contact Section -->
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
import Breadcrumbs from "./Breadcrumbs.vue";
import AccessSection from "./AccessSection.vue";
import ContactSection from "./ContactSection.vue";
import Footer from "./Footer.vue";
import Group27 from "./Group27";
import FixedSideButtons from "./FixedSideButtons.vue";
import ActionButton from "./ActionButton.vue";
import { frame132131753022Data } from "../data";

export default {
  name: "PremiumMembershipPage",
  components: {
    Navigation,
    Breadcrumbs,
    AccessSection,
    ContactSection,
    Footer,
    Group27,
    FixedSideButtons,
    ActionButton
  },
  data() {
    return {
      frame132131753022Props: frame132131753022Data,
    };
  },
  methods: {
    handleContactClick() {
      // Navigate to contact page
      this.$router.push('/contact');
    },
    handleJoinClick() {
      // Navigate to join page or handle join action
      this.$router.push('/application-form');
    }
  }
};
</script>

<style scoped>

.membership-page {
  background-color: #ECECEC;
  min-height: 100vh;
}

/* Hero Section */
.hero-section {
  width: 100%;
  height: 396px;
  background: linear-gradient(rgba(77, 77, 77, 0.70), rgba(77, 77, 77, 0.70)), 
              url('https://api.builder.io/api/v1/image/assets/TEMP/6ba0640caf634ea83255fc6ebd7dda9734c97932?width=2880') lightgray center/cover no-repeat;
  box-shadow: 0 4px 4px 0 rgba(0, 0, 0, 0.25);
  display: flex;
  align-items: end;
  padding: 50px 30px;
}

.hero-overlay {
  width: 100%;
}

.hero-content {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  gap: 10px;
}

.hero-subtitle {
  color: #FFFFFF;
  font-family: var(--font-family-inter);
  font-size: 24px;
  font-weight: 700;
  line-height: 2.5;
  letter-spacing: -0.48px;
}

.hero-title {
  color: #FFFFFF;
  font-family: var(--font-family-inter);
  font-size: 40px;
  font-weight: 700;
  line-height: 1.5;
  letter-spacing: -0.8px;
}

/* Introduction Section */
.introduction-section {
  padding: 70px 50px 50px 50px;
}

.container {
  max-width: 2000px;
  margin: 0 auto;
}

.intro-content {
  background: #FFFFFF;
  border-radius: 20px;
  padding: 50px;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 40px;
}

.intro-title {
  color: #1A1A1A;
  font-family: var(--font-family-inter);
  font-size: 20px;
  font-weight: 700;
  line-height: 1.5;
  text-align: center;
}

.intro-text {
  color: #3F3F3F;
  font-family: var(--font-family-inter);
  font-size: 18px;
  font-weight: 400;
  line-height: 1.5;
  text-align: left;
}

/* Publications Section */
.publications-section {
  padding: 50px;
}

.section-header {
  text-align: center;
  margin-bottom: 40px;
}

.section-title {
  color: #1A1A1A;
  font-family: var(--font-family-inter);
  font-size: 36px;
  font-weight: 700;
  line-height: normal;
  letter-spacing: -0.72px;
  margin-bottom: 29px;
}

.section-decoration {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 15px;
}

.decoration-line {
  width: 69px;
  height: 2px;
  background: #DA5761;
}

.decoration-text {
  color: #DA5761;
  font-family: var(--font-family-inter);
  font-size: 20px;
  font-weight: 700;
  letter-spacing: 0em;
}

.services-content {
  background: #FFFFFF;
  border-radius: 20px;
  padding: 50px;
}

.service-category {
  margin-bottom: 50px;
}

.category-title {
  color: #1A1A1A;
  font-family: var(--font-family-inter);
  font-size: 36px;
  font-weight: 700;
  line-height: normal;
  margin-bottom: 20px;
}

.service-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
  margin-bottom: 10px;
}

.service-grid-2 {
  grid-template-columns: repeat(3, 1fr);
}

.service-card {
  position: relative;
  border-radius: 20px;
  overflow: hidden;
  height: 294px;
}

.premium-card {
  border: 3px solid #DA5761;
  box-shadow: 0 4px 8px rgba(218, 87, 97, 0.3);
}

.service-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.service-overlay {
  position: absolute;
  bottom: 0;
  left: 83px;
  right: 0;
  background: #FFFFFF;
  border-radius: 10px 0 0 0;
  padding: 13px;
  width: 100%;
  height: 67px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  gap: 4px;
}

.premium-overlay {
  background: linear-gradient(135deg, #DA5761, #FF6B6B);
  color: white;
}

.service-tag {
  color: #DA5761;
  font-family: var(--font-family-inter);
  font-size: 15px;
  font-weight: 400;
  line-height: normal;
}

.premium-tag {
  color: #FFFFFF;
  font-weight: 700;
}

.service-name {
  color: #3F3F3F;
  font-family: var(--font-family-inter);
  font-size: 18px;
  font-weight: 700;
  line-height: normal;
}

.premium-overlay .service-name {
  color: #FFFFFF;
}

.service-icon {
  position: absolute;
  left: -28px;
  top: 50%;
  transform: translateY(-50%);
  width: 24px;
  height: 24px;
}

.section-divider {
  width: 100%;
  height: 1px;
  background: #CFCFCF;
  margin: 50px 0;
}

/* Featured Publication */
.featured-publication {
  background: white;
  border-radius: 15px;
  padding: 50px;
  max-width: 2000px;
  margin-left: auto;
  margin-right: auto;
}

.featured-content {
  display: flex;
  width: 100%;
  align-items: stretch;
  gap: 30px;
}

.featured-image {
  width: 30%;
  flex-shrink: 0;
  border-radius: 10px;
  overflow: hidden;
  position: relative;
}

.featured-image img {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 10px;
}

.featured-info {
  display: flex;
  flex: 1;
  flex-direction: column;
  flex-shrink: 0;
}

.content-box {
  background: #FFFFFF;
  border-radius: 15px;
  padding: 30px;
}

.content-title {
  color: #1A1A1A;
  font-family: var(--font-family-inter);
  font-size: 24px;
  font-weight: 700;
  line-height: 1.4;
  margin-bottom: 20px;
  border-bottom: 2px solid #DA5761;
  padding-bottom: 10px;
}

.content-body {
  color: #3F3F3F;
  font-family: var(--font-family-inter);
  font-size: 16px;
  font-weight: 400;
  line-height: 1.6;
}

.content-body p {
  margin-bottom: 15px;
}

.content-body p:last-child {
  margin-bottom: 0;
}

.featured-meta {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 15px;
}

.featured-year {
  color:#3F3F3F;
  font-size: 0.8rem;
  font-weight: 500;
}

.featured-category {
  background: #F6D5D8;
  color: #1A1A1A;
  padding: 10px 15px;
  border-radius: 5px;
  font-size: 0.8rem;
  font-weight: 500;
  width: auto;
  align-self: flex-start;
}

.featured-details {
  display: flex;
  flex-direction: column;
  gap: 0;
  width: 100%;
}

.past-info-row {
  display: flex;
  padding: 15px 0;
  align-items: center;
  gap: 50px;
  border-bottom: 0.5px dashed #B0B0B0;
  width: 100%;
}

.past-info-row:first-child {
  border-top: 0.5px dashed #B0B0B0;
}

.info-label {
  display: flex;
  padding: 10px 30px;
  justify-content: center;
  align-items: center;
  gap: 10px;
  border-radius: 5px;
  background: #727272;
  white-space: nowrap;
  width: 250px;
  color: #FFFFFF;
  font-family: 'Inter', sans-serif;
  font-size: 18px;
  font-weight: 400;
  line-height: 150%;
  margin: 0;
}

.info-value {
  color: var(--color-secondary);
  font-family: 'Inter', sans-serif;
  font-size: 18px;
  font-weight: 400;
  line-height: normal;
}

.download-btn {
  display: flex;
  width: auto;
  padding: 10px 50px;
  justify-content: center;
  align-items: center;
  gap: 10px;
  border-radius: 10px;
  background: #1A1A1A;
  border: none;
  cursor: pointer;
  color: #ffffff;
  margin-top: 50px;
  margin-left: auto;
  font-family: 'Inter', sans-serif;
  font-size: 15px;
  font-weight: 700;
  line-height: 150%;
  transition: all 0.3s ease;
}

.download-btn:hover {
  background: var(--color-secondary);
}

.icon-box {
  display: flex;
  align-items: center;
  justify-content: center;
}

.arrow-icon {
  display: flex;
  align-items: center;
  justify-content: center;
}

/* Membership Info */
.membership-info {
  background: #ECECEC;
  border-radius: 20px;
  padding: 30px;
}

.premium-info {
  background: linear-gradient(135deg, #ECECEC, #F8F8F8);
  border: 2px solid #DA5761;
}

.membership-info-title {
  color: #1A1A1A;
  font-family: var(--font-family-inter);
  font-size: 36px;
  font-weight: 700;
  line-height: normal;
  margin-bottom: 20px;
}

.membership-table {
  border-top: 0.5px dashed #B0B0B0;
  margin-bottom: 20px;
}

.table-row {
  display: flex;
  align-items: center;
  gap: 30px;
  padding: 15px 0;
  border-bottom: 0.5px dashed #B0B0B0;
}

.table-row-top {
  align-items: flex-start;
}

.table-label {
  background: #727272;
  color: #FFFFFF;
  font-family: var(--font-family-inter);
  font-size: 18px;
  font-weight: 400;
  line-height: 1.5;
  padding: 5px 10px;
  border-radius: 5px;
  width: 200px;
  text-align: center;
  flex-shrink: 0;
}

.premium-info .table-label {
  background: #DA5761;
}

.table-content {
  color: #3F3F3F;
  font-family: var(--font-family-inter);
  font-size: 18px;
  font-weight: 400;
  line-height: normal;
  flex: 1;
}

.membership-description {
  color: #3F3F3F;
  font-family: var(--font-family-inter);
  font-size: 18px;
  font-weight: 400;
  line-height: normal;
}

/* Filter Download Button */
.filter-download-btn {
  display: flex;
  width: auto;
  padding: 10px 50px;
  justify-content: center;
  align-items: center;
  gap: 10px;
  border-radius: 10px;
  background: #1A1A1A;
  border: none;
  cursor: pointer;
  color: #ffffff;
  font-family: 'Inter', sans-serif;
  font-size: 15px;
  font-weight: 700;
  line-height: 150%;
  transition: all 0.3s ease;
  margin: 50px auto 30px;
}

.premium-btn {
  background: linear-gradient(135deg, #DA5761, #FF6B6B);
  box-shadow: 0 4px 8px rgba(218, 87, 97, 0.3);
}

.premium-btn:hover {
  background: linear-gradient(135deg, #C44A54, #E55A5A);
  transform: translateY(-2px);
  box-shadow: 0 6px 12px rgba(218, 87, 97, 0.4);
}

.filter-download-btn:hover {
  background: var(--color-secondary);
}

.membership-action-btn {
  display: flex;
  width: 300px;
  padding: 10px 0;
  justify-content: center;
  align-items: center;
  gap: 10px;
  border-radius: 10px;
  background: #1A1A1A;
  border: none;
  cursor: pointer;
  color: #ffffff;
  font-family: 'Inter', sans-serif;
  font-size: 15px;
  font-weight: 700;
  line-height: 150%;
  transition: all 0.3s ease;
  margin: 0 auto 30px;
}

.membership-action-btn:hover {
  background: var(--color-secondary);
}

/* Flow Section */
.flow-section {
  padding: 50px;
}

.flow-content {
  background: #FFFFFF;
  border-radius: 20px;
  padding: 50px;
}

.flow-steps {
  border-top: 0.5px dashed #DA5761;
}

.flow-step {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 15px 0;
  border-bottom: 0.5px dashed #DA5761;
  min-height: 125px;
}

.step-number {
  color: #DA5761;
  font-family: var(--font-family-inter);
  font-size: 36px;
  font-weight: 700;
  line-height: 1.5;
  width: 150px;
  flex-shrink: 0;
}

.step-content {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.step-title {
  color: #3F3F3F;
  font-family: var(--font-family-inter);
  font-size: 18px;
  font-weight: 400;
  line-height: 1.5;
}

.step-description {
  color: #3F3F3F;
  font-family: var(--font-family-inter);
  font-size: 18px;
  font-weight: 400;
  line-height: 1.5;
}

/* Company Banner Section */
.company-banner-section {
  height: 351px;
  background: #FF6B6B;
  position: relative;
  overflow: hidden;
}

.company-banner-section::before {
  content: '';
  position: absolute;
  top: -225px;
  left: 0;
  width: 100%;
  height: 706px;
  background: url('https://api.builder.io/api/v1/image/assets/TEMP/42f6878f33350b96e3bbff6f048c352a254e8e2e?width=2882') center/cover no-repeat;
}

.company-banner-section::after {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(77, 77, 77, 0.70);
}

.banner-content {
  position: relative;
  z-index: 2;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 60px 420px;
}

.banner-text {
  text-align: center;
  color: #FFFFFF;
}

.banner-subtitle {
  font-family: var(--font-family-inter);
  font-size: 20px;
  font-weight: 700;
  margin-bottom: 8px;
}

.banner-title {
  font-family: var(--font-family-inter);
  font-size: 40px;
  font-weight: 700;
  line-height: 1.5;
  margin-bottom: 43px;
}

.banner-description {
  font-family: var(--font-family-inter);
  font-size: 20px;
  font-weight: 700;
  line-height: 1.5;
  margin-bottom: 33px;
}

.banner-button {
  background: #DA5761;
  border: none;
  border-radius: 10px;
  color: #FFFFFF;
  font-family: var(--font-family-inter);
  font-size: 15px;
  font-weight: 700;
  line-height: 1.5;
  padding: 10px 20px;
  display: inline-flex;
  align-items: center;
  gap: 10px;
  cursor: pointer;
  box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
}

/* Responsive Design */
@media (max-width: 1150px) {
  /* セクションのパディング調整 */
  .introduction-section,
  .publications-section {
    padding: 50px 30px !important;
  }
  
  /* レイアウトの縦並び化 */
  .featured-content {
    flex-direction: column !important;
    gap: 30px !important;
  }
  
  /* 要素の幅調整 */
  .featured-image {
    width: 100% !important;
    height: 300px !important;
  }
  
  /* 角丸の調整 */
  .featured-image {
    border-radius: 20px 20px 0 0 !important;
  }
  
  .featured-info {
    border-radius: 0 0 20px 20px !important;
    padding: 0 !important;
  }
  
  .content-box {
    padding: 30px 0 !important;
  }
  
  /* フォントサイズ調整 */
  .section-title {
    font-size: 32px !important;
  }
  
  .section-header {
    margin-bottom: 25px !important;
  }
  
  .hero-title {
    font-size: 32px !important;
  }
  
  .hero-subtitle {
    font-size: 18px !important;
  }
  
  .intro-title {
    font-size: 18px !important;
  }
  
  .intro-text {
    font-size: 18px !important;
  }
  
  .content-title {
    font-size: 22px !important;
  }
  
  .content-body {
    font-size: 18px !important;
  }
  
  .decoration-text {
    font-size: 18px !important;
  }
  
  /* コンテンツ調整 */
  .intro-content {
    padding: 30px 20px !important;
    gap: 30px !important;
  }
  
  .featured-publication {
    padding: 30px 20px !important;
  }
}

@media (max-width: 900px) {
  /* セクションのパディング調整 */
  .introduction-section,
  .publications-section {
    padding: 30px 20px !important;
  }
  
  /* レイアウトの縦並び化 */
  .featured-content {
    flex-direction: column !important;
    gap: 0 !important;
  }
  
  /* 要素の幅調整 */
  .featured-image {
    width: 100% !important;
    height: 280px !important;
  }
  
  /* 角丸の調整 */
  .featured-image {
    border-radius: 20px 20px 0 0 !important;
  }
  
  .featured-info {
    border-radius: 0 0 20px 20px !important;
    padding: 0 !important;
  }
  
  .content-box {
    padding: 25px 0 !important;
  }
  
  /* フォントサイズ調整 */
  .section-title {
    font-size: 29px !important;
  }
  
  .section-header {
    margin-bottom: 22px !important;
  }
  
  .hero-title {
    font-size: 29px !important;
  }
  
  .hero-subtitle {
    font-size: 17px !important;
  }
  
  .intro-title {
    font-size: 17px !important;
  }
  
  .intro-text {
    font-size: 17px !important;
  }
  
  .content-title {
    font-size: 20px !important;
  }
  
  .content-body {
    font-size: 17px !important;
  }
  
  .decoration-text {
    font-size: 17px !important;
  }
  
  /* コンテンツ調整 */
  .intro-content {
    padding: 30px 20px !important;
    gap: 25px !important;
  }
  
  .featured-publication {
    padding: 30px 20px !important;
  }
}

@media (max-width: 768px) {
  /* セクションのパディング調整 */
  .introduction-section,
  .publications-section {
    padding: 30px 20px !important;
  }
  
  .hero-section {
    height: 300px !important;
    padding: 30px 20px !important;
  }
  
  /* レイアウトの縦並び化 */
  .featured-content {
    flex-direction: column !important;
    gap: 0 !important;
  }
  
  /* 要素の幅調整 */
  .featured-image {
    width: 100% !important;
    height: 250px !important;
  }
  
  /* 角丸の調整 */
  .featured-image {
    border-radius: 20px 20px 0 0 !important;
  }
  
  .featured-info {
    border-radius: 0 0 20px 20px !important;
    padding: 0 !important;
  }
  
  .content-box {
    padding: 20px 0 !important;
  }
  
  /* フォントサイズ調整 */
  .section-title {
    font-size: 27px !important;
  }
  
  .section-header {
    margin-bottom: 20px !important;
  }
  
  .hero-title {
    font-size: 27px !important;
  }
  
  .hero-subtitle {
    font-size: 16px !important;
  }
  
  .intro-title {
    font-size: 16px !important;
  }
  
  .intro-text {
    font-size: 16px !important;
  }
  
  .content-title {
    font-size: 19px !important;
  }
  
  .content-body {
    font-size: 16px !important;
  }
  
  .decoration-text {
    font-size: 16px !important;
  }
  
  /* コンテンツ調整 */
  .intro-content {
    padding: 30px 20px !important;
    gap: 20px !important;
  }
  
  .featured-publication {
    padding: 30px 20px !important;
  }
  
  .download-btn {
    padding: 15px 50px !important;
    font-size: 18px !important;
  }
}

@media (max-width: 480px) {
  /* セクションのパディング調整 */
  .introduction-section,
  .publications-section {
    padding: 20px 15px !important;
  }
  
  .hero-section {
    height: 250px !important;
    padding: 25px 20px !important;
  }
  
  /* レイアウトの縦並び化 */
  .featured-content {
    flex-direction: column !important;
    gap: 0 !important;
  }
  
  /* 要素の幅調整 */
  .featured-image {
    width: 100% !important;
    height: 200px !important;
  }
  
  /* 角丸の調整 */
  .featured-image {
    border-radius: 15px 15px 0 0 !important;
  }
  
  .featured-info {
    border-radius: 0 0 15px 15px !important;
    padding: 0 !important;
  }
  
  .content-box {
    padding: 15px 0 !important;
  }
  
  /* フォントサイズ調整 */
  .section-title {
    font-size: 22px !important;
  }
  
  .section-header {
    margin-bottom: 18px !important;
  }
  
  .hero-title {
    font-size: 22px !important;
  }
  
  .hero-subtitle {
    font-size: 13px !important;
  }
  
  .intro-title {
    font-size: 13px !important;
  }
  
  .intro-text {
    font-size: 13px !important;
  }
  
  .content-title {
    font-size: 18px !important;
  }
  
  .content-body {
    font-size: 13px !important;
  }
  
  .decoration-text {
    font-size: 13px !important;
  }
  
  /* コンテンツ調整 */
  .intro-content {
    padding: 20px 15px !important;
    gap: 15px !important;
  }
  
  .featured-publication {
    padding: 20px 15px !important;
  }
  
  .download-btn {
    padding: 12px 40px !important;
    font-size: 16px !important;
    width: 100% !important;
  }
}
</style>
