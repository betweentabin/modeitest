<template>
  <AdminLayout>
    <div class="cms">
      <div class="pane left">
        <div class="toolbar">
          <input v-model="search" class="input" placeholder="ページ検索" @keyup.enter="loadPages" />
          <button class="btn" @click="openCreate">新規</button>
        </div>
        <div class="list">
          <div v-for="p in pages" :key="p.id" :class="['item',{active: currentPage && currentPage.id===p.id}]" @click="selectPage(p)">
            <div class="title">{{ p.title }}</div>
            <div class="slug">/{{ p.slug }}</div>
          </div>
        </div>
      </div>
      <div class="pane center">
        <div class="preview-header">
          <div class="info">プレビュー: {{ currentPage ? currentPage.title : '-' }}</div>
          <div class="actions">
            <button class="btn" :disabled="!currentPage" @click="publish">公開</button>
          </div>
        </div>
        <div class="preview">
          <iframe v-if="currentPage" :srcdoc="renderPreviewHtml()" class="frame"></iframe>
          <div v-else class="empty">ページを選択してください</div>
        </div>
      </div>
      <div class="pane right">
        <div v-if="currentPage" class="editor">
          <div class="field">
            <label>タイトル</label>
            <input v-model="currentPage.title" class="input" @change="savePageMeta" />
          </div>
          <div class="field">
            <label>Hero見出し</label>
            <input v-model="hero.title" class="input" @change="saveHero" />
          </div>
          <div class="field">
            <label>本文（HTML）</label>
            <textarea v-model="richText.html" class="textarea" rows="6" @change="saveRich"></textarea>
          </div>
          <div class="field" v-if="warnings && warnings.length">
            <label>警告</label>
            <ul style="margin:0; padding-left:18px; color:#b45309;">
              <li v-for="w in warnings" :key="w">{{ w }}</li>
            </ul>
          </div>
        </div>
        <div v-else class="empty">右側で編集ができます</div>
      </div>
    </div>

    <!-- Create modal -->
    <div v-if="showCreate" class="modal" @click="showCreate=false">
      <div class="modal-inner" @click.stop>
        <h3>新規ページ</h3>
        <div class="field"><label>Slug</label><input v-model="createForm.slug" class="input" placeholder="about, terms など"/></div>
        <div class="field"><label>タイトル</label><input v-model="createForm.title" class="input"/></div>
        <div class="actions"><button class="btn" @click="create">作成</button></div>
      </div>
    </div>
  </AdminLayout>
  
</template>

<script>
import AdminLayout from './AdminLayout.vue'
import apiClient from '@/services/apiClient'

