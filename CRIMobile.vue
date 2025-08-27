<template>
  <div class="container-center-horizontal">
    <div class="cri-consulting-mobile screen">
      <navigation2 />
      <div class="hero-section-mobile" :style="{ 'background-image': 'url(' + overlapGroup3 + ')' }">
        <div class="hero-content-mobile">
          <div class="about-us-mobile">{{ aboutUs }}</div>
          <div class="cri-title-mobile">{{ cri1 }}</div>
          <frame1321317534 :text78="frame1321317534Props.text78" />
        </div>
      </div>
      <navbar />
      <div class="content-section-mobile">
        <div class="about-section-mobile">
          <div class="cri-subtitle-mobile">{{ cri2 }}</div>
          <div class="consulting-tag-mobile">
            <div class="consulting-text-mobile">{{ consulting }}</div>
          </div>
        </div>
        <div class="image-section-mobile">
          <div class="image-mobile" :style="{ 'background-image': 'url(' + image1 + ')' }"></div>
          <div class="content-mobile">
            <frame1321317541 :text421="frame1321317541Props.text421" :className="frame1321317541Props.className" />
            <div class="description-section-mobile">
              <div class="cri-description-title-mobile">{{ cri3 }}</div>
              <div class="cri-description-content-mobile" v-html="text1154"></div>
            </div>
          </div>
        </div>
      </div>
      <navigation-footer2 />
    </div>
  </div>
</template>

<script>
import Navigation2 from "./Navigation2";
import Frame1321317534 from "./Frame1321317534";
import Navbar from "./Navbar";
import Frame1321317541 from "./Frame1321317541";
import NavigationFooter2 from "./NavigationFooter2";

export default {
  name: "CRIMobile",
  components: {
    Navigation2,
    Frame1321317534,
    Navbar,
    Frame1321317541,
    NavigationFooter2,
  },
  props: {
    overlapGroup3: {
      type: String,
      default: "",
    },
    aboutUs: {
      type: String,
      default: "",
    },
    cri1: {
      type: String,
      default: "",
    },
    frame1321317534Props: {
      type: Object,
      default: () => ({}),
    },
    cri2: {
      type: String,
      default: "",
    },
    consulting: {
      type: String,
      default: "",
    },
    image1: {
      type: String,
      default: "",
    },
    frame1321317541Props: {
      type: Object,
      default: () => ({}),
    },
    cri3: {
      type: String,
      default: "",
    },
    text1154: {
      type: String,
      default: "",
    },
  },
};
</script>

<style scoped>
.cri-consulting-mobile {
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
}

.hero-content-mobile {
  text-align: center;
  color: white;
  padding: 20px;
}

.about-us-mobile {
  font-size: 10px;
  font-weight: bold;
  margin-bottom: 8px;
}

.cri-title-mobile {
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

.about-section-mobile {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 15px;
}

.cri-subtitle-mobile {
  font-size: 18px;
  font-weight: bold;
  color: var(--eerie-black);
  text-align: center;
}

.consulting-tag-mobile {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 8px 16px;
  background-color: rgba(218, 87, 97, 0.1);
  border-radius: 20px;
}

.consulting-text-mobile {
  font-size: 12px;
  font-weight: bold;
  color: var(--mandy);
}

.image-section-mobile {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.image-mobile {
  width: 100%;
  height: 200px;
  background-size: cover;
  background-position: center;
  border-radius: 10px;
}

.content-mobile {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.description-section-mobile {
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.cri-description-title-mobile {
  font-size: 16px;
  font-weight: bold;
  color: var(--eerie-black);
}

.cri-description-content-mobile {
  font-size: 14px;
  color: var(--ship-gray);
  line-height: 1.6;
}

@media (max-width: 767px) {
  .content-section-mobile {
    padding: 15px;
  }
  
  .hero-section-mobile {
    min-height: 180px;
  }
  
  .cri-title-mobile {
    font-size: 14px;
  }
  
  .cri-subtitle-mobile {
    font-size: 16px;
  }
  
  .image-mobile {
    height: 150px;
  }
}
</style>
