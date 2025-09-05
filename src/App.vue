<template>
  <router-view />
  <EditModeToggle />
  
</template>

<script>
import EditModeToggle from './components/EditModeToggle.vue'
export default {
  name: "App",
  components: { EditModeToggle }
};
</script>
