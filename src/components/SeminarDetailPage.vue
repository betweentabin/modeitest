<template>
  <div class="page-container">
    <Navigation />
    
    <!-- Hero Section -->
    <div class="hero-section">
      <div class="hero-overlay">
        <div class="hero-content">
          <h1 class="hero-title">セミナー詳細</h1>
          <p class="hero-subtitle">seminar</p>
        </div>
      </div>
    </div>

    <div class="page-content" v-if="seminar">
      <!-- Seminar Header -->
      <div class="seminar-header">
        <h2 class="section-title">セミナー詳細</h2>
        <p class="section-subtitle">seminar</p>
      </div>

      <!-- Seminar Details Card -->
      <div class="seminar-detail-card">
        <div class="seminar-content">
          <div class="seminar-image">
            <img :src="seminar.image || '/img/image-1.png'" :alt="seminar.title" />
          </div>
          
          <div class="seminar-info">
            <div class="seminar-meta">
              <span class="seminar-category">セミナー詳細</span>
            </div>
            
            <h3 class="seminar-title">{{ seminar.title }}</h3>
            
            <div class="seminar-details">
              <div class="detail-row">
                <span class="detail-label">【講師】</span>
                <span class="detail-value">{{ seminar.instructor || 'ちくぎん地域経済研究所' }}</span>
              </div>
              
              <div class="detail-row">
                <span class="detail-label">【日時】</span>
                <span class="detail-value">{{ formatDetailDate(seminar.date) }}</span>
              </div>
              
              <div class="detail-row">
                <span class="detail-label">【場所】</span>
                <span class="detail-value">{{ seminar.venue || '久留米リサーチ・パーク' }}</span>
              </div>
              
              <div class="detail-row">
                <span class="detail-label">【対象】</span>
                <span class="detail-value">{{ seminar.target || '経営者・人事担当者' }}</span>
              </div>
              
              <div class="detail-row">
                <span class="detail-label">【参加費】</span>
                <span class="detail-value">{{ seminar.fee || '会員無料' }}</span>
              </div>
            </div>
            
            <div class="seminar-description">
              <h4>セミナー内容</h4>
              <p>{{ seminar.fullDescription || seminar.description }}</p>
            </div>
            
            <!-- Registration Button -->
            <div class="registration-section" v-if="seminar.status === 'current'">
              <button class="registration-btn" @click="registerSeminar">セミナーを予約する</button>
            </div>
            
            <div class="ended-section" v-else>
              <p class="ended-notice">このセミナーは終了しました</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Action Buttons -->
      <section class="action-section">
        <div class="action-buttons">
          <button class="action-btn contact-btn" @click="goToContact">お問い合わせはコチラ</button>
          <button class="action-btn member-btn" @click="goToMember">メンバー登録はコチラ</button>
        </div>
      </section>
    </div>

    <div v-else class="loading">
      読み込み中...
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
import apiClient from '../services/apiClient.js';

