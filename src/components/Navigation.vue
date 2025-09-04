<template>
  <div class="navigation">
    <div class="logo-section">
      <view-component />
      <group1 />
    </div>
    <div class="nav-controls">
      <div class="main-nav">
        <x-button v-if="!isMobile" />
        <x-button2 v-if="!isMobile" />
        <button class="hamburger-menu" @click="toggleMenu">
          <div class="hamburger-line"></div>
          <div class="hamburger-line"></div>
          <div class="hamburger-line"></div>
        </button>
      </div>
      <div class="sub-nav">
        <items />
      </div>
    </div>
    
    <!-- PC Menu Modal -->
    <pc-menu-modal :isOpen="isMenuOpen" @close="closeMenu" />
  </div>
</template>

<script>
import ViewComponent from "./ViewComponent";
import Group1 from "./Group1";
import XButton from "./XButton";
import XButton2 from "./XButton2";
import Items from "./ItemsNav";
import PcMenuModal from "./PcMenuModal.vue";

export default {
  name: "Navigation",
  components: {
    ViewComponent,
    Group1,
    XButton: XButton,
    XButton2,
    Items,
    PcMenuModal,
  },
  data() {
    return {
      isMenuOpen: false,
      isMobile: false
    };
  },
  mounted() {
    this.checkScreenSize();
    window.addEventListener('resize', this.checkScreenSize);
  },
  beforeDestroy() {
    window.removeEventListener('resize', this.checkScreenSize);
  },
  methods: {
    toggleMenu() {
      this.isMenuOpen = !this.isMenuOpen;
      console.log('Menu toggled:', this.isMenuOpen);
    },
    closeMenu() {
      this.isMenuOpen = false;
    },
    checkScreenSize() {
      this.isMobile = window.innerWidth <= 800;
    }
  }
};
</script>

<style>
.navigation {
  align-items: center;
  background-color: #ffffff;
  box-shadow: 0px 3px 20px #00000026;
  display: flex;
  justify-content: space-between;
  padding: 10px 20px;
  position: relative;
  width: 100%;
  z-index: 9;
}

.logo-section {
  display: flex;
  align-items: center;
  gap: 20px;
  min-width: 0;
  flex-shrink: 1;
  transition: gap 0.3s ease;
  height: auto;
  min-height: auto;
}

.nav-controls {
  display: flex;
  flex-direction: column;
  gap: 10px;
  width: auto;
  min-width: 0;
}

.main-nav {
  display: flex;
  align-items: center;
  gap: 15px;
  justify-content: flex-end;
  min-width: 300px;
}

.sub-nav {
  display: flex;
  align-items: center;
  gap: 15px;
  justify-content: flex-start;
}

.hamburger-menu {
  background: transparent;
  border: none;
  cursor: pointer;
  display: flex;
  flex-direction: column;
  gap: 4px;
  padding: 4px;
  width: 26px;
  height: 24px;
  justify-content: center;
  align-items: center;
}

.hamburger-line {
  width: 18px;
  height: 2px;
  background-color: #1A1A1A;
  transition: all 0.3s ease;
}

.hamburger-menu:hover .hamburger-line {
  background-color: #DA5761;
}

/* サブナビのレスポンシブ対応 */
@media (max-width: 1150px) {
  .sub-nav {
    display: none;
  }
}

/* モバイルでボタンを非表示 */
@media (max-width: 800px) {
  .x-button,
  .x-button2 {
    display: none;
  }
}

/* 小さい画面でのレイアウト調整 */
@media (max-width: 800px) {
  .navigation {
    padding: 12px 15px;
  }
  
  .logo-section {
    gap: 12px;
    height: auto;
    min-height: auto;
  }
  
  .main-nav {
    min-width: 250px;
  }
}

@media (max-width: 600px) {
  .navigation {
    padding: 10px 10px;
  }
  
  .logo-section {
    gap: 8px;
    height: auto;
    min-height: auto;
  }
  
  .main-nav {
    min-width: 200px;
    gap: 10px;
  }
}

@media (max-width: 480px) {
  .navigation {
    padding: 8px 8px;
  }
  
  .logo-section {
    gap: 6px;
    height: auto;
    min-height: auto;
  }
  
  .main-nav {
    min-width: auto;
    gap: 8px;
  }
}
</style>
