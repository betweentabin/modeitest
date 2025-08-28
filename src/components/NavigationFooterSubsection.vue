<template>
  <div class="navigation-footer-subsection">
    <div class="frame-4">
      <div class="frame-5">
        <div class="frame-6">
          <img class="img" alt="Vector" :src="vector13" />
          <div class="text-wrapper-9">トップ</div>
        </div>
        <div class="frame-6" @click="navigateToCompanyProfile" style="cursor: pointer;">
          <img class="img" alt="Vector" :src="vector14" />
          <div class="text-wrapper-9">会社概要</div>
        </div>
        <div class="frame-6">
          <img class="img" alt="Vector" :src="vector15" />
          <div class="text-wrapper-9">お知らせ</div>
        </div>
        <div class="frame-6">
          <img class="img" alt="Vector" :src="vector16" />
          <div class="text-wrapper-9">よくあるご質問</div>
        </div>
        <div class="frame-6">
          <img class="img" alt="Vector" :src="vector17" />
          <div class="text-wrapper-9">お問い合わせ</div>
        </div>
      </div>
      <div class="frame-7">
        <div class="frame-6">
          <img class="img" alt="Vector" :src="vector18" />
          <div class="text-wrapper-9">セミナー</div>
        </div>
        <div class="frame-6">
          <img class="img" alt="Vector" :src="vector19" />
          <div class="text-wrapper-9">刊行物</div>
        </div>
        <div class="frame-8">
          <div class="frame-6">
            <img class="img" alt="Vector" :src="vector20" />
            <div class="text-wrapper-9">各種情報</div>
          </div>
          <div class="frame-9">
            <img class="vector-2" alt="Vector" :src="vector21" />
            <div class="text-wrapper-10">経済指標一覧</div>
          </div>
          <div class="frame-9">
            <img class="vector-2" alt="Vector" :src="vector22" />
            <div class="text-wrapper-10">経済調査統計一覧</div>
          </div>
        </div>
        <div class="frame-8">
          <div class="frame-6">
            <img class="img" alt="Vector" :src="vector23" />
            <div class="text-wrapper-9">会員PR</div>
          </div>
          <div class="frame-10">
            <img class="vector-2" alt="Vector" :src="vector24" />
            <div class="text-wrapper-10">会員PRどっとコム</div>
          </div>
          <div class="frame-9">
            <img class="vector-2" alt="Vector" :src="vector" />
            <div class="text-wrapper-10">入会案内</div>
          </div>
        </div>
      </div>
      <div class="frame-11">
        <div class="frame-12">
          <div class="frame-13">
            <img class="img" alt="Vector" :src="image" />
            <div class="text-wrapper-9">会員サービスのご案内</div>
          </div>
          <div class="frame-14">
            <img class="vector-2" alt="Vector" :src="vector2" />
            <div class="text-wrapper-10">スタンダード（紹介）</div>
          </div>
          <div class="frame-15">
            <img class="vector-2" alt="Vector" :src="vector3" />
            <div class="text-wrapper-10">プレミアム（紹介）</div>
          </div>
        </div>
        <div class="frame-16">
          <img class="img" alt="Vector" :src="vector4" />
          <div class="text-wrapper-9">CRI 経営コンサルティング</div>
        </div>
        <div class="frame-17">
          <img class="img" alt="Vector" :src="vector5" />
          <div class="text-wrapper-9">決算報告</div>
        </div>
      </div>
      <div class="frame-18">
        <div class="frame-19">
          <img class="img" alt="Vector" :src="vector6" />
          <div class="text-wrapper-9">会員ログイン</div>
        </div>
        <div class="frame-20">
          <img class="img" alt="Vector" :src="vector7" />
          <div class="text-wrapper-9">特定商取引法に関する表記</div>
        </div>
        <div class="frame-21" @click="navigateToPrivacyPolicy" style="cursor: pointer;">
          <img class="img" alt="Vector" :src="vector8" />
          <div class="text-wrapper-9">プライバシーポリシー</div>
        </div>
        <div class="frame-22">
          <img class="img" alt="Vector" :src="vector9" />
          <div class="text-wrapper-9">利用規約</div>
        </div>
        <div class="frame-23">
          <img class="img" alt="Vector" :src="vector10" />
          <div class="text-wrapper-9">サイトマップ</div>
        </div>
      </div>
    </div>
    <img class="vector-3" alt="Vector" :src="vector72" />
    <div class="group-6">
      <div class="group-7">
        <div class="group-8">
          <div class="view">
            <div class="text-wrapper-11">
              株式会社ちくぎん地域経済研究所
            </div>
            <div class="text-wrapper-12">筑邦銀行グループ</div>
          </div>
          <img class="ico-logo" alt="Ico logo" :src="icoLogo1" />
        </div>
        <div class="element-3">
          〒839-0864　福岡県久留米市百年公園1番1号
          久留米リサーチセンタービル6階
          <br />
          電話番号. 0942-46-5081　営業時間. 平日9:00-17:00
        </div>
      </div>
      <p class="p">
        Copyright (C) The Chikugin Reserch Institute For Regional Economy
        Co.,Ltd All rights reserved.
      </p>
    </div>
  </div>
