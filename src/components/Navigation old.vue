<template>
  <div class="navigation">
    <div class="frame-1321317497">
      <view />
      <group1 />
    </div>
    <div class="frame-1321317498">
      <div class="group-2">
        <div class="items">
          <x-button />
          <x-button2 />
          <div class="text-align-justify">
            <div class="vector-container-1">
              <img
                class="vector-20"
                src="/img/vector-2.svg"
                alt="Vector"
              />
              <img
                class="vector-20"
                src="/img/vector-2.svg"
                alt="Vector"
              />
              <img
                class="vector-20"
                src="/img/vector-2.svg"
                alt="Vector"
              />
            </div>
          </div>
        </div>
        <items />
      </div>
    </div>
  </div>
</template>

<script>
import View from "./View";
import Group1 from "./Group1";
import XButton from "./XButton";
import XButton2 from "./XButton2";
import Items from "./Items";
export default {
  name: "Navigation",
  components: {
    View,
    Group1,
    XButton,
    XButton2,
    Items,
  },
};
</script>

<style>
.navigation {
  align-items: center;
  background-color: var(--cararra);
  box-shadow: 0px 3px 20px #00000026;
  display: flex;
  justify-content: space-between;
  padding: 10px 20px;
  position: relative;
  width: 1440px;
  z-index: 9;
}

.frame-1321317497 {
  align-items: center;
  display: inline-flex;
  flex: 0 0 auto;
  gap: 20px;
  overflow: hidden;
  position: relative;
}

.frame-1321317498 {
  align-items: flex-start;
  display: flex;
  flex-direction: column;
  gap: 10px;
  position: relative;
  width: 541px;
}

.group-2 {
  height: 68px;
  position: relative;
  width: 540px;
}

.items {
  align-items: center;
  display: inline-flex;
  gap: 15px;
  left: 220px;
  position: absolute;
  top: 0;
}

.text-align-justify {
  height: 24px;
  position: relative;
  width: 26px;
}

.vector-container-1 {
  align-items: flex-start;
  display: flex;
  flex-direction: column;
  gap: 7px;
  min-height: 23px;
  width: 25px;
}

.vector-20 {
  height: 3px;
  width: 25px;
}
</style>