export default {
  name: "SeminarDetailPage",
  components: {
    Navigation,
    FooterComplete
  },
  data() {
    return {
      seminar: null,
      loading: true,
      error: null
    };
  },
  async mounted() {
    await this.loadSeminar();
  },
  methods: {
    async loadSeminar() {
      try {
        this.loading = true;
        const seminarId = this.$route.params.id;
        
        const response = await apiClient.getSeminar(seminarId);
        
        if (response.success && response.data && response.data.seminar) {
          this.seminar = this.formatSeminarData(response.data.seminar);
        } else {
          throw new Error('セミナーが見つかりませんでした');
        }
      } catch (error) {
        console.error('セミナー詳細の読み込みに失敗しました:', error);
        this.error = 'セミナー詳細の読み込みに失敗しました。';
        // フォールバック: モックデータを使用
        await this.loadFallbackData();
      } finally {
        this.loading = false;
      }
    },
    
    formatSeminarData(seminar) {
      return {
        id: seminar.id,
        title: seminar.title,
        description: seminar.description,
        fullDescription: seminar.detailed_description || seminar.description,
        date: seminar.date,
        fee: this.formatFee(seminar.fee, seminar.membership_requirement),
        status: seminar.status === 'scheduled' ? 'current' : 'past',
        instructor: seminar.instructor || 'ちくぎん地域経済研究所',
        venue: seminar.location,
        target: this.formatTarget(seminar.membership_requirement),
        image: seminar.featured_image || '/img/image-1.png',
        start_time: seminar.start_time,
        end_time: seminar.end_time,
        capacity: seminar.capacity,
        current_participants: seminar.current_participants,
        application_deadline: seminar.application_deadline,
        contact_email: seminar.contact_email,
        contact_phone: seminar.contact_phone
      };
    },
    
    formatFee(fee, membershipRequirement) {
      if (fee === '0.00' || fee === 0) {
        return membershipRequirement === 'none' ? '無料' : '会員無料';
      }
      return `¥${parseFloat(fee).toLocaleString()}`;
    },
    
    formatTarget(membershipRequirement) {
      switch(membershipRequirement) {
        case 'none': return '一般参加可能';
        case 'basic': return 'ベーシック会員以上';
        case 'standard': return 'スタンダード会員以上';
        case 'premium': return 'プレミアム会員限定';
        default: return '経営者・管理職';
      }
    },
    
    async loadFallbackData() {
      const seminarId = parseInt(this.$route.params.id);
      
      // フォールバック用のモックデータ
      const seminars = [
        {
          id: 1,
          title: '採用力強化！経営・人事向け　面接官トレーニングセミナー',
          description: '久留米リサーチ・パーク（国立研究機関都市開発）１ー１　２F　特別会議室',
          fullDescription: 'バーソル・ビジネス・プロセス・アドバイシング（株）コンサルティング部門経営部では、人材紹介事業をはじめ、多様な中途採用領域にご経験・実績がございます。今回は、人材紹介業界の現状と転職者、求職者の特徴をお伝えし、今回は人材業界のトレンドを踏まえ、現在の転職業界の実情をプロジェクト視点で、中小企業の採用コンサルティングをはじめとして、皆様の採用を支援してまいります。また今回は、人材業界のトレンドを踏まえ、現在の転職業界の実情をプロジェクト視点で説明いたします。そして、中小企業の採用コンサルティングをはじめとして、皆様の採用プロジェクトを支援いたします。',
          date: '2025-06-15',
          fee: '会員無料',
          status: 'current',
          instructor: 'バーソル・ビジネス・プロセス・アドバイシング（株）コンサルティング部門経営部　山根人一朗',
          venue: '久留米リサーチ・パーク（国立研究機関都市開発）１ー１　２F　特別会議室',
          target: '経営者・人事担当者',
          image: '/img/image-1.png'
        },
        {
          id: 2,
          title: 'バーソル・ビジネス・プロセス・アドバイシング（株）コンサルティング部門経営部 山根人一朗',
          description: '時期',
          fullDescription: 'バーソル・ビジネス・プロセス・アドバイシング（株）では、人材紹介事業をはじめとして、多様な中途採用領域において豊富な経験と実績を有しています。本セミナーでは、人材紹介業界の最新動向と転職者・求職者の特徴について詳しく解説いたします。',
          date: '2025-06-20',
          fee: '会員無料',
          status: 'current',
          instructor: '山根人一朗',
          venue: '久留米リサーチ・パーク',
          target: '経営者・人事担当者',
          image: '/img/image-1.png'
        }
      ];
      
      this.seminar = seminars.find(s => s.id == seminarId);
      this.loading = false;
    },
    formatDetailDate(dateString) {
      const date = new Date(dateString);
      const year = date.getFullYear();
      const month = String(date.getMonth() + 1).padStart(2, '0');
      const day = String(date.getDate()).padStart(2, '0');
      const weekdays = ['日', '月', '火', '水', '木', '金', '土'];
      const weekday = weekdays[date.getDay()];
      return `${year}年${month}月${day}日（${weekday}）`;
    },
    registerSeminar() {
      // セミナー予約処理
      alert('セミナーの予約を受け付けました。詳細は後日ご連絡いたします。');
    },
    goToContact() {
      this.$router.push('/contact');
    },
    goToMember() {
      this.$router.push('/register');
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
  max-width: 800px;
  margin: 0 auto;
  padding: 60px 20px;
}

.seminar-header {
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

/* Seminar Detail Card */
.seminar-detail-card {
  background: white;
  border-radius: 15px;
  overflow: hidden;
  box-shadow: 0 5px 20px rgba(0,0,0,0.1);
  margin-bottom: 40px;
}

.seminar-content {
  display: flex;
  flex-direction: column;
}

.seminar-image {
  width: 100%;
  height: 300px;
  overflow: hidden;
}

.seminar-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.seminar-info {
  padding: 40px;
}

.seminar-meta {
  margin-bottom: 20px;
}

.seminar-category {
  background: #da5761;
  color: white;
  padding: 6px 16px;
  border-radius: 20px;
  font-size: 0.9rem;
  font-weight: 500;
}

.seminar-title {
  font-size: 1.8rem;
  color: #333;
  margin-bottom: 30px;
  font-weight: bold;
  line-height: 1.4;
}

.seminar-details {
  margin-bottom: 30px;
}

.detail-row {
  display: flex;
  margin-bottom: 15px;
  align-items: flex-start;
}

.detail-label {
  flex: 0 0 100px;
  font-weight: 600;
  color: #333;
  font-size: 0.9rem;
}

.detail-value {
  flex: 1;
  color: #666;
  font-size: 0.9rem;
  line-height: 1.5;
}

.seminar-description {
  margin-bottom: 30px;
  padding: 20px;
  background-color: #f8f9fa;
  border-radius: 10px;
}

.seminar-description h4 {
  font-size: 1.1rem;
  color: #333;
  margin-bottom: 15px;
  font-weight: 600;
}

.seminar-description p {
  color: #666;
  line-height: 1.7;
  font-size: 0.95rem;
}

/* Registration Section */
.registration-section {
  text-align: center;
}

.registration-btn {
  background: #da5761;
  color: white;
  border: none;
  padding: 15px 40px;
  font-size: 1.1rem;
  border-radius: 50px;
  cursor: pointer;
  transition: all 0.3s;
  font-weight: bold;
}

.registration-btn:hover {
  background: #c44853;
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(218, 87, 97, 0.3);
}

.ended-section {
  text-align: center;
  padding: 20px;
  background-color: #f8f9fa;
  border-radius: 10px;
}

.ended-notice {
  color: #666;
  font-size: 1rem;
  font-weight: 500;
}

.loading {
  text-align: center;
  padding: 60px;
  color: #666;
  font-size: 1.1rem;
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

.member-btn {
  background: #8B0000;
  color: white;
}

.member-btn:hover {
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
  
  .seminar-info {
    padding: 20px;
  }
  
  .seminar-title {
    font-size: 1.5rem;
  }
  
  .detail-row {
    flex-direction: column;
    gap: 5px;
  }
  
  .detail-label {
    flex: none;
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

@media (max-width: 480px) {
  .seminar-image {
    height: 200px;
  }
  
  .seminar-title {
    font-size: 1.3rem;
  }
  
  .detail-label,
  .detail-value {
    font-size: 0.85rem;
  }
  
  .seminar-description p {
    font-size: 0.9rem;
  }
}
</style>
