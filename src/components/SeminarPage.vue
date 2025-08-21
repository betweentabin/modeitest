<template>
  <div class="page-container">
    <Navigation />
    <div class="page-content">
      <div class="page-header">
        <h1>セミナー情報</h1>
        <p class="subtitle">SEMINAR</p>
      </div>

      <div class="seminar-intro">
        <p class="lead-text">
          ちくぎん地域経済研究所では、地域企業の皆様のスキルアップと<br />
          ビジネス成長を支援する各種セミナーを開催しています。
        </p>
      </div>

      <div class="seminar-categories">
        <button class="category-btn active">すべて</button>
        <button class="category-btn">経営戦略</button>
        <button class="category-btn">人事・労務</button>
        <button class="category-btn">マーケティング</button>
        <button class="category-btn">DX・IT</button>
        <button class="category-btn">財務・会計</button>
      </div>

      <div class="seminar-list">
        <div class="seminar-card upcoming">
          <div class="seminar-date">
            <div class="month">4月</div>
            <div class="day">28</div>
            <div class="year">2025</div>
          </div>
          <div class="seminar-image">
            <img src="/img/-----2-2.png" alt="事業継承セミナー" />
            <div class="seminar-badge">開催予定</div>
          </div>
          <div class="seminar-content">
            <h3>事業継承から描く九州の未来</h3>
            <p class="seminar-description">
              中小企業の事業承継における課題と解決策を、実際の成功事例を交えながら解説します。
              後継者育成のポイントや、スムーズな承継のための準備について学べます。
            </p>
            <div class="seminar-info">
              <div class="info-item">
                <span class="label">時間：</span>
                <span>14:00～17:00</span>
              </div>
              <div class="info-item">
                <span class="label">会場：</span>
                <span>久留米リサーチセンター</span>
              </div>
              <div class="info-item">
                <span class="label">定員：</span>
                <span>50名</span>
              </div>
              <div class="info-item">
                <span class="label">参加費：</span>
                <span>会員無料 / 一般3,000円</span>
              </div>
            </div>
            <button class="apply-btn">申し込む</button>
          </div>
        </div>

        <div class="seminar-card">
          <div class="seminar-date">
            <div class="month">5月</div>
            <div class="day">12</div>
            <div class="year">2025</div>
          </div>
          <div class="seminar-content full-width">
            <h3>採用力強化！経営・人事向け　面接官トレーニングセミナー</h3>
            <p class="seminar-description">
              優秀な人材を見極め、獲得するための面接技術を習得できるセミナーです。
              実践的なロールプレイングを通じて、面接スキルを向上させます。
            </p>
            <div class="seminar-info">
              <div class="info-item">
                <span class="label">時間：</span>
                <span>13:30～16:30</span>
              </div>
              <div class="info-item">
                <span class="label">会場：</span>
                <span>オンライン（Zoom）</span>
              </div>
              <div class="info-item">
                <span class="label">定員：</span>
                <span>30名</span>
              </div>
              <div class="info-item">
                <span class="label">参加費：</span>
                <span>会員2,000円 / 一般5,000円</span>
              </div>
            </div>
            <button class="apply-btn">申し込む</button>
          </div>
        </div>

        <div class="seminar-card">
          <div class="seminar-date">
            <div class="month">5月</div>
            <div class="day">25</div>
            <div class="year">2025</div>
          </div>
          <div class="seminar-content full-width">
            <h3>DX推進セミナー ～中小企業のデジタル変革～</h3>
            <p class="seminar-description">
              デジタル技術を活用した業務改善と新たなビジネスモデルの構築方法を学びます。
              実際の導入事例を通じて、自社に適したDX戦略を考えます。
            </p>
            <div class="seminar-info">
              <div class="info-item">
                <span class="label">時間：</span>
                <span>14:00～17:00</span>
              </div>
              <div class="info-item">
                <span class="label">会場：</span>
                <span>ハイブリッド開催</span>
              </div>
              <div class="info-item">
                <span class="label">定員：</span>
                <span>会場30名 / オンライン100名</span>
              </div>
              <div class="info-item">
                <span class="label">参加費：</span>
                <span>会員無料 / 一般3,000円</span>
              </div>
            </div>
            <button class="apply-btn">申し込む</button>
          </div>
        </div>
      </div>

      <div class="past-seminars">
        <h2>過去のセミナー・アーカイブ</h2>
        <p>会員の方は過去のセミナー資料・動画をご覧いただけます</p>
        <div class="archive-grid">
          <div class="archive-item">
            <div class="archive-date">2025.03.15</div>
            <h4>地域経済の未来を考える</h4>
            <a href="#" class="archive-link">資料を見る</a>
          </div>
          <div class="archive-item">
            <div class="archive-date">2025.02.28</div>
            <h4>経営戦略立案ワークショップ</h4>
            <a href="#" class="archive-link">動画を見る</a>
          </div>
          <div class="archive-item">
            <div class="archive-date">2025.02.10</div>
            <h4>補助金・助成金活用セミナー</h4>
            <a href="#" class="archive-link">資料を見る</a>
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

