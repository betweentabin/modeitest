<template>
  <div class="page-container">
    <Navigation />
    
    <!-- Hero Section -->
    <div class="hero-section">
      <div class="hero-overlay">
        <div class="hero-content">
          <h1 class="hero-title">CRI経営コンサルティング</h1>
          <p class="hero-subtitle">consulting</p>
        </div>
      </div>
    </div>

    <div class="page-content">
      <!-- What's CRI Section -->
      <section class="whats-cri-section">
        <div class="cri-content">
          <div class="cri-image">
            <img src="/img/image-1.png" alt="CRI経営コンサルティング" />
          </div>
          <div class="cri-info">
            <h2 class="cri-title">CRI経営コンサルティングとは？</h2>
            <div class="whats-cri">
              <h3>What's CRI<br><span class="sub-title">Management Consulting</span></h3>
              <p>
                CRI経営コンサルティングでは、経営革新により企業体質改革～
                レ・アドバイス、サポートをトータルにサポート！
              </p>
              <p>
                経営者様や、お客様のビジネス推進の内容に応じて高度で適正なコンサルティングを実施しており、
                多様なニーズ・幅広いワーニングをご利用いただけるよう、専門チームが継続的に研鑽を積んでおり、
                アドバイザリーサービスをご提供しております。
              </p>
            </div>
          </div>
        </div>
      </section>

      <!-- Main Duties Section -->
      <section class="main-duties-section">
        <div class="duties-header">
          <h2 class="section-title">CRI経営コンサルティングの主な業務</h2>
        </div>
        
        <div class="duties-content">
          <div class="duties-text">
            <h3 class="duties-title">MAIN DUTIES</h3>
            <p class="duties-description">
              幅広いエリアから企業体質を総合的に一括にサポート
            </p>
            <ul class="duties-list">
              <li>・事業企画・事業戦略立案</li>
              <li>・企業活性化・組織改革</li>
              <li>・マーケティング戦略</li>
              <li>・人事制度設計・人材開発</li>
              <li>・財務・資金調達</li>
              <li>・営業力強化</li>
              <li>・新規事業開発</li>
              <li>・経営診断・企業再生</li>
            </ul>
          </div>
          <div class="duties-image">
            <img src="/img/image-2.png" alt="経営コンサルティング業務" />
          </div>
        </div>
      </section>

      <!-- Company CTA Section -->
      <section class="company-cta">
        <div class="cta-content">
          <h2>株式会社ちくぎん地域経済研究所</h2>
          <p>様々な分野の調査研究を通じ、企業活動などをサポートします。</p>
          <button class="cta-button" @click="goToContact">お問い合わせはこちら</button>
        </div>
      </section>

      <!-- Support Content Section -->
      <section class="support-section">
        <div class="support-header">
          <h2 class="section-title">サポート内容を費用に応じて</h2>
          <p class="section-subtitle">support</p>
          <p class="support-description">
            ～研修会、コンサルティング（企業研修・人事）等お客様にサービスのご利用をいただけるよう努めております。～
          </p>
        </div>

        <!-- Free Services -->
        <div class="service-category">
          <h3 class="category-title">無料 - FREE -</h3>
          <div class="service-grid">
            <div class="service-card">
              <div class="service-image">
                <img src="/img/image-1.png" alt="無料サービス1" />
              </div>
              <div class="service-info">
                <h4>企業診断</h4>
                <p>企業・経営に関する課題</p>
              </div>
            </div>
            <div class="service-card">
              <div class="service-image">
                <img src="/img/image-2.png" alt="無料サービス2" />
              </div>
              <div class="service-info">
                <h4>事業承継</h4>
                <p>M&A・事業戦略</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Paid Services -->
        <div class="service-category">
          <h3 class="category-title">有料 - PAID -</h3>
          <div class="service-grid">
            <div class="service-card">
              <div class="service-image">
                <img src="/img/image-1.png" alt="有料サービス1" />
              </div>
              <div class="service-info">
                <h4>企業経営改善</h4>
              </div>
            </div>
            <div class="service-card">
              <div class="service-image">
                <img src="/img/image-2.png" alt="有料サービス2" />
              </div>
              <div class="service-info">
                <h4>企業経営戦略</h4>
              </div>
            </div>
            <div class="service-card">
              <div class="service-image">
                <img src="/img/image.png" alt="有料サービス3" />
              </div>
              <div class="service-info">
                <h4>経営戦略の構築</h4>
              </div>
            </div>
            <div class="service-card">
              <div class="service-image">
                <img src="/img/image-1.png" alt="有料サービス4" />
              </div>
              <div class="service-info">
                <h4>経営・財務戦略</h4>
              </div>
            </div>
          </div>
        </div>

        <div class="service-note">
          <p>
            ※研修取得、無料・有料の総合的な実現には、総合企業様にスティ（以下、「当社」という）主要料金体系となります。<br>
            ※バイ企業経営戦略等、有効活用による総合のため、サービス承諾・長期利用等の価格等につきまして、<br>
            総合分析（「キュータ」含む）。
          </p>
          <button class="service-contact-btn" @click="goToContact">お問い合わせはこちら</button>
        </div>
      </section>

      <!-- Consulting Cases Section -->
      <section class="cases-section">
        <div class="cases-header">
          <h2 class="section-title">CRI経営コンサルティングの実績紹介</h2>
          <p class="section-subtitle">achievements</p>
        </div>

        <div class="cases-grid">
          <div class="case-card">
            <div class="case-image">
              <img src="/img/image-1.png" alt="実績1" />
            </div>
            <div class="case-info">
              <h4>企業・地域活性化業</h4>
              <p>
                経営戦略および改革にかかる問題認識、現場確認（マーケット・リサーチ等）からステップアップ等まで、
                まさに企業の成長にかかる経営・コンサルティングを実施いたします。
              </p>
            </div>
          </div>
          
          <div class="case-card">
            <div class="case-image">
              <img src="/img/image-2.png" alt="実績2" />
            </div>
            <div class="case-info">
              <h4>企業・地域活性化事業</h4>
              <p>
                地域に密着した企業様に対する経営コンサルティングを担当しており、
                業界の営業支援メニューから地域限定含み・設定から幅広い戦略経営等をアドバイスいたします。
              </p>
            </div>
          </div>
          
          <div class="case-card">
            <div class="case-image">
              <img src="/img/image.png" alt="実績3" />
            </div>
            <div class="case-info">
              <h4>M&A・企業の成長戦略</h4>
              <p>
                中小企業のM&A等について、戦略立案から実行まで幅広くサポートしており、
                企業価値の向上とM&A進行プランの策定など、実績豊富なアドバイザーチームにより実施いたします。
              </p>
            </div>
          </div>
          
          <div class="case-card">
            <div class="case-image">
              <img src="/img/image-1.png" alt="実績4" />
            </div>
            <div class="case-info">
              <h4>企業・地域活性化事業</h4>
              <p>
                地域密着型に企業様にご利用いただき、かつ地域の活性化をサポートする取り組みを進めております。
                成長戦略・地域経済等への活用にも積極的に取り組んでいます。
              </p>
            </div>
          </div>
        </div>

        <div class="cases-note">
          <p>
            ちくぎん地域経済研究所は総合的な経営戦略立案・地域活性化等を経営コンサルティングとして展開をしております。
          </p>
        </div>
      </section>

      <!-- Action Buttons -->
      <div class="action-buttons">
        <button class="action-btn contact-btn" @click="goToContact">お問い合わせはコチラ</button>
        <button class="action-btn member-btn" @click="goToMember">入会はコチラ</button>
      </div>
    </div>

    <FooterComplete />
  </div>
