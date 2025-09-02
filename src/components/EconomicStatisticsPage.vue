<template>
  <div class="page-container">
    <Navigation />
    
    <!-- Hero Section -->
    <HeroSection 
      title="経済・調査統計"
      subtitle="economic statistics"
      heroImage="/img/hero-image.png"
    />
    
    <!-- Breadcrumbs -->
    <Breadcrumbs :breadcrumbs="['経済・調査統計']" />

    <div class="page-content">
      <!-- Publications Header -->
      <div class="publications-header">
        <h2 class="page-title">経済・調査統計</h2>
        <div class="title-decoration">
          <div class="line-left"></div>
          <span class="title-english">economic statistics</span>
          <div class="line-right"></div>
        </div>
      </div>

      <!-- Filter Container -->
      <div class="filter-container">
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
        </div>

        <!-- Download Button -->
        <button class="filter-download-btn">さらに表示
          <div class="icon-box">
            <svg class="arrow-icon" width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
              <rect width="23" height="23" rx="5" fill="white"/>
              <path d="M17.5302 11.9415L13.0581 16.5412C12.9649 16.6371 12.8384 16.691 12.7066 16.691C12.5747 16.691 12.4482 16.6371 12.355 16.5412C12.2618 16.4453 12.2094 16.3152 12.2094 16.1796C12.2094 16.044 12.2618 15.9139 12.355 15.818L15.9793 12.0909L6.2469 12.0909C6.11511 12.0909 5.98872 12.0371 5.89554 11.9413C5.80235 11.8454 5.75 11.7154 5.75 11.5799C5.75 11.4443 5.80235 11.3143 5.89554 11.2185C5.98872 11.1226 6.11511 11.0688 6.2469 11.0688L15.9793 11.0688L12.355 7.34171C12.2618 7.24581 12.2094 7.11574 12.2094 6.98012C12.2094 6.84449 12.2618 6.71443 12.355 6.61853C12.4482 6.52263 12.5747 6.46875 12.7066 6.46875C12.8384 6.46875 12.9649 6.52263 13.0581 6.61853L17.5302 11.2183C17.5764 11.2657 17.613 11.3221 17.638 11.3841C17.6631 11.4462 17.6759 11.5127 17.6759 11.5799C17.6759 11.647 17.6631 11.7135 17.638 11.7756C17.613 11.8376 17.5764 11.894 17.5302 11.9415Z" fill="#1A1A1A"/>
            </svg>
          </div>
        </button>

        <!-- Divider Line -->
        <div class="filter-divider"></div>

        <!-- Category Filter -->
        <div class="category-filter">
          <select 
            v-model="selectedCategory"
            @change="selectCategory(selectedCategory)"
            class="category-select"
          >
            <option 
              v-for="category in categories" 
              :key="category.id"
              :value="category.id"
            >
              {{ category.name }}
            </option>
          </select>
        </div>
      </div>

      <!-- Featured Publication -->
      <div class="featured-publication" v-if="featuredPublication">
        <div class="featured-content">
          <div class="featured-image">
            <img src="/img/image-1.png" alt="経済統計レポート" />
          </div>
          <div class="featured-info">
            <div class="featured-meta">
              <span class="featured-year">2025.4.28</span>
              <span class="featured-category">経済・調査統計の会員限定</span>
            </div>
            <div class="featured-details">
               <div class="content-title">雇用（有効求人倍率、パート有効求人数）</div>
               <div class="content-text">雇用（有効求人倍率、パート有効求人数）を更新しました。2025年3月の福岡県の有効求人倍率は前月を0.02ポイント上回り1.20倍、パートタイム有効求人数は前年同月比1.6%減の45,783人となりました。雇用関連の先行き指標である2025年2月の福岡県所定外労働時間は、前年同月比3.5％減の8.5時間となりました。</div>
             </div>

            <button class="download-btn" @click="goToStatisticsDetail(featuredPublication.id)">詳細を見る
              <div class="icon-box">
                <svg class="arrow-icon" width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <rect width="23" height="23" rx="5" fill="white"/>
                  <path d="M17.5302 11.9415L13.0581 16.5412C12.9649 16.6371 12.8384 16.691 12.7066 16.691C12.5747 16.691 12.4482 16.6371 12.355 16.5412C12.2618 16.4453 12.2094 16.3152 12.2094 16.1796C12.2094 16.044 12.2618 15.9139 12.355 15.818L15.9793 12.0909L6.2469 12.0909C6.11511 12.0909 5.98872 12.0371 5.89554 11.9413C5.80235 11.8454 5.75 11.7154 5.75 11.5799C5.75 11.4443 5.80235 11.3143 5.89554 11.2185C5.98872 11.1226 6.11511 11.0688 6.2469 11.0688L15.9793 11.0688L12.355 7.34171C12.2618 7.24581 12.2094 7.11574 12.2094 6.98012C12.2094 6.84449 12.2618 6.71443 12.355 6.61853C12.4482 6.52263 12.5747 6.46875 12.7066 6.46875C12.8384 6.46875 12.9649 6.52263 13.0581 6.61853L17.5302 11.2183C17.5764 11.2657 17.613 11.3221 17.638 11.3841C17.6631 11.4462 17.6759 11.5127 17.6759 11.5799C17.6759 11.647 17.6631 11.7135 17.638 11.7756C17.613 11.8376 17.5764 11.894 17.5302 11.9415Z" fill="#1A1A1A"/>
                </svg>
              </div>
            </button>
          </div>
        </div>
      </div>

      <!-- Publications Grid -->
      <div class="publications-container" v-if="!loading">
        <div class="publications-grid">
          <div 
            v-for="publication in filteredPublications" 
            :key="publication.id"
            class="publication-card"
            @click="goToPublicationDetail(publication.id)"
          >
            <div class="publication-image">
              <img :src="publication.image || '/img/image-1.png'" :alt="publication.title" />
            </div>
            <div class="publication-info">
              <div class="publication-meta">
                <span class="featured-category">経済・調査統計の会員限定</span>
                <span class="featured-year">{{ publication.year }}.4.28</span>
              </div>
              <h3 class="publication-title">{{ publication.title }}</h3>
              <button class="publication-download" @click.stop="goToStatisticsDetail(publication.id)">PDFダウンロード
              <div class="icon-box">
                <svg class="arrow-icon" width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <rect width="23" height="23" rx="5" fill="white"/>
                  <path d="M17.5302 11.9415L13.0581 16.5412C12.9649 16.6371 12.8384 16.691 12.7066 16.691C12.5747 16.691 12.4482 16.6371 12.355 16.5412C12.2618 16.4453 12.2094 16.3152 12.2094 16.1796C12.2094 16.044 12.2618 15.9139 12.355 15.818L15.9793 12.0909L6.2469 12.0909C6.11511 12.0909 5.98872 12.0371 5.89554 11.9413C5.80235 11.8454 5.75 11.7154 5.75 11.5799C5.75 11.4443 5.80235 11.3143 5.89554 11.2185C5.98872 11.1226 6.11511 11.0688 6.2469 11.0688L15.9793 11.0688L12.355 7.34171C12.2618 7.24581 12.2094 7.11574 12.2094 6.98012C12.2094 6.84449 12.2618 6.71443 12.355 6.61853C12.4482 6.52263 12.5747 6.46875 12.7066 6.46875C12.8384 6.46875 12.9649 6.52263 13.0581 6.61853L17.5302 11.2183C17.5764 11.2657 17.613 11.3221 17.638 11.3841C17.6631 11.4462 17.6759 11.5127 17.6759 11.5799C17.6759 11.647 17.6631 11.7135 17.638 11.7756C17.613 11.8376 17.5764 11.894 17.5302 11.9415Z" fill="#1A1A1A"/>
                </svg>
              </div>
            </button>
            </div>
          </div>
        </div>
      </div>

      <div v-if="loading" class="loading">
        読み込み中...
      </div>
    </div>

    <!-- Action Button Section -->
    <ActionButton 
      primary-text="お問い合わせはコチラ"
      secondary-text="入会はコチラ"
      @primary-click="handleContactClick"
      @secondary-click="handleJoinClick"
    />

    <!-- Contact CTA Section -->
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
import Navigation from "./Navigation.vue";
import Footer from "./Footer.vue";
import Group27 from "./Group27.vue";
import HeroSection from "./HeroSection.vue";
import Breadcrumbs from "./Breadcrumbs.vue";
import ContactSection from "./ContactSection.vue";
import AccessSection from "./AccessSection.vue";
import FixedSideButtons from "./FixedSideButtons.vue";
import ActionButton from "./ActionButton.vue";
import { frame132131753022Data } from "../data.js";
import apiClient from '../services/apiClient.js';
import { navigateToPublication, navigateToStatistics } from '../utils/navigation.js';

