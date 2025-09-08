<template>
  <div v-if="html">
    <!-- 編集モード（ライブプレビューで直接編集） -->
    <div 
      v-if="isEditMode"
      :class="wrapperClass"
      ref="editable"
      contenteditable
      v-html="html"
      @input="onEditInput"
    ></div>
    <!-- 通常表示 -->
    <div v-else :class="wrapperClass" v-html="html"></div>
  </div>
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
    const pickHtml = (payload) => {
      const body = payload?.data || payload
      const page = body?.page || body?.data?.page || null
      const content = page?.content || body?.content || null
      if (!content) return ''
      // 優先: content.html → content.htmls.body → content.htmls（文字列互換）
      if (typeof content.html === 'string' && content.html.trim()) return content.html
      if (content.htmls && typeof content.htmls.body === 'string' && content.htmls.body.trim()) return content.htmls.body
      if (typeof content.htmls === 'string' && content.htmls.trim()) return content.htmls
      return ''
    }

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
      // Also try to fetch latest from admin endpoint when admin token exists
      try {
        const token = localStorage.getItem('admin_token')
        if (token) {
          const res = await apiClient.get(`/api/admin/pages/${this.pageKey}`, { silent: true, params: { _t: Date.now() } })
          const html = pickHtml(res)
          if (typeof html === 'string' && html.trim().length) this.html = html
        }
      } catch (_) { /* ignore */ }
      return
    }
    try {
      const res = await apiClient.getPageContent(this.pageKey)
      const html = pickHtml(res)
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
    _hasCmsEditFlag() {
      try {
        const hash = window.location.hash || ''
        const qs = hash.includes('?') ? hash.split('?')[1] : window.location.search.slice(1)
        const params = new URLSearchParams(qs)
        return params.has('cmsEdit') || params.get('cmsPreview') === 'edit'
      } catch (_) { return false }
    },
    _loadPreviewFromStorage() {
      try {
        const v = localStorage.getItem(this._lsKey())
        if (typeof v === 'string') this.html = v
      } catch(_) {}
    },
    onEditInput() {
      try {
        const current = this.$refs.editable ? this.$refs.editable.innerHTML : ''
        // 親（管理画面）へ送信
        if (window.parent) {
          window.parent.postMessage({ type: 'cms-edit', pageKey: this.pageKey, html: current }, '*')
        }
        // ローカルにも保存
        try { localStorage.setItem(this._lsKey(), current) } catch(_) {}
      } catch(_) {}
    }
  },
  computed: {
    isEditMode() {
      return this._hasCmsPreviewFlag() && this._hasCmsEditFlag()
    }
  }
}
</script>

<style scoped>
/* No default styles */
</style>
