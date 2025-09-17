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
    _v2images: null, // images resolved from CMS v2 snapshot (e.g., KV)
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
        // Also try CMS v2 public snapshot to capture KV image (hero)
        try {
          const api = await import('@/services/apiClient')
          const apiClient = api.default || api
          const res = await apiClient.get(`/api/public/pages-v2/${state.pageKey}`, { silent: true, params: { _t: Date.now() } })
          const sections = res?.data?.sections || res?.data?.data?.sections || res?.sections || []
          const map = {}
          if (Array.isArray(sections)) {
            for (const s of sections) {
              const type = (s?.component_type || '').toUpperCase()
              const props = s?.props || s?.props_json || {}
              if (type === 'KV') {
                const id = props?.image_id || props?.id
                const ext = props?.ext || 'jpg'
                if (id) {
                  // use medium preset for hero by default
                  const url = (await import('@/config/api.js')).getApiUrl(`/api/public/m/${encodeURIComponent(id)}/md.${encodeURIComponent(ext)}`)
                  map['hero'] = url
                }
              }
            }
          }
          state._v2images = Object.keys(map).length ? map : null
        } catch (_) { state._v2images = state._v2images || null }
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
        let url = (v && typeof v === 'object') ? (v.url || '') : (typeof v === 'string' ? v : '')
        // Add cache-buster for storage file when uploaded_at is present
        try {
          const meta = (v && typeof v === 'object') ? v : null
          const ver = meta && meta.uploaded_at ? (Date.parse(meta.uploaded_at) || Date.now()) : null
          if (ver && typeof url === 'string' && url.startsWith('/storage/')) {
            url += (url.includes('?') ? '&' : '?') + '_t=' + encodeURIComponent(String(ver))
          }
        } catch (_) {}
        if (typeof url === 'string' && url.length) return resolveMediaUrl(url)
      }
    } catch (_) { /* ignore and fallback to registry */ }

    // Next, CMS v2 snapshot-derived images (e.g., hero from KV)
    try {
      const v2 = state._v2images
      const url2 = v2 && v2[slotKey]
      if (typeof url2 === 'string' && url2.length) return url2
    } catch (_) {}

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
          let url = (v && typeof v === 'object') ? (v.url || '') : (typeof v === 'string' ? v : '')
          try {
            const meta = (v && typeof v === 'object') ? v : null
            const ver = meta && meta.uploaded_at ? (Date.parse(meta.uploaded_at) || Date.now()) : null
            if (ver && typeof url === 'string' && url.startsWith('/storage/')) {
              url += (url.includes('?') ? '&' : '?') + '_t=' + encodeURIComponent(String(ver))
            }
          } catch (_) {}
          if (typeof url === 'string' && url.length) return resolveMediaUrl(url)
        }
      }
    } catch (_) { /* ignore and fallback to registry */ }

    // Then try CMS v2 snapshot-derived images
    try {
      const v2 = state._v2images
      const url2 = v2 && v2[slotKey]
      if (typeof url2 === 'string' && url2.length) return url2
    } catch (_) {}

    const mk = resolveMediaKey(slotKey, defaultMediaKey)
    return state._media ? state._media.getResponsiveImage(mk, fallback) : (fallback || '')
  }

  return { ensure, getSlot, getResponsiveSlot, _media: state._media }
}

export default usePageMedia
