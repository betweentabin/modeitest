<template>
  <div class="page-container">
    <Navigation />
    
    <!-- Hero Section -->
    <div class="hero-section">
      <div class="hero-overlay">
        <div class="hero-content">
          <h1 class="hero-title">入会案内</h1>
          <p class="hero-subtitle">membership</p>
        </div>
      </div>
    </div>

    <div class="page-content">
      <!-- Membership Introduction -->
      <section class="membership-intro">
        <div class="intro-content">
          <h2 class="intro-title">ご入会について</h2>
          <p class="intro-description">
            ちくぎん地域経済研究所は、地域企業の発展に貢献し、地域社会の未来を展望する活動を実施しています。<br>
            また、広域ネットワークとシンクタンク機能を活用し、多様な業務を通じて皆様の経営をサポートしております。<br>
            多くの経営者にとって有意義なサービスとなるよう努力してまいりますので、ぜひご入会をご検討下さい。
          </p>
        </div>
      </section>

      <!-- Services Overview -->
      <section class="services-overview">
        <div class="section-header">
          <h2 class="section-title">主な会員が受けられるサービス内容</h2>
          <p class="section-subtitle">service</p>
        </div>

        <!-- Premium Service -->
        <div class="service-card premium-service">
          <h3 class="service-title">プレミアサービス</h3>
          <div class="service-image">
            <img src="/img/image-1.png" alt="経営セミナー" />
            <p class="image-caption">経営セミナー</p>
          </div>
        </div>

        <!-- Standard & Premium Services Grid -->
        <div class="services-grid">
          <h3 class="grid-title">スタンダード ＆ プレミアサービス</h3>
          
          <div class="service-items">
            <div class="service-item">
              <img src="/img/image-1.png" alt="セミナー・研修" />
              <p class="service-name">セミナー・研修</p>
            </div>
            <div class="service-item">
              <img src="/img/image-2.png" alt="マーケティング" />
              <p class="service-name">マーケティング</p>
            </div>
            <div class="service-item">
              <img src="/img/image.png" alt="経営戦略の構築" />
              <p class="service-name">経営戦略の構築</p>
            </div>
            <div class="service-item">
              <img src="/img/image-1.png" alt="資金調達計画とキャッシュフロー" />
              <p class="service-name">資金調達計画とキャッシュフロー</p>
            </div>
            <div class="service-item">
              <img src="/img/image-2.png" alt="経営診断" />
              <p class="service-name">経営診断</p>
            </div>
          </div>
        </div>
      </section>

      <!-- Membership Details -->
      <section class="membership-details">
        <h3 class="details-title">会員サービスについて</h3>
        <p class="details-description">
          私たちの会員サービスは、地域企業の経営課題に対するソリューションを提供します。経営戦略の策定から、マーケティング支援、資金調達計画まで、幅広いサポートを行っています。
        </p>
        <p class="details-description">
          また、定期的な経営セミナーや勉強会を通じて、最新の経営手法や業界動向をお伝えし、会員企業の競争力強化をお手伝いします。経営診断サービスでは、客観的な視点から企業の現状を分析し、改善点を明確にしてまいります。
        </p>
        <div class="details-button">
          <button class="service-detail-button">サービス詳細を確認する</button>
        </div>
      </section>

      <!-- Membership Process -->
      <section class="membership-process">
        <div class="section-header">
          <h2 class="section-title">入会までの流れ</h2>
          <p class="section-subtitle">Flow of joining</p>
        </div>

        <div class="process-steps">
          <div class="step">
            <div class="step-number">STEP1</div>
            <div class="step-content">
              <h4>お問い合わせ</h4>
              <p>まずは、お気軽にお問い合わせください。お電話またはWebサイトのお問い合わせフォームよりご連絡ください。ご不明な点などお気軽にお尋ねください。</p>
            </div>
          </div>

          <div class="step">
            <div class="step-number">STEP2</div>
            <div class="step-content">
              <h4>入会のご案内・会員種別のご確認</h4>
              <p>入会手続きや会員種別について詳しくご案内いたします。</p>
            </div>
          </div>

          <div class="step">
            <div class="step-number">STEP3</div>
            <div class="step-content">
              <h4>申込み</h4>
              <p>申込用紙にご記入いただき、必要書類とともにご提出ください。</p>
            </div>
          </div>

          <div class="step">
            <div class="step-number">STEP4</div>
            <div class="step-content">
              <h4>会費のお支払い</h4>
              <p>入会金の入金確認後、各種サービスのご利用が可能になります。年会費、月会費については別途ご案内いたします。ご不明な点はメールまたはお電話でお問い合わせください。</p>
            </div>
          </div>
        </div>
      </section>

      <!-- Action Buttons -->
      <section class="action-section">
        <div class="action-buttons">
          <button class="action-btn contact-btn" @click="goToContact">お問い合わせはコチラ</button>
          <button class="action-btn register-btn" @click="goToRegister">入会はコチラ</button>
        </div>
      </section>
    </div>

    <!-- Company CTA Section -->
    <section class="company-cta-section">
      <div class="container">
        <div class="cta-content">
          <h2>株式会社ちくぎん地域経済研究所</h2>
          <p class="cta-description">様々な分野の調査研究を通じ、企業活動などをサポートします。</p>
          <button class="cta-button" @click="scrollToContact">お問い合わせはこちら</button>
        </div>
      </div>
    </section>

    <!-- Footer Navigation -->
    <div class="navigation-footer">
      <Footer v-bind="frame132131753022Props" />
      <div class="vector-7-1"></div>
      <Group27 />
    </div>
  </div>
