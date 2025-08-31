<template>
  <div class="cri-consulting-page">
    <Navigation />
    
    <!-- Hero Section -->
    <HeroSection 
      title="CRI 経営コンサルティング"
      subtitle="consulting"
      heroImage="https://api.builder.io/api/v1/image/assets/TEMP/db22880ee1d73553a2fa432da82e4e20fe5c43c9?width=2880"
    />
    
    <!-- Breadcrumbs -->
    <Breadcrumbs :breadcrumbs="['CRI 経営コンサルティング']" />
    
    <!-- What is CRI Consulting Section -->
    <div class="what-is-section">
      <div class="section-header">
        <h2 class="section-title">CRI 経営コンサルティングとは？</h2>
        <div class="section-divider">
          <div class="divider-line"></div>
          <span class="divider-text">consulting</span>
          <div class="divider-line"></div>
        </div>
      </div>
      
      <div class="content-container">
        <img src="https://api.builder.io/api/v1/image/assets/TEMP/f016525f0cc061901e592a57545785e894630484?width=940" alt="Consulting Image" class="content-image" />
        <div class="content-text">
          <h3 class="content-subtitle">What's CRI Management Consulting</h3>
          <h4 class="content-heading">CRI経営コンサルティングとは、事業でお悩みの皆様に対し、アドバイス、サポートするサービスです</h4>
          <p class="content-description">
            日常の企業活動の中で、まず自社が抱える様々な問題や課題・顧客ニーズなどに気付き、それらを整理して対応策を講じることができれば、改善に向けて新たなスタートを切ったと言えましょう。
            しかし、「何か変だ。」と思いながらもとりあえず一日の業務を無事に終えたことに安心していては、身近に存在する重要なことに気付くのが遅れることもあります。
          </p>
        </div>
      </div>
    </div>
    
    <!-- Main Duties Section -->
    <div class="main-duties-section">
      <div class="section-header">
        <h2 class="section-title">CRI経営コンサルティングの主な業務</h2>
        <div class="section-divider">
          <div class="divider-line"></div>
          <span class="divider-text">main duties</span>
          <div class="divider-line"></div>
        </div>
        <p class="section-subtitle">事業にまつわる様々をサポート行います。<br>当研究所のネットワークを活かし、御社の実情に合う専門家もご紹介できます。</p>
      </div>
      
      <div class="duties-container">
        <div class="duties-content">
          <h3 class="duties-title">MAIN DUTIES</h3>
          <h4 class="duties-heading">事業にまつわる様々な悩みを一緒に解決します</h4>
          <div class="duties-list">
            <p>経営戦略策定のサポート</p>
            <p>ビジネスマッチィングの支援</p>
            <p>事業継承の支援（後継者育成支援）</p>
            <p>社員研修、経営計画策定のための人材育成</p>
            <p>税務、財務、事務など各業務の課題解決力の育成</p>
            <p>事務省力化のサポート</p>
            <p>人事制度の策定</p>
            <p>ワンストップのよろず差相談</p>
          </div>
        </div>
        <img src="https://api.builder.io/api/v1/image/assets/TEMP/25a28ba9ea089f902a21c4d02c416034111f837a?width=1304" alt="Main Duties Image" class="duties-image" />
      </div>
      
      <p class="duties-description">
        当研究所だけで対応できないことは、CRIのもつネットワークを活用し、相談者の実情に合う専門家をご紹介いたします。その上で一緒に課題解決に向けて動いていきます。専門家が加わることで、状況に応じたよりよい解決方法を導き出すことができます。
      </p>
    </div>

    <!-- Contact CTA Section -->
    <ContactSection />
    
    <!-- Support Content and Costs Section -->
    <div class="support-section">
      <div class="section-header">
        <h2 class="section-title">サポート内容と費用に関して</h2>
        <div class="section-divider">
          <div class="divider-line"></div>
          <span class="divider-text">contents and costs</span>
          <div class="divider-line"></div>
        </div>
        <p class="section-subtitle">経営改善とは会社の中の「人」が変わることです。<br>ご相談と問題点・課題の整理は無料です。まずは、お気軽にご相談ください。</p>
      </div>
      
      <div class="support-content">
        <div class="support-category">
          <h3 class="category-title">無料 -FREE-</h3>
          <div class="service-grid">
            <div class="service-card">
              <img src="https://api.builder.io/api/v1/image/assets/TEMP/33cee256926cd28b9a1a674d35fd9166a56602c3?width=590" alt="Consultation" class="service-image" />
              <div class="service-info">
                <span class="service-label">consultation</span>
                <h4 class="service-title">ご相談</h4>
              </div>
              <div class="service-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                  <path d="M13.125 2.25V21.75C13.125 22.0484 13.0065 22.3345 12.7955 22.5455C12.5845 22.7565 12.2984 22.875 12 22.875C11.7016 22.875 11.4155 22.7565 11.2045 22.5455C10.9935 22.3345 10.875 22.0484 10.875 21.75V2.25C10.875 1.95163 10.9935 1.66548 11.2045 1.4545C11.4155 1.24353 11.7016 1.125 12 1.125C12.2984 1.125 12.5845 1.24353 12.7955 1.4545C13.0065 1.66548 13.125 1.95163 13.125 2.25Z" fill="#1A1A1A"/>
                </svg>
              </div>
            </div>
            <div class="service-card">
              <img src="https://api.builder.io/api/v1/image/assets/TEMP/31768edf86418d36cb69d49cceebe7329e674e2b?width=590" alt="Problem Analysis" class="service-image" />
              <div class="service-info">
                <span class="service-label">problem</span>
                <h4 class="service-title">問題点・課題の整理</h4>
              </div>
            </div>
          </div>
        </div>
        
        <div class="support-divider"></div>
        
        <div class="support-category">
          <h3 class="category-title">有料 -PAID-</h3>
          <div class="service-grid">
            <div class="service-card">
              <img src="https://api.builder.io/api/v1/image/assets/TEMP/3ae2d367ee53d3693e55ab25762bbc22b1e79db3?width=590" alt="Strategy Planning" class="service-image" />
              <div class="service-info">
                <span class="service-label">consultation</span>
                <h4 class="service-title">対応策の立案</h4>
              </div>
            </div>
            <div class="service-card">
              <img src="https://api.builder.io/api/v1/image/assets/TEMP/314b38f7051166e9dfefd653b917881f2e188fb0?width=590" alt="Improvement Activities" class="service-image" />
              <div class="service-info">
                <span class="service-label">problem</span>
                <h4 class="service-title">改善に向けた活動</h4>
              </div>
            </div>
            <div class="service-card">
              <img src="https://api.builder.io/api/v1/image/assets/TEMP/e92448f8521df04fdda36093ecdc836ecfdcbdbb?width=590" alt="Analysis" class="service-image" />
              <div class="service-info">
                <span class="service-label">problem</span>
                <h4 class="service-title">分析（新たな課題認識）</h4>
              </div>
            </div>
            <div class="service-card">
              <img src="https://api.builder.io/api/v1/image/assets/TEMP/ccca71dcedbebcbeb9188be2f5b67ca86225155f?width=590" alt="New Business Activities" class="service-image" />
              <div class="service-info">
                <span class="service-label">problem</span>
                <h4 class="service-title">新たな事業活動</h4>
              </div>
            </div>
          </div>
        </div>
        
        <div class="support-divider"></div>
        
        <div class="support-description">
          <p>「経営改善」とは、会社（ハード）が変わるのではなく、会社の中にいる「人」（ソフト）が変わることです。 ちくぎん地域経済研究所は、事業のお悩み解決のために、あなたにぴったりの解決策をご提案いたします。<br>どうぞお気軽にご相談ください。</p>
          <button class="contact-btn">
            <span>お問い合わせはコチラ</span>
            <svg width="18" height="19" viewBox="0 0 18 19" fill="none">
              <rect y="0.5" width="18" height="18" rx="5" fill="white"/>
              <path d="M13.2193 10.2752L9.7194 13.875C9.64643 13.95 9.54746 13.9922 9.44427 13.9922C9.34107 13.9922 9.24211 13.95 9.16914 13.875C9.09617 13.7999 9.05517 13.6981 9.05517 13.592C9.05517 13.4858 9.09617 13.3841 9.16914 13.309L12.0055 10.3922L4.38888 10.3922C4.28574 10.3922 4.18683 10.35 4.1139 10.275C4.04097 10.2 4 10.0983 4 9.99219C4 9.88611 4.04097 9.78437 4.1139 9.70936C4.18683 9.63435 4.28574 9.59221 4.38888 9.59221L12.0055 9.59221L9.16914 6.67537C9.09617 6.60032 9.05517 6.49853 9.05517 6.39239C9.05517 6.28625 9.09617 6.18446 9.16914 6.1094C9.24211 6.03435 9.34107 5.99219 9.44427 5.99219C9.54746 5.99219 9.64643 6.03435 9.7194 6.1094L13.2193 9.7092C13.2554 9.74635 13.2841 9.79046 13.3037 9.83902C13.3233 9.88758 13.3333 9.93962 13.3333 9.99219C13.3333 10.0448 13.3233 10.0968 13.3037 10.1454C13.2841 10.1939 13.2554 10.238 13.2193 10.2752Z" fill="#1A1A1A"/>
            </svg>
          </button>
        </div>
      </div>
    </div>
    
    <!-- Achievements Section -->
    <div class="achievements-section">
      <div class="section-header">
        <h2 class="section-title">CRI経営コンサルティングの実績紹介</h2>
        <div class="section-divider">
          <div class="divider-line"></div>
          <span class="divider-text">achievements</span>
          <div class="divider-line"></div>
        </div>
      </div>
      
      <div class="achievements-content">
        <div class="achievements-grid">
          <div class="achievement-card">
            <img src="https://api.builder.io/api/v1/image/assets/TEMP/ec6122758f12e1bfbe99ee61905a31ea4d49a78c?width=574" alt="Achievement 1" class="achievement-image" />
            <div class="achievement-info">
              <div class="achievement-meta">
                <span class="achievement-date">2025.6.27</span>
                <span class="achievement-category">カテゴリー</span>
              </div>
              <h4 class="achievement-title">分析（新たな課題認識）</h4>
              <p class="achievement-description">
                有限会社AliveCast 中村理氏による「誰もおしえてくれない、プロと一緒に考えるインターネットを使った"売れる仕組みづくり"」セミナーを開催。 ホームページの作成や運営に様々な疑問を抱えていた参加者様が多く、「非常に参考になった」「インターネットだけではなく自社の今後の戦略にも役立った」との声もあり、大変ご好評いただいたセミナーでした。
              </p>
            </div>
          </div>
          
          <div class="achievement-card">
            <img src="https://api.builder.io/api/v1/image/assets/TEMP/95f39033c1a29bc732f48805d8362c58b24c766c?width=574" alt="Achievement 2" class="achievement-image" />
            <div class="achievement-info">
              <div class="achievement-meta">
                <span class="achievement-date">2025.6.27</span>
                <span class="achievement-category">カテゴリー</span>
              </div>
              <h4 class="achievement-title">分析（新たな課題認識）</h4>
              <p class="achievement-description">
                在上海中国ビジネスウォッチャー姫田小夏氏による「当世上海事情」講演会を開催しました。 自らも上海に居住し、独自の目線で中国ビジネスをとらえる姫田氏は「中国中小企業の貪欲さ、すさまじい競争がある限り、中国はまだまだ発展の余地はある」と講演され、聴講者はメモを取りながら聞き入っていました。
              </p>
            </div>
          </div>
          
          <div class="achievement-card">
            <img src="https://api.builder.io/api/v1/image/assets/TEMP/9c17e76e3ac6cf114e40472b8f2ce93b5bfa00f3?width=574" alt="Achievement 3" class="achievement-image" />
            <div class="achievement-info">
              <div class="achievement-meta">
                <span class="achievement-date">2025.6.27</span>
                <span class="achievement-category">カテゴリー</span>
              </div>
              <h4 class="achievement-title">分析（新たな課題認識）</h4>
              <p class="achievement-description">
                Excel 2010 講座を開催。今回の講座は知っておくと実務が効率化できるような、中級者〜上級者向けの講座でしたが、受講者の理解度・満足度は高く、次回の講座の要望もありました。 今やパソコンスキルは企業では必須とされています。CRIでは今後も実務に役立つ講座を実施していく予定です。
              </p>
            </div>
          </div>
          
          <div class="achievement-card">
            <img src="https://api.builder.io/api/v1/image/assets/TEMP/5dabcf000de42e14f9010cb47622d830cacdf698?width=574" alt="Achievement 4" class="achievement-image" />
            <div class="achievement-info">
              <div class="achievement-meta">
                <span class="achievement-date">2025.6.27</span>
                <span class="achievement-category">カテゴリー</span>
              </div>
              <h4 class="achievement-title">分析（新たな課題認識）</h4>
              <p class="achievement-description">
                上海経済事情視察ツアーを実施。「上海開拓の糸口を探る」と題したこのツアーには、様々な業種の方々にご参加いただきました。 ツアー参加者様からは「今後のビジネスの参考にしたい」「中国から得るものは大きい」と、大変満足度の高いツアーとなりました。
              </p>
            </div>
          </div>
        </div>
        
        <div class="achievements-divider"></div>
        
        <p class="achievements-note">
          このほか「Hot Information」の配信や「経営参考BOOK」の配布も定期的に行っております。調査・研究の受託にも応じますので、お気軽にお問い合わせください。
        </p>
      </div>
    </div>
    
    <!-- Action Button Section -->
    <ActionButton 
      primary-text="お問い合わせはコチラ"
      secondary-text="入会はコチラ"
      @primary-click="handleContactClick"
      @secondary-click="handleJoinClick"
    />
    
    <!-- Access Section -->
    <AccessSection />

    <!-- Footer Navigation -->
    <div class="navigation-footer">
      <Footer v-bind="frame132131753022Props" />
      <div class="vector-7-1"></div>
      <group27 />
      </div>
    
    <!-- Fixed Side Buttons -->
    <FixedSideButtons position="bottom" />
  </div>
