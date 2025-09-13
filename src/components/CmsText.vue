<template>
  <InlineEditable
    v-bind="$attrs"
    :tag="tag"
    :pageKey="pageKey"
    :fieldKey="fieldKey"
    :type="type"
    :allowEmpty="allowEmpty"
    :value="display"
  >
    {{ display }}
  </InlineEditable>
  
</template>

<script>
import { computed, onMounted, onBeforeUnmount } from 'vue'
import InlineEditable from '@/components/InlineEditable.vue'
import { usePageText } from '@/composables/usePageText'

export default {
  name: 'CmsText',
  components: { InlineEditable },
  inheritAttrs: false,
  props: {
    pageKey: { type: String, required: true },
    fieldKey: { type: String, required: true },
    type: { type: String, default: 'text' }, // 'text' | 'html' | 'link'
    tag: { type: String, default: 'span' },
    fallback: { type: String, default: '' },
    // When true, allow empty string to render as blank (no fallback)
    allowEmpty: { type: Boolean, default: false },
    // Defer rendering fallback until first load completes to avoid showing stale static text
    deferFallback: { type: Boolean, default: true },
  },
  setup(props) {
    const pageText = usePageText(props.pageKey)
    pageText.load().catch(() => {})
    const display = computed(() => {
      const isLoading = !!(pageText.loading && pageText.loading.value)
      const hasPage = !!(pageText.page && pageText.page.value)
      const shouldDefer = !!props.deferFallback && isLoading && !hasPage
      const fb = shouldDefer ? '' : props.fallback
      if (props.type === 'html') return pageText.getHtml(props.fieldKey, fb, { allowEmpty: props.allowEmpty })
      if (props.type === 'link') return pageText.getLink(props.fieldKey, fb, { allowEmpty: props.allowEmpty })
      return pageText.getText(props.fieldKey, fb, { allowEmpty: props.allowEmpty })
    })
    // Preview key broadcasting: helps admin editor collect keys used on page
    const hasPreview = () => {
      try {
        const hash = window.location.hash || ''
        const qs = hash.includes('?') ? hash.split('?')[1] : (window.location.search || '').slice(1)
        const params = new URLSearchParams(qs)
        return params.has('cmsPreview')
      } catch(_) { return false }
    }
    let handler = null
    onMounted(() => {
      if (!hasPreview()) return
      try {
        window.parent && window.parent.postMessage({ type: 'cms-key', pageKey: props.pageKey, fieldKey: props.fieldKey, value: (typeof display.value === 'string' ? display.value : '') }, '*')
      } catch(_) {}
      handler = (ev) => {
        const data = ev?.data || {}
        if (data && data.type === 'cms-list-keys') {
          if (!data.pageKey || data.pageKey === props.pageKey) {
            try {
              window.parent && window.parent.postMessage({ type: 'cms-key', pageKey: props.pageKey, fieldKey: props.fieldKey, value: (typeof display.value === 'string' ? display.value : '') }, '*')
            } catch(_) {}
          }
        }
      }
      try { window.addEventListener('message', handler) } catch(_) {}
    })
    onBeforeUnmount(() => { try { if (handler) window.removeEventListener('message', handler) } catch(_) {} handler = null })
    return { display }
  }
}
</script>
