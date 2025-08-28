<template>
  <div class="page-container">
    <Navigation />
    
    <!-- Hero Section -->
    <div class="hero-section">
      <div class="hero-overlay">
        <div class="hero-content">
          <h1 class="hero-title">プライバシーポリシー</h1>
          <p class="hero-subtitle">privacy policy</p>
        </div>
      </div>
    </div>

    <div class="page-content">
      <!-- Header -->
      <div class="page-header">
        <h2 class="section-title">プライバシーポリシー</h2>
        <p class="section-subtitle">privacy policy</p>
      </div>

      <!-- Introduction -->
      <div class="intro-section">
        <p>
          当研究所では以下のプライバシーポリシーに基づき、お客様より頂戴する個人情報を適正な手順に従い、暗号化し、
          当研究所の発行する研修会における参加者との秘匿化サービスを安全に運用しており、当研究所のセキュリティが守られている限り上記の個人には、
          プライバシーポリシーに記載したためのものでございます。本プライバシーポリシーの内容を確認したものでございます。
        </p>
      </div>

      <!-- Policy Sections -->
      <div class="policy-sections">
        <div class="policy-section">
          <h3>適切な取得</h3>
          <p>
            当研究所では、当研究所の各業務やサービスをご利用いただくにあたって、個人の特性を把握する必要があります。お客様の個人情報をお聞きすることがございます。あらかじめ、当社は、収集、取得、管理、各種配信における本人もしくは第三者の正当な利益を害することのないよう、また正当な事由がある場合には、各種配信・個人情報の更新により完全にご利用いただくことができます。これらの情報は、すべてにお応えして収集し、適時に分析のために活用させていただく場合がございます。
          </p>
        </div>

        <div class="policy-section">
          <h3>個人情報を収集・利用する目的</h3>
          <p>当研究所が個人情報を収集または取得する目的は以下のとおりです。</p>
          <ol>
            <li>研修会等お申込みいただいたお客様への案内のため</li>
            <li>サービスに関するお問い合わせやアンケート調査等をするため</li>
            <li>各種営業活動や分析・お研修・ご案内に活用するため</li>
            <li>研修会等の運営および企画に関するため</li>
            <li>規約の改正、実施のためにお知らせ、報告をするため</li>
            <li>サービスにおける将来へのお客様との改善するため</li>
          </ol>
        </div>

        <div class="policy-section">
          <h3>情報の第三者への開示について</h3>
          <ol>
            <li>法令により開示が必要とする場合のため</li>
            <li>人の生命、身体または財産の保護のため等の緊急を要する当研究所の判断により、本人の同意を得ることが困難であると認められる場合</li>
            <li>公衆衛生の向上または児童の健全な育成の推進のため特に必要がある場合であって本人の同意を得ることが困難であると認められる場合</li>
            <li>国の機関もしくは地方公共団体またはその委託を受けた者が法令の定める事務を遂行することに対して協力する必要がある場合であって本人の同意を得ることにより当該事務の遂行に支障を及ぼすおそれがある場合</li>
            <li>委託会社において個人情報を取り扱わせる場合等では管理を明記</li>
          </ol>
        </div>

        <div class="policy-section">
          <h3>個人情報の訂正および削除</h3>
          <p>
            当研究所が保有する個人情報について、ご本人の過誤等があった場合に限り、そのものについて修正いたします。
            （1）当研究所が保有する各日の個人情報の開示を求められた場合に必要があります。
            （2）当研究所が保有する各日の個人情報の利用目的の通知を求められた場合に利用目的をお知らせします。
            （3）当研究所が保有する各日の個人情報の訂正・加法・削除を求められた場合に当研究所側にて当該個人情報について必要な対応をさせていただき、
            　　　また、申請者にそのむ結果をお伝えします。
          </p>
        </div>

        <div class="policy-section">
          <h3>免責事項</h3>
          <p>
            当研究所では、お客様の個人情報の機密性、また、当ウェブサイトを安全な環境のもとで適用はしますが、可能、
            当研究所が使用するものについてであって、当研究所に機密保持義務として適切であることにより可能。または、当ウェブサイトの内容確に問題した第三者へ、
            また、問題についても、当研究所内部での責任を負いません。
          </p>
        </div>

        <div class="policy-section">
          <h3>適切な取得</h3>
          <p>
            当研究所のサイトを利用した場合、お客様のプライバシーポリシーに同意したものとお考えします。修正条項により、上記
            記載のプライバシーポリシーを変更した場合は、新記、新、金庫、新記等を行うことがあります。注記。プライバシーポリシーに
            ついて、重要な変更をご連絡させて事項については、当研究所のサイトに記載のとおりとします。
          </p>
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
  name: "PrivacyPolicyPage",
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
}

/* Policy Sections */
.policy-sections {
  display: flex;
  flex-direction: column;
  gap: 30px;
}

.policy-section {
  background: white;
  border-radius: 15px;
  padding: 30px;
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.policy-section h3 {
  font-size: 1.3rem;
  color: #333;
  margin-bottom: 20px;
  font-weight: bold;
  border-bottom: 2px solid #da5761;
  padding-bottom: 10px;
}

.policy-section p {
  color: #666;
  line-height: 1.8;
  margin-bottom: 15px;
}

.policy-section ol {
  color: #666;
  line-height: 1.8;
  padding-left: 20px;
}

.policy-section li {
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
  .policy-section {
    padding: 20px;
  }
  
  .policy-section h3 {
    font-size: 1.2rem;
  }
}

@media (max-width: 480px) {
  .intro-section p,
  .policy-section p,
  .policy-section li {
    font-size: 0.9rem;
  }
}
</style>