</template>

<script>
import Navigation from "./Navigation.vue";
import FooterComplete from "./FooterComplete.vue";

export default {
  name: "CRIConsultingPage",
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
  max-width: 1200px;
  margin: 0 auto;
  padding: 60px 20px;
}

/* What's CRI Section */
.whats-cri-section {
  margin-bottom: 80px;
}

.cri-content {
  display: flex;
  gap: 40px;
  align-items: center;
  background: white;
  border-radius: 20px;
  padding: 40px;
  box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

.cri-image {
  flex: 0 0 300px;
}

.cri-image img {
  width: 100%;
  height: 200px;
  object-fit: cover;
  border-radius: 15px;
}

.cri-info {
  flex: 1;
}

.cri-title {
  font-size: 1.8rem;
  color: #333;
  margin-bottom: 20px;
  font-weight: bold;
}

.whats-cri h3 {
  color: #da5761;
  font-size: 1.5rem;
  font-weight: bold;
  margin-bottom: 15px;
}

.sub-title {
  display: block;
  font-size: 1rem;
  color: #da5761;
  font-weight: 400;
}

.whats-cri p {
  color: #666;
  line-height: 1.7;
  margin-bottom: 15px;
}

/* Main Duties Section */
.main-duties-section {
  margin-bottom: 80px;
}

.duties-header {
  text-align: center;
  margin-bottom: 50px;
}

.section-title {
  font-size: 2rem;
  color: #333;
  font-weight: bold;
  margin-bottom: 30px;
}

.duties-content {
  display: flex;
  gap: 40px;
  align-items: center;
  background: white;
  border-radius: 20px;
  padding: 40px;
  box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

.duties-text {
  flex: 1;
}

.duties-title {
  color: #da5761;
  font-size: 2rem;
  font-weight: bold;
  margin-bottom: 15px;
}

.duties-description {
  color: #333;
  font-size: 1.1rem;
  margin-bottom: 25px;
  font-weight: 600;
}

.duties-list {
  list-style: none;
  color: #666;
}

.duties-list li {
  margin-bottom: 8px;
  line-height: 1.6;
}

.duties-image {
  flex: 0 0 300px;
}

.duties-image img {
  width: 100%;
  height: 200px;
  object-fit: cover;
  border-radius: 15px;
}

/* Company CTA */
.company-cta {
  background: linear-gradient(135deg, #da5761 0%, #c44853 100%);
  color: white;
  text-align: center;
  padding: 60px 40px;
  border-radius: 20px;
  margin-bottom: 80px;
}

.cta-content h2 {
  font-size: 1.8rem;
  margin-bottom: 15px;
  font-weight: bold;
}

.cta-content p {
  font-size: 1.1rem;
  margin-bottom: 25px;
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

/* Support Section */
.support-section {
  margin-bottom: 80px;
}

.support-header {
  text-align: center;
  margin-bottom: 50px;
}

.section-subtitle {
  color: #da5761;
  font-size: 1rem;
  letter-spacing: 2px;
  margin-bottom: 20px;
}

.support-description {
  color: #666;
  font-size: 1rem;
  line-height: 1.6;
}

.service-category {
  margin-bottom: 50px;
}

.category-title {
  font-size: 1.5rem;
  color: #333;
  text-align: center;
  margin-bottom: 30px;
  font-weight: bold;
}

.service-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 25px;
  margin-bottom: 30px;
}

.service-card {
  background: white;
  border-radius: 15px;
  overflow: hidden;
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
  transition: transform 0.3s;
}

.service-card:hover {
  transform: translateY(-5px);
}

.service-image {
  height: 150px;
}

.service-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.service-info {
  padding: 20px;
  text-align: center;
}

.service-info h4 {
  color: #333;
  font-size: 1.1rem;
  margin-bottom: 10px;
  font-weight: 600;
}

.service-info p {
  color: #666;
  font-size: 0.9rem;
  line-height: 1.5;
}

.service-note {
  background: #f8f9fa;
  padding: 30px;
  border-radius: 15px;
  text-align: center;
}

.service-note p {
  color: #666;
  line-height: 1.6;
  margin-bottom: 20px;
}

.service-contact-btn {
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

.service-contact-btn:hover {
  background: #c44853;
}

/* Cases Section */
.cases-section {
  margin-bottom: 60px;
}

.cases-header {
  text-align: center;
  margin-bottom: 50px;
}

.cases-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 30px;
  margin-bottom: 40px;
}

.case-card {
  background: white;
  border-radius: 15px;
  overflow: hidden;
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.case-image {
  height: 180px;
}

.case-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.case-info {
  padding: 25px;
}

.case-info h4 {
  color: #333;
  font-size: 1.2rem;
  margin-bottom: 15px;
  font-weight: 600;
}

.case-info p {
  color: #666;
  line-height: 1.6;
  font-size: 0.95rem;
}

.cases-note {
  text-align: center;
  padding: 20px;
}

.cases-note p {
  color: #666;
  line-height: 1.6;
}

/* Action Buttons */
.action-buttons {
  display: flex;
  gap: 20px;
  justify-content: center;
  margin-bottom: 40px;
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

/* Responsive Design */
@media (max-width: 768px) {
  .hero-title {
    font-size: 2rem;
  }
  
  .page-content {
    padding: 40px 15px;
  }
  
  .cri-content,
  .duties-content {
    flex-direction: column;
    text-align: center;
  }
  
  .cri-image,
  .duties-image {
    flex: none;
    max-width: 100%;
  }
  
  .service-grid,
  .cases-grid {
    grid-template-columns: 1fr;
  }
  
  .action-buttons {
    flex-direction: column;
    align-items: center;
  }
  
  .action-btn {
    width: 100%;
    max-width: 300px;
  }
}
</style>
