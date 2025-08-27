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
                <th>ファイル名</th>
                <th>アップロード日時</th>
                <th>alt</th>
                <th>URL</th>
                <th>管理</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="media in filteredMedia" :key="media.id">
                <td class="file-name">{{ media.filename }}</td>
                <td class="upload-date">
                  {{ formatDate(media.date) }}<br>
                  <span class="time">16:00～ 17:00</span>
                </td>
                <td class="alt-text">{{ media.alt }}</td>
                <td class="file-url">{{ media.url }}</td>
                <td>
                  <button @click="editMedia(media)" class="edit-btn">編集</button>
                </td>
                <td>
                  <input 
                    type="checkbox" 
                    :value="media.id" 
                    v-model="selectedMedia"
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

export default {
  name: 'MediaManagement',
  components: {
    AdminLayout
  },
  data() {
    return {
      media: [
        {
          id: 1,
          filename: 'a.jpg',
          date: '2025-04-23',
          alt: 'XXXXXXXX',
          url: 'https://www.chikugin-ri.co.jp/'
        },
        {
          id: 2,
          filename: 'a.png',
          date: '2025-04-23',
          alt: 'XXXXXXXX',
          url: 'https://www.chikugin-ri.co.jp/'
        },
        {
          id: 3,
          filename: 'a.jpg',
          date: '2025-04-23',
          alt: 'XXXXXXXX',
          url: 'https://www.chikugin-ri.co.jp/'
        },
        {
          id: 4,
          filename: 'a.png',
          date: '2025-04-23',
          alt: 'XXXXXXXX',
          url: 'https://www.chikugin-ri.co.jp/'
        },
        {
          id: 5,
          filename: 'a.png',
          date: '2025-04-23',
          alt: 'XXXXXXXX',
          url: 'https://www.chikugin-ri.co.jp/'
        },
        {
          id: 6,
          filename: 'a.jpg',
          date: '2025-04-23',
          alt: 'XXXXXXXX',
          url: 'https://www.chikugin-ri.co.jp/'
        },
        {
          id: 7,
          filename: 'a.png',
          date: '2025-04-23',
          alt: 'XXXXXXXX',
          url: 'https://www.chikugin-ri.co.jp/'
        },
        {
          id: 8,
          filename: 'a.jpg',
          date: '2025-04-23',
          alt: 'XXXXXXXX',
          url: 'https://www.chikugin-ri.co.jp/'
        }
      ],
      loading: false,
      error: '',
      searchKeyword: '',
      selectedMedia: []
    }
  },
  computed: {
    filteredMedia() {
      let result = this.media
      
      if (this.searchKeyword) {
        const keyword = this.searchKeyword.toLowerCase()
        result = result.filter(item => 
          item.filename.toLowerCase().includes(keyword) ||
          item.alt.toLowerCase().includes(keyword) ||
          item.url.toLowerCase().includes(keyword)
        )
      }
      
      return result
    }
  },
  methods: {
    formatDate(dateString) {
      const date = new Date(dateString)
      const year = date.getFullYear()
      const month = date.getMonth() + 1
      const day = date.getDate()
      const weekdays = ['日', '月', '火', '水', '木', '金', '土']
      const weekday = weekdays[date.getDay()]
      
      return `${year}年${month}月${day}日(${weekday})`
    },
    editMedia(media) {
      this.$router.push(`/admin/media/${media.id}/edit`)
    },
    createNewMedia() {
      this.$router.push('/admin/media/new')
    },
    uploadNewMedia() {
      console.log('Upload new media')
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

.file-name {
  color: #333;
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
