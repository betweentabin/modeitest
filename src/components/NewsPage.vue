<template>
  <div class="page-container">
    <Navigation />
    
    <!-- Hero Section -->
    <HeroSection 
      title="お知らせ"
      subtitle="information"
      heroImage="/img/hero-image.png"
    />
    
    <!-- Breadcrumbs -->
    <Breadcrumbs :breadcrumbs="['お知らせ']" />

    <div class="page-content">
      <div class="news-header">
        <h2 class="section-title">お知らせ</h2>
        <div class="title-decoration">
          <div class="line-left"></div>
          <span class="title-english">information</span>
          <div class="line-right"></div>
        </div>
      </div>

      <div class="news-container">
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
        
        <!-- モバイル用プルダウンメニュー -->
        <div class="news-categories-mobile">
          <select 
            v-model="selectedCategory" 
            @change="filterCategory(selectedCategory)"
            class="category-select"
          >
            <option value="all">全て</option>
            <option value="research">ちくぎん地域経済レポート</option>
            <option value="quarterly">ちくぎん地域経済レポート</option>
            <option value="special">ちくぎん地域経済レポート</option>
            <option value="free">ちくぎん地域経済レポート</option>
          </select>
        </div>

        <div class="news-list" v-if="!loading">
        <article 
          v-for="(item, index) in filteredNews" 
          :key="item.id"
          class="news-item"
          @click="goToNewsDetail(item.id)"
          style="cursor: pointer;"
        >
                     <div class="news-meta">
             <span class="news-date">{{ formatDate(item.date) }}</span>
             <span :class="['news-category', getCategoryClass(item.category)]">
               {{ getCategoryLabel(item.category) }}
             </span>
             <h3 class="news-title">{{ item.title }}</h3>
           </div>
                       <div class="news-content">
              <div class="news-arrow">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                  <circle cx="12" cy="12" r="11" fill="#DA5761"/>
                  <path d="M9 7L15 12L9 17" stroke="white" stroke-width="2" fill="none"/>
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
            <button 
              class="pagination-btn" 
              :class="{ active: currentPage === 1 }"
              @click="changePage(1)"
            >
              1
            </button>
            <button 
              class="pagination-btn" 
              :class="{ active: currentPage === 2 }"
              @click="changePage(2)"
            >
              2
            </button>
            <button 
              class="pagination-btn" 
              :class="{ active: currentPage === 3 }"
              @click="changePage(3)"
            >
              3
            </button>
            <span class="pagination-dots">...</span>
            <button 
              class="pagination-btn" 
              :class="{ active: currentPage === 10 }"
              @click="changePage(10)"
            >
              10
            </button>
            <button 
              class="pagination-btn next-btn"
              @click="changePage(currentPage + 1)"
              :disabled="currentPage >= 10"
            >
              最後
            </button>
          </div>
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
import apiClient from '../services/apiClient.js';
import { frame132131753022Data } from "../data.js";

