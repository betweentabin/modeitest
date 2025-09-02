<template>
  <div class="page-container">
    <Navigation />
    
    <!-- Hero Section -->
    <HeroSection 
      title="経済・調査統計"
      subtitle="economic statistics"
      heroImage="https://api.builder.io/api/v1/image/assets/TEMP/ab5db9916398054424d59236a434310786cb8146?width=2880"
    />

    <!-- Breadcrumbs -->
    <Breadcrumbs :breadcrumbs="['経済・調査統計']" />

    <!-- Economic Statistics Detail Section -->
    <section class="statistics-detail-section" v-if="statistics">
      <div class="section-header">
        <h2 class="section-title">経済・調査統計</h2>
        <div class="section-divider">
          <div class="divider-line"></div>
          <span class="divider-text">economic statistics</span>
          <div class="divider-line"></div>
        </div>
      </div>

      <!-- Statistics Details Card -->
      <div class="statistics-detail-card">
          <div class="statistics-content">
                         <div class="statistics-info">
              <div class="statistics-details">
                             <div class="detail-row">
                  <span class="detail-label">タイトル</span>
                  <span class="detail-value">{{ statistics.title || '経済統計レポート' }}</span>
                </div>

                <div class="detail-row">
                  <span class="detail-label">カテゴリー</span>
                  <span class="detail-value">{{ statistics.category || '四半期経済レポート' }}</span>
                </div>
                
                <div class="detail-row">
                  <span class="detail-label">詳細</span>
                  <span class="detail-value">{{ statistics.description || '詳細情報がここに表示されます。' }}</span>
                </div>
                
                <div class="detail-row">
                  <span class="detail-label">備考</span>
                  <span class="detail-value">{{ statistics.notes || '備考情報がここに表示されます。' }}</span>
                </div>
                
                <div class="detail-row">
                  <span class="detail-label">CHECK</span>
                  <span class="detail-value">{{ statistics.check || 'チェック項目がここに表示されます。' }}</span>
                </div>
               
               
             </div>
           </div>
           
           <div class="statistics-image">
             <img :src="statistics.image || '/img/image-1.png'" :alt="statistics.title" />
           </div>
         </div>



        <!-- Action Section based on Auth State -->
        <div class="action-section">
          <!-- 非会員の場合 -->
          <div v-if="authState.type === 'non_member'" class="members-only-section">
            <p class="members-only-notice">{{ authState.message }}</p>
            <div class="login-btn arrow-dark" @click="goToLogin">
              <div class="text-44 valign-text-middle inter-bold-white-15px">ログインする</div>
              <frame13213176122 />
            </div>
          </div>
          
          <!-- 会員でログイン済みの場合 -->
          <div v-else-if="authState.type === 'member_logged_in'" class="download-section">
            <p class="download-notice">{{ authState.message }}</p>
            <div class="download-btn arrow-dark" @click="downloadStatistics">
              <div class="text-44 valign-text-middle inter-bold-white-15px">PDFダウンロード</div>
              <frame13213176122 />
            </div>
          </div>
        </div>

      </div>
      </section>

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
import { useMemberAuth } from '../composables/useMemberAuth.js';

