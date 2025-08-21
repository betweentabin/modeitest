<template>
  <div class="items-1 inter-bold-black-15px">
    <div class="text-6 valign-text-middle" @click="navigateTo('home')" style="cursor: pointer;">トップ</div>
    <img
      class="vector-22"
      src="https://cdn.animaapp.com/projects/68131d325b4f63697a4e5f8d/releases/6846ceece9555a0f73238379/img/vector-1.svg"
      alt="Vector 1"
    />
    <div class="text-6 valign-text-middle" @click="navigateTo('services')" style="cursor: pointer;">会員サービスのご案内</div>
    <img
      class="vector-22"
      src="https://cdn.animaapp.com/projects/68131d325b4f63697a4e5f8d/releases/6846ceece9555a0f73238379/img/vector-1.svg"
      alt="Vector 2"
    />
    <div class="text-6 valign-text-middle" @click="navigateTo('about')" style="cursor: pointer;">会社概要</div>
    <img
      class="vector-22"
      src="https://cdn.animaapp.com/projects/68131d325b4f63697a4e5f8d/releases/6846ceece9555a0f73238379/img/vector-1.svg"
      alt="Vector 3"
    />
    <div class="text-6 valign-text-middle" @click="navigateTo('news')" style="cursor: pointer;">お知らせ</div>
    <img
      class="vector-22"
      src="https://cdn.animaapp.com/projects/68131d325b4f63697a4e5f8d/releases/6846ceece9555a0f73238379/img/vector-1.svg"
      alt="Vector 4"
    />
    <div class="text-6 valign-text-middle" @click="navigateTo('faq')" style="cursor: pointer;">よくあるご質問</div>
  </div>
</template>

<script>
export default {
  name: "Items",
  methods: {
    navigateTo(route) {
      console.log('Navigating to:', route);
      // ここでルーティング処理を実装
      // this.$router.push('/' + route);
      
      // 一時的にアラートで確認
      alert(`${route}ページに移動します`);
    }
  }
};
</script>

<style>
.items-1 {
  align-items: center;
  display: inline-flex;
  gap: 15px;
  left: 0;
  position: absolute;
  top: 45px;
}

.text-6 {
  letter-spacing: 0;
  line-height: 22.5px;
  margin-top: -1px;
  position: relative;
  white-space: nowrap;
  width: fit-content;
}

.vector-22 {
  height: 10px;
  position: relative;
  width: 1px;
}
</style>