export default {
  name: "EconomicStatisticsPage",
  components: {
    Navigation,
    Footer,
    Group27,
    HeroSection,
    Breadcrumbs,
    ContactSection,
    AccessSection,
    FixedSideButtons,
    ActionButton
  },
  data() {
    return {
      frame132131753022Props: frame132131753022Data,
      loading: true,
      selectedYear: 'all',
      selectedCategory: 'all',
      error: null,
      currentPage: 1,
      totalPages: 1,
      years: [2024, 2023, 2022, 2021, 2020, 2019, 2018, 2017, 2016],
      categories: [
        { id: 'all', name: '全て' },
        { id: 'quarterly', name: '四半期経済レポート' },
        { id: 'annual', name: '年次経済統計' },
        { id: 'regional', name: '地域経済調査' },
        { id: 'industry', name: '産業別統計' }
      ],
      featuredPublication: {
        id: 1,
        title: '地域経済統計レポート',
        year: 2024,
        category: 'quarterly',
        author: 'ちくぎん地域経済研究所',
        publisher: '株式会社ちくぎん地域経済研究所',
        description: '2024年度版 地域経済動向調査レポート',
        keywords: '地域経済、統計データ、産業分析について',
        image: '/img/image-1.png'
      },
      publications: [
        {
          id: 2,
          title: '四半期経済動向調査レポート（約７）ページ',
          year: 2024,
          category: 'quarterly',
          image: '/img/image-1.png'
        },
        {
          id: 3,
          title: '年次経済統計データ集（約７）ページ',
          year: 2024,
          category: 'annual',
          image: '/img/image-1.png'
        },
        {
          id: 4,
          title: '地域経済調査結果報告書（約７）ページ',
          year: 2024,
          category: 'regional',
          image: '/img/image-1.png'
        },
        {
          id: 5,
          title: '産業別統計分析レポート（約７）ページ',
          year: 2024,
          category: 'industry',
          image: '/img/image-1.png'
        },
        {
          id: 6,
          title: '四半期経済動向調査レポート（約７）ページ',
          year: 2023,
          category: 'quarterly',
          image: '/img/image-1.png'
        },
        {
          id: 7,
          title: '年次経済統計データ集（約７）ページ',
          year: 2023,
          category: 'annual',
          image: '/img/image-1.png'
        },
        {
          id: 8,
          title: '地域経済調査結果報告書（約７）ページ',
          year: 2023,
          category: 'regional',
          image: '/img/image-1.png'
        },
        {
          id: 9,
          title: '産業別統計分析レポート（約７）ページ',
          year: 2023,
          category: 'industry',
          image: '/img/image-1.png'
        },
        {
          id: 10,
          title: '四半期経済動向調査レポート（約７）ページ',
          year: 2022,
          category: 'quarterly',
          image: '/img/image-1.png'
        },
        {
          id: 11,
          title: '年次経済統計データ集（約７）ページ',
          year: 2022,
          category: 'annual',
          image: '/img/image-1.png'
        },
        {
          id: 12,
          title: '地域経済調査結果報告書（約７）ページ',
          year: 2022,
          category: 'regional',
          image: '/img/image-1.png'
        },
        {
          id: 13,
          title: '産業別統計分析レポート（約７）ページ',
          year: 2022,
          category: 'industry',
          image: '/img/image-1.png'
        },
        {
          id: 14,
          title: '四半期経済動向調査レポート（約７）ページ',
          year: 2021,
          category: 'quarterly',
          image: '/img/image-1.png'
        },
        {
          id: 15,
          title: '年次経済統計データ集（約７）ページ',
          year: 2021,
          category: 'annual',
          image: '/img/image-1.png'
        },
        {
          id: 16,
          title: '地域経済調査結果報告書（約７）ページ',
          year: 2021,
          category: 'regional',
          image: '/img/image-1.png'
        },
        {
          id: 17,
          title: '産業別統計分析レポート（約７）ページ',
          year: 2021,
          category: 'industry',
          image: '/img/image-1.png'
        },
        {
          id: 18,
          title: '四半期経済動向調査レポート（約７）ページ',
          year: 2020,
          category: 'quarterly',
          image: '/img/image-1.png'
        },
        {
          id: 19,
          title: '年次経済統計データ集（約７）ページ',
          year: 2020,
          category: 'annual',
          image: '/img/image-1.png'
        },
        {
          id: 20,
          title: '地域経済調査結果報告書（約７）ページ',
          year: 2020,
          category: 'regional',
          image: '/img/image-1.png'
        },
        {
          id: 21,
          title: '産業別統計分析レポート（約７）ページ',
          year: 2020,
          category: 'industry',
          image: '/img/image-1.png'
        },
        {
          id: 22,
          title: '四半期経済動向調査レポート（約７）ページ',
          year: 2019,
          category: 'quarterly',
          image: '/img/image-1.png'
        },
        {
          id: 23,
          title: '年次経済統計データ集（約７）ページ',
          year: 2019,
          category: 'annual',
          image: '/img/image-1.png'
        },
        {
          id: 24,
          title: '地域経済調査結果報告書（約７）ページ',
          year: 2019,
          category: 'regional',
          image: '/img/image-1.png'
        }
      ]
    };
  },
  async mounted() {
    await Promise.all([
      this.loadFeaturedReport(),
      this.loadCategories(),
      this.loadYears(),
      this.loadPublications()
    ]);
  },
  computed: {
    filteredPublications() {
      const filtered = this.publications.filter(pub => {
        const yearMatch = this.selectedYear === 'all' || pub.year === this.selectedYear;
        const categoryMatch = this.selectedCategory === 'all' || pub.category === this.selectedCategory;
        return yearMatch && categoryMatch;
      });
      // 4列×3行=12個のレイアウトに合わせて最初の12個を返す
      return filtered.slice(0, 12);
    }
  },
  methods: {
    async loadPublications() {
      this.loading = true;
      try {
        const params = {
          page: this.currentPage,
          per_page: 12
        };
        
        if (this.selectedCategory && this.selectedCategory !== 'all') {
          params.category = this.selectedCategory;
        }

        if (this.selectedYear && this.selectedYear !== 'all') {
          params.year = this.selectedYear;
        }
        
        const response = await apiClient.getEconomicReports(params);
        
        if (response.success && response.data) {
          this.publications = response.data.reports.map(item => this.formatReportItem(item));
          this.totalPages = response.data.pagination.total_pages;
        } else {
          // フォールバック: 既存データを使用
          console.log('APIからデータを取得できませんでした。フォールバックデータを使用します。');
        }
      } catch (err) {
        console.error('経済統計の読み込みに失敗しました:', err);
        this.error = '経済統計の読み込みに失敗しました。';
        // フォールバック: 既存データを使用
      } finally {
        this.loading = false;
      }
    },

    async loadFeaturedReport() {
      try {
        const response = await apiClient.getFeaturedEconomicReport();
        
        if (response.success && response.data) {
          this.featuredPublication = this.formatReportItem(response.data);
        }
      } catch (err) {
        console.error('特集レポートの読み込みに失敗しました:', err);
        // フォールバック: 既存データを使用
      }
    },

    async loadCategories() {
      try {
        const response = await apiClient.getEconomicReportCategories();
        
        if (response.success && response.data) {
          this.categories = [
            { id: 'all', name: '全て' },
            ...response.data
          ];
        }
      } catch (err) {
        console.error('カテゴリの読み込みに失敗しました:', err);
        // フォールバック: 既存データを使用
      }
    },

    async loadYears() {
      try {
        const response = await apiClient.getEconomicReportYears();
        
        if (response.success && response.data) {
          this.years = response.data;
        }
      } catch (err) {
        console.error('年の読み込みに失敗しました:', err);
        // フォールバック: 既存データを使用
      }
    },
    
    formatReportItem(item) {
      return {
        id: item.id,
        title: item.title,
        year: item.year,
        category: item.category,
        image: item.cover_image_url || item.cover_image || '/img/image-1.png',
        description: item.description,
        author: item.author,
        publisher: item.publisher,
        pages: item.pages,
        is_downloadable: item.is_downloadable,
        members_only: item.members_only,
        publication_date: item.publication_date,
        keywords: item.keywords
      };
    },
    
    async downloadPublication(publicationId) {
      try {
        const response = await apiClient.downloadEconomicReport(publicationId);
        
        if (response.success && response.data) {
          if (response.data.file_url) {
            // ダウンロードURLにリダイレクト
            window.open(response.data.file_url, '_blank');
          } else {
            throw new Error('ダウンロードURLが取得できませんでした');
          }
        } else if (response.requires_login) {
          // ログインが必要な場合
          alert('このレポートは会員限定です。ログインしてください。');
          this.$router.push('/login');
        } else {
          throw new Error(response.message || 'ダウンロードに失敗しました');
        }
      } catch (err) {
        console.error('ダウンロードに失敗しました:', err);
        alert('ダウンロードに失敗しました。しばらくしてから再度お試しください。');
      }
    },
    selectYear(year) {
      this.selectedYear = year;
    },
    selectCategory(categoryId) {
      this.selectedCategory = categoryId;
    },
    getCategoryName(categoryId) {
      const category = this.categories.find(cat => cat.id === categoryId);
      return category ? category.name : '経済統計';
    },
    goToPublicationDetail(publicationId) {
      this.$router.push(navigateToPublication(publicationId));
    },
    goToStatisticsDetail(statisticsId) {
      this.$router.push(navigateToStatistics(statisticsId));
    },
    goToContact() {
      this.$router.push('/contact');
    },
    goToRegister() {
      this.$router.push('/register');
    },
    handleContactClick() {
      this.$router.push('/contact');
    },
    handleJoinClick() {
      this.$router.push('/join');
    }
  }
};
</script>

