<template>
  <div class="my-account-page">
    <Navigation />
    <div class="account-container">
      <div class="account-sidebar">
        <div class="sidebar-header">
          <div class="user-avatar">
            <span>{{ userInitial }}</span>
          </div>
          <h3 class="user-name">{{ memberInfo?.name || 'ゲスト' }}</h3>
          <p class="user-email">{{ memberInfo?.email || '' }}</p>
        </div>
        
        <nav class="sidebar-nav">
          <a 
            v-for="item in menuItems" 
            :key="item.id"
            :class="['nav-item', { active: activeTab === item.id }]"
            @click="activeTab = item.id"
          >
            <span class="nav-icon">{{ item.icon }}</span>
            <span>{{ item.label }}</span>
          </a>
        </nav>
        
        <div class="sidebar-footer">
          <button @click="handleLogout" class="logout-button">
            ログアウト
          </button>
        </div>
      </div>
      
      <div class="account-content">
        <!-- アカウント情報タブ -->
        <div v-if="activeTab === 'profile'" class="content-section">
          <h2>アカウント情報</h2>
          
          <!-- 表示モード -->
          <div v-if="!editMode" class="info-card">
            <div class="info-row">
              <label>会社名</label>
              <div class="info-value">{{ memberInfo?.company_name || '未登録' }}</div>
            </div>
            <div class="info-row">
              <label>代表者名</label>
              <div class="info-value">{{ memberInfo?.representative_name || '未登録' }}</div>
            </div>
            <div class="info-row">
              <label>メールアドレス</label>
              <div class="info-value">{{ memberInfo?.email }}</div>
            </div>
            <div class="info-row">
              <label>電話番号</label>
              <div class="info-value">{{ memberInfo?.phone || '未登録' }}</div>
            </div>
            <div class="info-row">
              <label>郵便番号</label>
              <div class="info-value">{{ memberInfo?.postal_code || '未登録' }}</div>
            </div>
            <div class="info-row">
              <label>住所</label>
              <div class="info-value">{{ memberInfo?.address || '未登録' }}</div>
            </div>
            <div class="info-row">
              <label>会員種別</label>
              <div class="info-value">
                <span :class="['membership-badge', `membership-${memberInfo?.membership_type}`]">
                  {{ getMembershipLabel(memberInfo?.membership_type) }}
                </span>
              </div>
            </div>
            <div class="info-row">
              <label>登録日</label>
              <div class="info-value">{{ formatDate(memberInfo?.created_at) }}</div>
            </div>
          </div>
          
          <!-- 編集モード -->
          <div v-else class="edit-form">
            <form @submit.prevent="saveProfile">
              <div class="form-row">
                <div class="form-group">
                  <label>会社名 *</label>
                  <input 
                    v-model="editForm.company_name" 
                    type="text" 
                    class="form-input"
                    required
                  >
                </div>
                <div class="form-group">
                  <label>代表者名 *</label>
                  <input 
                    v-model="editForm.representative_name" 
                    type="text" 
                    class="form-input"
                    required
                  >
                </div>
              </div>

              <div class="form-row">
                <div class="form-group">
                  <label>メールアドレス *</label>
                  <input 
                    v-model="editForm.email" 
                    type="email" 
                    class="form-input"
                    required
                  >
                </div>
                <div class="form-group">
                  <label>電話番号</label>
                  <input 
                    v-model="editForm.phone" 
                    type="text" 
                    class="form-input"
                  >
                </div>
              </div>

              <div class="form-row">
                <div class="form-group">
                  <label>郵便番号</label>
                  <input 
                    v-model="editForm.postal_code" 
                    type="text" 
                    class="form-input"
                    placeholder="例: 123-4567"
                  >
                </div>
              </div>

              <div class="form-group">
                <label>住所</label>
                <textarea 
                  v-model="editForm.address" 
                  class="form-textarea"
                  rows="3"
                ></textarea>
              </div>

              <div class="form-actions">
                <button type="button" @click="cancelEdit" class="cancel-button">
                  キャンセル
                </button>
                <button type="submit" class="save-button" :disabled="saving">
                  {{ saving ? '保存中...' : '保存する' }}
                </button>
              </div>
            </form>
          </div>
          
          <div v-if="!editMode" class="profile-actions">
            <button @click="startEdit" class="edit-button">プロフィールを編集</button>
            <button @click="showPasswordForm = true" class="password-button">パスワード変更</button>
          </div>
        </div>
        
        <!-- 会員プランタブ -->
        <div v-if="activeTab === 'membership'" class="content-section">
          <h2>会員プラン</h2>
          
          <div class="membership-card" :class="`membership-${memberInfo?.membershipType}`">
            <div class="membership-header">
              <h3>{{ getMembershipLabel(memberInfo?.membershipType) }}</h3>
              <span class="membership-badge">現在のプラン</span>
            </div>
            
            <div class="membership-features">
              <h4>利用可能な機能</h4>
              <ul>
                <li v-for="feature in getMembershipFeatures(memberInfo?.membershipType)" :key="feature">
                  ✓ {{ feature }}
                </li>
              </ul>
            </div>
            
            <div v-if="memberInfo?.membershipType !== 'premium'" class="upgrade-section">
              <p>より多くのコンテンツにアクセスしたい場合は、プランをアップグレードしてください。</p>
              <button @click="goToUpgrade" class="upgrade-button">
                プランをアップグレード
              </button>
            </div>
            
            <div v-if="memberInfo?.expiryDate" class="expiry-info">
              <span>有効期限: {{ formatDate(memberInfo.expiryDate) }}</span>
            </div>
          </div>
        </div>
        
        <!-- ダウンロード履歴タブ -->
        <div v-if="activeTab === 'downloads'" class="content-section">
          <h2>ダウンロード履歴</h2>
          
          <div class="downloads-list">
            <div class="download-item" v-for="item in downloadHistory" :key="item.id">
              <div class="download-info">
                <h4>{{ item.title }}</h4>
                <span class="download-date">{{ formatDate(item.downloadedAt) }}</span>
              </div>
              <button @click="redownload(item)" class="redownload-button">
                再ダウンロード
              </button>
            </div>
            
            <div v-if="downloadHistory.length === 0" class="empty-state">
              <p>ダウンロード履歴はありません</p>
            </div>
          </div>
        </div>
        
        <!-- お気に入りタブ -->
        <div v-if="activeTab === 'favorites'" class="content-section">
          <h2>お気に入り会員</h2>
          
          <div class="favorites-header">
            <p class="favorites-description">お気に入りに登録した会員の一覧です。</p>
            <button @click="$router.push('/member-directory')" class="directory-link-btn">
              会員名簿を見る
            </button>
          </div>
          
          <div v-if="loadingFavorites" class="loading">読み込み中...</div>
          <div v-else-if="favoritesError" class="error">{{ favoritesError }}</div>
          <div v-else>
            <div v-if="favoriteMembers.length === 0" class="empty-state">
              <div class="empty-icon">⭐</div>
              <h3>お気に入り会員はまだありません</h3>
              <p>会員名簿からお気に入りの会員を登録してみましょう。</p>
              <button @click="$router.push('/member-directory')" class="directory-btn">
                会員名簿を見る
              </button>
            </div>
            
            <div v-else class="favorites-list">
              <div 
                v-for="favorite in favoriteMembers" 
                :key="favorite.id"
                class="favorite-item"
              >
                <div class="favorite-info">
                  <h4>{{ favorite.company_name }}</h4>
                  <p>{{ favorite.representative_name }}</p>
                  <span class="membership-type">{{ getMembershipLabel(favorite.membership_type) }}</span>
                </div>
                <div class="favorite-actions">
                  <button @click="viewFavoriteDetail(favorite)" class="view-btn">詳細</button>
                  <button @click="removeFavorite(favorite)" class="remove-btn">削除</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- 設定タブ -->
        <div v-if="activeTab === 'settings'" class="content-section">
          <h2>設定</h2>
          
          <div class="settings-card">
            <h3>メール通知設定</h3>
            
            <div class="setting-item">
              <label class="setting-label">
                <input type="checkbox" v-model="settings.newsletter" />
                <span>新着刊行物のお知らせ</span>
              </label>
            </div>
            
            <div class="setting-item">
              <label class="setting-label">
                <input type="checkbox" v-model="settings.seminar" />
                <span>セミナー情報のお知らせ</span>
              </label>
            </div>
            
            <div class="setting-item">
              <label class="setting-label">
                <input type="checkbox" v-model="settings.promotion" />
                <span>キャンペーン情報</span>
              </label>
            </div>
            
            <button @click="saveSettings" class="save-button">
              設定を保存
            </button>
          </div>
          
          <div class="settings-card danger-zone">
            <h3>アカウントの削除</h3>
            <p>アカウントを削除すると、すべてのデータが失われます。この操作は取り消せません。</p>
            <button class="delete-button">アカウントを削除</button>
          </div>
        </div>
      </div>
    </div>
    <FooterComplete />
  </div>
