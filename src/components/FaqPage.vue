<template>
  <div class="page-container">
    <Navigation />
    <div class="page-content">
      <div class="page-header">
        <h1>よくあるご質問</h1>
        <p class="subtitle">FAQ</p>
        <p class="description">お客様からよくいただくご質問をまとめました</p>
      </div>
      
      <div class="faq-search">
        <input 
          type="text" 
          v-model="searchQuery" 
          placeholder="質問を検索..." 
          class="search-input"
        />
        <button class="search-btn">検索</button>
      </div>
      
      <div class="faq-categories">
        <button 
          v-for="category in categories" 
          :key="category.id"
          :class="['category-btn', { active: selectedCategory === category.id }]"
          @click="selectedCategory = category.id"
        >
          <span class="category-icon">{{ category.icon }}</span>
          <span>{{ category.name }}</span>
        </button>
      </div>
      
      <div class="faq-list">
        <div v-for="(item, index) in filteredFaqs" :key="index" class="faq-item">
          <div class="faq-question" @click="toggleAnswer(index)">
            <span class="q-mark">Q</span>
            <span class="question-text">{{ item.question }}</span>
            <span class="toggle-icon" :class="{ open: openItems.includes(index) }">
              <svg width="20" height="20" viewBox="0 0 20 20">
                <path d="M5 7.5L10 12.5L15 7.5" stroke="currentColor" stroke-width="2" fill="none"/>
              </svg>
            </span>
          </div>
          <transition name="slide">
            <div v-if="openItems.includes(index)" class="faq-answer">
              <span class="a-mark">A</span>
              <span class="answer-text" v-html="item.answer"></span>
            </div>
          </transition>
        </div>
        
        <div v-if="filteredFaqs.length === 0" class="no-results">
          <p>該当する質問が見つかりませんでした。</p>
          <p>お探しの情報が見つからない場合は、お問い合わせください。</p>
        </div>
      </div>
      
      <div class="contact-section">
        <h2>お探しの答えが見つかりませんか？</h2>
        <p>その他のご質問については、お気軽にお問い合わせください</p>
        <div class="contact-methods">
          <div class="contact-card">
            <div class="contact-icon">📞</div>
            <h3>お電話でのお問い合わせ</h3>
            <p class="contact-info">0942-46-5081</p>
            <p class="contact-hours">平日 9:00～17:00</p>
          </div>
          <div class="contact-card">
            <div class="contact-icon">✉️</div>
            <h3>メールでのお問い合わせ</h3>
            <p class="contact-info">info@chikugin-ri.co.jp</p>
            <p class="contact-hours">24時間受付</p>
          </div>
          <div class="contact-card">
            <div class="contact-icon">📝</div>
            <h3>お問い合わせフォーム</h3>
            <button class="form-btn" @click="$router.push('/contact')">
              フォームへ進む
            </button>
          </div>
        </div>
      </div>
    </div>
    <FooterComplete />
  </div>
</template>

<script>
import Navigation from "./Navigation.vue";
import FooterComplete from "./FooterComplete.vue";

