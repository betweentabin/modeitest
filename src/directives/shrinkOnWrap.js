// Vue 3 directive: shrink font size when text wraps to multiple lines
// Usage: v-shrink-on-wrap or v-shrink-on-wrap="{ lines: 2, className: 'shrink-2lines' }"

function getLineHeightPx(el) {
  const cs = getComputedStyle(el);
  const lh = cs.lineHeight;
  if (lh && lh.endsWith('px')) return parseFloat(lh);
  // Fallback when line-height is 'normal'
  const fs = parseFloat(cs.fontSize || '16');
  return fs * 1.2; // rough normal line-height
}

function getLineCount(el) {
  const lineHeight = getLineHeightPx(el);
  if (!lineHeight) return 1;
  // scrollHeight reflects actual content height even when clipped
  const lines = Math.round(el.scrollHeight / lineHeight);
  return Math.max(1, lines);
}

function applyClass(el, shouldShrink, className) {
  if (shouldShrink) {
    el.classList.add(className);
  } else {
    el.classList.remove(className);
  }
}

function setup(el, binding) {
  const opts = binding?.value || {};
  const threshold = Number(opts.lines) || 2; // shrink when lines >= threshold
  const className = opts.className || 'shrink-on-wrap';

  const check = () => {
    const lines = getLineCount(el);
    applyClass(el, lines >= threshold, className);
  };

  // Observe size and content changes
  const resizeObserver = new ResizeObserver(check);
  resizeObserver.observe(el);

  const mutationObserver = new MutationObserver(check);
  mutationObserver.observe(el, { childList: true, characterData: true, subtree: true });

  // Initial run (fonts may load later; run again after a tick)
  check();
  const fontLoadTimer = setTimeout(check, 200);

  // Store cleanup on element
  el.__shrinkOnWrapCleanup__ = () => {
    try { resizeObserver.disconnect(); } catch {}
    try { mutationObserver.disconnect(); } catch {}
    clearTimeout(fontLoadTimer);
  };
}

export default {
  mounted(el, binding) {
    setup(el, binding);
  },
  updated(el, binding) {
    // Re-run check on updates
    // setup again will rebind observers, so just run the class check
    const opts = binding?.value || {};
    const threshold = Number(opts.lines) || 2;
    const className = opts.className || 'shrink-on-wrap';
    const lines = getLineCount(el);
    applyClass(el, lines >= threshold, className);
  },
  unmounted(el) {
    if (el.__shrinkOnWrapCleanup__) {
      el.__shrinkOnWrapCleanup__();
      delete el.__shrinkOnWrapCleanup__;
    }
  }
};

