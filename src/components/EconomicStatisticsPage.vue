<template>
  <div class="page-container">
    <Navigation />
    
    <!-- Hero Section -->
    <div class="hero-section">
      <div class="hero-overlay">
        <div class="hero-content">
          <h1 class="hero-title">経済・調査統計</h1>
          <p class="hero-subtitle">economic and statistical reports</p>
        </div>
      </div>
    </div>

    <div class="page-content">
      <!-- Statistics Header -->
      <div class="statistics-header">
        <h2 class="section-title">経済・調査統計</h2>
        <p class="section-subtitle">economic and statistical reports</p>
      </div>

      <!-- Year Filter -->
      <div class="year-filter">
        <button 
          v-for="year in years" 
          :key="year"
          :class="['year-btn', { active: selectedYear === year }]"
          @click="selectYear(year)"
        >
          {{ year }}年
        </button>
        <button class="download-all-btn">一括ダウンロード</button>
      </div>

      <!-- Category Dropdown -->
      <div class="category-dropdown">
        <select v-model="selectedCategory" class="category-select">
          <option value="all">全て</option>
          <option value="monthly">月次レポート</option>
          <option value="quarterly">四半期レポート</option>
          <option value="annual">年次レポート</option>
          <option value="special">特別調査</option>
        </select>
      </div>

      <!-- Featured Report -->
      <div class="featured-report" v-if="featuredReport">
        <div class="featured-content">
          <div class="featured-image">
            <img :src="featuredReport.image || '/img/image-1.png'" :alt="featuredReport.title" />
          </div>
          <div class="featured-info">
            <div class="featured-meta">
              <span class="featured-year">{{ featuredReport.year }}年</span>
              <span class="featured-category">{{ getCategoryName(featuredReport.category) }}</span>
            </div>
            <h3 class="featured-title">{{ featuredReport.title }}</h3>
            <div class="featured-details">
              <p><strong>発行：</strong>{{ featuredReport.publisher }}</p>
              <p><strong>概要：</strong>{{ featuredReport.description }}</p>
              <p><strong>ページ数：</strong>{{ featuredReport.pages }}ページ</p>
              <p><strong>形式：</strong>PDF</p>
            </div>
            <button class="download-btn">詳細を見る</button>
          </div>
        </div>
      </div>

      <!-- Reports Grid -->
      <div class="reports-grid" v-if="!loading">
        <div 
          v-for="report in filteredReports" 
          :key="report.id"
          class="report-card"
          @click="goToReportDetail(report.id)"
        >
          <div class="report-image">
            <img :src="report.image || '/img/image-1.png'" :alt="report.title" />
          </div>
          <div class="report-info">
            <div class="report-meta">
              <span class="report-year">{{ report.year }}年</span>
              <span class="report-category">{{ getCategoryName(report.category) }}</span>
            </div>
            <h4 class="report-title">{{ report.title }}</h4>
            <p class="report-description">{{ report.shortDescription }}</p>
            <div class="report-actions">
              <button class="report-download">PDFダウンロード</button>
            </div>
          </div>
        </div>
      </div>

      <div v-if="loading" class="loading">
        読み込み中...
      </div>

      <!-- Action Buttons -->
      <section class="action-section">
        <div class="action-buttons">
          <button class="action-btn contact-btn" @click="goToContact">お問い合わせはコチラ</button>
          <button class="action-btn member-btn" @click="goToMember">入会はコチラ</button>
        </div>
      </section>
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

