// API設定
// 優先順位: VUE_APP_API_URL (env) > NODE_ENVごとのデフォルト
const ENV_BASE = process.env.VUE_APP_API_URL && String(process.env.VUE_APP_API_URL).trim()

const API_CONFIG = {
  development: {
    // ローカルLaravelのデフォルトポート（未指定時）
    baseURL: ENV_BASE || 'http://127.0.0.1:8000',
  },
  production: {
    // 環境変数未設定時のフォールバックは現行本番
    baseURL: ENV_BASE || 'https://heroic-celebration-production.up.railway.app',
  }
}

// 現在の環境を判定
const getCurrentEnvironment = () => {
  if (process.env.NODE_ENV === 'production') {
    return 'production'
  }
  return 'development'
}

// 現在の環境に基づいてAPI設定を取得
export const getApiConfig = () => {
  const env = getCurrentEnvironment()
  return API_CONFIG[env]
}

// APIベースURLを取得
export const getApiBaseUrl = () => {
  return getApiConfig().baseURL
}

// 完全なAPIエンドポイントURLを生成
export const getApiUrl = (endpoint) => {
  if (!endpoint) return getApiBaseUrl()
  const lower = String(endpoint).toLowerCase()
  // 絶対URLはそのまま返す（http/https/プロトコル相対）
  if (lower.startsWith('http://') || lower.startsWith('https://') || lower.startsWith('//')) {
    return endpoint
  }
  const baseUrl = getApiBaseUrl()
  const normalizedEndpoint = endpoint.startsWith('/') ? endpoint : `/${endpoint}`
  return `${baseUrl}${normalizedEndpoint}`
}

export default {
  getApiConfig,
  getApiBaseUrl,
  getApiUrl
}