</template>

<script>
import Navigation from "./Navigation.vue";
import Footer from "./Footer.vue";
import Group27 from "./Group27.vue";
import { frame132131753022Data } from "../data.js";

export default {
  name: "ServicesPage",
  components: {
    Navigation,
    Footer,
    Group27
  },
  data() {
    return {
      frame132131753022Props: frame132131753022Data,
    };
  },
  methods: {
    scrollToContact() {
      this.$router.push('/contact');
    },
    goToContact() {
      this.$router.push('/contact');
    },
    goToRegister() {
      this.$router.push('/register');
    }
  }
};
</script>

<style scoped>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

.page-container {
  min-height: 100vh;
  background-color: #ffffff;
}

/* Hero Section */
.hero-section {
  height: 300px;
  background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), 
              url('/img/hero-image.png') center/cover;
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
}

.hero-overlay {
  text-align: center;
  color: white;
}

.hero-title {
  font-size: 2.5rem;
  font-weight: bold;
  margin-bottom: 10px;
}

.hero-subtitle {
  font-size: 1rem;
  letter-spacing: 2px;
  color: #da5761;
}

/* Page Content */
.page-content {
  max-width: 1000px;
  margin: 0 auto;
  padding: 60px 20px;
}

/* Membership Introduction */
.membership-intro {
  text-align: center;
  margin-bottom: 60px;
  padding: 40px;
  background-color: #f8f9fa;
  border-radius: 10px;
}

.intro-title {
  font-size: 1.8rem;
  color: #333;
  margin-bottom: 30px;
  font-weight: bold;
}

.intro-description {
  font-size: 1rem;
  color: #666;
  line-height: 1.8;
  max-width: 800px;
  margin: 0 auto;
}

/* Services Overview */
.services-overview {
  margin-bottom: 60px;
}

.section-header {
  text-align: center;
  margin-bottom: 50px;
}

.section-title {
  font-size: 1.8rem;
  color: #333;
  margin-bottom: 10px;
  font-weight: bold;
}

.section-subtitle {
  color: #da5761;
  font-size: 1rem;
  letter-spacing: 2px;
  font-weight: 500;
  position: relative;
  padding-bottom: 20px;
}

.section-subtitle::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 50%;
  transform: translateX(-50%);
  width: 60px;
  height: 2px;
  background-color: #da5761;
}

