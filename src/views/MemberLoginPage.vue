<template>
  <div class="member-login-page">
    <div class="login-container">
      <div class="login-card">
        <div class="logo-section">
          <img
            class="logo"
            src="/img/ico-logo-2.svg"
            alt="Logo"
          />
          <h1 class="title inter-bold-black-24px">会員ログイン</h1>
          <p class="subtitle inter-normal-ship-gray-16px">会員限定コンテンツへアクセス</p>
        </div>
        
        <form @submit.prevent="handleLogin" class="login-form">
          <div class="form-group">
            <label for="email" class="form-label inter-semi-bold-ship-gray-12px">
              メールアドレス
            </label>
            <input
              id="email"
              v-model="email"
              type="email"
              required
              class="form-input inter-normal-ship-gray-16px"
              placeholder="member@example.com"
            />
          </div>

          <div class="form-group">
            <label for="password" class="form-label inter-semi-bold-ship-gray-12px">
              パスワード
            </label>
            <input
              id="password"
              v-model="password"
              type="password"
              required
              class="form-input inter-normal-ship-gray-16px"
              placeholder="••••••••"
            />
          </div>

          <div class="form-options">
            <label class="remember-me">
              <input
                type="checkbox"
                v-model="rememberMe"
                class="checkbox"
              />
              <span class="inter-normal-ship-gray-15px">ログイン情報を記憶する</span>
            </label>
            <a href="#" class="forgot-link inter-normal-ship-gray-15px" @click.prevent="showForgotPassword">
              パスワードを忘れた方
            </a>
          </div>

          <div v-if="error" class="error-message inter-normal-ship-gray-15px">
            <img src="/img/vector-28.svg" alt="Error" class="error-icon" />
            {{ error }}
          </div>

          <button
            type="submit"
            :disabled="loading"
            class="login-button inter-bold-white-15px"
          >
            {{ loading ? 'ログイン中...' : 'ログイン' }}
          </button>

          <div class="divider">
            <span class="divider-text inter-normal-ship-gray-10px">または</span>
          </div>

          <router-link
            to="/register"
            class="register-button inter-bold-mandy-15px"
          >
            新規会員登録
          </router-link>
        </form>

        <div class="membership-info">
          <div class="membership-types">
            <div class="membership-type">
              <img src="/img/vector-70.svg" alt="Basic" class="membership-icon" />
              <span class="inter-semi-bold-ship-gray-11px">ベーシック会員</span>
            </div>
            <div class="membership-type">
              <img src="/img/vector-71.svg" alt="Standard" class="membership-icon" />
              <span class="inter-semi-bold-ship-gray-11px">スタンダード会員</span>
            </div>
            <div class="membership-type">
              <img src="/img/vector-73.svg" alt="Premium" class="membership-icon" />
              <span class="inter-semi-bold-ship-gray-11px">プレミアム会員</span>
            </div>
          </div>
        </div>

        <div class="footer-text inter-normal-ship-gray-10px">
          セキュアな接続で保護されています
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import { getApiUrl } from '@/config/api'

