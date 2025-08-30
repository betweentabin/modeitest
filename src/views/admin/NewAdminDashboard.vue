<template>
  <AdminLayout>
    <div class="dashboard">
      <!-- ページヘッダー -->
      <div class="page-header">
        <h1 class="page-title">各ページ管理</h1>
        <button @click="createNewPage" class="add-btn">アップロード</button>
      </div>

      <!-- フィルターセクション -->
      <div class="filter-section">
        <div class="filter-row">
          <div class="filter-group">
            <select v-model="filters.year" class="filter-select">
              <option value="">年度</option>
              <option value="2025">2025</option>
              <option value="2024">2024</option>
              <option value="2023">2023</option>
            </select>
          </div>
          <div class="filter-group">
            <select v-model="filters.month" class="filter-select">
              <option value="">月</option>
              <option value="1">1月</option>
              <option value="2">2月</option>
              <option value="3">3月</option>
              <option value="4">4月</option>
              <option value="5">5月</option>
              <option value="6">6月</option>
              <option value="7">7月</option>
              <option value="8">8月</option>
              <option value="9">9月</option>
              <option value="10">10月</option>
              <option value="11">11月</option>
              <option value="12">12月</option>
            </select>
          </div>
          <div class="filter-group">
            <select v-model="filters.category" class="filter-select">
              <option value="">カテゴリー</option>
              <option value="news">ニュース</option>
              <option value="research">研究レポート</option>
              <option value="seminar">セミナー</option>
            </select>
          </div>
          <button @click="applyFilters" class="apply-btn">絞り込み</button>
        </div>
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
                <th>ページ</th>
                <th>アップロード日時</th>
                <th>管理</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="page in filteredPages" :key="page.pageKey">
                <td class="page-name">{{ page.title || page.pageKey }}</td>
                <td class="upload-date">
                  {{ formatDate(page.lastUpdated) }}<br>
                  <span class="time">16:00～ 17:00</span>
                </td>
                <td>
                  <button @click="editPage(page)" class="edit-btn">編集</button>
                </td>
                <td>
                  <input 
                    type="checkbox" 
                    :value="page.pageKey" 
                    v-model="selectedPages"
                    class="checkbox"
                  >
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
import mockServer from '@/mockServer'

export default {
  name: 'NewAdminDashboard',
  components: {
    AdminLayout
  },
  data() {
    return {
      pages: [],
      loading: false,
      error: '',
      searchKeyword: '',
      selectedPages: [],
      filters: {
        year: '',
        month: '',
        category: ''
      }
    }
  },
  computed: {
    filteredPages() {
      let result = this.pages
      
      if (this.searchKeyword) {
        const keyword = this.searchKeyword.toLowerCase()
        result = result.filter(page => 
          (page.title && page.title.toLowerCase().includes(keyword)) ||
          (page.pageKey && page.pageKey.toLowerCase().includes(keyword))
        )
      }
      
      return result
    }
  },
  async mounted() {
    const token = localStorage.getItem('adminToken')
    
    if (!token) {
      this.$router.push('/admin/login')
      return
    }

    await this.fetchPages()
  },
  methods: {
    async fetchPages() {
      this.loading = true
      this.error = ''

      try {
        console.log('Fetching pages from mockServer...')
        const data = await mockServer.getPages()
        console.log('Pages received:', data)
        this.pages = data
        console.log('Pages set to component:', this.pages)
      } catch (err) {
        this.error = 'ページの取得に失敗しました'
        console.error('Error fetching pages:', err)
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
    editPage(page) {
      this.$router.push(`/admin/pages/${page.pageKey}/edit`)
    },
    createNewPage() {
      this.$router.push('/admin/pages/new')
    },
    applyFilters() {
      // フィルター処理をここに実装
      console.log('Applying filters:', this.filters)
    },
    performSearch() {
      // 検索処理は computed で自動的に処理される
      console.log('Searching for:', this.searchKeyword)
    }
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

.filter-section {
  padding: 16px 24px;
  background-color: #f8f8f8;
  border-bottom: 1px solid #e5e5e5;
}

.filter-row {
  display: flex;
  align-items: center;
  gap: 16px;
}

.filter-group {
  position: relative;
}

.filter-select {
  background-color: white;
  border: 1px solid #d0d0d0;
  border-radius: 4px;
  padding: 8px 12px;
  font-size: 14px;
  color: #1A1A1A;
  min-width: 120px;
  cursor: pointer;
}

.apply-btn {
  background-color: #1A1A1A;
  color: white;
  border: none;
  padding: 8px 16px;
  border-radius: 4px;
  font-size: 14px;
  cursor: pointer;
  transition: background-color 0.2s;
}

.apply-btn:hover {
  background-color: #555;
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

.page-name {
  color: #1A1A1A;
  font-weight: 500;
}

.upload-date {
  color: #666;
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

/* レスポンシブ対応 */
@media (max-width: 768px) {
  .page-header {
    flex-direction: column;
    gap: 16px;
    align-items: stretch;
  }
  
  .filter-row {
    flex-direction: column;
    gap: 12px;
  }
  
  .search-container {
    max-width: 100%;
  }
  
  .table-container {
    font-size: 12px;
  }
  
  .data-table th,
  .data-table td {
    padding: 8px;
  }
  
  .page-name {
    max-width: 200px;
    word-break: break-word;
  }
}

@media (max-width: 480px) {
  .page-header,
  .filter-section,
  .search-section {
    padding: 12px 16px;
  }
  
  .filter-select {
    min-width: 100px;
  }
  
  .search-input {
    font-size: 16px; /* iOS zoom防止 */
  }
}
</style>
