<template>
  <div class="page-container">
    <Navigation />
    
    <!-- Hero Section -->
    <HeroSection 
      title="刊行物"
      subtitle="publications"
      heroImage="/img/hero-image.png"
    />
    
    <!-- Breadcrumbs -->
    <Breadcrumbs :breadcrumbs="['刊行物']" />

    <div class="page-content">
      <!-- Publications Header -->
      <div class="publications-header">
        <h2 class="page-title">刊行物</h2>
        <div class="title-decoration">
          <div class="line-left"></div>
          <span class="title-english">publications public</span>
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

        <!-- Category Filter -->
        <div class="category-filter">
          <button 
            v-for="category in categories" 
            :key="category.id"
            :class="['category-btn', { active: selectedCategory === category.id }]"
            @click="selectCategory(category.id)"
          >
            {{ category.name }}
          </button>
        </div>
      </div>

      <!-- Featured Publication -->
      <div class="featured-publication" v-if="featuredPublication">
        <div class="featured-content">
          <div class="featured-image">
            <img src="/img/image-1.png" alt="一般向け刊行物" />
          </div>
          <div class="featured-info">
            <div class="featured-meta">
              <span class="featured-year">2025.4.28</span>
              <span class="featured-category">一般公開</span>
            </div>
            <div class="featured-details">
              <div class="past-info-row">
                <div class="info-label info-label-author">
                  <span class="label-text">著者</span>
                </div>
                <div class="info-value">{{ featuredPublication.author }}</div>
              </div>
              <div class="past-info-row">
                <div class="info-label info-label-publisher">
                  <span class="label-text">出版社</span>
                </div>
                <div class="info-value">{{ featuredPublication.publisher }}</div>
              </div>
              <div class="past-info-row">
                <div class="info-label info-label-description">
                  <span class="label-text">概要</span>
                </div>
                <div class="info-value">{{ featuredPublication.description }}</div>
              </div>
              <div class="past-info-row">
                <div class="info-label info-label-keywords">
                  <span class="label-text">キーワード</span>
                </div>
                <div class="info-value">{{ featuredPublication.keywords }}</div>
              </div>
            </div>

            <button class="download-btn">入会してダウンロード
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
                <span class="featured-category">一般公開</span>
                <span class="featured-year">{{ publication.year }}.4.28</span>
              </div>
              <h3 class="publication-title">{{ publication.title }}</h3>
              <button class="publication-download">入会してダウンロード
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

    <!-- button Section -->
    <div class="button-section">
      <div class="button-container">
        <button class="cta-button primary">
          <span class="button-text">お問い合わせはコチラ</span>
          <div class="arrow-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <rect width="24" height="24" rx="4" fill="#FFFFFF"/>
              <path d="M9.5 6L15.5 12L9.5 18" stroke="#DA5761" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
        </button>
        <button class="cta-button secondary">
          <span class="button-text">入会はコチラ</span>
          <div class="arrow-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <rect width="24" height="24" rx="4" fill="#FFFFFF"/>
              <path d="M9.5 6L15.5 12L9.5 18" stroke="#9C3940" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
        </button>
      </div>
    </div>

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
import { frame132131753022Data } from "../data.js";
import apiClient from '../services/apiClient.js';
import mockServer from '@/mockServer';

