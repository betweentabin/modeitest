<template>
  <div class="page-container">
    <Navigation />
    
    <!-- Hero Section -->
    <div class="hero-section">
      <div class="hero-overlay">
        <div class="hero-content">
          <p class="hero-subtitle">site map</p>
          <h1 class="hero-title">サイトマップ</h1>
        </div>
      </div>
    </div>

    <div class="page-content">
      <!-- Breadcrumb -->
      <div class="breadcrumb">
        <span>トップ</span>
        <span class="separator">＞</span>
        <span>サイトマップ</span>
      </div>

      <!-- Page Header -->
      <div class="page-header">
        <h2 class="section-title">サイトマップ</h2>
        <p class="section-subtitle">site map</p>
      </div>

      <!-- Sitemap Grid -->
      <div class="sitemap-grid">
        <!-- Column 1 -->
        <div class="sitemap-column">
          <ul class="sitemap-list">
            <li class="sitemap-item">
              <img class="arrow-icon" src="/img/vector.svg" alt=">" />
              <router-link to="/" class="sitemap-link">トップ</router-link>
            </li>
            <li class="sitemap-item">
              <img class="arrow-icon" src="/img/vector.svg" alt=">" />
              <router-link to="/about" class="sitemap-link">会社概要</router-link>
            </li>
            <li class="sitemap-item">
              <img class="arrow-icon" src="/img/vector.svg" alt=">" />
              <router-link to="/news" class="sitemap-link">お知らせ</router-link>
            </li>
            <li class="sitemap-item">
              <img class="arrow-icon" src="/img/vector.svg" alt=">" />
              <router-link to="/faq" class="sitemap-link">よくあるご質問</router-link>
            </li>
            <li class="sitemap-item">
              <img class="arrow-icon" src="/img/vector.svg" alt=">" />
              <router-link to="/contact" class="sitemap-link">お問い合わせ</router-link>
            </li>
          </ul>
        </div>

        <!-- Column 2 -->
        <div class="sitemap-column">
          <ul class="sitemap-list">
            <li class="sitemap-item">
              <img class="arrow-icon" src="/img/vector.svg" alt=">" />
              <router-link to="/seminars" class="sitemap-link">セミナー</router-link>
            </li>
            <li class="sitemap-item">
              <img class="arrow-icon" src="/img/vector.svg" alt=">" />
              <router-link to="/publications" class="sitemap-link">刊行物</router-link>
            </li>
            <li class="sitemap-item category-title">
              <span class="category-text">各種情報</span>
            </li>
            <li class="sitemap-item">
              <img class="arrow-icon" src="/img/vector.svg" alt=">" />
              <router-link to="/statistics" class="sitemap-link">経済指標一覧</router-link>
            </li>
            <li class="sitemap-item">
              <img class="arrow-icon" src="/img/vector.svg" alt=">" />
              <router-link to="/statistics" class="sitemap-link">経済調査統計一覧</router-link>
            </li>
            <li class="sitemap-item category-title">
              <span class="category-text">会員PR</span>
            </li>
            <li class="sitemap-item">
              <img class="arrow-icon" src="/img/vector.svg" alt=">" />
              <router-link to="/register" class="sitemap-link">会員PRどっとコム</router-link>
            </li>
            <li class="sitemap-item">
              <img class="arrow-icon" src="/img/vector.svg" alt=">" />
              <router-link to="/services" class="sitemap-link">入会案内</router-link>
            </li>
          </ul>
        </div>

        <!-- Column 3 -->
        <div class="sitemap-column">
          <ul class="sitemap-list">
            <li class="sitemap-item">
              <img class="arrow-icon" src="/img/vector.svg" alt=">" />
              <span class="sitemap-text">会員サービスのご案内</span>
            </li>
            <li class="sitemap-item sub-item">
              <span class="sub-text">スタンダード（紹介）</span>
            </li>
            <li class="sitemap-item sub-item">
              <span class="sub-text">プレミアム（紹介）</span>
            </li>
            <li class="sitemap-item">
              <img class="arrow-icon" src="/img/vector.svg" alt=">" />
              <router-link to="/glossary" class="sitemap-link">用語集</router-link>
            </li>
            <li class="sitemap-item">
              <img class="arrow-icon" src="/img/vector.svg" alt=">" />
              <router-link to="/statistics" class="sitemap-link">経済・調査統計</router-link>
            </li>
            <li class="sitemap-item">
              <img class="arrow-icon" src="/img/vector.svg" alt=">" />
              <router-link to="/cri-consulting" class="sitemap-link">CRI経営コンサルティング</router-link>
            </li>
            <li class="sitemap-item">
              <img class="arrow-icon" src="/img/vector.svg" alt=">" />
              <router-link to="/financial-report" class="sitemap-link">決算報告</router-link>
            </li>
          </ul>
        </div>

        <!-- Column 4 -->
        <div class="sitemap-column">
          <ul class="sitemap-list">
            <li class="sitemap-item category-title">
              <span class="category-text">会員ログイン</span>
            </li>
            <li class="sitemap-item">
              <img class="arrow-icon" src="/img/vector.svg" alt=">" />
              <router-link to="/transaction-law" class="sitemap-link">特定商取引法に関する表記</router-link>
            </li>
            <li class="sitemap-item">
              <img class="arrow-icon" src="/img/vector.svg" alt=">" />
              <router-link to="/privacy" class="sitemap-link">プライバシーポリシー</router-link>
            </li>
            <li class="sitemap-item">
              <img class="arrow-icon" src="/img/vector.svg" alt=">" />
              <router-link to="/terms" class="sitemap-link">利用規約</router-link>
            </li>
            <li class="sitemap-item">
              <img class="arrow-icon" src="/img/vector.svg" alt=">" />
              <router-link to="/sitemap" class="sitemap-link">サイトマップ</router-link>
            </li>
          </ul>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="action-buttons">
        <button class="action-btn contact-btn" @click="goToContact">お問い合わせはコチラ</button>
        <button class="action-btn member-btn" @click="goToMember">入会はコチラ</button>
      </div>

      <!-- Access Section -->
      <section class="access-section">
        <div class="access-header">
          <h2>アクセス</h2>
          <h3 class="access-title">ACCESS</h3>
        </div>
        
        <div class="access-content">
          <div class="map-container">
            <div class="map-placeholder">
              <img src="/img/hero-image.png" alt="アクセスマップ" class="map-image" />
            </div>
          </div>
          
          <div class="access-info">
            <div class="access-item">
              <h4>会社情報</h4>
              <p>会社名：株式会社ちくぎん地域経済研究所</p>
              <p>住所：〒839-0864</p>
              <p>福岡県久留米市百年公園2番地1号久留米リサーチ・パーク内6階</p>
              <p>電話番号：0942-46-5091</p>
              <p>営業時間：平日9:00-17:00</p>
            </div>
            
            <div class="access-item">
              <h4>電車でお越しの場合</h4>
              <p>西鉄久留米線・JR久留米駅より徒歩14分 県営住宅前バス停より徒歩1分</p>
              <p>所要時間約11分（平日）徒歩時間 所要時間約10分</p>
              <p>平日のみ運行・徒歩で約30分 久留米シティプラザまで徒歩15分</p>
            </div>
            
            <div class="access-item">
              <h4>お車でお越しの場合</h4>
              <p>【九州自動車道】九州自動車道・久留米インター線経由約4分（平日早朝平日のみ）</p>
              <p>メインの久留米市・ポートタウン約8分（平日のみ）</p>
              <p>ローバー金融機構約8分・久留米発着約8分（平日8:00-18:00）</p>
            </div>
          </div>
        </div>
      </section>
    </div>

    <FooterComplete />
  </div>
