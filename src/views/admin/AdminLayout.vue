<template>
  <div class="admin-layout">
    <!-- ヘッダー -->
    <header class="header">
      <div class="header-content">
        <div class="logo-section">
          <img src="/img/ico-logo-1-1.svg" alt="ちくぎん地域経済研究所" class="logo">
          <span class="company-name">株式会社ちくぎん地域経済研究所</span>
          <span class="company-url">https://www.chikugin-ri.co.jp/</span>
        </div>
        <button @click="handleLogout" class="logout-btn">ログアウト</button>
      </div>
    </header>

    <div class="main-container">
      <!-- サイドバーナビゲーション -->
      <nav class="sidebar">
        <ul class="nav-menu">
          <li>
            <router-link to="/admin/members" class="nav-item" :class="{ active: isActive('/admin/members') }">
              会員管理
            </router-link>
          </li>
          <li>
            <router-link to="/admin/seminars" class="nav-item" :class="{ active: isActive('/admin/seminars') }">
              セミナー管理
            </router-link>
          </li>
          <li>
            <router-link to="/admin/publications" class="nav-item" :class="{ active: isActive('/admin/publications') }">
              刊行物管理
            </router-link>
          </li>
          <li>
            <router-link to="/admin/economic-reports" class="nav-item" :class="{ active: isActive('/admin/economic-reports') }">
              経済統計レポート管理
            </router-link>
          </li>
          <li>
            <router-link to="/admin/notices" class="nav-item" :class="{ active: isActive('/admin/notices') }">
              お知らせ管理
            </router-link>
          </li>
          <li>
            <router-link to="/admin/inquiries" class="nav-item" :class="{ active: isActive('/admin/inquiries') }">
              お問い合わせ管理
            </router-link>
          </li>
          <li>
            <router-link to="/admin/media" class="nav-item" :class="{ active: isActive('/admin/media') }">
              メディア管理
            </router-link>
          </li>
          <li>
            <router-link to="/admin/pages" class="nav-item" :class="{ active: isActive('/admin/pages') }">
              各ページ管理
            </router-link>
          </li>
        </ul>
      </nav>

      <!-- メインコンテンツエリア -->
      <main class="content">
        <slot></slot>
      </main>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'AdminLayout',
  methods: {
    isActive(path) {
      return this.$route.path === path || this.$route.path.startsWith(path + '/')
    },
    handleLogout() {
      localStorage.removeItem('adminToken')
      localStorage.removeItem('adminUser')
      delete axios.defaults.headers.common['Authorization']
      this.$router.push('/admin/login')
    }
  }
}
</script>

<style scoped>
.admin-layout {
  min-height: 100vh;
  background-color: #f5f5f5;
}

.header {
  background-color: white;
  border-bottom: 1px solid #e5e5e5;
  padding: 12px 24px;
}

.header-content {
  display: flex;
  justify-content: space-between;
  align-items: center;
  max-width: 1400px;
  margin: 0 auto;
}

@media (max-width: 768px) {
  .header-content {
    flex-direction: column;
    gap: 12px;
    align-items: flex-start;
  }
}

.logo-section {
  display: flex;
  align-items: center;
  gap: 12px;
}

.logo {
  height: 32px;
  width: auto;
}

.company-name {
  font-size: 16px;
  font-weight: 600;
  color: #1A1A1AA1A;
}

.company-url {
  font-size: 12px;
  color: #666;
}

.logout-btn {
  background-color: #1A1A1AA1A;
  color: white;
  border: none;
  padding: 8px 16px;
  border-radius: 4px;
  font-size: 14px;
  cursor: pointer;
  transition: background-color 0.2s;
}

.logout-btn:hover {
  background-color: #555;
}

.main-container {
  display: flex;
  max-width: 1400px;
  margin: 0 auto;
  min-height: calc(100vh - 65px);
}

@media (max-width: 768px) {
  .main-container {
    flex-direction: column;
  }
}

.sidebar {
  width: 200px;
  background-color: white;
  border-right: 1px solid #e5e5e5;
  padding: 20px 0;
}

@media (max-width: 768px) {
  .sidebar {
    width: 100%;
    border-right: none;
    border-bottom: 1px solid #e5e5e5;
  }
}

.nav-menu {
  list-style: none;
  padding: 0;
  margin: 0;
}

.nav-menu li {
  margin-bottom: 4px;
}

.nav-item {
  display: block;
  padding: 12px 24px;
  color: #1A1A1AA1A;
  text-decoration: none;
  font-size: 14px;
  transition: background-color 0.2s;
}

.nav-item:hover {
  background-color: #f8f8f8;
  color: #1A1A1AA1A;
  text-decoration: none;
}

.nav-item.active {
  background-color: #ff6b9d;
  color: white;
}

.nav-item.active:hover {
  background-color: #ff5a8c;
  color: white;
}

.content {
  flex: 1;
  padding: 20px;
  background-color: #f5f5f5;
}
</style>