export default {
  name: "EconomicStatisticsDetailPage",
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
    ActionButton
  },
  data() {
    return {
      frame132131753022Props: frame132131753022Data,
      statistics: null,
      loading: true,
      error: null
    };
  },
  computed: {
    // 会員認証状態の取得
    authState() {
      const { isLoggedIn, getMembershipType, getMembershipLabel } = useMemberAuth();
      const loggedIn = isLoggedIn();
      const membershipType = getMembershipType();
      const membershipLabel = getMembershipLabel();
      
      if (!loggedIn) {
        return {
          type: 'non_member',
          label: '非会員',
          canDownload: false,
          message: 'この統計は会員限定です。ダウンロードするにはログインが必要です。'
        };
      }
      
      // 会員でログイン済み
      return {
        type: 'member_logged_in',
        label: membershipLabel,
        canDownload: true,
        message: 'ログイン中です。PDFをダウンロードできます。'
      };
    }
  },
  async mounted() {
    await this.loadStatistics();
  },
  methods: {
    async loadStatistics() {
      try {
        this.loading = true;
        const statisticsId = this.$route.params.id;
        
        const response = await apiClient.getPublication(statisticsId);
        
        if (response.success && response.data && response.data.publication) {
          this.statistics = this.formatStatisticsData(response.data.publication);
        } else {
          // Fallback to mock data
          this.loadFallbackData();
        }
      } catch (error) {
        console.error('Error loading statistics:', error);
        this.loadFallbackData();
      } finally {
        this.loading = false;
      }
    },
    
    loadFallbackData() {
      // Mock data for demonstration
             this.statistics = {
         id: this.$route.params.id,
         title: '雇用（有効求人倍率、パート有効求人数）',
         category: '四半期経済レポート',
         description: '雇用（有効求人倍率、パート有効求人数）を更新しました。2025年3月の福岡県の有効求人倍率は前月を0.02ポイント上回り1.20倍、パートタイム有効求人数は前年同月比1.6%減の45,783人となりました。',
         notes: 'この統計は毎月更新されます。最新の雇用動向を把握するためにご活用ください。',
         check: 'データの正確性を確認済み。公開可能な状態です。',
         image: '/img/image-1.png'
       };
    },
    
    formatStatisticsData(statisticsData) {
      return {
        ...statisticsData
      };
    },
    
        formatDetailDate(dateString) {
      if (!dateString) return '';
      return dateString;
    },
    
    async downloadStatistics() {
      try {
        const response = await apiClient.downloadPublication(this.statistics.id);
        if (response.success && response.data.download_url) {
          // ダウンロードリンクを開く
          window.open(response.data.download_url, '_blank');
        } else {
          // フォールバック: 直接ダウンロード
          this.downloadFallback();
        }
      } catch (error) {
        console.error('ダウンロードに失敗しました:', error);
        this.downloadFallback();
      }
    },
    
    downloadFallback() {
      // フォールバックダウンロード処理
      const link = document.createElement('a');
      link.href = '/sample-statistics.pdf'; // サンプルPDFへのリンク
      link.download = `${this.statistics.title}.pdf`;
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
    },
    
    goToLogin() {
      this.$router.push('/login');
    },
    
    goToContact() {
      this.$router.push('/contact');
    },
    
    goToMember() {
      this.$router.push('/member');
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

/* Statistics Detail Section */
.statistics-detail-section {
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

/* Statistics Detail Card */
.statistics-detail-card {
  background: white;
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0 5px 20px rgba(0,0,0,0.1);
  width: 100%;
  max-width: 1500px;
  padding: 50px;
}

.statistics-content {
  display: flex;
  flex-direction: row;
  align-items: stretch;
  gap: 50px;
  height: auto;
}

.statistics-image {
  width: 40%;
  height: auto;
  overflow: hidden;
  flex-shrink: 0;
  align-self: stretch;
}

.statistics-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  min-height: 400px;
}

.statistics-info {
  width: 60%;
  flex: 1;
  height: 100%;
}

.statistics-details {
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



.action-section {
  margin-top: 30px;
}

.members-only-section {
  text-align: center;
  padding: 20px;
  background-color: #f8f9fa;
  border-radius: 10px;
}

.members-only-notice {
  color: #666;
  font-size: 1rem;
  font-weight: 500;
  margin-bottom: 20px;
}

.login-btn {
  align-items: center;
  background-color: #1A1A1A;
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

.login-btn:hover {
  background: #333333;
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(26, 26, 26, 0.3);
}

.download-section {
  text-align: center;
  padding: 20px;
  background-color: #e8f5e8;
  border-radius: 10px;
}

.download-notice {
  color: #2d5a2d;
  font-size: 1rem;
  font-weight: 500;
  margin-bottom: 20px;
}

.download-btn {
  align-items: center;
  background-color: #1A1A1A;
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

.download-btn:hover {
  background: #333333;
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(26, 26, 26, 0.3);
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

.loading {
  text-align: center;
  padding: 60px;
  color: #666;
  font-size: 1.1rem;
}

/* Contact Banner styles are now handled by ContactSection component */

/* Access Section styles are now handled by AccessSection component */

/* Floating Action Buttons styles are now handled by FixedSideButtons component */

/* Footer Navigation */

/* Responsive Design */
@media (max-width: 1150px) {
  .statistics-detail-section {
    padding: 50px 30px 0 30px !important;
  }
  
  .statistics-detail-card {
    padding: 50px 30px !important;
  }
  
  .statistics-title {
    font-size: 32px !important;
  }
  
  .statistics-subtitle {
    font-size: 18px !important;
  }
  
  .statistics-description {
    font-size: 18px !important;
  }
  
  .detail-label {
    font-size: 18px !important;
  }
  
  .detail-value {
    font-size: 18px !important;
  }
  
  .download-notice {
    font-size: 18px !important;
  }
  
  .download-btn {
    font-size: 18px !important;
    padding: 15px 0px !important;
    width: 350px !important;
  }
  
  .text-44 {
    font-size: 18px !important;
  }
  
  .button-section {
    padding: 60px 30px !important;
  }
  
  .cta-button {
    font-size: 18px !important;
    padding: 15px 30px !important;
  }
}

@media (max-width: 900px) {
  .statistics-detail-section {
    padding: 45px 25px 0 25px !important;
  }
  
  .statistics-detail-card {
    padding: 45px 25px !important;
  }
  
  .statistics-title {
    font-size: 29px !important;
  }
  
  .statistics-subtitle {
    font-size: 17px !important;
  }
  
  .statistics-description {
    font-size: 17px !important;
  }
  
  .detail-label {
    font-size: 17px !important;
  }
  
  .detail-value {
    font-size: 17px !important;
  }
  
  .download-notice {
    font-size: 17px !important;
  }
  
  .download-btn {
    font-size: 17px !important;
    padding: 14px 0px !important;
    width: 320px !important;
  }
  
  .text-44 {
    font-size: 17px !important;
  }
  
  .button-section {
    padding: 55px 25px !important;
  }
  
  .cta-button {
    font-size: 17px !important;
    padding: 14px 28px !important;
  }
}

@media (max-width: 768px) {
  .statistics-detail-section {
    padding: 30px 20px 0 20px !important;
  }
  
  .statistics-detail-card {
    padding: 30px 20px !important;
  }
  
  .statistics-title {
    font-size: 27px !important;
  }
  
  .statistics-subtitle {
    font-size: 16px !important;
  }
  
  .statistics-description {
    font-size: 16px !important;
  }
  
  .statistics-content {
    flex-direction: column !important;
  }
  
  .statistics-image {
    width: 100% !important;
    height: 300px !important;
  }
  
  .statistics-info {
    width: 100% !important;
  }
  
  .detail-label {
    width: 100% !important;
    font-size: 16px !important;
  }
  
  .detail-value {
    font-size: 16px !important;
  }
  
  .download-notice {
    font-size: 16px !important;
  }
  
  .download-btn {
    font-size: 16px !important;
    padding: 13px 0px !important;
    width: 100% !important;
    max-width: 300px !important;
  }
  
  .text-44 {
    font-size: 16px !important;
  }
  
  .button-section {
    padding: 50px 20px !important;
  }
  
  .cta-button {
    width: 100% !important;
    font-size: 16px !important;
    padding: 13px 26px !important;
  }
}

@media (max-width: 480px) {
  .statistics-detail-section {
    padding: 20px 15px 0 15px !important;
  }
  
  .statistics-detail-card {
    padding: 20px 15px !important;
  }
  
  .statistics-title {
    font-size: 22px !important;
  }
  
  .statistics-subtitle {
    font-size: 13px !important;
  }
  
  .statistics-description {
    font-size: 13px !important;
  }
  
  .detail-label {
    font-size: 13px !important;
  }
  
  .detail-value {
    font-size: 13px !important;
  }
  
  .download-notice {
    font-size: 13px !important;
  }
  
  .download-btn {
    font-size: 13px !important;
    padding: 12px 0px !important;
    width: 100% !important;
    max-width: 280px !important;
  }
  
  .text-44 {
    font-size: 13px !important;
  }
  
  .button-section {
    padding: 40px 15px !important;
  }
  
  .cta-button {
    font-size: 13px !important;
    padding: 12px 24px !important;
  }
}
</style>
