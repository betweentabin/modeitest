<template>
  <div class="min-h-screen bg-gray-100">
    <nav class="bg-white shadow-sm border-b border-gray-200">
      <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex items-center">
            <router-link to="/admin/dashboard" class="text-blue-600 hover:text-blue-800">
              ← ダッシュボードに戻る
            </router-link>
          </div>
          <div class="flex items-center space-x-4">
            <button
              @click="handleLogout"
              class="text-sm text-red-600 hover:text-red-800"
            >
              ログアウト
            </button>
          </div>
        </div>
      </div>
    </nav>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold mb-6">
          {{ isNew ? '新規ページ作成' : 'ページ編集' }}
        </h1>

        <form @submit.prevent="handleSubmit">
          <div class="mb-4">
            <label for="page_key" class="block text-sm font-medium text-gray-700 mb-2">
              ページキー
            </label>
            <input
              id="page_key"
              v-model="formData.page_key"
              type="text"
              :disabled="!isNew"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:bg-gray-100"
              placeholder="about, services, etc."
            />
          </div>

          <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
              タイトル
            </label>
            <input
              id="title"
              v-model="formData.title"
              type="text"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
          </div>

          <div class="mb-4">
            <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
              コンテンツ (JSON形式)
            </label>
            <textarea
              id="content"
              v-model="contentJson"
              rows="10"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 font-mono text-sm"
              placeholder='{"key": "value"}'
            />
            <p v-if="jsonError" class="mt-1 text-sm text-red-600">{{ jsonError }}</p>
          </div>

          <div class="mb-4">
            <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-2">
              メタディスクリプション
            </label>
            <textarea
              id="meta_description"
              v-model="formData.meta_description"
              rows="3"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
          </div>

          <div class="mb-4">
            <label for="meta_keywords" class="block text-sm font-medium text-gray-700 mb-2">
              メタキーワード
            </label>
            <input
              id="meta_keywords"
              v-model="formData.meta_keywords"
              type="text"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
          </div>

          <div class="mb-6">
            <label class="flex items-center">
              <input
                v-model="formData.is_published"
                type="checkbox"
                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
              />
              <span class="ml-2 text-sm text-gray-700">公開する</span>
            </label>
          </div>

          <div v-if="error" class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
            {{ error }}
          </div>

          <div v-if="successMessage" class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ successMessage }}
          </div>

          <div class="flex justify-end space-x-4">
            <router-link
              to="/admin/dashboard"
              class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
            >
              キャンセル
            </router-link>
            <button
              type="submit"
              :disabled="loading || jsonError"
              class="px-4 py-2 border border-transparent rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed"
            >
              {{ loading ? '保存中...' : '保存' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'PageEditForm',
  data() {
    return {
      formData: {
        page_key: '',
        title: '',
        content: {},
        meta_description: '',
        meta_keywords: '',
        is_published: false
      },
      contentJson: '',
      jsonError: '',
      loading: false,
      error: '',
      successMessage: ''
    }
  },
  computed: {
    isNew() {
      return this.$route.params.pageKey === 'new'
    },
    pageKey() {
      return this.$route.params.pageKey
    }
  },
  watch: {
    contentJson(newValue) {
      this.jsonError = ''
      try {
        this.formData.content = JSON.parse(newValue)
      } catch (e) {
        this.jsonError = 'JSONの形式が正しくありません'
      }
    }
  },
  async mounted() {
    const token = localStorage.getItem('adminToken')
    
    if (!token) {
      this.$router.push('/admin/login')
      return
    }

    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
    
    if (!this.isNew) {
      await this.fetchPageData()
    } else {
      this.contentJson = JSON.stringify({}, null, 2)
    }
  },
  methods: {
    async fetchPageData() {
      this.loading = true
      this.error = ''

      try {
        const response = await axios.get(`http://localhost:8000/api/admin/pages/${this.pageKey}`)
        this.formData = response.data
        this.contentJson = JSON.stringify(response.data.content, null, 2)
      } catch (err) {
        this.error = 'ページデータの取得に失敗しました'
        console.error(err)
      } finally {
        this.loading = false
      }
    },
    async handleSubmit() {
      this.loading = true
      this.error = ''
      this.successMessage = ''

      try {
        if (this.isNew) {
          await axios.post('http://localhost:8000/api/admin/pages', this.formData)
          this.successMessage = 'ページを作成しました'
          setTimeout(() => {
            this.$router.push('/admin/dashboard')
          }, 1500)
        } else {
          await axios.put(`http://localhost:8000/api/admin/pages/${this.pageKey}`, this.formData)
          this.successMessage = 'ページを更新しました'
        }
      } catch (err) {
        if (err.response?.data?.errors) {
          this.error = Object.values(err.response.data.errors).flat().join(', ')
        } else {
          this.error = this.isNew ? 'ページの作成に失敗しました' : 'ページの更新に失敗しました'
        }
        console.error(err)
      } finally {
        this.loading = false
      }
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