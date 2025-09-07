// Utilities to resolve media URLs for <img src>
// Keeps design stable by not forcing API base for frontend assets

export function resolveMediaUrl(input) {
  if (!input) return ''
  const url = String(input)
  const lower = url.toLowerCase()

  // Absolute URLs and protocol-relative
  if (lower.startsWith('http://') || lower.startsWith('https://') || url.startsWith('//')) {
    return url
  }

  // Storage URLs
  if (url.startsWith('/storage/')) return url
  if (url.startsWith('storage/')) return `/${url}`

  // Frontend-bundled assets
  if (url.startsWith('/img/') || url.startsWith('/images/') || url.startsWith('/assets/') || url.startsWith('/favicon')) {
    return url
  }

  // Other root-relative paths: leave as-is (resolved by current origin)
  if (url.startsWith('/')) return url

  // Fallback: assume public disk relative path (strip leading 'public/')
  const path = url.replace(/^public\//, '')
  return `/storage/${path}`
}

export default { resolveMediaUrl }

