<template>
  <div class="seminars-tab">
    <div class="filters">
      <select v-model="filters.status" @change="load" class="filter-select">
        <option value="">すべて</option>
        <option value="scheduled">募集中</option>
        <option value="ongoing">開催中</option>
        <option value="completed">終了</option>
      </select>
      <select v-model="filters.year" @change="load" class="filter-select">
        <option value="">年度</option>
        <option v-for="y in years" :key="y" :value="y">{{ y }}</option>
      </select>
      <select v-model="filters.month" @change="load" class="filter-select">
        <option value="">月</option>
        <option v-for="m in 12" :key="m" :value="m">{{ m }}月</option>
      </select>
    </div>
    <div v-if="loading" class="loading">読み込み中...</div>
    <div v-else-if="error" class="error">{{ error }}</div>
    <table v-else class="data-table">
      <thead>
        <tr>
          <th>日付</th>
          <th>タイトル</th>
          <th>会場</th>
          <th>ステータス</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="s in seminars" :key="s.id" :class="{ completed: s.status==='completed' }">
          <td>{{ formatDate(s.date) }}</td>
          <td>{{ s.title }}</td>
          <td>{{ s.location || '-' }}</td>
          <td>{{ statusLabel(s.status) }}</td>
        </tr>
        <tr v-if="seminars.length===0"><td colspan="4" class="empty">該当するセミナーがありません</td></tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import apiClient from '@/services/apiClient.js'

export default {
  name: 'MemberSeminarsTab',
  data() {
    const now = new Date()
    return {
      loading: false,
      error: '',
      seminars: [],
      years: Array.from({length: 6}).map((_,i)=> now.getFullYear()-i),
      filters: { status: 'scheduled', year: '', month: '' }
    }
  },
  mounted() { this.load() },
  methods: {
    async load() {
      this.loading = true
      this.error = ''
      try {
        const res = await apiClient.getMemberSeminars({ ...this.filters, per_page: 20 })
        if (res.success) this.seminars = res.data.seminars || []
        else this.error = res.error || res.message || '読み込みに失敗しました'
      } catch(e) { this.error = '読み込みに失敗しました' } finally { this.loading = false }
    },
    formatDate(d) { return d ? new Date(d).toLocaleDateString('ja-JP') : '-' },
    statusLabel(s) {
      return { scheduled:'募集中', ongoing:'開催中', completed:'終了', cancelled:'中止' }[s] || s
    }
  }
}
</script>

<style scoped>
.filters { display:flex; gap:8px; margin-bottom:12px; }
.filter-select { padding:6px 10px; }
.data-table { width:100%; border-collapse: collapse; }
.data-table th, .data-table td { border-bottom:1px solid #eee; padding:10px; text-align:left; }
.completed { color:#777; background:#fafafa; }
.empty { color:#777; text-align:center; }
.error { color:#da5761; padding:12px 0; }
</style>

