<template>
  <div class="admin-login-page">
    <div class="login-container">
      <div class="login-card">
        <div class="logo-section">
          <img
            class="logo"
            src="/img/ico-logo-2.svg"
            alt="Logo"
          />
          <h1 class="title inter-bold-black-24px">管理者ログイン</h1>
          <p class="subtitle inter-normal-ship-gray-16px">コンテンツ管理システムへようこそ</p>
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
              placeholder="admin@example.com"
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
        </form>

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
  name: 'AdminLoginPage',
  data() {
    return {
      email: '',
      password: '',
      loading: false,
      error: ''
    }
  },
  mounted() {
    // Vueのイベントシステムが機能しない場合のフォールバック
    const form = this.$el.querySelector('.login-form');
    if (form) {
      console.log('Manually adding submit event listener to form.');
      form.addEventListener('submit', (e) => {
        e.preventDefault();
        console.log('Manual form submission triggered.');
        this.handleLogin();
      });
    } else {
      console.error('Login form not found in mounted hook.');
    }
  },
  methods: {
    async handleLogin() {
      console.log('handleLogin method triggered.'); // デバッグ用ログ
      this.loading = true
      this.error = ''

      const payload = {
        email: this.email,
        password: this.password
      };
      console.log('Sending payload to API:', payload); // デバッグ用ログ

      try {
        const response = await axios.post(getApiUrl('/api/admin/login'), payload);
        console.log('API response received:', response); // デバッグ用ログ

        localStorage.setItem('adminToken', response.data.token)
        localStorage.setItem('adminUser', JSON.stringify(response.data.user))
        
        axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.token}`
        
        this.$router.push('/admin/dashboard')
      } catch (err) {
        console.error('Login API error:', err); // デバッグ用エラーログ
        if (err.response) {
          console.error('Error response data:', err.response.data);
          console.error('Error response status:', err.response.status);
        }
        
        if (err.response?.status === 403) {
          this.error = '管理者権限がありません'
        } else if (err.response?.data?.message) {
          this.error = err.response.data.message
        } else {
          this.error = 'ログインに失敗しました'
        }
      } finally {
        this.loading = false
      }
    }
  }
}
</script>

<style scoped>
.admin-login-page {
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

.footer-text {
  text-align: center;
  margin-top: 32px;
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
}
</style>