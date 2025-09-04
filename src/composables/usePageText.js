// Small utility to load page content and safely read structured texts/links/images
// Provides fallback-first getters to avoid layout/XSS risks.
import { reactive, toRefs } from 'vue'
import apiClient from '@/services/apiClient'

// Simple sanitizer: allowlisted tags and attributes only
function sanitizeHtml(input = '') {
  if (typeof input !== 'string') return ''

  // Drop script/style tags entirely
  let html = input.replace(/<\/(?:script|style)>/gi, '')
  html = html.replace(/<(?:script|style)[^>]*>[\s\S]*?<\/(?:script|style)>/gi, '')

  // Remove on* event handlers
  html = html.replace(/\son[a-z]+\s*=\s*"[^"]*"/gi, '')
  html = html.replace(/\son[a-z]+\s*=\s*'[^']*'/gi, '')
  html = html.replace(/\son[a-z]+\s*=\s*[^\s>]+/gi, '')

  // Allowlist tags and prune others by escaping angle brackets for non-allowed
  const allowedTags = ['b', 'strong', 'i', 'em', 'u', 'br', 'p', 'ul', 'ol', 'li', 'a']

  // Replace disallowed tags with their text content (strip tags)
  html = html.replace(/<\/?([a-z0-9-]+)([^>]*)>/gi, (match, tag, attrs) => {
    const t = String(tag || '').toLowerCase()
    if (!allowedTags.includes(t)) {
      // strip the whole tag
      return ''
    }

    if (t === 'a') {
      // keep only safe href, target, rel
      let href = ''
      const hrefMatch = attrs.match(/href\s*=\s*("([^"]*)"|'([^']*)'|([^\s>]+))/i)
      if (hrefMatch) {
        href = hrefMatch[2] || hrefMatch[3] || hrefMatch[4] || ''
      }
      // block javascript: and data: except images via / path
      const safe = href.startsWith('http://') || href.startsWith('https://') || href.startsWith('/')
      const safeHref = safe ? ` href="${href.replace(/"/g, '&quot;')}"` : ''
      return `<a${safeHref} target="_blank" rel="noopener noreferrer">`
    }

    // for others, drop attributes
    return `<${t}>`
  })

  // Close orphaned open tags for <a> in a naive way
  // This is intentionally simple and defensive; complex HTML should use CmsBlock
  return html
}

const state = reactive({
  pages: {}, // key -> { loading, error, page }
})

export function usePageText(pageKey) {
  if (!state.pages[pageKey]) {
    state.pages[pageKey] = { loading: false, error: null, page: null }
  }

  const load = async () => {
    const entry = state.pages[pageKey]
    if (entry.loading) return
    entry.loading = true
    entry.error = null
    try {
      const res = await apiClient.getPageContent(pageKey)
      const page = res?.data?.page || res?.data?.data?.page || null
      entry.page = page
    } catch (e) {
      entry.error = e?.message || 'Failed to load page content'
    } finally {
      state.pages[pageKey].loading = false
    }
  }

  const getText = (key, fallback = '') => {
    const page = state.pages[pageKey]?.page
    const texts = page?.content?.texts
    const val = texts && Object.prototype.hasOwnProperty.call(texts, key) ? texts[key] : undefined
    return typeof val === 'string' && val.length > 0 ? val : fallback
  }

  const getHtml = (key, fallback = '') => {
    const page = state.pages[pageKey]?.page
    const htmls = page?.content?.htmls || page?.content?.rich || null
    const raw = htmls && Object.prototype.hasOwnProperty.call(htmls, key) ? htmls[key] : undefined
    const chosen = typeof raw === 'string' && raw.length > 0 ? raw : fallback
    return sanitizeHtml(chosen)
  }

  const getLink = (key, fallback = '') => {
    const page = state.pages[pageKey]?.page
    const links = page?.content?.links
    const val = links && Object.prototype.hasOwnProperty.call(links, key) ? links[key] : undefined
    if (typeof val !== 'string') return fallback
    // Allow only app-relative or http(s)
    return val.startsWith('/') || val.startsWith('http://') || val.startsWith('https://') ? val : fallback
  }

  return {
    ...toRefs(state.pages[pageKey]),
    load,
    getText,
    getHtml,
    getLink,
  }
}

export default usePageText

