// 会員認証とアクセス制御のコンポジション関数
import { ref, computed } from 'vue'
import mockServer from '@/mockServer'

// グローバルな状態管理
const currentMember = ref(null)
const memberToken = ref(null)

// 初期化時にlocalStorageから会員情報を復元
const initializeMember = () => {
  const storedToken = localStorage.getItem('memberToken')
  const storedUser = localStorage.getItem('memberUser')
  
  if (storedToken && storedUser) {
    try {
      memberToken.value = storedToken
      currentMember.value = JSON.parse(storedUser)
    } catch (error) {
      console.error('Failed to parse stored user data:', error)
      clearMemberData()
    }
  }
}

// 会員データをクリア
const clearMemberData = () => {
  currentMember.value = null
  memberToken.value = null
  localStorage.removeItem('memberToken')
  localStorage.removeItem('memberUser')
}

// 初期化実行
initializeMember()

export function useMemberAuth() {
  // 会員情報の取得（互換性のため残す）
  const getMemberInfo = () => {
    return currentMember.value
  }

  // ログイン状態の確認（互換性のため残す）
  const isLoggedIn = () => {
    return !!currentMember.value && !!memberToken.value
  }

  // 会員ランクの取得（互換性のため残す）
  const getMembershipType = () => {
    return currentMember.value?.membershipType || 'guest'
  }

  // コンテンツへのアクセス権限チェック（拡張版）
  const canAccessContent = (requiredLevel, userMembershipType = null) => {
    const userLevel = userMembershipType || getMembershipType()
    
    const levels = {
      'free': 0,
      'guest': 0,
      'basic': 1,
      'standard': 2,
      'premium': 3
    }
    
    const userAccessLevel = levels[userLevel] || 0
    const contentLevel = levels[requiredLevel] || 0
    
    return userAccessLevel >= contentLevel
  }

  // 会員ランクの表示名
  const getMembershipLabel = (type) => {
    const labels = {
      'free': '無料',
      'guest': 'ゲスト',
      'basic': 'ベーシック会員',
      'standard': 'スタンダード会員',
      'premium': 'プレミアム会員'
    }
    return labels[type] || 'ゲスト'
  }

  // 必要な会員ランクのメッセージ（拡張版）
  const getAccessMessage = (requiredLevel) => {
    const currentLevel = getMembershipType()
    
    if (currentLevel === 'guest' || !isLoggedIn()) {
      return `この刊行物を閲覧するには会員登録が必要です`
    }
    
    const requiredLabel = getMembershipLabel(requiredLevel)
    return `この刊行物は${requiredLabel}以上の方限定です`
  }
  
  // アクセス制限メッセージの取得（新規追加）
  const getRestrictionMessage = (contentLevel, userMembershipType = null) => {
    const userLevel = userMembershipType || getMembershipType()
    
    if (!userLevel || userLevel === 'guest') {
      return '会員登録してアクセス'
    }
    
    const messages = {
      'basic': 'ベーシック会員以上で閲覧可能',
      'standard': 'スタンダード会員以上で閲覧可能',
      'premium': 'プレミアム会員限定コンテンツ'
    }
    
    return messages[contentLevel] || 'アップグレードが必要です'
  }

  // ログアウト
  const logout = () => {
    clearMemberData()
  }
  
  // ログイン処理（新規追加）
  const login = async (email, password) => {
    try {
      const response = await mockServer.memberLogin(email, password)
      
      if (response.success) {
        currentMember.value = response.user
        memberToken.value = response.token
        
        localStorage.setItem('memberToken', response.token)
        localStorage.setItem('memberUser', JSON.stringify(response.user))
        
        return { success: true, user: response.user }
      }
    } catch (error) {
      console.error('Login failed:', error)
      return { success: false, error: error.message }
    }
  }
  
  // 会員情報の更新（新規追加）
  const updateMemberInfo = (newInfo) => {
    if (currentMember.value) {
      currentMember.value = { ...currentMember.value, ...newInfo }
      localStorage.setItem('memberUser', JSON.stringify(currentMember.value))
    }
  }
  
  // 会員ランクのアップグレード（新規追加）
  const upgradeMembership = async (newMembershipType) => {
    if (!currentMember.value) {
      return { success: false, error: '未ログインです' }
    }
    
    try {
      const updatedMember = await mockServer.updateMember(currentMember.value.id, {
        membershipType: newMembershipType
      })
      
      currentMember.value = { ...currentMember.value, membershipType: newMembershipType }
      localStorage.setItem('memberUser', JSON.stringify(currentMember.value))
      
      return { success: true, member: updatedMember }
    } catch (error) {
      console.error('Upgrade failed:', error)
      return { success: false, error: error.message }
    }
  }

  return {
    // 互換性のため既存の関数を維持
    getMemberInfo,
    isLoggedIn,
    getMembershipType,
    canAccessContent,
    getMembershipLabel,
    getAccessMessage,
    logout,
    
    // 新規追加機能
    currentMember: computed(() => currentMember.value),
    getRestrictionMessage,
    login,
    updateMemberInfo,
    upgradeMembership
  }
}