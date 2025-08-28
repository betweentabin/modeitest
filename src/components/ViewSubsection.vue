<template>
  <div class="view-subsection">
    <div class="group">
      <div class="group-2">
        <div class="text-wrapper-2">ACCESS</div>
        <img class="vector" alt="Vector" :src="vector62" />
        <div class="text-wrapper-3">アクセス</div>
      </div>
    </div>

    <div class="frame-2">
      <img class="rectangle" alt="Rectangle" :src="rectangle3" />
      <div class="frame-3">
        <div class="group-3">
          <div class="text-wrapper-4">電車でお越しの場合</div>
          <p class="text-wrapper-5">
            櫛原：約1.2km 徒歩で約14分 乗換案内 | 徒歩ルート
          </p>
          <p class="text-wrapper-6">
            五郎丸：約1.9km 徒歩で約23分 乗換案内 | 徒歩ルート
          </p>
          <p class="text-wrapper-7">
            宮の陣：約1.2km 徒歩で約14分 乗換案内 | 徒歩ルート
          </p>
        </div>

        <div class="group-4">
          <div class="text-wrapper-4">会社情報</div>
          <div class="element">
            住所：〒839-0864
            <br />
            　　　福岡県久留米市百年公園1番1号久留米リサーチセンタービル6階
          </div>
          <div class="text-wrapper-8">電話番号：0942-46-5081</div>
          <div class="element-2">営業時間：平日9:00-17:00</div>
          <div class="text-wrapper-7">
            会社名：株式会社ちくぎん地域経済研究所
          </div>
        </div>

        <div class="group-5">
          <div class="text-wrapper-4">お車でお越しの場合</div>
          <div class="text-wrapper-5">
            タイムズ合川町混 | 約811m 徒歩で約10分
          </div>
          <div class="text-wrapper-6">
            Dパーキング諏訪野町第1 | 約830m 徒歩で約10分
          </div>
          <p class="text-wrapper-7">
            【予約制】軒先パーキング 合川スタンド跡駐車場 | 約497m 徒歩で約6分
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "ViewSubsection",
  data() {
    return {
      rectangle3: require('../../public/img/rectangle-3.png'),
      vector62: require('../../public/img/vector-6-3.svg'),
    };
  },
};
</script>

<style>
.view-subsection {
  /* Add your styles here */
}

.group {
  /* Add your styles here */
}

.group-2 {
  /* Add your styles here */
}

.text-wrapper-2 {
  /* Add your styles here */
}

.vector {
  /* Add your styles here */
}

.text-wrapper-3 {
  /* Add your styles here */
}

.frame-2 {
  /* Add your styles here */
}

.rectangle {
  /* Add your styles here */
}

.frame-3 {
  /* Add your styles here */
}

.group-3 {
  /* Add your styles here */
}

.text-wrapper-4 {
  /* Add your styles here */
}

.text-wrapper-5 {
  /* Add your styles here */
}

.text-wrapper-6 {
  /* Add your styles here */
}

.text-wrapper-7 {
  /* Add your styles here */
}

.group-4 {
  /* Add your styles here */
}

.element {
  /* Add your styles here */
}

.text-wrapper-8 {
  /* Add your styles here */
}

.element-2 {
  /* Add your styles here */
}

.group-5 {
  /* Add your styles here */
}
</style>