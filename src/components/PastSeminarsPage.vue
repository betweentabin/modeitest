<template>
  <div class="seminar-page">
    <!-- Navigation -->
    <Navigation />
    
    <!-- Hero Section -->
    <HeroSection 
      title="過去のセミナー"
      subtitle="past seminars"
      heroImage="https://api.builder.io/api/v1/image/assets/TEMP/ab5db9916398054424d59236a434310786cb8146?width=2880"
    />

    <!-- Breadcrumbs -->
    <Breadcrumbs :breadcrumbs="['セミナー', '過去のセミナー']" />

    <!-- Past Seminars Section -->
    <div class="past-seminars-section">
      <div class="seminars-container">
        <div class="section-header">
          <h2 class="section-title">過去のセミナー</h2>
          <div class="section-divider">
            <div class="divider-line"></div>
            <span class="divider-text">seminar</span>
            <div class="divider-line"></div>
          </div>
          <p class="section-description">以前行われたセミナーのバックナンバーです。</p>
        </div>

        <div class="past-seminars-content">
          <div class="past-seminar-card" v-for="(seminar, index) in pastSeminars" :key="index">
            <div class="past-seminar-info">
              <div class="past-info-row">
                <div class="info-label info-label-date">
                  <span class="label-text">セミナー日時</span>
                </div>
                <div class="info-value">{{ seminar.date }}</div>
              </div>
              <div class="past-info-row">
                <div class="info-label info-label-title">
                  <span class="label-text">セミナータイトル</span>
                </div>
                <div class="info-value">{{ seminar.title }}</div>
              </div>
              <div class="past-info-row content-row">
                <div class="info-label">
                  <span class="label-text">セミナー内容</span>
                </div>
                <div class="info-value content-text">{{ seminar.content }}</div>
              </div>
            </div>
          </div>

          <!-- Pagination -->
          <div class="pagination">
            <button 
              class="pagination-btn" 
              :class="{ active: currentPage === 1 }"
              @click="goToPage(1)"
            >
              1
            </button>
            <button 
              class="pagination-btn" 
              :class="{ active: currentPage === 2 }"
              @click="goToPage(2)"
            >
              2
            </button>
            <button 
              class="pagination-btn" 
              :class="{ active: currentPage === 3 }"
              @click="goToPage(3)"
            >
              3
            </button>
            <span class="pagination-dots">...</span>
            <button 
              class="pagination-btn" 
              :class="{ active: currentPage === 10 }"
              @click="goToPage(10)"
            >
              10
            </button>
            <button 
              class="pagination-btn next-btn"
              @click="goToPage(currentPage + 1)"
              :disabled="currentPage >= 10"
            >
              最後
            </button>
          </div>
        </div>
      </div>
    </div>

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
import { frame132131753022Data } from "../data";

export default {
  name: "PastSeminarsPage",
  components: {
    Navigation,
    Footer,
    Group27,
    AccessSection,
    HeroSection,
    Breadcrumbs,
    FixedSideButtons,
    ContactSection,
  },
  data() {
    return {
      frame132131753022Props: frame132131753022Data,
      currentPage: 1,
      itemsPerPage: 10,
      allPastSeminars: [
        {
          date: "2025年6月15日",
          title: "手形・小切手の全面的な電子化セミナー",
          content: "当セミナーでは、手形の電子化に向けた金融界の取組みや、代替手段である「でんさい」や「法人インターネットバンキング（ビジネスWeb）」の仕組みや導入方法、でんさいの基本的な操作方法についてご説明します。"
        },
        {
          date: "2025年6月10日",
          title: "デジタル変革時代の経営戦略セミナー",
          content: "デジタル技術を活用した経営戦略の立案と実行について、最新の事例を交えて詳しく解説しました。"
        },
        {
          date: "2025年6月5日",
          title: "ESG投資とサステナブル経営セミナー",
          content: "環境・社会・ガバナンスを考慮した投資と経営について、実践的なアプローチをご紹介しました。"
        },
        {
          date: "2025年5月30日",
          title: "中小企業の資金調達戦略セミナー",
          content: "中小企業が直面する資金調達の課題と解決策について、具体的な事例を交えて解説しました。"
        },
        {
          date: "2025年5月25日",
          title: "リモートワーク時代の人材マネジメントセミナー",
          content: "テレワーク環境での効果的な人材管理とチーム運営について、実践的なノウハウをご紹介しました。"
        },
        {
          date: "2025年5月20日",
          title: "AI・機械学習のビジネス活用セミナー",
          content: "人工知能と機械学習をビジネスに活用する方法について、最新の技術動向と実用例をご紹介しました。"
        },
        {
          date: "2025年5月15日",
          title: "グローバル展開戦略セミナー",
          content: "海外進出を目指す企業向けに、市場分析から現地法人設立まで、包括的な戦略をご提案しました。"
        },
        {
          date: "2025年5月10日",
          title: "データドリブン経営セミナー",
          content: "データを活用した意思決定と経営改善について、具体的な分析手法と活用事例をご紹介しました。"
        },
        {
          date: "2025年5月5日",
          title: "働き方改革と生産性向上セミナー",
          content: "働き方改革を推進しながら生産性を向上させる方法について、成功事例を交えて解説しました。"
        },
        {
          date: "2025年4月30日",
          title: "新規事業開発とイノベーションセミナー",
          content: "新規事業の立ち上げから成長戦略まで、イノベーションを生み出す組織づくりについて解説しました。"
        }
      ]
    };
  },
  computed: {
    pastSeminars() {
      const start = (this.currentPage - 1) * this.itemsPerPage;
      const end = start + this.itemsPerPage;
      return this.allPastSeminars.slice(start, end);
    },
    totalPages() {
      return Math.ceil(this.allPastSeminars.length / this.itemsPerPage);
    }
  },
  methods: {
    goToPage(page) {
      if (page >= 1 && page <= this.totalPages) {
        this.currentPage = page;
      }
    }
  }
};
</script>

