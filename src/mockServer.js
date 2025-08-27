// Mock API Server for testing CMS functionality
const mockData = {
  seminars: [
    {
      id: 1,
      title: '採用力強化！経営・人事向け　面接官トレーニングセミナー',
      description: '優秀な人材を見極め、獲得するための面接技術を習得できるセミナーを開催します。',
      date: '2025-06-15',
      start_time: '14:00',
      end_time: '17:00',
      location: 'ちくぎん地域経済研究所 会議室A',
      capacity: 30,
      fee: 5000,
      status: 'ongoing'
    },
    {
      id: 2,
      title: 'DX推進セミナー',
      description: 'デジタルトランスフォーメーションの基礎から実践まで学べるセミナーです。',
      date: '2025-06-20',
      start_time: '13:00',
      end_time: '16:00',
      location: 'オンライン開催',
      capacity: 100,
      fee: 3000,
      status: 'scheduled'
    }
  ],
  publications: [
    {
      id: 1,
      title: '事業継承から描く九州の未来',
      description: '最新の地域経済動向レポート。九州地域の製造業の動向と今後の展望について特集。',
      publication_date: '2025-04-28',
      category: 'research',
      type: 'pdf',
      author: 'ちくぎん地域経済研究所',
      pages: 45,
      file_url: '/files/kyushu-future.pdf',
      image_url: '', // 空にしてデフォルト画像を使用
      file_size: 2.1,
      download_count: 234,
      is_published: true,
      membershipLevel: 'premium' // プレミアム会員限定
    },
    {
      id: 2,
      title: '経営参考BOOK vol.52',
      description: '事業承継をテーマに、成功事例と具体的な進め方を解説。',
      publication_date: '2025-04-28',
      category: 'quarterly',
      type: 'pdf',
      author: 'ちくぎん地域経済研究所',
      pages: 32,
      file_url: '/files/management-book-52.pdf',
      image_url: '', // 空にしてデフォルト画像を使用
      file_size: 1.8,
      download_count: 156,
      is_published: true,
      membershipLevel: 'standard' // スタンダード会員以上
    },
    {
      id: 3,
      title: 'Hot Information Vol.323',
      description: '2025年度の経済展望と地域企業が取り組むべき課題について特集。',
      publication_date: '2025-04-28',
      category: 'special',
      type: 'pdf',
      author: 'ちくぎん地域経済研究所',
      pages: 28,
      file_url: '/files/hot-info-323.pdf',
      image_url: '', // 空にしてデフォルト画像を使用
      file_size: 1.5,
      download_count: 89,
      is_published: true,
      membershipLevel: 'basic' // ベーシック会員以上
    },
    {
      id: 4,
      title: 'Hot Information Vol.324',
      description: 'DX推進のポイントや、新たな成長戦略について詳しく解説。',
      publication_date: '2025-05-01',
      category: 'special',
      type: 'pdf',
      author: 'ちくぎん地域経済研究所',
      pages: 35,
      file_url: '/files/hot-info-324.pdf',
      image_url: '/img/-----2-2-4.png', // この1つだけCMS画像設定例として残す
      file_size: 2.0,
      download_count: 45,
      is_published: true,
      membershipLevel: 'free' // 無料公開
    }
  ],
  notices: [
    {
      id: 1,
      title: 'GW休業のお知らせ',
      content: '5月3日から5月6日まで休業いたします。',
      date: '2025-06-20',
      category: 'notice',
      isImportant: true
    },
    {
      id: 2,
      title: 'ホームページリニューアルのお知らせ',
      content: 'より使いやすいホームページにリニューアルしました。',
      date: '2025-06-15',
      category: 'notice',
      isImportant: false
    },
    {
      id: 3,
      title: '新年度の経済展望について',
      content: '2025年度の九州地域経済展望レポートを公開しました。',
      date: '2025-05-12',
      category: 'notice',
      isImportant: true
    }
  ],
  media: [
    {
      id: 1,
      title: '地域経済レポート2025',
      url: '/media/report-2025.jpg',
      type: 'image',
      uploadedDate: '2025-05-01'
    },
    {
      id: 2,
      title: 'セミナー資料',
      url: '/media/seminar-doc.pdf',
      type: 'document',
      uploadedDate: '2025-04-28'
    }
  ],
  members: [
    {
      id: 1,
      name: '山田太郎',
      email: 'yamada@example.com',
      company: '株式会社サンプル',
      membershipType: 'premium',
      joinedDate: '2024-01-15',
      status: 'active'
    },
    {
      id: 2,
      name: '鈴木花子',
      email: 'suzuki@example.com',
      company: '有限会社テスト',
      membershipType: 'standard',
      joinedDate: '2024-03-20',
      status: 'active'
    }
  ],
  pages: {
    // 基本ページ
    home: {
      title: 'トップページ',
      content: 'ちくぎん地域経済研究所のメインページ',
      lastUpdated: '2025-05-01'
    },
    about: {
      title: 'ちくぎん地域経済研究所について',
      content: '地域経済の発展に貢献する研究機関です。',
      lastUpdated: '2025-05-01'
    },
    services: {
      title: 'サービス一覧',
      content: '経済調査、コンサルティング、セミナー開催など',
      lastUpdated: '2025-04-28'
    },
    // ニュース・お知らせ関連
    news: {
      title: 'お知らせ',
      content: 'お知らせ一覧ページ',
      lastUpdated: '2025-04-28'
    },
    newsDetail: {
      title: 'お知らせ詳細',
      content: 'お知らせ記事の詳細ページ',
      lastUpdated: '2025-04-28'
    },
    // セミナー関連
    seminars: {
      title: 'セミナー',
      content: 'セミナー情報ページ',
      lastUpdated: '2025-04-28'
    },
    seminarRegistration: {
      title: 'セミナー申込',
      content: 'セミナー申込フォーム',
      lastUpdated: '2025-04-28'
    },
    // 刊行物関連
    publications: {
      title: '刊行物',
      content: '刊行物一覧ページ',
      lastUpdated: '2025-04-28'
    },
    publicationDetail: {
      title: '刊行物詳細',
      content: '刊行物詳細ページ',
      lastUpdated: '2025-04-28'
    },
    // 会員関連
    memberLogin: {
      title: '会員ログイン',
      content: '会員ログインページ',
      lastUpdated: '2025-04-28'
    },
    memberRegister: {
      title: '会員登録',
      content: '会員登録ページ',
      lastUpdated: '2025-04-28'
    },
    myAccount: {
      title: 'マイアカウント',
      content: '会員マイページ',
      lastUpdated: '2025-04-28'
    },
    upgrade: {
      title: 'プランアップグレード',
      content: '会員プランアップグレードページ',
      lastUpdated: '2025-04-28'
    },
    // その他のページ
    faq: {
      title: 'よくある質問',
      content: 'よくある質問と回答',
      lastUpdated: '2025-04-28'
    },
    apply: {
      title: '申込みフォーム',
      content: '各種申込みフォーム',
      lastUpdated: '2025-04-28'
    },
    contact: {
      title: 'お問い合わせ',
      content: 'お問い合わせフォーム',
      lastUpdated: '2025-04-28'
    },
    glossary: {
      title: '用語集',
      content: '経済用語集',
      lastUpdated: '2025-04-28'
    },
    privacy: {
      title: 'プライバシーポリシー',
      content: 'プライバシーポリシーページ',
      lastUpdated: '2025-04-28'
    },
    terms: {
      title: '利用規約',
      content: '利用規約ページ',
      lastUpdated: '2025-04-28'
    },
    // 管理画面関連
    adminLogin: {
      title: '管理者ログイン',
      content: '管理者ログインページ',
      lastUpdated: '2025-04-28'
    },
    adminDashboard: {
      title: '管理ダッシュボード',
      content: '管理画面のダッシュボード',
      lastUpdated: '2025-04-28'
    },
    // テスト・開発用
    test: {
      title: 'テストページ',
      content: 'Vue.js動作確認用テストページ',
      lastUpdated: '2025-04-28'
    }
  }
}