</template>

<script>
import AccessSection from './AccessSection.vue';
import Navigation from "./Navigation";
import Footer from "./Footer";
import ContactSection from "./ContactSection.vue";
import HeroSection from "./HeroSection.vue";
import Breadcrumbs from "./Breadcrumbs.vue";
import FixedSideButtons from "./FixedSideButtons.vue";
import ActionButton from "./ActionButton.vue";

import Group27 from "./Group27";
import { homePageData, frame132131753022Data } from "../data";

export default {
  name: "CriConsultingPage",
  components: {
    Navigation,
    Footer,
    ContactSection,
    AccessSection,
    Group27,
    HeroSection,
    Breadcrumbs,
    FixedSideButtons,
    ActionButton
  },
  data() {
    return {
      // Access section data
      
      // Footer data
      frame132131753022Props: homePageData.frame132131753022Props,
    };
  },
  mounted() {
    this.adjustImageHeight();
    this.adjustRectangleHeight();
    window.addEventListener('resize', this.adjustImageHeight);
    window.addEventListener('resize', this.adjustRectangleHeight);
  },
  beforeDestroy() {
    window.removeEventListener('resize', this.adjustImageHeight);
    window.removeEventListener('resize', this.adjustRectangleHeight);
  },
  methods: {
    adjustImageHeight() {
      this.$nextTick(() => {
        const contentText = this.$el.querySelector('.content-text');
        const contentImage = this.$el.querySelector('.content-image');
        
        if (contentText && contentImage) {
          const textHeight = contentText.offsetHeight;
          contentImage.style.height = textHeight + 'px';
        }
        
        const dutiesContent = this.$el.querySelector('.duties-content');
        const dutiesImage = this.$el.querySelector('.duties-image');
        
        if (dutiesContent && dutiesImage) {
          const dutiesHeight = dutiesContent.offsetHeight;
          dutiesImage.style.height = dutiesHeight + 'px';
        }
      });
    },
    adjustRectangleHeight() {
      this.$nextTick(() => {
        const frame1321317466 = this.$el.querySelector('.frame-1321317466');
        const rectangle3 = this.$el.querySelector('.rectangle-3');
        
        if (frame1321317466 && rectangle3) {
          const frameHeight = frame1321317466.offsetHeight;
          rectangle3.style.height = frameHeight + 'px';
        }
      });
    },
    handleContactClick() {
      this.$router.push('/contact');
    },
    handleJoinClick() {
      this.$router.push('/register');
    }
  }
};
</script>

