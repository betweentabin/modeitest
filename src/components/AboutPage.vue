<template>
  <div class="about-page">
    <div class="div-3">
      <HeroImageSubsection />
      <ViewSubsection />
      <NavigationFooterSubsection />
      <div class="frame-51">
        <div class="frame-52">
          <div class="text-wrapper-52">トップ</div>
          <div class="text-wrapper-53">&gt;</div>
          <div class="text-wrapper-54">会社概要</div>
        </div>
      </div>
      <FrameSubsection />
      <FrameWrapperSubsection />
      <DivWrapperSubsection />
      <DivSubsection />
      <SectionComponentNodeSubsection />
      <NavigationSubsection />
      <OverlapWrapperSubsection />
      <div class="frame-53">
        <div class="frame-54">
          <div class="group-13">
            <div class="text-wrapper-55">ログイン</div>
            <img class="vector-20" alt="Vector" src="/img/vector-11.svg" />
          </div>
        </div>
        <div class="frame-55">
          <div class="group-14">
            <div class="text-wrapper-56">お問い合わせ</div>
            <img class="vector-21" alt="Vector" src="/img/vector-12-1.svg" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import HeroImageSubsection from "./HeroImageSubsection";
import ViewSubsection from "./ViewSubsection";
import NavigationFooterSubsection from "./NavigationFooterSubsection";
import FrameSubsection from "./FrameSubsection";
import FrameWrapperSubsection from "./FrameWrapperSubsection";
import DivWrapperSubsection from "./DivWrapperSubsection";
import DivSubsection from "./DivSubsection";
import SectionComponentNodeSubsection from "./SectionComponentNodeSubsection";
import NavigationSubsection from "./NavigationSubsection";
import OverlapWrapperSubsection from "./OverlapWrapperSubsection";

export default {
  name: "Screen",
  components: {
    HeroImageSubsection,
    ViewSubsection,
    NavigationFooterSubsection,
    FrameSubsection,
    FrameWrapperSubsection,
    DivWrapperSubsection,
    DivSubsection,
    SectionComponentNodeSubsection,
    NavigationSubsection,
    OverlapWrapperSubsection,
  },
};
</script>

<style>
.screen {
  align-items: start;
  background-color: 000000;
  display: grid;
  justify-items: center;
  width: 100vw;
}

.screen .div-3 {
  background-color: var(--6);
  height: 6601px;
  overflow: hidden;
  position: relative;
  width: 1440px;
}

.screen .frame-51 {
  align-items: center;
  display: flex;
  gap: 10px;
  left: 0;
  padding: 24px 46px;
  position: absolute;
  top: 485px;
  width: 1440px;
}

.screen .frame-52 {
  align-items: center;
  display: flex;
  flex: 1;
  flex-grow: 1;
  gap: 8px;
  height: 12px;
  position: relative;
}

.screen .text-wrapper-52 {
  color: var(--4);
  font-family: "Inter-Light", Helvetica;
  font-size: 12px;
  font-weight: 300;
  height: 12px;
  letter-spacing: 0;
  line-height: 60px;
  margin-top: -1px;
  position: relative;
  text-align: center;
  white-space: nowrap;
  width: 36px;
}

.screen .text-wrapper-53 {
  color: var(--4);
  font-family: "Inter-Light", Helvetica;
  font-size: 12px;
  font-weight: 300;
  height: 12px;
  letter-spacing: 0;
  line-height: 60px;
  margin-top: -1px;
  position: relative;
  text-align: center;
  white-space: nowrap;
  width: 5px;
}

.screen .text-wrapper-54 {
  color: var(--4);
  font-family: "Inter-Light", Helvetica;
  font-size: 12px;
  font-weight: 300;
  height: 12px;
  letter-spacing: 0;
  line-height: 60px;
  margin-top: -1px;
  position: relative;
  text-align: center;
  white-space: nowrap;
  width: 48px;
}

.screen .frame-53 {
  display: grid;
  gap: 10px;
  grid-template-columns: repeat(1, minmax(0, 1fr));
  grid-template-rows: repeat(2, minmax(0, 1fr));
  height: 213px;
  left: 1330px;
  position: fixed;
  top: 595px;
  width: 100px;
}

.screen .frame-54 {
  background-color: var(--);
  border-radius: 500px;
  grid-column: 1 / 2;
  grid-row: 1 / 2;
  height: 100px;
  overflow: hidden;
  position: relative;
  width: 100px;
}

.screen .group-13 {
  height: 51px;
  left: 24px;
  position: relative;
  top: 24px;
  width: 54px;
}

.screen .text-wrapper-55 {
  color: #ffffff;
  font-family: "Inter-Bold", Helvetica;
  font-size: 13px;
  font-weight: 700;
  height: 20px;
  left: 0;
  letter-spacing: 0;
  line-height: 19.5px;
  position: absolute;
  text-align: center;
  top: 31px;
  white-space: nowrap;
}

.screen .vector-20 {
  height: 25px;
  left: 13px;
  position: absolute;
  top: 0;
  width: 26px;
}

.screen .frame-55 {
  background-color: #9c3940;
  border-radius: 500px;
  grid-column: 1 / 2;
  grid-row: 2 / 3;
  height: 100px;
  overflow: hidden;
  position: relative;
  width: 100px;
}

.screen .group-14 {
  height: auto;
  left: 11px;
  position: relative;
  top: 24px;
  width: auto;
}

.screen .text-wrapper-56 {
  color: #ffffff;
  font-family: "Inter-Bold", Helvetica;
  font-size: 13px;
  font-weight: 700;
  height: 20px;
  left: 0;
  letter-spacing: 0;
  line-height: 19.5px;
  position: absolute;
  text-align: center;
  top: 33px;
  white-space: nowrap;
}

.screen .vector-21 {
  height: 28px;
  left: 30px;
  position: absolute;
  top: 0;
  width: 18px;
}
</style>