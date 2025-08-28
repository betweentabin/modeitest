<template>
  <div class="page-container">
    <Navigation />
    <div class="page-content">
      <div v-if="loading" class="loading-container">
        <div class="loading-message">読み込み中...</div>
      </div>
      
      <div v-else-if="error" class="error-container">
        <div class="error-message">{{ error }}</div>
        <button @click="$router.push('/publications')" class="back-btn">刊行物一覧に戻る</button>
      </div>
      
      <div v-else-if="publication" class="detail-container">
        <!-- パンくずナビ -->
        <nav class="breadcrumb">
          <router-link to="/" class="breadcrumb-link">ホーム</router-link>
          <span class="breadcrumb-separator">></span>
          <router-link to="/publications" class="breadcrumb-link">刊行物</router-link>
          <span class="breadcrumb-separator">></span>
          <span class="breadcrumb-current">{{ publication.title }}</span>
        </nav>

        <!-- メインコンテンツ -->
        <div class="detail-content">
          <div class="detail-header">
            <div class="publication-image-large">
              <img 
                :src="publication.image_url || '/img/-----2-2-5.png'" 
                :alt="publication.title"
                class="main-image"
              />
            </div>
            
            <div class="publication-info">
              <div class="publication-meta">
                <span class="publication-category">{{ getCategoryText(publication.category) }}</span>
                <span class="publication-date">{{ formatDate(publication.publication_date) }}</span>
              </div>
              
              <h1 class="publication-title">{{ publication.title }}</h1>
              
              <div class="publication-details">
                <div class="detail-item" v-if="publication.author">
                  <span class="detail-label">著者・編集者:</span>
                  <span class="detail-value">{{ publication.author }}</span>
                </div>
                
                <div class="detail-item" v-if="publication.pages">
                  <span class="detail-label">ページ数:</span>
                  <span class="detail-value">{{ publication.pages }}ページ</span>
                </div>
                
                <div class="detail-item" v-if="publication.file_size">
                  <span class="detail-label">ファイルサイズ:</span>
                  <span class="detail-value">{{ publication.file_size }}MB</span>
                </div>
                
                <div class="detail-item" v-if="publication.download_count !== undefined">
                  <span class="detail-label">ダウンロード数:</span>
                  <span class="detail-value">{{ publication.download_count }}回</span>
                </div>
              </div>
              
              <div class="action-buttons">
                <button 
                  @click="downloadPDF" 
                  class="download-btn"
                  :disabled="!publication.file_url"
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
          </div>
          
          <!-- 詳細説明 -->
          <div class="description-section">
            <h2>概要</h2>
            <p class="description-text">{{ publication.description }}</p>
          </div>
          
          <!-- 関連刊行物 -->
          <div v-if="relatedPublications.length > 0" class="related-section">
            <h2>関連刊行物</h2>
            <div class="related-grid">
              <div 
                v-for="related in relatedPublications" 
                :key="related.id"
                class="related-item"
                @click="goToPublication(related.id)"
              >
                <img 
                  :src="related.image_url || '/img/-----2-2-1.png'" 
                  :alt="related.title"
                  class="related-image"
                />
                <div class="related-info">
                  <div class="related-date">{{ formatDate(related.publication_date) }}</div>
                  <h3 class="related-title">{{ related.title }}</h3>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Footer Navigation -->
    <div class="navigation-footer">
      <Footer v-bind="frame132131753022Props" />
      <div class="vector-7-1"></div>
      <Group27 />
    </div>
  </div>
</template>

<script>
import Navigation from "./Navigation.vue";
import Footer from "./Footer.vue";
import Group27 from "./Group27.vue";
import { frame132131753022Data } from "../data.js";
import mockServer from "@/mockServer";