export default {
  name: "SeminarPage",
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

.seminar-intro {
  text-align: center;
  margin-bottom: 40px;
}

.lead-text {
  font-size: 1.1rem;
  line-height: 1.8;
  color: #666;
}

.seminar-categories {
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

.seminar-list {
  display: grid;
  gap: 30px;
  margin-bottom: 60px;
}

.seminar-card {
  background: white;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
  display: flex;
  transition: transform 0.3s;
}

.seminar-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 5px 20px rgba(0,0,0,0.15);
}

.seminar-card.upcoming {
  border: 2px solid #dc3545;
}

.seminar-date {
  background: #dc3545;
  color: white;
  padding: 30px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  min-width: 120px;
}

.seminar-date .month {
  font-size: 1rem;
  margin-bottom: 5px;
}

.seminar-date .day {
  font-size: 2.5rem;
  font-weight: bold;
  line-height: 1;
}

.seminar-date .year {
  font-size: 0.9rem;
  margin-top: 5px;
}

.seminar-image {
  position: relative;
  width: 300px;
  flex-shrink: 0;
}

.seminar-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.seminar-badge {
  position: absolute;
  top: 20px;
  right: 20px;
  background: #28a745;
  color: white;
  padding: 5px 15px;
  border-radius: 20px;
  font-size: 0.85rem;
  font-weight: 600;
}

.seminar-content {
  flex: 1;
  padding: 30px;
}

.seminar-content.full-width {
  flex: 1;
}

.seminar-content h3 {
  color: #333;
  font-size: 1.5rem;
  margin-bottom: 15px;
}

.seminar-description {
  color: #666;
  line-height: 1.6;
  margin-bottom: 20px;
}

.seminar-info {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 10px;
  margin-bottom: 25px;
}

.info-item {
  color: #666;
  font-size: 0.95rem;
}

.info-item .label {
  font-weight: 600;
  color: #333;
}

.apply-btn {
  background: #dc3545;
  color: white;
  border: none;
  padding: 12px 30px;
  border-radius: 25px;
  font-size: 1rem;
  cursor: pointer;
  transition: all 0.3s;
}

.apply-btn:hover {
  background: #c82333;
  transform: scale(1.05);
}

.past-seminars {
  background: white;
  padding: 50px;
  border-radius: 10px;
  text-align: center;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.past-seminars h2 {
  color: #dc3545;
  font-size: 2rem;
  margin-bottom: 10px;
}

.past-seminars p {
  color: #666;
  margin-bottom: 30px;
}

.archive-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 30px;
  margin-top: 30px;
}

.archive-item {
  padding: 25px;
  border: 1px solid #dee2e6;
  border-radius: 10px;
  text-align: left;
  transition: all 0.3s;
}

.archive-item:hover {
  border-color: #dc3545;
  box-shadow: 0 3px 10px rgba(220, 53, 69, 0.2);
}

.archive-date {
  color: #dc3545;
  font-size: 0.9rem;
  margin-bottom: 10px;
}

.archive-item h4 {
  color: #333;
  margin-bottom: 15px;
}

.archive-link {
  color: #dc3545;
  text-decoration: none;
  font-weight: 500;
  transition: color 0.3s;
}

.archive-link:hover {
  color: #c82333;
  text-decoration: underline;
}

@media (max-width: 768px) {
  .seminar-card {
    flex-direction: column;
  }
  
  .seminar-image {
    width: 100%;
    height: 200px;
  }
  
  .seminar-info {
    grid-template-columns: 1fr;
  }
  
  .archive-grid {
    grid-template-columns: 1fr;
  }
}
</style>