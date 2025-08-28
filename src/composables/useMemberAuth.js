// 会員認証とアクセス制御のユーティリティ
import mockServer from '../mockServer'

// グローバルな状態管理（Vue 2互換のシンプルなストア）
const store = {
  state: {
    currentMember: null,
    memberToken: null
  },
  
  setMember(member, token) {
    this.state.currentMember = member
    this.state.memberToken = token
    
    if (member && token) {
      localStorage.setItem('memberToken', token)
      localStorage.setItem('memberUser', JSON.stringify(member))
    }
  },
  
  clearMember() {
    this.state.currentMember = null
    this.state.memberToken = null
    localStorage.removeItem('memberToken')
    localStorage.removeItem('memberUser')
  }
}

// 初期化時にlocalStorageから会員情報を復元
const initializeMember = () => {
  const storedToken = localStorage.getItem('memberToken')
  const storedUser = localStorage.getItem('memberUser')
  
  if (storedToken && storedUser) {
    try {
      store.state.memberToken = storedToken
      store.state.currentMember = JSON.parse(storedUser)
    } catch (error) {
      console.error('Failed to parse stored user data:', error)
      store.clearMember()
    }
  }
}

// 初期化実行
initializeMember()

export function useMemberAuth() {
  // 会員情報の取得
  const getMemberInfo = () => {
    return store.state.currentMember
  }

  // ログイン状態の確認
  const isLoggedIn = () => {
    return !!store.state.currentMember && !!store.state.memberToken
  }

  // 会員ランクの取得
  const getMembershipType = () => {
    return store.state.currentMember?.membershipType || 'guest'
  }

  // 会員ランクのラベル取得
  const getMembershipLabel = (type) => {
    const memberType = type || getMembershipType()
    const labels = {
      basic: 'ベーシック会員',
      standard: 'スタンダード会員', 
      premium: 'プレミアム会員',
      guest: 'ゲスト'
    }
    return labels[memberType] || 'ゲスト'
  }

  // ログイン処理
  const login = async (email, password) => {
    try {
      const result = await mockServer.memberLogin(email, password)
      if (result.success) {
        store.setMember(result.member, result.token)
        return { success: true }
      }
      return { success: false, error: result.error || 'ログインに失敗しました' }
    } catch (error) {
      console.error('Login error:', error)
      return { success: false, error: 'ログインに失敗しました' }
    }
  }

  // ログアウト処理
  const logout = () => {
    store.clearMember()
  }

  // コンテンツへのアクセス可否確認
  const canAccessContent = (requiredType) => {
    const currentType = getMembershipType()
    
    if (currentType === 'guest') return false
    if (!requiredType || requiredType === 'basic') return true
    
    const ranks = {
      basic: 1,
      standard: 2,
      premium: 3
    }
    
    const currentRank = ranks[currentType] || 0
    const requiredRank = ranks[requiredType] || 0
    
    return currentRank >= requiredRank
  }

  // アップグレード処理
  const upgradeMembership = async (newType) => {
    try {
      // 実際のAPIコールをここに実装
      // 今はモック実装
      const currentMember = store.state.currentMember
      if (currentMember) {
        const updatedMember = {
          ...currentMember,
          membershipType: newType
        }
        store.setMember(updatedMember, store.state.memberToken)
        return { success: true }
      }
      return { success: false, error: 'ログインが必要です' }
    } catch (error) {
      console.error('Upgrade error:', error)
      return { success: false, error: 'アップグレードに失敗しました' }
    }
  }

  // 公開API
  return {
    // State getters
    getMemberInfo,
    isLoggedIn,
    getMembershipType,
    getMembershipLabel,
    
    // Actions
    login,
    logout,
    canAccessContent,
    upgradeMembership,
    
    // Direct state access for reactivity in Vue 2 components
    get currentMember() {
      return store.state.currentMember
    },
    get memberToken() {
      return store.state.memberToken
    }
  }
}