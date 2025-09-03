<template>
  <AdminLayout>
    <div class="dashboard">
      <div class="page-header">
        <h1 class="page-title">メール配信</h1>
      </div>

      <!-- 作成フォーム（簡易版） -->
      <div class="composer">
        <div class="form-row">
          <div class="form-group">
            <label>件名</label>
            <input v-model="form.subject" class="form-input" placeholder="件名" />
          </div>
          <div class="form-group">
            <label>グループ</label>
            <select v-model="form.groups" class="form-select" multiple>
              <option v-for="g in groups" :key="g.id" :value="g.id">{{ g.name }} ({{ g.members_count || 0 }})</option>
            </select>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group full">
            <label>本文（HTML）</label>
            <textarea v-model="form.body_html" class="form-textarea" rows="8" placeholder="HTML本文"></textarea>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group full">
            <label>追加メール（改行区切り）</label>
            <textarea v-model="extraEmailsText" class="form-textarea" rows="4" placeholder="example@example.com"></textarea>
          </div>
        </div>
        <div class="form-actions">
          <button class="save-btn" :disabled="saving" @click="createCampaign">{{ saving ? '作成中...' : 'キャンペーン作成' }}</button>
          <button class="refresh-btn" @click="loadData">再読込</button>
        </div>
      </div>

      <!-- 一覧/操作 -->
      <div class="filters-section">
        <div class="status-filter">
          <label>ステータス</label>
          <select v-model="statusFilter" class="filter-select" @change="loadCampaigns">
            <option value="">すべて</option>
            <option value="draft">下書き</option>
            <option value="scheduled">予約</option>
            <option value="sending">送信中</option>
            <option value="sent">送信済</option>
            <option value="failed">失敗</option>
          </select>
        </div>
      </div>

      <div class="table-container">
        <div v-if="loading" class="loading">読み込み中...</div>
        <div v-else-if="error" class="error">{{ error }}</div>
        <div v-else class="table-wrapper">
          <table class="data-table">
            <thead>
              <tr>
                <th>ID</th>
                <th>件名</th>
                <th>ステータス</th>
                <th>予約時刻</th>
                <th>作成日</th>
                <th>操作</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="c in campaigns" :key="c.id">
                <td>{{ c.id }}</td>
                <td>{{ c.subject }}</td>
                <td>{{ c.status }}</td>
                <td>{{ formatDateTime(c.scheduled_at) }}</td>
                <td>{{ formatDateTime(c.created_at) }}</td>
                <td>
                  <button class="small-btn" @click="preview(c)">プレビュー</button>
                  <button class="small-btn" @click="schedule(c)">予約</button>
                  <button class="small-btn danger" @click="sendNow(c)">即時送信</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <div class="pagination" v-if="pagination.total > pagination.per_page">
        <button v-for="p in paginationPages" :key="p" @click="loadCampaigns(p)" :class="['page-btn', { active: p === pagination.current_page }]">{{ p }}</button>
      </div>
    </div>

    <!-- プレビューモーダル -->
    <div v-if="showPreview" class="modal-overlay" @click="showPreview=false">
      <div class="modal-content" @click.stop>
        <div class="modal-header">
          <h3>プレビュー: {{ previewSubject }}</h3>
          <button class="close-btn" @click="showPreview=false">×</button>
        </div>
        <div class="modal-body">
          <div class="preview-html" v-html="previewHtml"></div>
        </div>
      </div>
    </div>

    <!-- 受信者モーダル -->
    <div v-if="showRecipients" class="modal-overlay" @click="showRecipients=false">
      <div class="modal-content" @click.stop>
        <div class="modal-header">
          <h3>受信者一覧</h3>
          <button class="close-btn" @click="showRecipients=false">×</button>
        </div>
        <div class="modal-body">
          <div class="form-row">
            <select v-model="recipientStatusFilter" class="form-select" @change="loadRecipients()">
              <option value="">すべて</option>
              <option value="pending">pending</option>
              <option value="sent">sent</option>
              <option value="failed">failed</option>
            </select>
            <button class="save-btn" @click="resendFailed">失敗を再送待ちに戻す</button>
          </div>
          <table class="data-table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Member</th>
                <th>Status</th>
                <th>Sent At</th>
                <th>Error</th>
                <th>操作</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="r in recipients" :key="r.id">
                <td>{{ r.id }}</td>
                <td>{{ r.email }}</td>
                <td>{{ r.member_id || '-' }}</td>
                <td>{{ r.status }}</td>
                <td>{{ formatDateTime(r.sent_at) }}</td>
                <td>{{ r.error && r.error.length > 120 ? (r.error.slice(0,120) + '...') : (r.error || '') }}</td>
                <td>
                  <button class="small-btn" :disabled="r.status==='pending'" @click="resendRecipient(r)">再送待ちへ</button>
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
import apiClient from '@/services/apiClient.js'

