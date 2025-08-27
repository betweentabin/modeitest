<template>
  <div class="page-container">
    <Navigation />
    <div class="page-content">
      <div v-if="loading" class="loading-container">
        <div class="loading-message">読み込み中...</div>
      </div>
      
      <div v-else-if="error" class="error-container">
        <div class="error-message">{{ error }}</div>
        <button @click="$router.push('/news')" class="back-btn">ニュース一覧に戻る</button>
      </div>
      
      <div v-else-if="newsItem" class="detail-container">
        <!-- パンくずナビ -->
        <nav class="breadcrumb">
          <router-link to="/" class="breadcrumb-link">ホーム</router-link>
          <span class="breadcrumb-separator">></span>
          <router-link to="/news" class="breadcrumb-link">ニュース</router-link>
          <span class="breadcrumb-separator">></span>
          <span class="breadcrumb-current">{{ newsItem.title }}</span>
        </nav>

        <!-- メインコンテンツ -->
        <div class="detail-content">
          <div class="detail-header">
            <div class="news-meta">
              <span :class="getCategoryClass(newsItem.type)" class="category-badge">
                {{ getCategoryLabel(newsItem.type) }}
              </span>
              <span class="news-date">{{ formatDate(newsItem.date) }}</span>
            </div>
            
            <h1 class="news-title">{{ newsItem.title }}</h1>
            
            <!-- 種類別の詳細情報 -->
            <div v-if="newsItem.type === 'seminar'" class="type-specific-info">
              <div class="seminar-info">
                <div class="info-item" v-if="originalItem.location">
                  <span class="info-label">開催場所:</span>
                  <span class="info-value">{{ originalItem.location }}</span>
                </div>
                <div class="info-item" v-if="originalItem.capacity">
                  <span class="info-label">定員:</span>
                  <span class="info-value">{{ originalItem.capacity }}名</span>
                </div>
                <div class="info-item" v-if="originalItem.fee">
                  <span class="info-label">参加費:</span>
                  <span class="info-value">{{ originalItem.fee }}円</span>
                </div>
                <div class="info-item" v-if="originalItem.status">
                  <span class="info-label">ステータス:</span>
                  <span class="info-value status" :class="originalItem.status">{{ getStatusText(originalItem.status) }}</span>
                </div>
              </div>
            </div>
            
            <div v-else-if="newsItem.type === 'publication'" class="type-specific-info">
              <div class="publication-info">
                <div class="info-item" v-if="originalItem.author">
                  <span class="info-label">著者・編集者:</span>
                  <span class="info-value">{{ originalItem.author }}</span>
                </div>
                <div class="info-item" v-if="originalItem.pages">
                  <span class="info-label">ページ数:</span>
                  <span class="info-value">{{ originalItem.pages }}ページ</span>
                </div>
                <div class="info-item" v-if="originalItem.file_size">
                  <span class="info-label">ファイルサイズ:</span>
                  <span class="info-value">{{ originalItem.file_size }}MB</span>
                </div>
              </div>
            </div>
            
            <!-- アクションボタン -->
            <div class="action-buttons">
              <button 
                v-if="newsItem.type === 'seminar' && originalItem.status === 'recruiting'" 
                @click="registerSeminar" 
                class="register-btn"
              >
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M19,13H13V19H11V13H5V11H11V5H13V11H19V13Z"/>
                </svg>
                セミナーに申し込む
              </button>
              
              <button 
                v-if="newsItem.type === 'publication' && originalItem.file_url" 
                @click="downloadPDF" 
                class="download-btn"
              >
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                </svg>
                PDFダウンロード
              </button>
              
              <button @click="sharePage" class="share-btn">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M18,16.08C17.24,16.08 16.56,16.38 16.04,16.85L8.91,12.7C8.96,12.47 9,12.24 9,12C9,11.76 8.96,11.53 8.91,11.3L15.96,7.19C16.5,7.69 17.21,8 18,8A3,3 0 0,0 21,5A3,3 0 0,0 18,2A3,3 0 0,0 15,5C15,5.24 15.04,5.47 15.09,5.7L8.04,9.81C7.5,9.31 6.79,9 6,9A3,3 0 0,0 3,12A3,3 0 0,0 6,15C6.79,15 7.5,14.69 8.04,14.19L15.16,18.34C15.11,18.55 15.08,18.77 15.08,19C15.08,20.61 16.39,21.91 18,21.91C19.61,21.91 20.92,20.61 20.92,19A2.92,2.92 0 0,0 18,16.08Z"/>
                </svg>
                シェア
              </button>
            </div>
          </div>
          
          <!-- 詳細説明 -->
          <div class="description-section">
            <h2>詳細</h2>
            <p class="description-text">{{ newsItem.description }}</p>
            
            <!-- 追加コンテンツ（originalItemから） -->
            <div v-if="originalItem.content && originalItem.content !== newsItem.description" class="additional-content">
              <p>{{ originalItem.content }}</p>
            </div>
          </div>
          
          <!-- 関連ニュース -->
          <div v-if="relatedNews.length > 0" class="related-section">
            <h2>関連ニュース</h2>
            <div class="related-grid">
              <div 
                v-for="related in relatedNews" 
                :key="related.id"
                class="related-item"
                @click="goToNews(related.id)"
              >
                <div class="related-meta">
                  <span :class="getCategoryClass(related.type)" class="related-category">
                    {{ getCategoryLabel(related.type) }}
                  </span>
                  <span class="related-date">{{ formatDate(related.date) }}</span>
                </div>
                <h3 class="related-title">{{ related.title }}</h3>
                <p class="related-description">{{ related.description.substring(0, 100) }}...</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <FooterComplete />
  </div>
