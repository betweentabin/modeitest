<template>
  <div class="container-center-horizontal">
    <div class="publication-mobile screen">
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
          <div class="page-title-mobile">一般向け刊行物</div>
          <div class="page-subtitle-mobile">研究レポートや調査資料をご覧いただけます</div>
        </div>
        
        <div class="publications-grid-mobile">
          <div class="publication-card-mobile" v-for="(publication, index) in publications" :key="index">
            <div class="publication-image-mobile" :style="{ 'background-image': 'url(' + publication.image + ')' }"></div>
            <div class="publication-info-mobile">
              <div class="publication-date-mobile">{{ publication.date }}</div>
              <div class="publication-title-mobile">{{ publication.title }}</div>
              <div class="publication-description-mobile">{{ publication.description }}</div>
              <button class="view-button-mobile">詳細を見る</button>
            </div>
          </div>
        </div>
        
        <div class="pagination-mobile">
          <button class="pagination-button-mobile">前へ</button>
          <span class="pagination-info-mobile">1 / 5</span>
          <button class="pagination-button-mobile">次へ</button>
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
  name: "Screen9Mobile",
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
    publications: {
      type: Array,
      default: () => [
        {
          image: "/img/publication1.jpg",
          date: "2024.01.15",
          title: "地域経済レポート",
          description: "最新の地域経済動向について分析した資料です。"
        },
        {
          image: "/img/publication2.jpg",
          date: "2024.01.10",
          title: "統計調査結果",
          description: "年間統計調査の結果をまとめました。"
        }
      ],
    },
  },
};
</script>

<style scoped>
.publication-mobile {
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

.publications-grid-mobile {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.publication-card-mobile {
  background-color: var(--white);
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.1);
}

.publication-image-mobile {
  width: 100%;
  height: 150px;
  background-size: cover;
  background-position: center;
}

.publication-info-mobile {
  padding: 15px;
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.publication-date-mobile {
  font-size: 12px;
  color: var(--ship-gray);
}

.publication-title-mobile {
  font-size: 16px;
  font-weight: bold;
  color: var(--eerie-black);
}

.publication-description-mobile {
  font-size: 14px;
  color: var(--ship-gray);
  line-height: 1.5;
}

.view-button-mobile {
  background-color: var(--eerie-black);
  color: var(--white);
  border: none;
  padding: 10px 20px;
  border-radius: 5px;
  font-size: 14px;
  font-weight: bold;
  cursor: pointer;
  align-self: flex-start;
}

.pagination-mobile {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 20px;
}

.pagination-button-mobile {
  background-color: var(--white);
  color: var(--eerie-black);
  border: 1px solid var(--eerie-black);
  padding: 8px 16px;
  border-radius: 5px;
  font-size: 14px;
  cursor: pointer;
}

.pagination-info-mobile {
  font-size: 14px;
  color: var(--ship-gray);
}

@media (max-width: 767px) {
  .content-section-mobile {
    padding: 15px;
  }
  
  .publication-image-mobile {
    height: 120px;
  }
  
  .publication-info-mobile {
    padding: 12px;
  }
}
</style>
