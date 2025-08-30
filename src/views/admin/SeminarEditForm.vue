<template>
  <AdminLayout>
    <div class="dashboard">
      <!-- ページヘッダー -->
      <div class="page-header">
        <div class="header-left">
          <button @click="goBack" class="back-btn">
            ← セミナー管理に戻る
          </button>
          <h1 class="page-title">{{ isNew ? '新規セミナー作成' : 'セミナー編集' }}</h1>
        </div>
        <div class="header-actions">
          <button @click="handleLogout" class="logout-btn">ログアウト</button>
        </div>
      </div>

      <!-- フォームコンテナ -->
      <div class="form-container">
        <div v-if="loading" class="loading">読み込み中...</div>
        <div v-else-if="error && !isNew" class="error-container">
          <div class="error-message">{{ error }}</div>
        </div>
        <div v-else class="form-content">
          <form @submit.prevent="handleSubmit" class="edit-form">
            <!-- セミナー基本情報 -->
            <div class="form-section">
              <h3 class="section-title">基本情報</h3>
              
              <div class="form-group">
                <label for="title" class="form-label">
                  セミナータイトル <span class="required">*</span>
                </label>
                <input
                  id="title"
                  v-model="formData.title"
                  type="text"
                  required
                  class="form-input"
                  placeholder="セミナーのタイトルを入力してください"
                />
              </div>

              <div class="form-group">
                <label for="description" class="form-label">
                  詳細説明 <span class="required">*</span>
                </label>
                <textarea
                  id="description"
                  v-model="formData.description"
                  rows="4"
                  required
                  class="form-input"
                  placeholder="セミナーの詳細説明を入力してください"
                />
              </div>
            </div>

            <!-- スケジュール情報 -->
            <div class="form-section">
              <h3 class="section-title">スケジュール</h3>
              
              <div class="form-row">
                <div class="form-group">
                  <label for="date" class="form-label">
                    開催日 <span class="required">*</span>
                  </label>
                  <input
                    id="date"
                    v-model="formData.date"
                    type="date"
                    required
                    class="form-input"
                  />
                </div>
                
                <div class="form-group">
                  <label for="start_time" class="form-label">
                    開始時間 <span class="required">*</span>
                  </label>
                  <input
                    id="start_time"
                    v-model="formData.start_time"
                    type="time"
                    required
                    class="form-input"
                  />
                </div>
                
                <div class="form-group">
                  <label for="end_time" class="form-label">
                    終了時間 <span class="required">*</span>
                  </label>
                  <input
                    id="end_time"
                    v-model="formData.end_time"
                    type="time"
                    required
                    class="form-input"
                  />
                </div>
              </div>
            </div>

            <!-- 開催情報 -->
            <div class="form-section">
              <h3 class="section-title">開催情報</h3>
              
              <div class="form-group">
                <label for="location" class="form-label">
                  開催場所 <span class="required">*</span>
                </label>
                <input
                  id="location"
                  v-model="formData.location"
                  type="text"
                  required
                  class="form-input"
                  placeholder="例: ちくぎん地域経済研究所 会議室A"
                />
              </div>

              <div class="form-row">
                <div class="form-group">
                  <label for="capacity" class="form-label">
                    定員
                  </label>
                  <input
                    id="capacity"
                    v-model="formData.capacity"
                    type="number"
                    min="1"
                    class="form-input"
                    placeholder="定員数を入力"
                  />
                </div>
                
                <div class="form-group">
                  <label for="fee" class="form-label">
                    参加費
                  </label>
                  <input
                    id="fee"
                    v-model="formData.fee"
                    type="number"
                    min="0"
                    class="form-input"
                    placeholder="参加費（円）"
                  />
                </div>
              </div>
            </div>

            <!-- ステータス -->
            <div class="form-section">
              <div class="form-group">
                <label for="status" class="form-label">
                  ステータス <span class="required">*</span>
                </label>
                <select
                  id="status"
                  v-model="formData.status"
                  required
                  class="form-input"
                >
                  <option value="">ステータスを選択</option>
                  <option value="scheduled">予定</option>
                  <option value="ongoing">申し込み受付中</option>
                  <option value="completed">終了</option>
                  <option value="cancelled">中止</option>
                </select>
              </div>
            </div>

            <!-- エラー・成功メッセージ -->
            <div v-if="submitError" class="message error-message">
              {{ submitError }}
            </div>

            <div v-if="successMessage" class="message success-message">
              {{ successMessage }}
            </div>

            <!-- アクションボタン -->
            <div class="form-actions">
              <button
                type="button"
                @click="goBack"
                class="btn btn-secondary"
              >
                キャンセル
              </button>
              <button
                type="submit"
                :disabled="loading || submitLoading"
                class="btn btn-primary"
              >
                {{ submitLoading ? '保存中...' : '保存' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script>
import AdminLayout from './AdminLayout.vue'
import mockServer from '@/mockServer'

export default {
  name: 'SeminarEditForm',
  components: {
    AdminLayout
  },
  data() {
    return {
      formData: {
        title: '',
        description: '',
        date: '',
        start_time: '',
        end_time: '',
        location: '',
        capacity: null,
        fee: null,
        status: ''
      },
      loading: false,
      submitLoading: false,
      error: '',
      submitError: '',
      successMessage: ''
    }
  },
  computed: {
    isNew() {
      return this.$route.name === 'seminarNew' || !this.$route.params.id
    },
    seminarId() {
      return this.$route.params.id
    }
  },
  async mounted() {
    const token = localStorage.getItem('adminToken')
    
    if (!token) {
      this.$router.push('/admin/login')
      return
    }

    // モックサーバーを使用するため、認証ヘッダーは不要
    
    // 新規作成の場合はデータ取得をスキップ
    if (!this.isNew) {
      await this.fetchSeminarData()
    }
  },
  methods: {
    async fetchSeminarData() {
      this.loading = true
      this.error = ''

      try {
        const data = await mockServer.getSeminar(this.seminarId)
        this.formData = data
      } catch (err) {
        this.error = 'セミナーデータの取得に失敗しました'
        console.error(err)
      } finally {
        this.loading = false
      }
    },
    async handleSubmit() {
      this.submitLoading = true
      this.submitError = ''
      this.successMessage = ''

      try {
        if (this.isNew) {
          await mockServer.createSeminar(this.formData)
          this.successMessage = 'セミナーを作成しました'
          setTimeout(() => {
            this.$router.push('/admin/seminars')
          }, 1500)
        } else {
          await mockServer.updateSeminar(this.seminarId, this.formData)
          this.successMessage = 'セミナーを更新しました'
        }
      } catch (err) {
        this.submitError = this.isNew ? 'セミナーの作成に失敗しました' : 'セミナーの更新に失敗しました'
        console.error(err)
      } finally {
        this.submitLoading = false
      }
    },
    goBack() {
      this.$router.push('/admin/seminars')
    },
    handleLogout() {
      localStorage.removeItem('adminToken')
      localStorage.removeItem('adminUser')
      this.$router.push('/admin/login')
    }
  }
}
</script>

<style scoped>
.dashboard {
  background-color: white;
  border-radius: 8px;
  overflow: hidden;
  min-height: calc(100vh - 120px);
}

.page-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 20px 24px;
  border-bottom: 1px solid #e5e5e5;
  background-color: #f8f9fa;
}

.header-left {
  display: flex;
  align-items: center;
  gap: 16px;
}

.back-btn {
  background: none;
  border: none;
  color: #0066cc;
  font-size: 14px;
  cursor: pointer;
  padding: 8px 0;
  transition: color 0.2s;
}

.back-btn:hover {
  color: #0052a3;
  text-decoration: underline;
}

.page-title {
  font-size: 24px;
  font-weight: 600;
  color: #1A1A1A;
  margin: 0;
}

.header-actions {
  display: flex;
  gap: 12px;
}

.logout-btn {
  background-color: #1A1A1A;
  color: white;
  border: none;
  padding: 8px 16px;
  border-radius: 4px;
  font-size: 14px;
  cursor: pointer;
  transition: background-color 0.2s;
}

.logout-btn:hover {
  background-color: #555;
}

.form-container {
  padding: 24px;
  max-width: 800px;
  margin: 0 auto;
}

.loading {
  text-align: center;
  padding: 60px 20px;
  color: #666;
  font-size: 16px;
}

.error-container {
  padding: 20px;
  text-align: center;
}

.error-message {
  background-color: #fee2e2;
  border: 1px solid #fca5a5;
  color: #dc2626;
  padding: 16px;
  border-radius: 8px;
  font-size: 14px;
}

.form-section {
  margin-bottom: 32px;
}

.section-title {
  font-size: 18px;
  font-weight: 600;
  color: #1A1A1A;
  margin: 0 0 16px 0;
  padding-bottom: 8px;
  border-bottom: 2px solid #da5761;
}

.form-group {
  margin-bottom: 24px;
}

.form-row {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 16px;
}

.form-label {
  display: block;
  font-size: 14px;
  font-weight: 600;
  color: #1A1A1A;
  margin-bottom: 8px;
}

.required {
  color: #dc2626;
  font-weight: 500;
}

.form-input {
  width: 100%;
  padding: 12px 16px;
  border: 2px solid #e5e5e5;
  border-radius: 6px;
  font-size: 14px;
  transition: border-color 0.2s;
  box-sizing: border-box;
  font-family: inherit;
}

.form-input:focus {
  outline: none;
  border-color: #da5761;
}

.message {
  padding: 16px;
  border-radius: 6px;
  margin-bottom: 24px;
  font-size: 14px;
}

.success-message {
  background-color: #d1fae5;
  border: 1px solid #6ee7b7;
  color: #065f46;
}

.form-actions {
  display: flex;
  gap: 12px;
  justify-content: flex-end;
  padding-top: 24px;
  border-top: 1px solid #e5e5e5;
}

.btn {
  padding: 12px 24px;
  border: none;
  border-radius: 6px;
  font-size: 14px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s;
  min-width: 120px;
}

.btn-secondary {
  background-color: #f5f5f5;
  color: #1A1A1A;
  border: 1px solid #d1d5db;
}

.btn-secondary:hover {
  background-color: #e5e5e5;
}

.btn-primary {
  background-color: #da5761;
  color: white;
}

.btn-primary:hover:not(:disabled) {
  background-color: #c44853;
}

.btn:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

/* レスポンシブ対応 */
@media (max-width: 768px) {
  .page-header {
    flex-direction: column;
    gap: 16px;
    align-items: stretch;
  }
  
  .header-left {
    flex-direction: column;
    align-items: flex-start;
    gap: 8px;
  }
  
  .form-container {
    padding: 16px;
  }
  
  .page-title {
    font-size: 20px;
  }
  
  .form-actions {
    flex-direction: column-reverse;
  }
  
  .btn {
    width: 100%;
  }
  
  .form-row {
    grid-template-columns: 1fr;
  }
}

@media (max-width: 480px) {
  .page-header {
    padding: 16px;
  }
  
  .form-container {
    padding: 12px;
  }
  
  .page-title {
    font-size: 18px;
  }
  
  .form-section {
    margin-bottom: 24px;
  }
}
</style>
