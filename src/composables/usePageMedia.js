import { reactive } from 'vue'
import { useMedia } from '@/composables/useMedia'
import { usePageText } from '@/composables/usePageText'

// Provide per-page media key mapping over the global media registry
// PageContent.content.media_keys: { slotKey: mediaKey }

export function usePageMedia() {
  const state = reactive({
    pageKey: '',
    _media: null,
    _pageText: null,
    ready: false,
  })

  const ensure = async (pageKey) => {
    try {
      state.pageKey = pageKey || ''
      // media registry
      state._media = useMedia()
      await state._media.ensure()
      // page mapping (optional)
      if (state.pageKey) {
        state._pageText = usePageText(state.pageKey)
        await state._pageText.load({ force: true })
      }
      state.ready = true
    } catch (_) { state.ready = true }
  }

  const getMapping = () => {
    try {
      const page = state._pageText?.page?.value
      const m = page?.content?.media_keys
      return m && typeof m === 'object' ? m : {}
    } catch (_) { return {} }
  }

  const resolveMediaKey = (slotKey, defaultMediaKey = '') => {
    const map = getMapping()
    return (map && typeof map === 'object' && map[slotKey]) ? map[slotKey] : (defaultMediaKey || '')
  }

  const getSlot = (slotKey, defaultMediaKey = '', fallback = '') => {
    const mk = resolveMediaKey(slotKey, defaultMediaKey)
    return state._media ? state._media.getImage(mk, fallback) : (fallback || '')
  }

  const getResponsiveSlot = (slotKey, defaultMediaKey = '', fallback = '') => {
    const mk = resolveMediaKey(slotKey, defaultMediaKey)
    return state._media ? state._media.getResponsiveImage(mk, fallback) : (fallback || '')
  }

  return { ensure, getSlot, getResponsiveSlot, _media: state._media }
}

export default usePageMedia