<style scoped>
.cri-consulting-page {
  background-color: #ECECEC;
  min-height: 100vh;
  width: 100%;
}



/* Section Headers */
.section-header {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 29px;
  margin-bottom: 40px;
}

.section-title {
  color: #1A1A1A;
  text-align: center;
  font-family: Inter, -apple-system, Roboto, Helvetica, sans-serif;
  font-size: 36px;
  font-weight: 700;
  line-height: normal;
  letter-spacing: -0.72px;
  margin: 0;
}

.section-divider {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 15px;
}

.divider-line {
  width: 69px;
  height: 2px;
  background: #DA5761;
}

.divider-text {
  color: #DA5761;
  font-family: Inter, -apple-system, Roboto, Helvetica, sans-serif;
  font-size: 20px;
  font-weight: 700;
}

.section-subtitle {
  color: #1A1A1A;
  text-align: center;
  font-family: Inter, -apple-system, Roboto, Helvetica, sans-serif;
  font-size: 18px;
  font-weight: 400;
  line-height: normal;
  letter-spacing: -0.36px;
  max-width: 1014px;
}

/* What is CRI Section */
.what-is-section {
  width: 100%;
  padding: 70px 50px 50px;
}

.content-container {
  background-color: #FFF;
  border-radius: 20px;
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  max-width: 2000px;
  margin: 0 auto;
}

