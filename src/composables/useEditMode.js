import { reactive, toRefs } from 'vue'

// Global inline edit mode state (admin-only UI)
const state = reactive({
  enabled: false,
})

function _hasCmsEditFlag() {
  try {
    const hash = window.location.hash || ''
    const qs = hash.includes('?') ? hash.split('?')[1] : window.location.search.slice(1)
    const params = new URLSearchParams(qs)
    // cmsEdit=1 または cmsPreview=edit などで有効化
    if (params.has('cmsEdit')) return params.get('cmsEdit') !== '0'
    if (params.get('cmsPreview') === 'edit') return true
  } catch (_) {}
  return false
}

// Restore previous session state
try {
  const saved = sessionStorage.getItem('cms_edit_mode')
  if (saved === '1') state.enabled = true
  else if (_hasCmsEditFlag()) state.enabled = true
} catch (_) {
  // fallback: cmsEdit フラグがあれば有効
  if (_hasCmsEditFlag()) state.enabled = true
}

export function useEditMode() {
  const enable = () => {
    state.enabled = true
    try { sessionStorage.setItem('cms_edit_mode', '1') } catch (_) {}
  }
  const disable = () => {
    state.enabled = false
    try { sessionStorage.setItem('cms_edit_mode', '0') } catch (_) {}
  }
  const toggle = () => (state.enabled ? disable() : enable())

  return {
    ...toRefs(state),
    enable,
    disable,
    toggle,
  }
}

export default useEditMode
