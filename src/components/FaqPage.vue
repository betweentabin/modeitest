<template>
  <div class="page-container">
    <Navigation />
    
    <!-- Hero Section -->
    <div class="hero-section">
      <div class="hero-overlay">
        <div class="hero-content">
          <h1 class="hero-title">よくあるご質問</h1>
          <p class="hero-subtitle">FAQ</p>
        </div>
      </div>
    </div>

    <div class="page-content">
      <div class="faq-header">
        <h2 class="section-title">よくあるご質問</h2>
        <p class="section-subtitle">FAQ</p>
      </div>
      
      <div class="faq-categories">
        <button 
          v-for="category in categories" 
          :key="category.id"
          :class="['category-btn', { active: selectedCategory === category.id }]"
          @click="selectedCategory = category.id"
        >
          {{ category.name }}
        </button>
      </div>
      
      <div class="faq-list">
        <div v-for="(item, index) in filteredFaqs" :key="index" class="faq-item">
          <div class="faq-question" @click="toggleAnswer(index)">
            <div class="q-circle">
              <span class="q-mark">Q</span>
            </div>
            <span class="question-text">{{ item.question }}</span>
            <span class="toggle-icon" :class="{ open: openItems.includes(index) }">
              <svg width="20" height="20" viewBox="0 0 20 20">
                <path d="M5 7.5L10 12.5L15 7.5" stroke="currentColor" stroke-width="2" fill="none"/>
              </svg>
            </span>
          </div>
          <transition name="slide">
            <div v-if="openItems.includes(index)" class="faq-answer">
              <div class="a-circle">
                <span class="a-mark">A</span>
              </div>
              <div class="answer-content">
                <div v-if="item.tags && item.tags.length" class="answer-tags">
                  <span v-for="tag in item.tags" :key="tag" class="tag">{{ tag }}</span>
                </div>
                <div class="answer-text" v-html="item.answer"></div>
              </div>
            </div>
          </transition>
        </div>
      </div>
    </div>

    <!-- CTA Section -->
    <section class="cta-section">
      <div class="container">
        <div class="cta-content">
          <h2>株式会社ちくぎん地域経済研究所</h2>
          <p>様々な分野の調査研究を通じ、企業活動などをサポートします。</p>
          <button class="cta-button" @click="scrollToContact">お問い合わせはこちら</button>
        </div>
      </div>
    </section>

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
      searchQuery: '',
      selectedCategory: 'all',
      openItems: [],
      categories: [
        { id: 'all', name: '全て' },
        { id: 'service', name: '各種サービスについて' },
        { id: 'membership', name: '会員について' },
        { id: 'research', name: '調査研究について' }
      ],
      faqs: [
        {
          category: 'service',
          question: '貴社にとってどんなサービスが提供されますか？',
          answer: `私たちは以下のようなサービスを提供しています：
            <ul>
              <li>地域経済に関するリサーチ・分析とレポートの作成をします</li>
              <li>経営戦略立案支援・事業計画策定・プロジェクト管理・経営指導等を実施しています</li>
            </ul>`,
          tags: []
        },
        {
          category: 'membership',
          question: '資料費どのくらいの会費を支払っているのですか？',
          answer: `
            <div class="answer-section">
              <div class="price-info">
                <strong>スタンダード会員</strong><br>
                年会費：12,000円（税別）月額1,000円程度
              </div>
              <div class="benefits">
                <strong>サービス内容：</strong>
                <ul>
                  <li>経済指標・市場分析・企業分析・業界動向・資産・投資・金融等専門経営指導プログラム（入会金別途要）</li>
                </ul>
              </div>
              <div class="price-info premium">
                <strong>プレミアム会員（推奨会員）</strong><br>
                ・ビジネスマッチング：最新の市場分析、事業承継等の支援<br>
                ・M&A（事業承継関連）
              </div>
            </div>`,
          tags: ['スタンダード会員', 'プレミアム会員']
        },
        {
          category: 'research',
          question: '研究会の開催はありますか？',
          answer: '定期的な研究会や勉強会を開催しており、会員の皆様にご参加いただけます。',
          tags: []
        },
        {
          category: 'membership',
          question: '会費減額、減額はどうしたら良いですか？',
          answer: '会費の減額や変更については、お気軽にお問い合わせください。',
          tags: []
        },
        {
          category: 'service',
          question: '経営診断をしたい場合どうすればいいの、態度を教えてほしい？',
          answer: '経営診断をご希望の場合は、まずはお問い合わせフォームよりご連絡ください。',
          tags: []
        },
        {
          category: 'service',
          question: '料金体系を教えて？',
          answer: 'サービスごとに料金体系が異なります。詳しくはお問い合わせください。',
          tags: []
        },
        {
          category: 'service',
          question: '入会は法人・個人でも申込める？',
          answer: '法人・個人を問わずご入会いただけます。',
          tags: []
        },
        {
          category: 'service',
          question: '入会したい場合の手続きはどうしたらいい？',
          answer: '入会手続きについては、お問い合わせフォームよりご連絡いただくか、直接お電話でお問い合わせください。',
          tags: []
        },
        {
          category: 'service',
          question: '会費はどうやって払う？',
          answer: '会費のお支払い方法は、銀行振込、口座振替等をご利用いただけます。',
          tags: []
        },
        {
          category: 'service',
          question: '会費の支払いはいつする？',
          answer: '会費のお支払いタイミングについては、入会時にご案内いたします。',
          tags: []
        }
      ]
    };
  },
  computed: {
    filteredFaqs() {
      let filtered = this.faqs;
      
      if (this.selectedCategory !== 'all') {
        filtered = filtered.filter(faq => faq.category === this.selectedCategory);
      }
      
      if (this.searchQuery) {
        const query = this.searchQuery.toLowerCase();
        filtered = filtered.filter(faq => 
          faq.question.toLowerCase().includes(query) ||
          faq.answer.toLowerCase().includes(query)
        );
      }
      
      return filtered;
    }
  },
  methods: {
    toggleAnswer(index) {
      const itemIndex = this.openItems.indexOf(index);
      if (itemIndex > -1) {
        this.openItems.splice(itemIndex, 1);
      } else {
        this.openItems.push(index);
      }
    },
    scrollToContact() {
      this.$router.push('/contact');
    }
  }
};
</script>

