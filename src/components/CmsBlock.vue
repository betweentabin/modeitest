<template>
  <div v-if="html" :class="wrapperClass" v-html="html"></div>
  <slot v-else></slot>
</template>

<script>
import apiClient from '@/services/apiClient'

export default {
  name: 'CmsBlock',
  props: {
    pageKey: { type: String, required: true },
    wrapperClass: { type: String, default: '' }
  },
  data() {
    return { html: '' }
  },
  async mounted() {
    try {
      const res = await apiClient.getPageContent(this.pageKey)
      const html = res?.data?.page?.content?.html
      if (typeof html === 'string') this.html = html
    } catch (e) {
      // noop (fallback to slot)
    }
  }
}
</script>

<style scoped>
/* No default styles */
</style>

