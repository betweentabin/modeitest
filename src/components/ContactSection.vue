<template>
  <div class="contact-section">
    <div class="overlap-group6">
      <div class="rectangle-9"></div>
      <div class="button-3">
        <div class="text-44 valign-text-middle inter-bold-white-15px">お問い合わせはコチラ</div>
        <frame13213176122 />
      </div>
      <div class="text-45 valign-text-middle">株式会社ちくぎん地域経済研究所</div>
      <div class="group-30-1">
        <img
          class="vector-16-1"
          src="/img/vector-15-1.svg"
          alt="Vector 16"
        />
        <div class="about-us valign-text-middle inter-bold-white-20px">About us</div>
        <img
          class="vector-15-1"
          src="/img/vector-15-1.svg"
          alt="Vector 15"
        />
      </div>
      <div class="text-46 valign-text-middle inter-bold-white-20px">
        様々な分野の調査研究を通じ、企業活動などをサポートします。
      </div>
    </div>
  </div>
</template>

<script>
import Frame13213176122 from "./Frame13213176122";
export default {
  name: "ContactSection",
  components: {
    Frame13213176122,
  },
};
</script>

<style>
.contact-section {
  align-items: flex-start;
  background-color: #ff6a6a;
  display: flex;
  height: 351px;
  width: 100%;
  overflow: hidden;
  position: relative;
  opacity: 1;
}

.overlap-group6 {
  background-image: url(/img/-----1-1.png);
  background-position: 50% 50%;
  background-size: cover;
  height: 351px;
  width: 100%;
  position: relative;
}

.rectangle-9 {
  background-color: #4d4d4db2;
  height: 351px;
  left: 0;
  position: absolute;
  top: 0;
  width: 100%;
}

.button-3 {
  align-items: center;
  background-color: var(--mandy);
  border-radius: 10px;
  box-shadow: 0px 1px 2px #0000000d;
  display: flex;
  gap: 10px;
  justify-content: center;
  left: 50%;
  transform: translateX(-50%);
  padding: 10px 0px;
  position: absolute;
  top: 244px;
  width: 380px;
}

.text-44 {
  letter-spacing: 0;
  line-height: 22.5px;
  margin-top: -1px;
  position: relative;
  white-space: nowrap;
  width: fit-content;
}

.text-45 {
  color: var(--white);
  font-family: var(--font-family-inter);
  font-size: 40px;
  font-weight: 700;
  height: 60px;
  left: 50%;
  transform: translateX(-50%);
  letter-spacing: 0;
  line-height: 60px;
  position: absolute;
  top: 59px;
  white-space: nowrap;
  text-align: center;
}

.text-46 {
  height: 30px;
  left: 50%;
  transform: translateX(-50%);
  letter-spacing: 0;
  line-height: 30px;
  position: absolute;
  top: 190px;
  white-space: nowrap;
  text-align: center;
}

.group-30-1 {
  align-items: center;
  display: flex;
  height: 30px;
  left: 50%;
  transform: translateX(-50%);
  min-width: 270px;
  position: absolute;
  top: 130px;
}

.vector-16-1 {
  height: 2px;
  width: 69px;
}

.about-us {
  height: 30px;
  letter-spacing: 0;
  line-height: 30px;
  margin-left: 21px;
  min-width: 89px;
  white-space: nowrap;
}

.vector-15-1 {
  height: 2px;
  margin-left: 20px;
  width: 69px;
}
</style>
