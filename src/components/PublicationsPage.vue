<template>
  <div class="page-container">
    <Navigation />
    
    <!-- Hero Section -->
    <div class="hero-section">
      <div class="hero-overlay">
        <div class="hero-content">
          <h1 class="hero-title">刊行物</h1>
          <p class="hero-subtitle">publications</p>
        </div>
      </div>
    </div>

    <div class="page-content">
      <!-- Publications Header -->
      <div class="publications-header">
        <h2 class="section-title">刊行物</h2>
        <p class="section-subtitle">publications</p>
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
      </div>

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

      <!-- Featured Publication -->
      <div class="featured-publication" v-if="featuredPublication">
        <div class="featured-content">
          <div class="featured-image">
            <img src="/img/image-1.png" alt="経営戦略に関する書籍" />
          </div>
          <div class="featured-info">
            <div class="featured-meta">
              <span class="featured-year">2024年</span>
              <span class="featured-category">経営戦略支援の会員限定</span>
            </div>
            <h3 class="featured-title">経営戦略に関する書籍</h3>
            <div class="featured-details">
              <p><strong>【著者】</strong> ちくぎん地域経済研究所</p>
              <p><strong>【発行】</strong> 株式会社ちくぎん地域経済研究所</p>
              <p><strong>【詳細】</strong> 2024年度版 ちくぎん地域経済レポート</p>
              <p><strong>【キーワード】</strong> 経営戦略、地域経済、企業分析について</p>
            </div>
            <button class="download-btn">入会してダウンロード</button>
          </div>
        </div>
      </div>

      <!-- Publications Grid -->
      <div class="publications-grid" v-if="!loading">
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
              <span class="publication-year">{{ publication.year }}年</span>
              <span class="publication-category">{{ getCategoryName(publication.category) }}</span>
            </div>
            <h3 class="publication-title">{{ publication.title }}</h3>
            <button class="publication-download">入会してダウンロード</button>
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
          <button class="action-btn register-btn" @click="goToRegister">入会はコチラ</button>
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

    <FooterComplete />
  </div>
</template>

<script>
import Navigation from "./Navigation.vue";
import FooterComplete from "./FooterComplete.vue";
import apiClient from '../services/apiClient.js';

