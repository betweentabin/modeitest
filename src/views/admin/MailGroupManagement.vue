<template>
  <AdminLayout>
    <div class="dashboard">
      <div class="page-header">
        <h1 class="page-title">メールグループ管理</h1>
        <div class="header-actions">
          <button class="add-btn" @click="openCreateModal">新規グループ</button>
        </div>
      </div>

      <div class="filters-section">
        <div class="search-filter">
          <input v-model="search" class="search-input" placeholder="グループ名で検索..." @keyup.enter="loadGroups" />
        </div>
        <button class="refresh-btn" @click="loadGroups" :disabled="loading">{{ loading ? '更新中...' : '更新' }}</button>
      </div>

      <div class="table-container">
        <div v-if="loading" class="loading">読み込み中...</div>
        <div v-else-if="error" class="error">{{ error }}</div>
        <div v-else class="table-wrapper">
          <table class="data-table">
            <thead>
              <tr>
                <th>ID</th>
                <th>グループ名</th>
                <th>説明</th>
                <th>メンバー数</th>
                <th>作成日</th>
                <th>操作</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="g in groups" :key="g.id">
                <td>{{ g.id }}</td>
                <td>{{ g.name }}</td>
                <td class="desc">{{ g.description }}</td>
                <td>{{ g.members_count || 0 }}</td>
                <td>{{ formatDate(g.created_at) }}</td>
                <td>
                  <button class="small-btn" @click="openMembersModal(g)">メンバー</button>
                  <button class="small-btn danger" @click="deleteGroup(g)">削除</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <div class="pagination" v-if="pagination.total > pagination.per_page">
        <button v-for="p in paginationPages" :key="p" @click="loadGroups(p)" :class="['page-btn', { active: p === pagination.current_page }]">{{ p }}</button>
      </div>
    </div>

    <!-- Create Modal -->
    <div v-if="showCreate" class="modal-overlay" @click="showCreate=false">
      <div class="modal-content" @click.stop>
        <div class="modal-header">
          <h3>新規グループ</h3>
          <button class="close-btn" @click="showCreate=false">×</button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>グループ名</label>
            <input v-model="createForm.name" class="form-input" />
          </div>
          <div class="form-group">
            <label>説明</label>
            <textarea v-model="createForm.description" class="form-textarea" rows="3"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button class="cancel-btn" @click="showCreate=false">キャンセル</button>
          <button class="save-btn" :disabled="saving" @click="createGroup">{{ saving ? '作成中...' : '作成' }}</button>
        </div>
      </div>
    </div>

    <!-- Members Modal -->
    <div v-if="showMembers" class="modal-overlay" @click="closeMembersModal">
      <div class="modal-content large" @click.stop>
        <div class="modal-header">
          <h3>メンバー編集: {{ currentGroup?.name }}</h3>
          <button class="close-btn" @click="closeMembersModal">×</button>
        </div>
        <div class="modal-body">
          <p>メンバーIDをカンマ区切りで入力（例: 1,2,3）</p>
          <textarea v-model="memberIdsText" class="form-textarea" rows="5"></textarea>
          <div class="form-row">
            <button class="save-btn" :disabled="memberSaving" @click="bulkMembers('add')">追加</button>
            <button class="cancel-btn" :disabled="memberSaving" @click="bulkMembers('remove')">削除</button>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script>
import AdminLayout from './AdminLayout.vue'
import apiClient from '@/services/apiClient.js'

