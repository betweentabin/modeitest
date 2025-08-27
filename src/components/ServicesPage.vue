<template>
  <div class="page-container">
    <Navigation />
    <div class="page-content">
      <div class="page-header">
        <h1>{{ pageData ? pageData.title : '会員サービスのご案内' }}</h1>
        <p class="subtitle">SERVICES</p>
      </div>

      <div class="services-intro" v-if="pageData && pageData.content">
        <p class="lead-text">
          {{ pageData.content.description || 'ちくぎん地域経済研究所では、地域企業の皆様の成長と発展を支援するため、様々なサービスをご提供しています。' }}
        </p>
      </div>

      <div class="services-grid">
        <div class="service-card">
          <div class="service-image">
            <img src="/img/image.png" alt="調査研究" />
          </div>
          <div class="service-content">
            <h2>調査研究</h2>
            <p class="service-subtitle">「知りたい・学びたい」をサポート</p>
            <p class="service-description">
              地域経済の動向分析、市場調査、業界分析など、
              データに基づいた調査研究サービスを提供します。
              お客様のビジネス戦略立案に必要な情報をご提供いたします。
            </p>
            <ul class="service-features">
              <li>地域経済動向レポート</li>
              <li>業界別市場分析</li>
              <li>消費者動向調査</li>
              <li>競合分析レポート</li>
            </ul>
          </div>
        </div>

        <div class="service-card">
          <div class="service-image">
            <img src="/img/image-1.png" alt="人財開発" />
          </div>
          <div class="service-content">
            <h2>人財開発</h2>
            <p class="service-subtitle">人材を人財へ</p>
            <p class="service-description">
              社員研修、セミナー開催、人材育成プログラムの策定など、
              企業の人材を「人財」へと育成するお手伝いをいたします。
            </p>
            <ul class="service-features">
              <li>階層別研修プログラム</li>
              <li>専門スキル研修</li>
              <li>リーダーシップ開発</li>
              <li>組織活性化支援</li>
            </ul>
          </div>
        </div>

        <div class="service-card">
          <div class="service-image">
            <img src="/img/image-2.png" alt="経営支援" />
          </div>
          <div class="service-content">
            <h2>経営支援（経営サポート）</h2>
            <p class="service-subtitle">改善から改革へ</p>
            <p class="service-description">
              経営戦略の立案、業務改善、事業承継など、
              企業経営に関する総合的なコンサルティングサービスを提供します。
            </p>
            <ul class="service-features">
              <li>経営戦略策定支援</li>
              <li>業務プロセス改善</li>
              <li>事業承継サポート</li>
              <li>M&Aアドバイザリー</li>
            </ul>
          </div>
        </div>
      </div>

      <div class="membership-section">
        <h2>会員制度について</h2>
        <div class="membership-grid">
          <div class="membership-card">
            <h3>スタンダード会員</h3>
            <div class="membership-features">
              <ul>
                <li>月次経済レポートの配信</li>
                <li>セミナー参加割引</li>
                <li>経営相談（年2回まで）</li>
                <li>各種刊行物の優先購入</li>
              </ul>
            </div>
            <div class="membership-price">
              <p class="price-label">年会費</p>
              <p class="price">¥120,000</p>
            </div>
          </div>

          <div class="membership-card premium">
            <div class="premium-badge">おすすめ</div>
            <h3>プレミアム会員</h3>
            <div class="membership-features">
              <ul>
                <li>全てのスタンダード会員特典</li>
                <li>専門コンサルタントによる個別相談（無制限）</li>
                <li>オーダーメイド調査（年1回）</li>
                <li>社内研修の企画・実施（年2回）</li>
                <li>優先的な情報提供サービス</li>
              </ul>
            </div>
            <div class="membership-price">
              <p class="price-label">年会費</p>
              <p class="price">¥360,000</p>
            </div>
          </div>
        </div>
      </div>

      <div class="cta-section">
        <h2>まずはお気軽にご相談ください</h2>
        <p>貴社のニーズに合わせた最適なサービスをご提案いたします</p>
        <button class="cta-button" @click="$router.push('/contact')">
          お問い合わせはこちら
        </button>
      </div>
    </div>
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
  }
};
</script>

<style scoped>
.page-container {
  min-height: 100vh;
  background-color: #f8f9fa;
}