<style scoped>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

.page-container {
  min-height: 100vh;
  background-color: #ffffff;
}

/* Hero Section */
.hero-section {
  height: 300px;
  background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), 
              url('/img/hero-image.png') center/cover;
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
}

.hero-overlay {
  text-align: center;
  color: white;
}

.hero-title {
  font-size: 2.5rem;
  font-weight: bold;
  margin-bottom: 10px;
}

.hero-subtitle {
  font-size: 1rem;
  letter-spacing: 2px;
  color: #da5761;
}

/* Page Content */
.page-content {
  max-width: 1000px;
  margin: 0 auto;
  padding: 60px 20px;
}

.faq-header {
  text-align: center;
  margin-bottom: 50px;
}

.section-title {
  font-size: 2rem;
  color: #333;
  margin-bottom: 10px;
  font-weight: bold;
}

.section-subtitle {
  color: #da5761;
  font-size: 1rem;
  letter-spacing: 2px;
  font-weight: 500;
  position: relative;
  padding-bottom: 20px;
}

.section-subtitle::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 50%;
  transform: translateX(-50%);
  width: 60px;
  height: 2px;
  background-color: #da5761;
}

/* Categories */
.faq-categories {
  display: flex;
  justify-content: center;
  gap: 0;
  margin-bottom: 40px;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.category-btn {
  background: #f8f9fa;
  border: none;
  padding: 15px 25px;
  cursor: pointer;
  transition: all 0.3s;
  font-size: 0.9rem;
  color: #666;
  border-right: 1px solid #dee2e6;
}

.category-btn:last-child {
  border-right: none;
}

.category-btn.active,
.category-btn:hover {
  background: #da5761;
  color: white;
}

/* FAQ Items */
.faq-list {
  max-width: 800px;
  margin: 0 auto;
}

.faq-item {
  background: white;
  border-radius: 10px;
  margin-bottom: 15px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.05);
  overflow: hidden;
}

