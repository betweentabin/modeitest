<template>
  <div class="page-container">
    <Navigation />
    
    <!-- Hero Section -->
    <div class="hero-section">
      <div class="hero-overlay">
        <div class="hero-content">
          <h1 class="hero-title">プレミアム会員</h1>
          <p class="hero-subtitle">benefits</p>
        </div>
      </div>
    </div>

    <div class="page-content">
      <!-- Premium Member Introduction -->
      <section class="premium-intro">
        <div class="intro-content">
          <h2 class="intro-title">プレミアム会員の特典に関して</h2>
          <p class="intro-description">
            ちくぎん地域経済研究所のプレミアム会員になることで、より多くの調査資料やサポートが受けられるようになります。
          </p>
        </div>
      </section>

      <!-- Benefits Section -->
      <section class="benefits-section">
        <div class="section-header">
          <h2 class="section-title">諸題の特典</h2>
          <p class="section-subtitle">benefits</p>
        </div>

        <div class="benefit-card">
          <div class="benefit-image">
            <img src="/img/image-1.png" alt="日経トップリーダー" />
          </div>
          <div class="benefit-content">
            <h3 class="benefit-title">日経トップリーダービジネスで勝ち抜くヒント集</h3>
            <p class="benefit-subtitle">毎月、日経トップリーダーをお届けします。</p>
            <p class="benefit-description">
              経営トップに役立つ実践的な経営論を厳選し、深谷の時代を勝ち抜く企業づくりのヒントを毎号、
              情報源にするお手伝いで、企業の競争力向上にご利用します。
            </p>
            <button class="benefit-button">日経トップリーダーを確認する</button>
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
          <p class="cta-subtitle">About us</p>
          <p class="cta-description">様々な分野の調査研究を通じ、企業活動などをサポートします。</p>
          <button class="cta-button" @click="scrollToContact">お問い合わせはこちら</button>
        </div>
      </div>
    </section>

    <FooterComplete />
  </div>
</template>

<script>
import Navigation from "./Navigation.vue";
import FooterComplete from "./FooterComplete.vue";
import axios from 'axios';
import { getApiUrl } from '@/config/api';

export default {
  name: "ServicesPage",
  components: {
    Navigation,
    FooterComplete
  },
  data() {
    return {
      pageData: null,
      loading: true,
      error: null
    };
  },
  async mounted() {
    try {
      const response = await axios.get(getApiUrl('/api/pages/services'));
      this.pageData = response.data;
      this.loading = false;
    } catch (err) {
      console.error('Failed to fetch page data:', err);
      this.error = 'ページデータの取得に失敗しました';
      this.loading = false;
    }
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

/* Premium Introduction */
.premium-intro {
  text-align: center;
  margin-bottom: 60px;
  padding: 40px;
  background-color: #f8f9fa;
  border-radius: 10px;
}

.intro-title {
  font-size: 1.8rem;
  color: #333;
  margin-bottom: 20px;
  font-weight: bold;
}

.intro-description {
  font-size: 1.1rem;
  color: #666;
  line-height: 1.8;
  max-width: 800px;
  margin: 0 auto;
}

/* Benefits Section */
.benefits-section {
  margin-bottom: 60px;
}

.section-header {
  text-align: center;
  margin-bottom: 50px;
}

.section-title {
  font-size: 2rem;
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

/* Benefit Card */
.benefit-card {
  background: white;
  border-radius: 15px;
  overflow: hidden;
  box-shadow: 0 5px 20px rgba(0,0,0,0.1);
  display: flex;
  align-items: center;
  margin-bottom: 40px;
}

.benefit-image {
  flex: 0 0 40%;
  padding: 30px;
}

.benefit-image img {
  width: 100%;
  height: auto;
  border-radius: 10px;
}

.benefit-content {
  flex: 1;
  padding: 40px;
}

.benefit-title {
  font-size: 1.5rem;
  color: #333;
  margin-bottom: 10px;
  font-weight: bold;
}

.benefit-subtitle {
  font-size: 1.1rem;
  color: #da5761;
  margin-bottom: 20px;
  font-weight: 500;
}

.benefit-description {
  font-size: 1rem;
  color: #666;
  line-height: 1.8;
  margin-bottom: 25px;
}

.benefit-button {
  background: #da5761;
  color: white;
  border: none;
  padding: 12px 30px;
  border-radius: 25px;
  cursor: pointer;
  font-size: 0.9rem;
  transition: all 0.3s;
  font-weight: 500;
}

.benefit-button:hover {
  background: #c44853;
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(218, 87, 97, 0.3);
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
  margin-bottom: 10px;
  font-weight: bold;
}

.cta-subtitle {
  font-size: 1rem;
  letter-spacing: 2px;
  margin-bottom: 20px;
  color: rgba(255,255,255,0.8);
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
  
  .benefit-card {
    flex-direction: column;
  }
  
  .benefit-image {
    flex: none;
    width: 100%;
    padding: 20px;
  }
  
  .benefit-content {
    padding: 20px;
  }
  
  .action-buttons {
    flex-direction: column;
    align-items: center;
  }
  
  .action-btn {
    width: 100%;
    max-width: 300px;
  }
  
  .premium-intro {
    padding: 20px;
  }
}

@media (max-width: 480px) {
  .benefit-title {
    font-size: 1.3rem;
  }
  
  .benefit-subtitle {
    font-size: 1rem;
  }
  
  .benefit-description {
    font-size: 0.9rem;
  }
}
</style>