<template>
  <div class="page-container">
    <Navigation />
    
    <!-- Hero Section -->
    <div class="hero-section">
      <div class="hero-overlay">
        <div class="hero-content">
          <h1 class="hero-title">セミナー</h1>
          <p class="hero-subtitle">seminar</p>
        </div>
      </div>
    </div>

    <div class="page-content">
      <!-- Introduction Section -->
      <section class="intro-section">
        <p class="intro-text">
          ちくぎん地域経済研究所では地域企業の皆様にとって有益な情報を提供し、
          セミナーやイベントの開催を通じて、経営者および従業員の皆様の知識向上とスキルアップを
          支援させていただいております。
        </p>
        
        <div class="action-buttons">
          <button class="action-btn seminar-btn" @click="scrollToSeminars">開催予定のセミナー</button>
          <button class="action-btn registration-btn" @click="goToRegistration">過去のセミナー申込みはこちら</button>
        </div>
      </section>

      <!-- Current Seminars Section -->
      <section class="current-seminars" id="seminars">
        <div class="section-header">
          <h2 class="section-title">現在予約受付中のセミナー</h2>
        </div>

        <div class="seminars-list" v-if="!loading">
          <div 
            v-for="seminar in currentSeminars" 
            :key="seminar.id"
            class="seminar-card"
            @click="goToSeminarDetail(seminar.id)"
          >
            <div class="seminar-image">
              <img :src="seminar.image || '/img/image-1.png'" :alt="seminar.title" />
            </div>
            <div class="seminar-info">
              <div class="seminar-meta">
                <span class="seminar-date">{{ formatDate(seminar.date) }}</span>
                <span class="seminar-status current">申込受付中</span>
                <span class="seminar-fee">{{ seminar.fee }}</span>
              </div>
              <h3 class="seminar-title">{{ seminar.title }}</h3>
              <p class="seminar-description">{{ seminar.description }}</p>
              <button class="seminar-detail-btn">セミナー詳細を見る</button>
            </div>
          </div>
        </div>

        <div v-if="loading" class="loading">
          読み込み中...
        </div>

        <div class="load-more">
          <button class="load-more-btn">もっと見る</button>
        </div>
      </section>

      <!-- Past Seminars Section -->
      <section class="past-seminars">
        <div class="section-header">
          <h2 class="section-title">過去のセミナー</h2>
        </div>

        <div class="past-seminars-list">
          <div 
            v-for="seminar in pastSeminars" 
            :key="seminar.id"
            class="past-seminar-item"
          >
            <div class="past-seminar-meta">
              <span class="past-seminar-date">{{ formatDate(seminar.date) }}</span>
              <span class="past-seminar-status">終了</span>
            </div>
            <div class="past-seminar-content">
              <h4 class="past-seminar-title">{{ seminar.title }}</h4>
              <p class="past-seminar-description">{{ seminar.description }}</p>
            </div>
          </div>
        </div>

        <div class="load-more">
          <button class="load-more-btn">もっと見る</button>
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
import apiClient from '../services/apiClient.js';