export default {
  name: "PublicationsPage",
  components: {
    Navigation,
    FooterComplete
  },
  data() {
    return {
      loading: true,
      selectedYear: 2024,
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
        title: '経営戦略に関する書籍',
        year: 2024,
        category: 'economics',
        author: 'ちくぎん地域経済研究所',
        publisher: '株式会社ちくぎん地域経済研究所',
        description: '2024年度版 ちくぎん地域経済レポート',
        keywords: '経営戦略、地域経済、企業分析について',
        image: '/img/image-1.png'
      },
      publications: [
        {
          id: 2,
          title: 'メンバーの共有状況にもとづく一冊刊行（約７）ページ',
          year: 2024,
          category: 'economics',
          image: '/img/image-1.png'
        },
        {
          id: 3,
          title: 'メンバーの共有状況にもとづく一冊刊行（約７）ページ',
          year: 2024,
          category: 'quarterly',
          image: '/img/image-1.png'
        },
        {
          id: 4,
          title: 'メンバーの共有状況にもとづく一冊刊行（約７）ページ',
          year: 2024,
          category: 'special',
          image: '/img/image-1.png'
        },
        {
          id: 5,
          title: 'メンバーの共有状況にもとづく一冊刊行（約７）ページ',
          year: 2024,
          category: 'free',
          image: '/img/image-1.png'
        },
        {
          id: 6,
          title: 'メンバーの共有状況にもとづく一冊刊行（約７）ページ',
          year: 2023,
          category: 'economics',
          image: '/img/image-1.png'
        },
        {
          id: 7,
          title: 'メンバーの共有状況にもとづく一冊刊行（約７）ページ',
          year: 2023,
          category: 'quarterly',
          image: '/img/image-1.png'
        },
        {
          id: 8,
          title: 'メンバーの共有状況にもとづく一冊刊行（約７）ページ',
          year: 2023,
          category: 'special',
          image: '/img/image-1.png'
        },
        {
          id: 9,
          title: 'メンバーの共有状況にもとづく一冊刊行（約７）ページ',
          year: 2023,
          category: 'free',
          image: '/img/image-1.png'
        },
        {
          id: 10,
          title: 'メンバーの共有状況にもとづく一冊刊行（約７）ページ',
          year: 2022,
          category: 'economics',
          image: '/img/image-1.png'
        },
        {
          id: 11,
          title: 'メンバーの共有状況にもとづく一冊刊行（約７）ページ',
          year: 2022,
          category: 'quarterly',
          image: '/img/image-1.png'
        },
        {
          id: 12,
          title: 'メンバーの共有状況にもとづく一冊刊行（約７）ページ',
          year: 2022,
          category: 'special',
          image: '/img/image-1.png'
        }
      ]
    };
  },
  async mounted() {
    await this.loadPublications();
  },
  computed: {
    filteredPublications() {
      return this.publications.filter(pub => {
        const yearMatch = pub.year === this.selectedYear;
        const categoryMatch = this.selectedCategory === 'all' || pub.category === this.selectedCategory;
        return yearMatch && categoryMatch;
      });
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
        
        const response = await apiClient.getPublications(params);
        
        if (response.success && response.data) {
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
      this.$router.push(`/publications/${publicationId}`);
    },
    scrollToContact() {
      this.$router.push('/contact');
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

.publications-header {
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

/* Category Filter */
.category-filter {
  display: flex;
  justify-content: center;
  gap: 0;
  margin-bottom: 40px;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.category-btn {
  background: #f8f9fa;
  border: none;
  padding: 15px 20px;
  cursor: pointer;
  transition: all 0.3s;
  font-size: 0.8rem;
  color: #666;
  border-right: 1px solid #dee2e6;
  white-space: nowrap;
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
  flex: 0 0 200px;
}

.featured-image img {
  width: 100%;
  height: 250px;
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
  background: #333;
  color: white;
  border: none;
  padding: 12px 25px;
  border-radius: 25px;
  cursor: pointer;
  font-size: 0.9rem;
  transition: all 0.3s;
  font-weight: 500;
}

.download-btn:hover {
  background: #555;
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

/* Publications Grid */
.publications-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  gap: 20px;
  margin-bottom: 60px;
}

.publication-card {
  background: white;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
  transition: all 0.3s;
  cursor: pointer;
}

.publication-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 25px rgba(0,0,0,0.15);
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
  padding: 20px;
}

.publication-meta {
  display: flex;
  gap: 10px;
  margin-bottom: 15px;
}

.publication-year {
  background: #28a745;
  color: white;
  padding: 3px 10px;
  border-radius: 12px;
  font-size: 0.75rem;
  font-weight: 500;
}

.publication-category {
  background: #da5761;
  color: white;
  padding: 3px 10px;
  border-radius: 12px;
  font-size: 0.75rem;
  font-weight: 500;
}

.publication-title {
  font-size: 1rem;
  color: #333;
  margin-bottom: 15px;
  font-weight: 500;
  line-height: 1.4;
}

.publication-download {
  background: #333;
  color: white;
  border: none;
  padding: 8px 20px;
  border-radius: 20px;
  cursor: pointer;
  font-size: 0.8rem;
  transition: all 0.3s;
  font-weight: 500;
}

.publication-download:hover {
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

.register-btn {
  background: #8B0000;
  color: white;
}

.register-btn:hover {
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
  
  .category-filter {
    flex-wrap: wrap;
    gap: 5px;
  }
  
  .category-btn {
    padding: 10px 15px;
    font-size: 0.7rem;
    border-right: none;
    border-radius: 15px;
    margin-bottom: 5px;
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
  
  .publications-grid {
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 15px;
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
  .publications-grid {
    grid-template-columns: 1fr;
  }
  
  .featured-image img {
    height: 200px;
  }
  
  .publication-image {
    height: 150px;
  }
  
  .year-btn {
    padding: 6px 12px;
    font-size: 0.8rem;
  }
}
</style>