export default {
  name: "NewsPage",
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
        // まずmockServerから取得を試みる
        try {
          const allNews = await mockServer.getAllNews();
          
          if (allNews && allNews.length > 0) {
            this.newsItems = allNews.map(item => ({
              id: item.id,
              date: item.date,
              category: item.category || item.type || 'notice',
              title: item.title,
              description: item.description || item.content,
              type: item.type || item.category || 'notice'
            }));
            this.totalPages = Math.ceil(this.newsItems.length / 10);
            this.totalItems = this.newsItems.length;
            return;
          }
        } catch (mockError) {
          console.log('MockServer failed, trying API');
        }
        
        // APIから取得
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
         'publication': 'seminar',
         'notice': 'seminar',
         'research': 'seminar',
         'quarterly': 'seminar',
         'special': 'seminar',
         'free': 'seminar'
       };
       return classes[category] || 'seminar';
     },
    goToNewsDetail(newsId) {
      this.$router.push(`/news/${newsId}`);
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

.page-container {
  min-height: 100vh;
  background-color: #ECECEC;
}



/* Page Content */
.page-content {
  width: 100%;
  margin: 0 auto;
  padding: 70px 50px;
  box-shadow: none;
}

.news-header {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 29px;
  margin-bottom: 40px;
}

.section-title {
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
  justify-content: center;
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
}

/* News Container */
.news-container {
  background: white;
  padding: 50px;
  max-width: 1500px;
  margin: 0 auto;
  border-radius: 15px;
}

/* Categories */
.news-categories {
  display: flex;
  justify-content: center;
  gap: 0;
  margin-bottom: 40px;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: none;
  width: 100%;
}

.news-categories-mobile {
  display: none;
  margin-bottom: 40px;
  width: 100%;
}

.category-select {
  width: 100%;
  max-width: 300px;
  padding: 15px 20px;
  border: 2px solid #F6D5D8;
  border-radius: 8px;
  background: #F6D5D8;
  font-size: 16px;
  color: #1A1A1A;
  cursor: pointer;
  outline: none;
  margin: 0 0 0 auto;
  display: block;
}

.category-select:focus {
  border-color: #da5761;
  box-shadow: 0 0 0 2px rgba(218, 87, 97, 0.2);
}

.category-select option {
  background: white;
  color: #1A1A1A;
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
  box-sizing: border-box;
  width: 0;
  min-width: 0;
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
  margin-bottom: 40px;
}

.news-item {
  display: flex;
  padding: 20px 20px;
  align-items: center;
  gap: 50px;
  width: 100%;
  background: transparent;
  border: none;
  border-radius: 0;
  overflow: visible;
  transition: none;
  cursor: pointer;
  border-bottom: 0.5px dashed #DA5761;
}

.news-item:first-child {
  border-top: 0.5px dashed #DA5761;
}

.news-item:hover {
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
  transform: translateY(-2px);
}

.news-meta {
  display: flex;
  flex-direction: row;
  justify-content: center;
  align-items: center;
  gap: 20px;
  border-radius: 5px;
  flex: 1;
}

.news-date {
  color: #1A1A1A;
  font-family: 'Inter', sans-serif;
  font-size: 18px;
  font-weight: 400;
  line-height: 150%;
}

.news-category {
  padding: 4px 12px;
  border-radius: 15px;
  font-size: 0.8rem;
  font-weight: 500;
  color: white;
}

.news-category.seminar {
  background: #da5761;
  color: white;
  padding: 5px 25px;
  border-radius: 5px;
  font-size: 0.8rem;
  font-weight: 500;
}

.news-title {
  color: var(--color-secondary);
  font-family: 'Inter', sans-serif;
  font-size: 18px;
  font-weight: 400;
  line-height: normal;
  margin: 0;
  flex: 1;
}

.news-content {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.news-content h3 {
  color: var(--color-secondary);
  font-family: 'Inter', sans-serif;
  font-size: 18px;
  font-weight: 400;
  line-height: normal;
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



/* Responsive Design */
@media (max-width: 1200px) {
  .page-content {
    padding: 40px 30px;
  }
  
  .news-categories {
    display: none;
  }
  
  .news-categories-mobile {
    display: block;
  }
}

@media (max-width: 900px) {
  .company-profile {
    overflow-x: hidden;
  }

  .news-container {
    padding: 20px 20px !important;
  }
  
  .page-content {
    padding: 30px 20px;
  }
  
  .news-categories {
    flex-direction: column;
    gap: 10px;
  }
  
  .category-btn {
    width: 100%;
    border-right: none;
    border-bottom: 1px solid #DA5761;
  }
  
  .category-btn:last-child {
    border-bottom: none;
  }
  
  .news-item {
    flex-direction: row;
    gap: 20px;
    align-items: center;
    padding: 30px 0px;
  }
  
  .news-meta {
    flex-direction: column;
    gap: 15px;
    align-items: flex-start;
    width: 100%;
  }
  
  .news-title {
    font-size: 18px !important;
  }
  
  .news-date {
    font-size: 16px !important;
  }
  
  .news-category {
    font-size: 12px !important;
  }

  .news-categories-mobile {
    margin-bottom: 30px;
  }
}

@media (max-width: 768px) {
  .hero-title {
    font-size: 2rem;
  }
  
  .page-content {
    padding: 40px 15px;
  }
  
  .news-categories {
    flex-wrap: nowrap;
    gap: 0;
  }
  
  .category-btn {
    padding: 8px 10px;
    font-size: 0.6rem;
    border-right: 1px solid #DA5761;
    border-radius: 0;
    margin-bottom: 0;
    min-width: 0;
    flex: 1;
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
  .page-content {
    padding: 20px 15px;
  }
  
  .news-categories {
    padding: 20px 15px;
  }

  .category-select {
    width: 100%;
    max-width: 100%;
  }

  .news-container {
    padding: 20px 20px !important;
  }
  
  .category-btn {
    padding: 15px 20px;
    font-size: 14px !important;
  }

  .news-content {
    padding: 0;
    gap: 10px;
  }
  
  .news-item {
    padding: 10px 0;
    gap: 10px;
  }
  
  .news-meta {
    padding: 15px 0;
  }
  
  .news-title {
    font-size: 16px !important;
  }
  
  .news-date {
    font-size: 14px !important;
  }
  
  .news-category {
    font-size: 11px !important;
  }
  
  .news-content h3 {
    font-size: 0.9rem;
  }

  .news-categories-mobile {
    margin-bottom: 20px;
  }
}


</style>