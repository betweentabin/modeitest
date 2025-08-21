<template>
  <div class="page-container">
    <Navigation />
    <div class="page-content">
      <div class="page-header">
        <h1>刊行物</h1>
        <p class="subtitle">PUBLICATIONS</p>
      </div>

      <div class="publications-intro">
        <p class="lead-text">
          地域経済の最新動向や経営に役立つ情報を<br />
          定期刊行物として発行しています
        </p>
      </div>

      <div class="featured-publications">
        <h2>最新刊行物</h2>
        <div class="publication-grid">
          <div class="publication-card featured">
            <div class="publication-image">
              <img src="/img/-----2-2-5.png" alt="Hot Information Vol.324" />
              <div class="publication-badge">NEW</div>
            </div>
            <div class="publication-content">
              <div class="publication-date">2025.04.28</div>
              <h3>Hot Information Vol.324</h3>
              <p class="publication-description">
                2025年度の経済展望と地域企業が取り組むべき課題について特集しています。
                DX推進のポイントや、新たな成長戦略についても詳しく解説。
              </p>
              <div class="publication-actions">
                <button class="view-btn">詳細を見る</button>
                <button class="download-btn">PDFダウンロード</button>
              </div>
            </div>
          </div>

          <div class="publication-card">
            <div class="publication-image">
              <img src="/img/-----2-2-1.png" alt="経営参考BOOK vol.52" />
            </div>
            <div class="publication-content">
              <div class="publication-date">2025.04.28</div>
              <h3>経営参考BOOK vol.52</h3>
              <p class="publication-description">
                事業承継をテーマに、成功事例と具体的な進め方を解説。
                後継者育成のポイントも詳しく紹介しています。
              </p>
              <div class="publication-actions">
                <button class="view-btn">詳細を見る</button>
                <button class="download-btn">PDFダウンロード</button>
              </div>
            </div>
          </div>

          <div class="publication-card">
            <div class="publication-image">
              <img src="/img/-----2-2-4.png" alt="Hot Information Vol.323" />
            </div>
            <div class="publication-content">
              <div class="publication-date">2025.03.15</div>
              <h3>Hot Information Vol.323</h3>
              <p class="publication-description">
                地域金融機関の新たな取り組みと、地域企業への支援策について詳しく解説。
                融資制度の活用方法も掲載。
              </p>
              <div class="publication-actions">
                <button class="view-btn">詳細を見る</button>
                <button class="download-btn">PDFダウンロード</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="publication-types">
        <h2>定期刊行物のご紹介</h2>
        <div class="types-grid">
          <div class="type-card">
            <div class="type-icon">📊</div>
            <h3>HOT Information</h3>
            <p class="type-frequency">月刊</p>
            <p class="type-description">
              地域経済の最新動向と今後の展望を分析。
              業界別の詳細データと専門家による解説を掲載。
            </p>
            <ul class="type-features">
              <li>経済指標の分析</li>
              <li>業界動向レポート</li>
              <li>政策解説</li>
              <li>経営トピックス</li>
            </ul>
          </div>

          <div class="type-card">
            <div class="type-icon">📚</div>
            <h3>経営参考BOOK</h3>
            <p class="type-frequency">季刊</p>
            <p class="type-description">
              経営課題の解決に役立つ実践的な情報を提供。
              成功事例と専門家のアドバイスを収録。
            </p>
            <ul class="type-features">
              <li>経営戦略事例</li>
              <li>人材育成ノウハウ</li>
              <li>マーケティング手法</li>
              <li>財務改善のポイント</li>
            </ul>
          </div>

          <div class="type-card">
            <div class="type-icon">📈</div>
            <h3>地域経済白書</h3>
            <p class="type-frequency">年刊</p>
            <p class="type-description">
              年間の地域経済を総括し、次年度の展望を提示。
              詳細な統計データと分析を収録。
            </p>
            <ul class="type-features">
              <li>年間経済総括</li>
              <li>産業別分析</li>
              <li>地域比較データ</li>
              <li>将来予測</li>
            </ul>
          </div>
        </div>
      </div>

      <div class="archive-section">
        <h2>バックナンバー</h2>
        <div class="archive-search">
          <input type="text" placeholder="キーワードで検索..." class="search-input" />
          <select class="year-select">
            <option>2025年</option>
            <option>2024年</option>
            <option>2023年</option>
            <option>2022年</option>
            <option>2021年</option>
          </select>
          <button class="search-btn">検索</button>
        </div>
        
        <div class="archive-list">
          <div class="archive-item">
            <div class="archive-info">
              <span class="archive-date">2025.03</span>
              <span class="archive-title">Hot Information Vol.322</span>
            </div>
            <button class="archive-download">ダウンロード</button>
          </div>
          <div class="archive-item">
            <div class="archive-info">
              <span class="archive-date">2025.02</span>
              <span class="archive-title">Hot Information Vol.321</span>
            </div>
            <button class="archive-download">ダウンロード</button>
          </div>
          <div class="archive-item">
            <div class="archive-info">
              <span class="archive-date">2025.01</span>
              <span class="archive-title">経営参考BOOK vol.51</span>
            </div>
            <button class="archive-download">ダウンロード</button>
          </div>
          <div class="archive-item">
            <div class="archive-info">
              <span class="archive-date">2025.01</span>
              <span class="archive-title">Hot Information Vol.320</span>
            </div>
            <button class="archive-download">ダウンロード</button>
          </div>
        </div>
        
        <div class="pagination">
          <button class="page-btn">前へ</button>
          <span class="page-numbers">
            <span class="page-num active">1</span>
            <span class="page-num">2</span>
            <span class="page-num">3</span>
            <span class="page-num">4</span>
            <span class="page-num">5</span>
          </span>
          <button class="page-btn">次へ</button>
        </div>
      </div>

      <div class="member-notice">
        <h3>会員の皆様へ</h3>
        <p>
          会員の方は、すべての刊行物を無料でダウンロードいただけます。<br />
          ログイン後、マイページからアクセスしてください。
        </p>
        <button class="login-btn">会員ログイン</button>
      </div>
    </div>
    <FooterComplete />
  </div>