</template>

<script>
import icoLogo1 from "../../public/img/ico-logo-1-1.svg";
import image from "../../public/img/vector-1.svg";
import vector2 from "../../public/img/vector-2.svg";
import vector3 from "../../public/img/vector-1.svg";
import vector4 from "../../public/img/vector-1.svg";
import vector5 from "../../public/img/vector-5.svg";
import vector6 from "../../public/img/vector-6.svg";
import vector72 from "../../public/img/vector-7.svg";
import vector7 from "../../public/img/vector-7.svg";
import vector8 from "../../public/img/vector-1.svg";
import vector9 from "../../public/img/vector-1.svg";
import vector10 from "../../public/img/vector-1.svg";
import vector13 from "../../public/img/vector-13.svg";
import vector14 from "../../public/img/vector-14.svg";
import vector15 from "../../public/img/vector-1.svg";
import vector16 from "../../public/img/vector-1.svg";
import vector17 from "../../public/img/vector-1.svg";
import vector18 from "../../public/img/vector-1.svg";
import vector19 from "../../public/img/vector-1.svg";
import vector20 from "../../public/img/vector-1.svg";
import vector21 from "../../public/img/vector-1.svg";
import vector22 from "../../public/img/vector-1.svg";
import vector23 from "../../public/img/vector-1.svg";
import vector24 from "../../public/img/vector-1.svg";
import vector from "../../public/img/vector.svg";

export default {
  name: "NavigationFooterSubsection",
  data() {
    return {
      icoLogo1,
      image,
      vector2,
      vector3,
      vector4,
      vector5,
      vector6,
      vector72,
      vector7,
      vector8,
      vector9,
      vector10,
      vector13,
      vector14,
      vector15,
      vector16,
      vector17,
      vector18,
      vector19,
      vector20,
      vector21,
      vector22,
      vector23,
      vector24,
      vector,
    };
  },
  methods: {
    navigateToCompanyProfile() {
      this.$router.push('/company-profile');
    },
    navigateToPrivacyPolicy() {
      this.$router.push('/privacy-policy');
    }
  }
};
</script>

<style>
.navigation-footer-subsection {
  /* Add your styles here */
}

.frame-4 {
  /* Add your styles here */
}

.frame-5 {
  /* Add your styles here */
}

.frame-6 {
  /* Add your styles here */
}

.img {
  /* Add your styles here */
}

.text-wrapper-9 {
  /* Add your styles here */
}

.frame-7 {
  /* Add your styles here */
}

.frame-8 {
  /* Add your styles here */
}

.frame-9 {
  /* Add your styles here */
}

.frame-10 {
  /* Add your styles here */
}

.frame-11 {
  /* Add your styles here */
}

.frame-12 {
  /* Add your styles here */
}

.frame-13 {
  /* Add your styles here */
}

.frame-14 {
  /* Add your styles here */
}

.frame-15 {
  /* Add your styles here */
}

.frame-16 {
  /* Add your styles here */
}

.frame-17 {
  /* Add your styles here */
}

.frame-18 {
  /* Add your styles here */
}

.frame-19 {
  /* Add your styles here */
}

.frame-20 {
  /* Add your styles here */
}

.frame-21 {
  /* Add your styles here */
}

.frame-22 {
  /* Add your styles here */
}

.frame-23 {
  /* Add your styles here */
}

.group-6 {
  /* Add your styles here */
}

.group-7 {
  /* Add your styles here */
}

.group-8 {
  /* Add your styles here */
}

.view {
  /* Add your styles here */
}

.text-wrapper-11 {
  /* Add your styles here */
}

.text-wrapper-12 {
  /* Add your styles here */
}

.element-3 {
  /* Add your styles here */
}

.p {
  /* Add your styles here */
}
</style>