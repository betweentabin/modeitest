<template>
  <div class="page-container">
    <Navigation />
    
    <!-- Hero Section -->
    <div class="hero-section">
      <div class="hero-overlay">
        <div class="hero-content">
          <h1 class="hero-title">会社概要</h1>
          <p class="hero-subtitle">ABOUT US</p>
        </div>
      </div>
    </div>

    <!-- Our Mission Section -->
    <section class="section mission-section">
      <div class="container">
        <div class="section-header">
          <h2 class="section-title">経営理念</h2>
          <p class="section-subtitle">OUR MISSION</p>
        </div>
        
        <div class="mission-content">
          <div class="mission-image">
            <img src="/img/image-1.png" alt="ネットワークイメージ" />
          </div>
          <div class="mission-text">
            <h3>産学官金のネットワークを活かした地域創生</h3>
            <p>
              私たちは、産・官・学・金（金融機関）のネットワークを活用し、
              地域経済の持続的な発展と地域企業の成長を支援することを使命としています。
              1991年の設立以来、福岡県久留米市を拠点に、九州地域の経済発展に貢献してまいりました。
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- Message Section -->
    <section class="section message-section">
      <div class="container">
        <div class="section-header">
          <h2 class="section-title">ご挨拶</h2>
          <p class="section-subtitle">MESSAGE</p>
        </div>
        
        <div class="message-content">
          <div class="message-text">
            <p>
              変化の激しい経済環境の中で、企業が持続的な成長を遂げるためには、
              正確な情報と深い洞察に基づく戦略的な意思決定が不可欠です。
            </p>
            <p>
              私たちちくぎん地域経済研究所は、長年培ってきた調査研究の知見と
              幅広いネットワークを活用し、地域の皆様の課題解決と成長を
              全力でサポートしてまいります。
            </p>
            <p>
              産・官・学・金の連携を深め、地域経済の活性化に貢献することで、
              九州地域の明るい未来を共に創造していきたいと考えております。
            </p>
            <div class="message-signature">
              <p>株式会社ちくぎん地域経済研究所</p>
              <p>代表取締役社長</p>
            </div>
          </div>
          <div class="message-image">
            <img src="/img/image-2.png" alt="代表挨拶" />
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
      <div class="container">
        <div class="cta-content">
          <h2>株式会社ちくぎん地域経済研究所</h2>
          <p>地域の未来を共に考え、企業の成長をサポートします。</p>
          <button class="cta-button" @click="scrollToContact">お問い合わせはこちら</button>
        </div>
      </div>
    </section>

    <!-- Company Info Section -->
    <section class="section company-section">
      <div class="container">
        <div class="section-header">
          <h2 class="section-title">会社概要</h2>
          <p class="section-subtitle">COMPANY PROFILE</p>
        </div>
        
        <div class="company-table">
          <table>
            <tr>
              <th>会社名</th>
              <td>株式会社ちくぎん地域経済研究所</td>
            </tr>
            <tr>
              <th>設立</th>
              <td>平成3年4月1日（1991年）</td>
            </tr>
            <tr>
              <th>資本金</th>
              <td>30,000千円</td>
            </tr>
            <tr>
              <th>所在地</th>
              <td>〒839-0864 福岡県久留米市百年公園1番1号 久留米リサーチセンタービル6階</td>
            </tr>
            <tr>
              <th>電話番号</th>
              <td>TEL：0942-46-5081</td>
            </tr>
            <tr>
              <th>営業時間</th>
              <td>平日 9:00～17:00</td>
            </tr>
          </table>
        </div>
      </div>
    </section>

    <!-- History Section -->
    <section class="section history-section">
      <div class="container">
        <div class="section-header">
          <h2 class="section-title">沿革</h2>
          <p class="section-subtitle">HISTORY</p>
        </div>
        
        <div class="history-timeline">
          <div class="timeline-item">
            <div class="timeline-year">1988</div>
            <div class="timeline-content">
              <h4>調査研究開始</h4>
              <p>筑邦銀行にて地域経済に関する調査研究を開始</p>
            </div>
          </div>
          <div class="timeline-item">
            <div class="timeline-year">2010</div>
            <div class="timeline-content">
              <h4>経営戦略支援</h4>
              <p>企業への経営戦略支援、事業承継サポート、M&Aアドバイザリーを本格化</p>
            </div>
          </div>
          <div class="timeline-item">
            <div class="timeline-year">2011</div>
            <div class="timeline-content">
              <h4>コンサルティング事業拡大</h4>
              <p>福岡県、佐賀県、長崎県、大分県、熊本県、宮崎県、鹿児島県での調査・研究、コンサルティング事業を展開。</p>
              <p>地域密着型の総合的なサービス提供を開始。</p>
            </div>
          </div>
        </div>
        
        <div class="history-more">
          <button class="more-button">続きを見る</button>
        </div>
      </div>
    </section>

    <!-- Staff Section -->
    <section class="section staff-section">
      <div class="container">
        <div class="section-header">
          <h2 class="section-title">所属紹介</h2>
          <p class="section-subtitle">OUR TEAM</p>
        </div>
        
        <div class="staff-grid">
          <div class="staff-card">
            <div class="staff-image">
              <img src="/img/image.png" alt="スタッフ1" />
            </div>
            <div class="staff-info">
              <h4>代表取締役社長</h4>
              <p>田中 太郎</p>
            </div>
          </div>
          <div class="staff-card">
            <div class="staff-image">
              <img src="/img/image-1.png" alt="スタッフ2" />
            </div>
            <div class="staff-info">
              <h4>常務取締役</h4>
              <p>佐藤 花子</p>
            </div>
          </div>
          <div class="staff-card">
            <div class="staff-image">
              <img src="/img/image-2.png" alt="スタッフ3" />
            </div>
            <div class="staff-info">
              <h4>研究部長</h4>
              <p>山田 次郎</p>
            </div>
          </div>
          <div class="staff-card">
            <div class="staff-image">
              <img src="/img/image.png" alt="スタッフ4" />
            </div>
            <div class="staff-info">
              <h4>コンサルティング部長</h4>
              <p>鈴木 美咲</p>
            </div>
          </div>
          <div class="staff-card">
            <div class="staff-image">
              <img src="/img/image-1.png" alt="スタッフ5" />
            </div>
            <div class="staff-info">
              <h4>シニアアナリスト</h4>
              <p>高橋 一郎</p>
            </div>
          </div>
        </div>
        
        <div class="staff-more">
          <button class="more-button">続きを見る</button>
        </div>
      </div>
    </section>

    <!-- Access Section -->
    <section class="section access-section">
      <div class="container">
        <div class="section-header">
          <h2 class="section-title">アクセス</h2>
          <p class="section-subtitle">ACCESS</p>
        </div>
        
        <div class="access-content">
          <div class="access-map">
            <img src="/img/rectangle-3.png" alt="アクセスマップ" />
          </div>
          <div class="access-info">
            <div class="access-details">
              <h4>所在地</h4>
              <p>〒839-0864<br />
                福岡県久留米市百年公園1番1号<br />
                久留米リサーチセンタービル6階</p>
              
              <h4>電車でお越しの場合</h4>
              <ul>
                <li>宮の陣：約1.2km 徒歩で約14分 <a href="#">乗換案内</a> | <a href="#">徒歩ルート</a></li>
                <li>櫛原：約1.2km 徒歩で約14分 <a href="#">乗換案内</a> | <a href="#">徒歩ルート</a></li>
                <li>五郎丸：約1.9km 徒歩で約23分 <a href="#">乗換案内</a> | <a href="#">徒歩ルート</a></li>
              </ul>
              
              <h4>お車でお越しの場合</h4>
              <ul>
                <li>【予約制】軒先パーキング 合川スタンド跡駐車場 | 約497m 徒歩で約6分</li>
                <li>タイムズ合川町混 | 約811m 徒歩で約10分</li>
                <li>Dパーキング諏訪野町第1 | 約830m 徒歩で約10分</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer Navigation -->
    <div class="navigation-footer">
      <Footer v-bind="frame132131753022Props" />
      <div class="vector-7-1"></div>
      <Group27 />
    </div>

    <!-- Fixed Action Buttons -->
    <FixedActionButtons />
  </div>