.page-content {
  max-width: 1200px;
  margin: 0 auto;
  padding: 40px 20px;
}

.page-header {
  text-align: center;
  margin-bottom: 40px;
}

.page-header h1 {
  font-size: 2.5rem;
  color: #333;
  margin-bottom: 10px;
}

.subtitle {
  color: #dc3545;
  font-size: 1.2rem;
  font-weight: 600;
  letter-spacing: 2px;
}

.services-intro {
  text-align: center;
  margin-bottom: 60px;
}

.lead-text {
  font-size: 1.1rem;
  line-height: 1.8;
  color: #666;
}

.services-grid {
  display: grid;
  gap: 40px;
  margin-bottom: 60px;
}

.service-card {
  background: white;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
  display: flex;
  align-items: center;
}

.service-card:nth-child(even) {
  flex-direction: row-reverse;
}

.service-image {
  flex: 0 0 40%;
  padding: 20px;
}

.service-image img {
  width: 100%;
  height: auto;
  border-radius: 10px;
}

.service-content {
  flex: 1;
  padding: 40px;
}

.service-content h2 {
  color: #dc3545;
  font-size: 1.8rem;
  margin-bottom: 10px;
}

.service-subtitle {
  color: #666;
  font-size: 1.1rem;
  margin-bottom: 20px;
}

.service-description {
  line-height: 1.8;
  color: #666;
  margin-bottom: 20px;
}

.service-features {
  list-style: none;
  padding: 0;
}

.service-features li {
  padding: 8px 0;
  padding-left: 25px;
  position: relative;
  color: #666;
}

.service-features li:before {
  content: "✓";
  position: absolute;
  left: 0;
  color: #dc3545;
  font-weight: bold;
}

.membership-section {
  background: white;
  padding: 60px;
  border-radius: 10px;
  margin-bottom: 40px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.membership-section h2 {
  text-align: center;
  color: #dc3545;
  font-size: 2rem;
  margin-bottom: 40px;
}

.membership-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 40px;
}

.membership-card {
  border: 2px solid #dee2e6;
  border-radius: 10px;
  padding: 30px;
  position: relative;
}

.membership-card.premium {
  border-color: #dc3545;
  transform: scale(1.05);
}

.premium-badge {
  position: absolute;
  top: -15px;
  right: 30px;
  background: #dc3545;
  color: white;
  padding: 5px 20px;
  border-radius: 20px;
  font-size: 0.9rem;
}

.membership-card h3 {
  text-align: center;
  color: #333;
  font-size: 1.5rem;
  margin-bottom: 30px;
}

.membership-features ul {
  list-style: none;
  padding: 0;
  margin-bottom: 30px;
}

.membership-features li {
  padding: 10px 0;
  padding-left: 25px;
  position: relative;
  color: #666;
  border-bottom: 1px solid #f0f0f0;
}

.membership-features li:before {
  content: "✓";
  position: absolute;
  left: 0;
  color: #28a745;
  font-weight: bold;
}

.membership-price {
  text-align: center;
  padding-top: 20px;
  border-top: 2px solid #dee2e6;
}

.price-label {
  color: #666;
  margin-bottom: 10px;
}

.price {
  font-size: 2rem;
  font-weight: bold;
  color: #dc3545;
}

.cta-section {
  text-align: center;
  background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
  color: white;
  padding: 60px;
  border-radius: 10px;
  margin-top: 60px;
}

.cta-section h2 {
  font-size: 2rem;
  margin-bottom: 20px;
}

.cta-section p {
  font-size: 1.1rem;
  margin-bottom: 30px;
}

.cta-button {
  background: white;
  color: #dc3545;
  border: none;
  padding: 15px 40px;
  font-size: 1.1rem;
  border-radius: 50px;
  cursor: pointer;
  transition: transform 0.3s;
}

.cta-button:hover {
  transform: scale(1.05);
}

@media (max-width: 768px) {
  .service-card,
  .service-card:nth-child(even) {
    flex-direction: column;
  }
  
  .service-image {
    flex: none;
    width: 100%;
  }
  
  .membership-grid {
    grid-template-columns: 1fr;
  }
  
  .membership-card.premium {
    transform: none;
  }
}
</style>