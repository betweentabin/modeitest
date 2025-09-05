import { reactive, toRefs } from 'vue'

// Global inline edit mode state (admin-only UI)
const state = reactive({
  enabled: false,
})

// Restore previous session state
try {
  const saved = sessionStorage.getItem('cms_edit_mode')
  if (saved === '1') state.enabled = true
} catch (_) {}

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

