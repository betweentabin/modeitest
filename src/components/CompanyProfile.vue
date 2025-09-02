<template>
  <div class="company-profile">
    <navigation />

    <!-- Hero Section -->
    <HeroSection 
      title="会社概要"
      subtitle="About Us"
      heroImage="https://api.builder.io/api/v1/image/assets/TEMP/df7ca8cd2f554040b151c3c0f960f06d9826cc19?width=2880"
    />

    <!-- Breadcrumbs -->
    <Breadcrumbs :breadcrumbs="['会社概要']" />

    <!-- Philosophy Section -->
    <section class="philosophy-section">
      <div class="section-header">
        <h2 class="section-title">経営理念</h2>
        <div class="section-divider">
          <div class="divider-line"></div>
          <span class="divider-text">philosophy</span>
          <div class="divider-line"></div>
        </div>
      </div>
      <div class="philosophy-content">
        <img class="philosophy-image" src="https://api.builder.io/api/v1/image/assets/TEMP/01501a28725d762f4b766643e9bcd235f2e43e2e?width=1340" alt="Philosophy" />
        <div class="philosophy-text">
          <div class="mission-title">OUR MISSION</div>
          <div class="mission-content">
            <h3 class="mission-heading">産官学金のネットワーク活用による地域貢献</h3>
            <p class="mission-description">
              <span class="mission-line">・地域に根差した経済 / 産業の調査 / 研究</span><br>
              <span class="mission-line">・地域経済を担う企業 / 医療 / 農業 / 学術研究活動のサポート</span><br>
              <span class="mission-line">・未来を支える「人」づくり</span>
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- Message Section -->
    <section class="message-section">
      <div class="section-header">
        <h2 class="section-title">ご挨拶</h2>
        <div class="section-divider">
          <div class="divider-line"></div>
          <span class="divider-text">message</span>
          <div class="divider-line"></div>
        </div>
      </div>
      <div class="message-content">
        <div class="message-text">
          <div class="message-title">MESSAGE</div>
          <div class="message-body">
            <p>皆さま方には、平素より筑邦銀行グループをご利用お引き立ていただき誠にありがとうございます。</p>
            <p>私どもは「地域社会へのご奉仕」という基本理念のもと、総合金融サービスの向上・充実に努めてまいりました。こうした中で、地元のさらなる発展に貢献するため、「(株)ちくぎん地域経済研究所」を設立いたしました。</p>
            <p>当研究所では、産・官・学・金（金融機関）のネットワークの構築などにより、今後一層発展の可能性を秘めたバイオ・アグリ・医療・介護をはじめ様々な分野の調査研究をより専門的に行うことといたします。</p>
            <p>また、こうした研究成果や様々なネットワークを活用し経営コンサルティング機能を十分に発揮することなどにより、多様な企業の生産・販売活動や医療・介護活動などのサポートを行ってまいります。</p>
            <p>以上のような活動を通じ、皆さま方と緊密な連携のもと、ヒト・モノ・カネ・情報を最大限に活かし、地域の振興・発展にお役にたてるよう努めてまいる所存です。</p>
            <p>当研究所へのご支援、ご愛顧をよろしくお願い申し上げます。</p>
          </div>
          <div class="message-signature">株式会社 ちくぎん地域経済研究所代表取締役社長 空閑 重信</div>
        </div>
        <img class="message-image" src="https://api.builder.io/api/v1/image/assets/TEMP/20aa75cfa1be4c2096a1f47bf126cf240173b231?width=1340" alt="Message" />
      </div>
    </section>

    <!-- Contact CTA Section -->
    <ContactSection />

    <!-- Company Profile Section -->
    <section class="company-profile-section">
      <div class="section-header">
        <h2 class="section-title">会社概要</h2>
        <div class="section-divider">
          <div class="divider-line"></div>
          <span class="divider-text">company profile</span>
          <div class="divider-line"></div>
        </div>
      </div>
      <div class="profile-table">
        <div class="profile-row">
          <div class="profile-label">会社名</div>
          <div class="profile-value">株式会社 ちくぎん地域経済研究所</div>
        </div>
        <div class="profile-row">
          <div class="profile-label">設立</div>
          <div class="profile-value">平成23年7月1日</div>
        </div>
        <div class="profile-row">
          <div class="profile-label">住所</div>
          <div class="profile-value">〒839-0864<br>福岡県久留米市百年公園1番1号 久留米リサーチセンタービル6階</div>
        </div>
        <div class="profile-row">
          <div class="profile-label">代表者</div>
          <div class="profile-value">代表取締役社長　空閑 重信</div>
        </div>
        <div class="profile-row">
          <div class="profile-label">資本金</div>
          <div class="profile-value">3,000万円</div>
        </div>
        <div class="profile-row">
          <div class="profile-label">株主</div>
          <div class="profile-value">筑邦銀行　および筑邦銀行グループ会社 （ちくぎんリース(株)、昭光(株)、筑邦信用保証(株)）</div>
        </div>
        <div class="profile-row">
          <div class="profile-label">組織体制</div>
          <div class="profile-value">企画部、調査部</div>
        </div>
      </div>
    </section>

    <!-- History Section -->
    <section class="history-section">
      <div class="section-header">
        <h2 class="section-title">沿革</h2>
        <div class="section-divider">
          <div class="divider-line"></div>
          <span class="divider-text">history</span>
          <div class="divider-line"></div>
        </div>
      </div>
      <div class="history-content">
        <div class="history-item">
          <div class="history-year">1988</div>
          <div class="history-details">
            <div class="history-date">昭和63年1月30日</div>
            <div class="history-description">ちくぎんコンピュータサービス（株）設立</div>
          </div>
        </div>
        <div class="history-item">
          <div class="history-year">2010</div>
          <div class="history-details">
            <div class="history-date">平成22年6月29日</div>
            <div class="history-description">ちくぎんコンピュータサービス（株）の定款変更により、経営コンサルティング業務・経済調査等業務を追加。</div>
          </div>
        </div>
        <div class="history-item">
          <div class="history-year">2011</div>
          <div class="history-details">
            <div class="history-date">平成23年7月1日</div>
            <div class="history-description">社名変更　（株）ちくぎん地域経済研究所として新たにスタート。<br>主たる業務は調査・研究、人材開発、IT関連サービス、経営支援（経営サポート）、コンシェルジュサービス。</div>
          </div>
        </div>
        <button class="detail-button arrow-dark">
          詳細はこちら
          <svg width="18" height="19" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect y="0.5" width="18" height="18" rx="5" fill="white"/>
            <path d="M13.2193 10.2752L9.7194 13.875C9.64643 13.95 9.54746 13.9922 9.44427 13.9922C9.34107 13.9922 9.24211 13.95 9.16914 13.875C9.09617 13.7999 9.05517 13.6981 9.05517 13.592C9.05517 13.4858 9.09617 13.3841 9.16914 13.309L12.0055 10.3922L4.38888 10.3922C4.28574 10.3922 4.18683 10.35 4.1139 10.275C4.04097 10.2 4 10.0983 4 9.99219C4 9.88611 4.04097 9.78437 4.1139 9.70936C4.18683 9.63435 4.28574 9.59221 4.38888 9.59221L12.0055 9.59221L9.16914 6.67537C9.09617 6.60032 9.05517 6.49853 9.05517 6.39239C9.05517 6.28625 9.09617 6.18446 9.16914 6.1094C9.24211 6.03435 9.34107 5.99219 9.44427 5.99219C9.54746 5.99219 9.64643 6.03435 9.7194 6.1094L13.2193 9.7092C13.2554 9.74635 13.2841 9.79046 13.3037 9.83902C13.3233 9.88758 13.3333 9.93962 13.3333 9.99219C13.3333 10.0448 13.3233 10.0968 13.3037 10.1454C13.2841 10.1939 13.2554 10.238 13.2193 10.2752Z" fill="#1A1A1A"/>
          </svg>
        </button>
      </div>
    </section>

    <!-- Staff Section -->
    <section class="staff-section">
      <div class="section-header">
        <h2 class="section-title">所員紹介</h2>
        <div class="section-divider">
          <div class="divider-line"></div>
          <span class="divider-text">About us</span>
          <div class="divider-line"></div>
        </div>
      </div>
      <div class="staff-carousel">
        <div class="carousel-container">
          <button class="carousel-prev">
            <svg width="16" height="44" viewBox="0 0 16 44" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M0.544218 24.0321L12.8448 43.1583C13.1914 43.6972 13.6615 44 14.1517 44C14.6419 44 15.112 43.6972 15.4587 43.1583C15.8053 42.6193 16 41.8883 16 41.1261C16 40.3639 15.8053 39.6329 15.4587 39.094L4.46349 22.0024L15.4556 4.90604C15.6272 4.63918 15.7633 4.32236 15.8562 3.97368C15.9491 3.62501 15.9969 3.2513 15.9969 2.87389C15.9969 2.49649 15.9491 2.12278 15.8562 1.7741C15.7633 1.42542 15.6272 1.10861 15.4556 0.841744C15.2839 0.574878 15.0802 0.363189 14.8559 0.218762C14.6317 0.0743358 14.3914 -2.81188e-09 14.1486 0C13.9059 2.81189e-09 13.6656 0.0743357 13.4413 0.218762C13.2171 0.363189 13.0133 0.574878 12.8417 0.841744L0.541144 19.9678C0.369335 20.2347 0.233092 20.5517 0.14023 20.9005C0.047369 21.2494 -0.000284195 21.6234 9.53674e-07 22.001C0.000287056 22.3786 0.0485067 22.7524 0.141896 23.1009C0.235286 23.4495 0.372005 23.7659 0.544218 24.0321Z" fill="#1A1A1A"/>
            </svg>
          </button>
          <div class="staff-members">
            <div class="staff-member">
              <img class="staff-photo" src="https://api.builder.io/api/v1/image/assets/TEMP/013d1cd8a9cd502c97404091dee8168d1aa93903?width=452" alt="森田 祥子" />
              <div class="staff-info">
                <div class="staff-position">企画部　部長代理</div>
                <div class="staff-name">森田 祥子 <span class="staff-reading">- もりた さちこ -</span></div>
                <div class="staff-note">（アジア福岡パートナーズへ出向）</div>
              </div>
            </div>
            <div class="staff-member">
              <img class="staff-photo" src="https://api.builder.io/api/v1/image/assets/TEMP/3eb35c11c5738cb9283fd65048f0db5c42dd1080?width=451" alt="溝上 浩文" />
              <div class="staff-info">
                <div class="staff-position">取締役企画部長　兼調査部長</div>
                <div class="staff-name">溝上 浩文 <span class="staff-reading">- みぞかみ ひろふみ -</span></div>
              </div>
            </div>
            <div class="staff-member">
              <img class="staff-photo" src="https://api.builder.io/api/v1/image/assets/TEMP/ce433d9c00a0ce68895c315df3a3c49aa626deff?width=451" alt="空閑 重信" />
              <div class="staff-info">
                <div class="staff-position">代表取締役社長</div>
                <div class="staff-name">空閑 重信 <span class="staff-reading">- くが しげのぶ -</span></div>
              </div>
            </div>
            <div class="staff-member">
              <img class="staff-photo" src="https://api.builder.io/api/v1/image/assets/TEMP/b21372a6aca15dfc189c6953aeb23f36f5d5e20b?width=451" alt="髙田 友里恵" />
              <div class="staff-info">
                <div class="staff-position">調査部　主任</div>
                <div class="staff-name">髙田 友里恵 <span class="staff-reading">- たかだ ゆりえ -</span></div>
              </div>
            </div>
            <div class="staff-member">
              <img class="staff-photo" src="https://api.builder.io/api/v1/image/assets/TEMP/497e67c9baa8add863ab6c5cc32439cf23eea4c3?width=451" alt="中村 公栄" />
              <div class="staff-info">
                <div class="staff-position"></div>
                <div class="staff-name">中村 公栄 <span class="staff-reading">- なかむら きえみ -</span></div>
              </div>
            </div>
          </div>
          <button class="carousel-next">
            <svg width="16" height="44" viewBox="0 0 16 44" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M15.4558 24.0321L3.15522 43.1583C2.8086 43.6972 2.33848 44 1.84828 44C1.35809 44 0.88797 43.6972 0.54135 43.1583C0.194729 42.6193 3.65224e-09 41.8883 0 41.1261C-3.65224e-09 40.3639 0.194729 39.6329 0.54135 39.094L11.5365 22.0024L0.544425 4.90604C0.372796 4.63918 0.236652 4.32236 0.143767 3.97368C0.0508821 3.62501 0.00307463 3.2513 0.00307462 2.87389C0.00307462 2.49649 0.0508821 2.12278 0.143767 1.7741C0.236652 1.42542 0.372796 1.10861 0.544425 0.841744C0.716055 0.574878 0.919808 0.363189 1.14405 0.218762C1.3683 0.0743358 1.60864 -2.81188e-09 1.85136 0C2.09408 2.81189e-09 2.33442 0.0743357 2.55867 0.218762C2.78291 0.363189 2.98667 0.574878 3.15829 0.841744L15.4589 19.9678C15.6307 20.2347 15.7669 20.5517 15.8598 20.9005C15.9526 21.2494 16.0003 21.6234 16 22.001C15.9997 22.3786 15.9515 22.7524 15.8581 23.1009C15.7647 23.4495 15.628 23.7659 15.4558 24.0321Z" fill="#1A1A1A"/>
            </svg>
          </button>
        </div>
        <button class="detail-button arrow-dark">
          詳細はこちら
          <svg width="18" height="19" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect y="0.5" width="18" height="18" rx="5" fill="white"/>
            <path d="M13.2193 10.2752L9.7194 13.875C9.64643 13.95 9.54746 13.9922 9.44427 13.9922C9.34107 13.9922 9.24211 13.95 9.16914 13.875C9.09617 13.7999 9.05517 13.6981 9.05517 13.592C9.05517 13.4858 9.09617 13.3841 9.16914 13.309L12.0055 10.3922L4.38888 10.3922C4.28574 10.3922 4.18683 10.35 4.1139 10.275C4.04097 10.2 4 10.0983 4 9.99219C4 9.88611 4.04097 9.78437 4.1139 9.70936C4.18683 9.63435 4.28574 9.59221 4.38888 9.59221L12.0055 9.59221L9.16914 6.67537C9.09617 6.60032 9.05517 6.49853 9.05517 6.39239C9.05517 6.28625 9.09617 6.18446 9.16914 6.1094C9.24211 6.03435 9.34107 5.99219 9.44427 5.99219C9.54746 5.99219 9.64643 6.03435 9.7194 6.1094L13.2193 9.7092C13.2554 9.74635 13.2841 9.79046 13.3037 9.83902C13.3233 9.88758 13.3333 9.93962 13.3333 9.99219C13.3333 10.0448 13.3233 10.0968 13.3037 10.1454C13.2841 10.1939 13.2554 10.238 13.2193 10.2752Z" fill="#1A1A1A"/>
          </svg>
        </button>
      </div>
    </section>

        <!-- Access Section -->
    <AccessSection />

    <!-- Footer Navigation -->
    <Footer v-bind="frame132131753022Props" />

    <!-- Fixed Side Buttons -->
    <FixedSideButtons position="bottom" />
  </div>