export default {
  name: 'BlockCmsEditor',
  components: { AdminLayout },
  data(){
    return {
      pages: [],
      search: '',
      currentPage: null,
      sections: [],
      hero: { title: '' },
      richText: { html: '' },
      warnings: [],
      showCreate: false,
      createForm: { slug: '', title: '' },
    }
  },
  mounted(){ this.loadPages() },
  methods: {
    async loadPages(){
      const res = await apiClient.listCmsPages({ search: this.search, per_page: 100 })
      if (res.success) this.pages = res.data.data || []
    },
    async selectPage(p){
      const res = await apiClient.getCmsPage(p.id)
      if (res.success){
        this.currentPage = res.data
        // very small mapping to two demo sections: hero (sort 10) and rich (sort 20)
        const secs = (res.data.sections||[])
        const hero = secs.find(s=>s.sort===10) || { id: 'hero', sort: 10, component_type:'Hero', props_json:{ title: '' } }
        const rich = secs.find(s=>s.sort===20) || { id: 'rich', sort: 20, component_type:'RichText', props_json:{ html: '' } }
        this.hero = { title: (hero.props_json&&hero.props_json.title)||'' }
        this.richText = { html: (rich.props_json&&rich.props_json.html)||'' }
        this.collectWarnings([hero, rich])
      }
    },
    collectWarnings(sections){
      const warn = []
      const expected = {
        'Hero': new Set(['title']),
        'RichText': new Set(['html'])
      }
      for (const s of sections){
        if (!s || !s.component_type) continue
        const props = (s.props_json && typeof s.props_json === 'object') ? Object.keys(s.props_json) : []
        const ex = expected[s.component_type]
        if (ex){
          for (const k of props){ if (!ex.has(k)) warn.push(`${s.component_type}: 未対応キー「${k}」`) }
        } else {
          warn.push(`未対応ブロック: ${s.component_type}`)
        }
      }
      this.warnings = warn
    },
    renderPreviewHtml(){
      const h = this.hero.title ? `<section><h1>${this.escape(this.hero.title)}</h1></section>` : ''
      const r = this.richText.html ? `<section>${this.richText.html}</section>` : ''
      return `<!doctype html><html><head><meta charset='utf-8'><style>body{font-family:sans-serif;padding:16px;}section{margin:16px 0;}h1{font-size:24px;}</style></head><body>${h}${r}</body></html>`
    },
    escape(s){ return (s||'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;') },
    async savePageMeta(){ if (!this.currentPage) return; await apiClient.updateCmsPage(this.currentPage.id, { title: this.currentPage.title }) },
    async saveHero(){ if (!this.currentPage) return; await apiClient.upsertCmsSection(this.currentPage.id, 'hero', { sort:10, component_type:'Hero', props_json:{ title: this.hero.title }, status:'draft' }) },
    async saveRich(){ if (!this.currentPage) return; await apiClient.upsertCmsSection(this.currentPage.id, 'rich', { sort:20, component_type:'RichText', props_json:{ html: this.richText.html }, status:'draft' }) },
    async publish(){ if (!this.currentPage) return; const res = await apiClient.publishCmsPage(this.currentPage.id); if (res.success) alert('公開しました') },
    openCreate(){ this.showCreate = true },
    async create(){
      if (!this.createForm.slug || !this.createForm.title) return
      const res = await apiClient.createCmsPage({ ...this.createForm })
      if (res.success){ this.showCreate=false; this.createForm={slug:'', title:''}; await this.loadPages(); this.selectPage(res.data) }
    }
  }
}
</script>

<style scoped>
.cms{ display:flex; gap:0; height: calc(100vh - 140px); background:#fff; border-radius:8px; overflow:hidden; }
.pane{ border-right:1px solid #eee; }
.left{ width:280px; }
.center{ flex:1; }
.right{ width:360px; }
.toolbar{ display:flex; gap:8px; padding:10px; border-bottom:1px solid #eee; }
.list{ overflow:auto; height: calc(100% - 50px); }
.item{ padding:10px 12px; border-bottom:1px solid #f4f4f4; cursor:pointer; }
.item.active{ background:#fff2f4; }
.title{ font-weight:600; }
.slug{ color:#777; font-size:12px; }
.preview-header{ display:flex; justify-content:space-between; align-items:center; padding:8px 12px; border-bottom:1px solid #eee; }
.preview{ height: calc(100% - 45px); }
.frame{ width:100%; height:100%; border:0; background:#fff; }
.editor{ padding:12px; }
.field{ margin-bottom:12px; display:flex; flex-direction:column; gap:6px; }
.input, .textarea{ border:1px solid #ddd; border-radius:6px; padding:8px 10px; }
.btn{ background:#1A1A1A; color:#fff; border:none; border-radius:6px; padding:8px 12px; cursor:pointer; }
.empty{ padding:16px; color:#777; }
.modal{ position:fixed; inset:0; background:rgba(0,0,0,0.4); display:flex; align-items:center; justify-content:center; }
.modal-inner{ background:#fff; border-radius:8px; padding:16px; width:360px; display:flex; flex-direction:column; gap:10px; }
.actions{ display:flex; justify-content:flex-end; }
</style>