<style scoped>
:root {
  --color-primary: #1A1A1A;
  --color-secondary: #3F3F3F;
  --color-accent: #DA5761;
  --color-accent-dark: #9C3940;
  --color-gray: #727272;
  --color-light-gray: #F6F6F6;
  --color-light-pink: #FDF6F7;
  --color-border: #CFCFCF;
  --color-white: #FFFFFF;
  --color-background: #ECECEC;
}

.seminar-page {
  width: 100%;
  background-color: #ECECEC;
  position: relative;
}

/* Hero Section and Breadcrumb styles are now handled by components */

/* Section Headers */
.section-header {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 29px;
  margin-bottom: 50px;
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

.section-description {
  color: var(--color-primary);
  text-align: center;
  font-family: 'Inter', sans-serif;
  font-size: 18px;
  font-weight: 400;
  line-height: normal;
  letter-spacing: -0.36px;
  width: 1014px;
  margin: 0;
}

/* Past Seminars Section */
.past-seminars-section {
  padding: 50px 50px 80px 50px;
  background: var(--color-background);
}

.seminars-container {
  max-width: 2000px;
  margin: 0 auto;
}

.past-seminars-content {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 30px;
  padding: 50px;
  border-radius: 20px;
  background: #FFFFFF;
}

.past-seminar-card {
  display: flex;
  padding: 30px;
  flex-direction: column;
  align-items: flex-start;
  gap: 10px;
  border-radius: 20px;
  background: #F6F6F6;
  width: 100%;
}

.past-seminar-info {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  border-top: 0.5px dashed var(--color-secondary);
  width: 100%;
}

.past-seminar-info .info-row {
  border-bottom: 0.5px dashed var(--color-secondary);
}

.past-info-row {
  display: flex;
  padding: 15px 0;
  align-items: center;
  gap: 50px;
  border-bottom: 0.5px dashed #B0B0B0;
  width: 100%;
}

.past-info-row:first-child {
  border-top: 0.5px dashed #B0B0B0;
}

.content-row {
  align-items: center;
  min-height: 96px;
}

.info-label {
  display: flex;
  padding: 10px 30px;
  justify-content: center;
  align-items: center;
  gap: 10px;
  border-radius: 5px;
  background: #727272;
  white-space: nowrap;
  width: 250px;
}

.info-label-date {
  width: 250px;
}

.info-label-title {
  width: 250px;
}

.label-text {
  color: #FFFFFF;
  font-family: 'Inter', sans-serif;
  font-size: 18px;
  font-weight: 400;
  line-height: 150%;
}

.info-value {
  color: var(--color-secondary);
  font-family: 'Inter', sans-serif;
  font-size: 18px;
  font-weight: 400;
  line-height: normal;
}

.content-text {
  flex: 1;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.show-more-btn {
  display: flex;
  width: 300px;
  padding: 10px 0;
  justify-content: center;
  align-items: center;
  gap: 10px;
  border-radius: 10px;
  background: #1A1A1A;
  border: none;
  cursor: pointer;
  box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
  color: #ffffff;
}

.show-more-btn span {
  color: #ffffff;
  font-family: 'Inter', sans-serif;
  font-size: 15px;
  font-weight: 700;
  line-height: 150%;
}

.show-more-btn:hover {
  background: var(--color-secondary);
}

.past-show-more {
  /* Same styles as show-more-btn */
}

/* Pagination Styles */
.pagination {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 10px;
  margin-top: 30px;
}

.pagination-btn {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 40px;
  height: 40px;
  border-radius: 5px;
  background: #FFFFFF;
  border: 1px solid #CFCFCF;
  cursor: pointer;
  font-family: 'Inter', sans-serif;
  font-size: 14px;
  font-weight: 500;
  color: var(--color-secondary);
  transition: all 0.3s ease;
}

.pagination-btn:hover {
  background: var(--color-accent);
  color: #FFFFFF;
  border-color: var(--color-accent);
}

.pagination-btn.active {
  background: #1A1A1A;
  color: #FFFFFF;
  border-color: #1A1A1A;
}

.pagination-btn:disabled {
  background: #F6F6F6;
  color: #B2B2B2;
  cursor: not-allowed;
  border-color: #E0E0E0;
}

.pagination-dots {
  color: var(--color-secondary);
  font-size: 14px;
  font-weight: 500;
}

.next-btn {
  width: 60px;
}

/* Contact Banner styles are now handled by ContactSection component */

/* Access Section styles are now handled by AccessSection component */

/* Floating Action Buttons styles are now handled by FixedSideButtons component */

/* Footer Navigation */

/* Responsive Design */
@media (max-width: 1150px) {
  .past-seminars-section {
    padding: 50px 30px !important;
  }
  
  .past-seminars-content {
    padding: 50px 30px !important;
  }
  
  .section-title {
    font-size: 32px !important;
  }
  
  .section-description {
    font-size: 18px !important;
  }
  
  .seminar-card {
    gap: 30px !important;
  }
  
  .seminar-title {
    font-size: 22px !important;
  }
  
  .seminar-description {
    font-size: 18px !important;
  }
  
  .seminar-date,
  .seminar-location {
    font-size: 18px !important;
  }
  
  .seminar-image {
    height: 300px !important;
  }
  
  .show-more-btn span {
    font-size: 18px !important;
  }
  
  .pagination-btn {
    width: 38px !important;
    height: 38px !important;
    font-size: 13px !important;
  }
}

@media (max-width: 900px) {
  .past-seminars-section {
    padding: 45px 25px !important;
  }
  
  .past-seminars-content {
    padding: 45px 25px !important;
  }
  
  .section-title {
    font-size: 29px !important;
  }
  
  .section-description {
    font-size: 17px !important;
  }
  
  .seminar-card {
    gap: 25px !important;
  }
  
  .seminar-title {
    font-size: 20px !important;
  }
  
  .seminar-description {
    font-size: 17px !important;
  }
  
  .seminar-date,
  .seminar-location {
    font-size: 17px !important;
  }
  
  .seminar-image {
    height: 280px !important;
  }
  
  .show-more-btn span {
    font-size: 17px !important;
  }
  
  .pagination-btn {
    width: 36px !important;
    height: 36px !important;
    font-size: 12px !important;
  }
}

@media (max-width: 768px) {
  .past-seminars-section {
    padding: 30px 20px !important;
  }
  
  .past-seminars-content {
    padding: 30px 20px !important;
  }
  
  .section-title {
    font-size: 27px !important;
  }
  
  .section-description {
    width: 100% !important;
    font-size: 16px !important;
  }
  
  .seminar-card {
    flex-direction: column !important;
    gap: 20px !important;
  }
  
  .seminar-title {
    font-size: 19px !important;
  }
  
  .seminar-description {
    font-size: 16px !important;
  }
  
  .seminar-date,
  .seminar-location {
    font-size: 16px !important;
  }
  
  .seminar-image {
    width: 100% !important;
    height: 250px !important;
    border-radius: 20px 20px 0 0 !important;
  }
  
  .seminar-details {
    width: 100% !important;
  }
  
  .show-more-btn span {
    font-size: 16px !important;
  }
  
  .pagination-btn {
    width: 34px !important;
    height: 34px !important;
    font-size: 11px !important;
  }
}

@media (max-width: 480px) {
  .past-seminars-section {
    padding: 20px 15px !important;
  }
  
  .past-seminars-content {
    padding: 20px 15px !important;
  }
  
  .section-title {
    font-size: 22px !important;
  }
  
  .section-description {
    font-size: 13px !important;
  }
  
  .seminar-card {
    gap: 18px !important;
  }
  
  .seminar-title {
    font-size: 18px !important;
  }
  
  .seminar-description {
    font-size: 13px !important;
  }
  
  .seminar-date,
  .seminar-location {
    font-size: 13px !important;
  }
  
  .seminar-image {
    height: 200px !important;
  }
  
  .show-more-btn span {
    font-size: 13px !important;
  }
  
  .pagination-btn {
    width: 32px !important;
    height: 32px !important;
    font-size: 10px !important;
  }
}
</style>