</template>

<script>
import Navigation from "./Navigation.vue";
import FooterComplete from "./FooterComplete.vue";

export default {
  name: "PublicationsPage",
  components: {
    Navigation,
    FooterComplete
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

.publications-intro {
  text-align: center;
  margin-bottom: 60px;
}

.lead-text {
  font-size: 1.1rem;
  line-height: 1.8;
  color: #666;
}

.featured-publications {
  margin-bottom: 60px;
}

.featured-publications h2 {
  color: #dc3545;
  font-size: 2rem;
  margin-bottom: 30px;
  text-align: center;
}

.publication-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
  gap: 30px;
}

.publication-card {
  background: white;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
  transition: transform 0.3s;
}

.publication-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 5px 20px rgba(0,0,0,0.15);
}

.publication-card.featured {
  border: 2px solid #dc3545;
}

.publication-image {
  position: relative;
  height: 300px;
  background: #f5f5f5;
  display: flex;
  align-items: center;
  justify-content: center;
}

.publication-image img {
  max-width: 80%;
  max-height: 80%;
  object-fit: contain;
}

.publication-badge {
  position: absolute;
  top: 20px;
  right: 20px;
  background: #dc3545;
  color: white;
  padding: 5px 15px;
  border-radius: 20px;
  font-size: 0.85rem;
  font-weight: 600;
}

.publication-content {
  padding: 25px;
}

.publication-date {
  color: #dc3545;
  font-size: 0.9rem;
  margin-bottom: 10px;
}

.publication-content h3 {
  color: #333;
  font-size: 1.3rem;
  margin-bottom: 15px;
}

.publication-description {
  color: #666;
  line-height: 1.6;
  margin-bottom: 20px;
  font-size: 0.95rem;
}

.publication-actions {
  display: flex;
  gap: 10px;
}

.view-btn,
.download-btn {
  flex: 1;
  padding: 10px;
  border-radius: 5px;
  border: none;
  cursor: pointer;
  transition: all 0.3s;
  font-size: 0.9rem;
}

.view-btn {
  background: white;
  color: #dc3545;
  border: 1px solid #dc3545;
}

.view-btn:hover {
  background: #dc3545;
  color: white;
}

.download-btn {
  background: #dc3545;
  color: white;
}

.download-btn:hover {
  background: #c82333;
}

