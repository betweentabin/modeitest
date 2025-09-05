<template>
  <div v-if="html" :class="wrapperClass" v-html="html"></div>
  <div v-else>
    <slot></slot>
  </div>
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
    return { html: '', _previewHandler: null }
  },
  async mounted() {
    const hasPreview = this._hasCmsPreviewFlag()
    if (hasPreview) {
      this._loadPreviewFromStorage()
      this._previewHandler = (ev) => {
        const data = ev?.data || {}
        if (data && data.type === 'cms-preview' && data.pageKey === this.pageKey) {
          if (typeof data.html === 'string') {
            this.html = data.html
            try { localStorage.setItem(this._lsKey(), data.html) } catch (_) {}
          }
        }
      }
      window.addEventListener('message', this._previewHandler)
      return
    }
    try {
      const res = await apiClient.getPageContent(this.pageKey)
      const html = res?.data?.page?.content?.html
      if (typeof html === 'string') this.html = html
    } catch (e) { /* noop */ }
  },
  beforeDestroy() {
    if (this._previewHandler) {
      window.removeEventListener('message', this._previewHandler)
      this._previewHandler = null
    }
  },
  methods: {
    _lsKey() { return `cms_preview_${this.pageKey}` },
    _hasCmsPreviewFlag() {
      try {
        const hash = window.location.hash || ''
        const qs = hash.includes('?') ? hash.split('?')[1] : window.location.search.slice(1)
        const params = new URLSearchParams(qs)
        return params.has('cmsPreview')
      } catch (_) { return false }
    },
    _loadPreviewFromStorage() {
      try {
        const v = localStorage.getItem(this._lsKey())
        if (typeof v === 'string') this.html = v
      } catch(_) {}
    }
  }
}
</script>

<style scoped>
/* No default styles */
</style>
