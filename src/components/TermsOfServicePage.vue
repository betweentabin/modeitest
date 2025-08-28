<template>
  <div class="page-container">
    <Navigation />
    
    <!-- Hero Section -->
    <div class="hero-section">
      <div class="hero-overlay">
        <div class="hero-content">
          <h1 class="hero-title">利用規約</h1>
          <p class="hero-subtitle">terms of service</p>
        </div>
      </div>
    </div>

    <div class="page-content">
      <!-- Header -->
      <div class="page-header">
        <h2 class="section-title">利用規約</h2>
        <p class="section-subtitle">terms of service</p>
      </div>

      <!-- Introduction -->
      <div class="intro-section">
        <p>
          このウェブサイト（ http://www.chikugin-cri.co.jp ）は下記ウェブサイトといいます）は、株式会社ちくぎん地域経済研究所（以下「当社」という）により管理運営しています。
        </p>
        <p>
          利用にあたっては、以下の諸条件をお読みいただき、ご了解していただいたうえでご利用ください。なお、当研究所時の当ウェブサイトをご利用された場合には、本規約の記載事項に同意いただいたものといたします。
        </p>
      </div>

      <!-- Terms Sections -->
      <div class="terms-sections">
        <div class="terms-section">
          <h3>著作権等について</h3>
          <p>
            当ウェブサイトに掲載されている文章や画像（写真、図、ライン等）の著作権等知的財産権は、当研究所又は正当な権利者に帰属いたします。したがって、これらを無断で複製、採録、改変することはできません。
          </p>
        </div>

        <div class="terms-section">
          <h3>リンクについて</h3>
          <p>
            当ウェブサイトは、リンクフリーサイトにし他の当ウェブサイトへ移転や今後の判断によりメニューバリューが構成されております。詳細した全サウェブサイトは当
            研究所が運営するものではないあり得ません。したがって、その内容に関してい当研究所内で情報を集約することはございませんのでご了承ください。
          </p>
        </div>

        <div class="terms-section">
          <h3>免責事項</h3>
          <p>
            当ウェブサイトに掲載された情報、また、当ウェブサイトを利用することで生じたいかなる特別、間接的、演技、仲介等、当
            研究所が故意によるものでない限り当責任を負いません。
          </p>
          <p>
            また、当ウェブサイトについてシステムメンテナンス、機器の故障、通信事情、ネット関連要因などにより、予告なく一時的にサービスを中断することがあります。
            また、問題により、当研究所内部での責任を負いません。
          </p>
        </div>

        <div class="terms-section">
          <h3>セキュリティについて</h3>
          <p>
            当ウェブサイトのセキュリティ向上を目的として、TLS（Transport Layer Security）という情報の暗号化により通信時
            の漏洩防止を継続して継続しています。ただこのお客様一個人での暗号化によりクッキーマ等を削除することで当暗号化されます。
            また、今時のウェブサイトはダウンロードでき分類等に対応しコンピューターウイルス等に注目するニューウイルス関連
            の実行を行わないでください。
          </p>
        </div>

        <div class="terms-section">
          <h3>クッキー（Cookie）について</h3>
          <p>
            当ウェブサイトでは、より良い等サイトの向上の実現のために、セキュリティの向上を目的に、クッキー（Cookie）を利用することがあります
            ます。
          </p>
          <p>
            クッキー（Cookie）とは、お客様のウェブサイトでアクセスする際にウェブサイトを効率的に取得動けるのに本一つトップ。
            クッキーの利用を好ましい、今後の様々個々の基礎サービストラブルアクセスする被書事後、または書をお客様。利用でスロ
            ご利用をした。そのほか、ブラウザの設定でクッキー（Cookie）の受信を完全することがございます。
          </p>
        </div>

        <div class="terms-section">
          <h3>ご利用環境について</h3>
          <p>このサイトはInternet Explorer7.0以上およびFirefox3.0以上のバージョンでの動作を推奨します。</p>
        </div>

        <div class="terms-section">
          <h3>禁止される行為</h3>
          <ol>
            <li>当ウェブサイトに対し技術的手段を用いて過度の負荷をかけたり、当ウェブサイトの持続的な機能を妨害することを</li>
            <li>当ウェブサイトの内容に公序良俗の中止を求めること</li>
            <li>当研究所の第三者の信用を毀損するような行為、ウェブサイトでの行為をすること</li>
            <li>当研究所、または第三者の著作権、商標権その他の知的財産権、肖像権、プライバシー、その他の権利を侵害する こと</li>
            <li>過度の営業活動を誘発することにおいてそのシステムなされること</li>
            <li>システムの関連保守並行処は期間やを継続すること</li>
            <li>当ウェブサイト並びに第三者にに課すやを課せることを</li>
            <li>当研究所以なるように継続、あるいは各種の者が容易に運営することなく</li>
            <li>上記の代本、または上記による機会には、多額には当研究所の判断により制に課す運営性することを</li>
            <li>その内容公等について継続・公開に対らすこと</li>
          </ol>
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
  name: "TermsOfServicePage",
  components: {
    Navigation,
    FooterComplete
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

.page-header {
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

/* Introduction */
.intro-section {
  background: #f8f9fa;
  border-radius: 15px;
  padding: 30px;
  margin-bottom: 40px;
  border-left: 4px solid #da5761;
}

.intro-section p {
  color: #666;
  line-height: 1.8;
  font-size: 1rem;
  margin-bottom: 15px;
}

.intro-section p:last-child {
  margin-bottom: 0;
}

/* Terms Sections */
.terms-sections {
  display: flex;
  flex-direction: column;
  gap: 30px;
}

.terms-section {
  background: white;
  border-radius: 15px;
  padding: 30px;
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.terms-section h3 {
  font-size: 1.3rem;
  color: #333;
  margin-bottom: 20px;
  font-weight: bold;
  border-bottom: 2px solid #da5761;
  padding-bottom: 10px;
}

.terms-section p {
  color: #666;
  line-height: 1.8;
  margin-bottom: 15px;
}

.terms-section p:last-child {
  margin-bottom: 0;
}

.terms-section ol {
  color: #666;
  line-height: 1.8;
  padding-left: 20px;
}

.terms-section li {
  margin-bottom: 10px;
}

/* Responsive Design */
@media (max-width: 768px) {
  .hero-title {
    font-size: 2rem;
  }
  
  .page-content {
    padding: 40px 15px;
  }
  
  .intro-section,
  .terms-section {
    padding: 20px;
  }
  
  .terms-section h3 {
    font-size: 1.2rem;
  }
}

@media (max-width: 480px) {
  .intro-section p,
  .terms-section p,
  .terms-section li {
    font-size: 0.9rem;
  }
}
</style>
