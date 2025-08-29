<template>
  <div class="seminar-page">
    <!-- Navigation -->
    <Navigation />
    
    <!-- Hero Section -->
    <HeroSection 
      title="受付中のセミナー"
      subtitle="current seminars"
      heroImage="https://api.builder.io/api/v1/image/assets/TEMP/ab5db9916398054424d59236a434310786cb8146?width=2880"
    />

    <!-- Breadcrumbs -->
    <Breadcrumbs :breadcrumbs="['セミナー', '受付中のセミナー']" />

    <!-- Current Seminars Section -->
    <div class="current-seminars-section">
      <div class="seminars-container">
        <div class="section-header">
          <h2 class="section-title">現在予約受付中のセミナー</h2>
          <div class="section-divider">
            <div class="divider-line"></div>
            <span class="divider-text">seminar</span>
            <div class="divider-line"></div>
          </div>
          <p class="section-description">現在予約受付中のセミナーです。ご興味の方は、ご予約をしてください</p>
        </div>

        <div class="seminars-content">
          <div class="seminar-card" v-for="(seminar, index) in currentSeminars" :key="index">
            <div class="seminar-image">
              <img :src="seminar.image" :alt="seminar.title" />
            </div>
            <div class="seminar-details">
              <div class="seminar-info">
                <div class="info-row">
                  <div class="info-row-first">
                    <div class="info-label">
                      <span class="label-text">セミナー予約受付時間</span>
                    </div>
                    <div class="info-value">{{ seminar.reservationPeriod }}</div>
                  </div>
                </div>
                <div class="info-row">
                  <div class="info-row-second">
                    <div class="info-label info-label-date">
                      <span class="label-text">セミナー日時</span>
                    </div>
                    <div class="info-value">{{ seminar.date }}</div>
                  </div>
                </div>
                <div class="info-row">
                  <div class="info-row-third">
                    <div class="info-label info-label-title">
                      <span class="label-text">セミナータイトル</span>
                    </div>
                    <div class="info-value">{{ seminar.title }}</div>
                  </div>
                </div>
                <div class="info-row content-row">
                  <div class="info-row-fourth">
                    <div class="info-label">
                      <span class="label-text">セミナー内容</span>
                    </div>
                    <div class="info-value content-text">{{ seminar.content }}</div>
                  </div>
                </div>
              </div>
              <button class="reserve-btn">
                <span>セミナーを予約する</span>
                <svg width="18" height="19" viewBox="0 0 18 19" fill="none">
                  <rect y="0.5" width="18" height="18" rx="5" fill="white"/>
                  <path d="M13.7193 9.84548L10.2194 13.4453C10.1464 13.5203 10.0475 13.5625 9.94427 13.5625C9.84107 13.5625 9.74211 13.5203 9.66914 13.4453C9.59617 13.3702 9.55517 13.2684 9.55517 13.1623C9.55517 13.0562 9.59617 12.9544 9.66914 12.8793L12.5055 9.96248L4.88888 9.96248C4.78574 9.96248 4.68683 9.92034 4.6139 9.84533C4.54097 9.77032 4.5 9.66858 4.5 9.5625C4.5 9.45642 4.54097 9.35468 4.6139 9.27967C4.68683 9.20466 4.78574 9.16252 4.88888 9.16252L12.5055 9.16252L9.66914 6.24568C9.59617 6.17063 9.55517 6.06884 9.55517 5.9627C9.55517 5.85656 9.59617 5.75477 9.66914 5.67972C9.74211 5.60466 9.84107 5.5625 9.94427 5.5625C10.0475 5.5625 10.1464 5.60466 10.2194 5.67972L13.7193 9.27951C13.7554 9.31666 13.7841 9.36078 13.8037 9.40933C13.8233 9.45789 13.8333 9.50994 13.8333 9.5625C13.8333 9.61506 13.8233 9.66711 13.8037 9.71567C13.7841 9.76422 13.7554 9.80834 13.7193 9.84548Z" fill="#9C3940"/>
                </svg>
              </button>
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
    <div class="navigation-footer">
      <Footer v-bind="frame132131753022Props" />
      <div class="vector-7-1"></div>
      <group27 />
    </div>

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
  name: "CurrentSeminarsPage",
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
      allCurrentSeminars: [
        {
          image: "https://api.builder.io/api/v1/image/assets/TEMP/6f8050c173e2495bc6d7c0f029347413638f330f?width=534",
          reservationPeriod: "10:00～12:00",
          date: "2025年7月15日",
          title: "手形・小切手の全面的な電子化セミナー",
          content: "当セミナーでは、手形の電子化に向けた金融界の取組みや、代替手段である「でんさい」や「法人インターネットバンキング（ビジネスWeb）」の仕組みや導入方法、でんさいの基本的な操作方法についてご説明します。"
        },
        {
          image: "https://api.builder.io/api/v1/image/assets/TEMP/6f8050c173e2495bc6d7c0f029347413638f330f?width=534",
          reservationPeriod: "10:00～12:00",
          date: "2025年7月16日",
          title: "デジタル変革時代の経営戦略セミナー",
          content: "デジタル技術を活用した経営戦略の立案と実行について、最新の事例を交えて詳しく解説します。"
        },
        {
          image: "https://api.builder.io/api/v1/image/assets/TEMP/6f8050c173e2495bc6d7c0f029347413638f330f?width=534",
          reservationPeriod: "14:00～16:00",
          date: "2025年7月17日",
          title: "ESG投資とサステナブル経営セミナー",
          content: "環境・社会・ガバナンスを考慮した投資と経営について、実践的なアプローチをご紹介します。"
        },
        {
          image: "https://api.builder.io/api/v1/image/assets/TEMP/6f8050c173e2495bc6d7c0f029347413638f330f?width=534",
          reservationPeriod: "13:00～15:00",
          date: "2025年7月18日",
          title: "中小企業の資金調達戦略セミナー",
          content: "中小企業が直面する資金調達の課題と解決策について、具体的な事例を交えて解説します。"
        },
        {
          image: "https://api.builder.io/api/v1/image/assets/TEMP/6f8050c173e2495bc6d7c0f029347413638f330f?width=534",
          reservationPeriod: "10:00～12:00",
          date: "2025年7月19日",
          title: "リモートワーク時代の人材マネジメントセミナー",
          content: "テレワーク環境での効果的な人材管理とチーム運営について、実践的なノウハウをご紹介します。"
        },
        {
          image: "https://api.builder.io/api/v1/image/assets/TEMP/6f8050c173e2495bc6d7c0f029347413638f330f?width=534",
          reservationPeriod: "15:00～17:00",
          date: "2025年7月20日",
          title: "AI・機械学習のビジネス活用セミナー",
          content: "人工知能と機械学習をビジネスに活用する方法について、最新の技術動向と実用例をご紹介します。"
        },
        {
          image: "https://api.builder.io/api/v1/image/assets/TEMP/6f8050c173e2495bc6d7c0f029347413638f330f?width=534",
          reservationPeriod: "11:00～13:00",
          date: "2025年7月21日",
          title: "グローバル展開戦略セミナー",
          content: "海外進出を目指す企業向けに、市場分析から現地法人設立まで、包括的な戦略をご提案します。"
        },
        {
          image: "https://api.builder.io/api/v1/image/assets/TEMP/6f8050c173e2495bc6d7c0f029347413638f330f?width=534",
          reservationPeriod: "14:00～16:00",
          date: "2025年7月22日",
          title: "データドリブン経営セミナー",
          content: "データを活用した意思決定と経営改善について、具体的な分析手法と活用事例をご紹介します。"
        },
        {
          image: "https://api.builder.io/api/v1/image/assets/TEMP/6f8050c173e2495bc6d7c0f029347413638f330f?width=534",
          reservationPeriod: "10:00～12:00",
          date: "2025年7月23日",
          title: "働き方改革と生産性向上セミナー",
          content: "働き方改革を推進しながら生産性を向上させる方法について、成功事例を交えて解説します。"
        },
        {
          image: "https://api.builder.io/api/v1/image/assets/TEMP/6f8050c173e2495bc6d7c0f029347413638f330f?width=534",
          reservationPeriod: "13:00～15:00",
          date: "2025年7月24日",
          title: "新規事業開発とイノベーションセミナー",
          content: "新規事業の立ち上げから成長戦略まで、イノベーションを生み出す組織づくりについて解説します。"
        }
      ]
    };
  },
  computed: {
    currentSeminars() {
      const start = (this.currentPage - 1) * this.itemsPerPage;
      const end = start + this.itemsPerPage;
      return this.allCurrentSeminars.slice(start, end);
    },
    totalPages() {
      return Math.ceil(this.allCurrentSeminars.length / this.itemsPerPage);
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

/* Current Seminars Section */
.current-seminars-section {
  padding: 50px;
  background: var(--color-background);
}

.seminars-container {
  max-width: 2000px;
  margin: 0 auto;
}

.seminars-content {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 30px;
  padding: 50px;
  border-radius: 20px;
  background: #FFFFFF;
}

.seminar-card {
  display: flex;
  width: 100%;
  align-items: stretch;
  border-radius: 20px;
  background: #FDF6F7;
}

.seminar-image {
  width: 30%;
  flex-shrink: 0;
  border-radius: 20px 0 0 20px;
  overflow: hidden;
  position: relative;
}

.seminar-image img {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.seminar-details {
  display: flex;
  width: 70%;
  padding: 30px;
  flex-direction: column;
  align-items: flex-end;
  gap: 20px;
  flex-shrink: 0;
}

.seminar-info {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: flex-start;
  align-self: stretch;
  border-top: 1px dashed var(--color-accent);
}

.info-row {
  display: flex;
  padding: 15px 0;
  align-items: center;
  gap: 50px;
  border-bottom: 1px dashed #DA5761;
  width: 100%;
}

.info-row:first-child {
  border-top: 1px dashed #DA5761;
}

.info-row-first {
  display: flex;
  align-items: center;
  gap: 30px;
}

.info-row-second {
  display: flex;
  align-items: center;
  gap: 30px;
}

.info-row-third {
  display: flex;
  align-items: center;
  gap: 30px;
}

.info-row-fourth {
  display: flex;
  align-items: flex-start;
  gap: 30px;
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

.reserve-btn {
  display: flex;
  padding: 10px 100px;
  align-items: center;
  gap: 10px;
  border-radius: 10px;
  background: #9C3940;
  border: none;
  cursor: pointer;
  box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
}

.reserve-btn span {
  color: #FFFFFF;
  font-family: 'Inter', sans-serif;
  font-size: 15px;
  font-weight: 700;
  line-height: 150%;
}

.reserve-btn:hover {
  background: var(--color-accent);
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
  background: var(--color-accent);
  color: #FFFFFF;
  border-color: var(--color-accent);
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
.navigation-footer {
  align-items: center;
  background-color: var(--celeste);
  display: flex;
  flex-direction: column;
  gap: 50px;
  padding: 100px;
  position: relative;
  width: 100%;
  max-width: 100vw;
  z-index: 4;
  box-sizing: border-box;
}

.vector-7-1 {
  height: 1px;
  background-color: #B2B2B2;
  position: relative;
  width: 100%;
  max-width: 1240px;
}

/* Responsive Design */
@media (max-width: 1200px) {
  .seminar-card {
    flex-direction: column;
  }

  .seminar-image {
    width: 100%;
    height: 250px;
    border-radius: 20px 20px 0 0;
  }

  .seminar-details {
    width: 100%;
  }
}

@media (max-width: 768px) {
  .current-seminars-section {
    padding: 30px 20px;
  }

  .seminars-content {
    padding: 30px 20px;
  }

  .section-description {
    width: 100%;
  }
}
</style>