.content-image {
  width: 50%;
  border-radius: 20px 0 0 20px;
  object-fit: cover;
  object-position: center;
}

.content-text {
  flex: 1;
  padding: 50px;
  background: #FFF;
  border-radius: 0 20px 20px 0;
  display: flex;
  flex-direction: column;
  gap: 40px;
}

.content-subtitle {
  color: #DA5761;
  font-family: Inter, -apple-system, Roboto, Helvetica, sans-serif;
  font-size: 64px;
  font-weight: 700;
  line-height: 110%;
  margin: 0;
}

.content-heading {
  color: #1A1A1A;
  font-family: Inter, -apple-system, Roboto, Helvetica, sans-serif;
  font-size: 28px;
  font-weight: 700;
  line-height: 150%;
  margin: 0;
}

.content-description {
  color: #3F3F3F;
  font-family: Noto Sans JP, -apple-system, Roboto, Helvetica, sans-serif;
  font-size: 18px;
  font-weight: 400;
  line-height: normal;
  margin: 0;
}

/* Main Duties Section */
.main-duties-section {
  width: 100%;
  padding: 50px 50px 80px;
}

.duties-container {
  background: #FFF;
  border-radius: 20px;
  display: flex;
  align-items: flex-start;
  max-width: 2000px;
  margin: 0 auto;
}

