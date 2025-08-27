<template>
  <div class="container-center-horizontal">
    <div class="screen24-mobile screen">
      <Navigation2 />
      <div class="mobile-content-wrapper">
        <div class="hero-section-mobile">
          <img
            class="hero-image-mobile"
            :src="heroImageProps.heroImage || '/img/hero-image-1.png'"
            alt="Hero Image"
          />
        </div>
        
        <div class="main-content-mobile">
          <div class="membership-section-mobile">
            <about2 />
            <div class="membership-content-mobile">
              <frame1321317705 v-bind="frame1321317705Props" />
              <div class="join-button-mobile">
                <div class="join-text-mobile">{{ text1982 }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <NavigationFooter2 />
    </div>
  </div>
</template>

<script>
import Navigation2 from "./Navigation2";
import NavigationFooter2 from "./NavigationFooter2";
import About2 from "./About2";
import Frame1321317705 from "./Frame1321317705";

export default {
  name: "Screen24Mobile",
  components: {
    Navigation2,
    NavigationFooter2,
    About2,
    Frame1321317705,
  },
  props: {
    text1982: {
      type: String,
      default: "会員になりたい方はこちら",
    },
    heroImageProps: {
      type: Object,
      default: () => ({
        heroImage: "/img/hero-image-1.png",
        membership: "MEMBERSHIP",
        text65: "会員について",
        className: "hero-image-mobile",
      }),
    },
    frame1321317705Props: {
      type: Object,
      default: () => ({}),
    },
  },
};
</script>

<style scoped>
.screen24-mobile {
  display: flex;
  flex-direction: column;
  width: 100%;
  max-width: 768px;
  margin: 0 auto;
  background-color: var(--cararra);
  min-height: 100vh;
}

.mobile-content-wrapper {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 20px;
  padding: 0 0 20px 0;
}

.hero-section-mobile {
  width: 100%;
  overflow: hidden;
}

.hero-image-mobile {
  width: 100%;
  height: 200px;
  object-fit: cover;
}

.main-content-mobile {
  display: flex;
  flex-direction: column;
  gap: 20px;
  padding: 0 20px;
  flex: 1;
}

.membership-section-mobile {
  display: flex;
  flex-direction: column;
  gap: 30px;
}

.membership-content-mobile {
  background-color: var(--white);
  border-radius: 20px;
  padding: 30px 20px;
  display: flex;
  flex-direction: column;
  gap: 30px;
  align-items: center;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.join-button-mobile {
  background-color: var(--mandy);
  border-radius: 15px;
  padding: 15px 40px;
  box-shadow: 0px 1px 2px #0000000d;
  width: 100%;
  max-width: 320px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.join-text-mobile {
  font-size: 16px;
  font-weight: bold;
  color: white;
  text-align: center;
  line-height: 1.4;
}

/* Tablet styles */
@media (max-width: 1024px) and (min-width: 768px) {
  .main-content-mobile {
    padding: 0 40px;
  }
  
  .hero-image-mobile {
    height: 250px;
  }
  
  .membership-content-mobile {
    padding: 40px 30px;
  }
  
  .join-button-mobile {
    padding: 18px 60px;
    max-width: 400px;
  }
  
  .join-text-mobile {
    font-size: 18px;
  }
}

/* Mobile styles */
@media (max-width: 767px) {
  .mobile-content-wrapper {
    padding: 0 0 15px 0;
    gap: 15px;
  }
  
  .main-content-mobile {
    padding: 0 15px;
    gap: 15px;
  }
  
  .hero-image-mobile {
    height: 160px;
  }
  
  .membership-section-mobile {
    gap: 20px;
  }
  
  .membership-content-mobile {
    padding: 20px 15px;
    gap: 20px;
    border-radius: 15px;
  }
  
  .join-button-mobile {
    padding: 12px 30px;
    border-radius: 10px;
  }
  
  .join-text-mobile {
    font-size: 14px;
  }
}

/* Extra small mobile styles */
@media (max-width: 480px) {
  .main-content-mobile {
    padding: 0 10px;
  }
  
  .membership-content-mobile {
    padding: 15px 10px;
  }
  
  .join-button-mobile {
    padding: 10px 20px;
  }
  
  .join-text-mobile {
    font-size: 13px;
  }
}
</style>