.publication-types {
  background: white;
  padding: 50px;
  border-radius: 10px;
  margin-bottom: 60px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.publication-types h2 {
  color: #dc3545;
  font-size: 2rem;
  margin-bottom: 40px;
  text-align: center;
}

.types-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 40px;
}

.type-card {
  text-align: center;
  padding: 30px;
  border: 1px solid #dee2e6;
  border-radius: 10px;
  transition: all 0.3s;
}

.type-card:hover {
  border-color: #dc3545;
  box-shadow: 0 5px 15px rgba(220, 53, 69, 0.2);
}

.type-icon {
  font-size: 3rem;
  margin-bottom: 20px;
}

.type-card h3 {
  color: #333;
  font-size: 1.5rem;
  margin-bottom: 10px;
}

.type-frequency {
  color: #dc3545;
  font-weight: 600;
  margin-bottom: 15px;
}

.type-description {
  color: #666;
  line-height: 1.6;
  margin-bottom: 20px;
}

.type-features {
  list-style: none;
  padding: 0;
  text-align: left;
}

.type-features li {
  padding: 8px 0;
  padding-left: 25px;
  position: relative;
  color: #666;
  border-bottom: 1px solid #f0f0f0;
}

.type-features li:before {
  content: "✓";
  position: absolute;
  left: 0;
  color: #28a745;
  font-weight: bold;
}

.archive-section {
  background: white;
  padding: 50px;
  border-radius: 10px;
  margin-bottom: 60px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.archive-section h2 {
  color: #dc3545;
  font-size: 2rem;
  margin-bottom: 30px;
  text-align: center;
}

.archive-search {
  display: flex;
  gap: 10px;
  margin-bottom: 30px;
  max-width: 600px;
  margin-left: auto;
  margin-right: auto;
}

.search-input {
  flex: 1;
  padding: 10px 15px;
  border: 1px solid #dee2e6;
  border-radius: 5px;
  font-size: 1rem;
}

.year-select {
  padding: 10px 15px;
  border: 1px solid #dee2e6;
  border-radius: 5px;
  font-size: 1rem;
  background: white;
}

.search-btn {
  padding: 10px 30px;
  background: #dc3545;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background 0.3s;
}

.search-btn:hover {
  background: #c82333;
}

.archive-list {
  margin-bottom: 30px;
}

.archive-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px;
  border-bottom: 1px solid #dee2e6;
  transition: background 0.3s;
}

.archive-item:hover {
  background: #f8f9fa;
}

.archive-info {
  display: flex;
  gap: 20px;
  align-items: center;
}

.archive-date {
  color: #dc3545;
  font-weight: 600;
}

.archive-title {
  color: #333;
}

.archive-download {
  padding: 8px 20px;
  background: white;
  color: #dc3545;
  border: 1px solid #dc3545;
  border-radius: 5px;
  cursor: pointer;
  transition: all 0.3s;
}

.archive-download:hover {
  background: #dc3545;
  color: white;
}

.pagination {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 20px;
  margin-top: 30px;
}

.page-btn {
  padding: 10px 20px;
  background: white;
  border: 1px solid #dee2e6;
  border-radius: 5px;
  cursor: pointer;
  transition: all 0.3s;
}

.page-btn:hover {
  background: #dc3545;
  color: white;
  border-color: #dc3545;
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

.member-notice {
  background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
  color: white;
  padding: 50px;
  border-radius: 10px;
  text-align: center;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.member-notice h3 {
  font-size: 1.8rem;
  margin-bottom: 15px;
}

.member-notice p {
  font-size: 1.1rem;
  margin-bottom: 25px;
  line-height: 1.6;
}

.login-btn {
  padding: 12px 40px;
  background: white;
  color: #dc3545;
  border: none;
  border-radius: 25px;
  font-size: 1.1rem;
  font-weight: 600;
  cursor: pointer;
  transition: transform 0.3s;
}

.login-btn:hover {
  transform: scale(1.05);
}

@media (max-width: 768px) {
  .publication-grid {
    grid-template-columns: 1fr;
  }
  
  .types-grid {
    grid-template-columns: 1fr;
  }
  
  .archive-search {
    flex-direction: column;
  }
  
  .archive-item {
    flex-direction: column;
    gap: 10px;
    text-align: center;
  }
}
</style>