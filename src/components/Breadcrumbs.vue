<template>
  <div class="breadcrumbs" v-if="breadcrumbs && breadcrumbs.length > 0">
    <router-link to="/" class="breadcrumb-item">トップ</router-link>
    <template v-for="(item, index) in breadcrumbs">
      <span :key="`separator-${index}`" class="breadcrumb-separator">></span>
      <span 
        :key="`item-${index}`"
        class="breadcrumb-item"
        :class="{ current: index === breadcrumbs.length - 1 }"
      >
        {{ item }}
      </span>
    </template>
  </div>
</template>

<script>
export default {
  name: "Breadcrumbs",
  props: {
    breadcrumbs: {
      type: Array,
      default: () => []
    }
  }
};
</script>

<style scoped>
/* Breadcrumbs */
.breadcrumbs {
  padding: 24px 46px;
  display: flex;
  align-items: center;
  gap: 8px;
}

.breadcrumb-item {
  color: #3F3F3F;
  font-size: 12px;
  font-weight: 300;
  line-height: 5;
  text-decoration: none;
  transition: color 0.3s ease;
}

.breadcrumb-item:hover {
  color: #DA5761;
  text-decoration: underline;
}

.breadcrumb-item.current {
  color: #1A1A1A;
  font-weight: 500;
  cursor: default;
}

.breadcrumb-item.current:hover {
  color: #1A1A1A;
  text-decoration: none;
}

.breadcrumb-separator {
  color: #3F3F3F;
  font-size: 12px;
  font-weight: 300;
  line-height: 5;
}

/* レスポンシブ対応 */
@media (max-width: 768px) {
  .breadcrumbs {
    padding: 20px 20px;
  }
}

@media (max-width: 480px) {
  .breadcrumbs {
    padding: 15px 15px;
  }
}
</style>
