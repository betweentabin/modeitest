<template>
  <div class="page-container">
    <Navigation />
    
    <!-- Hero Section -->
    <HeroSection 
      title="経済・調査統計"
      subtitle="economic statistics"
      heroImage="/img/Image_fx6.jpg"
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
          <!-- ダウンロード可能（一般公開 または ログイン済み会員） -->
          <div v-if="authState.canDownload" class="download-section">
            <p class="download-notice">{{ authState.message }}</p>
            <div class="download-btn arrow-dark" @click="downloadStatistics">
              <div class="text-44 valign-text-middle inter-bold-white-15px">PDFダウンロード</div>
              <div class="pdf-icon-wrapper">
                <img class="pdf-icon" src="/img/PDFicon.svg" alt="PDF" width="23" height="23" />
              </div>
            </div>
          </div>

          <!-- 非会員で会員限定 -->
          <div v-else class="members-only-section">
            <p class="members-only-notice">{{ authState.message }}</p>
            <div class="login-btn arrow-dark" @click="goToLogin">
              <div class="text-44 valign-text-middle inter-bold-white-15px">ログインする</div>
              <div class="pdf-icon-wrapper">
                <svg class="arrow-icon" width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <rect width="23" height="23" rx="5" fill="white"/>
                  <path d="M17.5302 11.9415L13.0581 16.5412C12.9649 16.6371 12.8384 16.691 12.7066 16.691C12.5747 16.691 12.4482 16.6371 12.355 16.5412C12.2618 16.4453 12.2094 16.3152 12.2094 16.1796C12.2094 16.044 12.2618 15.9139 12.355 15.818L15.9793 12.0909L6.2469 12.0909C6.11511 12.0909 5.98872 12.0371 5.89554 11.9413C5.80235 11.8454 5.75 11.7154 5.75 11.5799C5.75 11.4443 5.80235 11.3143 5.89554 11.2185C5.98872 11.1226 6.11511 11.0688 6.2469 11.0688L15.9793 11.0688L12.355 7.34171C12.2618 7.24581 12.2094 7.11574 12.2094 6.98012C12.2094 6.84449 12.2618 6.71443 12.355 6.61853C12.4482 6.52263 12.5747 6.46875 12.7066 6.46875C12.8384 6.46875 12.9649 6.52263 13.0581 6.61853L17.5302 11.2183C17.5764 11.2657 17.613 11.3221 17.638 11.3841C17.6631 11.4462 17.6759 11.5127 17.6759 11.5799C17.6759 11.647 17.6631 11.7135 17.638 11.7756C17.613 11.8376 17.5764 11.894 17.5302 11.9415Z" fill="#1A1A1A"/>
                </svg>
              </div>
            </div>
          </div>
        </div>

      </div>
      </section>

