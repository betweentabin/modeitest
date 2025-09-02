<template>
  <div class="page-container">
    <Navigation />
    
    <!-- Hero Section -->
    <HeroSection 
      title="ニュース詳細"
      subtitle="news detail"
      heroImage="/img/hero-image.png"
    />
    
    <!-- Breadcrumbs -->
    <Breadcrumbs :breadcrumbs="['ニュース', newsItem ? newsItem.title : '詳細']" />

    <div class="page-content">
      <div v-if="loading" class="loading-container">
        <div class="loading-message">読み込み中...</div>
      </div>
      
      <div v-else-if="error" class="error-container">
        <div class="error-message">{{ error }}</div>
        <button @click="$router.push('/news')" class="back-btn">ニュース一覧に戻る</button>
      </div>
      
             <div v-else-if="newsItem" class="detail-container">
         <!-- メインコンテンツ -->
        <div class="detail-content">
          <div class="detail-header">
              <!-- ニュース画像 -->
              <div v-if="newsItem.image" class="news-image">
                <img :src="newsItem.image" :alt="newsItem.title" />
              </div>
              
              <div class="news-meta">
               <span class="news-date">{{ formatDate(newsItem.date) }}</span>
               <span :class="getCategoryClass(newsItem.type)" class="category-badge">
                 {{ getCategoryLabel(newsItem.type) }}
               </span>
             </div>
            
              <h1 class="news-title">{{ newsItem.title }}</h1>
             
                <!-- 詳細説明 -->
               <div class="description-section">
                 <p class="description-text">{{ newsItem.description }}</p>
                 
                 <!-- 追加コンテンツ（originalItemから） -->
                 <div v-if="originalItem.content && originalItem.content !== newsItem.description" class="additional-content">
                   <p>{{ originalItem.content }}</p>
                 </div>
               </div>

             <!-- 一覧に戻るボタン -->
             <button @click="$router.push('/news')" class="filter-download-btn">一覧に戻る
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
import FixedActionButtons from "./FixedActionButtons.vue";
import HeroSection from "./HeroSection.vue";
import Breadcrumbs from "./Breadcrumbs.vue";
import ContactSection from "./ContactSection.vue";
import AccessSection from "./AccessSection.vue";
import FixedSideButtons from "./FixedSideButtons.vue";
import { frame132131753022Data } from "../data.js";
import mockServer from "@/mockServer";

