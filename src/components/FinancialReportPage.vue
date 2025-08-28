<template>
  <div class="page-container">
    <Navigation />
    
    <!-- Hero Section -->
    <div class="hero-section">
      <div class="hero-overlay">
        <div class="hero-content">
          <p class="hero-subtitle">financial report</p>
          <h1 class="hero-title">決算報告</h1>
        </div>
      </div>
    </div>

    <div class="page-content">
      <!-- Breadcrumb -->
      <div class="breadcrumb">
        <span>トップ</span>
        <span class="separator">＞</span>
        <span>決算報告</span>
      </div>

      <!-- Page Header -->
      <div class="page-header">
        <h2 class="section-title">決算報告</h2>
        <p class="section-subtitle">financial report</p>
      </div>

      <!-- Financial Reports -->
      <div class="reports-container">
        <!-- 2025年3月期 -->
        <div class="report-section">
          <h3 class="report-year">2025年3月期</h3>
          <div class="report-date">決算短信（2020年5月12日）</div>
          <ul class="report-list">
            <li class="report-item">
              <span class="report-title">決算短信（2020年5月12日）</span>
            </li>
            <li class="report-item">
              <span class="report-title">決算説明資料（PDF・1,285KB・全3ページ）</span>
            </li>
            <li class="report-item">
              <span class="report-title">決算説明資料【第2期（決算説明）資料】（PDF・334KB・全2ページ）</span>
            </li>
            <li class="report-item">
              <span class="report-title">決算報告書【第1期（決算メンバー）】スピーチ（PDF・626KB・全1ページ）</span>
            </li>
            <li class="report-item">
              <span class="report-title">メディアの売上実績配信の利益を見いただいたより上げす</span>
            </li>
          </ul>
        </div>

        <!-- 2024年3月期 -->
        <div class="report-section">
          <h3 class="report-year">2024年3月期</h3>
          <div class="report-date">決算短信（2020年5月12日）</div>
          <ul class="report-list">
            <li class="report-item">
              <span class="report-title">決算短信（2020年5月12日）</span>
            </li>
            <li class="report-item">
              <span class="report-title">決算説明（PDF・1,285KB・全3ページ）</span>
            </li>
            <li class="report-item">
              <span class="report-title">決算説明資料【第2期（決算説明）資料】（PDF・334KB・全2ページ）</span>
            </li>
            <li class="report-item">
              <span class="report-title">決算報告書【第1期（決算メンバー）】スピーチ（PDF・626KB・全1ページ）</span>
            </li>
            <li class="report-item">
              <span class="report-title">メディアの売上実績配信の利益を見いただいたより上げす</span>
            </li>
          </ul>
        </div>

        <!-- 2023年3月期 -->
        <div class="report-section">
          <h3 class="report-year">2023年3月期</h3>
          <div class="report-date">決算短信（2020年5月12日）</div>
          <ul class="report-list">
            <li class="report-item">
              <span class="report-title">決算短信（2020年5月12日）</span>
            </li>
            <li class="report-item">
              <span class="report-title">決算説明（PDF・1,285KB・全3ページ）</span>
            </li>
            <li class="report-item">
              <span class="report-title">決算説明資料【第2期（決算説明）資料】（PDF・334KB・全2ページ）</span>
            </li>
            <li class="report-item">
              <span class="report-title">決算報告書【第1期（決算メンバー）】スピーチ（PDF・626KB・全1ページ）</span>
            </li>
            <li class="report-item">
              <span class="report-title">メディアの売上実績配信の利益を見いただいたより上げす</span>
            </li>
          </ul>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="action-buttons">
        <button class="action-btn contact-btn" @click="goToContact">お問い合わせはコチラ</button>
        <button class="action-btn member-btn" @click="goToMember">入会はコチラ</button>
      </div>

      <!-- Company Section -->
      <section class="company-section">
        <div class="company-overlay">
          <div class="company-content">
            <h2>株式会社ちくぎん地域経済研究所</h2>
            <p class="company-subtitle">About us</p>
            <p class="company-description">様々な分野の調査研究を通じ、企業活動などをサポートします。</p>
            <button class="company-btn" @click="goToContact">お問い合わせはコチラ</button>
          </div>
        </div>
      </section>

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
  name: "FinancialReportPage",
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

/* Reports Container */
.reports-container {
  margin-bottom: 60px;
}

.report-section {
  background: white;
  border-radius: 15px;
  padding: 30px;
  margin-bottom: 30px;
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.report-year {
  font-size: 1.3rem;
  color: #333;
  font-weight: bold;
  margin-bottom: 15px;
}

.report-date {
  color: #666;
  font-size: 0.95rem;
  margin-bottom: 20px;
}

.report-list {
  list-style: none;
}

.report-item {
  padding: 12px 0;
  border-bottom: 1px solid #f0f0f0;
  position: relative;
  padding-left: 20px;
}

.report-item:before {
  content: '•';
  position: absolute;
  left: 0;
  color: #da5761;
  font-size: 1.2rem;
  font-weight: bold;
}

.report-item:last-child {
  border-bottom: none;
}

.report-title {
  color: #666;
  font-size: 0.95rem;
  line-height: 1.6;
  cursor: pointer;
  transition: color 0.3s;
}

.report-title:hover {
  color: #da5761;
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

/* Company Section */
.company-section {
  background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), 
              url('/img/hero-image.png') center/cover;
  color: white;
  text-align: center;
  padding: 80px 20px;
  margin-bottom: 60px;
  border-radius: 20px;
}

.company-content h2 {
  font-size: 1.8rem;
  margin-bottom: 10px;
  font-weight: bold;
}

.company-subtitle {
  font-size: 1rem;
  letter-spacing: 2px;
  color: #da5761;
  margin-bottom: 20px;
}

.company-description {
  font-size: 1.1rem;
  margin-bottom: 30px;
  line-height: 1.6;
}

.company-btn {
  background: #da5761;
  color: white;
  border: none;
  padding: 15px 40px;
  font-size: 1rem;
  border-radius: 50px;
  cursor: pointer;
  transition: all 0.3s;
  font-weight: bold;
}

.company-btn:hover {
  background: #c44853;
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(218, 87, 97, 0.3);
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
  
  .report-section {
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
  
  .access-content {
    flex-direction: column;
  }
  
  .company-section {
    padding: 50px 20px;
  }
}

@media (max-width: 480px) {
  .report-title {
    font-size: 0.85rem;
  }
  
  .access-item p {
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
