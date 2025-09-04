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

            <!-- 画像管理 -->
            <div class="form-section">
              <h3 class="section-title">画像管理</h3>
              <div class="image-management">
                <div v-if="!isNew && formData.images && formData.images.length > 0" class="image-list">
                  <div v-for="(image, index) in formData.images" :key="index" class="image-item">
                    <div class="image-preview">
                      <img :src="image.url" :alt="image.alt || '画像'" class="preview-img" />
                    </div>
                    <div class="image-details">
                      <div class="image-info">
                        <div class="image-name">{{ image.alt || `画像 ${index + 1}` }}</div>
                        <div class="image-path">{{ image.url }}</div>
                      </div>
                      <div class="image-actions">
                        <button 
                          type="button" 
                          @click="editImage(index)" 
                          class="image-btn edit-image-btn"
                        >
                          編集
                        </button>
                        <button 
                          type="button" 
                          @click="deleteImage(index)" 
                          class="image-btn delete-image-btn"
                        >
                          削除
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div v-else class="no-images">
                  <p>画像がまだ追加されていません</p>
                </div>
                
                <div class="add-image-section">
                  <button 
                    type="button" 
                    @click="showImageUploadModal = true" 
                    class="add-image-btn"
                  >
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                      <path d="M8 0a1 1 0 0 1 1 1v6h6a1 1 0 1 1 0 2H9v6a1 1 0 1 1-2 0V9H1a1 1 0 0 1 0-2h6V1a1 1 0 0 1 1-1z"/>
                    </svg>
                    画像を追加
                  </button>
                </div>
                
                <!-- 画像アップロードモーダル -->
                <div v-if="showImageUploadModal" class="modal-overlay">
                  <div class="modal-container">
                    <div class="modal-header">
                      <h3>画像を追加</h3>
                      <button @click="showImageUploadModal = false" class="close-modal">×</button>
                    </div>
                    <div class="modal-body">
                      <div class="form-group">
                        <label class="form-label">画像を選択</label>
                        <input 
                          type="file" 
                          @change="handleImageSelect" 
                          accept="image/*" 
                          class="file-input"
                          ref="fileInput"
                        />
                      </div>
                      
                      <div v-if="selectedImage" class="image-preview-container">
                        <img :src="selectedImagePreview" alt="プレビュー" class="image-preview-large" />
                      </div>
                      
                      <div class="form-group">
                        <label for="image-alt" class="form-label">代替テキスト</label>
                        <input 
                          id="image-alt" 
                          v-model="newImage.alt" 
                          type="text" 
                          class="form-input" 
                          placeholder="画像の説明"
                        />
                      </div>
                      
                      <div class="form-group">
                        <label for="image-description" class="form-label">説明</label>
                        <textarea 
                          id="image-description" 
                          v-model="newImage.description" 
                          class="form-input" 
                          rows="3" 
                          placeholder="画像の詳細な説明"
                        ></textarea>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button 
                        @click="showImageUploadModal = false" 
                        class="btn btn-secondary"
                      >
                        キャンセル
                      </button>
                      <button 
                        @click="addImage" 
                        class="btn btn-primary"
                        :disabled="!selectedImage"
                      >
                        追加
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- コンテンツ -->
            <div class="form-section">
              <h3 class="section-title">コンテンツ</h3>
              <div class="mode-toggle">
                <label><input type="radio" value="json" v-model="contentMode" /> JSON</label>
                <label><input type="radio" value="html" v-model="contentMode" /> HTML（全文編集）</label>
                <label><input type="radio" value="fields" v-model="contentMode" /> Fields（安全なテキスト上書き）</label>
              </div>

              <div v-if="contentMode==='json'" class="form-group">
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

              <div v-else-if="contentMode==='html'" class="form-group">
                <label for="content_html" class="form-label">
                  コンテンツ (HTML)
                </label>
                <textarea
                  id="content_html"
                  v-model="contentHtml"
                  rows="18"
                  class="html-editor"
                  placeholder="ここにHTMLを直接入力してください"
                />
                <p class="form-help">危険なスクリプトは入れないでください（自動サニタイズは行っていません）。</p>
              </div>

              <!-- Fields mode: key-value editor for content.texts -->
              <div v-else class="form-group">
                <label class="form-label">
                  テキストフィールド（content.texts）
                </label>
                <div class="fields-editor">
                  <div 
                    v-for="(row, idx) in textsEditor" 
                    :key="row._id"
                    class="field-row"
                  >
                    <input
                      v-model="row.key"
                      type="text"
                      class="form-input field-key"
                      placeholder="キー（例: page_title, lead, cta_primary）"
                    />
                    <input
                      v-model="row.value"
                      type="text"
                      class="form-input field-value"
                      placeholder="値（表示テキスト）"
                    />
                    <button type="button" class="btn btn-secondary small" @click="removeTextField(idx)">削除</button>
                  </div>
                  <button type="button" class="btn btn-primary" @click="addTextField">+ フィールドを追加</button>
                  <p class="form-help">推奨キー例: page_title, page_subtitle, lead, cta_primary, cta_secondary</p>
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
import mockServer from '@/mockServer'
import axios from 'axios'
import apiClient from '@/services/apiClient.js'

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
        is_published: false,
        images: []
      },
      contentMode: 'json',
      contentJson: '',
      contentHtml: '',
      textsEditor: [],
      jsonError: '',
      loading: false,
      submitLoading: false,
      error: '',
      submitError: '',
      successMessage: '',
      showImageUploadModal: false,
      selectedImage: null,
      selectedImagePreview: '',
      newImage: {
        alt: '',
        description: '',
        url: ''
      },
      editingImageIndex: -1
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
    const token = localStorage.getItem('admin_token')
    
    if (!token) {
      this.$router.push('/admin/login')
      return
    }

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
        const data = await mockServer.getPage(this.pageKey)
        this.formData = {
          ...data,
          images: data.images || []
        }
        this.contentJson = JSON.stringify(data.content || data, null, 2)
        // Initialize fields editor from content.texts if available
        const texts = (data && data.content && data.content.texts) ? data.content.texts : {}
        this.textsEditor = Object.keys(texts).map((k) => ({ _id: `${k}-${Date.now()}-${Math.random()}`, key: k, value: texts[k] }))
      } catch (err) {
        this.error = 'ページデータの取得に失敗しました'
        console.error(err)
      } finally {
        this.loading = false
      }
    },
    
    handleImageSelect(event) {
      const file = event.target.files[0]
      if (!file) return
      
      if (file.size > 5 * 1024 * 1024) {
        this.submitError = '画像サイズは5MB以下にしてください'
        return
      }
      
      this.selectedImage = file
      
      // プレビュー用のURLを作成
      const reader = new FileReader()
      reader.onload = (e) => {
        this.selectedImagePreview = e.target.result
      }
      reader.readAsDataURL(file)
    },
    
    addImage() {
      if (!this.selectedImage) return
      
      const reader = new FileReader()
      reader.onload = (e) => {
        const newImageData = {
          id: Date.now(),
          url: e.target.result,
          alt: this.newImage.alt || this.selectedImage.name,
          description: this.newImage.description || ''
        }
        
        if (this.editingImageIndex >= 0) {
          // 既存の画像を更新
          this.formData.images.splice(this.editingImageIndex, 1, newImageData)
          this.editingImageIndex = -1
        } else {
          // 新しい画像を追加
          if (!this.formData.images) {
            this.formData.images = []
          }
          this.formData.images.push(newImageData)
        }
        
        // モーダルをリセット
        this.resetImageModal()
        
        // 成功メッセージ
        this.successMessage = '画像が追加されました'
        setTimeout(() => {
          this.successMessage = ''
        }, 3000)
      }
      reader.readAsDataURL(this.selectedImage)
    },
    
    editImage(index) {
      const image = this.formData.images[index]
      this.editingImageIndex = index
      this.newImage = {
        alt: image.alt,
        description: image.description
      }
      this.selectedImagePreview = image.url
      this.selectedImage = true // 画像が既に選択されている状態
      this.showImageUploadModal = true
    },
    
    deleteImage(index) {
      if (!confirm('この画像を削除してもよろしいですか？')) {
        return
      }
      
      this.formData.images.splice(index, 1)
      this.successMessage = '画像が削除されました'
      setTimeout(() => {
        this.successMessage = ''
      }, 3000)
    },
    
    resetImageModal() {
      this.showImageUploadModal = false
      this.selectedImage = null
      this.selectedImagePreview = ''
      this.newImage = {
        alt: '',
        description: '',
        url: ''
      }
      this.editingImageIndex = -1
      if (this.$refs.fileInput) {
        this.$refs.fileInput.value = ''
      }
    },
    addTextField() {
      this.textsEditor.push({ _id: `new-${Date.now()}-${Math.random()}`, key: '', value: '' })
    },
    removeTextField(index) {
      this.textsEditor.splice(index, 1)
    },
    async handleSubmit() {
      this.submitLoading = true
      this.submitError = ''
      this.successMessage = ''

      try {
        // コンテンツのモードに応じて content を設定
        if (this.contentMode === 'html') {
          this.formData.content = this.contentHtml || ''
        } else if (this.contentMode === 'fields') {
          // Merge with existing JSON if valid, else new object
          let base = {}
          try { base = this.contentJson ? JSON.parse(this.contentJson) : {} } catch(e) { base = {} }
          const texts = {}
          for (const row of this.textsEditor) {
            const k = (row.key || '').trim()
            if (!k) continue
            texts[k] = row.value || ''
          }
          this.formData.content = { ...(base || {}), texts }
        } else {
          try {
            this.formData.content = JSON.parse(this.contentJson)
          } catch (e) {
            this.submitError = 'JSONの形式が正しくありません: ' + e.message
            this.submitLoading = false
            return
          }
        }
        
        // 送信データの準備
        const submitData = {
          ...this.formData,
          // 画像データも含める
          images: this.formData.images || []
        }
        
        if (this.isNew) {
          // 新規作成機能
          if (!submitData.page_key) {
            this.submitError = 'ページキーは必須です'
            this.submitLoading = false
            return
          }
          
          try {
            const res = await apiClient.request('POST', '/api/admin/pages', submitData)
            if (!(res && (res.success || res.id || res.page || res.data))) {
              throw new Error(res?.message || '作成に失敗しました')
            }
            this.successMessage = 'ページを作成しました'
            setTimeout(() => {
              this.$router.push('/admin/pages')
            }, 1500)
          } catch (e) {
            this.submitError = '新規ページ作成に失敗しました: ' + e.message
          }
        } else {
          // 既存ページの更新
          const key = this.formData.page_key || this.pageKey
          const res = await apiClient.request('PUT', `/api/admin/pages/${key}`, submitData)
          if (!(res && (res.success || res.id || res.page || res.data))) {
            throw new Error(res?.message || '更新に失敗しました')
          }
          this.successMessage = 'ページを更新しました'
          
          // 画像が含まれる場合、成功メッセージを拡張
          if (submitData.images && submitData.images.length > 0) {
            this.successMessage += `（${submitData.images.length}枚の画像を含む）`
          }
          
          // 更新後に最新データを再取得
          setTimeout(() => {
            this.fetchPageData()
          }, 1000)
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
      localStorage.removeItem('admin_token')
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
  color: #1A1A1A;
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

/* 画像管理スタイル */
.image-management {
  margin-top: 16px;
}

.image-list {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 20px;
  margin-bottom: 24px;
}

.image-item {
  border: 1px solid #e5e5e5;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
  background-color: white;
}

.image-preview {
  height: 160px;
  overflow: hidden;
  background-color: #f5f5f5;
}

.preview-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.image-details {
  padding: 12px;
}

.image-info {
  margin-bottom: 12px;
}

.image-name {
  font-weight: 500;
  font-size: 14px;
  color: #1A1A1A;
  margin-bottom: 4px;
}

.image-path {
  font-size: 12px;
  color: #666;
  word-break: break-all;
}

.image-actions {
  display: flex;
  gap: 8px;
}

.image-btn {
  flex: 1;
  padding: 8px;
  border-radius: 4px;
  font-size: 12px;
  cursor: pointer;
  border: none;
  transition: all 0.2s;
}

.edit-image-btn {
  background-color: #f5f5f5;
  color: #1A1A1A;
  border: 1px solid #d1d5db;
}

.edit-image-btn:hover {
  background-color: #e5e5e5;
}

.delete-image-btn {
  background-color: #fee2e2;
  color: #dc2626;
  border: 1px solid #fca5a5;
}

.delete-image-btn:hover {
  background-color: #fecaca;
}

.no-images {
  padding: 32px;
  text-align: center;
  background-color: #f9fafb;
  border: 1px dashed #d1d5db;
  border-radius: 8px;
  color: #666;
  margin-bottom: 24px;
}

.add-image-section {
  margin-bottom: 24px;
}

.add-image-btn {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 12px 16px;
  background-color: #f9fafb;
  border: 1px dashed #d1d5db;
  border-radius: 8px;
  color: #1A1A1A;
  font-size: 14px;
  cursor: pointer;
  transition: all 0.2s;
  width: 100%;
  justify-content: center;
}

.add-image-btn:hover {
  background-color: #f3f4f6;
  border-color: #da5761;
  color: #da5761;
}

.add-image-btn svg {
  transition: all 0.2s;
}

.add-image-btn:hover svg {
  color: #da5761;
}

/* モーダル */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
}

.modal-container {
  background-color: white;
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
  width: 100%;
  max-width: 600px;
  max-height: 90vh;
  overflow-y: auto;
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 16px 24px;
  border-bottom: 1px solid #e5e5e5;
}

.modal-header h3 {
  margin: 0;
  font-size: 18px;
  font-weight: 600;
  color: #1A1A1A;
}

.close-modal {
  background: none;
  border: none;
  font-size: 24px;
  color: #666;
  cursor: pointer;
  padding: 0;
  line-height: 1;
}

.modal-body {
  padding: 24px;
}

.modal-footer {
  display: flex;
  justify-content: flex-end;
  gap: 12px;
  padding: 16px 24px;
  border-top: 1px solid #e5e5e5;
}

.file-input {
  padding: 12px;
  border: 1px solid #e5e5e5;
  border-radius: 6px;
  width: 100%;
  background-color: #f9fafb;
}

.image-preview-container {
  margin: 16px 0;
  text-align: center;
}

.image-preview-large {
  max-width: 100%;
  max-height: 300px;
  border: 1px solid #e5e5e5;
  border-radius: 4px;
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