export default {
  name: 'EmailCampaignManagement',
  components: { AdminLayout },
  data() {
    return {
      loading: false,
      saving: false,
      error: '',
      campaigns: [],
      groups: [],
      pagination: { current_page: 1, last_page: 1, per_page: 20, total: 0 },
      statusFilter: '',
      form: { subject: '', body_html: '', groups: [] },
      extraEmailsText: '',
      showPreview: false,
      previewHtml: '',
      previewSubject: ''
    }
  },
  computed: {
    paginationPages() {
      const pages = []
      const maxShow = 5
      const start = Math.max(1, this.pagination.current_page - Math.floor(maxShow / 2))
      const end = Math.min(this.pagination.last_page, start + maxShow - 1)
      for (let i = start; i <= end; i++) pages.push(i)
      return pages
    }
  },
  mounted() { this.loadData() },
  methods: {
    async loadData() { await Promise.all([this.loadGroups(), this.loadCampaigns()]) },
    async loadGroups() {
      try {
        const res = await apiClient.getMailGroups({ per_page: 100 })
        if (res.success) this.groups = res.data.data || []
      } catch (e) { console.warn('Failed to load groups', e) }
    },
    async loadCampaigns(page = 1) {
      this.loading = true
      this.error = ''
      try {
        const res = await apiClient.getEmailCampaigns({ page, per_page: this.pagination.per_page, status: this.statusFilter })
        if (res.success) {
          const p = res.data
          this.campaigns = p.data || []
          this.pagination = { current_page: p.current_page, last_page: p.last_page, per_page: p.per_page, total: p.total }
        } else { throw new Error(res.error || res.message) }
      } catch (e) { this.error = '読み込みに失敗しました' } finally { this.loading = false }
    },
    emailsFromText() {
      return this.extraEmailsText.split(/\r?\n/).map(s => s.trim()).filter(Boolean)
    },
    async createCampaign() {
      this.saving = true
      try {
        const payload = { ...this.form, extra_emails: this.emailsFromText() }
        const res = await apiClient.createEmailCampaign(payload)
        if (res.success) {
          alert('作成しました')
          this.form = { subject: '', body_html: '', groups: [] }
          this.extraEmailsText = ''
          await this.loadCampaigns(this.pagination.current_page)
        } else { alert(res.error || '作成に失敗しました') }
      } catch (e) { alert('作成に失敗しました') } finally { this.saving = false }
    },
    async preview(c) {
      try {
        const res = await apiClient.previewEmailCampaign(c.id)
        if (res.success) {
          this.previewSubject = c.subject
          this.previewHtml = res.data.body_html || ''
          this.showPreview = true
        }
      } catch (e) { alert('プレビューに失敗しました') }
    },
    async schedule(c) {
      const when = prompt('送信予約日時を入力 (YYYY-MM-DD HH:mm:ss)')
      if (!when) return
      try {
        const res = await apiClient.scheduleEmailCampaign(c.id, when)
        if (res.success) { alert('予約しました'); this.loadCampaigns(this.pagination.current_page) }
      } catch (e) { alert('予約に失敗しました') }
    },
    async sendNow(c) {
      if (!confirm('今すぐ送信しますか？')) return
      try {
        const res = await apiClient.sendEmailCampaignNow(c.id)
        if (res.success) { alert('送信しました'); this.loadCampaigns(this.pagination.current_page) }
        else alert(res.error || '送信に失敗しました')
      } catch (e) { alert('送信に失敗しました') }
    },
    formatDateTime(s) { return s ? new Date(s).toLocaleString('ja-JP') : '-' }
  }
}
</script>

<style scoped>
.dashboard { background: white; border-radius: 8px; overflow: hidden; }
.page-header { display: flex; justify-content: space-between; align-items: center; padding: 20px 24px; border-bottom: 1px solid #e5e5e5; }
.page-title { font-size: 24px; font-weight: 600; }
.composer { padding: 16px 24px; border-bottom: 1px solid #e5e5e5; }
.form-row { display: flex; gap: 16px; margin-bottom: 12px; }
.form-group { flex: 1; }
.form-group.full { flex: 1 1 100%; }
.form-input, .form-select, .form-textarea { width: 100%; padding: 8px 12px; border: 1px solid #d0d0d0; border-radius: 4px; }
.form-actions { display: flex; gap: 12px; }
.save-btn { padding: 8px 16px; border: 1px solid #28a745; background: #28a745; color: white; border-radius: 4px; }
.refresh-btn { padding: 8px 16px; border: 1px solid #007bff; background: #007bff; color: white; border-radius: 4px; }
.filters-section { padding: 16px 24px; display: flex; gap: 16px; align-items: center; border-bottom: 1px solid #e5e5e5; }
.filter-select { padding: 8px 12px; border: 1px solid #d0d0d0; border-radius: 4px; }
.table-container { overflow-x: auto; }
.loading, .error { padding: 40px; text-align: center; }
.error { color: #da5761; }
.data-table { width: 100%; border-collapse: collapse; }
.data-table th, .data-table td { border-bottom: 1px solid #e5e5e5; padding: 12px 16px; text-align: left; }
.small-btn { padding: 6px 10px; border: 1px solid #ccc; border-radius: 4px; background: white; cursor: pointer; margin-right: 6px; }
.small-btn.danger { border-color: #dc3545; color: #dc3545; }
.modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.4); display: flex; justify-content: center; align-items: center; }
.modal-content { background: white; border-radius: 8px; width: 720px; max-width: 95%; overflow: hidden; }
.modal-header { display: flex; justify-content: space-between; align-items: center; padding: 16px 20px; border-bottom: 1px solid #eee; }
.modal-body { padding: 16px 20px; }
.close-btn { background: none; border: none; font-size: 20px; cursor: pointer; color: #666; }
.preview-html { border: 1px solid #eee; padding: 12px; border-radius: 6px; background: #fafafa; min-height: 200px; }
</style>
