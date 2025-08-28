<template>
  <div class="frame-wrapper-subsection">
    <div class="about-2">
      <div class="text-wrapper-18">経営理念</div>

      <div class="frame-27">
        <img class="vector-5" alt="Vector" :src="vector162" />

        <div class="text-wrapper-19">philosophy</div>

        <img class="vector-5" alt="Vector" :src="vector152" />
      </div>
    </div>

    <div class="frame-28">
      <div class="image-2" />

      <div class="frame-29">
        <div class="div-wrapper">
          <div class="text-wrapper-20">OUR MISSION</div>
        </div>

        <div class="frame-30">
          <div class="text-wrapper-21">
            産官学金のネットワーク活用による地域貢献
          </div>

          <p class="text-wrapper-22">
            地域に根差した経済 / 産業の調査 / 研究
            <br />
            地域経済を担う企業 / 医療 / 農業 / 学術研究活動のサポート
            <br />
            未来を支える「人」づくり
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "FrameWrapperSubsection",
  data() {
    return {
      vector152: require('../../public/img/vector-15-2.svg'),
      vector162: require('../../public/img/vector-1.svg'),
    };
  },
};
</script>

<style>
.frame-wrapper-subsection {
  /* Add your styles here */
}

.about-2 {
  /* Add your styles here */
}

.text-wrapper-18 {
  /* Add your styles here */
}

.frame-27 {
  /* Add your styles here */
}

.vector-5 {
  /* Add your styles here */
}

.text-wrapper-19 {
  /* Add your styles here */
}

.frame-28 {
  /* Add your styles here */
}

.image-2 {
  /* Add your styles here */
}

.frame-29 {
  /* Add your styles here */
}

.div-wrapper {
  /* Add your styles here */
}

.text-wrapper-20 {
  /* Add your styles here */
}

.frame-30 {
  /* Add your styles here */
}

.text-wrapper-21 {
  /* Add your styles here */
}

.text-wrapper-22 {
  /* Add your styles here */
}
</style>