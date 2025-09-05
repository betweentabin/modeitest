<template>
  <div class="app-page">
    <Navigation />
    <HeroSection title="セミナー申し込み" subtitle="seminar application" />
    <Breadcrumbs :breadcrumbs="['セミナー申し込み', '入力']" />

    <section class="section">
      <div class="container">
        <h1 class="title">お客様情報の入力</h1>
        <form @submit.prevent="goConfirm" class="form">
          <div class="row">
            <label>お名前<span class="req">*</span></label>
            <input v-model="form.name" type="text" required />
          </div>
          <div class="row">
            <label>メールアドレス<span class="req">*</span></label>
            <input v-model="form.email" type="email" required :readonly="_loggedIn" />
          </div>
          <div class="row">
            <label>会社名</label>
            <input v-model="form.company" type="text" />
          </div>
          <div class="row">
            <label>電話番号</label>
            <input v-model="form.phone" type="tel" />
          </div>
          <div class="row">
            <label>特記事項</label>
            <textarea v-model="form.special_requests" rows="4" />
          </div>
          <div class="actions">
            <button type="button" class="btn outline" @click="goBack">戻る</button>
            <button type="submit" class="btn primary">確認へ進む</button>
          </div>
        </form>
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
import { useMemberAuth } from '@/composables/useMemberAuth'

export default {
  name: 'SeminarApplicationFormPage',
  components: { Navigation, Footer, HeroSection, Breadcrumbs },
  data() {
    return {
      form: {
        name: '',
        email: '',
        company: '',
        phone: '',
        special_requests: ''
      },
      _member: null,
      _loggedIn: false
    }
  },
  mounted() {
    // If a member is logged in, prefill and lock email to avoid EMAIL_MISMATCH on server
    try {
      const auth = useMemberAuth()
      this._member = auth.getMemberInfo()
      this._loggedIn = auth.isLoggedIn()
      if (this._member) {
        if (!this.form.name) this.form.name = this._member.name || this._member.full_name || ''
        if (!this.form.email) this.form.email = this._member.email || ''
      }
    } catch (e) { /* noop */ }
  },
  methods: {
    goBack() { this.$router.back() },
    goConfirm() {
      const id = this.$route.params.id
      const q = new URLSearchParams(this.form).toString()
      this.$router.push(`/seminars/${id}/apply/confirm?${q}`)
    }
  }
}
</script>

<style scoped>
.section { padding: 40px 20px; background: #f6f6f6; }
.container { max-width: 800px; margin: 0 auto; background:#fff; padding:24px; border-radius:8px; }
.title { font-size: 22px; margin: 0 0 12px; }
.form { display: flex; flex-direction: column; gap: 14px; }
.row { display: flex; flex-direction: column; gap: 6px; }
label { font-weight: 600; font-size: 14px; }
.req { color:#da5761; margin-left:4px; }
input, textarea { border:1px solid #ddd; border-radius:6px; padding:10px; font-size:14px; }
.actions { display:flex; gap:8px; justify-content:flex-end; margin-top:8px; }
.btn { padding:10px 16px; border-radius:6px; cursor:pointer; font-weight:600; }
.btn.primary { background:#da5761; color:#fff; border:none; }
.btn.outline { background:#fff; color:#1a1a1a; border:1px solid #ddd; }
.btn.primary:hover { background:#c44853; }
</style>
