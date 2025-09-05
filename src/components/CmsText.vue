<template>
  <InlineEditable
    v-bind="$attrs"
    :tag="tag"
    :pageKey="pageKey"
    :fieldKey="fieldKey"
    :type="type"
    :value="display"
  >
    {{ display }}
  </InlineEditable>
  
</template>

<script>
import { computed } from 'vue'
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
  },
  setup(props) {
    const pageText = usePageText(props.pageKey)
    pageText.load().catch(() => {})
    const display = computed(() => {
      if (props.type === 'html') return pageText.getHtml(props.fieldKey, props.fallback)
      if (props.type === 'link') return pageText.getLink(props.fieldKey, props.fallback)
      return pageText.getText(props.fieldKey, props.fallback)
    })
    return { display }
  }
}
</script>
