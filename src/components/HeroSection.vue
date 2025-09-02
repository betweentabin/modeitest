<template>
  <div class="hero-section" :style="heroStyle">
    <div class="hero-overlay">
      <div class="hero-content">
        <div class="hero-subtitle">{{ subtitle }}</div>
        <div class="hero-title">{{ title }}</div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "HeroSection",
  props: {
    title: {
      type: String,
      required: true,
      default: "ページタイトル"
    },
    subtitle: {
      type: String,
      default: "サブタイトル"
    },
    heroImage: {
      type: String,
      required: true
    }
  },
  computed: {
    heroStyle() {
      return {
        backgroundImage: `url('${this.heroImage}')`
      };
    }
  }
};
</script>

<style scoped>
/* Hero Section */
.hero-section {
  width: 100%;
  height: 400px;
  background: lightgray center / cover no-repeat;
  box-shadow: 0 4px 4px rgba(0, 0, 0, 0.25);
  position: relative;
}

.hero-overlay {
  background: rgba(77, 77, 77, 0.70);
  width: 100%;
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: flex-end;
  align-items: flex-start;
  padding: 50px 30px;
  box-sizing: border-box;
}

.hero-content {
  color: white;
}

.hero-subtitle {
  color: white;
  font-size: clamp(18px, 4vw, 24px);
  font-weight: 700;
  text-align: left;
  line-height: 2.5;
  letter-spacing: -0.48px;
}

.hero-title {
  color: white;
  font-size: clamp(28px, 6vw, 40px);
  font-weight: 700;
  text-align: left;
  line-height: 1.5;
  letter-spacing: -0.8px;
}

/* レスポンシブ対応 */
@media (max-width: 1150px) {
  .hero-section {
    height: 350px;
  }
  
  .hero-overlay {
    padding: 40px 25px;
  }
  
  .hero-subtitle {
    font-size: clamp(16px, 3.5vw, 22px);
  }
  
  .hero-title {
    font-size: clamp(24px, 5.5vw, 36px);
  }
}

@media (max-width: 800px) {
  .hero-section {
    min-height: 300px;
    height: 40vh;
    background-position: center 30%;
  }
  
  .hero-overlay {
    padding: 30px 20px;
  }
  
  .hero-subtitle {
    font-size: clamp(15px, 3vw, 20px);
    line-height: 2.2;
  }
  
  .hero-title {
    font-size: clamp(22px, 5vw, 32px);
    line-height: 1.4;
  }
}

@media (max-width: 600px) {
  .hero-section {
    min-height: 280px;
    height: 35vh;
    background-position: center 25%;
  }
  
  .hero-overlay {
    padding: 25px 18px;
  }
  
  .hero-subtitle {
    font-size: clamp(14px, 2.8vw, 18px);
    line-height: 2.0;
  }
  
  .hero-title {
    font-size: clamp(20px, 4.5vw, 28px);
    line-height: 1.3;
  }
}

@media (max-width: 480px) {
  .hero-section {
    min-height: 250px;
    height: 30vh;
    background-position: center 20%;
  }
  
  .hero-overlay {
    padding: 20px 15px;
  }
  
  .hero-subtitle {
    font-size: clamp(13px, 2.5vw, 16px);
    line-height: 1.8;
  }
  
  .hero-title {
    font-size: clamp(18px, 4vw, 24px);
    line-height: 1.2;
  }
}
</style>
