<template>
  <div class="page-container">
    <Navigation />
    <div class="page-content">
      <div class="page-header">
        <h1>お知らせ・ニュース</h1>
        <p class="subtitle">NEWS & INFORMATION</p>
      </div>

      <div class="news-categories">
        <button class="category-btn active" @click="filterCategory('all')">すべて</button>
        <button class="category-btn" @click="filterCategory('news')">ニュース</button>
        <button class="category-btn" @click="filterCategory('seminar')">セミナー</button>
        <button class="category-btn" @click="filterCategory('publication')">刊行物</button>
        <button class="category-btn" @click="filterCategory('notice')">お知らせ</button>
      </div>

      <div class="news-list">
        <article class="news-item featured">
          <div class="news-meta">
            <span class="news-date">2025.05.12</span>
            <span class="news-category hot">HOT</span>
          </div>
          <div class="news-content">
            <h3>HOT Information Vol.319掲載しました！</h3>
            <p>最新の地域経済動向レポート「HOT Information Vol.319」を掲載しました。今月は九州地域の製造業の動向と今後の展望について特集しています。</p>
            <a href="#" class="read-more">詳細を見る →</a>
          </div>
        </article>

        <article class="news-item">
          <div class="news-meta">
            <span class="news-date">2025.05.12</span>
            <span class="news-category seminar">セミナー</span>
          </div>
          <div class="news-content">
            <h3>採用力強化！経営・人事向け　面接官トレーニングセミナー</h3>
            <p>優秀な人材を見極め、獲得するための面接技術を習得できるセミナーを開催します。実践的なロールプレイングを通じて、面接スキルを向上させます。</p>
            <a href="#" class="read-more">詳細を見る →</a>
          </div>
        </article>

        <article class="news-item">
          <div class="news-meta">
            <span class="news-date">2025.05.12</span>
            <span class="news-category publication">刊行物</span>
          </div>
          <div class="news-content">
            <h3>Hot Information Vol.318掲載しました！</h3>
            <p>地域金融機関の新たな取り組みと、地域企業への支援策について詳しく解説しています。会員の皆様は無料でダウンロード可能です。</p>
            <a href="#" class="read-more">詳細を見る →</a>
          </div>
        </article>

        <article class="news-item">
          <div class="news-meta">
            <span class="news-date">2025.05.12</span>
            <span class="news-category news">ニュース</span>
          </div>
          <div class="news-content">
            <h3>Hot Information Vol.316掲載しました</h3>
            <p>今月号では、地域の観光産業の回復状況と、インバウンド需要の最新動向について分析しています。</p>
            <a href="#" class="read-more">詳細を見る →</a>
          </div>
        </article>

        <article class="news-item">
          <div class="news-meta">
            <span class="news-date">2025.04.28</span>
            <span class="news-category publication">刊行物</span>
          </div>
          <div class="news-content">
            <h3>Hot Information Vol.324発行</h3>
            <p>2025年度の経済展望と、地域企業が取り組むべき課題について特集しています。DX推進のポイントも解説。</p>
            <a href="#" class="read-more">詳細を見る →</a>
          </div>
          <div class="news-thumbnail">
            <img src="/img/-----2-2-5.png" alt="Hot Information Vol.324" />
          </div>
        </article>

        <article class="news-item">
          <div class="news-meta">
            <span class="news-date">2025.04.28</span>
            <span class="news-category publication">刊行物</span>
          </div>
          <div class="news-content">
            <h3>経営参考BOOK vol.52発行</h3>
            <p>事業承継をテーマに、成功事例と具体的な進め方を解説。後継者育成のポイントも詳しく紹介しています。</p>
            <a href="#" class="read-more">詳細を見る →</a>
          </div>
          <div class="news-thumbnail">
            <img src="/img/-----2-2-1.png" alt="経営参考BOOK vol.52" />
          </div>
        </article>

        <article class="news-item">
          <div class="news-meta">
            <span class="news-date">2025.04.15</span>
            <span class="news-category seminar">セミナー</span>
          </div>
          <div class="news-content">
            <h3>事業継承から描く九州の未来</h3>
            <p>地域企業の事業承継の現状と課題、そして成功へのロードマップを解説するセミナーを開催します。</p>
            <a href="#" class="read-more">詳細を見る →</a>
          </div>
          <div class="news-thumbnail">
            <img src="/img/-----2-2.png" alt="事業継承セミナー" />
          </div>
        </article>

        <article class="news-item">
          <div class="news-meta">
            <span class="news-date">2025.04.01</span>
            <span class="news-category notice">お知らせ</span>
          </div>
          <div class="news-content">
            <h3>2025年度会員募集開始</h3>
            <p>2025年度の新規会員募集を開始しました。早期入会特典として、過去の経済レポートアーカイブへのアクセス権を提供します。</p>
            <a href="#" class="read-more">詳細を見る →</a>
          </div>
        </article>
      </div>

      <div class="pagination">
        <button class="page-btn" :disabled="currentPage === 1" @click="changePage(currentPage - 1)">前へ</button>
        <span class="page-numbers">
          <span 
            v-for="page in totalPages" 
            :key="page"
            class="page-num" 
            :class="{ active: page === currentPage }"
            @click="changePage(page)"
          >
            {{ page }}
          </span>
        </span>
        <button class="page-btn" :disabled="currentPage === totalPages" @click="changePage(currentPage + 1)">次へ</button>
      </div>

      <div class="news-subscribe">
        <h2>最新情報をメールでお届け</h2>
        <p>セミナー情報や最新レポートの発行情報をいち早くお届けします</p>
        <div class="subscribe-form">
          <input type="email" placeholder="メールアドレスを入力" class="email-input" />
          <button class="subscribe-btn">登録する</button>
        </div>
      </div>
    </div>
    <FooterComplete />
  </div>