export default {
  name: "FaqPage",
  components: {
    Navigation,
    FooterComplete
  },
  data() {
    return {
      searchQuery: "",
      selectedCategory: "all",
      openItems: [],
      categories: [
        { id: "all", name: "すべて", icon: "📋" },
        { id: "membership", name: "会員登録", icon: "👤" },
        { id: "service", name: "サービス内容", icon: "💼" },
        { id: "payment", name: "料金・支払い", icon: "💳" },
        { id: "seminar", name: "セミナー", icon: "🎓" },
        { id: "publication", name: "刊行物", icon: "📚" },
        { id: "other", name: "その他", icon: "❓" }
      ],
      faqs: [
        {
          category: "membership",
          question: "会員登録の方法を教えてください。",
          answer: "会員登録は以下の方法で行えます：<br/>1. オンラインフォームからのお申し込み<br/>2. 申込書を郵送でのお申し込み<br/>3. 当研究所窓口での直接お申し込み<br/><br/>必要書類をご提出後、審査を経て会員登録が完了します。審査には通常3～5営業日かかります。"
        },
        {
          category: "membership",
          question: "入会金や年会費はいくらですか？",
          answer: "会員種別により以下の料金となります：<br/><br/><strong>プレミアム会員</strong><br/>年会費：360,000円<br/><br/><strong>スタンダード会員</strong><br/>年会費：120,000円<br/><br/>※初年度は入会金は無料です。"
        },
        {
          category: "membership",
          question: "会員の種類と特典の違いを教えてください。",
          answer: "スタンダード会員は基本的なサービスをご利用いただけます。プレミアム会員は、全てのスタンダード会員特典に加え、専門コンサルタントによる個別相談（無制限）、オーダーメイド調査（年1回）、社内研修の企画・実施（年2回）などの特典があります。"
        },
        {
          category: "service",
          question: "どのようなレポートが閲覧できますか？",
          answer: "以下のレポートをご覧いただけます：<br/>• HOT Information（月刊）<br/>• 経営参考BOOK（季刊）<br/>• 地域経済動向レポート（月次）<br/>• 業界別市場分析レポート（四半期）<br/>• 年次経済白書<br/><br/>会員様は過去のアーカイブも含めて全て無料で閲覧可能です。"
        },
        {
          category: "service",
          question: "コンサルティングサービスの内容を教えてください。",
          answer: "経営戦略立案、事業計画策定、業務改善、人材育成、事業承継、M&Aアドバイザリーなど、幅広い分野でコンサルティングサービスを提供しています。初回相談は無料で承っております。"
        },
        {
          category: "seminar",
          question: "セミナーの開催頻度と参加方法を教えてください。",
          answer: "毎月2～3回のペースで各種セミナーを開催しています。開催情報は会員様にメールでご案内するほか、ホームページでも公開しています。会員様は優先的にご参加いただけ、参加費も割引となります。"
        },
        {
          category: "seminar",
          question: "オンラインセミナーは実施していますか？",
          answer: "はい、実施しています。現在、対面セミナーとオンラインセミナーのハイブリッド形式で開催しており、遠方の会員様にもご参加いただけるようになっています。録画配信も行っており、後日視聴も可能です。"
        },
        {
          category: "payment",
          question: "支払い方法を教えてください。",
          answer: "以下のお支払い方法をご利用いただけます：<br/>• 銀行振込<br/>• 口座振替（自動引き落とし）<br/>• クレジットカード（VISA、MasterCard、JCB、AMEX）<br/><br/>年払い・半年払い・月払いからお選びいただけます。年払いの場合は5%の割引が適用されます。"
        },
        {
          category: "payment",
          question: "領収書や請求書は発行してもらえますか？",
          answer: "はい、発行可能です。マイページから電子領収書・請求書をダウンロードいただけます。郵送での発行をご希望の場合は、事務局までご連絡ください。"
        },
        {
          category: "payment",
          question: "途中解約や返金は可能ですか？",
          answer: "途中解約は可能です。月払いの場合は翌月から課金停止となります。年払いで既にお支払いいただいた分については、残期間に応じて日割り計算で返金いたします（手数料を除く）。"
        },
        {
          category: "publication",
          question: "刊行物の購入方法を教えてください。",
          answer: "会員様はマイページから無料でダウンロード可能です。非会員の方は、個別購入も可能です。オンラインショップまたは電話・FAXでご注文ください。"
        },
        {
          category: "publication",
          question: "過去の刊行物は入手できますか？",
          answer: "過去5年分の刊行物はアーカイブとして保管しており、会員様は無料で閲覧・ダウンロード可能です。それ以前のものについては、個別にお問い合わせください。"
        },
        {
          category: "other",
          question: "パスワードを忘れてしまいました。",
          answer: "ログイン画面の「パスワードを忘れた方」リンクをクリックし、登録メールアドレスを入力してください。パスワード再設定用のリンクをメールでお送りします。メールが届かない場合は、迷惑メールフォルダをご確認ください。"
        },
        {
          category: "other",
          question: "登録情報の変更方法を教えてください。",
          answer: "マイページにログイン後、「会員情報編集」から変更可能です。会社名、部署名、住所、電話番号、メールアドレスなどの基本情報を更新できます。変更は即座に反映されます。"
        },
        {
          category: "other",
          question: "退会手続きの方法を教えてください。",
          answer: "マイページの「退会手続き」から申請いただくか、お電話（0942-46-5081）にてご連絡ください。退会処理完了まで約1週間かかります。なお、退会後も過去のご利用履歴は一定期間保管されます。"
        }
      ]
    };
  },
  computed: {
    filteredFaqs() {
      let faqs = this.faqs;
      
      if (this.selectedCategory !== "all") {
        faqs = faqs.filter(faq => faq.category === this.selectedCategory);
      }
      
      if (this.searchQuery) {
        const query = this.searchQuery.toLowerCase();
        faqs = faqs.filter(faq => 
          faq.question.toLowerCase().includes(query) || 
          faq.answer.toLowerCase().includes(query)
        );
      }
      
      return faqs;
    }
  },
  methods: {
    toggleAnswer(index) {
      const position = this.openItems.indexOf(index);
      if (position > -1) {
        this.openItems.splice(position, 1);
      } else {
        this.openItems.push(index);
      }
    }
  }
};
</script>

<style scoped>
.page-container {
  min-height: 100vh;
  background-color: #f8f9fa;
}