export default {
  name: "SeminarPage",
  components: {
    Navigation,
    Footer,
    Group27,
    FixedActionButtons
  },
  data() {
    return {
      frame132131753022Props: frame132131753022Data,
      loading: true,
      currentSeminars: [],
      pastSeminars: [],
      error: null
    }
  },
  async mounted() {
    await this.loadSeminars();
  },
  methods: {
    async loadSeminars() {
      try {
        this.loading = true;
        const response = await apiClient.getSeminars();
        
        if (response.success && response.data && response.data.seminars) {
          const allSeminars = response.data.seminars;
          const currentDate = new Date();
          
          // セミナーを現在と過去に分類
          this.currentSeminars = allSeminars.filter(seminar => {
            const seminarDate = new Date(seminar.date);
            return seminarDate >= currentDate && seminar.status === 'scheduled';
          }).map(seminar => this.formatSeminarData(seminar));
          
          this.pastSeminars = allSeminars.filter(seminar => {
            const seminarDate = new Date(seminar.date);
            return seminarDate < currentDate || seminar.status === 'completed';
          }).map(seminar => this.formatSeminarData(seminar));
        }
      } catch (error) {
        console.error('セミナーデータの読み込みに失敗しました:', error);
        this.error = 'セミナーデータの読み込みに失敗しました。';
        // フォールバック: 元のハードコードされたデータを使用
        this.loadFallbackData();
      } finally {
        this.loading = false;
      }
    },
    
    formatSeminarData(seminar) {
      return {
        id: seminar.id,
        title: seminar.title,
        description: seminar.description,
        date: seminar.date,
        fee: this.formatFee(seminar.fee, seminar.membership_requirement),
        status: seminar.status === 'scheduled' ? 'current' : 'past',
        image: seminar.featured_image || '/img/image-1.png',
        start_time: seminar.start_time,
        end_time: seminar.end_time,
        location: seminar.location,
        capacity: seminar.capacity,
        current_participants: seminar.current_participants
      };
    },
    
    formatFee(fee, membershipRequirement) {
      if (fee === '0.00' || fee === 0) {
        return membershipRequirement === 'none' ? '無料' : '会員無料';
      }
      return `¥${parseFloat(fee).toLocaleString()}`;
    },
    
    loadFallbackData() {
      this.currentSeminars = [
        {
          id: 1,
          title: '採用力強化！経営・人事向け　面接官トレーニングセミナー',
          description: '久留米リサーチ・パーク（国立研究機関都市開発）１ー１　２F　特別会議室',
          date: '2025-06-15',
          fee: '会員無料',
          status: 'current',
          image: '/img/image-1.png'
        },
        {
          id: 2,
          title: 'バーソル・ビジネス・プロセス・アドバイシング（株）コンサルティング部門経営部 山根人一朗',
          description: '時期',
          date: '2025-06-20',
          fee: '会員無料',
          status: 'current',
          image: '/img/image-1.png'
        },
        {
          id: 3,
          title: 'バーソル・ビジネス・プロセス・アドバイシング（株）コンサルティング部門経営部',
          description: 'バーソル・ビジネス・プロセス・アドバイシング（株）では、人材紹介事業をはじめ、多様な中途採用領域にご経験・実績がございます。今回は、人材紹介業界の現状と転職者、求職者の特徴をお伝えし、今回は人材業界のトレンドを踏まえ、現在の転職業界の実情をプロジェクト視点で、中小企業の採用コンサルティングをはじめとして、皆様の採用を支援してまいります。',
          date: '2025-06-25',
          fee: '会員無料',
          status: 'current',
          image: '/img/image-1.png'
        },
        {
          id: 4,
          title: '個別',
          description: '個別トレーニングセミナー',
          date: '2025-07-01',
          fee: '会員無料',
          status: 'current',
          image: '/img/image-1.png'
        },
        {
          id: 5,
          title: '時期',
          description: '事務員強化改善　体系立てるようにする',
          date: '2025-07-05',
          fee: '会員無料',
          status: 'current',
          image: '/img/image-1.png'
        }
      ];
    },
    
    formatDate(dateString) {
      const date = new Date(dateString);
      const year = date.getFullYear();
      const month = String(date.getMonth() + 1).padStart(2, '0');
      const day = String(date.getDate()).padStart(2, '0');
      return `${year}.${month}.${day}`;
    },
    
    goToSeminarDetail(seminarId) {
      this.$router.push(`/seminars/${seminarId}`);
    },
    
    scrollToSeminars() {
      const element = document.getElementById('seminars');
      if (element) {
        element.scrollIntoView({ behavior: 'smooth' });
      }
    },
    
    goToRegistration() {
      this.$router.push('/seminar-registration');
    },
    
    scrollToContact() {
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

/* Introduction Section */
.intro-section {
  text-align: center;
  margin-bottom: 60px;
  padding: 40px;
  background-color: #f8f9fa;
  border-radius: 10px;
}

.intro-text {
  font-size: 1rem;
  color: #666;
  line-height: 1.8;
  margin-bottom: 30px;
  max-width: 800px;
  margin-left: auto;
  margin-right: auto;
}

.action-buttons {
  display: flex;
  gap: 20px;
  justify-content: center;
  flex-wrap: wrap;
}

.action-btn {
  border: none;
  padding: 12px 30px;
  border-radius: 25px;
  cursor: pointer;
  font-size: 0.9rem;
  font-weight: 500;
  transition: all 0.3s;
  min-width: 200px;
}

.seminar-btn {
  background: #333;
  color: white;
}

.seminar-btn:hover {
  background: #555;
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.registration-btn {
  background: #da5761;
  color: white;
}

.registration-btn:hover {
  background: #c44853;
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(218, 87, 97, 0.3);
}

/* Section Headers */
.section-header {
  text-align: center;
  margin-bottom: 40px;
}

.section-title {
  font-size: 1.8rem;
  color: #333;
  font-weight: bold;
  position: relative;
  padding-bottom: 15px;
}

.section-title::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 50%;
  transform: translateX(-50%);
  width: 60px;
  height: 2px;
  background-color: #da5761;
}

/* Current Seminars */
.current-seminars {
  margin-bottom: 60px;
}

.seminars-list {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.seminar-card {
  display: flex;
  background: white;
  border-radius: 15px;
  overflow: hidden;
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
  transition: all 0.3s;
  cursor: pointer;
}

.seminar-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

.seminar-image {
  flex: 0 0 200px;
  height: 150px;
}

.seminar-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.seminar-info {
  flex: 1;
  padding: 20px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.seminar-meta {
  display: flex;
  gap: 15px;
  margin-bottom: 15px;
  flex-wrap: wrap;
}

.seminar-date {
  background: #28a745;
  color: white;
  padding: 4px 12px;
  border-radius: 15px;
  font-size: 0.8rem;
  font-weight: 500;
}

.seminar-status.current {
  background: #da5761;
  color: white;
  padding: 4px 12px;
  border-radius: 15px;
  font-size: 0.8rem;
  font-weight: 500;
}

.seminar-fee {
  background: #007bff;
  color: white;
  padding: 4px 12px;
  border-radius: 15px;
  font-size: 0.8rem;
  font-weight: 500;
}

.seminar-title {
  font-size: 1.1rem;
  color: #333;
  margin-bottom: 10px;
  font-weight: 600;
  line-height: 1.4;
}

.seminar-description {
  font-size: 0.9rem;
  color: #666;
  line-height: 1.5;
  margin-bottom: 15px;
  flex-grow: 1;
}

.seminar-detail-btn {
  background: #da5761;
  color: white;
  border: none;
  padding: 8px 20px;
  border-radius: 20px;
  cursor: pointer;
  font-size: 0.9rem;
  align-self: flex-start;
  transition: all 0.3s;
  font-weight: 500;
}

.seminar-detail-btn:hover {
  background: #c44853;
}

.loading {
  text-align: center;
  padding: 40px;
  color: #666;
}

/* Load More */
.load-more {
  text-align: center;
  margin-top: 30px;
}

.load-more-btn {
  background: #333;
  color: white;
  border: none;
  padding: 12px 30px;
  border-radius: 25px;
  cursor: pointer;
  font-size: 0.9rem;
  transition: all 0.3s;
  font-weight: 500;
}

.load-more-btn:hover {
  background: #555;
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

/* Past Seminars */
.past-seminars {
  margin-bottom: 60px;
}

.past-seminars-list {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.past-seminar-item {
  background: white;
  border: 1px solid #dee2e6;
  border-radius: 10px;
  padding: 20px;
  transition: all 0.3s;
}

.past-seminar-item:hover {
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.past-seminar-meta {
  display: flex;
  gap: 15px;
  margin-bottom: 10px;
  align-items: center;
}

.past-seminar-date {
  color: #666;
  font-size: 0.9rem;
  font-weight: 500;
}

.past-seminar-status {
  background: #6c757d;
  color: white;
  padding: 3px 10px;
  border-radius: 12px;
  font-size: 0.75rem;
  font-weight: 500;
}

.past-seminar-title {
  font-size: 1rem;
  color: #333;
  margin-bottom: 8px;
  font-weight: 500;
}

.past-seminar-description {
  font-size: 0.9rem;
  color: #666;
  line-height: 1.5;
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
  
  .seminar-card {
    flex-direction: column;
  }
  
  .seminar-image {
    flex: none;
    height: 200px;
  }
  
  .action-buttons {
    flex-direction: column;
    align-items: center;
  }
  
  .action-btn {
    width: 100%;
    max-width: 300px;
  }
  
  .intro-section {
    padding: 20px;
  }
}

@media (max-width: 480px) {
  .seminar-meta {
    flex-direction: column;
    gap: 8px;
  }
  
  .seminar-title {
    font-size: 1rem;
  }
  
  .seminar-description {
    font-size: 0.85rem;
  }
  
  .past-seminar-meta {
    flex-direction: column;
    align-items: flex-start;
    gap: 8px;
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