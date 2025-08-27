<template>
  <div class="container-center-horizontal">
    <div class="economic-indicators-mobile screen">
      <navigation2 />
      <div class="hero-section-mobile">
        <hero-image2
          :heroImage="heroImageProps.heroImage"
          :membership="heroImageProps.membership"
          :text65="heroImageProps.text65"
        />
      </div>
      <div class="content-section-mobile">
        <div class="header-mobile">
          <div class="page-title-mobile">{{ pageTitle }}</div>
          <div class="page-subtitle-mobile">{{ pageSubtitle }}</div>
        </div>
        
        <div class="indicators-grid-mobile">
          <div class="indicator-card-mobile" v-for="(indicator, index) in indicators" :key="index">
            <div class="indicator-title-mobile">{{ indicator.title }}</div>
            <div class="indicator-value-mobile">{{ indicator.value }}</div>
            <div class="indicator-change-mobile" :class="indicator.changeClass">
              {{ indicator.change }}
            </div>
          </div>
        </div>
        
        <div class="chart-section-mobile">
          <div class="chart-title-mobile">{{ chartTitle }}</div>
          <div class="chart-placeholder-mobile">
            <div class="chart-message-mobile">{{ chartMessage }}</div>
          </div>
        </div>
        
        <div class="download-section-mobile">
          <button class="download-button-mobile">{{ downloadButtonText }}</button>
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
  name: "EconomicIndicatorsMobile",
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
    pageTitle: {
      type: String,
      default: "経済指標",
    },
    pageSubtitle: {
      type: String,
      default: "最新の経済動向をご覧いただけます",
    },
    indicators: {
      type: Array,
      default: () => [
        { title: "GDP成長率", value: "2.1%", change: "+0.3%", changeClass: "positive" },
        { title: "失業率", value: "2.6%", change: "-0.1%", changeClass: "positive" },
        { title: "インフレ率", value: "0.8%", change: "+0.2%", changeClass: "negative" },
      ],
    },
    chartTitle: {
      type: String,
      default: "経済指標推移",
    },
    chartMessage: {
      type: String,
      default: "グラフが表示されます",
    },
    downloadButtonText: {
      type: String,
      default: "レポートをダウンロード",
    },
  },
};
</script>

<style scoped>
.economic-indicators-mobile {
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

.header-mobile {
  text-align: center;
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.page-title-mobile {
  font-size: 20px;
  font-weight: bold;
  color: var(--eerie-black);
}

.page-subtitle-mobile {
  font-size: 14px;
  color: var(--ship-gray);
}

.indicators-grid-mobile {
  display: grid;
  grid-template-columns: 1fr;
  gap: 15px;
}

.indicator-card-mobile {
  background-color: var(--white);
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.1);
  text-align: center;
}

.indicator-title-mobile {
  font-size: 14px;
  color: var(--ship-gray);
  margin-bottom: 8px;
}

.indicator-value-mobile {
  font-size: 24px;
  font-weight: bold;
  color: var(--eerie-black);
  margin-bottom: 5px;
}

.indicator-change-mobile {
  font-size: 12px;
  font-weight: bold;
}

.indicator-change-mobile.positive {
  color: #22c55e;
}

.indicator-change-mobile.negative {
  color: #ef4444;
}

.chart-section-mobile {
  background-color: var(--white);
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.1);
}

.chart-title-mobile {
  font-size: 16px;
  font-weight: bold;
  color: var(--eerie-black);
  margin-bottom: 15px;
  text-align: center;
}

.chart-placeholder-mobile {
  height: 200px;
  background-color: var(--black-haze);
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.chart-message-mobile {
  color: var(--ship-gray);
  font-size: 14px;
}

.download-section-mobile {
  display: flex;
  justify-content: center;
}

.download-button-mobile {
  background-color: var(--eerie-black);
  color: var(--white);
  border: none;
  padding: 15px 30px;
  border-radius: 10px;
  font-size: 15px;
  font-weight: bold;
  cursor: pointer;
  transition: background-color 0.3s ease;
  width: 100%;
  max-width: 300px;
}

.download-button-mobile:hover {
  background-color: var(--ship-gray);
}

@media (max-width: 767px) {
  .content-section-mobile {
    padding: 15px;
  }
  
  .indicator-card-mobile {
    padding: 15px;
  }
  
  .chart-section-mobile {
    padding: 15px;
  }
  
  .chart-placeholder-mobile {
    height: 150px;
  }
}
</style>
