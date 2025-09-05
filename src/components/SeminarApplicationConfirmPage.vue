<template>
  <div class="app-page">
    <Navigation />
    <HeroSection title="セミナー申し込み確認" subtitle="confirm" />
    <Breadcrumbs :breadcrumbs="['セミナー申し込み', '確認']" />

    <section class="section">
      <div class="container">
        <h1 class="title">記入内容のご確認</h1>
        <div class="summary">
          <div class="row"><span class="label">お名前</span><span class="val">{{ form.name }}</span></div>
          <div class="row"><span class="label">メールアドレス</span><span class="val">{{ form.email }}</span></div>
          <div class="row"><span class="label">会社名</span><span class="val">{{ form.company || '-' }}</span></div>
          <div class="row"><span class="label">電話番号</span><span class="val">{{ form.phone || '-' }}</span></div>
          <div class="row"><span class="label">特記事項</span><span class="val">{{ form.special_requests || '-' }}</span></div>
        </div>
        <div class="actions">
          <button class="btn outline" @click="backToForm">修正する</button>
          <button class="btn primary" :disabled="submitting" @click="submit">送信する</button>
        </div>
      </div>
    </section>
    <Footer />
  </div>
</template>

<script>
import Navigation from './Navigation.vue'
import Footer from './Footer.vue'
import HeroSection from './HeroSection.vue'
import Breadcrumbs from './Breadcrumbs.vue'
import apiClient from '@/services/apiClient'

export default {
  name: 'SeminarApplicationConfirmPage',
  components: { Navigation, Footer, HeroSection, Breadcrumbs },
  data() {
    const q = this.$route.query || {}
    return {
      form: {
        name: q.name || '',
        email: q.email || '',
        company: q.company || '',
        phone: q.phone || '',
        special_requests: q.special_requests || ''
      },
      submitting: false
    }
  },
  methods: {
    backToForm() {
      const id = this.$route.params.id
      const qs = new URLSearchParams(this.form).toString()
      this.$router.push(`/seminars/${id}/apply?${qs}`)
    },
    async submit() {
      this.submitting = true
      try {
        const id = this.$route.params.id
        const res = await apiClient.registerForSeminar(id, this.form)
        if (res && res.success) {
          const num = res.data?.registration_number
          const query = num ? `?applicationNumber=${encodeURIComponent(num)}` : ''
          this.$router.replace(`/seminars/${id}/apply/complete${query}`)
        } else {
          throw new Error(res?.error || '送信に失敗しました')
        }
      } catch (e) {
        alert(e.message || '送信に失敗しました')
      } finally {
        this.submitting = false
      }
    }
  }
}
</script>

<style scoped>
.section { padding: 40px 20px; background: #f6f6f6; }
.container { max-width: 800px; margin: 0 auto; background:#fff; padding:24px; border-radius:8px; }
.title { font-size: 22px; margin: 0 0 12px; }
.summary { display:flex; flex-direction:column; gap:10px; }
.row { display:flex; gap:12px; border-bottom:1px dashed #eee; padding:10px 0; }
.label { min-width: 140px; color:#666; }
.val { color:#1a1a1a; }
.actions { display:flex; gap:8px; justify-content:flex-end; margin-top:16px; }
.btn { padding:10px 16px; border-radius:6px; cursor:pointer; font-weight:600; }
.btn.primary { background:#da5761; color:#fff; border:none; }
.btn.outline { background:#fff; color:#1a1a1a; border:1px solid #ddd; }
.btn.primary:hover { background:#c44853; }
</style>

