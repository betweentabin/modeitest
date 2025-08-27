<template>
  <div class="container-center-horizontal">
    <div class="business-overview-mobile screen">
      <Navigation2 />
      <img
        class="hero-image-mobile"
        src="/img/hero-image-3.png"
        alt="Hero Image"
      />
      <div class="content-section-mobile">
        <div class="membership-mobile">{{ membership || '会員向け' }}</div>
        <div class="title-mobile">{{ text75 || '事業概要詳細' }}</div>
        <div class="section-title-mobile">{{ text124 || '事業内容' }}</div>
        <div class="section-content-mobile">{{ text125 || '詳細な事業内容についてご説明いたします。' }}</div>
        <div class="about-title-mobile">{{ text128 || '主要サービス' }}</div>
        <div class="section-subtitle-mobile">{{ text131 || 'その他のサービス' }}</div>
      </div>
      <NavigationFooter2 />
    </div>
  </div>
</template>

<script>
import Navigation2 from "./Navigation2";
import NavigationFooter2 from "./NavigationFooter2";

export default {
  name: "Screen4Mobile",
  components: {
    Navigation2,
    NavigationFooter2,
  },
  props: {
    overlapGroup2: {
      type: String,
      default: "",
    },
    membership: {
      type: String,
      default: "",
    },
    text75: {
      type: String,
      default: "",
    },
    frame1321317534Props: {
      type: Object,
      default: () => ({}),
    },
    text124: {
      type: String,
      default: "",
    },
    text125: {
      type: String,
      default: "",
    },
    text128: {
      type: String,
      default: "",
    },
    text131: {
      type: String,
      default: "",
    },
  },
};
</script>

<style scoped>
.business-overview-mobile {
  display: flex;
  flex-direction: column;
  width: 100%;
  max-width: 768px;
  margin: 0 auto;
  background-color: var(--cararra);
}

.hero-section-mobile {
  width: 100%;
  min-height: 200px;
  display: flex;
  align-items: center;
  justify-content: center;
  background-size: cover;
  background-position: center;
  position: relative;
}

.hero-content-mobile {
  text-align: center;
  color: white;
  padding: 20px;
}

.membership-mobile {
  font-size: 10px;
  font-weight: bold;
  margin-bottom: 8px;
}

.title-mobile {
  font-size: 15px;
  font-weight: bold;
  margin-bottom: 10px;
}

.content-section-mobile {
  padding: 20px;
  display: flex;
  flex-direction: column;
  gap: 30px;
}

.section-mobile {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.section-title-mobile {
  font-size: 16px;
  font-weight: bold;
  color: var(--eerie-black);
}

.section-content-mobile {
  font-size: 14px;
  color: var(--ship-gray);
  line-height: 1.6;
}

.about-section-mobile {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.about-title-mobile {
  font-size: 18px;
  font-weight: bold;
  color: var(--eerie-black);
  text-align: center;
}

.section-subtitle-mobile {
  font-size: 16px;
  font-weight: bold;
  color: var(--eerie-black);
  margin-top: 20px;
}

@media (max-width: 767px) {
  .content-section-mobile {
    padding: 15px;
  }
  
  .hero-section-mobile {
    min-height: 180px;
  }
  
  .title-mobile {
    font-size: 14px;
  }
  
  .section-title-mobile {
    font-size: 15px;
  }
}
</style>
