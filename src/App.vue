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
  components: { EditModeToggle },
  mounted() {
    // Global listener: when media registry updates, force a rerender of the whole app tree
    try { window.addEventListener('cms-media-updated', this._onMediaUpdated) } catch (_) {}
  },
  beforeDestroy() {
    try { window.removeEventListener('cms-media-updated', this._onMediaUpdated) } catch (_) {}
  },
  methods: {
    _onMediaUpdated() {
      try { this.$forceUpdate() } catch (_) {}
    }
  }
};
</script>
