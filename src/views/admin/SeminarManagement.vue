<template>
  <AdminLayout>
    <div class="dashboard">
      <!-- ページヘッダー -->
      <div class="page-header">
        <h1 class="page-title">セミナー管理</h1>
        <button @click="createNewSeminar" class="add-btn">追加</button>
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
            <select v-model="filters.status" class="filter-select">
              <option value="">ステータス</option>
              <option value="scheduled">予定</option>
              <option value="ongoing">申し込み受付中</option>
              <option value="completed">終了</option>
              <option value="cancelled">中止</option>
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
                <th>セミナー名</th>
                <th>日時</th>
                <th>会場情報</th>
                <th>ステータス</th>
                <th>受講可</th>
                <th>募集人数</th>
                <th>管理</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="seminar in filteredSeminars" :key="seminar.id">
                <td class="seminar-name">{{ seminar.title }}</td>
                <td class="seminar-date">
                  {{ formatDate(seminar.date) }}<br>
                  <span class="time">{{ seminar.time || '16:00～ 17:00' }}</span>
                </td>
                <td class="venue">{{ seminar.venue || 'ZOOM（福岡県）' }}</td>
                <td>
                  <span class="status-badge" :class="getStatusClass(seminar.status)">
                    {{ getStatusText(seminar.status) }}
                  </span>
                </td>
                <td class="membership">{{ seminar.membership || '一般' }}</td>
                <td class="capacity">{{ seminar.capacity || '200' }}名</td>
                <td>
                  <button @click="editSeminar(seminar)" class="edit-btn">編集</button>
                </td>
                <td>
                  <input 
                    type="checkbox" 
                    :value="seminar.id" 
                    v-model="selectedSeminars"
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
  name: 'SeminarManagement',
  components: {
    AdminLayout
  },
  data() {
    return {
      seminars: [],
      loading: false,
      error: '',
      searchKeyword: '',
      selectedSeminars: [],
      filters: {
        year: '',
        month: '',
        status: ''
      }
    }
  },
  async mounted() {
    await this.loadSeminars()
  },
  computed: {
    filteredSeminars() {
      let result = this.seminars
      
      if (this.searchKeyword) {
        const keyword = this.searchKeyword.toLowerCase()
        result = result.filter(seminar => 
          seminar.title.toLowerCase().includes(keyword) ||
          seminar.venue.toLowerCase().includes(keyword)
        )
      }
      
      if (this.filters.status) {
        result = result.filter(seminar => seminar.status === this.filters.status)
      }
      
      return result
    }
  },
  methods: {
    async loadSeminars() {
      this.loading = true
      try {
        const data = await mockServer.getSeminars()
        // データ形式を既存のテンプレートに合わせて調整
        this.seminars = data.map(seminar => ({
          ...seminar,
          time: `${seminar.start_time || '16:00'}～ ${seminar.end_time || '17:00'}`,
          venue: seminar.location || 'ZOOM（福岡県）',
          membership: '一般'
        }))
      } catch (err) {
        this.error = 'セミナーデータの読み込みに失敗しました'
        console.error(err)
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
    getStatusClass(status) {
      switch (status) {
        case 'completed': return 'status-completed'
        case 'ongoing': return 'status-ongoing'
        case 'scheduled': return 'status-scheduled'
        case 'cancelled': return 'status-cancelled'
        default: return ''
      }
    },
    getStatusText(status) {
      switch (status) {
        case 'completed': return '終了'
        case 'ongoing': return '申し込み受付中'
        case 'scheduled': return '予定'
        case 'cancelled': return '中止'
        default: return '不明'
      }
    },
    editSeminar(seminar) {
      this.$router.push(`/admin/seminars/${seminar.id}/edit`)
    },
    createNewSeminar() {
      this.$router.push('/admin/seminars/new')
    },
    applyFilters() {
      console.log('Applying filters:', this.filters)
    },
    performSearch() {
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
  color: #333;
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
  color: #333;
  min-width: 120px;
  cursor: pointer;
}

.apply-btn {
  background-color: #333;
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
  color: #333;
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
  color: #333;
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
  color: #333;
}

.data-table td {
  border-bottom: 1px solid #e5e5e5;
  padding: 16px;
  font-size: 14px;
}

.seminar-name {
  color: #333;
  font-weight: 500;
  max-width: 300px;
}

.seminar-date {
  color: #666;
}

.venue {
  color: #666;
  max-width: 200px;
  font-size: 12px;
}

.time {
  font-size: 12px;
  color: #999;
}

.status-badge {
  padding: 4px 8px;
  border-radius: 12px;
  font-size: 12px;
  font-weight: 500;
}

.status-completed {
  background-color: #e5e7eb;
  color: #374151;
}

.status-ongoing {
  background-color: #dbeafe;
  color: #1e40af;
}

.status-scheduled {
  background-color: #fef3c7;
  color: #92400e;
}

.status-cancelled {
  background-color: #fee2e2;
  color: #dc2626;
}

.membership {
  color: #666;
  font-size: 12px;
}

.capacity {
  color: #666;
  font-size: 12px;
}

.edit-btn {
  background-color: #333;
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
