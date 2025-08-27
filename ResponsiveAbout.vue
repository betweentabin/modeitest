<template>
  <div class="responsive-wrapper">
    <!-- デスクトップ版 -->
    <div class="desktop-only">
      <About />
    </div>
    
    <!-- モバイル版 -->
    <div class="mobile-only">
      <About2 />
    </div>
  </div>
</template>

<script>
import About from './About.vue'
import About2 from './About2.vue'

export default {
  name: 'ResponsiveAbout',
  components: {
    About,
    About2
  }
}
</script>

<style scoped>
.responsive-wrapper {
  width: 100%;
}

/* デスクトップ版を表示（768px以上） */
.desktop-only {
  display: block;
}

.mobile-only {
  display: none;
}

/* モバイル版を表示（767px以下） */
@media (max-width: 767px) {
  .desktop-only {
    display: none;
  }
  
  .mobile-only {
    display: block;
  }
}
</style>
