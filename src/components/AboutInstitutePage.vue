<template>
  <div class="about-institute-page">
    <navigation />

    <!-- Hero Section -->
    <HeroSection 
      title="ちくぎん地域経済研究所について"
      subtitle="for you"
      heroImage="https://api.builder.io/api/v1/image/assets/TEMP/df7ca8cd2f554040b151c3c0f960f06d9826cc19?width=2880"
    />

    <!-- Breadcrumbs -->
    <Breadcrumbs :breadcrumbs="['ちくぎん地域経済研究所について']" />

    <!-- About Section -->
    <div class="about-section">
      <div class="section-header">
        <h2 class="section-title">ちくぎん地域経済研究所について</h2>
        <div class="section-divider">
          <div class="divider-line"></div>
          <span class="divider-text">FOR YOU</span>
          <div class="divider-line"></div>
        </div>
      </div>
      
      <div class="about-content">
        <img class="about-image" src="https://api.builder.io/api/v1/image/assets/TEMP/ec1204f76835f4d00fb62a46530330165ae1b65e?width=1340" alt="会社画像" />
        <div class="about-text">
          <div class="about-headline">
            <h3 class="main-headline">産 官 学 金 を<br>繋ぐ架け橋へ</h3>
          </div>
          <div class="about-description">
            当研究所は、産・官・学・金(金融)のネットワークによる様々な分野の調査研究を通じ、企業活動などをサポートします。<br><br>
            経済・社会・産業動向などに関する調査研究及び企業経営や県民の生活のお役に立つ情報をご提供するとともに、各種経済・文化団体の事務局活動等を通じて、地域社会に貢献することを目指しております。<br>
            今後とも地元企業や地域の皆様をはじめ行政等との連携を緊密にし、様々な事業展開を図り地域の発展に寄与してまいりたいと考えております。
          </div>
        </div>
      </div>
    </div>

    <!-- Service Overview Section -->
    <div class="service-section">
      <div class="section-header">
        <h2 class="section-title">サービス概要</h2>
        <div class="section-divider">
          <div class="divider-line"></div>
          <span class="divider-text">service</span>
          <div class="divider-line"></div>
        </div>
      </div>
      
      <div class="service-cards">
        <div class="service-card">
          <img class="service-image" src="https://api.builder.io/api/v1/image/assets/TEMP/a3c7e188d6e1f00b84c70555aa606fd2ebe0cc5b?width=870" alt="開発・研究" />
          <div class="service-content">
            <h3 class="service-title">開発・研究</h3>
            <p class="service-description">ちくぎん地域経済研究所では、国・地方自治体・大学・企業などからのご要望を受け、様々な情報を収集・調査・分析をします。有意義な情報を分かりやすく発信していきます。</p>
            <div class="service-details">
              主な定期刊行物<br>
              ちくぎん地域経済レポート（四半期毎）<br>
              Hot Information（1ヶ月に2回）<br>
              メールマガジン（毎週2回）
            </div>
          </div>
        </div>
        
        <div class="service-card">
          <img class="service-image" src="https://api.builder.io/api/v1/image/assets/TEMP/f92b01ad91c11f2d63f1c851a4991b7316f2365d?width=870" alt="人材開発、セミナー" />
          <div class="service-content">
            <h3 class="service-title">人材開発、セミナー</h3>
            <p class="service-description">企業幹部、従業員または後継者(次世代育成)にマッチする効果的な研修を行います。ご要望に合わせて各種講演会、セミナー等の企画・運営を行うほか、様々なニーズに合わせて、外部専門家等の紹介・斡旋をいたします。</p>
            <div class="service-details">
              人材紹介、斡旋<br>
              外部専門家の紹介、斡旋<br>
              教育・研修<br>
              社員研修<br>
              講演会<br>
              セミナー
            </div>
          </div>
        </div>
        
        <div class="service-card">
          <img class="service-image" src="https://api.builder.io/api/v1/image/assets/TEMP/9de269531d1458bd155965ea0ad95d1a7f468fe4?width=870" alt="経営支援" />
          <div class="service-content">
            <h3 class="service-title">経営支援(経営サポート)</h3>
            <p class="service-description">企業の皆様の経営課題解決に向けたお手伝いを行います。社内のバックオフィス業務構築などのお悩み事がありましたらご相談ください。</p>
            <div class="service-details">
              コンサルティング<br>
              経営課題解決サポート<br>
              ビジネスマッチング<br>
              国内外企業の紹介<br>
              新ビジネスモデルの発展<br>
              業務提携等の支援
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

    <!-- Contact CTA Section -->
    <ContactSection />

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
import Navigation from "./Navigation";
import ContactSection from "./ContactSection.vue";
import Footer from "./Footer";
import Group27 from "./Group27";
import AccessSection from "./AccessSection";
import HeroSection from "./HeroSection.vue";
import Breadcrumbs from "./Breadcrumbs.vue";
import FixedSideButtons from "./FixedSideButtons.vue";
import vector7 from "../../public/img/vector-7.svg";
import { frame132131753022Data } from "../data";