</template>

<script>
import Navigation from "./Navigation.vue";
import Footer from "./Footer.vue";
import Group27 from "./Group27.vue";
import FixedActionButtons from "./FixedActionButtons.vue";
import { frame132131753022Data } from "../data.js";
import axios from 'axios';
import { getApiUrl } from '@/config/api';

export default {
  name: "AboutPage",
  components: {
    Navigation,
    Footer,
    Group27,
    FixedActionButtons
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
      const response = await axios.get(getApiUrl('/api/pages/about'));
      this.pageData = response.data;
      this.loading = false;
    } catch (err) {
      console.error('Failed to fetch page data:', err);
      this.error = 'ページデータの取得に失敗しました';
      this.loading = false;
    }
  },
  data() {
    return {
      frame132131753022Props: frame132131753022Data,
    };
  },
  methods: {
    scrollToContact() {
      // お問い合わせページに遷移
      this.$router.push('/contact');
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
  height: 400px;
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
  font-size: 3rem;
  font-weight: bold;
  margin-bottom: 10px;
}

.hero-subtitle {
  font-size: 1.2rem;
  letter-spacing: 2px;
  color: #da5761;
}

/* Section Common Styles */
.section {
  padding: 80px 0;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 20px;
}

.section-header {
  text-align: center;
  margin-bottom: 60px;
}

.section-title {
  font-size: 2.5rem;
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

/* Mission Section */
.mission-section {
  background-color: #f8f9fa;
}

.mission-content {
  display: flex;
  align-items: center;
  gap: 60px;
}

.mission-image {
  flex: 0 0 45%;
}

.mission-image img {
  width: 100%;
  height: auto;
  border-radius: 10px;
}

.mission-text {
  flex: 1;
}

.mission-text h3 {
  font-size: 1.8rem;
  color: #da5761;
  margin-bottom: 20px;
  font-weight: bold;
}

.mission-text p {
  color: #666;
  line-height: 1.8;
  font-size: 1.1rem;
}

/* Message Section */
.message-section {
  background-color: #ffffff;
}

.message-content {
  display: flex;
  align-items: flex-start;
  gap: 60px;
}

.message-text {
  flex: 1;
}

.message-text p {
  color: #666;
  line-height: 1.8;
  font-size: 1.1rem;
  margin-bottom: 20px;
}

.message-signature {
  margin-top: 40px;
  text-align: right;
}

.message-signature p {
  color: #333;
  font-weight: bold;
  margin-bottom: 5px;
}

.message-image {
  flex: 0 0 45%;
}

.message-image img {
  width: 100%;
  height: auto;
  border-radius: 10px;
}

/* CTA Section */
.cta-section {
  background: linear-gradient(135deg, #da5761 0%, #c44853 100%);
  color: white;
  text-align: center;
  padding: 80px 0;
}

.cta-content h2 {
  font-size: 2rem;
  margin-bottom: 20px;
  font-weight: bold;
}

.cta-content p {
  font-size: 1.1rem;
  margin-bottom: 30px;
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

/* Company Section */
.company-section {
  background-color: #f8f9fa;
}

.company-table {
  background: white;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.company-table table {
  width: 100%;
  border-collapse: collapse;
}

.company-table th {
  background-color: #f8f9fa;
  padding: 20px;
  text-align: left;
  width: 200px;
  border-bottom: 1px solid #dee2e6;
  font-weight: bold;
  color: #333;
}

.company-table td {
  padding: 20px;
  border-bottom: 1px solid #dee2e6;
  color: #666;
}

/* History Section */
.history-section {
  background-color: #ffffff;
}

.history-timeline {
  max-width: 800px;
  margin: 0 auto;
}

.timeline-item {
  display: flex;
  margin-bottom: 40px;
  position: relative;
}

.timeline-year {
  flex: 0 0 120px;
  font-size: 1.5rem;
  font-weight: bold;
  color: #da5761;
  text-align: right;
  padding-right: 30px;
}

.timeline-content {
  flex: 1;
  padding-left: 30px;
  border-left: 3px solid #da5761;
  position: relative;
}

.timeline-content::before {
  content: '';
  position: absolute;
  left: -8px;
  top: 0;
  width: 14px;
  height: 14px;
  background-color: #da5761;
  border-radius: 50%;
}

.timeline-content h4 {
  color: #333;
  font-size: 1.2rem;
  margin-bottom: 10px;
  font-weight: bold;
}

.timeline-content p {
  color: #666;
  line-height: 1.6;
  margin-bottom: 5px;
}

.history-more {
  text-align: center;
  margin-top: 40px;
}

.more-button {
  background: #da5761;
  color: white;
  border: none;
  padding: 12px 30px;
  border-radius: 25px;
  cursor: pointer;
  font-size: 1rem;
  transition: background-color 0.3s;
}

.more-button:hover {
  background-color: #c44853;
}

/* Staff Section */
.staff-section {
  background-color: #f8f9fa;
}

.staff-grid {
  display: grid;
  grid-template-columns: repeat(5, 1fr);
  gap: 30px;
  margin-bottom: 40px;
}

.staff-card {
  text-align: center;
  background: white;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
  transition: transform 0.3s;
}

.staff-card:hover {
  transform: translateY(-5px);
}

.staff-image {
  width: 120px;
  height: 120px;
  margin: 0 auto 15px;
  overflow: hidden;
  border-radius: 50%;
}

.staff-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.staff-info h4 {
  color: #333;
  font-size: 0.9rem;
  margin-bottom: 5px;
  font-weight: bold;
}

.staff-info p {
  color: #666;
  font-size: 1rem;
}

.staff-more {
  text-align: center;
}

/* Access Section */
.access-section {
  background-color: #ffffff;
}

.access-content {
  display: flex;
  gap: 60px;
  align-items: flex-start;
}

.access-map {
  flex: 0 0 45%;
}

.access-map img {
  width: 100%;
  height: auto;
  border-radius: 10px;
}

.access-info {
  flex: 1;
}

.access-details h4 {
  color: #da5761;
  font-size: 1.2rem;
  margin-bottom: 10px;
  margin-top: 25px;
  font-weight: bold;
}

.access-details h4:first-child {
  margin-top: 0;
}

.access-details p {
  color: #666;
  line-height: 1.6;
  margin-bottom: 15px;
}

.access-details ul {
  list-style: none;
  padding: 0;
}

.access-details li {
  color: #666;
  line-height: 1.6;
  margin-bottom: 8px;
  padding-left: 10px;
}

.access-details a {
  color: #da5761;
  text-decoration: none;
}

.access-details a:hover {
  text-decoration: underline;
}

/* Responsive Design */
@media (max-width: 768px) {
  .hero-title {
    font-size: 2rem;
  }
  
  .section {
    padding: 60px 0;
  }
  
  .section-title {
    font-size: 2rem;
  }
  
  .mission-content,
  .message-content,
  .access-content {
    flex-direction: column;
    gap: 40px;
  }
  
  .mission-image,
  .message-image,
  .access-map {
    flex: none;
  }
  
  .staff-grid {
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
  }
  
  .timeline-item {
    flex-direction: column;
  }
  
  .timeline-year {
    text-align: left;
    padding-right: 0;
    padding-bottom: 10px;
  }
  
  .timeline-content {
    padding-left: 0;
    border-left: none;
    border-top: 3px solid #da5761;
    padding-top: 15px;
  }
  
  .timeline-content::before {
    left: 0;
    top: -8px;
  }
}

@media (max-width: 480px) {
  .staff-grid {
    grid-template-columns: 1fr;
  }
  
  .container {
    padding: 0 15px;
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