export default {
  name: "NewsDetailPage",
  components: {
    Navigation,
    Footer,
    Group27,
    FixedActionButtons,
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
      error: '',
      newsItem: null,
      originalItem: null, // セミナー、刊行物、お知らせの元データ
      relatedNews: []
    };
  },
  async mounted() {
    await this.loadNewsDetail();
  },
  watch: {
    '$route'() {
      // ルートが変わったら再読み込み
      this.loadNewsDetail();
    }
  },
  methods: {
    async loadNewsDetail() {
      try {
        this.loading = true;
        this.error = '';
        
        const newsId = parseInt(this.$route.params.id);
        
                 // フォールバックデータを使用（NewsPage.vueと同じデータ）
         const fallbackNews = [
           {
             id: 1,
             date: '2025-05-12',
             category: 'seminar',
             title: '採用力強化！経営・人事向け　面接官トレーニングセミナー',
             description: '優秀な人材を見極め、獲得するための面接技術を習得できるセミナーを開催します。',
             type: 'seminar',
             image: '/img/hero-image.png'
           },
           {
             id: 2,
             date: '2025-05-12',
             category: 'publication',
             title: 'HOT infomation Vol.319掲載しました！',
             description: '最新の経済動向と地域企業の動きをまとめました。',
             type: 'publication',
             image: '/img/image-1@2x.png'
           },
           {
             id: 3,
             date: '2025-05-12',
             category: 'publication',
             title: 'Hot Information Vol.318掲載しました！',
             description: '地域経済の最新情報をお届けします。',
             type: 'publication',
             image: '/img/image-2@2x.png'
           }
         ];
        
        // 指定されたニュースを検索
        this.newsItem = fallbackNews.find(news => news.id === newsId);
        
        if (!this.newsItem) {
          this.error = 'ニュースが見つかりませんでした';
          return;
        }
        
        // 元データを取得（セミナー、刊行物、お知らせの詳細情報）
        await this.loadOriginalItem();
        
        // 関連ニュースを取得（同じカテゴリーの他のニュース）
        this.relatedNews = fallbackNews
          .filter(news => news.id !== newsId && news.type === this.newsItem.type)
          .slice(0, 3);
        
      } catch (err) {
        this.error = 'ニュースの詳細情報を取得できませんでした';
        console.error('News detail loading error:', err);
      } finally {
        this.loading = false;
      }
    },
    async loadOriginalItem() {
      try {
                 // フォールバックデータの詳細情報
         const fallbackDetails = {
           seminar: {
             id: 1,
             location: 'ちくぎん本店 会議室',
             capacity: 30,
             fee: 5000,
             status: 'recruiting',
             heading: '採用力強化！経営・人事向け　面接官トレーニングセミナー',
             content: '面接官として必要なスキルを習得し、優秀な人材を採用できるようになります。'
           },
           publication: {
             id: 2,
             author: 'ちくぎん地域経済研究所',
             pages: 24,
             file_size: 2.5,
             file_url: '#',
             heading: 'HOT infomation Vol.319掲載しました！',
             content: '地域経済の最新動向と企業の取り組みを詳しく解説しています。'
           }
         };
        
        // ニュースタイプに応じて詳細情報を設定
        if (fallbackDetails[this.newsItem.type]) {
          this.originalItem = fallbackDetails[this.newsItem.type];
        } else {
          this.originalItem = {};
        }
      } catch (err) {
        console.warn('元データの取得に失敗:', err);
        this.originalItem = {};
      }
    },
    formatDate(dateString) {
      const date = new Date(dateString);
      const year = date.getFullYear();
      const month = date.getMonth() + 1;
      const day = date.getDate();
      return `${year}.${String(month).padStart(2, '0')}.${String(day).padStart(2, '0')}`;
    },
    getCategoryLabel(type) {
      switch (type) {
        case 'seminar':
          return 'SEMINAR';
        case 'publication':
          return 'PUBLICATION';
        case 'notice':
          return 'NEWS';
        default:
          return 'NEWS';
      }
    },
    getCategoryClass(type) {
      switch (type) {
        case 'seminar':
          return 'seminar-category';
        case 'publication':
          return 'publication-category';
        case 'notice':
          return 'news-category';
        default:
          return 'news-category';
      }
    },
    getStatusText(status) {
      const statusMap = {
        'recruiting': '募集中',
        'scheduled': '開催予定',
        'ongoing': '開催中',
        'completed': '終了',
        'cancelled': '中止'
      };
      return statusMap[status] || status;
    },
    registerSeminar() {
      // セミナー申し込みページに遷移
      this.$router.push('/seminar-registration');
    },
    downloadPDF() {
      if (this.originalItem && this.originalItem.file_url) {
        window.open(this.originalItem.file_url, '_blank');
      } else {
        alert('PDFファイルが見つかりません');
      }
    },
    sharePage() {
      if (navigator.share) {
        navigator.share({
          title: this.newsItem.title,
          text: this.newsItem.description,
          url: window.location.href
        });
      } else {
        // フォールバック: URLをクリップボードにコピー
        navigator.clipboard.writeText(window.location.href).then(() => {
          alert('URLをクリップボードにコピーしました');
        });
      }
    },
    goToNews(newsId) {
      this.$router.push(`/news/${newsId}`);
    }
  }
};
</script>

<style scoped>
.page-container {
  min-height: 100vh;
  background-color: #f8f9fa;
}

.page-content {
  width: 100%;
  margin: 0 auto;
  padding: 70px 50px;
}

.loading-container,
.error-container {
  text-align: center;
  padding: 60px 20px;
}

.loading-message {
  font-size: 18px;
  color: #666;
}

.error-message {
  font-size: 18px;
  color: #dc3545;
  margin-bottom: 20px;
}

.back-btn {
  background-color: #6c757d;
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 5px;
  cursor: pointer;
  text-decoration: none;
  display: inline-block;
}

 .back-btn:hover {
   background-color: #5a6268;
 }

 .detail-content {
  background: white;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
  max-width: 1500px;
  margin: 0 auto;
}