</template>

<script>
import { ref, computed, onMounted } from 'vue'
// import { useRouter } from 'vue-router' // Vue 2では利用不可
import Navigation from '@/components/Navigation.vue'
import FooterComplete from '@/components/FooterComplete.vue'
import PublicationCard from '@/components/PublicationCard.vue'
import { useMemberAuth } from '@/composables/useMemberAuth'

export default {
  name: 'MyAccountPage',
  components: {
    Navigation,
    FooterComplete,
    PublicationCard
  },
  data() {
    return {
      activeTab: 'profile',
      memberInfo: null,
      downloadHistory: [],
      favoriteMembers: [],
      settings: {
        newsletter: true,
        emailNotifications: true,
        smsNotifications: false
      },
      
      // プロフィール編集
      editMode: false,
      editForm: {},
      saving: false,
      
      // パスワード変更
      showPasswordForm: false,
      passwordForm: {
        current_password: '',
        new_password: '',
        new_password_confirmation: ''
      },
      changingPassword: false,
      
      // お気に入り
      loadingFavorites: false,
      favoritesError: ''
    }
  },
  computed: {
    userInitial() {
      return this.memberInfo?.name?.charAt(0) || 'G'
    },
    menuItems() {
      return [
        { id: 'profile', label: 'アカウント情報', icon: '👤' },
        { id: 'membership', label: '会員プラン', icon: '★' },
        { id: 'downloads', label: 'ダウンロード履歴', icon: '↓' },
        { id: 'favorites', label: 'お気に入り', icon: '♥' },
        { id: 'settings', label: '設定', icon: '⚙' }
      ]
    }
  },
  async mounted() {
    await this.initializeAuth()
    if (this.memberInfo) {
      this.loadFavoriteMembers()
      this.loadDownloadHistory()
    }
  },
  methods: {
    async initializeAuth() {
      const { getMemberInfo, isLoggedIn } = useMemberAuth()
      
      if (!isLoggedIn()) {
        this.$router.push('/member/login?redirect=/my-account')
        return
      }

      try {
        const response = await this.$apiClient.request('GET', '/member/my-profile')
        if (response.success) {
          this.memberInfo = response.data
        } else {
          console.error('プロフィール取得に失敗:', response.message)
        }
      } catch (error) {
        console.error('認証情報の取得に失敗:', error)
        this.$router.push('/member/login')
      }
    },

    // プロフィール編集
    startEdit() {
      this.editForm = {
        company_name: this.memberInfo.company_name || '',
        representative_name: this.memberInfo.representative_name || '',
        email: this.memberInfo.email || '',
        phone: this.memberInfo.phone || '',
        postal_code: this.memberInfo.postal_code || '',
        address: this.memberInfo.address || ''
      }
      this.editMode = true
    },

    cancelEdit() {
      this.editMode = false
      this.editForm = {}
    },

    async saveProfile() {
      this.saving = true
      
      try {
        const response = await this.$apiClient.request('PUT', '/member/my-profile', this.editForm)
        
        if (response.success) {
          this.memberInfo = response.data
          this.editMode = false
          alert('プロフィールを更新しました')
        } else {
          alert(response.message || 'プロフィールの更新に失敗しました')
        }
      } catch (error) {
        console.error('プロフィール更新に失敗:', error)
        alert('サーバーエラーが発生しました')
      } finally {
        this.saving = false
      }
    },

    // お気に入り会員
    async loadFavoriteMembers() {
      this.loadingFavorites = true
      this.favoritesError = ''

      try {
        const response = await this.$apiClient.request('GET', '/member/favorites')
        
        if (response.success) {
          this.favoriteMembers = response.data
        } else {
          this.favoritesError = response.message || 'お気に入り一覧の取得に失敗しました'
        }
      } catch (error) {
        this.favoritesError = 'サーバーエラーが発生しました'
        console.error('お気に入り取得に失敗:', error)
      } finally {
        this.loadingFavorites = false
      }
    },

    async removeFavorite(favorite) {
      if (!confirm(`${favorite.company_name} をお気に入りから削除しますか？`)) {
        return
      }

      try {
        const response = await this.$apiClient.request('DELETE', `/member/favorites/${favorite.id}`)
        
        if (response.success) {
          this.favoriteMembers = this.favoriteMembers.filter(f => f.id !== favorite.id)
          alert('お気に入りから削除しました')
        } else {
          alert(response.message || 'お気に入りの削除に失敗しました')
        }
      } catch (error) {
        console.error('お気に入り削除に失敗:', error)
        alert('サーバーエラーが発生しました')
      }
    },

    viewFavoriteDetail(favorite) {
      // 会員名簿ページに遷移（詳細表示）
      this.$router.push(`/member-directory?view=${favorite.id}`)
    },

    // ダウンロード履歴（サンプル）
    loadDownloadHistory() {
      this.downloadHistory = [
        {
          id: 1,
          title: 'ちくぎん地域経済レポート Vol.15',
          date: '2024-03-15',
          type: 'PDF',
          size: '2.3MB'
        },
        {
          id: 2,
          title: 'Hot Information 2024年2月号',
          date: '2024-02-28',
          type: 'PDF',
          size: '1.8MB'
        }
      ]
    },

    handleLogout() {
      if (confirm('ログアウトしますか？')) {
        const { logout } = useMemberAuth()
        logout()
        this.$router.push('/')
      }
    },
    
    goToUpgrade() {
      this.$router.push('/upgrade')
    },
    
    redownload(item) {
      // 再ダウンロードの実装
      console.log('再ダウンロード:', item)
    },
    
    getMembershipLabel() {
      const { getMembershipLabel } = useMemberAuth()
      return getMembershipLabel()
    },
    
    getMembershipFeatures(type) {
      const features = {
        basic: [
          'ベーシック向け刊行物の閲覧',
          'セミナー情報の確認',
          'メール配信サービス'
        ],
        premium: [
          'すべての刊行物への無制限アクセス',
          'セミナーの優先参加',
          '限定レポートの配信',
          '経済統計データの詳細分析',
          '個別相談サービス'
        ]
      }
      return features[type] || []
    },
    
    formatDate(dateString) {
      const date = new Date(dateString)
      return date.toLocaleDateString('ja-JP')
    },
    
    saveSettings() {
      // 設定保存の実装
      console.log('設定を保存:', this.settings)
    }
  }
}
</script>

