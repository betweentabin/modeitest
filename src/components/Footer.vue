<template>
  <div class="footer-container">
    <div class="frame-1321317530">
      <div class="frame-1321317521">
      <router-link to="/" class="footer-link">
        <frame13213175225 :text14="frame132131752251Props.text14" />
      </router-link>
      <router-link to="/company" class="footer-link">
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
      <router-link to="/seminar" class="footer-link">
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
          <frame13213175222 :text19="'CRI 経営コンサルティング'" />
        </router-link>
        <router-link to="/financial-reports" class="footer-link">
          <frame13213175222 :text19="'決算報告'" />
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
  
  <!-- Separator line -->
  <div class="vector-7-1"></div>
  
  <!-- Group27 component -->
  <group27 />
</div>
</template>

<script>
import Frame13213175225 from "./Frame13213175225";
import Frame13213175222 from "./Frame13213175222";
import Frame13213175273 from "./Frame13213175273";
import Frame132131752522 from "./Frame132131752522";
import Frame13213175223 from "./Frame13213175223";
import Frame13213175255 from "./Frame13213175255";
import Group27 from "./Group27";
export default {
  name: "Footer",
  components: {
    Frame13213175225,
    Frame13213175222,
    Frame13213175273,
    Frame132131752522,
    Frame13213175223,
    Frame13213175255,
    Group27,
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
/* Footer container */
.footer-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  width: 100%;
  padding: 50px 100px;
  gap: 50px;
  background-color: #CFCFCF;
}

/* Vector separator line */
.vector-7-1 {
  height: 1px;
  background-color: #B2B2B2;
  position: relative;
  width: 100%;
  max-width: 1240px;
  margin: 0 auto;
}

/* Group27 component styling */
group27 {
  display: block;
  width: 100%;
}

.frame-1321317530 {
  align-items: flex-start;
  display: flex;
  flex: 0 0 auto;
  gap: 60px;
  position: relative;
  width: 100%;
  max-width: 1200px;
  flex-wrap: wrap;
  justify-content: center;
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

.text19 {
  align-self: center;
  height: auto;
  letter-spacing: 0;
  line-height: 1.5;
  margin-bottom: 2.75px;
  min-width: 190px;
  white-space: nowrap;
  font-size: 16px;
}

.frame-1321317523-1 {
  align-items: flex-start;
  display: flex;
  gap: 10px;
  height: 18px;
  width: 84px;
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

/* navigation-footer スタイル */
.navigation-footer {
  background: #CFCFCF;
  padding: 100px;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 50px;
  width: 100%;
  box-sizing: border-box;
  position: relative;
  z-index: 4;
}

.navigation-footer .vector-7-1 {
  height: 1px;
  background-color: #B2B2B2;
  position: relative;
  width: 100%;
  max-width: 1240px;
}

.navigation-footer .frame132131753022 {
  width: 100%;
  max-width: 1000px;
}

.navigation-footer .group27 {
  width: 100%;
  max-width: 1000px;
}

/* レスポンシブ対応 */
@media (max-width: 1150px) {
  .footer-container {
    padding: 40px 80px !important;
    gap: 40px !important;
  }
  
  .frame-1321317530 {
    gap: 40px !important;
    padding: 0 20px !important;
    max-width: 100% !important;
  }
  
  .frame-1321317521,
  .frame-1321317522 {
    width: 140px !important;
    min-width: 120px !important;
  }
  
  .frame-1321317523 {
    width: 180px !important;
  }
  
  .frame-1321317524-1 {
    width: 180px !important;
  }
  
  .navigation-footer {
    padding: 80px 50px !important;
    gap: 40px !important;
  }
}

@media (max-width: 800px) {
  .footer-container {
    padding: 30px 60px !important;
    gap: 30px !important;
  }
  
  .frame-1321317530 {
    gap: 30px !important;
    padding: 0 15px !important;
    min-height: 180px !important;
  }
  
  .frame-1321317521,
  .frame-1321317522 {
    width: 120px !important;
    min-width: 100px !important;
    gap: 15px !important;
  }
  
  .frame-1321317523 {
    width: 160px !important;
    height: auto !important;
  }
  
  .frame-1321317524-1 {
    width: 160px !important;
    height: auto !important;
  }
  
  .frame-container,
  .frame-container-1 {
    gap: 15px !important;
  }
  
  /* フッター全体のフォントサイズ統一 */
  .text19 {
    font-size: 14px !important;
    line-height: 20px !important;
  }
  
  /* フッターセクション全体のフォントサイズ調整 */
  .frame-1321317530 * {
    font-size: 14px !important;
  }
  
  .navigation-footer {
    padding: 60px 30px !important;
    gap: 30px !important;
  }
}

@media (max-width: 600px) {
  .footer-container {
    padding: 25px 40px !important;
    gap: 25px !important;
  }
  
  .frame-1321317530 {
    gap: 25px !important;
    padding: 0 10px !important;
    min-height: 160px !important;
    display: grid !important;
    grid-template-columns: 1fr 1fr !important;
    grid-template-rows: auto auto !important;
    justify-items: center !important;
    align-items: flex-start !important;
  }
  
  .frame-1321317521,
  .frame-1321317522,
  .frame-1321317523,
  .frame-1321317524-1 {
    width: 100% !important;
    max-width: 300px !important;
    text-align: left !important;
  }
  
  .frame-container,
  .frame-container-1 {
    align-items: flex-start !important;
    gap: 12px !important;
  }
  
  .frame-132131752-2 {
    align-items: flex-start !important;
    width: 100% !important;
  }
  
  .frame-1321317522-1,
  .frame-1321317523-1 {
    justify-content: flex-start !important;
    width: 100% !important;
  }
  
  /* フッター全体のフォントサイズ統一 */
  .text19 {
    font-size: 13px !important;
    line-height: 18px !important;
    min-width: auto !important;
  }
  
  /* フッターセクション全体のフォントサイズ調整 */
  .frame-1321317530 * {
    font-size: 13px !important;
  }
  
  .navigation-footer {
    padding: 40px 20px !important;
    gap: 25px !important;
  }
}

@media (max-width: 480px) {
  .footer-container {
    padding: 30px !important;
    gap: 20px !important;
  }
  
  .frame-1321317530 {
    gap: 20px !important;
    padding: 0 8px !important;
    min-height: 140px !important;
  }
  
  .frame-1321317521,
  .frame-1321317522,
  .frame-1321317523,
  .frame-1321317524-1 {
    max-width: 280px !important;
  }
  
  .frame-container,
  .frame-container-1 {
    gap: 10px !important;
  }
  
  .frame-132131752-2 {
    gap: 4px !important;
  }
  
  /* フッター全体のフォントサイズ統一 */
  .text19 {
    font-size: 12px !important;
    line-height: 16px !important;
  }
  
  /* フッターセクション全体のフォントサイズ調整 */
  .frame-1321317530 * {
    font-size: 12px !important;
  }
  
  .navigation-footer {
    padding: 30px 15px !important;
    gap: 20px !important;
  }
}

@media (max-width: 400px) {
  .footer-container {
    padding: 30px 20px !important;
    gap: 15px !important;
  }
  
  .frame-1321317530 {
    gap: 20px !important;
    padding: 0 5px !important;
    min-height: 120px !important;
  }
  
  .frame-1321317521,
  .frame-1321317522,
  .frame-1321317523,
  .frame-1321317524-1 {
    max-width: 260px !important;
  }
  
  .frame-container,
  .frame-container-1 {
    gap: 8px !important;
  }
  
  /* フッター全体のフォントサイズ統一 */
  .text19 {
    font-size: 11px !important;
    line-height: 14px !important;
  }
  
  /* フッターセクション全体のフォントサイズ調整 */
  .frame-1321317530 * {
    font-size: 11px !important;
  }
  
  .navigation-footer {
    padding: 25px 10px !important;
    gap: 15px !important;
  }
}

@media (max-width: 350px) {
  .footer-container {
    padding: 10px 15px !important;
    gap: 10px !important;
  }
  
  .frame-1321317530 {
    gap: 15px !important;
    padding: 0 5px !important;
    min-height: 100px !important;
    display: grid !important;
    grid-template-columns: 1fr !important;
    grid-template-rows: auto auto auto auto !important;
    justify-items: flex-start !important;
    align-items: flex-start !important;
  }
  
  .frame-1321317521,
  .frame-1321317522,
  .frame-1321317523,
  .frame-1321317524-1 {
    max-width: 240px !important;
    text-align: left !important;
  }
  
  .frame-container,
  .frame-container-1 {
    gap: 6px !important;
    align-items: flex-start !important;
  }
  
  .text19 {
    font-size: 10px !important;
    line-height: 12px !important;
  }
  
  .navigation-footer {
    padding: 20px 8px !important;
    gap: 10px !important;
  }
}


</style>
