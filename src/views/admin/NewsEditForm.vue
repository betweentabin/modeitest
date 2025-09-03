<template>
  <AdminLayout>
    <div class="dashboard">
      <div class="page-header">
        <button @click="goBack" class="back-btn">← ニュース管理に戻る</button>
        <h1 class="page-title">{{ isNew ? 'ニュース新規作成' : 'ニュース編集' }}</h1>
      </div>
      <div class="form-container">
        <div v-if="loading" class="loading">読み込み中...</div>
        <form v-else @submit.prevent="handleSubmit" class="form">
          <label class="label">タイトル</label>
          <input v-model="form.title" type="text" required class="input" />

          <label class="label">概要/説明</label>
          <textarea v-model="form.description" rows="3" class="input"></textarea>

          <label class="label">本文</label>
          <textarea v-model="form.content" rows="6" class="input"></textarea>

          <div class="row">
            <div>
              <label class="label">カテゴリ</label>
              <select v-model="form.category" class="input">
                <option value="notice">お知らせ</option>
                <option value="seminar">セミナー</option>
                <option value="publication">刊行物</option>
                <option value="research">研究</option>
                <option value="general">一般</option>
              </select>
            </div>
            <div>
              <label class="label">種別</label>
              <select v-model="form.type" class="input">
                <option value="news">ニュース</option>
                <option value="seminar">セミナー</option>
                <option value="publication">刊行物</option>
                <option value="notice">お知らせ</option>
              </select>
            </div>
          </div>

          <div class="row">
            <div>
              <label class="label">公開日</label>
              <input v-model="form.published_date" type="date" class="input" />
            </div>
            <div class="check">
              <label><input type="checkbox" v-model="form.is_featured" /> 注目にする</label>
            </div>
          </div>

          <div class="actions">
            <button type="submit" class="btn" :disabled="submitting">{{ isNew ? '作成' : '更新' }}</button>
            <span v-if="error" class="error">{{ error }}</span>
            <span v-if="success" class="success">{{ success }}</span>
          </div>
        </form>
      </div>
    </div>
  </AdminLayout>
</template>

<script>
import AdminLayout from './AdminLayout.vue'
import apiClient from '../../services/apiClient'

export default {
  name: 'NewsEditForm',
  components: { AdminLayout },
  data() {
    return {
      form: {
        title: '',
        description: '',
        content: '',
        category: 'notice',
        type: 'news',
        published_date: new Date().toISOString().split('T')[0],
        is_featured: false
      },
      loading: false,
      submitting: false,
      error: '',
      success: ''
    }
  },
  computed: {
    isNew() { return !this.$route.params.id || this.$route.params.id === 'new' },
    id() { return this.$route.params.id }
  },
  async mounted() {
    if (!this.isNew) await this.fetch()
  },
  methods: {
    async fetch() {
      this.loading = true
      this.error = ''
      try {
        const res = await apiClient.get(`/api/admin/news-v2/${this.id}`)
        if (res && res.success && res.data && res.data.news) {
          const n = res.data.news
          this.form = {
            title: n.title || '',
            description: n.description || n.excerpt || '',
            content: n.content || '',
            category: n.category || 'notice',
            type: n.type || 'news',
            published_date: (n.published_date || n.published_at || '').split('T')[0] || '',
            is_featured: !!n.is_featured
          }
        } else {
          this.error = 'データ取得に失敗しました'
        }
      } catch (e) {
        this.error = 'データ取得に失敗しました'
        console.error(e)
      } finally {
        this.loading = false
      }
    },
    async handleSubmit() {
      this.submitting = true
      this.error = ''
      this.success = ''
      try {
        const payload = { ...this.form, membership_requirement: 'none' }
        let res
        if (this.isNew) {
          res = await apiClient.post('/api/admin/news-v2', payload)
        } else {
          res = await apiClient.put(`/api/admin/news-v2/${this.id}`, payload)
        }
        if (!res || !res.success) throw new Error(res?.message || '保存に失敗しました')
        this.success = '保存しました'
        setTimeout(() => this.goBack(), 1000)
      } catch (e) {
        this.error = e.message || '保存に失敗しました'
        console.error(e)
      } finally {
        this.submitting = false
      }
    },
    goBack() { this.$router.push('/admin/news') }
  }
}
</script>

<style scoped>
.dashboard { background:#fff; border-radius:8px; overflow:hidden; }
.page-header { display:flex; align-items:center; gap:16px; padding:16px 20px; border-bottom:1px solid #eee; }
.back-btn { background:none; border:none; color:#0066cc; cursor:pointer; }
.page-title { margin:0; font-size:20px; font-weight:600; }
.form-container { padding:20px; max-width:800px; }
.label { display:block; margin:12px 0 6px; font-weight:600; }
.input { width:100%; box-sizing:border-box; padding:10px 12px; border:1px solid #ddd; border-radius:6px; }
.row { display:flex; gap:16px; align-items:flex-end; margin-top:8px; }
.check { padding-bottom:8px; }
.actions { margin-top:20px; display:flex; gap:12px; align-items:center; }
.btn { background:#da5761; color:#fff; border:none; padding:10px 16px; border-radius:6px; cursor:pointer; }
.error { color:#da5761; }
.success { color:#0a7d42; }
</style>