</template>

<script>
import Navigation from "./Navigation.vue";
import FooterComplete from "./FooterComplete.vue";
import mockServer from "@/mockServer";

export default {
  name: "NewsDetailPage",
  components: {
    Navigation,
    FooterComplete
  },
  data() {
    return {
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
        
        const newsId = this.$route.params.id;
        
        // 全ニュースから指定されたニュースを検索
        const allNews = await mockServer.getAllNews();
        this.newsItem = allNews.find(news => news.id === newsId);
        
        if (!this.newsItem) {
          this.error = 'ニュースが見つかりませんでした';
          return;
        }
        
        // 元データを取得（セミナー、刊行物、お知らせの詳細情報）
        await this.loadOriginalItem();
        
        // 関連ニュースを取得（同じカテゴリーの他のニュース）
        this.relatedNews = allNews
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
        const itemId = parseInt(this.newsItem.id.split('-')[1]);
        
        switch (this.newsItem.type) {
          case 'seminar':
            const seminars = await mockServer.getSeminars();
            this.originalItem = seminars.find(s => s.id === itemId);
            break;
          case 'publication':
            const publications = await mockServer.getPublications();
            this.originalItem = publications.find(p => p.id === itemId);
            break;
          case 'notice':
            const notices = await mockServer.getNotices();
            this.originalItem = notices.find(n => n.id === itemId);
            break;
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
  max-width: 1000px;
  margin: 0 auto;
  padding: 40px 20px;
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

.breadcrumb {
  margin-bottom: 30px;
  font-size: 14px;
}

.breadcrumb-link {
  color: #0066cc;
  text-decoration: none;
}

.breadcrumb-link:hover {
  text-decoration: underline;
}

.breadcrumb-separator {
  margin: 0 10px;
  color: #6c757d;
}

.breadcrumb-current {
  color: #333;
  font-weight: 500;
}

.detail-content {
  background: white;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.detail-header {
  padding: 40px;
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
  background-color: #28a745;
}

.publication-category {
  background-color: #007bff;
}

.news-date {
  color: #6c757d;
  font-size: 14px;
}

.news-title {
  font-size: 2rem;
  color: #333;
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
  color: #333;
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

.share-btn {
  background-color: #f8f9fa;
  color: #333;
  border: 1px solid #dee2e6;
}

.share-btn:hover {
  background-color: #e9ecef;
}

.description-section {
  padding: 40px;
  border-top: 1px solid #eee;
}

.description-section h2 {
  font-size: 1.5rem;
  color: #333;
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
  color: #333;
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
  color: #333;
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
@media (max-width: 768px) {
  .detail-header {
    padding: 20px;
  }
  
  .news-title {
    font-size: 1.5rem;
  }
  
  .action-buttons {
    flex-direction: column;
  }
  
  .description-section,
  .related-section {
    padding: 20px;
  }
  
  .related-grid {
    grid-template-columns: 1fr;
  }
  
  .news-meta {
    flex-direction: column;
    align-items: flex-start;
    gap: 10px;
  }
}
</style>
