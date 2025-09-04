<template>
  <div class="page-container">
    <Navigation />
    
    <!-- Hero Section -->
    <HeroSection 
      title="セミナー詳細"
      subtitle="seminar"
      heroImage="https://api.builder.io/api/v1/image/assets/TEMP/ab5db9916398054424d59236a434310786cb8146?width=2880"
    />

    <!-- Breadcrumbs -->
    <Breadcrumbs :breadcrumbs="['セミナー', 'セミナー詳細（予約受付中）']" />

    <!-- Seminar Detail Section -->
    <section class="seminar-detail-section" v-if="seminar">
      <div class="section-header">
        <h2 class="section-title">セミナー詳細</h2>
        <div class="section-divider">
          <div class="divider-line"></div>
          <span class="divider-text">seminar</span>
          <div class="divider-line"></div>
        </div>
      </div>

      <!-- Seminar Details Card -->
      <div class="seminar-detail-card" v-restricted="{ requiredLevel: seminar.membershipRequirement || 'free' }">
          <div class="seminar-content">
                         <div class="seminar-info">
              <div class="seminar-details">
              <div class="detail-row">
                 <span class="detail-label">セミナー名</span>
                 <span class="detail-value">{{ seminar.title || 'セミナー名' }}</span>
               </div>

               <div class="detail-row">
                 <span class="detail-label">講師</span>
                 <span class="detail-value">{{ seminar.instructor || 'ちくぎん地域経済研究所' }}</span>
               </div>
               
               <div class="detail-row">
                 <span class="detail-label">セミナー日時</span>
                 <span class="detail-value">{{ formatDetailDate(seminar.date) }}</span>
               </div>
               
               <div class="detail-row">
                 <span class="detail-label">開催場所</span>
                 <span class="detail-value">{{ seminar.venue || '久留米リサーチ・パーク' }}</span>
               </div>
               
                               <div class="detail-row">
                  <span class="detail-label">定員</span>
                  <span class="detail-value">{{ seminar.capacity || '30名' }}</span>
                </div>
               
               <div class="detail-row">
                 <span class="detail-label">参加費</span>
                 <span class="detail-value">{{ seminar.fee || '会員無料' }}</span>
               </div>
             </div>
           </div>
           
           <div class="seminar-image">
             <img :src="seminar.image || '/img/image-1.png'" :alt="seminar.title" />
             <MembershipBadge 
               v-if="seminar.membershipRequirement && seminar.membershipRequirement !== 'free'" 
               :level="seminar.membershipRequirement" 
               class="detail-badge"
             />
           </div>
         </div>

        <div class="detail-row">
          <span class="detail-label">講師紹介</span>
          <span class="detail-value">{{ seminar.fullDescription || seminar.description }}</span>
        </div>

        <div class="detail-row">
          <span class="detail-label">プログラム</span>
          <span class="detail-value">{{ seminar.fullDescription || seminar.description }}</span>
        </div>

        <!-- Registration Button -->
        <div class="registration-section" v-if="seminar.status === 'current'">
          <div 
            class="registration-btn" 
            @click="handleRegistration"
            :class="{ disabled: !canRegister }"
          >
            <div class="text-44 valign-text-middle inter-bold-white-15px">{{ registrationButtonText }}</div>
            <frame13213176122 />
          </div>
        </div>
        
        <div class="ended-section" v-else>
          <p class="ended-notice">このセミナーは終了しました</p>
        </div>

      </div>
    </section>

    <div v-else class="loading">
      読み込み中...
    </div>

<!-- Action Button Section -->
<ActionButton 
  primary-text="お問い合わせはコチラ"
  secondary-text="メンバー登録はコチラ"
  max-width="1500px"
  @primary-click="handleContactClick"
  @secondary-click="handleJoinClick"
/>

    <!-- Contact Section -->
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
import Footer from "./Footer";
import Group27 from "./Group27";
import AccessSection from "./AccessSection.vue";
import HeroSection from "./HeroSection.vue";
import Breadcrumbs from "./Breadcrumbs.vue";
import FixedSideButtons from "./FixedSideButtons.vue";
import ContactSection from "./ContactSection.vue";
import Frame13213176122 from "./Frame13213176122.vue";
import ActionButton from "./ActionButton.vue";
import { frame132131753022Data } from "../data";
import apiClient from '../services/apiClient.js';
import mockServer from '@/mockServer';
import MembershipBadge from './MembershipBadge.vue';