/* Premium Service */
.premium-service {
  background: white;
  border-radius: 15px;
  padding: 30px;
  margin-bottom: 40px;
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.service-title {
  font-size: 1.5rem;
  color: #333;
  margin-bottom: 20px;
  font-weight: bold;
}

.service-image {
  text-align: center;
}

.service-image img {
  width: 200px;
  height: 150px;
  object-fit: cover;
  border-radius: 10px;
  margin-bottom: 10px;
}

.image-caption {
  font-size: 0.9rem;
  color: #666;
}

/* Services Grid */
.services-grid {
  background: white;
  border-radius: 15px;
  padding: 30px;
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
  margin-bottom: 40px;
}

.grid-title {
  font-size: 1.3rem;
  color: #333;
  margin-bottom: 25px;
  font-weight: bold;
  text-align: center;
}

.service-items {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
  gap: 20px;
}

.service-item {
  text-align: center;
  padding: 15px;
  border-radius: 10px;
  transition: transform 0.3s, box-shadow 0.3s;
}

.service-item:hover {
  transform: translateY(-5px);
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.service-item img {
  width: 80px;
  height: 80px;
  object-fit: cover;
  border-radius: 10px;
  margin-bottom: 10px;
}

.service-name {
  font-size: 0.9rem;
  color: #333;
  font-weight: 500;
}

/* Membership Details */
.membership-details {
  background: white;
  border-radius: 15px;
  padding: 40px;
  margin-bottom: 40px;
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.details-title {
  font-size: 1.5rem;
  color: #333;
  margin-bottom: 20px;
  font-weight: bold;
}

.details-description {
  font-size: 1rem;
  color: #666;
  line-height: 1.8;
  margin-bottom: 20px;
}

.details-button {
  text-align: center;
  margin-top: 30px;
}

.service-detail-button {
  background: #da5761;
  color: white;
  border: none;
  padding: 12px 30px;
  border-radius: 25px;
  cursor: pointer;
  font-size: 1rem;
  transition: all 0.3s;
  font-weight: 500;
}

.service-detail-button:hover {
  background: #c44853;
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(218, 87, 97, 0.3);
}

/* Membership Process */
.membership-process {
  margin-bottom: 60px;
}

.process-steps {
  max-width: 700px;
  margin: 0 auto;
}

.step {
  display: flex;
  align-items: flex-start;
  margin-bottom: 30px;
  padding: 20px;
  background: white;
  border-radius: 10px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.step-number {
  flex: 0 0 80px;
  background: #da5761;
  color: white;
  padding: 8px 16px;
  border-radius: 20px;
  font-weight: bold;
  font-size: 0.9rem;
  text-align: center;
  margin-right: 20px;
}

.step-content h4 {
  font-size: 1.1rem;
  color: #333;
  margin-bottom: 10px;
  font-weight: bold;
}

.step-content p {
  font-size: 0.9rem;
  color: #666;
  line-height: 1.6;
}

/* Action Section */
.action-section {
  margin-bottom: 60px;
}

.action-buttons {
  display: flex;
  gap: 20px;
  justify-content: center;
}

.action-btn {
  border: none;
  padding: 15px 40px;
  border-radius: 50px;
  cursor: pointer;
  font-size: 1rem;
  font-weight: bold;
  transition: all 0.3s;
  min-width: 200px;
}

.contact-btn {
  background: #da5761;
  color: white;
}

.contact-btn:hover {
  background: #c44853;
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(218, 87, 97, 0.3);
}

.register-btn {
  background: #8B0000;
  color: white;
}

.register-btn:hover {
  background: #660000;
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(139, 0, 0, 0.3);
}

/* Company CTA Section */
.company-cta-section {
  background: linear-gradient(135deg, #da5761 0%, #c44853 100%);
  color: white;
  text-align: center;
  padding: 80px 0;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 20px;
}

.cta-content h2 {
  font-size: 2rem;
  margin-bottom: 20px;
  font-weight: bold;
}

.cta-description {
  font-size: 1.1rem;
  margin-bottom: 30px;
  color: rgba(255,255,255,0.9);
}

.cta-button {
  background: white;
  color: #da5761;
  border: none;
  padding: 15px 40px;
  font-size: 1.1rem;
  border-radius: 50px;
  cursor: pointer;
  transition: transform 0.3s, box-shadow 0.3s;
  font-weight: bold;
}

.cta-button:hover {
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

/* Responsive Design */
@media (max-width: 768px) {
  .hero-title {
    font-size: 2rem;
  }
  
  .page-content {
    padding: 40px 15px;
  }
  
  .service-items {
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 15px;
  }
  
  .action-buttons {
    flex-direction: column;
    align-items: center;
  }
  
  .action-btn {
    width: 100%;
    max-width: 300px;
  }
  
  .step {
    flex-direction: column;
    text-align: center;
  }
  
  .step-number {
    margin-right: 0;
    margin-bottom: 15px;
    align-self: center;
  }
  
  .membership-intro,
  .premium-service,
  .services-grid,
  .membership-details {
    padding: 20px;
  }
}

@media (max-width: 480px) {
  .service-item img {
    width: 60px;
    height: 60px;
  }
  
  .service-name {
    font-size: 0.8rem;
  }
  
  .step-content h4 {
    font-size: 1rem;
  }
  
  .step-content p {
    font-size: 0.85rem;
  }
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

.navigation-footer .vector-7-1 {
  height: 1px;
  background-color: #B2B2B2;
  position: relative;
  width: 100%;
  max-width: 1240px;
}
</style>