</template>

<script>
import Navigation from "./Navigation.vue";
import FooterComplete from "./FooterComplete.vue";

export default {
  name: "NewsPage",
  components: {
    Navigation,
    FooterComplete
  },
  data() {
    return {
      currentPage: 1,
      totalPages: 3,
      selectedCategory: 'all'
    };
  },
  methods: {
    changePage(page) {
      if (page >= 1 && page <= this.totalPages) {
        this.currentPage = page;
      }
    },
    filterCategory(category) {
      this.selectedCategory = category;
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

.page-header {
  text-align: center;
  margin-bottom: 40px;
}

.page-header h1 {
  font-size: 2.5rem;
  color: #333;
  margin-bottom: 10px;
}

.subtitle {
  color: #dc3545;
  font-size: 1.2rem;
  font-weight: 600;
  letter-spacing: 2px;
}

.news-categories {
  display: flex;
  justify-content: center;
  gap: 10px;
  margin-bottom: 40px;
  flex-wrap: wrap;
}

.category-btn {
  padding: 10px 20px;
  background: white;
  border: 2px solid #dee2e6;
  border-radius: 25px;
  cursor: pointer;
  transition: all 0.3s;
  font-size: 0.95rem;
}

.category-btn:hover,
.category-btn.active {
  background: #dc3545;
  color: white;
  border-color: #dc3545;
}

.news-list {
  background: white;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.news-item {
  padding: 30px;
  border-bottom: 1px solid #e9ecef;
  display: flex;
  gap: 30px;
  transition: background-color 0.3s;
}

.news-item:hover {
  background-color: #f8f9fa;
}

.news-item:last-child {
  border-bottom: none;
}

.news-item.featured {
  background: linear-gradient(135deg, #fff5f5 0%, #ffe5e5 100%);
  border-left: 4px solid #dc3545;
}

.news-meta {
  display: flex;
  flex-direction: column;
  gap: 10px;
  min-width: 120px;
}

.news-date {
  color: #666;
  font-size: 0.9rem;
  font-weight: 500;
}

.news-category {
  display: inline-block;
  padding: 4px 12px;
  border-radius: 20px;
  font-size: 0.8rem;
  text-align: center;
  font-weight: 600;
  text-transform: uppercase;
  width: fit-content;
}

.news-category.hot {
  background: #dc3545;
  color: white;
}

.news-category.seminar {
  background: #007bff;
  color: white;
}

.news-category.publication {
  background: #28a745;
  color: white;
}

.news-category.news {
  background: #ffc107;
  color: #333;
}

.news-category.notice {
  background: #6c757d;
  color: white;
}

.news-content {
  flex: 1;
}

.news-content h3 {
  color: #333;
  margin-bottom: 10px;
  font-size: 1.3rem;
  cursor: pointer;
  transition: color 0.3s;
}

.news-content h3:hover {
  color: #dc3545;
}

.news-content p {
  color: #666;
  line-height: 1.6;
  margin-bottom: 15px;
}

.read-more {
  color: #dc3545;
  text-decoration: none;
  font-weight: 500;
  transition: all 0.3s;
}

.read-more:hover {
  color: #c82333;
}

.news-thumbnail {
  width: 150px;
  flex-shrink: 0;
}

.news-thumbnail img {
  width: 100%;
  height: auto;
  border-radius: 8px;
}

.pagination {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 20px;
  margin-top: 40px;
}

.page-btn {
  padding: 10px 20px;
  background: white;
  border: 1px solid #dee2e6;
  border-radius: 5px;
  cursor: pointer;
  transition: all 0.3s;
}

.page-btn:hover:not(:disabled) {
  background: #dc3545;
  color: white;
  border-color: #dc3545;
}

.page-btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.page-numbers {
  display: flex;
  gap: 10px;
}

.page-num {
  width: 40px;
  height: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
  border: 1px solid #dee2e6;
  border-radius: 5px;
  cursor: pointer;
  transition: all 0.3s;
}

.page-num:hover {
  background: #f8f9fa;
}

.page-num.active {
  background: #dc3545;
  color: white;
  border-color: #dc3545;
}

.news-subscribe {
  background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
  color: white;
  padding: 50px;
  border-radius: 10px;
  text-align: center;
  margin-top: 60px;
}

.news-subscribe h2 {
  font-size: 1.8rem;
  margin-bottom: 10px;
}

.news-subscribe p {
  font-size: 1.1rem;
  margin-bottom: 30px;
}

.subscribe-form {
  display: flex;
  max-width: 500px;
  margin: 0 auto;
  gap: 10px;
}

.email-input {
  flex: 1;
  padding: 12px 20px;
  border: none;
  border-radius: 50px;
  font-size: 1rem;
}

.subscribe-btn {
  padding: 12px 30px;
  background: white;
  color: #dc3545;
  border: none;
  border-radius: 50px;
  font-weight: 600;
  cursor: pointer;
  transition: transform 0.3s;
}

.subscribe-btn:hover {
  transform: scale(1.05);
}

@media (max-width: 768px) {
  .news-item {
    flex-direction: column;
    gap: 15px;
  }
  
  .news-meta {
    flex-direction: row;
    gap: 15px;
  }
  
  .news-thumbnail {
    width: 100%;
  }
  
  .subscribe-form {
    flex-direction: column;
  }
}
</style>