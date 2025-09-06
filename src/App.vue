<template>
  <div>
    <router-view />
    <EditModeToggle />
  </div>
</template>

<script>
import EditModeToggle from './components/EditModeToggle.vue'
export default {
  name: "App",
  components: { EditModeToggle }
};
</script>
