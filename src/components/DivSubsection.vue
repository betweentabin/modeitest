<template>
  <div class="div-subsection">
    <div class="about-4">
      <div class="text-wrapper-27">沿革</div>

      <div class="frame-35">
        <img class="vector-7" alt="Vector" :src="vector165" />

        <div class="text-wrapper-28">history</div>

        <img class="vector-7" alt="Vector" :src="vector155" />
      </div>
    </div>

    <div class="frame-36">
      <div class="frame-37">
        <div class="frame-38">
          <div class="text-wrapper-29">1988</div>

          <div class="frame-39">
            <div class="text-wrapper-30">昭和63年1月30日</div>

            <div class="text-wrapper-31">
              ちくぎんコンピュータサービス（株）設立
            </div>
          </div>
        </div>

        <div class="frame-38">
          <div class="text-wrapper-29">2010</div>

          <div class="frame-39">
            <div class="text-wrapper-30">平成22年6月29日</div>

            <div class="text-wrapper-31">
              ちくぎんコンピュータサービス（株）の定款変更により、経営コンサルティング業務・経済調査等業務を追加。
            </div>
          </div>
        </div>

        <div class="frame-38">
          <div class="text-wrapper-32">2011</div>

          <div class="frame-39">
            <div class="text-wrapper-30">平成23年7月1日</div>

            <div class="IT">
              社名変更　（株）ちくぎん地域経済研究所として新たにスタート。
              <br />
              主たる業務は調査・研究、人材開発、IT関連サービス、経営支援（経営サポート）、コンシェルジュサービス。
            </div>
          </div>
        </div>
      </div>

      <button class="button">
        <div class="text-wrapper-33">詳細はこちら</div>

        <div class="vector-wrapper">
          <img class="vector-8" alt="Vector" :src="vector25" />
        </div>
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: "DivSubsection",
  data() {
    return {
      vector155: require('../../public/img/vector-15-1.svg'),
      vector165: require('../../public/img/vector-1.svg'),
      vector25: require('../../public/img/vector-1.svg'),
    };
  },
};
</script>

<style>
.div-subsection {
  /* Add your styles here */
}

.about-4 {
  /* Add your styles here */
}

.text-wrapper-27 {
  /* Add your styles here */
}

.frame-35 {
  /* Add your styles here */
}

.vector-7 {
  /* Add your styles here */
}

.text-wrapper-28 {
  /* Add your styles here */
}

.frame-36 {
  /* Add your styles here */
}

.frame-37 {
  /* Add your styles here */
}

.frame-38 {
  /* Add your styles here */
}

.text-wrapper-29 {
  /* Add your styles here */
}

.frame-39 {
  /* Add your styles here */
}

.text-wrapper-30 {
  /* Add your styles here */
}

.text-wrapper-31 {
  /* Add your styles here */
}

.IT {
  /* Add your styles here */
}

.button {
  /* Add your styles here */
}

.text-wrapper-33 {
  /* Add your styles here */
}

.vector-wrapper {
  /* Add your styles here */
}

.vector-8 {
  /* Add your styles here */
}
</style>