.duties-content {
  flex: 1;
  padding: 50px;
  background: #FFF;
  border-radius: 20px 0 0 20px;
  display: flex;
  flex-direction: column;
  gap: 40px;
}

.duties-title {
  color: #DA5761;
  font-family: Inter, -apple-system, Roboto, Helvetica, sans-serif;
  font-size: 64px;
  font-weight: 700;
  line-height: 150%;
  margin: 0;
}

.duties-heading {
  color: #1A1A1A;
  font-family: Inter, -apple-system, Roboto, Helvetica, sans-serif;
  font-size: 28px;
  font-weight: 700;
  line-height: 150%;
  margin: 0;
}

.duties-list {
  display: flex;
  flex-direction: column;
  gap: 5px;
}

.duties-list p {
  color: #3F3F3F;
  font-family: Inter, -apple-system, Roboto, Helvetica, sans-serif;
  font-size: 18px;
  font-weight: 400;
  line-height: normal;
  margin: 0;
}

.duties-image {
  width: 50%;
  border-radius: 0 20px 20px 0;
  object-fit: cover;
  object-position: center;
}

.duties-description {
  color: #1A1A1A;
  text-align: center;
  font-family: Inter, -apple-system, Roboto, Helvetica, sans-serif;
  font-size: 18px;
  font-weight: 400;
  line-height: normal;
  letter-spacing: -0.36px;
  max-width: 1140px;
  margin: 0 auto;
  margin-top: 50px;
}

/* Support Section */
.support-section {
  width: 100%;
  padding: 80px 50px 50px;
}

