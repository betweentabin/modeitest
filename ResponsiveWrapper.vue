<template>
  <div class="responsive-wrapper">
    <!-- デスクトップ版 -->
    <div class="desktop-only">
      <component :is="desktopComponent" v-bind="componentProps" />
    </div>
    
    <!-- モバイル版 -->
    <div class="mobile-only">
      <component :is="mobileComponent" v-bind="componentProps" />
    </div>
  </div>
</template>

<script>
export default {
  name: 'ResponsiveWrapper',
  props: {
    desktopComponent: {
      type: [String, Object],
      required: true
    },
    mobileComponent: {
      type: [String, Object],
      required: true
    },
    componentProps: {
      type: Object,
      default: () => ({})
    }
  },
  mounted() {
    console.log('ResponsiveWrapper mounted with:', {
      desktopComponent: this.desktopComponent,
      mobileComponent: this.mobileComponent,
      componentProps: this.componentProps
    })
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
