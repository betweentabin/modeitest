<template>
  <div :class="[`card-1-1`, className || ``]" @click="handleCardClick" style="cursor: pointer;">
    <div class="image-5" :style="{ 'background-image': 'url(' + image + ')' }">
      <frame1321317481 :text49="frame1321317481Props.text49" :text50="frame1321317481Props.text50" />
    </div>
  </div>
</template>

<script>
import Frame1321317481 from "./Frame1321317481";
export default {
  name: "Card",
  components: {
    Frame1321317481,
  },
  props: ["image", "className", "frame1321317481Props"],
  methods: {
    handleCardClick() {
      console.log('Card clicked:', this.frame1321317481Props);
      // カードクリック時の処理
      alert('カードがクリックされました');
    }
  }
};
</script>

<style>
.card-1-1 {
  position: relative;
  width: calc(33.333% - 13.33px);
  flex-shrink: 0;
  aspect-ratio: 434 / 330;
}

.image-5 {
  align-items: flex-end;
  background-position: 50% 50%;
  background-size: cover;
  border-radius: 10px;
  display: flex;
  height: 100%;
  overflow: hidden;
  position: relative;
  width: 100%;
}
</style>