.support-content {
  padding: 50px;
  border-radius: 20px;
  background: #FFF;
  max-width: 2000px;
  margin: 0 auto;
  display: flex;
  flex-direction: column;
  gap: 50px;
}

.support-category {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.category-title {
  color: #1A1A1A;
  font-family: Inter, -apple-system, Roboto, Helvetica, sans-serif;
  font-size: 36px;
  font-weight: 700;
  line-height: normal;
  margin: 0;
}

.service-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 20px;
}

.service-card {
  position: relative;
  border-radius: 20px;
  overflow: hidden;
  background: #FFF;
}

.service-image {
  width: 100%;
  height: 294px;
  object-fit: cover;
  border-radius: 20px;
}

.service-info {
  position: absolute;
  bottom: 0;
  left: 83px;
  background: #FFF;
  padding: 13px;
  border-radius: 10px 0 0 0;
  width: 100%;
}

.service-label {
  color: #DA5761;
  font-family: Inter, -apple-system, Roboto, Helvetica, sans-serif;
  font-size: 15px;
  font-weight: 400;
  display: block;
  margin-bottom: 5px;
}

.service-title {
  color: #3F3F3F;
  font-family: Inter, -apple-system, Roboto, Helvetica, sans-serif;
  font-size: 18px;
  font-weight: 700;
  margin: 0;
}

.service-icon {
  position: absolute;
  bottom: 28px;
  left: 55px;
  width: 24px;
  height: 24px;
}

.support-divider {
  width: 100%;
  height: 1px;
  background: #CFCFCF;
}

.support-description {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 50px;
}

.support-description p {
  color: #1A1A1A;
  font-family: Inter, -apple-system, Roboto, Helvetica, sans-serif;
  font-size: 18px;
  font-weight: 400;
  line-height: normal;
  letter-spacing: -0.36px;
  text-align: center;
  margin: 0;
}

.contact-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  width: 380px;
  padding: 10px 0;
  border-radius: 10px;
  background: #1A1A1A;
  border: none;
  cursor: pointer;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
}

.contact-btn span {
  color: #FFF;
  font-family: Inter, -apple-system, Roboto, Helvetica, sans-serif;
  font-size: 15px;
  font-weight: 700;
  line-height: 150%;
}

/* Achievements Section */
.achievements-section {
  width: 100%;
  padding: 50px;
}

.achievements-content {
  padding: 50px;
  border-radius: 20px;
  background: #FFF;
  max-width: 2000px;
  margin: 0 auto;
  display: flex;
  flex-direction: column;
  gap: 50px;
}

.achievements-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 30px;
}

.achievement-card {
  background: #FFF;
  border-radius: 10px;
  overflow: hidden;
}

.achievement-image {
  width: 100%;
  height: 186px;
  object-fit: cover;
  border-radius: 10px;
}

