<template>
  <AdminLayout>
    <div class="dashboard">
      <!-- ページヘッダー -->
      <div class="page-header">
        <h1 class="page-title">メディア管理</h1>
        <button @click="uploadNewMedia" class="add-btn">アップロード</button>
      </div>

      <!-- 検索セクション -->
      <div class="search-section">
        <div class="search-container">
          <span class="search-label">検索する</span>
          <input 
            v-model="searchKeyword" 
            type="text" 
            placeholder="キーワードを入力する"
            class="search-input"
            @keyup.enter="performSearch"
          >
          <button @click="performSearch" class="search-btn">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
              <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.415l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" fill="currentColor"/>
            </svg>
          </button>
        </div>
      </div>

      <!-- データテーブル -->
      <div class="table-container">
        <div v-if="loading" class="loading">読み込み中...</div>
        <div v-else-if="error" class="error">{{ error }}</div>
        <div v-else class="table-wrapper">
          <table class="data-table">
            <thead>
              <tr>
                <th style="width: 160px;">プレビュー</th>
                <th>キー</th>
                <th>URL</th>
                <th style="width: 120px;">操作</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(row, idx) in rows" :key="row._id">
                <td>
                  <img :src="row.value" alt="preview" style="max-width:140px; max-height:70px; object-fit:cover; border-radius:4px;" v-if="row.value" />
                  <div v-else style="color:#888; font-size:12px;">（未設定）</div>
                </td>
                <td>
                  <input v-model="row.key" class="form-input" placeholder="例）hero_home" />
                </td>
                <td>
                  <input v-model="row.value" class="form-input" placeholder="/img/hero.jpg または https://..." />
                </td>
                <td>
                  <button class="edit-btn" @click="pickFile(idx)">選択</button>
                  <button class="delete-btn" @click="removeRow(idx)">削除</button>
                </td>
              </tr>
            </tbody>
          </table>
          <div class="table-actions">
            <button class="add-btn" @click="addRow">+ 追加</button>
            <button class="save-btn" @click="save">保存</button>
            <input ref="file" type="file" accept="image/*" style="display:none" @change="onFileSelected" />
          </div>
        </div>
      </div>

      <!-- ページネーション -->
      <div class="pagination">
        <span class="page-info">1 2 3 .... 99 最後</span>
      </div>
    </div>
  </AdminLayout>
</template>

<script>
import AdminLayout from './AdminLayout.vue'
import apiClient from '@/services/apiClient.js'

export default {
  name: 'MediaManagement',
  components: {
    AdminLayout
  },
  data() {
    return {
      rows: [], // { _id, key, value }
      loading: false,
      error: '',
      searchKeyword: '',
      selectedMedia: [],
      filePickIndex: -1,
    }
  },
  async mounted() {
    await this.load()
  },
  methods: {
    async load() {
      this.loading = true
      this.error = ''
      try {
        const res = await apiClient.getPageContent('media')
        const page = res?.data?.page || res?.data?.data?.page
        const images = page?.content?.images || {}
        this.rows = Object.keys(images).map(k => ({ _id: `m-${k}-${Date.now()}-${Math.random()}`, key: k, value: images[k] }))
      } catch (e) {
        // fallback: mock localStorage
        try {
          const str = localStorage.getItem('cms_mock_data')
          const json = str ? JSON.parse(str) : null
          const images = json?.media?.images || {}
          this.rows = Object.keys(images).map(k => ({ _id: `m-${k}-${Date.now()}-${Math.random()}`, key: k, value: images[k] }))
        } catch(err) {
          this.error = 'メディアの取得に失敗しました'
        }
      } finally {
        this.loading = false
      }
    },
    formatDate(dateString) {
      const date = new Date(dateString)
      const year = date.getFullYear()
      const month = date.getMonth() + 1
      const day = date.getDate()
      const weekdays = ['日', '月', '火', '水', '木', '金', '土']
      const weekday = weekdays[date.getDay()]
      
      return `${year}年${month}月${day}日(${weekday})`
    },
    addRow() {
      this.rows.push({ _id: `new-${Date.now()}-${Math.random()}`, key: '', value: '' })
    },
    removeRow(idx) {
      this.rows.splice(idx, 1)
    },
    pickFile(idx) {
      this.filePickIndex = idx
      const el = this.$refs.file
      if (el) el.click()
    },
    onFileSelected(e) {
      const file = e.target.files[0]
      if (!file) return
      const reader = new FileReader()
      reader.onload = (ev) => {
        if (this.filePickIndex >= 0) {
          this.$set(this.rows[this.filePickIndex], 'value', ev.target.result)
          this.filePickIndex = -1
        }
        if (this.$refs.file) this.$refs.file.value = ''
      }
      reader.readAsDataURL(file)
    },
    async save() {
      const images = {}
      for (const row of this.rows) {
        const k = (row.key || '').trim()
        if (!k) continue
        images[k] = row.value || ''
      }
      const payload = {
        page_key: 'media',
        title: 'Media Registry',
        content: { images },
        is_published: true,
      }
      // Try update, fallback to create
      let saved = false
      try {
        let res = await apiClient.request('PUT', '/api/admin/pages/media', payload)
        if (!(res && (res.success || res.id || res.page || res.data))) {
          res = await apiClient.request('POST', '/api/admin/pages', payload)
        }
        saved = !!(res && (res.success || res.id || res.page || res.data))
      } catch(e) {}
      if (!saved) {
        // fallback: save to localStorage mock
        try {
          const str = localStorage.getItem('cms_mock_data')
          const json = str ? JSON.parse(str) : {}
          json.media = { images }
          localStorage.setItem('cms_mock_data', JSON.stringify(json))
          saved = true
        } catch(e) {}
      }
      alert(saved ? '保存しました' : '保存に失敗しました')
    },
    performSearch() {
      // キー/URLを対象にクライアントフィルタ（簡易）
      const kw = (this.searchKeyword || '').toLowerCase()
      if (!kw) return
      this.rows = this.rows.filter(r => (r.key||'').toLowerCase().includes(kw) || (r.value||'').toLowerCase().includes(kw))
    },
    uploadNewMedia() { this.addRow() }
  }
}
</script>

