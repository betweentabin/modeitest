<template>
  <div class="content-view-2">
    <div class="frame-1321317467-2">
      <group10 />
      <div class="frame-1321317467-1">
        <img class="rectangle-3" :src="rectangle3" alt="Rectangle 3" />
        <div class="frame-1321317466">
          <div class="group-container">
            <div class="group-12">
              <div class="text-3 valign-text-middle inter-bold-mandy-20px">{{ text75 }}</div>
              <p class="x12km-14 valign-text-middle inter-normal-ship-gray-16px">{{ text77 }}</p>
              <div class="text-11 valign-text-middle inter-normal-ship-gray-16px" v-html="text76"></div>
              <p class="x12km-14-1 valign-text-middle inter-normal-ship-gray-16px">{{ phone }}</p>
              <p class="x19km-23 valign-text-middle inter-normal-ship-gray-16px">{{ x900 }}</p>
            </div>
            <div class="group-12">
              <div class="text-3 valign-text-middle inter-bold-mandy-20px">{{ text74 }}</div>
              <p class="x12km-14 valign-text-middle inter-normal-ship-gray-16px">{{ x12Km141 }}</p>
              <p class="x12km-14-1 valign-text-middle inter-normal-ship-gray-16px">{{ x12Km142 }}</p>
              <p class="x19km-23 valign-text-middle inter-normal-ship-gray-16px">{{ x19Km23 }}</p>
            </div>
            <div class="group-12">
              <div class="text-3 valign-text-middle inter-bold-mandy-20px">{{ text78 }}</div>
              <p class="x12km-14 valign-text-middle inter-normal-ship-gray-16px">{{ x497M6 }}</p>
              <p class="x12km-14-1 valign-text-middle inter-normal-ship-gray-16px">{{ x811M10 }}</p>
              <p class="x19km-23 valign-text-middle inter-normal-ship-gray-16px">{{ d1830M10 }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Group10 from "./Group10";
import { homePageData } from "../data";

export default {
  name: "AccessSection",
  components: {
    Group10,
  },
  data() {
    return {
      // content-view-2に必要なデータ
      rectangle3: homePageData.rectangle3,
      text75: homePageData.text75,
      text77: homePageData.text77,
      text76: homePageData.text76,
      phone: homePageData.phone,
      x900: homePageData.x900,
      text74: homePageData.text74,
      x12Km141: homePageData.x12Km141,
      x12Km142: homePageData.x12Km142,
      x19Km23: homePageData.x19Km23,
      text78: homePageData.text78,
      x497M6: homePageData.x497M6,
      x811M10: homePageData.x811M10,
      d1830M10: homePageData.d1830M10,
    };
  },
  mounted() {
    this.adjustRectangleHeight();
    window.addEventListener('resize', this.adjustRectangleHeight);
  },
  beforeDestroy() {
    window.removeEventListener('resize', this.adjustRectangleHeight);
  },
  methods: {
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
/* Access Section */
.content-view-2 {
  align-items: center;
  background-color: var(--white);
  display: flex;
  flex-direction: column;
  gap: 24px;
  padding: 80px 50px;
  position: relative;
  width: 100%;
  z-index: 3;
  box-sizing: border-box;
}

.frame-1321317467-2 {
  align-items: flex-start;
  background-color: var(--white);
  display: flex;
  flex-direction: column;
  gap: 24px;
  position: relative;
  width: 100%;
  max-width: 2000px;
  z-index: 3;
  box-sizing: border-box;
  padding: 0 50px;
}

.frame-1321317467-1 {
  align-items: flex-start;
  align-self: stretch;
  display: flex;
  flex: 0 0 auto;
  gap: 40px;
  position: relative;
  width: 100%;
  min-height: auto;
}

.rectangle-3 {
  height: 100%;
  object-fit: cover;
  position: relative;
  width: 45%;
  max-width: 692px;
  flex-shrink: 0;
  border-radius: 10px;
}

.frame-1321317466 {
  display: flex;
  align-items: flex-start;
  position: relative;
  width: auto;
  flex-shrink: 0;
  box-sizing: border-box;
  height: auto;
}

.group-container {
  display: flex;
  flex-direction: column;
  gap: 30px;
}

.group-12 {
  align-items: flex-start;
  display: flex;
  flex-direction: column;
  height: fit-content;
  width: fit-content;
}

.text-3 {
  color: #DA5761;
  font-size: 20px;
  font-weight: 700;
  line-height: 1.5;
}

.x12km-14, .x12km-14-1, .x19km-23 {
  color: #3F3F3F;
  font-size: 16px;
  font-weight: 400;
  line-height: 1.6;
}

.text-11 {
  color: #3F3F3F;
  font-size: 16px;
  font-weight: 400;
  line-height: 1.6;
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
</style>