</template>

<script>
import Navigation from "./Navigation.vue";
import FooterComplete from "./FooterComplete.vue";

export default {
  name: "SitemapPage",
  components: {
    Navigation,
    FooterComplete
  },
  methods: {
    goToContact() {
      this.$router.push('/contact');
    },
    goToMember() {
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
  justify-content: flex-start;
  padding-left: 50px;
}

.hero-overlay {
  color: white;
}

.hero-subtitle {
  font-size: 0.9rem;
  letter-spacing: 2px;
  margin-bottom: 10px;
  color: #ffffff;
  opacity: 0.9;
}

.hero-title {
  font-size: 2.5rem;
  font-weight: bold;
  color: white;
}

/* Page Content */
.page-content {
  max-width: 1000px;
  margin: 0 auto;
  padding: 40px 20px;
}

/* Breadcrumb */
.breadcrumb {
  color: #666;
  font-size: 0.9rem;
  margin-bottom: 30px;
}

.separator {
  margin: 0 8px;
  color: #999;
}

/* Page Header */
.page-header {
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

/* Sitemap Grid */
.sitemap-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 40px;
  margin-bottom: 60px;
  background: white;
  border-radius: 15px;
  padding: 40px;
  box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

.sitemap-column {
  min-height: 200px;
}

.sitemap-list {
  list-style: none;
}

.sitemap-item {
  display: flex;
  align-items: center;
  margin-bottom: 12px;
  min-height: 20px;
}

.sitemap-item.category-title {
  margin-bottom: 8px;
  margin-top: 20px;
}

.sitemap-item.category-title:first-child {
  margin-top: 0;
}

.sitemap-item.sub-item {
  padding-left: 20px;
  margin-bottom: 8px;
}

.arrow-icon {
  width: 10px;
  height: 17px;
  margin-right: 10px;
  flex-shrink: 0;
  filter: sepia(1) saturate(5) hue-rotate(320deg) brightness(0.8);
}

.sitemap-link {
  color: #333;
  text-decoration: none;
  font-size: 0.95rem;
  line-height: 1.4;
  transition: color 0.3s;
}

.sitemap-link:hover {
  color: #da5761;
}

.sitemap-text {
  color: #333;
  font-size: 0.95rem;
  line-height: 1.4;
}

.category-text {
  color: #333;
  font-size: 0.95rem;
  font-weight: 500;
}

.sub-text {
  color: #666;
  font-size: 0.9rem;
  line-height: 1.4;
}

/* Action Buttons */
.action-buttons {
  display: flex;
  gap: 20px;
  justify-content: center;
  margin-bottom: 60px;
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

.member-btn {
  background: #8B0000;
  color: white;
}

.member-btn:hover {
  background: #660000;
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(139, 0, 0, 0.3);
}

/* Access Section */
.access-section {
  margin-bottom: 40px;
}

.access-header {
  margin-bottom: 40px;
}

.access-header h2 {
  font-size: 1.2rem;
  color: #666;
  margin-bottom: 5px;
}

.access-title {
  font-size: 2rem;
  color: #333;
  font-weight: bold;
}

.access-content {
  display: flex;
  gap: 40px;
  align-items: flex-start;
}

.map-container {
  flex: 1;
}

.map-image {
  width: 100%;
  height: 300px;
  object-fit: cover;
  border-radius: 15px;
}

.access-info {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 25px;
}

.access-item h4 {
  color: #333;
  font-size: 1.1rem;
  font-weight: bold;
  margin-bottom: 10px;
}

.access-item p {
  color: #666;
  font-size: 0.9rem;
  line-height: 1.6;
  margin-bottom: 5px;
}

/* Responsive Design */
@media (max-width: 768px) {
  .hero-section {
    padding-left: 20px;
  }
  
  .hero-title {
    font-size: 2rem;
  }
  
  .page-content {
    padding: 30px 15px;
  }
  
  .sitemap-grid {
    grid-template-columns: repeat(2, 1fr);
    gap: 25px;
    padding: 25px;
  }
  
  .action-buttons {
    flex-direction: column;
    align-items: center;
  }
  
  .action-btn {
    width: 100%;
    max-width: 300px;
  }
  
  .access-content {
    flex-direction: column;
  }
}

@media (max-width: 480px) {
  .sitemap-grid {
    grid-template-columns: 1fr;
  }
  
  .sitemap-link,
  .sitemap-text,
  .category-text {
    font-size: 0.85rem;
  }
  
  .access-item p {
    font-size: 0.85rem;
  }
}
</style>