<style scoped>
.dashboard {
  background-color: white;
  border-radius: 8px;
  overflow: hidden;
}

.page-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 20px 24px;
  border-bottom: 1px solid #e5e5e5;
}

.page-title {
  font-size: 24px;
  font-weight: 600;
  color: #1A1A1A;
  margin: 0;
}

.add-btn {
  background-color: #da5761;
  color: white;
  border: none;
  padding: 8px 16px;
  border-radius: 4px;
  font-size: 14px;
  cursor: pointer;
  transition: background-color 0.2s;
}

.add-btn:hover {
  background-color: #c44853;
}

.search-section {
  padding: 16px 24px;
  border-bottom: 1px solid #e5e5e5;
}

.search-container {
  display: flex;
  align-items: center;
  gap: 12px;
  max-width: 500px;
  margin-left: auto;
}

.search-label {
  font-size: 14px;
  color: #1A1A1A;
  white-space: nowrap;
}

.search-input {
  flex: 1;
  border: 1px solid #d0d0d0;
  border-radius: 4px;
  padding: 8px 12px;
  font-size: 14px;
}

.search-btn {
  background: none;
  border: none;
  padding: 8px;
  cursor: pointer;
  color: #666;
  transition: color 0.2s;
}

.search-btn:hover {
  color: #1A1A1A;
}

.table-container {
  overflow-x: auto;
}

.loading, .error {
  padding: 40px;
  text-align: center;
  color: #666;
}

.error {
  color: #da5761;
}

.data-table {
  width: 100%;
  border-collapse: collapse;
}

.data-table th {
  background-color: #f8f8f8;
  border-bottom: 1px solid #e5e5e5;
  padding: 12px 16px;
  text-align: left;
  font-weight: 600;
  font-size: 14px;
  color: #1A1A1A;
}

.data-table td {
  border-bottom: 1px solid #e5e5e5;
  padding: 16px;
  font-size: 14px;
}

.file-name {
  color: #1A1A1A;
  font-weight: 500;
}

.upload-date {
  color: #666;
}

.alt-text {
  color: #666;
}

.file-url {
  color: #0066cc;
  text-decoration: underline;
  max-width: 200px;
  word-break: break-all;
}

.time {
  font-size: 12px;
  color: #999;
}

.edit-btn {
  background-color: #1A1A1A;
  color: white;
  border: none;
  padding: 6px 12px;
  border-radius: 4px;
  font-size: 12px;
  cursor: pointer;
  transition: background-color 0.2s;
}

.edit-btn:hover {
  background-color: #555;
}

.checkbox {
  width: 16px;
  height: 16px;
  cursor: pointer;
}

.pagination {
  padding: 16px 24px;
  text-align: center;
  border-top: 1px solid #e5e5e5;
}

.page-info {
  font-size: 14px;
  color: #da5761;
}
</style>
