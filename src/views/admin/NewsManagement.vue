<template>
  <AdminLayout>
    <div class="dashboard">
      <div class="page-header">
        <h1 class="page-title">ニュース管理（News）</h1>
        <button @click="createNews" class="add-btn">追加</button>
      </div>

      <div class="table-container">
        <div v-if="loading" class="loading">読み込み中...</div>
        <div v-else-if="error" class="error">{{ error }}</div>
        <div v-else class="table-wrapper">
          <table class="data-table">
            <thead>
              <tr>
                <th>ID</th>
                <th>タイトル</th>
                <th>公開日</th>
                <th>操作</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in news" :key="item.id">
                <td>{{ item.id }}</td>
                <td class="title">{{ item.title }}</td>
                <td>{{ formatDate(item.published_at) }}</td>
                <td>
                  <button class="edit-btn" @click="editNews(item.id)">編集</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script>
import AdminLayout from './AdminLayout.vue'
import apiClient from '../../services/apiClient'

export default {
  name: 'NewsManagement',
  components: { AdminLayout },
  data() {
    return {
      news: [],
      loading: false,
      error: ''
    }
  },
  async mounted() {
    await this.loadNews()
  },
  methods: {
    async loadNews() {
      this.loading = true
      this.error = ''
      try {
        const res = await apiClient.get('/api/admin/news-v2?per_page=50')
        if (res && res.success && res.data) {
          this.news = res.data.news
        } else {
          this.error = 'ニュースの取得に失敗しました'
        }
      } catch (e) {
        this.error = 'ニュースの取得に失敗しました'
        console.error(e)
      } finally {
        this.loading = false
      }
    },
    formatDate(v) {
      if (!v) return ''
      const d = new Date(v)
      if (isNaN(d)) return v
      const mm = String(d.getMonth()+1).padStart(2,'0')
      const dd = String(d.getDate()).padStart(2,'0')
      return `${d.getFullYear()}-${mm}-${dd}`
    },
    editNews(id) {
      this.$router.push(`/admin/news/${id}/edit`)
    },
    createNews() {
      this.$router.push('/admin/news/new')
    }
  }
}
</script>

<style scoped>
.dashboard { background: #fff; border-radius: 8px; overflow: hidden; }
.page-header { display:flex; justify-content:space-between; align-items:center; padding:16px 20px; border-bottom:1px solid #eee; }
.page-title { margin:0; font-size:20px; font-weight:600; }
.add-btn, .edit-btn { background:#1A1A1A; color:#fff; border:none; padding:8px 12px; border-radius:6px; cursor:pointer; }
.add-btn { background:#da5761; }
.table-container { padding: 16px 20px; }
.data-table { width:100%; border-collapse: collapse; }
.data-table th, .data-table td { padding:12px; border-bottom:1px solid #eee; text-align:left; }
.title { max-width: 520px; }
.loading, .error { text-align:center; padding:30px; color:#666; }
.error { color:#da5761; }
</style>

