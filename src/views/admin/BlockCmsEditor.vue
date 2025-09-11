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
        <div v-if="currentPage" class="editor-form">
          <div class="field">
            <label>KV画像</label>
            <div class="kv-uploader" @click="selectKvFile">
              <input ref="kvInput" type="file" accept="image/*" style="display:none" @change="onKvSelected" />
              <div v-if="kv.previewUrl" class="kv-preview" :style="{backgroundImage: `url(${kv.previewUrl})`}"></div>
              <div v-else class="kv-placeholder">
                <span class="kv-icon">🖼</span>
                <span>アップロードファイル</span>
              </div>
            </div>
            <div class="help">推奨比率 16:9（md/lgプリセットで自動リサイズ配信）</div>
          </div>

          <div class="field">
            <label>ページタイトル</label>
            <input v-model="currentPage.title" class="input" @change="savePageMeta" />
          </div>

          <div class="section-title">コンテンツ</div>
          <div class="field">
            <label>エディター</label>
            <textarea v-model="richText.html" class="textarea" rows="18" @change="saveRich"></textarea>
          </div>
          <div class="field">
            <label>本文用画像</label>
            <div style="display:flex; gap:8px; align-items:center;">
              <input ref="contentImgInput" type="file" accept="image/*" style="display:none" @change="onContentImageSelected" />
              <button class="btn" @click="selectContentImage">画像を選択</button>
              <button class="btn" @click="insertLastContentImage" :disabled="!lastContentImgUrl">本文に画像を追加</button>
              <span class="help" v-if="lastContentImgUrl">準備済み: {{ lastContentImgUrl }}</span>
            </div>
          </div>

          <div v-if="currentPage" class="section-title">子コンポーネント文言（基本）</div>
          <div v-if="currentPage" class="field">
            <label>ページタイトル（見出し）</label>
            <input v-model="privacyTexts.page_title" class="input" />
          </div>
          <div v-if="currentPage" class="field">
            <label>サブタイトル</label>
            <input v-model="privacyTexts.page_subtitle" class="input" />
          </div>
          <div v-if="currentPage" class="field">
            <label>導入文</label>
            <textarea v-model="privacyTexts.intro" class="textarea" rows="4"></textarea>
          </div>
          <div v-if="currentPage" class="actions" style="justify-content:flex-start; gap:8px;">
            <button class="btn" @click="savePrivacyTexts">文言を保存（PageContent）</button>
            <span class="help">ページ内のCmsTextに反映（公開デザインはそのまま）</span>
          </div>

          <!-- privacy-policy: section-wise fields -->
          <div v-if="currentPage.slug==='privacy-policy'" class="section-title">セクション別文言</div>
          <!-- 1. 収集 -->
          <div v-if="currentPage.slug==='privacy-policy'" class="field">
            <label>1. 個人情報の収集（見出し）</label>
            <input v-model="privacyTexts.collection_title" class="input" />
          </div>
          <div v-if="currentPage.slug==='privacy-policy'" class="field">
            <label>1. 個人情報の収集（本文）</label>
            <textarea v-model="privacyTexts.collection_body" class="textarea" rows="4"></textarea>
          </div>
          <!-- 2. 利用目的 -->
          <div v-if="currentPage.slug==='privacy-policy'" class="field">
            <label>2. 個人情報の利用目的（見出し）</label>
            <input v-model="privacyTexts.purpose_title" class="input" />
          </div>
          <div v-if="currentPage.slug==='privacy-policy'" class="field">
            <label>2. 個人情報の利用目的（導入文）</label>
            <textarea v-model="privacyTexts.purpose_intro" class="textarea" rows="3"></textarea>
          </div>
          <div v-if="currentPage.slug==='privacy-policy'" class="field">
            <label>2. 個人情報の利用目的（リストHTML）</label>
            <textarea v-model="privacyTexts.purpose_list" class="textarea" rows="5" placeholder="<ul>は不要。<br>区切りで入力"></textarea>
          </div>
          <!-- 3. 第三者提供 -->
          <div v-if="currentPage.slug==='privacy-policy'" class="field">
            <label>3. 個人情報の第三者提供（見出し）</label>
            <input v-model="privacyTexts.disclosure_title" class="input" />
          </div>
          <div v-if="currentPage.slug==='privacy-policy'" class="field">
            <label>3. 個人情報の第三者提供（リストHTML）</label>
            <textarea v-model="privacyTexts.disclosure_list" class="textarea" rows="5"></textarea>
          </div>
          <!-- 4. 開示・訂正・削除 -->
          <div v-if="currentPage.slug==='privacy-policy'" class="field">
            <label>4. 個人情報の開示・訂正・削除（見出し）</label>
            <input v-model="privacyTexts.correction_title" class="input" />
          </div>
          <div v-if="currentPage.slug==='privacy-policy'" class="field">
            <label>4. 個人情報の開示・訂正・削除（本文HTML）</label>
            <textarea v-model="privacyTexts.correction_body" class="textarea" rows="5"></textarea>
          </div>
          <!-- 免責 -->
          <div v-if="currentPage.slug==='privacy-policy'" class="field">
            <label>免責事項（見出し）</label>
            <input v-model="privacyTexts.disclaimer_title" class="input" />
          </div>
          <div v-if="currentPage.slug==='privacy-policy'" class="field">
            <label>免責事項（本文1）</label>
            <textarea v-model="privacyTexts.disclaimer_body1" class="textarea" rows="3"></textarea>
          </div>
          <div v-if="currentPage.slug==='privacy-policy'" class="field">
            <label>免責事項（本文2）</label>
            <textarea v-model="privacyTexts.disclaimer_body2" class="textarea" rows="3"></textarea>
          </div>
          <div v-if="currentPage.slug==='privacy-policy'" class="field">
            <label>免責事項（本文3）</label>
            <textarea v-model="privacyTexts.disclaimer_body3" class="textarea" rows="3"></textarea>
          </div>
          <!-- 変更告知 -->
          <div v-if="currentPage.slug==='privacy-policy'" class="field">
            <label>プライバシーポリシーの変更（見出し）</label>
            <input v-model="privacyTexts.changes_title" class="input" />
          </div>
          <div v-if="currentPage.slug==='privacy-policy'" class="field">
            <label>プライバシーポリシーの変更（本文）</label>
            <textarea v-model="privacyTexts.changes_body" class="textarea" rows="3"></textarea>
          </div>

          <div class="actions-row">
            <button class="btn primary" :disabled="!currentPage" @click="publish">公開する</button>
            <button class="btn" :disabled="!currentPage" @click="unpublish">公開を停止する</button>
            <button class="btn" :disabled="!currentPage" @click="issuePreview">プレビューリンク</button>
            <a v-if="previewUrl" :href="previewUrl" target="_blank" rel="noopener" class="btn">開く</a>
          </div>

          <div v-if="currentPage" class="actions-row" style="margin-top:8px;">
            <button class="btn" @click="importExistingPrivacy">既存文言を取り込む</button>
            <button class="btn" @click="syncRichToPageContentHtml">本文をPageContentに同期</button>
          </div>
          <div v-if="currentPage" class="field" style="margin-top:8px;">
            <label>PageContentのページキー（必要に応じて変更）</label>
            <input v-model="pageContentKey" class="input" placeholder="privacy / privacy-poricy など" />
            <div class="help">取り込み/保存はこのキーで行います</div>
          </div>
        </div>
        <div v-else class="empty">ページを選択してください</div>
      </div>
      <div class="pane right" style="display:none"></div>
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
import { getApiUrl } from '@/config/api.js'

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
      previewUrl: '',
      kv: { id:'', ext:'', previewUrl:'' },
      lastContentImgUrl: '',
      privacyTexts: {
        page_title: '', page_subtitle: '', intro: '',
        collection_title: '', collection_body: '',
        purpose_title: '', purpose_intro: '', purpose_list: '',
        disclosure_title: '', disclosure_list: '',
        correction_title: '', correction_body: '',
        disclaimer_title: '', disclaimer_body1: '', disclaimer_body2: '', disclaimer_body3: '',
        changes_title: '', changes_body: '',
      },
      // PageContent(CmsText) 側のキー。ページ選択時に推定（UIで変更可）
      pageContentKey: 'privacy',
    }
  },
  mounted(){ this.loadPages() },
  methods: {
    async loadPages(){
      const res = await apiClient.listCmsPages({ search: this.search, per_page: 100 })
      if (res.success) this.pages = res.data.data || []
      // auto-select by route param or query
      const slug = this.$route.params.slug || this.$route.query.slug
      if (slug) {
        const match = (this.pages || []).find(p => p.slug === slug)
        if (match) { await this.selectPage(match) }
        else {
          // If not exists, prefill create modal with slug
          this.createForm.slug = slug
          this.createForm.title = slug
          this.showCreate = true
        }
      }
    },
    async selectPage(p){
      const res = await apiClient.getCmsPage(p.id)
      if (res.success){
        this.currentPage = res.data
        // very small mapping to two demo sections: hero (sort 10) and rich (sort 20)
        const secs = (res.data.sections||[])
        const hero = secs.find(s=>s.sort===10) || { id: 'hero', sort: 10, component_type:'Hero', props_json:{ title: '' } }
        const kv = secs.find(s=>s.sort===15) || { id: 'kv', sort: 15, component_type:'KV', props_json:{ image_id:'', ext:'' } }
        const rich = secs.find(s=>s.sort===20) || { id: 'rich', sort: 20, component_type:'RichText', props_json:{ html: '' } }
        this.hero = { title: (hero.props_json&&hero.props_json.title)||'' }
        this.kv = { id: (kv.props_json&&kv.props_json.image_id)||'', ext:(kv.props_json&&kv.props_json.ext)||'', previewUrl: this.kvPreviewFromProps((kv.props_json||{})) }
        this.richText = { html: (rich.props_json&&rich.props_json.html)||'' }
        this.collectWarnings([hero, rich])
        // 推奨のPageContentキーを推定
        const slug = (this.currentPage.slug || '').toLowerCase()
        if (slug.includes('privacy')) this.pageContentKey = 'privacy'
        else if (slug.includes('legal') || slug.includes('transaction')) this.pageContentKey = 'transaction-law'
        else if (slug.includes('terms')) this.pageContentKey = 'terms'

        // 既存テキストの読み込み
        try {
          const page = await apiClient.adminGetPageContent(this.pageContentKey)
          const content = page?.data?.page?.content || {}
          const texts = content.texts || {}
          const keys = Object.keys(this.privacyTexts)
          for (const k of keys) {
            if (Object.prototype.hasOwnProperty.call(texts, k) && typeof texts[k] === 'string') {
              this.privacyTexts[k] = texts[k]
            }
          }
          if (!this.privacyTexts.page_title) this.privacyTexts.page_title = this.currentPage.title || ''
        } catch(_) { /* noop */ }
      }
    },
    kvPreviewFromProps(props){
      if (!props || !props.image_id || !props.ext) return ''
      return getApiUrl(`/api/public/m/${encodeURIComponent(props.image_id)}/md.${encodeURIComponent(props.ext)}`)
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
    async publish(){
      if (!this.currentPage) return
      const res = await apiClient.publishCmsPage(this.currentPage.id)
      if (res.success) {
        try { await apiClient.setCmsOverride({ slug: this.currentPage.slug, page_id: this.currentPage.id, enabled: true }) } catch(_){ /* ignore */ }
        alert('公開しました（オーバーライドON）')
      }
    },
    async unpublish(){
      if (!this.currentPage) return
      try {
        const res = await apiClient.setCmsOverride({ slug: this.currentPage.slug, page_id: this.currentPage.id, enabled: false })
        if (res.success) alert('公開を停止しました（オーバーライドOFF）')
      } catch(_){ alert('公開停止に失敗しました') }
    },
    async issuePreview(){
      if (!this.currentPage) return
      try{
        const tok = await apiClient.issueCmsPreviewToken(this.currentPage.id)
        if (tok.success) {
          const t = tok.data.token
          const slug = tok.data.slug
          this.previewUrl = getApiUrl(`/api/public/pages-v2/${encodeURIComponent(slug)}/preview?token=${encodeURIComponent(t)}`)
          alert('プレビューリンクを作成しました。開くボタンで確認できます。')
        }
      }catch(_){ alert('プレビューリンクの作成に失敗しました') }
    },
    selectKvFile(){ this.$refs.kvInput && this.$refs.kvInput.click() },
    async onKvSelected(e){
      const f = (e.target.files && e.target.files[0]) || null
      if (!f || !this.currentPage) return
      try{
        const up = await apiClient.uploadCmsMedia(f)
        if (up && up.success){
          const id = up.data.id
          const mime = (up.data.mime||'').toLowerCase()
          const ext = mime.includes('png')? 'png' : mime.includes('webp')? 'webp' : mime.includes('gif')? 'gif' : 'jpg'
          await apiClient.upsertCmsSection(this.currentPage.id, 'kv', { sort:15, component_type:'KV', props_json:{ image_id:id, ext }, status:'draft' })
          this.kv = { id, ext, previewUrl: getApiUrl(`/api/public/m/${encodeURIComponent(id)}/md.${encodeURIComponent(ext)}`) }
        } else {
          alert('画像アップロードに失敗しました')
        }
      } catch(_){ alert('画像アップロードに失敗しました') }
    },
    selectContentImage(){ this.$refs.contentImgInput && this.$refs.contentImgInput.click() },
    async onContentImageSelected(e){
      const f = (e.target.files && e.target.files[0]) || null
      if (!f || !this.currentPage) return
      try{
        const up = await apiClient.uploadCmsMedia(f)
        if (up && up.success){
          const id = up.data.id
          const mime = (up.data.mime||'').toLowerCase()
          const ext = mime.includes('png')? 'png' : mime.includes('webp')? 'webp' : mime.includes('gif')? 'gif' : 'jpg'
          const url = getApiUrl(`/api/public/m/${encodeURIComponent(id)}/md.${encodeURIComponent(ext)}`)
          this.lastContentImgUrl = url
        } else {
          alert('画像アップロードに失敗しました')
        }
      } catch(_){ alert('画像アップロードに失敗しました') }
    },
    insertLastContentImage(){
      if (!this.lastContentImgUrl) return
      const html = this.richText.html || ''
      this.richText.html = `${html}\n<p><img src="${this.lastContentImgUrl}" alt=""></p>`
      this.lastContentImgUrl = ''
    },
    async importExistingPrivacy(){
      try {
        // 候補キーを順に探索（UIで指定→ privacy → privacy-poricy → privacy-policy → privacy poricy）
        const candidates = [this.pageContentKey, 'privacy', 'privacy-poricy', 'privacy-policy', 'privacy poricy']
        let foundKey = null
        let res = null
        for (const k of candidates) {
          try {
            const r = await apiClient.adminGetPageContent(k)
            if (r && r.success && r.data && r.data.page) { res = r; foundKey = k; break }
          } catch(_) { /* try next */ }
        }
        // 無ければ既定キーで初期作成
        if (!res || !foundKey) {
          foundKey = this.pageContentKey
          await apiClient.post('/api/admin/pages', {
            page_key: foundKey,
            title: 'プライバシーポリシー',
            content: { html: '', texts: { page_title: 'プライバシーポリシー', page_subtitle: 'privacy policy', intro: '' } },
            is_published: true
          })
          res = await apiClient.adminGetPageContent(foundKey)
        }
        // 採用キーを記録
        this.pageContentKey = foundKey
        const content = res?.data?.page?.content || {}
        const texts = content.texts || {}
        // Prefer content.html; fallback to content.htmls.body if html is empty
        const htmls = (content && content.htmls) || {}
        const bodyHtml = (typeof htmls?.body === 'string') ? htmls.body : ''
        const html = (typeof content?.html === 'string' && content.html.trim()) ? content.html : bodyHtml
        if (typeof html === 'string') {
          this.richText.html = html
        }
        // set known fields if present
        const keys = Object.keys(this.privacyTexts)
        for (const k of keys) {
          if (Object.prototype.hasOwnProperty.call(texts, k) && typeof texts[k] === 'string') {
            this.privacyTexts[k] = texts[k]
          }
        }
        alert('既存の文言を取り込みました')
      } catch (e) {
        console.warn('importExistingPrivacy failed', e)
        alert('取り込みに失敗しました')
      }
    },
    async syncRichToPageContentHtml(){
      try {
        const html = this.richText.html || ''
        // Sync to both html and htmls.body for backward compatibility
        const patch = { content: { html, htmls: { body: html } } }
        const res = await apiClient.adminUpdatePageContent(this.pageContentKey, patch)
        if (res) alert('PageContentに本文を同期しました')
      } catch (e) {
        alert('同期に失敗しました')
      }
    },
    async savePrivacyTexts(){
      try {
        const patch = { content: { texts: { ...this.privacyTexts } } }
        const res = await apiClient.adminUpdatePageContent(this.pageContentKey, patch)
        if (res) alert('保存しました')
      } catch(_) { alert('保存に失敗しました') }
    },
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
.cms{ display:flex; gap:0; min-height: calc(100vh - 140px); background:#fff; border-radius:8px; overflow:hidden; }
.pane{ border-right:1px solid #eee; }
.left{ width:280px; }
.center{ flex:1; padding:16px; }
.right{ width:360px; }
.toolbar{ display:flex; gap:8px; padding:10px; border-bottom:1px solid #eee; }
.list{ overflow:auto; height: calc(100% - 50px); }
.item{ padding:10px 12px; border-bottom:1px solid #f4f4f4; cursor:pointer; }
.item.active{ background:#fff2f4; }
.title{ font-weight:600; }
.slug{ color:#777; font-size:12px; }
.editor-form{ max-width: 860px; margin: 0 auto; }
.field{ margin-bottom:12px; display:flex; flex-direction:column; gap:6px; }
.input, .textarea{ border:1px solid #ddd; border-radius:6px; padding:8px 10px; }
.btn{ background:#1A1A1A; color:#fff; border:none; border-radius:6px; padding:8px 12px; cursor:pointer; }
.btn.primary{ background:#DA5761; }
.empty{ padding:16px; color:#777; }
.modal{ position:fixed; inset:0; background:rgba(0,0,0,0.4); display:flex; align-items:center; justify-content:center; }
.modal-inner{ background:#fff; border-radius:8px; padding:16px; width:360px; display:flex; flex-direction:column; gap:10px; }
.actions{ display:flex; justify-content:flex-end; }
.actions-row{ display:flex; gap:8px; justify-content:center; padding-top:8px; }
.section-title{ background:#e6f0ff; color:#1a3a7c; padding:6px 10px; border-left:4px solid #2d5bd1; margin:10px 0; font-weight:600; }
.kv-uploader{ border:1px dashed #bbb; border-radius:8px; height:160px; display:flex; align-items:center; justify-content:center; background:#fafafa; cursor:pointer; }
.kv-placeholder{ display:flex; flex-direction:column; align-items:center; color:#666; gap:6px; }
.kv-icon{ font-size:22px; }
.kv-preview{ width:100%; height:100%; background-size:cover; background-position:center; border-radius:8px; }
.help{ color:#777; font-size:12px; }
</style>
