import { reactive, toRefs } from 'vue'
import apiClient from '@/services/apiClient'

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
  try {
    // 1) Prefer admin endpoint if available (works for unpublished drafts too)
    const adminRes = await apiClient.get('/api/admin/pages/media', { silent: true })
    if (adminRes && (adminRes.data || adminRes.page)) {
      const d = adminRes.data || adminRes
      const page = d?.page || d
      const images = page?.content?.images || {}
      state.images = images || {}
      state.loaded = true
      return
    }
  } catch(e) {
    // ignore, fallback to public/local
  }

  try {
    // 2) Public endpoint (requires published page)
    const res = await apiClient.get('/api/public/pages/media', { silent: true })
    const page = res?.data?.page || res?.data?.data?.page
    const images = page?.content?.images || null
    if (images) {
      state.images = images
      state.loaded = true
      return
    }
    throw new Error('media page not found')
  } catch (e) {
    // 3) Fallback: try localStorage mock
    try {
      const str = localStorage.getItem('cms_mock_data')
      const json = str ? JSON.parse(str) : null
      const images = json?.media?.images || null
      if (images) {
        state.images = images
        state.loaded = true
        return
      }
      // Built-in defaults
      state.images = {
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
      }
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
    return typeof v === 'string' && v.length ? v : fallback
  }
  return {
    ...toRefs(state),
    ensure,
    getImage,
  }
}

export default useMedia