<style scoped>
.my-account-page {
  min-height: 100vh;
  background: #f5f5f5;
}

.account-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 40px 20px;
  display: grid;
  grid-template-columns: 280px 1fr;
  gap: 30px;
}

/* サイドバー */
.account-sidebar {
  background: white;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
  padding: 24px;
  height: fit-content;
  position: sticky;
  top: 20px;
}

.sidebar-header {
  text-align: center;
  padding-bottom: 24px;
  border-bottom: 1px solid #e0e0e0;
  margin-bottom: 24px;
}

.user-avatar {
  width: 80px;
  height: 80px;
  border-radius: 50%;
  background: linear-gradient(135deg, var(--mandy) 0%, var(--hot-pink) 100%);
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 16px;
  font-size: 32px;
  color: white;
  font-weight: 600;
}

.user-name {
  font-size: 18px;
  font-weight: 600;
  color: #1A1A1A;
  margin: 0 0 4px 0;
}

.user-email {
  font-size: 14px;
  color: #666;
  margin: 0;
}

.sidebar-nav {
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.nav-item {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 12px 16px;
  border-radius: 8px;
  color: #666;
  text-decoration: none;
  cursor: pointer;
  transition: all 0.3s ease;
}

.nav-item:hover {
  background: #f5f5f5;
  color: #1A1A1A;
}

.nav-item.active {
  background: rgba(218, 87, 97, 0.1);
  color: var(--mandy);
  font-weight: 600;
}

.nav-icon {
  font-size: 20px;
}

.sidebar-footer {
  margin-top: 24px;
  padding-top: 24px;
  border-top: 1px solid #e0e0e0;
}

.logout-button {
  width: 100%;
  padding: 12px;
  background: white;
  color: #666;
  border: 1px solid #e0e0e0;
  border-radius: 8px;
  font-size: 14px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.3s ease;
}

.logout-button:hover {
  background: #f5f5f5;
  color: var(--mandy);
  border-color: var(--mandy);
}

/* コンテンツエリア */
.account-content {
  background: white;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
  padding: 32px;
}

.content-section h2 {
  font-size: 24px;
  color: #1A1A1A;
  margin: 0 0 24px 0;
  padding-bottom: 12px;
  border-bottom: 2px solid #f0f0f0;
}

/* アカウント情報 */
.info-card {
  background: #f9f9f9;
  border-radius: 8px;
  padding: 24px;
  margin-bottom: 24px;
}

.info-row {
  display: flex;
  align-items: center;
  padding: 12px 0;
  border-bottom: 1px solid #e0e0e0;
}

.info-row:last-child {
  border-bottom: none;
}

.info-row label {
  flex: 0 0 150px;
  font-size: 14px;
  color: #666;
  font-weight: 500;
}

.info-value {
  flex: 1;
  font-size: 15px;
  color: #1A1A1A;
}

.edit-button {
  padding: 12px 32px;
  background: var(--mandy);
  color: white;
  border: none;
  border-radius: 8px;
  font-size: 15px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
}

.edit-button:hover {
  background: var(--hot-pink);
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(218, 87, 97, 0.3);
}

/* 会員プラン */
.membership-card {
  border-radius: 12px;
  padding: 24px;
  background: linear-gradient(135deg, #f5f5f5 0%, #ebebeb 100%);
}

.membership-card.membership-basic {
  background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
}

.membership-card.membership-standard {
  background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);
}

.membership-card.membership-premium {
  background: linear-gradient(135deg, #fce4ec 0%, #f8bbd0 100%);
}

.membership-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 24px;
}

.membership-header h3 {
  font-size: 20px;
  color: #1A1A1A;
  margin: 0;
}

.membership-badge {
  padding: 6px 16px;
  background: white;
  border-radius: 20px;
  font-size: 12px;
  font-weight: 600;
  color: #666;
}

.membership-features {
  margin-bottom: 24px;
}

.membership-features h4 {
  font-size: 16px;
  color: #1A1A1A;
  margin: 0 0 12px 0;
}

.membership-features ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

.membership-features li {
  padding: 8px 0;
  color: #666;
  font-size: 14px;
}

.upgrade-section {
  background: white;
  border-radius: 8px;
  padding: 20px;
  margin-bottom: 16px;
}

.upgrade-section p {
  font-size: 14px;
  color: #666;
  margin: 0 0 16px 0;
}

.upgrade-button {
  padding: 12px 24px;
  background: linear-gradient(135deg, var(--mandy) 0%, var(--hot-pink) 100%);
  color: white;
  border: none;
  border-radius: 8px;
  font-size: 14px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
}

.upgrade-button:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(218, 87, 97, 0.3);
}