export default {
  name: "EconomicStatisticsPage",
  components: {
    Navigation,
    Footer,
    Group27,
    FixedActionButtons
  },
  data() {
    return {
      frame132131753022Props: frame132131753022Data,
      loading: false,
      selectedYear: 2024,
      selectedCategory: 'all',
      years: [2024, 2023, 2022, 2021, 2020, 2019, 2018, 2017, 2016],
      featuredReport: {
        id: 1,
        title: '九州地域の経済動向（2024年第4四半期）',
        year: 2024,
        category: 'quarterly',
        publisher: 'ちくぎん地域経済研究所',
        description: '九州地域の最新の経済動向と今後の見通しについて詳細に分析したレポートです。製造業、サービス業、建設業等の業界別動向も掲載。',
        pages: 45,
        image: '/img/image-1.png'
      },
      reports: [
        {
          id: 2,
          title: '九州地域経済月次レポート（2024年12月）',
          shortDescription: '九州地域の月次経済指標と動向分析',
          year: 2024,
          category: 'monthly',
          pages: 20,
          image: '/img/image-1.png'
        },
        {
          id: 3,
          title: '地方銀行の経営動向調査（2024年版）',
          shortDescription: '九州・沖縄地区地方銀行の経営状況分析',
          year: 2024,
          category: 'annual',
          pages: 65,
          image: '/img/image-1.png'
        },
        {
          id: 4,
          title: '中小企業の設備投資動向（2024年上半期）',
          shortDescription: '中小企業の設備投資計画と実績調査',
          year: 2024,
          category: 'special',
          pages: 32,
          image: '/img/image-1.png'
        },
        {
          id: 5,
          title: '九州地域の人口動態と経済への影響（2024年）',
          shortDescription: '人口減少が地域経済に与える影響分析',
          year: 2024,
          category: 'special',
          pages: 58,
          image: '/img/image-1.png'
        },
        {
          id: 6,
          title: '九州地域経済年次レポート（2023年版）',
          shortDescription: '2023年の九州地域経済の総括と2024年の展望',
          year: 2023,
          category: 'annual',
          pages: 120,
          image: '/img/image-1.png'
        },
        {
          id: 7,
          title: '製造業の海外展開動向調査（2023年）',
          shortDescription: '九州地域製造業の海外進出状況と課題',
          year: 2023,
          category: 'special',
          pages: 42,
          image: '/img/image-1.png'
        },
        {
          id: 8,
          title: '観光産業の回復状況調査（2023年）',
          shortDescription: 'コロナ後の観光産業回復状況分析',
          year: 2023,
          category: 'special',
          pages: 35,
          image: '/img/image-1.png'
        },
        {
          id: 9,
          title: '九州地域金融機関の貸出動向（2023年）',
          shortDescription: '地域金融機関の融資状況と中小企業への影響',
          year: 2023,
          category: 'annual',
          pages: 48,
          image: '/img/image-1.png'
        },
        {
          id: 10,
          title: 'IT産業の成長可能性調査（2022年）',
          shortDescription: '九州地域IT産業の現状と将来性分析',
          year: 2022,
          category: 'special',
          pages: 55,
          image: '/img/image-1.png'
        },
        {
          id: 11,
          title: '農業・食品産業の競争力調査（2022年）',
          shortDescription: '九州地域の農業・食品産業の競争力分析',
          year: 2022,
          category: 'annual',
          pages: 72,
          image: '/img/image-1.png'
        },
        {
          id: 12,
          title: '地域創生の取り組み効果検証（2022年）',
          shortDescription: '地方創生政策の効果測定と今後の課題',
          year: 2022,
          category: 'special',
          pages: 38,
          image: '/img/image-1.png'
        }
      ]
    };
  },
  computed: {
    filteredReports() {
      return this.reports.filter(report => {
        const yearMatch = report.year === this.selectedYear;
        const categoryMatch = this.selectedCategory === 'all' || report.category === this.selectedCategory;
        return yearMatch && categoryMatch;
      });
    }
  },
  methods: {
    selectYear(year) {
      this.selectedYear = year;
    },
    getCategoryName(category) {
      const names = {
        'monthly': '月次レポート',
        'quarterly': '四半期レポート',
        'annual': '年次レポート',
        'special': '特別調査'
      };
      return names[category] || 'レポート';
    },
    goToReportDetail(reportId) {
      // PDFダウンロードまたは詳細ページへの遷移
      alert(`レポート${reportId}の詳細ページまたはダウンロードを開始します。`);
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
  max-width: 1200px;
  margin: 0 auto;
  padding: 60px 20px;
}

.statistics-header {
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

/* Year Filter */
.year-filter {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 10px;
  margin-bottom: 30px;
  flex-wrap: wrap;
}

.year-btn {
  background: #f8f9fa;
  border: 1px solid #dee2e6;
  padding: 8px 16px;
  border-radius: 20px;
  cursor: pointer;
  transition: all 0.3s;
  font-size: 0.9rem;
  color: #666;
}

.year-btn.active,
.year-btn:hover {
  background: #da5761;
  color: white;
  border-color: #da5761;
}

.download-all-btn {
  background: #333;
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 20px;
  cursor: pointer;
  font-size: 0.9rem;
  transition: all 0.3s;
  margin-left: 20px;
}

.download-all-btn:hover {
  background: #555;
}

/* Category Dropdown */
.category-dropdown {
  text-align: center;
  margin-bottom: 40px;
}

.category-select {
  padding: 12px 20px;
  border: 2px solid #dee2e6;
  border-radius: 25px;
  font-size: 1rem;
  background: white;
  cursor: pointer;
  outline: none;
  transition: border-color 0.3s;
  min-width: 200px;
}

.category-select:focus {
  border-color: #da5761;
}

/* Featured Report */
.featured-report {
  background: white;
  border-radius: 15px;
  padding: 30px;
  margin-bottom: 40px;
  box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

.featured-content {
  display: flex;
  gap: 30px;
  align-items: center;
}

.featured-image {
  flex: 0 0 250px;
}

.featured-image img {
  width: 100%;
  height: 200px;
  object-fit: cover;
  border-radius: 10px;
}

.featured-info {
  flex: 1;
}

.featured-meta {
  display: flex;
  gap: 15px;
  margin-bottom: 15px;
}

.featured-year {
  background: #28a745;
  color: white;
  padding: 4px 12px;
  border-radius: 15px;
  font-size: 0.8rem;
  font-weight: 500;
}

.featured-category {
  background: #da5761;
  color: white;
  padding: 4px 12px;
  border-radius: 15px;
  font-size: 0.8rem;
  font-weight: 500;
}

.featured-title {
  font-size: 1.5rem;
  color: #333;
  margin-bottom: 20px;
  font-weight: bold;
}

.featured-details {
  margin-bottom: 25px;
}

.featured-details p {
  font-size: 0.9rem;
  color: #666;
  margin-bottom: 8px;
  line-height: 1.5;
}

.download-btn {
  background: #da5761;
  color: white;
  border: none;
  padding: 12px 25px;
  border-radius: 25px;
  cursor: pointer;
  font-size: 1rem;
  transition: all 0.3s;
  font-weight: 500;
}

.download-btn:hover {
  background: #c44853;
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(218, 87, 97, 0.3);
}

/* Reports Grid */
.reports-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 25px;
  margin-bottom: 60px;
}

.report-card {
  background: white;
  border-radius: 15px;
  overflow: hidden;
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
  transition: all 0.3s;
  cursor: pointer;
}

.report-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

.report-image {
  height: 180px;
  overflow: hidden;
}

.report-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.report-info {
  padding: 20px;
}

.report-meta {
  display: flex;
  gap: 10px;
  margin-bottom: 15px;
}

.report-year {
  background: #28a745;
  color: white;
  padding: 3px 10px;
  border-radius: 12px;
  font-size: 0.75rem;
  font-weight: 500;
}

.report-category {
  background: #da5761;
  color: white;
  padding: 3px 10px;
  border-radius: 12px;
  font-size: 0.75rem;
  font-weight: 500;
}

.report-title {
  font-size: 1.1rem;
  color: #333;
  margin-bottom: 10px;
  font-weight: 600;
  line-height: 1.4;
}

.report-description {
  font-size: 0.9rem;
  color: #666;
  line-height: 1.5;
  margin-bottom: 15px;
}

.report-actions {
  text-align: center;
}

.report-download {
  background: #333;
  color: white;
  border: none;
  padding: 8px 20px;
  border-radius: 20px;
  cursor: pointer;
  font-size: 0.9rem;
  transition: all 0.3s;
  font-weight: 500;
}

.report-download:hover {
  background: #555;
}

.loading {
  text-align: center;
  padding: 40px;
  color: #666;
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
  
  .year-filter {
    justify-content: center;
  }
  
  .download-all-btn {
    margin-left: 0;
    margin-top: 10px;
  }
  
  .featured-content {
    flex-direction: column;
    text-align: center;
  }
  
  .featured-image {
    flex: none;
    max-width: 300px;
    margin: 0 auto;
  }
  
  .reports-grid {
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 20px;
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
  .reports-grid {
    grid-template-columns: 1fr;
  }
  
  .featured-image img {
    height: 160px;
  }
  
  .report-image {
    height: 150px;
  }
  
  .year-btn {
    padding: 6px 12px;
    font-size: 0.8rem;
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
