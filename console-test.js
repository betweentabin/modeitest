// ブラウザのコンソールで実行するテストコマンド
// HomePage (http://localhost:8081) を開いて、F12でコンソールを開き、以下のコマンドを貼り付けて実行してください

// ========================================
// 1. LocalStorageの現在のデータを確認
// ========================================
console.log('=== LocalStorage確認 ===');
const currentData = localStorage.getItem('cms_mock_data');
if (currentData) {
  const data = JSON.parse(currentData);
  console.log('現在のデータ:', data);
  console.log('セミナー数:', data.seminars ? data.seminars.length : 0);
  console.log('刊行物数:', data.publications ? data.publications.length : 0);
  console.log('お知らせ数:', data.notices ? data.notices.length : 0);
} else {
  console.log('LocalStorageにデータがありません');
}

// ========================================
// 2. テストデータを追加（コピーして実行）
// ========================================
const testData = {
  seminars: [
    {
      id: 1001,
      title: '【テスト】採用力強化セミナー',
      description: 'テスト用セミナーです',
      date: '2025-08-27',
      start_time: '14:00',
      end_time: '17:00',
      location: 'オンライン',
      capacity: 30,
      fee: 5000,
      status: 'ongoing'
    },
    {
      id: 1002,
      title: '【テスト】DX推進セミナー',
      description: 'デジタル変革について',
      date: '2025-09-01',
      start_time: '13:00',
      end_time: '16:00',
      location: 'ちくぎん会議室',
      capacity: 100,
      fee: 3000,
      status: 'scheduled'
    }
  ],
  publications: [
    {
      id: 2001,
      title: 'HOT Information Vol.999（テスト）',
      description: 'テスト用刊行物',
      publishedDate: '2025-08-26',
      category: 'monthly',
      fileUrl: '/files/test.pdf'
    },
    {
      id: 2002,
      title: '経営参考BOOK Vol.100（テスト）',
      description: 'テスト用書籍',
      publishedDate: '2025-08-25',
      category: 'book',
      fileUrl: '/files/test2.pdf'
    }
  ],
  notices: [
    {
      id: 3001,
      title: '【重要】テストお知らせ1',
      content: 'これはテスト用の重要なお知らせです',
      date: '2025-08-27',
      category: 'notice',
      isImportant: true
    },
    {
      id: 3002,
      title: 'テストお知らせ2',
      content: '通常のテストお知らせ',
      date: '2025-08-26',
      category: 'notice',
      isImportant: false
    }
  ],
  media: [],
  members: [],
  pages: {
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
    seminars: {
      title: 'セミナー',
      content: 'セミナー情報ページ',
      lastUpdated: '2025-04-28'
    },
    publications: {
      title: '刊行物',
      content: '刊行物一覧ページ',
      lastUpdated: '2025-04-28'
    },
    news: {
      title: 'お知らせ',
      content: 'お知らせ一覧ページ',
      lastUpdated: '2025-04-28'
    },
    contact: {
      title: 'お問い合わせ',
      content: 'お問い合わせフォーム',
      lastUpdated: '2025-04-28'
    },
    faq: {
      title: 'よくある質問',
      content: 'よくある質問と回答',
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
    }
  }
};

localStorage.setItem('cms_mock_data', JSON.stringify(testData));
console.log('✅ テストデータを追加しました！');
console.log('ページをリロードして確認してください');

// ========================================
// 3. HomePage を手動でリロード
// ========================================
// location.reload();

// ========================================
// 4. データをクリア
// ========================================
// localStorage.removeItem('cms_mock_data');
// console.log('データをクリアしました');