export default {
  name: 'MemberLoginPage',
  data() {
    return {
      email: '',
      password: '',
      rememberMe: false,
      loading: false,
      error: ''
    }
  },
  methods: {
    async handleLogin() {
      this.loading = true
      this.error = ''

      try {
        const response = await axios.post(getApiUrl('/api/login'), {
          email: this.email,
          password: this.password
        })

        localStorage.setItem('memberToken', response.data.token)
        localStorage.setItem('memberUser', JSON.stringify(response.data.user))
        
        if (this.rememberMe) {
          localStorage.setItem('rememberEmail', this.email)
        } else {
          localStorage.removeItem('rememberEmail')
        }
        
        axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.token}`
        
        this.$router.push('/member/dashboard')
      } catch (err) {
        if (err.response?.data?.message) {
          this.error = err.response.data.message
        } else {
          this.error = 'ログインに失敗しました'
        }
      } finally {
        this.loading = false
      }
    },
    showForgotPassword() {
      this.$router.push('/forgot-password')
    }
  },
  mounted() {
    const rememberedEmail = localStorage.getItem('rememberEmail')
    if (rememberedEmail) {
      this.email = rememberedEmail
      this.rememberMe = true
    }
  }
}
</script>

<style scoped>
.member-login-page {
  min-height: 100vh;
  background: linear-gradient(135deg, #f5f5f5 0%, #ebebeb 100%);
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 20px;
}

.login-container {
  width: 100%;
  max-width: 480px;
}

.login-card {
  background: var(--white);
  border-radius: 16px;
  box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
  padding: 48px 40px;
  position: relative;
  overflow: hidden;
}

.login-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 4px;
  background: linear-gradient(90deg, var(--mandy) 0%, var(--hot-pink) 100%);
}

.logo-section {
  text-align: center;
  margin-bottom: 40px;
}

.logo {
  width: 60px;
  height: 60px;
  margin: 0 auto 20px;
}

.title {
  margin: 0 0 8px 0;
  color: var(--black);
}

.subtitle {
  margin: 0;
  color: var(--ship-gray);
  opacity: 0.8;
}

.login-form {
  margin-top: 32px;
}

.form-group {
  margin-bottom: 24px;
}

.form-label {
  display: block;
  margin-bottom: 8px;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  color: var(--ship-gray);
}

.form-input {
  width: 100%;
  padding: 12px 16px;
  border: 1px solid var(--celeste);
  border-radius: 8px;
  background: var(--white);
  transition: all 0.3s ease;
  color: var(--ship-gray);
}

.form-input:focus {
  outline: none;
  border-color: var(--mandy);
  box-shadow: 0 0 0 3px rgba(218, 87, 97, 0.1);
}

.form-input::placeholder {
  color: var(--celeste);
}

.form-options {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 24px;
}

.remember-me {
  display: flex;
  align-items: center;
  cursor: pointer;
}

.checkbox {
  margin-right: 8px;
  width: 18px;
  height: 18px;
  accent-color: var(--mandy);
}

.forgot-link {
  color: var(--mandy);
  text-decoration: none;
  transition: opacity 0.3s;
}

.forgot-link:hover {
  opacity: 0.8;
  text-decoration: underline;
}

.error-message {
  background: rgba(218, 87, 97, 0.08);
  border: 1px solid rgba(218, 87, 97, 0.2);
  border-radius: 8px;
  padding: 12px 16px;
  margin-bottom: 24px;
  color: var(--mandy);
  display: flex;
  align-items: center;
  gap: 8px;
}

.error-icon {
  width: 16px;
  height: 16px;
  filter: brightness(0) saturate(100%) invert(40%) sepia(81%) saturate(479%) hue-rotate(315deg) brightness(91%) contrast(89%);
}

.login-button {
  width: 100%;
  padding: 14px 24px;
  background: linear-gradient(135deg, var(--mandy) 0%, var(--hot-pink) 100%);
  border: none;
  border-radius: 8px;
  color: var(--white);
  font-weight: 700;
  cursor: pointer;
  transition: all 0.3s ease;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.login-button:hover:not(:disabled) {
  transform: translateY(-2px);
  box-shadow: 0 8px 20px rgba(218, 87, 97, 0.3);
}

.login-button:active:not(:disabled) {
  transform: translateY(0);
}

.login-button:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.divider {
  position: relative;
  text-align: center;
  margin: 24px 0;
}

.divider::before {
  content: '';
  position: absolute;
  top: 50%;
  left: 0;
  right: 0;
  height: 1px;
  background: var(--celeste);
}

.divider-text {
  position: relative;
  background: var(--white);
  padding: 0 16px;
  color: var(--sonic-silver);
}

.register-button {
  display: block;
  width: 100%;
  padding: 14px 24px;
  background: var(--white);
  border: 2px solid var(--mandy);
  border-radius: 8px;
  color: var(--mandy);
  font-weight: 700;
  cursor: pointer;
  transition: all 0.3s ease;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  text-align: center;
  text-decoration: none;
}

.register-button:hover {
  background: var(--mandy);
  color: var(--white);
  transform: translateY(-2px);
  box-shadow: 0 8px 20px rgba(218, 87, 97, 0.2);
}

.membership-info {
  margin-top: 32px;
  padding-top: 24px;
  border-top: 1px solid var(--cararra);
}

.membership-types {
  display: flex;
  justify-content: space-around;
  gap: 16px;
}

.membership-type {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 8px;
}

.membership-icon {
  width: 24px;
  height: 24px;
  opacity: 0.6;
}

.footer-text {
  text-align: center;
  margin-top: 24px;
  color: var(--sonic-silver);
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 4px;
}

.footer-text::before {
  content: '\1F512';
  font-size: 12px;
}

@media (max-width: 640px) {
  .login-card {
    padding: 32px 24px;
  }
  
  .title {
    font-size: 20px;
  }
  
  .subtitle {
    font-size: 14px;
  }
  
  .membership-types {
    flex-direction: column;
    gap: 12px;
  }
  
  .membership-type {
    flex-direction: row;
    justify-content: center;
  }
}
</style>