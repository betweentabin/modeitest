import { reactive } from 'vue'
import { useMedia } from '@/composables/useMedia'
import { usePageText } from '@/composables/usePageText'
import { resolveMediaUrl } from '@/utils/url.js'

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
    // Prefer page-managed images (PageContent.content.images[slotKey])
    try {
      const page = state._pageText && state._pageText.page && state._pageText.page.value
      const imgs = page && page.content && page.content.images
      if (imgs && Object.prototype.hasOwnProperty.call(imgs, slotKey)) {
        const v = imgs[slotKey]
        const url = (v && typeof v === 'object') ? (v.url || '') : (typeof v === 'string' ? v : '')
        if (typeof url === 'string' && url.length) return resolveMediaUrl(url)
      }
    } catch (_) { /* ignore and fallback to registry */ }

    const mk = resolveMediaKey(slotKey, defaultMediaKey)
    return state._media ? state._media.getImage(mk, fallback) : (fallback || '')
  }

  const getResponsiveSlot = (slotKey, defaultMediaKey = '', fallback = '') => {
    // Prefer page-managed images with simple responsive suffix convention
    try {
      const page = state._pageText && state._pageText.page && state._pageText.page.value
      const imgs = page && page.content && page.content.images
      if (imgs && typeof imgs === 'object') {
        // Try viewport-specific variants then base key
        let vp = 'desktop'
        try {
          const w = typeof window !== 'undefined' ? window.innerWidth : 1200
          vp = (w <= 600) ? 'mobile' : (w <= 1024 ? 'tablet' : 'desktop')
        } catch (_) {}
        const tryKeys = vp === 'mobile'
          ? [ `${slotKey}_mobile`, `${slotKey}_sm`, `${slotKey}@mobile`, slotKey ]
          : vp === 'tablet'
          ? [ `${slotKey}_tablet`, `${slotKey}_md`, slotKey ]
          : [ slotKey ]
        for (const k of tryKeys) {
          if (!Object.prototype.hasOwnProperty.call(imgs, k)) continue
          const v = imgs[k]
          const url = (v && typeof v === 'object') ? (v.url || '') : (typeof v === 'string' ? v : '')
          if (typeof url === 'string' && url.length) return resolveMediaUrl(url)
        }
      }
    } catch (_) { /* ignore and fallback to registry */ }

    const mk = resolveMediaKey(slotKey, defaultMediaKey)
    return state._media ? state._media.getResponsiveImage(mk, fallback) : (fallback || '')
  }

  return { ensure, getSlot, getResponsiveSlot, _media: state._media }
}

export default usePageMedia