.page-content {
  max-width: 1000px;
  margin: 0 auto;
  padding: 40px 20px;
}

.page-header {
  text-align: center;
  margin-bottom: 40px;
}

.page-header h1 {
  font-size: 2.5rem;
  color: #333;
  margin-bottom: 10px;
}

.subtitle {
  color: #dc3545;
  font-size: 1.2rem;
  font-weight: 600;
  letter-spacing: 2px;
  margin-bottom: 10px;
}

.description {
  color: #666;
  font-size: 1.1rem;
}

.faq-search {
  display: flex;
  max-width: 600px;
  margin: 0 auto 40px;
  gap: 10px;
}

.search-input {
  flex: 1;
  padding: 12px 20px;
  border: 2px solid #dee2e6;
  border-radius: 50px;
  font-size: 1rem;
}

.search-btn {
  padding: 12px 30px;
  background: #dc3545;
  color: white;
  border: none;
  border-radius: 50px;
  cursor: pointer;
  transition: background 0.3s;
}

.search-btn:hover {
  background: #c82333;
}

.faq-categories {
  display: flex;
  justify-content: center;
  gap: 10px;
  margin-bottom: 40px;
  flex-wrap: wrap;
}

.category-btn {
  display: flex;
  align-items: center;
  gap: 5px;
  padding: 10px 20px;
  background: white;
  border: 2px solid #dee2e6;
  border-radius: 25px;
  cursor: pointer;
  transition: all 0.3s;
  font-size: 0.95rem;
}

.category-icon {
  font-size: 1.2rem;
}

.category-btn:hover {
  background: #f8f9fa;
}

.category-btn.active {
  background: #dc3545;
  color: white;
  border-color: #dc3545;
}

.faq-list {
  background: white;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
  margin-bottom: 60px;
}

.faq-item {
  border-bottom: 1px solid #e9ecef;
}

.faq-item:last-child {
  border-bottom: none;
}

.faq-question {
  padding: 25px;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 15px;
  transition: background-color 0.3s;
}

.faq-question:hover {
  background-color: #f8f9fa;
}

.q-mark, .a-mark {
  width: 35px;
  height: 35px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: bold;
  flex-shrink: 0;
  font-size: 1.1rem;
}

.q-mark {
  background: #dc3545;
  color: white;
}

.a-mark {
  background: #28a745;
  color: white;
}

.question-text {
  flex: 1;
  font-weight: 500;
  color: #333;
  font-size: 1.1rem;
}

.toggle-icon {
  color: #666;
  transition: transform 0.3s;
}

.toggle-icon.open {
  transform: rotate(180deg);
}

.faq-answer {
  padding: 25px;
  padding-top: 0;
  background: #fff;
  display: flex;
  gap: 15px;
  align-items: flex-start;
  border-top: 1px solid #f0f0f0;
}

.answer-text {
  flex: 1;
  line-height: 1.8;
  color: #555;
}

.no-results {
  padding: 60px;
  text-align: center;
  color: #666;
}

.no-results p {
  margin: 10px 0;
}

.contact-section {
  background: white;
  padding: 60px;
  border-radius: 10px;
  text-align: center;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.contact-section h2 {
  color: #dc3545;
  font-size: 2rem;
  margin-bottom: 10px;
}

.contact-section > p {
  color: #666;
  font-size: 1.1rem;
  margin-bottom: 40px;
}

.contact-methods {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 30px;
  margin-top: 40px;
}

.contact-card {
  padding: 30px;
  border: 2px solid #dee2e6;
  border-radius: 10px;
  transition: all 0.3s;
}

.contact-card:hover {
  border-color: #dc3545;
  transform: translateY(-5px);
  box-shadow: 0 5px 15px rgba(220, 53, 69, 0.2);
}

.contact-icon {
  font-size: 3rem;
  margin-bottom: 20px;
}

.contact-card h3 {
  color: #333;
  font-size: 1.2rem;
  margin-bottom: 15px;
}

.contact-info {
  color: #dc3545;
  font-size: 1.1rem;
  font-weight: 600;
  margin-bottom: 5px;
}

.contact-hours {
  color: #666;
  font-size: 0.9rem;
}

.form-btn {
  margin-top: 15px;
  padding: 10px 30px;
  background: #dc3545;
  color: white;
  border: none;
  border-radius: 25px;
  cursor: pointer;
  transition: all 0.3s;
}

.form-btn:hover {
  background: #c82333;
  transform: scale(1.05);
}

.slide-enter-active, .slide-leave-active {
  transition: all 0.3s ease;
}

.slide-enter, .slide-leave-to {
  opacity: 0;
  max-height: 0;
}

@media (max-width: 768px) {
  .faq-search {
    flex-direction: column;
  }
  
  .contact-methods {
    grid-template-columns: 1fr;
  }
}
</style>