.expiry-info {
  text-align: center;
  padding-top: 16px;
  border-top: 1px solid rgba(0, 0, 0, 0.1);
  color: #666;
  font-size: 14px;
}

/* ダウンロード履歴 */
.downloads-list {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.download-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 16px;
  background: #f9f9f9;
  border-radius: 8px;
  transition: background 0.3s ease;
}

.download-item:hover {
  background: #f0f0f0;
}

.download-info h4 {
  font-size: 15px;
  color: #1A1A1A;
  margin: 0 0 4px 0;
}

.download-date {
  font-size: 13px;
  color: #666;
}

.redownload-button {
  padding: 8px 16px;
  background: white;
  color: var(--mandy);
  border: 1px solid var(--mandy);
  border-radius: 6px;
  font-size: 13px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.3s ease;
}

.redownload-button:hover {
  background: var(--mandy);
  color: white;
}

/* お気に入り */
.favorites-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 20px;
}

/* 設定 */
.settings-card {
  background: #f9f9f9;
  border-radius: 8px;
  padding: 24px;
  margin-bottom: 24px;
}

.settings-card h3 {
  font-size: 18px;
  color: #1A1A1A;
  margin: 0 0 20px 0;
}

.setting-item {
  margin-bottom: 16px;
}

.setting-label {
  display: flex;
  align-items: center;
  gap: 12px;
  cursor: pointer;
  font-size: 15px;
  color: #1A1A1A;
}

.setting-label input[type="checkbox"] {
  width: 20px;
  height: 20px;
  cursor: pointer;
}

.save-button {
  padding: 12px 32px;
  background: var(--mandy);
  color: white;
  border: none;
  border-radius: 8px;
  font-size: 15px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
}

.save-button:hover {
  background: var(--hot-pink);
}

.danger-zone {
  background: #fff5f5;
  border: 1px solid #ffcccc;
}

.danger-zone p {
  font-size: 14px;
  color: #666;
  margin: 0 0 16px 0;
}

.delete-button {
  padding: 12px 24px;
  background: #dc3545;
  color: white;
  border: none;
  border-radius: 8px;
  font-size: 14px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
}

.delete-button:hover {
  background: #c82333;
}

/* 空状態 */
.empty-state {
  text-align: center;
  padding: 60px 20px;
  color: #999;
}

.empty-state p {
  font-size: 16px;
  margin: 0;
}

/* レスポンシブ */
@media (max-width: 768px) {
  .account-container {
    grid-template-columns: 1fr;
  }
  
  .account-sidebar {
    position: static;
  }
  
  .favorites-grid {
    grid-template-columns: 1fr;
  }
}
</style>