<style scoped>
.page-container {
  min-height: 100vh;
  background-color: #ECECEC;
}

/* Page Content */
.page-content {
  margin: 0 auto;
  padding: 70px 50px 50px 50px;
}

.publications-header {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 29px;
  margin-bottom: 40px;
}

.page-title {
  font-family: Inter, -apple-system, Roboto, Helvetica, sans-serif;
  font-size: 36px;
  font-weight: 700;
  color: #1A1A1A;
  letter-spacing: -0.72px;
  text-align: center;
  margin: 0;
}

.title-decoration {
  display: flex;
  align-items: center;
  gap: 15px;
  width: auto;
  min-width: 306px;
}

.line-left, .line-right {
  width: 80px;
  height: 2px;
  background: #DA5761;
  flex-shrink: 0;
}

.title-english {
  font-family: Inter, -apple-system, Roboto, Helvetica, sans-serif;
  font-size: 20px;
  font-weight: 700;
  color: #DA5761;
  white-space: nowrap;
}

/* Filter Container */
.filter-container {
  background: white;
  padding: 50px;
  border-radius: 15px;
  margin-bottom: 40px;
  max-width: 2000px;
  margin-left: auto;
  margin-right: auto;
  display: flex;
  flex-direction: column;
  gap: 20px;
}

