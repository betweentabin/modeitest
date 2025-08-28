<template>
  <div class="frame-1321317530">
    <div class="frame-1321317521">
      <router-link to="/" class="footer-link">
        <frame13213175225 :text14="frame132131752251Props.text14" />
      </router-link>
      <router-link to="/about" class="footer-link">
        <frame13213175225 :text14="frame132131752252Props.text14" />
      </router-link>
      <router-link to="/news" class="footer-link">
        <frame13213175225 :text14="frame132131752253Props.text14" />
      </router-link>
      <router-link to="/faq" class="footer-link">
        <frame13213175225 :text14="frame132131752254Props.text14" />
      </router-link>
      <router-link to="/contact" class="footer-link">
        <frame13213175225 :text14="frame132131752255Props.text14" />
      </router-link>
    </div>


    
    <div class="frame-1321317522">
      <router-link to="/seminars" class="footer-link">
        <frame13213175222 :text19="frame132131752221Props.text19" />
      </router-link>
      <router-link to="/publications" class="footer-link">
        <frame13213175222 :text19="frame132131752222Props.text19" />
      </router-link>
      <frame13213175273
        :frame13213175222Props="frame132131752731Props.frame13213175222Props"
        :frame13213175251Props="frame132131752731Props.frame13213175251Props"
        :frame13213175252Props="frame132131752731Props.frame13213175252Props"
      />
      <frame13213175273
        :frame13213175222Props="frame132131752732Props.frame13213175222Props"
        :frame13213175251Props="frame132131752732Props.frame13213175251Props"
        :frame13213175252Props="frame132131752732Props.frame13213175252Props"
      />
    </div>



    <div class="frame-1321317523">
      <div class="frame-container">
        <div class="frame-132131752-2">
          <router-link to="/services" class="footer-link">
            <frame13213175222 :text19="'会員サービスのご案内'" />
          </router-link>
          <router-link to="/membership/standard" class="footer-link">
            <frame13213175255 :text22="frame1321317525221Props.text26" />
          </router-link>
          <router-link to="/membership/premium" class="footer-link">
            <frame13213175255 :text22="frame1321317525222Props.text26" />
          </router-link>
        </div>
        <router-link to="/cri-consulting" class="footer-link">
          <div class="frame-1321317522-1">
            <img
              class="vector-27"
              src="/img/vector.svg"
              alt="Vector"
            />
            <div class="cri valign-text-middle inter-normal-black-16px">CRI 経営コンサルティング</div>
          </div>
        </router-link>
        <router-link to="/financial-reports" class="footer-link">
          <div class="frame-1321317523-1">
            <img
              class="vector-27"
              src="/img/vector.svg"
              alt="Vector"
            />
            <div class="text-28 valign-text-middle inter-normal-black-16px">決算報告</div>
          </div>
        </router-link>
      </div>
    </div>


    
    <div class="frame-1321317524-1">
      <div class="frame-container-1">
        <router-link to="/login" class="footer-link">
          <frame13213175223 :text29="frame132131752231Props.text29" />
        </router-link>
        <router-link to="/transaction-law" class="footer-link">
          <frame13213175223 :text29="frame132131752232Props.text29" :className="frame132131752232Props.className" />
        </router-link>
        <router-link to="/privacy-policy" class="footer-link">
          <frame13213175223 :text29="frame132131752233Props.text29" :className="frame132131752233Props.className" />
        </router-link>
        <router-link to="/terms-of-service" class="footer-link">
          <frame13213175223 :text29="frame132131752234Props.text29" :className="frame132131752234Props.className" />
        </router-link>
        <router-link to="/sitemap" class="footer-link">
          <frame13213175223 :text29="frame132131752235Props.text29" />
        </router-link>
      </div>
    </div>
  </div>
</template>

<script>
import Frame13213175225 from "./Frame13213175225";
import Frame13213175222 from "./Frame13213175222";
import Frame13213175273 from "./Frame13213175273";
import Frame132131752522 from "./Frame132131752522";
import Frame13213175223 from "./Frame13213175223";
import Frame13213175255 from "./Frame13213175255";
export default {
  name: "Footer",
  components: {
    Frame13213175225,
    Frame13213175222,
    Frame13213175273,
    Frame132131752522,
    Frame13213175223,
    Frame13213175255,
  },
  props: [
    "frame132131752251Props",
    "frame132131752252Props",
    "frame132131752253Props",
    "frame132131752254Props",
    "frame132131752255Props",
    "frame132131752221Props",
    "frame132131752222Props",
    "frame132131752731Props",
    "frame132131752732Props",
    "frame1321317525221Props",
    "frame1321317525222Props",
    "frame132131752231Props",
    "frame132131752232Props",
    "frame132131752233Props",
    "frame132131752234Props",
    "frame132131752235Props",
  ],
};
</script>

<style>
.frame-1321317530 {
  align-items: flex-start;
  display: flex;
  flex: 0 0 auto;
  gap: 60px;
  position: relative;
  width: 100%;
  flex-wrap: wrap;
  justify-content: space-between;
  min-height: 200px;
}

.frame-1321317521 {
  align-items: flex-start;
  display: flex;
  flex-direction: column;
  gap: 20px;
  position: relative;
  width: 151px;
  min-width: 140px;
}

.frame-1321317522 {
  align-items: flex-start;
  display: flex;
  flex-direction: column;
  gap: 20px;
  position: relative;
  width: 171px;
  min-width: 160px;
}

.frame-1321317523 {
  height: 134px;
  position: relative;
  width: 210px;
}

.frame-container {
  align-items: flex-start;
  display: flex;
  flex-direction: column;
  gap: 20px;
  min-height: 134px;
}

.frame-132131752-2 {
  align-items: flex-start;
  display: flex;
  flex: 0 0 auto;
  flex-direction: column;
  gap: 5px;
  position: relative;
  width: 171px;
}



.frame-1321317522-1 {
  align-items: flex-start;
  display: flex;
  gap: 10px;
  height: 18px;
  width: 210px;
}

.cri {
  align-self: center;
  height: 12px;
  letter-spacing: 0;
  line-height: 32px;
  margin-bottom: 2.75px;
  min-width: 190px;
  white-space: nowrap;
}

.frame-1321317523-1 {
  align-items: flex-start;
  display: flex;
  gap: 10px;
  height: 18px;
  width: 84px;
}

.text-28 {
  align-self: center;
  height: 12px;
  letter-spacing: 0;
  line-height: 32px;
  margin-bottom: 2.75px;
  min-width: 64px;
  white-space: nowrap;
}

.frame-1321317524-1 {
  height: 170px;
  position: relative;
  width: 212px;
}

.frame-container-1 {
  align-items: flex-start;
  display: flex;
  flex-direction: column;
  gap: 20px;
  min-height: 170px;
  position: relative;
}
.footer-link {
  text-decoration: none;
  color: inherit;
  display: block;
  transition: opacity 0.3s;
}

.footer-link:hover {
  opacity: 0.7;
}

</style>