// localStorage を使用してデータを永続化
const STORAGE_KEY = 'cms_mock_data'

class MockAPIServer {
  constructor() {
    this.loadData()
  }

  loadData() {
    const savedData = localStorage.getItem(STORAGE_KEY)
    console.log('Loading data from localStorage...')
    if (savedData) {
      this.data = JSON.parse(savedData)
      console.log('Data loaded from localStorage:', this.data)
      console.log('Pages in loaded data:', this.data.pages)
    } else {
      console.log('No saved data, using default mockData')
      this.data = mockData
      this.saveData()
      console.log('Default data saved and loaded:', this.data)
    }
  }

  saveData() {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(this.data))
  }

  // Seminars
  getSeminars() {
    return Promise.resolve(this.data.seminars)
  }

  getSeminar(id) {
    const seminar = this.data.seminars.find(s => s.id === parseInt(id))
    if (seminar) {
      return Promise.resolve(seminar)
    }
    return Promise.reject(new Error('Seminar not found'))
  }

  createSeminar(data) {
    const newSeminar = {
      ...data,
      id: Math.max(...this.data.seminars.map(s => s.id), 0) + 1
    }
    this.data.seminars.push(newSeminar)
    this.saveData()
    return Promise.resolve(newSeminar)
  }

  updateSeminar(id, data) {
    const index = this.data.seminars.findIndex(s => s.id === parseInt(id))
    if (index !== -1) {
      this.data.seminars[index] = { ...this.data.seminars[index], ...data }
      this.saveData()
      return Promise.resolve(this.data.seminars[index])
    }
    return Promise.reject(new Error('Seminar not found'))
  }

  deleteSeminar(id) {
    const index = this.data.seminars.findIndex(s => s.id === parseInt(id))
    if (index !== -1) {
      this.data.seminars.splice(index, 1)
      this.saveData()
      return Promise.resolve({ success: true })
    }
    return Promise.reject(new Error('Seminar not found'))
  }

  // Publications
  getPublications() {
    return Promise.resolve(this.data.publications)
  }
  
  getPublication(id) {
    const publication = this.data.publications.find(p => p.id === parseInt(id))
    if (publication) {
      return Promise.resolve(publication)
    }
    return Promise.reject(new Error('Publication not found'))
  }

  createPublication(data) {
    const newPublication = {
      ...data,
      id: Math.max(...this.data.publications.map(p => p.id), 0) + 1
    }
    this.data.publications.push(newPublication)
    this.saveData()
    return Promise.resolve(newPublication)
  }

  updatePublication(id, data) {
    const index = this.data.publications.findIndex(p => p.id === parseInt(id))
    if (index !== -1) {
      this.data.publications[index] = { ...this.data.publications[index], ...data }
      this.saveData()
      return Promise.resolve(this.data.publications[index])
    }
    return Promise.reject(new Error('Publication not found'))
  }

  deletePublication(id) {
    const index = this.data.publications.findIndex(p => p.id === parseInt(id))
    if (index !== -1) {
      this.data.publications.splice(index, 1)
      this.saveData()
      return Promise.resolve({ success: true })
    }
    return Promise.reject(new Error('Publication not found'))
  }

  // Notices
  getNotices() {
    return Promise.resolve(this.data.notices)
  }

  getNotice(id) {
    const notice = this.data.notices.find(n => n.id === parseInt(id))
    if (notice) {
      return Promise.resolve(notice)
    }
    return Promise.reject(new Error('Notice not found'))
  }

  createNotice(data) {
    const newNotice = {
      ...data,
      id: Math.max(...this.data.notices.map(n => n.id), 0) + 1
    }
    this.data.notices.push(newNotice)
    this.saveData()
    return Promise.resolve(newNotice)
  }

  updateNotice(id, data) {
    const index = this.data.notices.findIndex(n => n.id === parseInt(id))
    if (index !== -1) {
      this.data.notices[index] = { ...this.data.notices[index], ...data }
      this.saveData()
      return Promise.resolve(this.data.notices[index])
    }
    return Promise.reject(new Error('Notice not found'))
  }

  deleteNotice(id) {
    const index = this.data.notices.findIndex(n => n.id === parseInt(id))
    if (index !== -1) {
      this.data.notices.splice(index, 1)
      this.saveData()
      return Promise.resolve({ success: true })
    }
    return Promise.reject(new Error('Notice not found'))
  }

  // Media
  getMedia() {
    return Promise.resolve(this.data.media)
  }

  getMediaItem(id) {
    const media = this.data.media.find(m => m.id === parseInt(id))
    if (media) {
      return Promise.resolve(media)
    }
    return Promise.reject(new Error('Media not found'))
  }

  uploadMedia(data) {
    const newMedia = {
      ...data,
      id: Math.max(...this.data.media.map(m => m.id), 0) + 1,
      uploadedDate: new Date().toISOString()
    }
    this.data.media.push(newMedia)
    this.saveData()
    return Promise.resolve(newMedia)
  }

  updateMedia(id, data) {
    const index = this.data.media.findIndex(m => m.id === parseInt(id))
    if (index !== -1) {
      this.data.media[index] = { ...this.data.media[index], ...data }
      this.saveData()
      return Promise.resolve(this.data.media[index])
    }
    return Promise.reject(new Error('Media not found'))
  }

  deleteMedia(id) {
    const index = this.data.media.findIndex(m => m.id === parseInt(id))
    if (index !== -1) {
      this.data.media.splice(index, 1)
      this.saveData()
      return Promise.resolve({ success: true })
    }
    return Promise.reject(new Error('Media not found'))
  }

  // Members
  getMembers() {
    return Promise.resolve(this.data.members)
  }

  getMember(id) {
    const member = this.data.members.find(m => m.id === parseInt(id))
    if (member) {
      return Promise.resolve(member)
    }
    return Promise.reject(new Error('Member not found'))
  }

  updateMember(id, data) {
    const index = this.data.members.findIndex(m => m.id === parseInt(id))
    if (index !== -1) {
      this.data.members[index] = { ...this.data.members[index], ...data }
      this.saveData()
      return Promise.resolve(this.data.members[index])
    }
    return Promise.reject(new Error('Member not found'))
  }

  // Member Authentication
  memberLogin(email, password) {
    // 簡易的な認証（実際のパスワード検証の代わり）
    const member = this.data.members.find(m => m.email === email && m.status === 'active')
    
    if (member) {
      // パスワードは仮で "password123" とする
      if (password === 'password123') {
        const token = 'member_token_' + Date.now()
        const userData = {
          id: member.id,
          name: member.name,
          email: member.email,
          company: member.company,
          membershipType: member.membershipType,
          expiryDate: member.expiryDate || '2025-12-31',
          token: token
        }
        return Promise.resolve({
          success: true,
          user: userData,
          token: token
        })
      }
    }
    
    return Promise.reject(new Error('メールアドレスまたはパスワードが正しくありません'))
  }

  // Get current member from token
  getCurrentMember(token) {
    if (!token || !token.startsWith('member_token_')) {
      return null
    }
    // 簡易実装: トークンがあれば最初のアクティブ会員を返す
    const member = this.data.members.find(m => m.status === 'active')
    if (member) {
      return {
        id: member.id,
        name: member.name,
        email: member.email,
        company: member.company,
        membershipType: member.membershipType,
        expiryDate: member.expiryDate || '2025-12-31'
      }
    }
    return null
  }

  // Check if member can access content
  canAccessContent(contentLevel, userMembershipType) {
    const levels = {
      'free': 0,
      'basic': 1,
      'standard': 2,
      'premium': 3
    }
    
    const contentRequirement = levels[contentLevel] || 0
    const userLevel = userMembershipType ? (levels[userMembershipType] || 0) : 0
    
    return userLevel >= contentRequirement
  }

  // Get restriction message
  getRestrictionMessage(contentLevel, userMembershipType) {
    if (!userMembershipType) {
      return '会員登録してアクセス'
    }
    
    const messages = {
      'basic': 'ベーシック会員以上で閲覧可能',
      'standard': 'スタンダード会員以上で閲覧可能',
      'premium': 'プレミアム会員限定コンテンツ'
    }
    
    return messages[contentLevel] || 'アップグレードが必要です'
  }

  memberRegister(data) {
    // 既存メールチェック
    const existingMember = this.data.members.find(m => m.email === data.email)
    if (existingMember) {
      return Promise.reject(new Error('このメールアドレスは既に登録されています'))
    }
    
    const newMember = {
      id: Math.max(...this.data.members.map(m => m.id), 0) + 1,
      name: data.name,
      email: data.email,
      company: data.company || '',
      membershipType: data.membershipType || 'basic', // デフォルトはベーシック会員
      joinedDate: new Date().toISOString().split('T')[0],
      status: 'active'
    }
    
    this.data.members.push(newMember)
    this.saveData()
    
    const token = 'member_token_' + Date.now()
    return Promise.resolve({
      success: true,
      user: newMember,
      token: token
    })
  }

  // Pages
  getPages() {
    // ページオブジェクトを配列形式で返す
    console.log('MockServer getPages called')
    console.log('Current pages data:', this.data.pages)
    const pagesArray = Object.entries(this.data.pages).map(([key, value]) => ({
      pageKey: key,
      ...value
    }))
    console.log('Returning pages array:', pagesArray)
    return Promise.resolve(pagesArray)
  }

  getPage(pageKey) {
    const page = this.data.pages[pageKey]
    if (page) {
      return Promise.resolve({ pageKey, ...page })
    }
    return Promise.reject(new Error('Page not found'))
  }

  updatePage(pageKey, data) {
    if (this.data.pages[pageKey]) {
      this.data.pages[pageKey] = {
        ...this.data.pages[pageKey],
        ...data,
        lastUpdated: new Date().toISOString()
      }
      this.saveData()
      return Promise.resolve({ pageKey, ...this.data.pages[pageKey] })
    }
    return Promise.reject(new Error('Page not found'))
  }

  // Get all news items for NewsPage
  getAllNews() {
    const news = []
    
    // Convert seminars to news items
    this.data.seminars.forEach(seminar => {
      news.push({
        id: `seminar-${seminar.id}`,
        date: seminar.date,
        category: 'seminar',
        title: seminar.title,
        description: seminar.description,
        type: 'seminar'
      })
    })
    
    // Convert publications to news items
    this.data.publications.forEach(publication => {
      news.push({
        id: `publication-${publication.id}`,
        date: publication.publication_date, // 正しいフィールド名を使用
        category: 'publication',
        title: publication.title,
        description: publication.description,
        type: 'publication'
      })
    })
    
    // Convert notices to news items
    this.data.notices.forEach(notice => {
      news.push({
        id: `notice-${notice.id}`,
        date: notice.date,
        category: notice.category,
        title: notice.title,
        description: notice.content,
        isImportant: notice.isImportant,
        type: 'notice'
      })
    })
    
    // Sort by date (newest first)
    news.sort((a, b) => new Date(b.date) - new Date(a.date))
    
    return Promise.resolve(news)
  }
}

// Export singleton instance
export default new MockAPIServer()