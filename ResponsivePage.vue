<template>
  <div class="responsive-page">
    <!-- デスクトップ版 -->
    <div class="desktop-only">
      <component :is="desktopComponent" v-bind="desktopProps || pageProps" />
    </div>
    
    <!-- モバイル版 -->
    <div class="mobile-only">
      <component :is="mobileComponent" v-bind="mobileProps || pageProps" />
    </div>
  </div>
</template>

<script>
export default {
  name: 'ResponsivePage',
  props: {
    desktopComponent: {
      type: [String, Object],
      required: true
    },
    mobileComponent: {
      type: [String, Object],
      required: true
    },
    pageProps: {
      type: Object,
      default: () => ({})
    },
    desktopProps: {
      type: Object,
      default: null
    },
    mobileProps: {
      type: Object,
      default: null
    }
  },
  mounted() {
    console.log('ResponsivePage mounted with:', {
      desktopComponent: this.desktopComponent,
      mobileComponent: this.mobileComponent,
      pageProps: this.pageProps,
      desktopProps: this.desktopProps,
      mobileProps: this.mobileProps
    })
  }
}
</script>

<style scoped>
.responsive-page {
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