export default {
  name: "AboutInstitutePage",
  components: {
    Navigation,
    ContactSection,
    Footer,
    Group27,
    AccessSection,
    HeroSection,
    Breadcrumbs,
    FixedSideButtons,
  },
  data() {
    return {
      vector7: vector7,
      frame132131753022Props: frame132131753022Data,
    };
  },
  mounted() {
    this.adjustRectangleHeight();
    this.adjustAboutImageHeight();
    this.adjustServiceImageHeight();
    window.addEventListener('resize', this.adjustRectangleHeight);
    window.addEventListener('resize', this.adjustAboutImageHeight);
    window.addEventListener('resize', this.adjustServiceImageHeight);
  },
  beforeDestroy() {
    window.removeEventListener('resize', this.adjustRectangleHeight);
    window.removeEventListener('resize', this.adjustAboutImageHeight);
    window.removeEventListener('resize', this.adjustServiceImageHeight);
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
    },
    adjustAboutImageHeight() {
      this.$nextTick(() => {
        const aboutText = this.$el.querySelector('.about-text');
        const aboutImage = this.$el.querySelector('.about-image');
        
        if (aboutText && aboutImage) {
          const textHeight = aboutText.offsetHeight;
          aboutImage.style.height = textHeight + 'px';
        }
      });
    },
    adjustServiceImageHeight() {
      this.$nextTick(() => {
        const serviceCards = this.$el.querySelectorAll('.service-card');
        
        serviceCards.forEach(card => {
          const serviceContent = card.querySelector('.service-content');
          const serviceImage = card.querySelector('.service-image');
          
          if (serviceContent && serviceImage) {
            const contentHeight = serviceContent.offsetHeight;
            serviceImage.style.height = contentHeight + 'px';
          }
        });
      });
    }
  }
};
</script>

<style scoped>
.about-institute-page {
  background-color: #ECECEC;
  font-family: 'Inter', Helvetica, sans-serif;
  position: relative;
  width: 100%;
  overflow-x: auto;
}



@media (max-width: 480px) {
  .hero-section {
    min-height: 250px;
    height: 35vh;
  }
  
  .hero-overlay {
    padding: 20px 15px;
  }
}



/* Section Styling */
.about-section, .service-section {
  padding: 70px 50px 0 50px;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 40px;
}

.section-header {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 29px;
}

.section-title {
  color: #1A1A1A;
  font-size: 36px;
  font-weight: 700;
  text-align: center;
  letter-spacing: -0.72px;
}

.section-divider {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 15px;
}

.divider-line {
  width: 69px;
  height: 2px;
  background: #DA5761;
}

.divider-text {
  color: #DA5761;
  font-size: 20px;
  font-weight: 700;
}

/* About Section */
.about-section {
  background: #ECECEC;
}

.about-content {
  display: flex;
  align-items: flex-start;
  width: 100%;
  max-width: 2000px;
  height: auto;
}

.about-image {
  width: 50%;
  height: auto;
  border-radius: 20px 0 0 20px;
  object-fit: cover;
  object-position: center;
}

.about-text {
  width: 50%;
  height: auto;
  padding: 50px;
  background: white;
  border-radius: 0 20px 20px 0;
  display: flex;
  flex-direction: column;
  justify-content: center;
  gap: 40px;
}

.about-headline {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.main-headline {
  color: #DA5761;
  font-size: 55px;
  font-weight: 700;
  line-height: 1.5;
}

.about-description {
  color: #3F3F3F;
  font-family: 'Noto Sans JP', sans-serif;
  font-size: 20px;
  font-weight: 400;
  line-height: 1.2;
}

/* Service Section */
.service-section {
  background: #ECECEC;
  width: 100%;
}

.service-cards {
  display: flex;
  flex-direction: column;
  gap: 40px;
  width: 100%;
  max-width: 2000px;
}

.service-card {
  display: flex;
  align-items: flex-start;
  width: 100%;
  background: white;
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.service-image {
  width: 40%;
  height: auto;
  object-fit: cover;
  object-position: center;
}

.service-content {
  width: 60%;
  padding: 40px;
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.service-title {
  color: #1A1A1A;
  font-size: 24px;
  font-weight: 700;
  line-height: 1.5;
}

.service-description {
  color: #3F3F3F;
  font-size: 16px;
  font-weight: 400;
  line-height: 1.6;
}

.service-details {
  color: #3F3F3F;
  font-size: 14px;
  font-weight: 400;
  line-height: 1.8;
  background: #F5F5F5;
  padding: 20px;
  border-radius: 10px;
}

/* Button Section */
.button-section {
  background: #ECECEC;
  padding: 70px 50px;
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
  max-width: 2000px;
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
@media (max-width: 900px) {
  .about-institute-page {
    overflow-x: auto;
  }
  
  .about-section, .service-section, .navigation-footer {
    min-width: 900px;
  }
}

@media (max-width: 768px) {

  
  .about-content {
    flex-direction: column;
  }
  
  .about-image, .about-text {
    width: 100%;
  }
  
  .service-card {
    flex-direction: column;
  }
  
  .service-image, .service-content {
    width: 100%;
  }
  

}
</style>