.achievement-info {
  padding: 20px 0;
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.achievement-meta {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.achievement-date {
  color: #3F3F3F;
  font-family: Inter, -apple-system, Roboto, Helvetica, sans-serif;
  font-size: 15px;
  font-weight: 400;
}

.achievement-category {
  color: #FFF;
  font-family: Inter, -apple-system, Roboto, Helvetica, sans-serif;
  font-size: 13px;
  font-weight: 400;
  padding: 5px 38px 6px;
  border-radius: 100px;
  background: #DA5761;
}

.achievement-title {
  color: #1A1A1A;
  font-family: Inter, -apple-system, Roboto, Helvetica, sans-serif;
  font-size: 20px;
  font-weight: 700;
  line-height: normal;
  margin: 0;
}

.achievement-description {
  color: #3F3F3F;
  font-family: Inter, -apple-system, Roboto, Helvetica, sans-serif;
  font-size: 18px;
  font-weight: 400;
  line-height: normal;
  margin: 0;
}

.achievements-divider {
  width: 100%;
  height: 1px;
  background: #CFCFCF;
}

.achievements-note {
  color: #1A1A1A;
  font-family: Inter, -apple-system, Roboto, Helvetica, sans-serif;
  font-size: 18px;
  font-weight: 400;
  line-height: normal;
  letter-spacing: -0.36px;
  text-align: center;
  margin: 0;
}

/* Company Intro Section */
.company-intro-section {
  width: 100%;
  height: 351px;
  background: #FF6B6B;
  position: relative;
  background-image: url('https://api.builder.io/api/v1/image/assets/TEMP/42f6878f33350b96e3bbff6f048c352a254e8e2e?width=2882');
  background-size: cover;
  background-position: center;
}

.company-intro-overlay {
  background: rgba(77, 77, 77, 0.70);
  width: 100%;
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  padding: 50px;
}

.company-intro-content {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 30px;
  max-width: 600px;
  text-align: center;
}

.company-intro-title {
  color: #FFF;
  font-family: Inter, -apple-system, Roboto, Helvetica, sans-serif;
  font-size: 40px;
  font-weight: 700;
  line-height: 150%;
  margin: 0;
}

.company-intro-subtitle {
  color: #FFF;
  font-family: Inter, -apple-system, Roboto, Helvetica, sans-serif;
  font-size: 20px;
  font-weight: 700;
  line-height: 150%;
  margin: 0;
}

.company-intro-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  width: 380px;
  padding: 10px 0;
  border-radius: 10px;
  background: #DA5761;
  border: none;
  cursor: pointer;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
}

.company-intro-btn span {
  color: #FFF;
  font-family: Inter, -apple-system, Roboto, Helvetica, sans-serif;
  font-size: 15px;
  font-weight: 700;
  line-height: 150%;
}





/* Responsive Design */
@media (max-width: 1150px) {
  .frame-1321317467-1 {
    flex-direction: column;
    gap: 20px;
  }
  
  .rectangle-3 {
    width: 100%;
    max-width: none;
    order: 2;
  }
  
  .frame-1321317466 {
    order: 1;
  }
}

/* Footer Navigation */
.navigation-footer {
  align-items: center;
  background-color: var(--celeste);
  display: flex;
  flex-direction: column;
  gap: 50px;
  padding: 100px;
  position: relative;
  width: 100%;
  max-width: 100vw;
  z-index: 4;
  box-sizing: border-box;
}

.vector-7-1 {
  height: 1px;
  background-color: #B2B2B2;
  position: relative;
  width: 100%;
  max-width: 1240px;
}

/* Access Section */

.access-title-container svg {
  position: absolute;
  left: 0;
  top: 18px;
}

.access-main-title {
  color: #1A1A1A;
  font-family: Inter, -apple-system, Roboto, Helvetica, sans-serif;
  font-size: 48px;
  font-weight: 700;
  line-height: 150%;
  position: absolute;
  left: 0;
  top: 54px;
  margin: 0;
}

.access-subtitle {
  color: #1A1A1A;
  font-family: Inter, -apple-system, Roboto, Helvetica, sans-serif;
  font-size: 24px;
  font-weight: 700;
  line-height: 150%;
  position: absolute;
  left: 114px;
  top: 0;
}

.access-map {
  width: 692px;
  height: 398px;
  border-radius: 10px;
  object-fit: cover;
}

.info-section {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.info-title {
  color: #DA5761;
  font-family: Inter, -apple-system, Roboto, Helvetica, sans-serif;
  font-size: 20px;
  font-weight: 700;
  line-height: 200%;
  margin: 0;
}

.info-item {
  color: #1A1A1A;
  font-family: Inter, -apple-system, Roboto, Helvetica, sans-serif;
  font-size: 16px;
  font-weight: 400;
  line-height: 200%;
  margin: 0;
}



/* Responsive Design */
@media (max-width: 1200px) {
  .content-container,
  .duties-container {
    flex-direction: column;
  }
  
  .content-image,
  .duties-image {
    width: 100%;
    border-radius: 20px;
  }
  
  .service-grid,
  .achievements-grid {
    grid-template-columns: repeat(2, 1fr);
  }

  .access-map {
    width: 100%;
  }
}

@media (max-width: 768px) {
  .hero-title {
    font-size: 28px;
  }
  
  .section-title {
    font-size: 28px;
  }
  
  .content-subtitle,
  .duties-title {
    font-size: 48px;
  }
  
  .service-grid,
  .achievements-grid {
    grid-template-columns: 1fr;
  }
  
  .cta-btn {
    width: 100%;
    padding: 15px 20px;
  }
  

}
</style>