/* Year Filter */
.year-filter {
  display: flex;
  justify-content: center;
  gap: 10px;
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

/* Filter Download Button */
.filter-download-btn {
  display: flex;
  width: auto;
  padding: 10px 50px;
  justify-content: center;
  align-items: center;
  gap: 10px;
  border-radius: 10px;
  background: #1A1A1A;
  border: none;
  cursor: pointer;
  color: #ffffff;
  font-family: 'Inter', sans-serif;
  font-size: 15px;
  font-weight: 700;
  line-height: 150%;
  transition: all 0.3s ease;
  margin: 0 auto 0;
}

.filter-download-btn:hover {
  background: var(--color-secondary);
}

/* Filter Divider */
.filter-divider {
  width: 100%;
  height: 1px;
  background-color: #E0E0E0;
  margin: 10px 0;
}

.icon-box {
  display: flex;
  align-items: center;
  justify-content: center;
}

.arrow-icon {
  display: flex;
  align-items: center;
  justify-content: center;
}

/* Category Filter */
.category-filter {
  display: flex;
  justify-content: flex-end;
  width: 100%;
}

.category-select {
  background: #F6D5D8;
  border: none;
  padding: 15px 20px;
  border-radius: 8px;
  cursor: pointer;
  transition: all 0.3s;
  font-size: 0.9rem;
  color: #1A1A1A;
  font-family: 'Inter', sans-serif;
  font-weight: 500;
  min-width: 300px;
  outline: none;
}

.category-select:hover {
  background: #da5761;
  color: white;
}

.category-select:focus {
  box-shadow: none;
}

.category-select option {
  background: white;
  color: #1A1A1A;
  padding: 10px;
}

/* Featured Publication */
.featured-publication {
  background: white;
  border-radius: 15px;
  padding: 50px;
  margin-bottom: 40px;
  max-width: 2000px;
  margin-left: auto;
  margin-right: auto;
}

.featured-content {
  display: flex;
  width: 100%;
  align-items: stretch;
  gap: 30px;
}

.featured-image {
  width: 30%;
  flex-shrink: 0;
  border-radius: 10px;
  overflow: hidden;
  position: relative;
}

.featured-image img {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 10px;
}

.featured-info {
  display: flex;
  flex: 1;
  flex-direction: column;
  flex-shrink: 0;
}

.featured-meta {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 15px;
}

.featured-year {
  color:#3F3F3F;
  font-size: 0.8rem;
  font-weight: 500;
}

.featured-category {
  background: #F6D5D8;
  color: #1A1A1A;
  padding: 10px 15px;
  border-radius: 5px;
  font-size: 0.8rem;
  font-weight: 500;
  width: auto;
  align-self: flex-start;
}

.featured-details {
  display: flex;
  flex-direction: column;
  gap: 20px;
  width: 100%;
  border-top: 0.5px dashed #B0B0B0;
  border-bottom: 0.5px dashed #B0B0B0;
  padding: 20px 0;
}

.content-title {
  font-family: 'Inter', sans-serif;
  font-size: 20px;
  font-weight: 700;
  color: #1A1A1A;
  line-height: 1.4;
}

.content-text {
  font-family: 'Inter', sans-serif;
  font-size: 16px;
  font-weight: 400;
  color: #666;
  line-height: 1.6;
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
  color: #FFFFFF;
  font-family: 'Inter', sans-serif;
  font-size: 18px;
  font-weight: 400;
  line-height: 150%;
  margin: 0;
}

.info-value {
  color: var(--color-secondary);
  font-family: 'Inter', sans-serif;
  font-size: 18px;
  font-weight: 400;
  line-height: normal;
}



.download-btn {
  display: flex;
  width: auto;
  padding: 10px 50px;
  justify-content: center;
  align-items: center;
  gap: 10px;
  border-radius: 10px;
  background: #1A1A1A;
  border: none;
  cursor: pointer;

  color: #ffffff;
  margin-top: 20px;
  margin-left: auto;
  font-family: 'Inter', sans-serif;
  font-size: 15px;
  font-weight: 700;
  line-height: 150%;
  transition: all 0.3s ease;
}

.download-btn:hover {
  background: var(--color-secondary);
}

/* Publications Container */
.publications-container {
  background: white;
  padding: 50px;
  border-radius: 15px;
  max-width: 2000px;
  margin-left: auto;
  margin-right: auto;
}

/* Publications Grid */
.publications-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 30px;
}

