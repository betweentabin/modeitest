<template>
  <nav class="navigation-menu">
    <ul class="nav-list">
      <li class="nav-item">
        <router-link to="/" class="nav-link" exact-active-class="active">
          ホーム
        </router-link>
      </li>
      <li class="nav-item">
        <router-link to="/about" class="nav-link" active-class="active">
          会社概要
        </router-link>
      </li>
      <li class="nav-item">
        <router-link to="/services" class="nav-link" active-class="active">
          サービス
        </router-link>
      </li>
      <li class="nav-item">
        <router-link to="/contact" class="nav-link" active-class="active">
          お問い合わせ
        </router-link>
      </li>
    </ul>
  </nav>
</template>

<script>
export default {
  name: "NavigationMenu",
};
</script>

<style scoped>
.navigation-menu {
  display: flex;
  align-items: center;
}

.nav-list {
  display: flex;
  list-style: none;
  margin: 0;
  padding: 0;
  gap: 30px;
}

.nav-item {
  position: relative;
}

.nav-link {
  color: #333;
  text-decoration: none;
  font-size: 16px;
  font-weight: 500;
  padding: 8px 12px;
  transition: all 0.3s ease;
  display: block;
  position: relative;
}

.nav-link:hover {
  color: #007bff;
}

.nav-link.active {
  color: #007bff;
  font-weight: 600;
}

.nav-link.active::after {
  content: '';
  position: absolute;
  bottom: -2px;
  left: 12px;
  right: 12px;
  height: 2px;
  background-color: #007bff;
}
</style>