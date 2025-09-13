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
  props: ["image", "className", "frame1321317481Props", "linkTo"],
  methods: {
    handleCardClick() {
      console.log('Card clicked:', this.frame1321317481Props);
      
      // リンクが指定されている場合はそのページに遷移
      if (this.linkTo) {
        this.$router.push(this.linkTo);
        return;
      }
      
      // カードのタイトルに基づいて遷移先を決定
      const cardTitle = this.frame1321317481Props?.text49;
      
      if (cardTitle === "調査研究") {
        // 開発・研究ページ（AboutInstitutePageの最初のサービスカード）に遷移
        this.$router.push('/aboutus#service-development');
      } else if (cardTitle === "人財開発") {
        // 人材開発ページに遷移
        this.$router.push('/aboutus#service-human-resources');
      } else if (cardTitle === "経営支援 (経営サポート)") {
        // 経営支援ページに遷移
        this.$router.push('/aboutus#service-management-support');
      } else {
        // デフォルトは研究所についてページに遷移
        this.$router.push('/aboutus');
      }
    }
  }
};
</script>

<style>
.card-1-1 {
  height: 330px;
  position: relative;
  width: calc((100% - 40px) / 3);
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

/* レスポンシブ対応 */
@media (max-width: 1700px) {
  .card-1-1 {
    width: calc((100% - 30px) / 3);
  }
}

@media (max-width: 1300px) {
  .card-1-1 {
    height: 250px;
  }
}

@media (max-width: 1100px) {
  .card-1-1 {
    width: 100%;
  }
}

@media (max-width: 900px) {
  .card-1-1 {
    width: 100%;
  }
}
</style>