export default {
  name: "PublicationDetailPage",
  components: {
    Navigation,
    Footer,
    Group27
  },
  data() {
    return {
      frame132131753022Props: frame132131753022Data,
      loading: true,
      error: '',
      publication: null,
      relatedPublications: []
    };
  },
  async mounted() {
    await this.loadPublication();
  },
  watch: {
    '$route'() {
      // ルートが変わったら再読み込み
      this.loadPublication();
    }
  },
  methods: {
    async loadPublication() {
      try {
        this.loading = true;
        this.error = '';
        
        const publicationId = parseInt(this.$route.params.id);
        
        // 指定された刊行物を取得
        this.publication = await mockServer.getPublication(publicationId);
        
        // 関連刊行物を取得（同じカテゴリーの他の刊行物）
        const allPublications = await mockServer.getPublications();
        this.relatedPublications = allPublications
          .filter(p => p.id !== publicationId && p.category === this.publication.category)
          .slice(0, 3);
        
      } catch (err) {
        this.error = '刊行物の詳細情報を取得できませんでした';
        console.error('Publication detail loading error:', err);
      } finally {
        this.loading = false;
      }
    },
    formatDate(dateString) {
      const date = new Date(dateString);
      const year = date.getFullYear();
      const month = date.getMonth() + 1;
      const day = date.getDate();
      return `${year}.${String(month).padStart(2, '0')}.${String(day).padStart(2, '0')}`;
    },
    getCategoryText(category) {
      const categories = {
        'research': '研究レポート',
        'quarterly': '季報',
        'special': '特別レポート',
        'survey': '調査資料'
      };
      return categories[category] || 'その他';
    },
    downloadPDF() {
      if (this.publication.file_url) {
        // ダウンロード数を増加
        this.publication.download_count++;
        window.open(this.publication.file_url, '_blank');
      } else {
        alert('PDFファイルが見つかりません');
      }
    },
    sharePage() {
      if (navigator.share) {
        navigator.share({
          title: this.publication.title,
          text: this.publication.description,
          url: window.location.href
        });
      } else {
        // フォールバック: URLをクリップボードにコピー
        navigator.clipboard.writeText(window.location.href).then(() => {
          alert('URLをクリップボードにコピーしました');
        });
      }
    },
    goToPublication(publicationId) {
      this.$router.push(`/publications/${publicationId}`);
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
  max-width: 1200px;
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
  display: grid;
  grid-template-columns: 400px 1fr;
  gap: 40px;
  padding: 40px;
}

.publication-image-large {
  position: relative;
}

.main-image {
  width: 100%;
  height: auto;
  border-radius: 10px;
  box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.publication-info {
  padding: 20px 0;
}

.publication-meta {
  display: flex;
  gap: 15px;
  margin-bottom: 15px;
}

.publication-category {
  background-color: #da5761;
  color: white;
  padding: 5px 12px;
  border-radius: 15px;
  font-size: 12px;
  font-weight: 500;
}

.publication-date {
  color: #6c757d;
  font-size: 14px;
}

.publication-title {
  font-size: 2.2rem;
  color: #333;
  margin-bottom: 30px;
  line-height: 1.3;
}

.publication-details {
  margin-bottom: 30px;
}

.detail-item {
  display: flex;
  margin-bottom: 10px;
}

.detail-label {
  font-weight: 600;
  color: #333;
  min-width: 120px;
}

.detail-value {
  color: #666;
}

.action-buttons {
  display: flex;
  gap: 15px;
}

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

.download-btn {
  background-color: #da5761;
  color: white;
}

.download-btn:hover:not(:disabled) {
  background-color: #c44853;
}

.download-btn:disabled {
  background-color: #ccc;
  cursor: not-allowed;
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

.description-text {
  font-size: 16px;
  line-height: 1.6;
  color: #666;
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
  padding: 15px;
  cursor: pointer;
  transition: transform 0.2s, box-shadow 0.2s;
  display: flex;
  gap: 15px;
}

.related-item:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.related-image {
  width: 80px;
  height: 80px;
  object-fit: cover;
  border-radius: 5px;
  flex-shrink: 0;
}

.related-info {
  flex: 1;
}

.related-date {
  font-size: 12px;
  color: #6c757d;
  margin-bottom: 5px;
}

.related-title {
  font-size: 14px;
  color: #333;
  line-height: 1.4;
  margin: 0;
}

/* レスポンシブ対応 */
@media (max-width: 768px) {
  .detail-header {
    grid-template-columns: 1fr;
    gap: 20px;
    padding: 20px;
  }
  
  .publication-title {
    font-size: 1.6rem;
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
