<template>
  <AdminLayout>
    <div class="dashboard">
      <!-- ページヘッダー -->
      <div class="page-header">
        <h1 class="page-title">メディア管理</h1>
        <button @click="load" class="add-btn">再読み込み</button>
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
                <th>ページキー</th>
                <th>種別/場所</th>
                <th>URL</th>
                <th>更新日</th>
                <th style="width:140px;">操作</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(row, idx) in rows" :key="row._id">
                <td>
                  <img :src="row.url" alt="preview" style="max-width:140px; max-height:70px; object-fit:cover; border-radius:4px;" v-if="row.url" />
                  <div v-else style="color:#888; font-size:12px;">（未設定）</div>
                </td>
                <td>{{ row.pageKey }}</td>
                <td>{{ row.key }}</td>
                <td class="file-url">{{ row.url }}</td>
                <td>{{ formatDate(row.updated_at) }}</td>
                <td>
                  <button class="edit-btn" @click="pickReplace(idx)">画像で置換</button>
                </td>
              </tr>
            </tbody>
          </table>
          
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
      rows: [], // { _id, pageKey, key, url, source, updated_at }
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
        const res = await apiClient.get('/api/admin/pages/media-usage', { silent: true })
        const items = res?.data?.data?.items || res?.data?.items || []
        this.rows = items.map(it => ({
          _id: `mu-${it.page_key}-${it.key}-${Math.random()}`,
          pageKey: it.page_key,
          key: it.key,
          url: it.url,
          source: it.source || 'json',
          updated_at: it.updated_at,
        }))
      } catch (e) {
        this.error = 'メディアの取得に失敗しました'
      } finally {
        this.loading = false
      }
    },
    pickReplace(idx) {
      this.filePickIndex = idx
      // 動的にfile要素を起こす（1行1入力を避ける）
      const input = document.createElement('input')
      input.type = 'file'
      input.accept = 'image/*'
      input.onchange = async (e) => {
        const file = e.target.files[0]
        if (!file) return
        const row = this.rows[this.filePickIndex]
        try {
          const fd = new FormData()
          fd.append('image', file)
          let endpoint = ''
          if (row.source === 'json') {
            fd.append('key', row.key)
            endpoint = `/api/admin/pages/${row.pageKey}/replace-image`
          } else {
            fd.append('old_url', row.url)
            endpoint = `/api/admin/pages/${row.pageKey}/replace-html-image`
          }
          const url = endpoint
          const res = await apiClient.upload(url, fd)
          if (res && (res.success || res.data)) {
            alert('画像を置換しました')
            this.load()
          } else {
            alert(res?.message || '置換に失敗しました')
          }
        } catch (err) {
          console.error('replace image failed', err)
          alert('置換に失敗しました')
        } finally {
          this.filePickIndex = -1
        }
      }
      input.click()
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
    performSearch() {
      // キー/URLを対象にクライアントフィルタ（簡易）
      const kw = (this.searchKeyword || '').toLowerCase()
      if (!kw) return
      this.rows = this.rows.filter(r => (r.pageKey||'').toLowerCase().includes(kw) || (r.key||'').toLowerCase().includes(kw) || (r.url||'').toLowerCase().includes(kw))
    },
    uploadNewMedia() {}
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