export default {
  name: "SeminarDetailPage",
  components: {
    Navigation,
    Footer,
    Group27,
    AccessSection,
    HeroSection,
    Breadcrumbs,
    FixedSideButtons,
    ContactSection,
    Frame13213176122,
    ActionButton,
    MembershipBadge
  },
  data() {
    return {
      frame132131753022Props: frame132131753022Data,
      seminar: null,
      loading: true,
      error: null
    };
  },
  async mounted() {
    await this.loadSeminar();
  },
  computed: {
    canRegister() {
      if (!this.seminar) return false;
      const requiredLevel = this.seminar.membershipRequirement || 'free';
      return this.$store.getters['auth/canAccess'](requiredLevel);
    },
    registrationButtonText() {
      if (!this.seminar) return 'セミナーを予約する';
      
      const requiredLevel = this.seminar.membershipRequirement || 'free';
      const canAccess = this.$store.getters['auth/canAccess'](requiredLevel);
      const isRestricted = this.$store.getters['auth/canViewButRestricted'](requiredLevel);
      
      if (canAccess) {
        return 'セミナーを予約する';
      } else if (isRestricted) {
        return `${this.getMembershipText(requiredLevel)}会員限定`;
      } else {
        return 'ログインが必要';
      }
    }
  },
  methods: {
    async loadSeminar() {
      try {
        this.loading = true;
        const seminarId = this.$route.params.id;
        
        // まずAPIから取得を試みる
        try {
          const response = await apiClient.getSeminar(seminarId);
          if (response && response.data) {
            const seminar = response.data;
            this.seminar = {
              id: seminar.id,
              title: seminar.title,
              description: seminar.description,
              fullDescription: seminar.detailed_description || seminar.description,
            date: seminar.date,
            start_time: seminar.start_time,
            end_time: seminar.end_time,
            venue: seminar.location,
            location: seminar.location,
            capacity: seminar.capacity ? `${seminar.capacity}名` : '30名',
            fee: seminar.fee === 0 || seminar.fee === '0' ? '会員無料' : `${seminar.fee}円`,
            status: seminar.status === 'scheduled' || seminar.status === 'ongoing' ? 'current' : seminar.status,
            image: seminar.featured_image || '/img/image-1.png',
            instructor: seminar.instructor || 'ちくぎん地域経済研究所',
            notes: seminar.notes,
            application_deadline: seminar.application_deadline,
            membershipRequirement: seminar.membership_requirement || 'free'
            };
            return;
          }
        } catch (apiError) {
          console.log('API failed, trying mockServer:', apiError.message);
        }
        
        // APIが失敗した場合はmockServerから取得
        const seminar = await mockServer.getSeminar(seminarId);
        this.seminar = {
          id: seminar.id,
          title: seminar.title,
          description: seminar.description,
          fullDescription: seminar.detailed_description || seminar.description,
          date: seminar.date,
          start_time: seminar.start_time,
          end_time: seminar.end_time,
          venue: seminar.location,
          capacity: seminar.capacity,
          price: seminar.price,
          organizer: seminar.organizer,
          membershipRequirement: seminar.membership_requirement,
          applicationDeadline: seminar.application_deadline,
          currentParticipants: seminar.current_participants,
          isOnline: seminar.is_online,
          featuredImage: seminar.featured_image
        };
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
        membershipRequirement: seminar.membership_requirement || 'free',
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
      const seminarId = this.$route.params.id;
      
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
        },
        {
          id: '手形・小切手の全面的な電子化セミナー-2025年7月15日',
          title: '手形・小切手の全面的な電子化セミナー',
          description: '当セミナーでは、手形の電子化に向けた金融界の取組みや、代替手段である「でんさい」や「法人インターネットバンキング（ビジネスWeb）」の仕組みや導入方法、でんさいの基本的な操作方法についてご説明します。',
          fullDescription: '当セミナーでは、手形の電子化に向けた金融界の取組みや、代替手段である「でんさい」や「法人インターネットバンキング（ビジネスWeb）」の仕組みや導入方法、でんさいの基本的な操作方法についてご説明します。手形の電子化は、企業の業務効率化とコスト削減に大きく貢献します。本セミナーでは、実践的な知識と具体的な導入ステップをご提供いたします。',
          date: '2025-07-15',
          fee: '会員無料',
          status: 'current',
          instructor: 'ちくぎん地域経済研究所',
          venue: '久留米リサーチ・パーク',
          target: '経営者・人事担当者',
          image: '/img/image-1.png'
        }
      ];
      
      // 数値IDまたは文字列IDで検索
      let foundSeminar = seminars.find(s => s.id == seminarId);
      
      // 文字列IDで見つからない場合は、タイトルと日付から生成されたIDを検索
      if (!foundSeminar) {
        foundSeminar = seminars.find(s => s.id === seminarId);
      }
      
      // それでも見つからない場合は、デフォルトのセミナーを表示
      if (!foundSeminar) {
        foundSeminar = seminars[0];
      }
      
      this.seminar = foundSeminar;
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
    getMembershipText(level) {
      switch (level) {
        case 'standard':
          return 'スタンダード';
        case 'premium':
          return 'プレミアム';
        default:
          return '会員';
      }
    },
    handleRegistration() {
      if (!this.seminar) return;
      
      const requiredLevel = this.seminar.membershipRequirement || 'free';
      const canAccess = this.$store.getters['auth/canAccess'](requiredLevel);
      
      if (canAccess) {
        this.registerSeminar();
      } else if (!this.$store.getters['auth/isAuthenticated']) {
        this.$router.push('/login');
      } else {
        alert(`このセミナーは${this.getMembershipText(requiredLevel)}会員限定です。アップグレードをご検討ください。`);
        this.$router.push('/membership');
      }
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
    },
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

.page-container {
  min-height: 100vh;
  background-color: #ECECEC;
}

/* Hero Section and Breadcrumb styles are now handled by components */

/* Seminar Detail Section */
.seminar-detail-section {
  padding: 70px 50px 50px 50px;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 40px;
  background: #ECECEC;
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

/* Seminar Detail Card */
.seminar-detail-card {
  background: white;
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0 5px 20px rgba(0,0,0,0.1);
  width: 100%;
  max-width: 1500px;
  padding: 50px;
}

.seminar-content {
  display: flex;
  flex-direction: row;
  align-items: stretch;
  gap: 50px;
  height: auto;
}

.seminar-image {
  width: 40%;
  height: auto;
  overflow: hidden;
  flex-shrink: 0;
  align-self: stretch;
}

.seminar-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  min-height: 400px;
}

.seminar-info {
  width: 60%;
  flex: 1;
  height: 100%;
}

.seminar-details {
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.detail-row {
  display: flex;
  flex-direction: column;
  margin-bottom: 15px;
  align-items: flex-start;
  border-bottom: 0.5px dashed #D0D0D0;
  padding-bottom: 15px;
}

.detail-row:first-child {
  border-top: 0.5px dashed #D0D0D0;
  padding-top: 15px;
}

.detail-label {
  width: 200px;
  font-weight: normal;
  color: white;
  font-size: 0.9rem;
  background-color: #727272;
  padding: 5px 0;
  border-radius: 5px;
  text-align: center;
  margin-bottom: 5px;
}

.detail-value {
  width: 100%;
  color: #666;
  font-size: 0.9rem;
  line-height: 1.5;
  padding-left: 10px;
}



/* Registration Section */
.registration-section {
  text-align: center;
  margin-top: 30px;
}

.registration-btn {
  align-items: center;
  background-color: var(--mandy);
  border-radius: 10px;
  box-shadow: 0px 1px 2px #0000000d;
  display: flex;
  gap: 10px;
  justify-content: center;
  padding: 10px 0px;
  width: 380px;
  border: none;
  cursor: pointer;
  color: white;
  font-family: var(--font-family-inter);
  font-size: 1.1rem;
  font-weight: bold;
  transition: all 0.3s;
  margin: 0 auto;
}

.registration-btn:hover {
  background: #c44853;
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(218, 87, 97, 0.3);
}

.text-44 {
  letter-spacing: 0;
  line-height: 22.5px;
  margin-top: 0px;
  position: relative;
  white-space: nowrap;
  width: fit-content;
  display: flex;
  align-items: center;
  color: var(--white);
  font-family: var(--font-family-inter);
  font-size: 15px;
  font-weight: 700;
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

/* 会員制限スタイル */
.detail-badge {
  position: absolute;
  top: 15px;
  right: 15px;
  z-index: 2;
}

.seminar-image {
  position: relative;
}

.registration-btn.disabled {
  opacity: 0.6;
  cursor: not-allowed;
  background-color: #e0e0e0;
}

.seminar-detail-card {
  position: relative;
}

/* Contact Banner styles are now handled by ContactSection component */

/* Access Section styles are now handled by AccessSection component */

/* Floating Action Buttons styles are now handled by FixedSideButtons component */

/* Responsive Design */
@media (max-width: 1150px) {
  .seminar-detail-section {
    padding: 50px 30px !important;
  }
  
  .seminar-title {
    font-size: 32px !important;
  }
  
  .seminar-subtitle {
    font-size: 18px !important;
  }
  
  .seminar-description p {
    font-size: 18px !important;
  }
  
  .detail-label {
    font-size: 18px !important;
  }
  
  .detail-value {
    font-size: 18px !important;
  }
  
  .action-btn {
    font-size: 18px !important;
    padding: 15px 30px !important;
  }
  
  .seminar-image {
    height: 350px !important;
  }
}

/* 1150px以下（タブレット横向き） */
@media (max-width: 1150px) {
  .seminar-detail-section {
    padding: 50px 30px !important;
  }
  
  .seminar-detail-card {
    padding: 40px !important;
  }
  
  .seminar-content {
    flex-direction: column !important;
    gap: 0 !important;
  }
  
  .seminar-image {
    width: 100% !important;
    height: 300px !important;
    border-radius: 20px 20px 0 0 !important;
    order: -1 !important;
  }
  
  .seminar-info {
    width: 100% !important;
    border-radius: 0 0 20px 20px !important;
    padding: 30px 0 0 0 !important;
    order: 1 !important;
  }
  
  .section-title {
    font-size: 32px !important;
  }
  
  .divider-text {
    font-size: 18px !important;
  }
  
  .detail-label,
  .detail-value {
    font-size: 18px !important;
  }
  
  .section-header {
    gap: 25px !important;
  }
}

/* 900px以下（タブレット） */
@media (max-width: 900px) {
  .seminar-detail-section {
    padding: 30px 20px !important;
  }
  
  .seminar-detail-card {
    padding: 35px !important;
  }
  
  .seminar-image {
    height: 280px !important;
    order: -1 !important;
  }
  
  .seminar-info {
    padding: 30px 0 0 0 !important;
    order: 1 !important;
  }
  
  .section-title {
    font-size: 29px !important;
  }
  
  .divider-text {
    font-size: 17px !important;
  }
  
  .detail-label,
  .detail-value {
    font-size: 17px !important;
  }
  
  .section-header {
    gap: 22px !important;
  }
}

/* 768px以下（タブレット縦向き） */
@media (max-width: 768px) {
  .seminar-detail-section {
    padding: 30px 20px !important;
  }
  
  .seminar-detail-card {
    padding: 30px !important;
  }
  
  .seminar-content {
    flex-direction: column !important;
    gap: 0 !important;
  }
  
  .seminar-image {
    width: 100% !important;
    height: 250px !important;
    border-radius: 20px 20px 0 0 !important;
    order: -1 !important;
  }
  
  .seminar-info {
    width: 100% !important;
    padding: 30px 0 0 0 !important;
    border-radius: 0 0 20px 20px !important;
    order: 1 !important;
  }
  
  .section-title {
    font-size: 27px !important;
  }
  
  .divider-text {
    font-size: 16px !important;
  }
  
  .detail-label,
  .detail-value {
    font-size: 16px !important;
  }
  
  .section-header {
    gap: 20px !important;
  }
  
  .detail-row {
    flex-direction: column !important;
  }
  
  .action-buttons {
    flex-direction: column !important;
    align-items: center !important;
  }
  
  .action-btn {
    width: 100% !important;
    max-width: 300px !important;
    font-size: 16px !important;
    padding: 13px 26px !important;
  }
}

/* 480px以下（スマートフォン） */
@media (max-width: 480px) {
  .seminar-detail-section {
    padding: 20px 15px !important;
  }
  
  .seminar-detail-card {
    padding: 20px !important;
  }
  
  .seminar-image {
    height: 200px !important;
    border-radius: 15px 15px 0 0 !important;
    order: -1 !important;
  }
  
  .seminar-info {
    padding: 20px 0 0 0 !important;
    border-radius: 0 0 15px 15px !important;
    order: 1 !important;
  }
  
  .section-title {
    font-size: 22px !important;
  }
  
  .divider-text {
    font-size: 13px !important;
  }
  
  .detail-label,
  .detail-value {
    font-size: 13px !important;
  }
  
  .section-header {
    gap: 18px !important;
  }
  
  .action-btn {
    font-size: 13px !important;
    padding: 12px 24px !important;
  }
  
  .registration-btn {
    width: 100% !important;
    padding: 15px 20px !important;
  }
}

/* Footer Navigation */
</style>
