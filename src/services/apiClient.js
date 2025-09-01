// API Client for Laravel Backend
import { getApiUrl } from '../config/api.js'

class ApiClient {
  constructor() {
    this.baseURL = getApiUrl('')
    this.token = null
  }

  setToken(token) {
    this.token = token
  }

  // Generic request method
  async request(endpoint, options = {}) {
    const url = getApiUrl(endpoint)
    
    const config = {
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        ...(this.token ? { Authorization: `Bearer ${this.token}` } : {}),
        ...options.headers
      },
      mode: 'cors', // CORSモードを明示的に指定
      ...options
    }

    try {
      const response = await fetch(url, config)
      
      // レスポンスが空の場合のハンドリング
      const text = await response.text()
      let data = {}
      
      if (text) {
        try {
          data = JSON.parse(text)
        } catch (e) {
          console.error('JSON parse error:', e)
          data = { success: false, error: 'Invalid JSON response' }
        }
      }
      
      if (!response.ok) {
        console.error(`API Error: ${response.status} ${response.statusText}`, data)
        return { success: false, error: data.message || `HTTP error! status: ${response.status}` }
      }
      
      return data
    } catch (error) {
      console.error('API request failed:', error)
      // ネットワークエラーの場合はフォールバックを返す
      return { success: false, error: error.message }
    }
  }

  // GET request
  async get(endpoint, options = {}) {
    return this.request(endpoint, {
      method: 'GET',
      ...options
    })
  }

  // POST request
  async post(endpoint, data = null, options = {}) {
    return this.request(endpoint, {
      method: 'POST',
      body: data ? JSON.stringify(data) : null,
      ...options
    })
  }

  // PUT request
  async put(endpoint, data = null, options = {}) {
    return this.request(endpoint, {
      method: 'PUT',
      body: data ? JSON.stringify(data) : null,
      ...options
    })
  }

  // DELETE request
  async delete(endpoint, options = {}) {
    return this.request(endpoint, {
      method: 'DELETE',
      ...options
    })
  }

  // Seminar API methods
  async getSeminars(params = {}) {
    const queryString = new URLSearchParams(params).toString()
    const endpoint = queryString ? `/api/seminars?${queryString}` : '/api/seminars'
    return this.get(endpoint)
  }

  async getSeminar(id) {
    return this.get(`/api/seminars/${id}`)
  }

  async registerForSeminar(seminarId, registrationData) {
    return this.post(`/api/seminars/${seminarId}/register`, registrationData)
  }

  // Admin Seminar API methods (requires authentication)
  async createSeminar(seminarData, token) {
    return this.post('/api/admin/seminars', seminarData, {
      headers: {
        'Authorization': `Bearer ${token}`
      }
    })
  }

  async updateSeminar(id, seminarData, token) {
    return this.put(`/api/admin/seminars/${id}`, seminarData, {
      headers: {
        'Authorization': `Bearer ${token}`
      }
    })
  }

  async deleteSeminar(id, token) {
    return this.delete(`/api/admin/seminars/${id}`, {
      headers: {
        'Authorization': `Bearer ${token}`
      }
    })
  }

  // News API methods
  async getNews(params = {}) {
    const queryString = new URLSearchParams(params).toString()
    const endpoint = queryString ? `/api/news?${queryString}` : '/api/news'
    return this.get(endpoint)
  }

  async getNewsItem(id) {
    return this.get(`/api/news/${id}`)
  }

  async createNews(newsData, token) {
    return this.post('/api/admin/news', newsData, {
      headers: {
        'Authorization': `Bearer ${token}`
      }
    })
  }

  // Publications API methods
  async getPublications(params = {}) {
    const queryString = new URLSearchParams(params).toString()
    const endpoint = queryString ? `/api/publications?${queryString}` : '/api/publications'
    return this.get(endpoint)
  }

  async getPublication(id) {
    return this.get(`/api/publications/${id}`)
  }

  async downloadPublication(id) {
    return this.get(`/api/publications/${id}/download`)
  }

  async createPublication(publicationData, token) {
    return this.post('/api/admin/publications', publicationData, {
      headers: {
        'Authorization': `Bearer ${token}`
      }
    })
  }

  async updatePublication(id, publicationData, token) {
    return this.put(`/api/admin/publications/${id}`, publicationData, {
      headers: {
        'Authorization': `Bearer ${token}`
      }
    })
  }

  async deletePublication(id, token) {
    return this.delete(`/api/admin/publications/${id}`, {
      headers: {
        'Authorization': `Bearer ${token}`
      }
    })
  }

  // Inquiry API methods
  async submitInquiry(inquiryData) {
    return this.post('/api/inquiries', inquiryData)
  }

  async getInquiries(params = {}, token) {
    const queryString = new URLSearchParams(params).toString()
    const endpoint = queryString ? `/api/admin/inquiries?${queryString}` : '/api/admin/inquiries'
    return this.get(endpoint, {
      headers: {
        'Authorization': `Bearer ${token}`
      }
    })
  }

  async getInquiry(id, token) {
    return this.get(`/api/admin/inquiries/${id}`, {
      headers: {
        'Authorization': `Bearer ${token}`
      }
    })
  }

  async markInquiryAsResponded(id, token) {
    return this.post(`/api/admin/inquiries/${id}/respond`, null, {
      headers: {
        'Authorization': `Bearer ${token}`
      }
    })
  }

  async getAdminInquiries(params = {}, token) {
    const queryString = new URLSearchParams(params).toString()
    const endpoint = queryString ? `/api/admin/inquiries?${queryString}` : '/api/admin/inquiries'
    return this.get(endpoint, {
      headers: {
        'Authorization': `Bearer ${token}`
      }
    })
  }

  async deleteInquiry(id, token) {
    return this.delete(`/api/admin/inquiries/${id}`, {
      headers: {
        'Authorization': `Bearer ${token}`
      }
    })
  }

  // Auth API methods (to be implemented)
  async login(credentials) {
    return this.post('/api/auth/login', credentials)
  }

  async logout(token) {
    return this.post('/api/auth/logout', null, {
      headers: {
        'Authorization': `Bearer ${token}`
      }
    })
  }

  async register(userData) {
    return this.post('/api/auth/register', userData)
  }

  // Admin Auth API methods (to be implemented)
  async adminLogin(credentials) {
    return this.post('/api/admin/login', credentials)
  }

  async adminLogout(token) {
    return this.post('/api/admin/logout', null, {
      headers: {
        'Authorization': `Bearer ${token}`
      }
    })
  }

  // Admin-specific methods with token
  async getAdminSeminars(params = {}, token) {
    const queryString = new URLSearchParams(params).toString()
    const endpoint = queryString ? `/api/admin/seminars?${queryString}` : '/api/admin/seminars'
    return this.get(endpoint, {
      headers: {
        'Authorization': `Bearer ${token}`
      }
    })
  }

  async getAdminNews(params = {}, token) {
    const queryString = new URLSearchParams(params).toString()
    const endpoint = queryString ? `/api/admin/news-v2?${queryString}` : '/api/admin/news-v2'
    return this.get(endpoint, {
      headers: {
        'Authorization': `Bearer ${token}`
      }
    })
  }

  async getAdminPublications(params = {}, token) {
    const queryString = new URLSearchParams(params).toString()
    const endpoint = queryString ? `/api/admin/publications-v2?${queryString}` : '/api/admin/publications-v2'
    return this.get(endpoint, {
      headers: {
        'Authorization': `Bearer ${token}`
      }
    })
  }

  // News categories API methods
  async getNewsCategories() {
    return this.get('/api/news-categories')
  }

  // Publication categories API methods
  async getPublicationCategories() {
    return this.get('/api/publication-categories')
  }

  // Notices API methods
  async getNotices(params = {}) {
    const queryString = new URLSearchParams(params).toString()
    const endpoint = queryString ? `/api/notices?${queryString}` : '/api/notices'
    return this.get(endpoint)
  }

  async getNotice(id) {
    return this.get(`/api/notices/${id}`)
  }

  async createNotice(noticeData, token) {
    return this.post('/api/admin/notices', noticeData, {
      headers: {
        'Authorization': `Bearer ${token}`
      }
    })
  }

  async updateNotice(id, noticeData, token) {
    return this.put(`/api/admin/notices/${id}`, noticeData, {
      headers: {
        'Authorization': `Bearer ${token}`
      }
    })
  }

  async deleteNotice(id, token) {
    return this.delete(`/api/admin/notices/${id}`, {
      headers: {
        'Authorization': `Bearer ${token}`
      }
    })
  }
  
  // Page content API methods
  async getPageContents() {
    return this.get('/api/public/pages')
  }
  
  async getPageContent(pageKey) {
    return this.get(`/api/public/pages/${pageKey}`)
  }
}

// Export a singleton instance
export default new ApiClient()
