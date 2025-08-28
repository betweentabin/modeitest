// API設定
const API_CONFIG = {
  development: {
    baseURL: 'http://localhost:8001',
  },
  production: {
    baseURL: 'https://heroic-celebration-production.up.railway.app',
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
  const baseUrl = getApiBaseUrl()
  // エンドポイントが/で始まっていない場合は追加
  const normalizedEndpoint = endpoint.startsWith('/') ? endpoint : `/${endpoint}`
  return `${baseUrl}${normalizedEndpoint}`
}

export default {
  getApiConfig,
  getApiBaseUrl,
  getApiUrl
}