export default {
  name: "PublicationsPublicPage",
  components: {
    Navigation,
    Footer,
    Group27,
    HeroSection,
    Breadcrumbs,
    ContactSection,
    AccessSection,
    FixedSideButtons
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
        { id: 'economics', name: 'ちくぎん地域経済レポート' },
        { id: 'quarterly', name: 'ちくぎん地域経済レポート' },
        { id: 'special', name: 'ちくぎん地域経済レポート' },
        { id: 'free', name: 'ちくぎん地域経済レポート' }
      ],
      featuredPublication: {
        id: 1,
        title: '一般向け刊行物',
        year: 2024,
        category: 'economics',
        author: 'ちくぎん地域経済研究所',
        publisher: '株式会社ちくぎん地域経済研究所',
        description: '2024年度版 一般向け地域経済レポート',
        keywords: '地域経済、一般公開、経済分析について',
        image: '/img/image-1.png'
      },
      publications: [
        {
          id: 2,
          title: '一般向け刊行物（約７）ページ',
          year: 2024,
          category: 'economics',
          image: '/img/image-1.png'
        },
        {
          id: 3,
          title: '一般向け刊行物（約７）ページ',
          year: 2024,
          category: 'quarterly',
          image: '/img/image-1.png'
        },
        {
          id: 4,
          title: '一般向け刊行物（約７）ページ',
          year: 2024,
          category: 'special',
          image: '/img/image-1.png'
        },
        {
          id: 5,
          title: '一般向け刊行物（約７）ページ',
          year: 2024,
          category: 'free',
          image: '/img/image-1.png'
        },
        {
          id: 6,
          title: '一般向け刊行物（約７）ページ',
          year: 2023,
          category: 'economics',
          image: '/img/image-1.png'
        },
        {
          id: 7,
          title: '一般向け刊行物（約７）ページ',
          year: 2023,
          category: 'quarterly',
          image: '/img/image-1.png'
        },
        {
          id: 8,
          title: '一般向け刊行物（約７）ページ',
          year: 2023,
          category: 'special',
          image: '/img/image-1.png'
        },
        {
          id: 9,
          title: '一般向け刊行物（約７）ページ',
          year: 2023,
          category: 'free',
          image: '/img/image-1.png'
        },
        {
          id: 10,
          title: '一般向け刊行物（約７）ページ',
          year: 2022,
          category: 'economics',
          image: '/img/image-1.png'
        },
        {
          id: 11,
          title: '一般向け刊行物（約７）ページ',
          year: 2022,
          category: 'quarterly',
          image: '/img/image-1.png'
        },
        {
          id: 12,
          title: '一般向け刊行物（約７）ページ',
          year: 2022,
          category: 'special',
          image: '/img/image-1.png'
        },
        {
          id: 13,
          title: '一般向け刊行物（約７）ページ',
          year: 2022,
          category: 'free',
          image: '/img/image-1.png'
        },
        {
          id: 14,
          title: '一般向け刊行物（約７）ページ',
          year: 2021,
          category: 'economics',
          image: '/img/image-1.png'
        },
        {
          id: 15,
          title: '一般向け刊行物（約７）ページ',
          year: 2021,
          category: 'quarterly',
          image: '/img/image-1.png'
        },
        {
          id: 16,
          title: '一般向け刊行物（約７）ページ',
          year: 2021,
          category: 'special',
          image: '/img/image-1.png'
        },
        {
          id: 17,
          title: '一般向け刊行物（約７）ページ',
          year: 2021,
          category: 'free',
          image: '/img/image-1.png'
        },
        {
          id: 18,
          title: '一般向け刊行物（約７）ページ',
          year: 2020,
          category: 'economics',
          image: '/img/image-1.png'
        },
        {
          id: 19,
          title: '一般向け刊行物（約７）ページ',
          year: 2020,
          category: 'quarterly',
          image: '/img/image-1.png'
        },
        {
          id: 20,
          title: '一般向け刊行物（約７）ページ',
          year: 2020,
          category: 'special',
          image: '/img/image-1.png'
        },
        {
          id: 21,
          title: '一般向け刊行物（約７）ページ',
          year: 2020,
          category: 'free',
          image: '/img/image-1.png'
        },
        {
          id: 22,
          title: '一般向け刊行物（約７）ページ',
          year: 2019,
          category: 'economics',
          image: '/img/image-1.png'
        },
        {
          id: 23,
          title: '一般向け刊行物（約７）ページ',
          year: 2019,
          category: 'quarterly',
          image: '/img/image-1.png'
        },
        {
          id: 24,
          title: '一般向け刊行物（約７）ページ',
          year: 2019,
          category: 'special',
          image: '/img/image-1.png'
        }
      ]
    };
  },
  computed: {
    filteredPublications() {
      let filtered = this.publications;
      
      // Year filter
      if (this.selectedYear !== 'all') {
        filtered = filtered.filter(pub => pub.year === this.selectedYear);
      }
      
      // Category filter
      if (this.selectedCategory !== 'all') {
        filtered = filtered.filter(pub => pub.category === this.selectedCategory);
      }
      
      return filtered.slice(0, 12);
    }
  },
  mounted() {
    this.loadPublications();
  },
  methods: {
    async loadPublications() {
      this.loading = true;
      try {
        // まずmockServerから取得を試みる
        try {
          const allPublications = await mockServer.getPublications();
          
          if (allPublications && allPublications.length > 0) {
            // 無料公開の刊行物のみフィルタリング
            const freePublications = allPublications.filter(item => 
              item.membership_level === 'free' || item.membershipLevel === 'free' || !item.membership_level
            );
            
            this.publications = freePublications.map(item => ({
              id: item.id,
              title: item.title,
              image: item.cover_image || item.image_url || '/img/-----2-2-4.png',
              description: item.description,
              category: item.category || 'special',
              publish_date: item.publication_date,
              author: item.author || 'ちくぎん地域経済研究所',
              pages: item.pages,
              file_size: item.file_size,
              download_count: item.download_count,
              is_published: item.is_published,
              membershipLevel: 'free'
            }));
            this.totalPages = Math.ceil(this.publications.length / 12);
            return;
          }
        } catch (mockError) {
          console.log('MockServer failed, trying API');
        }
        
        // APIから取得
        const params = {
          page: this.currentPage,
          year: this.selectedYear !== 'all' ? this.selectedYear : null,
          category: this.selectedCategory !== 'all' ? this.selectedCategory : null
        }
        
        const response = await apiClient.getPublications(params);
        
        if (response && response.success && response.data && response.data.publications) {
          this.publications = response.data.publications.map(item => this.formatPublicationItem(item));
          this.totalPages = response.data.pagination.total_pages;
        } else {
          // フォールバック: 既存データを使用
          console.log('APIからデータを取得できませんでした。フォールバックデータを使用します。');
        }
      } catch (err) {
        console.error('刊行物の読み込みに失敗しました:', err);
        this.error = '刊行物の読み込みに失敗しました。';
        // フォールバック: 既存データを使用
      } finally {
        this.loading = false;
      }
    },
    
    formatPublicationItem(item) {
      return {
        id: item.id,
        title: item.title,
        year: new Date(item.publication_date).getFullYear(),
        category: item.category,
        image: item.cover_image || '/img/image-1.png',
        description: item.description,
        author: item.author,
        pages: item.pages,
        is_downloadable: item.is_downloadable,
        members_only: item.members_only
      };
    },
    
    async downloadPublication(publicationId) {
      try {
        const response = await apiClient.downloadPublication(publicationId);
        if (response.success && response.data.download_url) {
          // ダウンロードリンクを開く
          window.open(response.data.download_url, '_blank');
        }
      } catch (err) {
        console.error('ダウンロードに失敗しました:', err);
        alert('ダウンロードに失敗しました。');
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
      return category ? category.name : 'ちくぎん地域経済レポート';
    },
    goToPublicationDetail(publicationId) {
      this.$router.push(`/publications-public/${publicationId}`);
    },
    goToContact() {
      this.$router.push('/contact');
    },
    goToRegister() {
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
  margin-bottom: 20px;
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
  margin: 0 auto 30px;
}

.filter-download-btn:hover {
  background: var(--color-secondary);
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
  justify-content: center;
  gap: 0;
  border-radius: 8px;
  overflow: hidden;
  width: 100%;
}

.category-btn {
  background: #F6D5D8;
  border: none;
  padding: 15px 20px;
  cursor: pointer;
  transition: all 0.3s;
  font-size: 0.8rem;
  color: #666;
  border-right: 1px solid #DA5761;
  white-space: nowrap;
  flex: 1;
}

.category-btn:last-child {
  border-right: none;
}

.category-btn.active,
.category-btn:hover {
  background: #da5761;
  color: white;
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
  min-height: 300px;
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
  gap: 0;
  width: 100%;
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

/* Button Section */
.button-section {
  background: #ECECEC;
  padding: 50px 50px 70px 50px;
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
}

.button-container {
  display: flex;
  flex-direction: column;
  gap: 20px;
  align-items: center;
  width: 100%;
  max-width: 2000px;
}

.cta-button {
  width: 300px;
  padding: 20px 40px;
  border: none;
  border-radius: 10px;
  font-family: 'Inter', Helvetica, sans-serif;
  font-size: 18px;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.3s ease;
  text-align: center;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 30px;
}

.button-text {
  width: auto;
  text-align: center;
}

.arrow-icon {
  flex-shrink: 0;
  display: flex;
  align-items: center;
  justify-content: center;
}

.cta-button.primary {
  background-color: #DA5761;
  color: #FFFFFF;
  width: 100%;
}

.cta-button.primary:hover {
  background-color: #c44a54;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(218, 87, 97, 0.3);
}

.cta-button.secondary {
  background-color: #9C3940;
  color: #FFFFFF;
  width: 100%;
}

.cta-button.secondary:hover {
  background-color: #8a3238;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(156, 57, 64, 0.3);
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
