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

    <!-- Action Button Section -->
    <ActionButton 
      primary-text="お問い合わせはコチラ"
      secondary-text="入会はコチラ"
      @primary-click="handleContactClick"
      @secondary-click="handleJoinClick"
    />

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
import Navigation from "./Navigation";
import ContactSection from "./ContactSection.vue";
import Footer from "./Footer";
import Group27 from "./Group27";
import AccessSection from "./AccessSection";
import HeroSection from "./HeroSection.vue";
import Breadcrumbs from "./Breadcrumbs.vue";
import FixedSideButtons from "./FixedSideButtons.vue";
import ActionButton from "./ActionButton.vue";
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
    ActionButton
  },
  data() {
    return {
      vector7: vector7,
      frame132131753022Props: frame132131753022Data,
    };
  },
  mounted() {
    // JavaScriptによる画像の高さ調整を削除
  },
  beforeDestroy() {
    // JavaScriptによる画像の高さ調整を削除
  },
  methods: {
    // JavaScriptによる画像の高さ調整を削除
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
  padding: 70px 50px 50px 50px;
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





/* Footer Navigation */



/* Responsive Design */
@media (max-width: 1200px) {
  .about-section, .service-section {
    padding: 60px 40px 40px 40px;
    gap: 30px;
  }
  
  .section-title {
    font-size: 32px;
  }
  
  .main-headline {
    font-size: 48px;
  }
  
  .about-description {
    font-size: 18px;
  }
  
  .about-text {
    padding: 40px;
    gap: 30px;
  }
  
  .service-content {
    padding: 30px;
    gap: 15px;
  }
  
  .service-title {
    font-size: 22px;
  }
}

@media (max-width: 900px) {
  .about-section, .service-section {
    padding: 50px 30px 30px 30px;
    gap: 25px;
    min-width: auto;
    width: 100%;
  }
  
  .section-header {
    gap: 20px;
  }
  
  .section-title {
    font-size: 28px;
  }
  
  .divider-line {
    width: 50px;
  }
  
  .divider-text {
    font-size: 18px;
  }
  
  .about-content {
    flex-direction: column;
    gap: 0;
  }
  
  .about-image {
    width: 100%;
    border-radius: 20px 20px 0 0;
    height: 300px;
  }
  
  .about-text {
    width: 100%;
    padding: 30px;
    gap: 25px;
    border-radius: 0 0 20px 20px;
  }
  
  .main-headline {
    font-size: 36px;
    text-align: center;
  }
  
  .about-description {
    font-size: 16px;
    text-align: center;
  }
  
  .service-cards {
    gap: 30px;
  }
  
  .service-card {
    flex-direction: column;
  }
  
  .service-image {
    width: 100%;
    height: 250px;
  }
  
  .service-content {
    width: 100%;
    padding: 25px;
    gap: 15px;
  }
  
  .service-title {
    font-size: 20px;
    text-align: center;
  }
  
  .service-description {
    font-size: 15px;
    text-align: center;
  }
  
  .service-details {
    font-size: 13px;
    padding: 15px;
  }
}

@media (max-width: 768px) {
  .about-section, .service-section {
    padding: 40px 20px 20px 20px;
    gap: 20px;
  }
  
  .section-header {
    gap: 15px;
  }
  
  .section-title {
    font-size: 24px;
  }
  
  .divider-line {
    width: 40px;
  }
  
  .divider-text {
    font-size: 16px;
  }
  
  .about-image {
    height: 250px;
  }
  
  .about-text {
    padding: 25px 20px;
    gap: 20px;
  }
  
  .main-headline {
    font-size: 28px;
  }
  
  .about-description {
    font-size: 14px;
  }
  
  .service-cards {
    gap: 25px;
  }
  
  .service-image {
    height: 200px;
  }
  
  .service-content {
    padding: 20px;
    gap: 12px;
  }
  
  .service-title {
    font-size: 18px;
  }
  
  .service-description {
    font-size: 14px;
  }
  
  .service-details {
    font-size: 12px;
    padding: 12px;
  }
}

@media (max-width: 480px) {
  .about-section, .service-section {
    padding: 30px 15px 15px 15px;
    gap: 15px;
  }
  
  .section-header {
    gap: 12px;
  }
  
  .section-title {
    font-size: 20px;
  }
  
  .divider-line {
    width: 30px;
  }
  
  .divider-text {
    font-size: 14px;
  }
  
  .about-image {
    height: 200px;
  }
  
  .about-text {
    padding: 20px 15px;
    gap: 15px;
  }
  
  .main-headline {
    font-size: 22px;
  }
  
  .about-description {
    font-size: 13px;
  }
  
  .service-cards {
    gap: 20px;
  }
  
  .service-image {
    height: 180px;
  }
  
  .service-content {
    padding: 15px;
    gap: 10px;
  }
  
  .service-title {
    font-size: 16px;
  }
  
  .service-description {
    font-size: 13px;
  }
  
  .service-details {
    font-size: 11px;
    padding: 10px;
  }
}
</style>
