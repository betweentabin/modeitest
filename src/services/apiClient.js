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

  // adminトークンを取得
  getAdminToken() {
    return localStorage.getItem('admin_token')
  }

  // 現在のトークンを取得（設定されたトークンまたはadminトークン）
  getCurrentToken() {
    // 優先: 明示設定 > admin_token > auth_token(member) > memberToken(legacy)
    return this.token 
      || this.getAdminToken() 
      || localStorage.getItem('auth_token') 
      || localStorage.getItem('memberToken')
  }

  // adminとして認証されているかチェック
  isAdminAuthenticated() {
    return !!this.getAdminToken()
  }

  // Generic request method (supports two signatures):
  // 1) request(endpoint, options)
  // 2) request(method, endpoint, body, options)
  async request(a, b = {}, c = null, d = {}) {
    let method, endpoint, body, options

    // Detect signature
    const upper = typeof a === 'string' ? a.toUpperCase() : ''
    const isVerb = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'].includes(upper)
    if (isVerb) {
      method = upper
      endpoint = b
      body = c
      options = d || {}
    } else {
      method = (b && b.method) ? b.method : 'GET'
      endpoint = a
      body = (b && b.body) ? b.body : null
      options = b || {}
    }

    // Handle params: append to endpoint if provided
    if (options.params && typeof options.params === 'object') {
      const qs = new URLSearchParams(options.params).toString()
      if (qs) {
        endpoint = endpoint.includes('?') ? `${endpoint}&${qs}` : `${endpoint}?${qs}`
      }
      // prevent fetch from choking on non-standard option
      delete options.params
    }

    const url = getApiUrl(endpoint)

    // Token selection by endpoint type (member vs admin)
    const adminTokenLS = localStorage.getItem('admin_token')
    const memberTokenLS = localStorage.getItem('auth_token') || localStorage.getItem('memberToken')
    const isAdminEndpoint = typeof endpoint === 'string' && endpoint.startsWith('/api/admin')
    const isMemberEndpoint = typeof endpoint === 'string' && (endpoint.startsWith('/api/member') || endpoint.startsWith('/api/member-auth'))

    let chosenToken = null
    if (isAdminEndpoint) {
      chosenToken = this.token || adminTokenLS || null
    } else if (isMemberEndpoint) {
      chosenToken = this.token || memberTokenLS || null
    } else {
      // Prefer member token, fallback to admin for mixed/public endpoints
      chosenToken = this.token || memberTokenLS || adminTokenLS || null
    }

    // Build Authorization header
    let authHeader = null
    if (chosenToken) {
      authHeader = chosenToken.startsWith('Bearer ') ? chosenToken : `Bearer ${chosenToken}`
      console.log('Using auth token:', authHeader.substring(0, 30) + '...')
    }
    
    const config = {
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        ...(authHeader ? { Authorization: authHeader } : {}),
        ...options.headers
      },
      mode: 'cors', // CORSモードを明示的に指定
      method,
      ...(body ? { body: typeof body === 'string' ? body : JSON.stringify(body) } : {}),
      ...options
    }

    try {
      const response = await fetch(url, config)

      // 非200系
      if (!response.ok) {
        let errText = ''
        try { errText = await response.text() } catch(e) {}
        let errJson = null
        try { errJson = errText ? JSON.parse(errText) : null } catch(e) {}
        const code = errJson?.error?.code || errJson?.code || response.status
        const message = errJson?.error?.message || errJson?.message || `HTTP error! status: ${response.status}`
        const details = errJson?.error?.details || null
        if (!options || !options.silent) {
          console.error(`API Error: ${response.status} ${response.statusText}`, errJson || errText)
        }
        return { success: false, error: message, code, details, raw: errJson || errText }
      }

      // レスポンス種別指定（blob/arraybuffer/text等）
      const respType = options.responseType || null
      if (respType === 'blob') {
        const blob = await response.blob()
        return { success: true, data: blob }
      }
      if (respType === 'arraybuffer') {
        const buf = await response.arrayBuffer()
        return { success: true, data: buf }
      }
      if (respType === 'text') {
        const txt = await response.text()
        return { success: true, data: txt }
      }

      // Content-TypeでJSON/テキストを判定
      const contentType = response.headers.get('Content-Type') || ''
      if (contentType.includes('application/json')) {
        const data = await response.json()
        if (data && typeof data === 'object' && 'success' in data) return data
        return { success: true, data }
      }

      // デフォルト: テキストとして返却
      const text = await response.text()
      return { success: true, data: text }
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

  // Upload (multipart/form-data). body must be FormData
  async upload(endpoint, formData, options = {}) {
    const url = getApiUrl(endpoint)
    const adminTokenLS = localStorage.getItem('admin_token')
    const chosenToken = this.token || adminTokenLS || null
    const headers = {
      'Accept': 'application/json',
      ...(chosenToken ? { 'Authorization': chosenToken.startsWith('Bearer ') ? chosenToken : `Bearer ${chosenToken}` } : {}),
      ...(options.headers || {})
    }
    const res = await fetch(url, { method: (options.method || 'POST'), headers, body: formData })
    if (!res.ok) {
      let msg = ''
      try { msg = await res.text() } catch(e) {}
      try { msg = JSON.parse(msg).message || msg } catch(e) {}
      return { success: false, error: msg || `HTTP ${res.status}` }
    }
    const ct = res.headers.get('Content-Type') || ''
    if (ct.includes('application/json')) {
      return await res.json()
    }
    const text = await res.text()
    return { success: true, data: text }
  }

  // Member masters
  async getRegions() { return this.get('/api/member-masters/regions') }
  async getIndustries() { return this.get('/api/member-masters/industries') }

  // Member seminar APIs
  async getMemberSeminars(params = {}) {
    return this.get('/api/member/seminars', { params })
  }
  async getMySeminarRegistrations(params = {}) {
    return this.get('/api/member/seminar-registrations', { params })
  }
  async getSeminarFavorites(params = {}) {
    return this.get('/api/member/seminar-favorites', { params })
  }
  async addSeminarFavorite(seminarId) {
    return this.post(`/api/member/seminar-favorites/${seminarId}`)
  }
  async removeSeminarFavorite(seminarId) {
    return this.delete(`/api/member/seminar-favorites/${seminarId}`)
  }

  // Member Admin APIs
  async getAdminMembers(params = {}) {
    return this.get('/api/admin/members', { params })
  }

  async createAdminMember(data) {
    return this.post('/api/admin/members', data)
  }

  async updateAdminMember(id, data) {
    return this.put(`/api/admin/members/${id}`, data)
  }

  async extendAdminMember(id, extendMonths) {
    return this.request('PATCH', `/api/admin/members/${id}/extend`, { extend_months: extendMonths })
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

  // Member favorites APIs
  async getMemberFavorites() {
    return this.get('/api/member/favorites')
  }

  async addMemberFavorite(favoriteMemberId) {
    return this.post(`/api/member/favorites/${favoriteMemberId}`)
  }

  async removeMemberFavorite(favoriteMemberId) {
    return this.delete(`/api/member/favorites/${favoriteMemberId}`)
  }

  // Member activity/logs
  async logMemberAccess({ content_type, content_id, access_type, required_level = null }) {
    return this.post('/api/member/log-access', {
      content_type,
      content_id,
      access_type,
      ...(required_level ? { required_level } : {})
    })
  }

  async getMemberDownloadHistory(params = {}) {
    return this.get('/api/member/download-history', { params })
  }

  // Member directory APIs
  async getMemberDirectory(params = {}) {
    return this.get('/api/member/directory', { params })
  }

  async getMemberDirectoryDetail(id) {
    return this.get(`/api/member/directory/${id}`)
  }

  async exportMemberDirectoryCsv(params = {}) {
    // Note: this client uses fetch; for streaming CSV, a dedicated download path may be used in UI
    return this.get('/api/member/directory/export/csv', { params })
  }

  // Admin mail groups
  async getMailGroups(params = {}) {
    return this.get('/api/admin/mail-groups', { params })
  }

  async createMailGroup(data) {
    return this.post('/api/admin/mail-groups', data)
  }

  async updateMailGroup(id, data) {
    return this.put(`/api/admin/mail-groups/${id}`, data)
  }

  async deleteMailGroup(id) {
    return this.delete(`/api/admin/mail-groups/${id}`)
  }

  async bulkEditMailGroupMembers(id, action, memberIds) {
    return this.post(`/api/admin/mail-groups/${id}/members`, { action, member_ids: memberIds })
  }

  async uploadMailGroupCsv(id, file) {
    const fd = new FormData()
    fd.append('file', file)
    return this.upload(`/api/admin/mail-groups/${id}/import-csv`, fd)
  }

  // Admin email campaigns
  async getEmailCampaigns(params = {}) {
    return this.get('/api/admin/emails', { params })
  }

  async createEmailCampaign(data) {
    return this.post('/api/admin/emails', data)
  }

  async getEmailCampaign(id) {
    return this.get(`/api/admin/emails/${id}`)
  }

  async previewEmailCampaign(id) {
    return this.post(`/api/admin/emails/${id}/preview`)
  }

  async scheduleEmailCampaign(id, scheduledAt) {
    return this.post(`/api/admin/emails/${id}/schedule`, { scheduled_at: scheduledAt })
  }

  async sendEmailCampaignNow(id) {
    return this.post(`/api/admin/emails/${id}/send-now`)
  }

  async resendFailedRecipients(id) {
    return this.post(`/api/admin/emails/${id}/resend-failed`)
  }

  async resendRecipient(id, recipientId) {
    return this.post(`/api/admin/emails/${id}/recipients/${recipientId}/resend`)
  }

  async duplicateEmailCampaign(id) {
    return this.post(`/api/admin/emails/${id}/duplicate`)
  }

  async listEmailTemplates() {
    return this.get('/api/admin/emails/templates')
  }

  async markEmailTemplate(id) {
    return this.post(`/api/admin/emails/${id}/mark-template`)
  }

  async unmarkEmailTemplate(id) {
    return this.post(`/api/admin/emails/${id}/unmark-template`)
  }

  async createCampaignFromTemplate(id) {
    return this.post(`/api/admin/emails/${id}/create-from-template`)
  }

  async listEmailAttachments(id) {
    return this.get(`/api/admin/emails/${id}/attachments`)
  }

  async uploadEmailAttachment(id, file) {
    const fd = new FormData()
    fd.append('attachment', file)
    return this.upload(`/api/admin/emails/${id}/attachments`, fd)
  }

  async deleteEmailAttachment(id, attachmentId) {
    return this.delete(`/api/admin/emails/${id}/attachments/${attachmentId}`)
  }

  // News API methods
  async getNews(params = {}) {
    const queryString = new URLSearchParams(params).toString()
    const endpoint = queryString ? `/api/news-v2?${queryString}` : '/api/news-v2'
    return this.get(endpoint)
  }

  async getNewsItem(id) {
    return this.get(`/api/news-v2/${id}`)
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
    const endpoint = queryString ? `/api/publications-v2?${queryString}` : '/api/publications-v2'
    return this.get(endpoint)
  }

  async getPublication(id) {
    return this.get(`/api/publications-v2/${id}`)
  }

  async downloadPublication(id) {
    return this.get(`/api/publications-v2/${id}/download`)
  }

  // 経済統計レポート関連のメソッド
  async getEconomicReports(params = {}) {
    const queryString = new URLSearchParams(params).toString()
    const endpoint = queryString ? `/api/economic-reports?${queryString}` : '/api/economic-reports'
    return this.get(endpoint)
  }

  async getEconomicReport(id) {
    return this.get(`/api/economic-reports/${id}`)
  }

  async getFeaturedEconomicReport() {
    return this.get('/api/economic-reports/featured')
  }

  async getEconomicReportCategories() {
    return this.get('/api/economic-reports/categories')
  }

  async getEconomicReportYears() {
    return this.get('/api/economic-reports/years')
  }

  async downloadEconomicReport(id) {
    return this.post(`/api/economic-reports/${id}/download`)
  }

  // Economic Indicators (public)
  async getIndicatorCategories() {
    return this.get('/api/economic-indicators/categories')
  }

  async getIndicators(params = {}) {
    const queryString = new URLSearchParams(params).toString()
    const endpoint = queryString ? `/api/economic-indicators?${queryString}` : '/api/economic-indicators'
    return this.get(endpoint)
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
    // Use v2 endpoint to align with admin listing
    return this.post('/api/inquiries-v2', inquiryData)
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
    return this.post(`/api/admin/inquiries-v2/${id}/respond`, null, {
      headers: {
        'Authorization': `Bearer ${token}`
      }
    })
  }

  async getAdminInquiries(params = {}, token) {
    const queryString = new URLSearchParams(params).toString()
    const endpoint = queryString ? `/api/admin/inquiries-v2?${queryString}` : '/api/admin/inquiries-v2'
    // トークンは自動的にrequestメソッドで付与される
    return this.get(endpoint)
  }

  async deleteInquiry(id, token) {
    return this.delete(`/api/admin/inquiries-v2/${id}`, {
      headers: {
        'Authorization': `Bearer ${token}`
      }
    })
  }

  // Auth API methods (to be implemented)
  async login(credentials) {
    // Use member auth endpoints for member login
    return this.post('/api/member-auth/login', credentials)
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
  async getAdminSeminars(params = {}) {
    const queryString = new URLSearchParams(params).toString()
    const endpoint = queryString ? `/api/admin/seminars?${queryString}` : '/api/admin/seminars'
    // トークンは自動的にrequestメソッドで付与される
    return this.get(endpoint)
  }

  // Admin seminar registrations management
  async getAdminSeminarRegistrations(seminarId, params = {}) {
    const endpoint = `/api/admin/seminars/${seminarId}/registrations`
    return this.get(endpoint, { params })
  }
  async approveAdminSeminarRegistration(seminarId, regId) {
    const endpoint = `/api/admin/seminars/${seminarId}/registrations/${regId}/approve`
    return this.post(endpoint)
  }
  async rejectAdminSeminarRegistration(seminarId, regId, reason = '') {
    const endpoint = `/api/admin/seminars/${seminarId}/registrations/${regId}/reject`
    return this.post(endpoint, { reason })
  }
  async bulkApproveAdminSeminarRegistrations(seminarId, registrationIds = []) {
    const endpoint = `/api/admin/seminars/${seminarId}/registrations/bulk-approve`
    return this.post(endpoint, { registration_ids: registrationIds })
  }

  async getAdminNews(params = {}) {
    const queryString = new URLSearchParams(params).toString()
    const endpoint = queryString ? `/api/admin/news-v2?${queryString}` : '/api/admin/news-v2'
    // トークンは自動的にrequestメソッドで付与される
    return this.get(endpoint)
  }

  async getAdminPublications(params = {}) {
    const queryString = new URLSearchParams(params).toString()
    const endpoint = queryString ? `/api/admin/publications-v2?${queryString}` : '/api/admin/publications-v2'
    // トークンは自動的にrequestメソッドで付与される
    return this.get(endpoint)
  }

  // Admin: Economic Indicators
  async getAdminIndicators(params = {}) {
    const queryString = new URLSearchParams(params).toString()
    const endpoint = queryString ? `/api/admin/economic-indicators?${queryString}` : '/api/admin/economic-indicators'
    return this.get(endpoint)
  }

  async createAdminIndicator(data) {
    return this.post('/api/admin/economic-indicators', data)
  }

  async updateAdminIndicator(id, data) {
    return this.put(`/api/admin/economic-indicators/${id}`, data)
  }

  async deleteAdminIndicator(id) {
    return this.delete(`/api/admin/economic-indicators/${id}`)
  }

  // Admin: Indicator Categories
  async getAdminIndicatorCategories() {
    return this.get('/api/admin/economic-indicator-categories')
  }

  async createAdminIndicatorCategory(data) {
    return this.post('/api/admin/economic-indicator-categories', data)
  }

  async updateAdminIndicatorCategory(id, data) {
    return this.put(`/api/admin/economic-indicator-categories/${id}`, data)
  }

  async deleteAdminIndicatorCategory(id) {
    return this.delete(`/api/admin/economic-indicator-categories/${id}`)
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

  // デバッグ用: 管理者トークンを自動取得
  async getDebugAdminToken() {
    try {
      const response = await this.post('/api/debug/admin-login')
      if (response.success && response.token) {
        // localStorageに保存して次回以降も使用可能に
        localStorage.setItem('admin_token', response.token)
        localStorage.setItem('adminUser', JSON.stringify(response.user))
        return response.token
      }
      return null
    } catch (error) {
      console.error('Failed to get debug admin token:', error)
      return null
    }
  }
}

// Export a singleton instance
export default new ApiClient()
