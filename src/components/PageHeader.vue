<template>
  <div class="page-header">
    <!-- Navigation -->
    <navigation />
  </div>
</template>

<script>
import Navigation from "./Navigation.vue";

export default {
  name: "PageHeader",
  components: {
    Navigation,
  }
};
</script>

<style scoped>
.page-header {
  width: 100%;
}
</style>