.publication-card {
  background: white;
  border-radius: 10px;
  overflow: hidden;
  transition: all 0.3s;
  cursor: pointer;
  min-height: 300px;
  display: flex;
  flex-direction: column;
}

.publication-card:hover {
  transform: translateY(-5px);

}

.publication-image {
  height: 180px;
  overflow: hidden;
}

.publication-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.publication-info {
  padding: 20px 0 0 0;
  flex: 1;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.publication-meta {
  display: flex;
  flex-direction: column;
  gap: 15px;
  margin-bottom: 15px;
}



.publication-title {
  font-size: 1rem;
  color: #1A1A1A;
  margin-bottom: 15px;
  font-weight: 500;
  line-height: 1.4;
}

.publication-download {
  display: flex;
  width: 100%;
  padding: 10px 0;
  justify-content: center;
  align-items: center;
  gap: 10px;
  border-radius: 10px;
  background: #1A1A1A;
  border: none;
  cursor: pointer;
  color: #ffffff;
  font-family: 'Inter', sans-serif;
  font-size: 15px;
  font-weight: 700;
  line-height: 150%;
  transition: all 0.3s ease;
}

.publication-download:hover {
  background: var(--color-secondary);
}

.loading {
  text-align: center;
  padding: 40px;
  color: #666;
}



/* Responsive Design */
@media (max-width: 1150px) {
  .page-content {
    padding: 50px 20px !important;
  }
  
  .publications-grid {
    grid-template-columns: repeat(3, 1fr) !important;
    gap: 20px !important;
  }
  
  .section-title {
    font-size: 32px !important;
  }
  
  .featured-title {
    font-size: 22px !important;
  }
  
  .featured-description {
    font-size: 18px !important;
  }
  
  .publication-title {
    font-size: 18px !important;
  }
  
  .publication-description {
    font-size: 18px !important;
  }
}

@media (max-width: 900px) {
  .page-content {
    padding: 40px 20px !important;
  }
  
  .publications-grid {
    grid-template-columns: repeat(2, 1fr) !important;
    gap: 20px !important;
  }
  
  .section-title {
    font-size: 29px !important;
  }
  
  .featured-title {
    font-size: 20px !important;
  }
  
  .featured-description {
    font-size: 17px !important;
  }
  
  .publication-title {
    font-size: 17px !important;
  }
  
  .publication-description {
    font-size: 17px !important;
  }
  
  .year-filter {
    justify-content: center !important;
  }
  
  .category-filter {
    flex-wrap: wrap !important;
    gap: 5px !important;
  }
  
  .category-btn {
    padding: 10px 15px !important;
    font-size: 0.7rem !important;
    border-right: none !important;
    border-radius: 15px !important;
    margin-bottom: 5px !important;
  }
}

@media (max-width: 768px) {
  .page-content {
    padding: 40px 15px !important;
  }
  
  .publications-grid {
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)) !important;
    gap: 15px !important;
  }
  
  .section-title {
    font-size: 27px !important;
  }
  
  .featured-title {
    font-size: 19px !important;
  }
  
  .featured-description {
    font-size: 16px !important;
  }
  
  .publication-title {
    font-size: 16px !important;
  }
  
  .publication-description {
    font-size: 16px !important;
  }
  
  .featured-content {
    flex-direction: column !important;
    text-align: center !important;
  }
  
  .featured-image {
    flex: none !important;
    max-width: 300px !important;
    margin: 0 auto !important;
  }
}

@media (max-width: 480px) {
  .page-content {
    padding: 30px 20px !important;
  }
  
  .publications-grid {
    grid-template-columns: 1fr !important;
    gap: 20px !important;
  }
  
  .section-title {
    font-size: 22px !important;
  }
  
  .featured-title {
    font-size: 18px !important;
  }
  
  .featured-description {
    font-size: 13px !important;
  }
  
  .publication-title {
    font-size: 13px !important;
  }
  
  .publication-description {
    font-size: 13px !important;
  }
  
  .featured-image img {
    height: 200px !important;
  }
  
  .publication-image {
    height: 150px !important;
  }
  
  .year-btn {
    padding: 6px 12px !important;
    font-size: 0.8rem !important;
  }
}

/* Footer Navigation */
</style>
