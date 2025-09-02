<template>
  <div class="page-container">
    <Navigation />
    
    <!-- Hero Section -->
    <HeroSection 
      title="よくあるご質問"
      subtitle="FAQ"
      heroImage="/img/hero-image.png"
    />
    
    <!-- Breadcrumbs -->
    <Breadcrumbs :breadcrumbs="['よくあるご質問']" />

    <div class="page-content">
      <div class="content-header">
        <h2 class="page-title">よくあるご質問</h2>
        <div class="title-decoration">
          <div class="line-left"></div>
          <span class="title-english">FAQ</span>
          <div class="line-right"></div>
        </div>
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
      
      <!-- モバイル用プルダウンメニュー -->
      <div class="faq-categories-mobile">
        <select 
          v-model="selectedCategory" 
          @change="selectedCategory = selectedCategory"
          class="category-select"
        >
          <option value="all">全て</option>
          <option value="service">各種サービスについて</option>
          <option value="membership">会員について</option>
          <option value="research">調査研究について</option>
        </select>
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

    <!-- Contact CTA Section -->
    <ContactSection />

    <!-- Access Section -->
    <AccessSection />

    <!-- Footer Navigation -->
    <Footer v-bind="frame132131753022Props" />

    <!-- Fixed Side Buttons -->
    <FixedSideButtons position="bottom" />
  </div>
</template>

<script>
import Navigation from "./Navigation.vue";
import Footer from "./Footer.vue";
import Group27 from "./Group27.vue";
import FixedActionButtons from "./FixedActionButtons.vue";
import HeroSection from "./HeroSection.vue";
import Breadcrumbs from "./Breadcrumbs.vue";
import ContactSection from "./ContactSection.vue";
import AccessSection from "./AccessSection.vue";
import FixedSideButtons from "./FixedSideButtons.vue";
import { frame132131753022Data } from "../data.js";

export default {
  name: "FaqPage",
  components: {
    Navigation,
    Footer,
    Group27,
    FixedActionButtons,
    HeroSection,
    Breadcrumbs,
    ContactSection,
    AccessSection,
    FixedSideButtons
  },
  data() {
    return {
      frame132131753022Props: frame132131753022Data,
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

  }
};
</script>

<style scoped>

.page-container {
  min-height: 100vh;
  background-color: #ECECEC;
}

/* Page Content */
.page-content {
  width: 100%;
  margin: 0 auto;
  padding: 70px 50px;
}

.content-header {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 29px;
  margin-bottom: 40px;
}

.page-title {
  font-family: Inter, -apple-system, Roboto, Helvetica, sans-serif;
  font-size: 36px;
  font-weight: 700;
  color: #1A1A1A;
  letter-spacing: -0.72px;
  text-align: center;
  margin: 0;
}

.title-decoration {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 15px;
  width: auto;
  min-width: 306px;
}

.line-left, .line-right {
  width: 80px;
  height: 2px;
  background: #DA5761;
  flex-shrink: 0;
}

.title-english {
  font-family: Inter, -apple-system, Roboto, Helvetica, sans-serif;
  font-size: 20px;
  font-weight: 700;
  color: #DA5761;
}

/* Categories */
.faq-categories {
  display: flex;
  justify-content: center;
  gap: 0;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: none;
  max-width: 1500px;
  margin: 0 auto 40px;
}

.faq-categories-mobile {
  display: none;
  margin-bottom: 40px;
  width: 100%;
}

.category-select {
  width: 100%;
  max-width: 300px;
  padding: 15px 20px;
  border: 2px solid #F6D5D8;
  border-radius: 8px;
  background: #F6D5D8;
  font-size: 16px;
  color: #1A1A1A;
  cursor: pointer;
  outline: none;
  margin: 0 0 0 auto;
  display: block;
}

.category-select:focus {
  border-color: #da5761;
  box-shadow: 0 0 0 2px rgba(218, 87, 97, 0.2);
}

.category-select option {
  background: white;
  color: #1A1A1A;
}

.category-btn {
  background: #F6D5D8;
  border: none;
  padding: 15px 20px;
  cursor: pointer;
  transition: all 0.3s;
  font-size: 0.8rem;
  color: #666;
  border-right: 1px solid #DA5761;
  white-space: nowrap;
  flex: 1;
  box-sizing: border-box;
  width: 0;
  min-width: 0;
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
  max-width: 1500px;
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
  flex: 0 0 35px;
  width: 35px;
  height: 35px;
  border-radius: 50%;
  background: #da5761;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-right: 15px;
  min-width: 35px;
  min-height: 35px;
}

.q-mark {
  color: white;
  font-weight: bold;
  font-size: 1.2rem;
}

.question-text {
  flex: 1;
  font-size: 1rem;
  color: #1A1A1A;
  font-weight: 500;
  font-family: "Noto Sans JP", "Helvetica Neue", Helvetica, Arial, sans-serif;
  line-height: 1.6;
  display: flex;
  align-items: center;
  min-height: 40px;
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
  padding: 20px;
  border-top: 1px solid #dee2e6;
}

.a-circle {
  flex: 0 0 35px;
  width: 35px;
  height: 35px;
  border-radius: 50%;
  background: white;
  border: 2px solid #da5761;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-right: 15px;
  margin-top: 5px;
  min-width: 35px;
  min-height: 35px;
}

.a-mark {
  color: #da5761;
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



/* Responsive Design */
@media (max-width: 1200px) {
  .page-content {
    padding: 40px 30px;
  }
  
  .faq-categories {
    display: none;
  }
  
  .faq-categories-mobile {
    display: block;
  }
}

@media (max-width: 900px) {
  .page-content {
    padding: 30px 20px;
  }
  
  .faq-categories {
    flex-direction: column;
    gap: 10px;
  }
  
  .category-btn {
    width: 100%;
    border-right: none;
    border-bottom: 1px solid #DA5761;
  }
  
  .category-btn:last-child {
    border-bottom: none;
  }
  
  .faq-item {
    padding: 0;
  }
  
  .faq-question {
    padding: 15px;
  }
  
  .question-text {
    font-size: 16px !important;
  }
  
  .answer-text {
    font-size: 14px !important;
  }
}

@media (max-width: 768px) {
  .page-content {
    padding: 40px 15px;
  }
  
  .faq-categories {
    flex-wrap: nowrap;
    gap: 0;
  }
  
  .category-btn {
    padding: 8px 10px;
    font-size: 0.6rem;
    border-right: 1px solid #DA5761;
    border-radius: 0;
    margin-bottom: 0;
    min-width: 0;
    flex: 1;
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

@media (max-width: 480px) {
  .faq-item {
    padding: 0;
  }

  .page-content {
    padding: 20px 15px;
  }
  
  .faq-categories {
    padding: 20px 15px;
  }
  
  .category-btn {
    padding: 15px 20px;
    font-size: 14px !important;
  }
  
  .faq-item {
    padding: 0;
  }
  
  .faq-question {
    padding: 10px 0;
  }
  
  .answer-text,
  .question-text {
    font-size: 13px !important;
  }

  .faq-answer,
  .faq-question {
    padding: 10px;
  }
  
  .q-circle,
  .a-circle {
    width: 30px;
    height: 30px;
    margin-right: 8px;
  }
  
  .q-mark,
  .a-mark {
    font-size: 0.9rem;
  }

  .faq-categories-mobile {
    margin-bottom: 20px;
  }

  .content-header {
    gap: 20px;
    margin-bottom: 20px;
  }

  .page-title {
    font-size: 25px;
  }

  .title-english {
  font-size: 13px;
}
}
</style>