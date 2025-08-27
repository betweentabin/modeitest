<template>
  <div class="container-center-horizontal">
    <div class="u12475u12511u12490u12540u24773u22577u65288u35443u32048u65289u12494u12540u12510u12523-mobile screen">
      <navigation :className="navigationProps.className" />
      <hero-image
        :heroImage="heroImageProps.heroImage"
        :membership="heroImageProps.membership"
        :text65="heroImageProps.text65"
        :className="heroImageProps.className"
      />
      <div class="mobile-content-wrapper">
        <frame13213175344 :text1798="frame13213175344Props.text1798" />
        <frame1321317555
          :text1778="frame1321317555Props.text1778"
          :frame1321317705Props="frame1321317555Props.frame1321317705Props"
        />
        <frame1321317493 :className="frame1321317493Props.className" />
        <div class="frame-1321317553-10-mobile">
          <div class="frame-1321317545-19-mobile">
            <x-button :text63="xButton1Props.text63" :frame13213176122Props="xButton1Props.frame13213176122Props" />
            <x-button
              :text63="xButton2Props.text63"
              :className="xButton2Props.className"
              :frame13213176122Props="xButton2Props.frame13213176122Props"
            />
          </div>
        </div>
        <frame1321317483 :className="frame1321317483Props.className" />
        <view-component :className="viewProps.className" />
      </div>
      <navigation-footer v-bind="navigationFooterProps" />
    </div>
  </div>
</template>

<script>
import Navigation from "./Navigation2";
import HeroImage from "./HeroImage";
import Frame13213175344 from "./Frame13213175344";
import Frame1321317555 from "./Frame1321317555";
import Frame1321317493 from "./Frame1321317493";
import XButton from "./XButton";
import Frame1321317483 from "./Frame1321317483";
import ViewComponent from "./ViewComponent";
import NavigationFooter from "./NavigationFooter2";

export default {
  name: "Screen21Mobile",
  components: {
    Navigation,
    HeroImage,
    Frame13213175344,
    Frame1321317555,
    Frame1321317493,
    XButton,
    Frame1321317483,
    ViewComponent,
    NavigationFooter,
  },
  props: [
    "navigationProps",
    "heroImageProps",
    "frame13213175344Props",
    "frame1321317555Props",
    "frame1321317493Props",
    "xButton1Props",
    "xButton2Props",
    "frame1321317483Props",
    "viewProps",
    "navigationFooterProps",
  ],
};
</script>

<style scoped>
.u12475u12511u12490u12540u24773u22577u65288u35443u32048u65289u12494u12540u12510u12523-mobile {
  align-items: center;
  background-color: var(--cararra);
  display: flex;
  flex-direction: column;
  min-height: 100vh;
  overflow: hidden;
  position: relative;
  width: 100%;
}

.mobile-content-wrapper {
  width: 100%;
  padding: 20px;
  box-sizing: border-box;
}

.frame-1321317553-10-mobile {
  align-items: center;
  display: flex;
  flex-direction: column;
  gap: 20px;
  padding: 30px 20px;
  position: relative;
  width: 100%;
  z-index: 3;
}

.frame-1321317545-19-mobile {
  align-items: center;
  align-self: stretch;
  border-radius: 15px;
  display: flex;
  flex-direction: column;
  flex: 0 0 auto;
  gap: 15px;
  height: auto;
  justify-content: center;
  position: relative;
  width: 100%;
}

/* タブレット対応 */
@media (min-width: 768px) and (max-width: 1023px) {
  .mobile-content-wrapper {
    padding: 30px;
    max-width: 768px;
    margin: 0 auto;
  }

  .frame-1321317553-10-mobile {
    padding: 40px 30px;
    gap: 30px;
  }

  .frame-1321317545-19-mobile {
    flex-direction: row;
    gap: 20px;
  }
}

/* スマートフォン対応 */
@media (max-width: 767px) {
  .mobile-content-wrapper {
    padding: 15px;
  }

  .frame-1321317553-10-mobile {
    padding: 20px 15px;
  }
}
</style>