<template>
  <AdminLayout>
    <div class="dashboard">
      <!-- ページヘッダー -->
      <div class="page-header">
        <div class="header-left">
          <button @click="goBack" class="back-btn">
            ← ダッシュボードに戻る
          </button>
          <h1 class="page-title">{{ isNew ? '新規ページ作成' : 'ページ編集' }}</h1>
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
            <!-- ページキー -->
            <div class="form-section">
              <div class="form-group">
                <label for="page_key" class="form-label">
                  ページキー <span class="required">*</span>
                </label>
                <input
                  id="page_key"
                  v-model="formData.page_key"
                  type="text"
                  :disabled="!isNew"
                  required
                  class="form-input"
                  :class="{ disabled: !isNew }"
                  placeholder="例: about, services, contact"
                />
                <p class="form-help">
                  {{ isNew ? 'URLの一部になります（例: /about）' : 'ページキーは編集できません' }}
                </p>
              </div>
            </div>

            <!-- タイトル -->
            <div class="form-section">
              <div class="form-group">
                <label for="title" class="form-label">
                  ページタイトル <span class="required">*</span>
                </label>
                <input
                  id="title"
                  v-model="formData.title"
                  type="text"
                  required
                  class="form-input"
                  placeholder="ページのタイトルを入力してください"
                />
              </div>
            </div>

            <!-- コンテンツ -->
            <div class="form-section">
              <div class="form-group">
                <label for="content" class="form-label">
                  コンテンツ (JSON形式) <span class="required">*</span>
                </label>
                <div class="json-editor-container">
                  <textarea
                    id="content"
                    v-model="contentJson"
                    rows="15"
                    required
                    class="json-editor"
                    :class="{ error: jsonError }"
                    placeholder='{"key": "value", "title": "タイトル", "description": "説明文"}'
                  />
                  <div v-if="jsonError" class="json-error">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                      <path d="M8 16A8 8 0 1 1 8 0a8 8 0 0 1 0 16zM7 3v4a1 1 0 0 0 2 0V3a1 1 0 0 0-2 0zm1 8a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                    </svg>
                    {{ jsonError }}
                  </div>
                  <div v-else class="json-success">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                      <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.061L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                    </svg>
                    JSONフォーマットが正しいです
                  </div>
                </div>
              </div>
            </div>

            <!-- メタデータ -->
            <div class="form-section">
              <h3 class="section-title">SEO設定</h3>
              
              <div class="form-group">
                <label for="meta_description" class="form-label">
                  メタディスクリプション
                </label>
                <textarea
                  id="meta_description"
                  v-model="formData.meta_description"
                  rows="3"
                  class="form-input"
                  placeholder="検索結果に表示される説明文（160文字以内推奨）"
                />
                <p class="form-help">
                  {{ formData.meta_description ? formData.meta_description.length : 0 }}/160文字
                </p>
              </div>

              <div class="form-group">
                <label for="meta_keywords" class="form-label">
                  メタキーワード
                </label>
                <input
                  id="meta_keywords"
                  v-model="formData.meta_keywords"
                  type="text"
                  class="form-input"
                  placeholder="キーワード1, キーワード2, キーワード3"
                />
                <p class="form-help">カンマ区切りでキーワードを入力してください</p>
              </div>
            </div>

            <!-- 公開設定 -->
            <div class="form-section">
              <div class="form-group">
                <label class="checkbox-label">
                  <input
                    v-model="formData.is_published"
                    type="checkbox"
                    class="checkbox-input"
                  />
                  <span class="checkbox-custom"></span>
                  <span class="checkbox-text">ページを公開する</span>
                </label>
                <p class="form-help">
                  チェックを外すと、このページは非公開になります
                </p>
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
                :disabled="loading || jsonError || submitLoading"
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
import axios from 'axios'

