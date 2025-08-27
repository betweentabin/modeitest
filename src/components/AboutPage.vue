<template>
  <div class="page-container">
    <Navigation />
    <div class="page-content">
      <div class="about-header">
        <h1>{{ pageData ? pageData.title : '会社概要' }}</h1>
        <p class="subtitle">ABOUT US</p>
      </div>

      <div class="about-content">
        <section class="company-info">
          <h2>会社情報</h2>
          <table class="info-table">
            <tr>
              <th>会社名</th>
              <td>株式会社ちくぎん地域経済研究所</td>
            </tr>
            <tr>
              <th>設立</th>
              <td>1991年4月</td>
            </tr>
            <tr>
              <th>所在地</th>
              <td>
                〒839-0864<br />
                福岡県久留米市百年公園1番1号<br />
                久留米リサーチセンタービル6階
              </td>
            </tr>
            <tr>
              <th>電話番号</th>
              <td>0942-46-5081</td>
            </tr>
            <tr>
              <th>営業時間</th>
              <td>平日 9:00～17:00</td>
            </tr>
            <tr>
              <th>事業内容</th>
              <td>
                <ul>
                  <li>地域経済に関する調査研究</li>
                  <li>経営コンサルティング</li>
                  <li>セミナー・研修会の開催</li>
                  <li>情報提供サービス</li>
                  <li>人財開発支援</li>
                </ul>
              </td>
            </tr>
          </table>
        </section>

        <section class="access-info">
          <h2>アクセス情報</h2>
          
          <div class="access-section">
            <h3>電車でお越しの場合</h3>
            <ul class="access-list">
              <li>宮の陣駅：約1.2km 徒歩で約14分</li>
              <li>櫛原駅：約1.2km 徒歩で約14分</li>
              <li>五郎丸駅：約1.9km 徒歩で約23分</li>
            </ul>
          </div>

          <div class="access-section">
            <h3>お車でお越しの場合</h3>
            <ul class="access-list">
              <li>【予約制】軒先パーキング 合川スタンド跡駐車場：約497m 徒歩で約6分</li>
              <li>タイムズ合川町混：約811m 徒歩で約10分</li>
              <li>Dパーキング諏訪野町第1：約830m 徒歩で約10分</li>
            </ul>
          </div>

          <div class="map-container">
            <img src="/img/rectangle-3.png" alt="地図" class="map-image" />
          </div>
        </section>
        
        <section class="mission" v-if="pageData && pageData.content">
          <h2>私たちの理念</h2>
          <div class="mission-content">
            <div class="mission-text">
              <h3>{{ pageData.content.mission || '地域と共に歩む' }}</h3>
              <p>{{ pageData.content.mission || 'ちくぎん地域経済研究所は、産・官・学・金（金融機関）のネットワークを活かし、地域経済の持続的な発展と地域企業の成長を支援することを使命としています。' }}</p>
              <p>{{ pageData.content.history || '1991年の設立以来、福岡県久留米市を拠点に、九州地域の経済発展に貢献してまいりました。長年培ってきた知識と経験、そして幅広いネットワークを活用し、企業活動を総合的にサポートいたします。' }}</p>
              <div v-if="pageData.content.team">
                <p>エコノミスト: {{ pageData.content.team.economists }}名</p>
                <p>データサイエンティスト: {{ pageData.content.team.data_scientists }}名</p>
                <p>エンジニア: {{ pageData.content.team.engineers }}名</p>
              </div>
            </div>
            <div class="mission-image">
              <img src="/img/image-2.png" alt="研究所イメージ" />
            </div>
          </div>
        </section>
      </div>
    </div>
    <FooterComplete />
  </div>
</template>

<script>
import Navigation from "./Navigation.vue";
import FooterComplete from "./FooterComplete.vue";
import axios from 'axios';
import { getApiUrl } from '@/config/api';

export default {
  name: "AboutPage",
  components: {
    Navigation,
    FooterComplete
  },
  data() {
    return {
      pageData: null,
      loading: true,
      error: null
    };
  },
  async mounted() {
    try {
      const response = await axios.get(getApiUrl('/api/pages/about'));
      this.pageData = response.data;
      this.loading = false;
    } catch (err) {
      console.error('Failed to fetch page data:', err);
      this.error = 'ページデータの取得に失敗しました';
      this.loading = false;
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

.about-header {
  text-align: center;
  margin-bottom: 40px;
}

.about-header h1 {
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

.about-content {
  background: white;
  padding: 40px;
  border-radius: 10px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.company-info h2,
.access-info h2,
.mission h2,
.partner-logos h2 {
  color: #dc3545;
  margin-bottom: 30px;
  font-size: 1.8rem;
}

.info-table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 40px;
}

.info-table th {
  background-color: #f8f9fa;
  padding: 15px;
  text-align: left;
  width: 150px;
  border-bottom: 2px solid #dee2e6;
}

.info-table td {
  padding: 15px;
  border-bottom: 1px solid #dee2e6;
}

.info-table ul {
  margin: 0;
  padding-left: 20px;
}

.access-info {
  margin-top: 40px;
  padding-top: 40px;
  border-top: 2px solid #dee2e6;
}

.access-section {
  margin-bottom: 30px;
}

.access-section h3 {
  color: #333;
  font-size: 1.3rem;
  margin-bottom: 15px;
}

.access-list {
  list-style: none;
  padding: 0;
}

.access-list li {
  padding: 10px 0;
  border-bottom: 1px solid #f0f0f0;
  color: #666;
}

.map-container {
  margin-top: 30px;
  text-align: center;
}

.map-image {
  max-width: 100%;
  height: auto;
  border-radius: 10px;
}

.mission {
  margin-top: 40px;
  padding-top: 40px;
  border-top: 2px solid #dee2e6;
}

.mission p {
  line-height: 1.8;
  color: #666;
  font-size: 1.1rem;
}

.mission-content {
  display: flex;
  align-items: center;
  gap: 40px;
}

.mission-text {
  flex: 1;
}

.mission-text h3 {
  color: #333;
  font-size: 1.5rem;
  margin-bottom: 20px;
}

.mission-text p {
  margin-bottom: 15px;
}

.mission-image {
  flex: 0 0 300px;
}

.mission-image img {
  width: 100%;
  height: auto;
  border-radius: 10px;
}

@media (max-width: 768px) {
  .mission-content {
    flex-direction: column;
  }
  
  .mission-image {
    flex: none;
    width: 100%;
  }
}
</style>