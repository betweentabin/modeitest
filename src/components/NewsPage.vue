<template>
  <div class="page-container">
    <Navigation />
    
    <!-- Hero Section -->
    <div class="hero-section">
      <div class="hero-overlay">
        <div class="hero-content">
          <h1 class="hero-title">お知らせ</h1>
          <p class="hero-subtitle">information</p>
        </div>
      </div>
    </div>

    <div class="page-content">
      <div class="news-header">
        <h2 class="section-title">お知らせ</h2>
        <p class="section-subtitle">information</p>
      </div>

      <div class="news-categories">
        <button 
          :class="['category-btn', { active: selectedCategory === 'all' }]" 
          @click="filterCategory('all')"
        >
          全て
        </button>
        <button 
          :class="['category-btn', { active: selectedCategory === 'research' }]" 
          @click="filterCategory('research')"
        >
          ちくぎん地域経済レポート
        </button>
        <button 
          :class="['category-btn', { active: selectedCategory === 'quarterly' }]" 
          @click="filterCategory('quarterly')"
        >
          ちくぎん地域経済レポート
        </button>
        <button 
          :class="['category-btn', { active: selectedCategory === 'special' }]" 
          @click="filterCategory('special')"
        >
          ちくぎん地域経済レポート
        </button>
        <button 
          :class="['category-btn', { active: selectedCategory === 'free' }]" 
          @click="filterCategory('free')"
        >
          ちくぎん地域経済レポート
        </button>
      </div>

      <div class="news-list" v-if="!loading">
        <article 
          v-for="(item, index) in filteredNews" 
          :key="item.id"
          class="news-item"
          @click="goToNewsDetail(item.id)"
        >
          <div class="news-meta">
            <span class="news-date">{{ formatDate(item.date) }}</span>
            <span :class="['news-category', getCategoryClass(item.category)]">
              {{ getCategoryLabel(item.category) }}
            </span>
          </div>
          <div class="news-content">
            <h3>{{ item.title }}</h3>
            <div class="news-arrow">
              <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                <path d="M7.5 5L12.5 10L7.5 15" stroke="currentColor" stroke-width="2" fill="none"/>
              </svg>
            </div>
          </div>
        </article>
      </div>

      <div v-if="loading" class="loading">
        読み込み中...
      </div>

      <!-- Pagination -->
      <div class="pagination">
        <span class="page-info">1 2 3 .... 10 最後</span>
      </div>
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
  name: "NewsPage",
  components: {
    Navigation,
    FooterComplete
  },
  data() {
    return {
      currentPage: 1,
      totalPages: 1,
      selectedCategory: 'all',
      newsItems: [],
      loading: false,
      error: null,
      totalItems: 0
    };
  },
  async mounted() {
    await this.loadNews()
  },
  methods: {
    async loadNews() {
      this.loading = true
      try {
        const params = {
          page: this.currentPage,
          per_page: 10
        }
        
        if (this.selectedCategory && this.selectedCategory !== 'all') {
          params.category = this.selectedCategory
        }
        
        const response = await apiClient.getNews(params)
        
        if (response.success && response.data) {
          this.newsItems = response.data.news.map(item => this.formatNewsItem(item))
          this.totalPages = response.data.pagination.total_pages
          this.totalItems = response.data.pagination.total_items
        } else {
          this.loadFallbackNews()
        }
      } catch (err) {
        console.error('ニュースの読み込みに失敗しました:', err)
        this.error = 'ニュースの読み込みに失敗しました。'
        this.loadFallbackNews()
      } finally {
        this.loading = false
      }
    },
    
    formatNewsItem(item) {
      return {
        id: item.id,
        date: item.published_date,
        category: item.category,
        title: item.title,
        description: item.description,
        type: item.type
      }
    },
    
    async loadFallbackNews() {
      // フォールバック: 既存のモックデータから生成
      this.newsItems = [
        {
          id: 1,
          date: '2025-05-12',
          category: 'seminar',
          title: '採用力強化！経営・人事向け　面接官トレーニングセミナー',
          description: '優秀な人材を見極め、獲得するための面接技術を習得できるセミナーを開催します。',
          type: 'seminar'
        },
        {
          id: 2,
          date: '2025-05-12',
          category: 'publication',
          title: 'HOT infomation Vol.319掲載しました！',
          description: '最新の経済動向と地域企業の動きをまとめました。',
          type: 'publication'
        },
        {
          id: 3,
          date: '2025-05-12',
          category: 'publication',
          title: 'Hot Information Vol.318掲載しました！',
          description: '地域経済の最新情報をお届けします。',
          type: 'publication'
        }
      ]
    },
    async changePage(page) {
      if (page >= 1 && page <= this.totalPages) {
        this.currentPage = page;
        await this.loadNews();
      }
    },
    async filterCategory(category) {
      this.selectedCategory = category;
      this.currentPage = 1; // リセット
      await this.loadNews();
    },
    formatDate(dateString) {
      const date = new Date(dateString);
      const year = date.getFullYear();
      const month = String(date.getMonth() + 1).padStart(2, '0');
      const day = String(date.getDate()).padStart(2, '0');
      return `${year}.${month}.${day}`;
    },
    getCategoryLabel(category) {
      const labels = {
        'seminar': 'セミナー',
        'publication': 'カテゴリ1',
        'notice': 'カテゴリ1',
        'research': 'カテゴリ1',
        'quarterly': 'カテゴリ1',
        'special': 'カテゴリ1',
        'free': 'カテゴリ1'
      };
      return labels[category] || 'カテゴリ1';
    },
    getCategoryClass(category) {
      const classes = {
        'seminar': 'seminar',
        'publication': 'category1',
        'notice': 'category1',
        'research': 'category1',
        'quarterly': 'category1',
        'special': 'category1',
        'free': 'category1'
      };
      return classes[category] || 'category1';
    },
    goToNewsDetail(newsId) {
      this.$router.push(`/news/${newsId}`);
    },
    scrollToContact() {
      this.$router.push('/contact');
    }
  },
  computed: {
    filteredNews() {
      if (this.selectedCategory === 'all') {
        return this.newsItems
      }
      return this.newsItems.filter(item => item.category === this.selectedCategory)
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

.news-header {
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

/* Categories */
.news-categories {
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

/* News List */
.news-list {
  max-width: 800px;
  margin: 0 auto 40px;
}

.news-item {
  background: white;
  border: 1px solid #dee2e6;
  border-radius: 8px;
  margin-bottom: 10px;
  overflow: hidden;
  transition: all 0.3s;
  cursor: pointer;
}

.news-item:hover {
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
  transform: translateY(-2px);
}

.news-meta {
  display: flex;
  align-items: center;
  gap: 15px;
  padding: 15px 20px 0;
}

.news-date {
  font-size: 0.9rem;
  color: #666;
  font-weight: 500;
}

.news-category {
  padding: 4px 12px;
  border-radius: 15px;
  font-size: 0.8rem;
  font-weight: 500;
  color: white;
}

.news-category.category1 {
  background: #da5761;
}

.news-category.seminar {
  background: #28a745;
}

.news-content {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 10px 20px 15px;
}

.news-content h3 {
  font-size: 1rem;
  color: #333;
  font-weight: 500;
  flex: 1;
}

.news-arrow {
  color: #da5761;
  margin-left: 15px;
  transition: transform 0.3s;
}

.news-item:hover .news-arrow {
  transform: translateX(5px);
}

.loading {
  text-align: center;
  padding: 40px;
  color: #666;
}

/* Pagination */
.pagination {
  text-align: center;
  margin-top: 40px;
}

.page-info {
  color: #da5761;
  font-size: 0.9rem;
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
  
  .news-categories {
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
  
  .news-content {
    flex-direction: column;
    align-items: flex-start;
    gap: 10px;
  }
  
  .news-arrow {
    margin-left: 0;
    align-self: flex-end;
  }
  
  .news-meta {
    flex-wrap: wrap;
    gap: 10px;
  }
}

@media (max-width: 480px) {
  .news-content h3 {
    font-size: 0.9rem;
  }
  
  .news-meta {
    padding: 10px 15px 0;
  }
  
  .news-content {
    padding: 10px 15px;
  }
}
</style>