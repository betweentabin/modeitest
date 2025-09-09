import { reactive, toRefs } from 'vue'
import apiClient from '@/services/apiClient'
import { resolveMediaUrl } from '@/utils/url.js'

const state = reactive({
  loaded: false,
  loading: false,
  error: null,
  images: {}, // key -> url
})

async function loadMedia() {
  if (state.loaded || state.loading) return
  state.loading = true
  state.error = null

  // Helper: normalize/resolve URLs in the map
  const normalize = (images) => {
    const out = {}
    if (images && typeof images === 'object') {
      for (const [k, v] of Object.entries(images)) {
        out[k] = resolveMediaUrl(typeof v === 'string' ? v : (v?.url || ''))
      }
    }
    return out
  }

  try {
    // 1) If admin session exists, fetch the media page through admin API
    // Avoid hitting admin endpoint when not authenticated to prevent spurious 404 logs
    if (apiClient.isAdminAuthenticated()) {
      const adminPage = await apiClient.get('/api/admin/pages/media', { silent: true })
      const page = adminPage?.data?.page || adminPage?.data?.data?.page || adminPage?.page
      const images = page?.content?.images || null
      if (images) {
        state.images = normalize(images)
        state.loaded = true
        return
      }
    }
  } catch (e) {
    // ignore and try public endpoint
  }

  try {
    // 2) Public endpoint (published media page)
    const res = await apiClient.get('/api/public/pages/media', { silent: true })
    const page = res?.data?.page || res?.data?.data?.page
    const images = page?.content?.images || null
    if (images) {
      state.images = normalize(images)
      state.loaded = true
      return
    }
    throw new Error('media page not found')
  } catch (e) {
    // 3) Fallback: local mock or built-in defaults
    try {
      const str = localStorage.getItem('cms_mock_data')
      const json = str ? JSON.parse(str) : null
      const images = json?.media?.images || null
      if (images) {
        state.images = normalize(images)
        state.loaded = true
        return
      }
      // Built-in defaults
      state.images = normalize({
        hero_economic_indicators: '/img/hero-image.png',
        hero_economic_statistics: '/img/hero-image.png',
        hero_publications: '/img/hero-image.png',
        hero_company_profile: '/img/hero-image.png',
        hero_privacy: '/img/hero-image.png',
        hero_terms: '/img/hero-image.png',
        hero_transaction_law: '/img/hero-image.png',
        hero_contact: '/img/hero-image.png',
        hero_glossary: '/img/hero-image.png',
        hero_membership: '/img/hero-image.png',
        hero_seminars_current: '/img/hero-image.png',
        hero_financial_reports: '/img/hero-image.png',
        hero_sitemap: '/img/hero-image.png',
        hero_consulting: '/img/hero-image.png',
        // Other common section backgrounds
        contact_section_bg: '/img/-----1-1.png',
      })
      state.loaded = true
    } catch (err) {
      state.error = err?.message || 'Failed to load media registry'
    }
  } finally {
    state.loading = false
  }
}

export function useMedia() {
  const ensure = () => loadMedia()
  const getImage = (key, fallback = '') => {
    const v = state.images?.[key]
    return typeof v === 'string' && v.length ? v : resolveMediaUrl(fallback)
  }
  return {
    ...toRefs(state),
    ensure,
    getImage,
  }
}

export default useMedia
