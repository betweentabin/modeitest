<template>
  <div class="container-center-horizontal">
    <div class="about-business-mobile screen">
      <Navigation2 />
      <img
        class="hero-image-mobile"
        src="/img/hero-image-2.png"
        alt="Hero Image"
      />
      <div class="content-section-mobile">
        <div class="text-mobile">{{ text29 || 'トップ' }}</div>
        <div class="text-mobile">{{ text30 || '>' }}</div>
        <div class="text-mobile">{{ text31 || '会社事業紹介' }}</div>
        <div class="title-mobile">{{ text32 || '事業内容について' }}</div>
        <div class="description-mobile">{{ text33 || '弊社の主要事業をご紹介いたします。' }}</div>
        <div class="about-title-mobile">{{ text43 || '事業紹介' }}</div>
      </div>
      <NavigationFooter2 />
    </div>
  </div>
</template>

<script>
import Navigation2 from "./Navigation2";
import NavigationFooter2 from "./NavigationFooter2";

export default {
  name: "ScreenMobile",
  components: {
    Navigation2,
    NavigationFooter2,
  },
  props: {
    heroImageProps: {
      type: Object,
      default: () => ({}),
    },
    text29: {
      type: String,
      default: "",
    },
    text30: {
      type: String,
      default: "",
    },
    text31: {
      type: String,
      default: "",
    },
    text32: {
      type: String,
      default: "",
    },
    text33: {
      type: String,
      default: "",
    },
    text43: {
      type: String,
      default: "",
    },
  },
};
</script>

<style scoped>
.about-business-mobile {
  display: flex;
  flex-direction: column;
  width: 100%;
  max-width: 768px;
  margin: 0 auto;
  background-color: var(--cararra);
}

.hero-image-mobile {
  width: 100%;
  height: auto;
  margin-bottom: 20px;
}

.content-section-mobile {
  padding: 20px;
  display: flex;
  flex-direction: column;
  gap: 30px;
}

.breadcrumb-mobile {
  display: flex;
  flex-direction: column;
  gap: 8px;
  font-size: 12px;
  color: var(--ship-gray);
}

.main-content-mobile {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.title-mobile {
  font-size: 18px;
  font-weight: bold;
  color: var(--eerie-black);
  line-height: 1.4;
}

.description-mobile {
  font-size: 14px;
  color: var(--ship-gray);
  line-height: 1.6;
}

.about-mobile {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.about-title-mobile {
  font-size: 20px;
  font-weight: bold;
  color: var(--eerie-black);
  text-align: center;
}

.text-mobile {
  font-size: 12px;
  color: var(--ship-gray);
}

@media (max-width: 767px) {
  .content-section-mobile {
    padding: 15px;
  }
  
  .title-mobile {
    font-size: 16px;
  }
  
  .description-mobile {
    font-size: 13px;
  }
}
</style>
