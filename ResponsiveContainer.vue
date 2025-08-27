<template>
  <div class="responsive-container">
    <!-- デスクトップ版 (768px以上で表示) -->
    <div class="desktop-view">
      <component 
        :is="desktopComponent" 
        v-bind="componentProps" 
      />
    </div>
    
    <!-- モバイル版 (767px以下で表示) -->
    <div class="mobile-view">
      <component 
        :is="mobileComponent" 
        v-bind="componentProps" 
      />
    </div>
  </div>
</template>

<script>
export default {
  name: 'ResponsiveContainer',
  props: {
    desktopComponent: {
      type: [Object, Function],
      required: true
    },
    mobileComponent: {
      type: [Object, Function],
      required: true
    },
    componentProps: {
      type: Object,
      default: () => ({})
    }
  },
  mounted() {
    console.log('ResponsiveContainer mounted:', {
      desktopComponent: this.desktopComponent,
      mobileComponent: this.mobileComponent,
      componentProps: this.componentProps
    });
    
    // コンポーネントの存在確認
    if (!this.desktopComponent) {
      console.error('desktopComponent is missing');
    }
    if (!this.mobileComponent) {
      console.error('mobileComponent is missing');
    }
  },
  errorCaptured(err, instance, info) {
    console.error('ResponsiveContainer error:', err, info);
    return false;
  }
}
</script>

<style scoped>
.responsive-container {
  width: 100%;
}

/* デフォルト（デスクトップ）: 768px以上 */
.desktop-view {
  display: block;
}

.mobile-view {
  display: none;
}

/* モバイル: 767px以下 */
@media (max-width: 767px) {
  .desktop-view {
    display: none;
  }
  
  .mobile-view {
    display: block;
  }
}
</style>