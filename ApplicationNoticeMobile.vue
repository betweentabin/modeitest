<template>
  <div class="container-center-horizontal">
    <div class="application-notice-mobile screen">
      <navigation2 />
      <div class="hero-section-mobile">
        <hero-image2
          :heroImage="heroImageProps.heroImage"
          :membership="heroImageProps.membership"
          :text65="heroImageProps.text65"
        />
      </div>
      <div class="content-section-mobile">
        <div class="notice-header-mobile">
          <div class="notice-title-mobile">{{ noticeTitle }}</div>
          <div class="notice-subtitle-mobile">{{ noticeSubtitle }}</div>
        </div>
        <div class="notice-content-mobile">
          <div class="notice-text-mobile" v-html="noticeContent"></div>
        </div>
        <div class="action-section-mobile">
          <div class="action-buttons-mobile">
            <button class="primary-button-mobile">{{ primaryButtonText }}</button>
            <button class="secondary-button-mobile">{{ secondaryButtonText }}</button>
          </div>
        </div>
      </div>
      <navigation-footer2 />
    </div>
  </div>
</template>

<script>
import Navigation2 from "./Navigation2";
import HeroImage2 from "./HeroImage2";
import NavigationFooter2 from "./NavigationFooter2";

export default {
  name: "ApplicationNoticeMobile",
  components: {
    Navigation2,
    HeroImage2,
    NavigationFooter2,
  },
  props: {
    heroImageProps: {
      type: Object,
      default: () => ({}),
    },
    noticeTitle: {
      type: String,
      default: "お申し込み",
    },
    noticeSubtitle: {
      type: String,
      default: "申し込みに関するお知らせ",
    },
    noticeContent: {
      type: String,
      default: "",
    },
    primaryButtonText: {
      type: String,
      default: "申し込む",
    },
    secondaryButtonText: {
      type: String,
      default: "詳細を見る",
    },
  },
};
</script>

<style scoped>
.application-notice-mobile {
  display: flex;
  flex-direction: column;
  width: 100%;
  max-width: 768px;
  margin: 0 auto;
  background-color: var(--cararra);
}

.hero-section-mobile {
  width: 100%;
  margin-bottom: 20px;
}

.content-section-mobile {
  padding: 20px;
  display: flex;
  flex-direction: column;
  gap: 30px;
}

.notice-header-mobile {
  text-align: center;
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.notice-title-mobile {
  font-size: 20px;
  font-weight: bold;
  color: var(--eerie-black);
}

.notice-subtitle-mobile {
  font-size: 14px;
  color: var(--ship-gray);
}

.notice-content-mobile {
  background-color: var(--white);
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.1);
}

.notice-text-mobile {
  font-size: 14px;
  color: var(--ship-gray);
  line-height: 1.6;
}

.action-section-mobile {
  display: flex;
  justify-content: center;
}

.action-buttons-mobile {
  display: flex;
  flex-direction: column;
  gap: 15px;
  width: 100%;
  max-width: 300px;
}

.primary-button-mobile {
  background-color: var(--eerie-black);
  color: var(--white);
  border: none;
  padding: 15px 30px;
  border-radius: 10px;
  font-size: 15px;
  font-weight: bold;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.primary-button-mobile:hover {
  background-color: var(--ship-gray);
}

.secondary-button-mobile {
  background-color: var(--white);
  color: var(--eerie-black);
  border: 2px solid var(--eerie-black);
  padding: 15px 30px;
  border-radius: 10px;
  font-size: 15px;
  font-weight: bold;
  cursor: pointer;
  transition: all 0.3s ease;
}

.secondary-button-mobile:hover {
  background-color: var(--eerie-black);
  color: var(--white);
}

@media (max-width: 767px) {
  .content-section-mobile {
    padding: 15px;
  }
  
  .notice-content-mobile {
    padding: 15px;
  }
  
  .notice-title-mobile {
    font-size: 18px;
  }
  
  .action-buttons-mobile {
    max-width: 100%;
  }
}
</style>