export default {
  name: 'MailGroupManagement',
  components: { AdminLayout },
  data() {
    return {
      loading: false,
      saving: false,
      memberSaving: false,
      error: '',
      search: '',
      groups: [],
      pagination: { current_page: 1, last_page: 1, per_page: 20, total: 0 },
      showCreate: false,
      createForm: { name: '', description: '' },
      showMembers: false,
      currentGroup: null,
      memberIdsText: ''
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
  mounted() {
    this.loadGroups()
  },
  methods: {
    formatDate(s) { return s ? new Date(s).toLocaleDateString('ja-JP') : '-' },
    async loadGroups(page = 1) {
      this.loading = true
      this.error = ''
      try {
        const res = await apiClient.getMailGroups({ page, per_page: this.pagination.per_page, search: this.search })
        if (res.success) {
          const p = res.data
          this.groups = p.data || []
          this.pagination = { current_page: p.current_page, last_page: p.last_page, per_page: p.per_page, total: p.total }
        } else {
          throw new Error(res.error || res.message)
        }
      } catch (e) {
        this.error = '読み込みに失敗しました'
        console.error(e)
      } finally { this.loading = false }
    },
    openCreateModal() { this.showCreate = true },
    async createGroup() {
      this.saving = true
      try {
        const res = await apiClient.createMailGroup(this.createForm)
        if (res.success) {
          this.showCreate = false
          this.createForm = { name: '', description: '' }
          this.loadGroups(this.pagination.current_page)
        } else { alert(res.error || '作成に失敗しました') }
      } catch (e) { alert('作成に失敗しました') } finally { this.saving = false }
    },
    async deleteGroup(group) {
      if (!confirm(`グループ「${group.name}」を削除しますか？`)) return
      try {
        const res = await apiClient.deleteMailGroup(group.id)
        if (res.success) this.loadGroups(this.pagination.current_page)
        else alert(res.error || '削除に失敗しました')
      } catch (e) { alert('削除に失敗しました') }
    },
    openMembersModal(group) { this.currentGroup = group; this.memberIdsText = ''; this.showMembers = true },
    closeMembersModal() { this.showMembers = false; this.currentGroup = null },
    async bulkMembers(action) {
      if (!this.currentGroup) return
      this.memberSaving = true
      try {
        const ids = this.memberIdsText.split(',').map(s => parseInt(s.trim(), 10)).filter(n => !isNaN(n))
        if (ids.length === 0) { alert('メンバーIDを入力してください'); return }
        const res = await apiClient.bulkEditMailGroupMembers(this.currentGroup.id, action, ids)
        if (res.success) { alert('更新しました'); this.loadGroups(this.pagination.current_page) }
        else alert(res.error || '更新に失敗しました')
      } catch (e) { alert('更新に失敗しました') } finally { this.memberSaving = false }
    }
  }
}
</script>

<style scoped>
.dashboard { background: white; border-radius: 8px; overflow: hidden; }
.page-header { display: flex; justify-content: space-between; align-items: center; padding: 20px 24px; border-bottom: 1px solid #e5e5e5; }
.page-title { font-size: 24px; font-weight: 600; }
.header-actions { display: flex; gap: 12px; }
.add-btn, .refresh-btn { padding: 8px 16px; border: none; border-radius: 4px; background: #007bff; color: white; cursor: pointer; }
.filters-section { padding: 16px 24px; border-bottom: 1px solid #e5e5e5; display: flex; gap: 12px; align-items: center; }
.search-input { padding: 8px 12px; border: 1px solid #d0d0d0; border-radius: 4px; }
.table-container { overflow-x: auto; }
.loading, .error { padding: 40px; text-align: center; }
.error { color: #da5761; }
.data-table { width: 100%; border-collapse: collapse; }
.data-table th, .data-table td { border-bottom: 1px solid #e5e5e5; padding: 12px 16px; text-align: left; }
.desc { max-width: 420px; color: #555; }
.small-btn { padding: 6px 10px; border: 1px solid #ccc; border-radius: 4px; background: white; cursor: pointer; margin-right: 6px; }
.small-btn.danger { border-color: #dc3545; color: #dc3545; }
.pagination { padding: 16px 24px; }
.page-btn { margin-right: 6px; padding: 6px 10px; }
.modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.4); display: flex; justify-content: center; align-items: center; }
.modal-content { background: white; border-radius: 8px; width: 560px; max-width: 95%; overflow: hidden; }
.modal-content.large { width: 720px; }
.modal-header { display: flex; justify-content: space-between; align-items: center; padding: 16px 20px; border-bottom: 1px solid #eee; }
.modal-body { padding: 16px 20px; }
.modal-footer { padding: 12px 20px; display: flex; justify-content: flex-end; gap: 8px; border-top: 1px solid #eee; }
.close-btn { background: none; border: none; font-size: 20px; cursor: pointer; color: #666; }
.form-group { margin-bottom: 12px; }
.form-input, .form-textarea { width: 100%; padding: 8px 12px; border: 1px solid #d0d0d0; border-radius: 4px; }
.cancel-btn { padding: 8px 16px; border: 1px solid #6c757d; border-radius: 4px; background: white; color: #6c757d; }
.save-btn { padding: 8px 16px; border: 1px solid #28a745; border-radius: 4px; background: #28a745; color: white; }
</style>