</template>

<script>
import AccessSection from './AccessSection.vue';
import Navigation from "./Navigation";
import ContactSection from "./ContactSection.vue";
import Footer from "./Footer";
import Group27 from "./Group27";
import HeroSection from "./HeroSection.vue";
import Breadcrumbs from "./Breadcrumbs.vue";
import FixedSideButtons from "./FixedSideButtons.vue";

import vector7 from "../../public/img/vector-7.svg";
import { frame132131753022Data } from "../data";

export default {
  name: "CompanyProfile",
  components: {
    Navigation,
    ContactSection,
    Footer,
    Group27,
    AccessSection,
    HeroSection,
    Breadcrumbs,
    FixedSideButtons,
  },
  data() {
    return {
      vector7: vector7,
      frame132131753022Props: frame132131753022Data,
      
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
        const messageText = this.$el.querySelector('.message-text');
        const messageImage = this.$el.querySelector('.message-image');
        
        if (messageText && messageImage) {
          const textHeight = messageText.offsetHeight;
          messageImage.style.height = textHeight + 'px';
        }
        
        const philosophyText = this.$el.querySelector('.philosophy-text');
        const philosophyImage = this.$el.querySelector('.philosophy-image');
        
        if (philosophyText && philosophyImage) {
          const philosophyHeight = philosophyText.offsetHeight;
          philosophyImage.style.height = philosophyHeight + 'px';
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
    }
  }
};
</script>

<style scoped>
.company-profile {
  background-color: #ECECEC;
  font-family: 'Inter', Helvetica, sans-serif;
  position: relative;
  width: 100%;
  overflow-x: auto;
}





/* Section Styling */
section {
  padding: 70px 50px 50px;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 40px;
}

.section-header {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 29px;
}

.section-title {
  color: #1A1A1A;
  font-size: 36px;
  font-weight: 700;
  text-align: center;
  letter-spacing: -0.72px;
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
  font-size: 20px;
  font-weight: 700;
}

/* Philosophy Section */
.philosophy-section {
  background: #ECECEC;
  width: 100%;
  overflow: hidden;
}

.philosophy-content {
  display: flex;
  align-items: flex-start;
  width: 100%;
  max-width: 100%;
}

.philosophy-image {
  width: 50%;
  border-radius: 20px 0 0 20px;
  object-fit: cover;
  object-position: center;
}

.philosophy-text {
  width: 50%;
  height: auto;
  padding: 50px;
  background: white;
  border-radius: 0 20px 20px 0;
  display: flex;
  flex-direction: column;
  justify-content: center;
  gap: 40px;
}

.mission-title {
  color: #DA5761;
  font-family: Inter, -apple-system, Roboto, Helvetica, sans-serif;
  font-size: 64px;
  font-weight: 700;
  line-height: 110%;
  margin: 0;
}

.mission-content {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.mission-heading {
  color: #1A1A1A;
  font-size: 28px;
  font-weight: 700;
  line-height: 1.5;
}

.mission-description {
  color: #3F3F3F;
  font-family: 'Noto Sans JP', sans-serif;
  font-size: 20px;
  font-weight: 400;
  line-height: 1.2;
}

.mission-line {
  display: inline-block;
  text-indent: -1em;
  padding-left: 1em;
}

/* Message Section */
.message-section {
  background: #ECECEC;
  width: 100%;
  overflow: hidden;
}

.message-content {
  display: flex;
  align-items: flex-start;
  width: 100%;
  max-width: 100%;
}

.message-text {
  width: 50%;
  padding: 50px;
  background: white;
  border-radius: 20px 0 0 20px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: flex-end;
  gap: 40px;
}

.message-title {
  color: #DA5761;
  font-size: 64px;
  font-weight: 700;
  line-height: 1.5;
  align-self: stretch;
}

.message-body {
  color: #3F3F3F;
  font-family: 'Noto Sans JP', sans-serif;
  font-size: 20px;
  font-weight: 400;
  line-height: 1.2;
  align-self: stretch;
}

.message-body p {
  margin-bottom: 1em;
}

.message-signature {
  color: #3F3F3F;
  font-family: 'Noto Sans JP', sans-serif;
  font-size: 20px;
  font-weight: 400;
}

.message-image {
  width: 50%;
  border-radius: 0 20px 20px 0;
  object-fit: cover;
  object-position: center;
}

/* Company Profile Section */
.company-profile-section {
  background: #ECECEC;
}

.profile-table {
  background: white;
  border-radius: 20px;
  padding: 50px;
  width: 100%;
  max-width: 2000px;
  display: flex;
  flex-direction: column;
}

.profile-row {
  display: flex;
  justify-content: flex-start;
  align-items: center;
  height: auto;
  border-bottom: 0.5px dashed #DA5761;
  padding: 30px 0;
}

.profile-row:first-child {
  border-top: 0.5px dashed #DA5761;
}

.profile-label {
  color: #3F3F3F;
  font-size: 18px;
  font-weight: 700;
  line-height: 1.5;
  width: 180px;
  flex-shrink: 0;
}

.profile-value {
  color: #3F3F3F;
  font-size: 18px;
  font-weight: 400;
  line-height: 1.5;
}

/* History Section */
.history-section {
  background: #ECECEC;
}

.history-content {
  background: white;
  border-radius: 20px;
  padding: 50px;
  width: 100%;
  max-width: 2000px;
  display: flex;
  flex-direction: column;
}

.history-item {
  display: flex;
  padding: 30px 0;
  justify-content: flex-start;
  align-items: center;
  border-bottom: 0.5px dashed #DA5761;
}

.history-item:first-child {
  border-top: 0.5px dashed #DA5761;
}

.history-year {
  color: #DA5761;
  font-size: 60px;
  font-weight: 700;
  line-height: 1.5;
  width: 250px;
  flex-shrink: 0;
}

.history-details {
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.history-date {
  color: #1A1A1A;
  font-size: 20px;
  font-weight: 700;
  line-height: 1.5;
}

.history-description {
  color: #3F3F3F;
  font-size: 18px;
  font-weight: 400;
  line-height: 1.5;
}

.detail-button {
  background: #1A1A1A;
  border-radius: 10px;
  padding: 10px 0;
  width: 300px;
  height: 43px;
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 10px;
  border: none;
  cursor: pointer;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
  color: white;
  font-size: 15px;
  font-weight: 700;
  line-height: 1.5;
  margin: 0 auto;
  margin-top: 50px;
}

/* Staff Section */
.staff-section {
  background: #ECECEC;
}

.staff-carousel {
  background: white;
  border-radius: 20px;
  padding: 50px 40px;
  width: 100%;
  max-width: 2000px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  position: relative;
}

.carousel-prev, .carousel-next {
  background: transparent;
  border: none;
  cursor: pointer;
  width: 16px;
  height: 44px;
}

.staff-carousel {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.carousel-container {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 50px;
  width: 100%;
}

.staff-members {
  display: flex;
  gap: 10px;
  overflow-x: hidden;
  width: 90%;
}

.staff-member {
  width: calc((100% - 40px) / 5);
  display: flex;
  flex-direction: column;
  gap: 20px;
  flex-shrink: 0;
}

.staff-photo {
  width: 100%;
  aspect-ratio: 226 / 300;
  object-fit: cover;
}

.staff-info {
  display: flex;
  flex-direction: column;
  gap: 5px;
}

.staff-position {
  color: #1A1A1A;
  font-size: 12px;
  font-weight: 400;
  line-height: 1.5;
}

.staff-name {
  color: #1A1A1A;
  font-size: 20px;
  font-weight: 400;
  line-height: 1.5;
}

.staff-reading {
  font-size: 12px;
  font-weight: 400;
}

.staff-note {
  color: #1A1A1A;
  font-size: 12px;
  font-weight: 400;
  line-height: 1.5;
}

/* Access Section */

.access-map {
  width: 692px;
  height: 398px;
  border-radius: 10px;
}

.info-heading {
  color: #DA5761;
  font-size: 20px;
  font-weight: 700;
  line-height: 2;
  margin-bottom: 10px;
}

.info-item {
  color: #1A1A1A;
  font-size: 16px;
  font-weight: 400;
  line-height: 2;
  margin-bottom: 5px;
}

/* Footer Navigation */

.footer-navigation {
  background: #CFCFCF;
  padding: 50px 100px;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 50px;
}

.footer-links {
  display: flex;
  align-items: flex-start;
  gap: 60px;
}

.footer-column {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  gap: 20px;
  width: 171px;
}

.footer-item {
  display: flex;
  height: 18px;
  align-items: center;
  gap: 10px;
  align-self: stretch;
}

.footer-sub-item {
  display: flex;
  height: 15px;
  padding-left: 20px;
  align-items: center;
  gap: 10px;
  align-self: stretch;
}

.arrow-icon {
  width: 10px;
  height: 17px;
  fill: #DA5761;
}

.dash-icon {
  width: 2px;
  height: 10px;
  transform: rotate(90deg);
  fill: #DA5761;
}

.footer-item span,
.footer-sub-item span {
  color: #1A1A1A;
  font-size: 16px;
  font-weight: 400;
  line-height: 2;
}

.footer-divider {
  width: 1240px;
  height: 1px;
  border: none;
  background: #B2B2B2;
}

.footer-bottom {
  width: 716px;
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.footer-company {
  display: flex;
  align-items: center;
  gap: 20px;
  justify-content: center;
}

.footer-logo {
  width: 54px;
  height: 42px;
}

.footer-company-text {
  display: flex;
  flex-direction: column;
  gap: -5px;
}

.footer-company-name {
  color: #1A1A1A;
  font-size: 24px;
  font-weight: 700;
  line-height: 1.5;
}

.footer-group-name {
  color: #1A1A1A;
  font-size: 15px;
  font-weight: 700;
  line-height: 1.5;
}

.footer-contact {
  color: #1A1A1A;
  text-align: center;
  font-size: 20px;
  font-weight: 400;
  line-height: 1.2;
}

.footer-copyright {
  color: #1A1A1A;
  font-size: 15px;
  font-weight: 500;
  line-height: 1.5;
  text-align: center;
  margin-top: 20px;
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

  .philosophy-section,
  .message-section,
  .company-profile-section,
  .history-section,
  .staff-section {
    padding: 50px 20px;
  }

  .philosophy-text,
  .message-text,
  .profile-table,
  .history-content,
  .staff-carousel {
    padding: 30px 20px;
  }
  
  .philosophy-content,
  .message-content {
    flex-direction: column;
    gap: 0;
  }
  
  .philosophy-image,
  .philosophy-text,
  .message-text,
  .message-image {
    width: 100%;
  }
  
  .philosophy-image {
    border-radius: 20px 20px 0 0;
    height: 300px !important;
  }
  
  .philosophy-text {
    border-radius: 0 0 20px 20px;
    padding: 40px;
  }
  
  .message-text {
    border-radius: 0 0 20px 20px;
    padding: 40px;
    order: 2;
  }
  
  .message-image {
    border-radius: 20px 20px 0 0;
    height: 300px !important;
    order: 1;
  }

  .section-title {
    font-size: 32px !important;
  }

  .divider-text {
    font-size: 18px !important;
  }

  .mission-title,
  .message-title {
    font-size: 48px !important;
  }
  
  .mission-description,
  .message-body,
  .message-signature,
  .profile-value,
  .history-description {
    font-size: 18px !important;
  }

  .mission-heading,
  .history-date,
  .staff-name {
    font-size: 22px !important;
  }

  .staff-position,
  .staff-note,
  .staff-reading {
    font-size: 18px !important;
  }
  
  .history-item,
  .profile-row {
    flex-direction: column;
    gap: 10px;
    align-items: flex-start;
    padding: 10px 0;
  }
  
  .history-year {
    width: auto;
    font-size: 48px !important;
  }
  
  .history-details {
    width: 100%;
  }
}

@media (max-width: 900px) {
  .company-profile {
    overflow-x: hidden;
  }
  
  .navigation-header,
  .hero-section,
  .breadcrumbs,
  section,
  .contact-cta-section,
  .footer-navigation {
    min-width: auto;
    width: 100%;
  }
  
  .philosophy-section,
  .message-section {
    width: 100%;
    overflow: hidden;
  }
  
  .philosophy-content,
  .message-content {
    width: 100%;
    max-width: 100%;
  }

  .section-title {
    font-size: 29px !important;
  }

  .divider-text {
    font-size: 17px !important;
  }

  .mission-title,
  .message-title {
    font-size: 42px !important;
  }

  .mission-description,
  .message-body,
  .message-signature,
  .profile-value,
  .history-description {
    font-size: 17px !important;
  }

  .mission-heading,
  .history-date,
  .staff-name {
    font-size: 20px !important;
  }

  .staff-position,
  .staff-note,
  .staff-reading {
    font-size: 17px !important;
  }

  .history-year {
    font-size: 42px !important;
  }

  .staff-members {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    width: 100%;
    overflow-x: visible;
  }

  .staff-member {
    width: 100%;
  }

  .carousel-prev,
  .carousel-next {
    display: none;
  }
}

@media (max-width: 768px) {
  
  .staff-members {
    overflow-x: scroll;
  }

  .philosophy-content,
  .message-content {
    flex-direction: column;
    width: 100%;
    max-width: 100%;
  }
  
  .philosophy-image,
  .philosophy-text,
  .message-text,
  .message-image {
    width: 100%;
  }
  
  .philosophy-section,
  .message-section {
    width: 100%;
    overflow: hidden;
  }

  .section-title {
    font-size: 27px !important;
  }

  .divider-text {
    font-size: 16px !important;
  }

  .mission-title,
  .message-title {
    font-size: 38px !important;
  }

  .mission-description,
  .message-body,
  .message-signature,
  .profile-value,
  .history-description {
    font-size: 16px !important;
  }

  .mission-heading,
  .history-date,
  .staff-name {
    font-size: 19px !important;
  }

  .staff-position,
  .staff-note,
  .staff-reading {
    font-size: 16px !important;
  }

  .history-year {
    font-size: 38px !important;
  }
  
  .footer-links {
    flex-wrap: wrap;
    gap: 30px;
  }
}

@media (max-width: 480px) {
  .philosophy-section,
  .message-section {
    width: 100%;
    overflow: hidden;
  }

  .philosophy-section,
  .message-section,
  .company-profile-section,
  .history-section,
  .staff-section {
    padding: 30px 20px;
    gap: 20px;
  }
  
  .philosophy-content,
  .message-content {
    width: 100%;
    max-width: 100%;
  }
  
  .philosophy-text,
  .message-text {
    padding: 30px 20px;
    gap: 20px;
  }

  .history-year {
    font-size: 35px !important;
  }
  
  .mission-title,
  .message-title {
    font-size: 25px !important;
  }

  .mission-description,
  .message-body,
  .message-signature,
  .profile-value,
  .history-description {
    font-size: 13px !important;
  }

  .mission-heading,
  .history-date,
  .staff-name {
    font-size: 18px !important;
  }

  .staff-position,
  .staff-note,
  .staff-reading {
    font-size: 10px !important;
  }

  .staff-info {
    gap: 10px !important;
  }

  .staff-name {
    display: flex;
    flex-direction: column;
    gap: 0px;
  }

  .staff-reading {
    align-self: flex-start;
  }

  .philosophy-image {
    height: 200px !important;
  }

  .message-image {
    height: 200px !important;
    order: 1;
  }

  .detail-button {
    margin-top: 30px !important;
  }

  .section-header {
    gap: 20px !important;
    margin-bottom: 20px !important;
  }

  .section-title {
    font-size: 22px !important;
  }

  .divider-text {
    font-size: 13px !important;
  }
}
</style>