.faq-question {
  display: flex;
  align-items: center;
  padding: 20px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.faq-question:hover {
  background-color: #f8f9fa;
}

.q-circle {
  flex: 0 0 40px;
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background: #da5761;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-right: 15px;
}

.q-mark {
  color: white;
  font-weight: bold;
  font-size: 1.2rem;
}

.question-text {
  flex: 1;
  font-size: 1rem;
  color: #333;
  font-weight: 500;
}

.toggle-icon {
  color: #666;
  transition: transform 0.3s;
}

.toggle-icon.open {
  transform: rotate(180deg);
}

.faq-answer {
  display: flex;
  align-items: flex-start;
  padding: 0 20px 20px 20px;
  background-color: #f8f9fa;
  border-top: 1px solid #dee2e6;
}

.a-circle {
  flex: 0 0 40px;
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background: #28a745;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-right: 15px;
  margin-top: 5px;
}

.a-mark {
  color: white;
  font-weight: bold;
  font-size: 1.2rem;
}

.answer-content {
  flex: 1;
  padding-top: 5px;
}

.answer-tags {
  margin-bottom: 15px;
}

.tag {
  display: inline-block;
  background: #da5761;
  color: white;
  padding: 4px 12px;
  border-radius: 15px;
  font-size: 0.8rem;
  margin-right: 8px;
  margin-bottom: 5px;
}

.answer-text {
  color: #666;
  line-height: 1.6;
}

.answer-text ul {
  margin: 10px 0;
  padding-left: 20px;
}

.answer-text li {
  margin-bottom: 5px;
}

.answer-section {
  margin: 15px 0;
}

.price-info {
  background: #e8f4f8;
  padding: 15px;
  border-radius: 8px;
  margin-bottom: 15px;
  border-left: 4px solid #da5761;
}

.price-info.premium {
  background: #fff2e8;
  border-left-color: #ff8c00;
}

.benefits {
  background: #f0f8f0;
  padding: 15px;
  border-radius: 8px;
  margin-bottom: 15px;
  border-left: 4px solid #28a745;
}

/* Slide Animation */
.slide-enter-active,
.slide-leave-active {
  transition: all 0.3s ease;
}

.slide-enter-from,
.slide-leave-to {
  opacity: 0;
  max-height: 0;
  padding-top: 0;
  padding-bottom: 0;
}

.slide-enter-to,
.slide-leave-from {
  opacity: 1;
  max-height: 500px;
}

/* CTA Section */
.cta-section {
  background: linear-gradient(135deg, #da5761 0%, #c44853 100%);
  color: white;
  text-align: center;
  padding: 80px 0;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 20px;
}

.cta-content h2 {
  font-size: 2rem;
  margin-bottom: 20px;
  font-weight: bold;
}

.cta-content p {
  font-size: 1.1rem;
  margin-bottom: 30px;
}

.cta-button {
  background: white;
  color: #da5761;
  border: none;
  padding: 15px 40px;
  font-size: 1.1rem;
  border-radius: 50px;
  cursor: pointer;
  transition: transform 0.3s, box-shadow 0.3s;
  font-weight: bold;
}

.cta-button:hover {
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

/* Responsive Design */
@media (max-width: 768px) {
  .hero-title {
    font-size: 2rem;
  }
  
  .page-content {
    padding: 40px 15px;
  }
  
  .faq-categories {
    flex-direction: column;
  }
  
  .category-btn {
    border-right: none;
    border-bottom: 1px solid #dee2e6;
  }
  
  .category-btn:last-child {
    border-bottom: none;
  }
  
  .faq-question {
    padding: 15px;
  }
  
  .question-text {
    font-size: 0.9rem;
  }
  
  .q-circle,
  .a-circle {
    width: 35px;
    height: 35px;
    margin-right: 10px;
  }
  
  .q-mark,
  .a-mark {
    font-size: 1rem;
  }
}
</style>