<!-- Action Button Section -->
<ActionButton 
  primary-text="お問い合わせはこちら"
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
    // 会員認証状態の取得（無料公開を優先）
    authState() {
      const { isLoggedIn, getMembershipLabel } = useMemberAuth();
      const loggedIn = isLoggedIn();
      const membershipLabel = getMembershipLabel();

      // 統計が無料公開の場合はログイン不要でDL可
      if (this.statistics && (this.statistics.members_only === false || String(this.statistics.membership_level || '').toLowerCase() === 'free')) {
        return {
          type: 'public_free',
          label: '一般公開',
          canDownload: true,
          message: '一般公開のレポートです。PDFをダウンロードできます。'
        }
      }

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
        
        // 経済統計レポートAPIから取得
        const response = await apiClient.getEconomicReport(statisticsId);
        
        if (response.success && response.data) {
          this.statistics = this.formatStatisticsData(response.data);
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
        id: statisticsData.id,
        title: statisticsData.title,
        category: statisticsData.category,
        description: statisticsData.description,
        notes: statisticsData.notes,
        check: statisticsData.check,
        image: statisticsData.cover_image_url || statisticsData.cover_image || '/img/image-1.png',
        publication_date: statisticsData.publication_date,
        year: statisticsData.year,
        is_downloadable: statisticsData.is_downloadable,
        members_only: statisticsData.members_only,
        membership_level: statisticsData.membership_level || statisticsData.membershipLevel || null
      };
    },
    
        formatDetailDate(dateString) {
      if (!dateString) return '';
      return dateString;
    },
    
    async downloadStatistics() {
      try {
        const response = await apiClient.downloadEconomicReport(this.statistics.id);
        if (response.success && response.data && (response.data.file_url || response.data.download_url)) {
          // ダウンロードリンクを開く
          const url = response.data.file_url || response.data.download_url
          window.open(url, '_blank');
          try { await apiClient.logMemberAccess({ content_type: 'economic_report', content_id: this.statistics.id, access_type: 'download' }) } catch(e) { /* noop */ }
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
      const redirect = encodeURIComponent(this.$route.fullPath)
      this.$router.push(`/member-login?redirect=${redirect}`)
    },
    
    goToContact() {
      this.$router.push('/contact');
    },
    
    goToMember() {
      this.$router.push('/membership');
    },
    handleContactClick() {
      this.$router.push('/contact');
    },
    handleJoinClick() {
      this.$router.push('/application-form');
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

.login-btn:hover {
  opacity: 0.8;
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
  opacity: 0.8;
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
@media (max-width: 1200px) {
  .statistics-content {
    flex-direction: column !important;
    gap: 30px !important;
  }
  
  .statistics-image {
    width: 100% !important;
    height: 300px !important;
    order: -1 !important;
  }
  
  .statistics-info {
    width: 100% !important;
  }
}

@media (max-width: 1150px) {
  .statistics-detail-section {
    padding: 50px 30px !important;
  }
  
  .statistics-detail-card {
    padding: 30px 20px !important;
  }
  
  .statistics-image {
    height: 350px !important;
  }
  
  .section-title {
    font-size: 32px !important;
  }
  
  .divider-text {
    font-size: 18px !important;
  }
  
  .detail-label {
    font-size: 18px !important;
  }
  
  .detail-value {
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
    padding: 30px 20px 50px 20px !important;
  }
  
  .cta-button {
    font-size: 18px !important;
    padding: 15px 30px !important;
  }
}

@media (max-width: 900px) {
  .statistics-detail-section {
    padding: 30px 20px !important;
  }
  
  .statistics-detail-card {
    padding: 30px 20px !important;
  }
  
  .statistics-image {
    height: 280px !important;
  }
  
  .section-title {
    font-size: 29px !important;
  }
  
  .divider-text {
    font-size: 17px !important;
  }
  
  .detail-label {
    font-size: 17px !important;
  }
  
  .detail-value {
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
    padding: 30px 20px 50px 20px !important;
  }
  
  .cta-button {
    font-size: 17px !important;
    padding: 14px 28px !important;
  }
}

@media (max-width: 768px) {
  .statistics-detail-section {
    padding: 30px 20px !important;
  }
  
  .statistics-detail-card {
    padding: 30px 20px !important;
  }
  
  .statistics-image {
    height: 250px !important;
  }
  
  .section-title {
    font-size: 27px !important;
  }
  
  .divider-text {
    font-size: 16px !important;
  }
  
  .detail-label {
    font-size: 16px !important;
  }
  
  .detail-value {
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
    padding: 30px 20px 50px 20px !important;
  }
  
  .cta-button {
    width: 100% !important;
    font-size: 16px !important;
    padding: 13px 26px !important;
  }
}

@media (max-width: 480px) {
  .statistics-detail-section {
    padding: 20px 15px !important;
  }
  
  .statistics-detail-card {
    padding: 20px 15px !important;
  }
  
  .statistics-image {
    height: 200px !important;
  }
  
  .section-title {
    font-size: 22px !important;
  }
  
  .divider-text {
    font-size: 13px !important;
  }
  
  .detail-label {
    font-size: 13px !important;
  }
  
  .detail-value {
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
    padding: 20px 15px 40px 15px !important;
  }
  
  .cta-button {
    font-size: 13px !important;
    padding: 12px 24px !important;
  }
  
  .login-btn {
    width: 100% !important;
  }
}

/* PDF Icon Wrapper */
.pdf-icon-wrapper {
  width: 23px;
  height: 23px;
  background: white;
  border-radius: 5px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.pdf-icon {
  width: 23px;
  height: 23px;
}
</style>