.detail-header {
  padding: 40px;
}

.news-image {
  margin-bottom: 50px;
  border-radius: 8px;
  overflow: hidden;
}

.news-image img {
  width: 100%;
  height: auto;
  display: block;
}

.news-meta {
  display: flex;
  gap: 15px;
  margin-bottom: 20px;
  align-items: center;
}

.category-badge {
  color: white;
  padding: 6px 12px;
  border-radius: 4px;
  font-size: 12px;
  font-weight: 600;
  text-align: center;
  white-space: nowrap;
}

 .news-category {
   background-color: #da5761;
 }
 
 .seminar-category {
   background-color: #da5761;
 }
 
 .publication-category {
   background-color: #da5761;
 }

.news-date {
  color: #6c757d;
  font-size: 14px;
}

.news-title {
  font-size: 2rem;
  color: #1A1A1A;
  margin-bottom: 30px;
  line-height: 1.3;
}

.type-specific-info {
  background-color: #f8f9fa;
  padding: 20px;
  border-radius: 8px;
  margin-bottom: 30px;
}

.info-item {
  display: flex;
  margin-bottom: 10px;
}

.info-label {
  font-weight: 600;
  color: #1A1A1A;
  min-width: 120px;
}

.info-value {
  color: #666;
}

.status.recruiting {
  color: #28a745;
  font-weight: 600;
}

.status.completed {
  color: #6c757d;
}

.status.cancelled {
  color: #dc3545;
}

.action-buttons {
  display: flex;
  gap: 15px;
  flex-wrap: wrap;
}

.register-btn,
.download-btn,
.share-btn {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 12px 24px;
  border: none;
  border-radius: 8px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s;
}

.register-btn {
  background-color: #28a745;
  color: white;
}

.register-btn:hover {
  background-color: #218838;
}

.download-btn {
  background-color: #007bff;
  color: white;
}

 .download-btn:hover {
   background-color: #0056b3;
 }

  /* Filter Download Button */
 .filter-download-btn {
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
   color: #ffffff;
   font-family: 'Inter', sans-serif;
   font-size: 15px;
   font-weight: 700;
   line-height: 150%;
   transition: all 0.3s ease;
   margin: 0 auto;
 }

 .filter-download-btn .icon-box {
  display: flex;
  align-items: center;
  justify-content: center;
}

.arrow-icon {
  display: flex;
  align-items: center;
  justify-content: center;
}

.filter-download-btn:hover {
  background: var(--color-secondary);
}


.share-btn {
  background-color: #f8f9fa;
  color: #1A1A1A;
  border: 1px solid #dee2e6;
}

.share-btn:hover {
  background-color: #e9ecef;
}

.description-section {
  padding: 40px 0;
  border-top: 1px solid #eee;
}

.description-section h2 {
  font-size: 1.5rem;
  color: #1A1A1A;
  margin-bottom: 20px;
}

.description-text,
.additional-content p {
  font-size: 16px;
  line-height: 1.6;
  color: #666;
  margin-bottom: 15px;
}

.related-section {
  padding: 40px;
  border-top: 1px solid #eee;
  background-color: #f8f9fa;
}

.related-section h2 {
  font-size: 1.5rem;
  color: #1A1A1A;
  margin-bottom: 20px;
}

.related-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 20px;
}

.related-item {
  background: white;
  border-radius: 8px;
  padding: 20px;
  cursor: pointer;
  transition: transform 0.2s, box-shadow 0.2s;
}

.related-item:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.related-meta {
  display: flex;
  gap: 10px;
  margin-bottom: 10px;
  align-items: center;
}

.related-category {
  color: white;
  padding: 3px 8px;
  border-radius: 3px;
  font-size: 10px;
  font-weight: 600;
}

.related-date {
  font-size: 12px;
  color: #6c757d;
}

.related-title {
  font-size: 16px;
  color: #1A1A1A;
  line-height: 1.4;
  margin: 0 0 10px 0;
}

.related-description {
  font-size: 14px;
  color: #666;
  line-height: 1.4;
  margin: 0;
}