export default {
  name: 'NewPageEditForm',
  components: {
    AdminLayout
  },
  data() {
    return {
      formData: {
        page_key: '',
        title: '',
        content: {},
        meta_description: '',
        meta_keywords: '',
        is_published: false
      },
      contentJson: '',
      jsonError: '',
      loading: false,
      submitLoading: false,
      error: '',
      submitError: '',
      successMessage: ''
    }
  },
  computed: {
    isNew() {
      return this.$route.params.pageKey === 'new'
    },
    pageKey() {
      return this.$route.params.pageKey
    }
  },
  watch: {
    contentJson(newValue) {
      this.jsonError = ''
      try {
        this.formData.content = JSON.parse(newValue)
      } catch (e) {
        this.jsonError = 'JSONの形式が正しくありません: ' + e.message
      }
    }
  },
  async mounted() {
    const token = localStorage.getItem('adminToken')
    
    if (!token) {
      this.$router.push('/admin/login')
      return
    }

    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
    
    if (!this.isNew) {
      await this.fetchPageData()
    } else {
      this.contentJson = JSON.stringify({
        "title": "新しいページ",
        "description": "ページの説明をここに入力してください"
      }, null, 2)
    }
  },
  methods: {
    async fetchPageData() {
      this.loading = true
      this.error = ''

      try {
        const response = await axios.get(`http://localhost:8000/api/admin/pages/${this.pageKey}`)
        this.formData = response.data
        this.contentJson = JSON.stringify(response.data.content, null, 2)
      } catch (err) {
        this.error = 'ページデータの取得に失敗しました'
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
          await axios.post('http://localhost:8000/api/admin/pages', this.formData)
          this.successMessage = 'ページを作成しました'
          setTimeout(() => {
            this.$router.push('/admin/pages')
          }, 1500)
        } else {
          await axios.put(`http://localhost:8000/api/admin/pages/${this.pageKey}`, this.formData)
          this.successMessage = 'ページを更新しました'
        }
      } catch (err) {
        if (err.response?.data?.errors) {
          this.submitError = Object.values(err.response.data.errors).flat().join(', ')
        } else {
          this.submitError = this.isNew ? 'ページの作成に失敗しました' : 'ページの更新に失敗しました'
        }
        console.error(err)
      } finally {
        this.submitLoading = false
      }
    },
    goBack() {
      this.$router.push('/admin/pages')
    },
    handleLogout() {
      localStorage.removeItem('adminToken')
      localStorage.removeItem('adminUser')
      delete axios.defaults.headers.common['Authorization']
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
  color: #333;
  margin: 0;
}

.header-actions {
  display: flex;
  gap: 12px;
}

.logout-btn {
  background-color: #333;
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
  color: #333;
  margin: 0 0 16px 0;
  padding-bottom: 8px;
  border-bottom: 2px solid #da5761;
}

.form-group {
  margin-bottom: 24px;
}

.form-label {
  display: block;
  font-size: 14px;
  font-weight: 600;
  color: #333;
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

.form-input.disabled {
  background-color: #f5f5f5;
  color: #666;
  cursor: not-allowed;
}

.form-help {
  font-size: 12px;
  color: #666;
  margin-top: 4px;
  margin-bottom: 0;
}

.json-editor-container {
  position: relative;
}

.json-editor {
  width: 100%;
  padding: 16px;
  border: 2px solid #e5e5e5;
  border-radius: 6px;
  font-size: 13px;
  font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
  line-height: 1.5;
  resize: vertical;
  min-height: 300px;
  box-sizing: border-box;
  transition: border-color 0.2s;
}

.json-editor:focus {
  outline: none;
  border-color: #da5761;
}

.json-editor.error {
  border-color: #dc2626;
}

.json-error {
  display: flex;
  align-items: center;
  gap: 8px;
  margin-top: 8px;
  padding: 8px 12px;
  background-color: #fee2e2;
  border: 1px solid #fca5a5;
  color: #dc2626;
  border-radius: 4px;
  font-size: 12px;
}

.json-success {
  display: flex;
  align-items: center;
  gap: 8px;
  margin-top: 8px;
  padding: 8px 12px;
  background-color: #d1fae5;
  border: 1px solid #6ee7b7;
  color: #065f46;
  border-radius: 4px;
  font-size: 12px;
}

.checkbox-label {
  display: flex;
  align-items: center;
  gap: 12px;
  cursor: pointer;
  padding: 16px;
  border: 2px solid #e5e5e5;
  border-radius: 6px;
  transition: border-color 0.2s;
}

.checkbox-label:hover {
  border-color: #da5761;
}

.checkbox-input {
  display: none;
}

.checkbox-custom {
  width: 20px;
  height: 20px;
  border: 2px solid #d1d5db;
  border-radius: 4px;
  position: relative;
  transition: all 0.2s;
}

.checkbox-input:checked + .checkbox-custom {
  background-color: #da5761;
  border-color: #da5761;
}

.checkbox-input:checked + .checkbox-custom::after {
  content: '';
  position: absolute;
  top: 2px;
  left: 6px;
  width: 4px;
  height: 8px;
  border: 2px solid white;
  border-left: none;
  border-top: none;
  transform: rotate(45deg);
}

.checkbox-text {
  font-size: 14px;
  font-weight: 500;
  color: #333;
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
  color: #333;
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
  
  .json-editor {
    font-size: 12px;
    min-height: 250px;
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
  
  .json-editor {
    min-height: 200px;
  }
}
</style>