/* レスポンシブ対応 */
@media (max-width: 1150px) {
  .detail-header {
    padding: 40px 30px !important;
  }
  
  .news-title {
    font-size: 32px !important;
  }
  
  .news-subtitle {
    font-size: 18px !important;
  }
  
  .news-meta {
    gap: 30px !important;
  }
  
  .news-category,
  .news-date {
    font-size: 18px !important;
  }
  
  .description-section,
  .related-section {
    padding: 40px 30px !important;
  }
  
  .description-section h3 {
    font-size: 22px !important;
  }
  
  .description-section p {
    font-size: 18px !important;
  }
  
  .related-section h2 {
    font-size: 22px !important;
  }
  
  .related-title {
    font-size: 18px !important;
  }
  
  .related-description {
    font-size: 16px !important;
  }
  
  .related-category {
    font-size: 12px !important;
  }
  
  .related-date {
    font-size: 14px !important;
  }
  
  .action-btn {
    font-size: 18px !important;
    padding: 15px 30px !important;
  }
}

@media (max-width: 900px) {
  .detail-header {
    padding: 35px 25px !important;
  }
  
  .news-title {
    font-size: 29px !important;
  }
  
  .news-subtitle {
    font-size: 17px !important;
  }
  
  .news-meta {
    gap: 25px !important;
  }
  
  .news-category,
  .news-date {
    font-size: 17px !important;
  }
  
  .description-section,
  .related-section {
    padding: 35px 25px !important;
  }
  
  .description-section h3 {
    font-size: 20px !important;
  }
  
  .description-section p {
    font-size: 17px !important;
  }
  
  .related-section h2 {
    font-size: 20px !important;
  }
  
  .related-title {
    font-size: 17px !important;
  }
  
  .related-description {
    font-size: 15px !important;
  }
  
  .related-category {
    font-size: 11px !important;
  }
  
  .related-date {
    font-size: 13px !important;
  }
  
  .action-btn {
    font-size: 17px !important;
    padding: 14px 28px !important;
  }
}

@media (max-width: 768px) {
  .detail-header {
    padding: 20px !important;
  }
  
  .news-title {
    font-size: 27px !important;
  }
  
  .news-subtitle {
    font-size: 16px !important;
  }
  
  .news-meta {
    flex-direction: column !important;
    align-items: flex-start !important;
    gap: 10px !important;
  }
  
  .news-category,
  .news-date {
    font-size: 16px !important;
  }
  
  .action-buttons {
    flex-direction: column !important;
  }
  
  .description-section,
  .related-section {
    padding: 20px !important;
  }
  
  .description-section h3 {
    font-size: 19px !important;
  }
  
  .description-section p {
    font-size: 16px !important;
  }
  
  .related-section h2 {
    font-size: 19px !important;
  }
  
  .related-grid {
    grid-template-columns: 1fr !important;
  }
  
  .related-title {
    font-size: 16px !important;
  }
  
  .related-description {
    font-size: 14px !important;
  }
  
  .related-category {
    font-size: 10px !important;
  }
  
  .related-date {
    font-size: 12px !important;
  }
  
  .action-btn {
    font-size: 16px !important;
    padding: 13px 26px !important;
  }
}

@media (max-width: 480px) {
  .detail-header {
    padding: 15px !important;
  }
  
  .news-title {
    font-size: 22px !important;
  }
  
  .news-subtitle {
    font-size: 13px !important;
  }
  
  .news-category,
  .news-date {
    font-size: 13px !important;
  }
  
  .description-section,
  .related-section {
    padding: 15px !important;
  }
  
  .description-section h3 {
    font-size: 18px !important;
  }
  
  .description-section p {
    font-size: 13px !important;
  }
  
  .related-section h2 {
    font-size: 18px !important;
  }
  
  .related-title {
    font-size: 13px !important;
  }
  
  .related-description {
    font-size: 12px !important;
  }
  
  .related-category {
    font-size: 9px !important;
  }
  
  .related-date {
    font-size: 11px !important;
  }
  
  .action-btn {
    font-size: 13px !important;
    padding: 12px 24px !important;
  }
}

/* Footer Navigation */
</style>
