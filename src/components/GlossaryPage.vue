<template>
  <div class="page-container">
    <Navigation />
    
    <!-- Hero Section -->
    <div class="hero-section">
      <div class="hero-overlay">
        <div class="hero-content">
          <h1 class="hero-title">用語集</h1>
          <p class="hero-subtitle">glossary</p>
        </div>
      </div>
    </div>

    <div class="page-content">
      <!-- Glossary Header -->
      <div class="glossary-header">
        <h2 class="section-title">用語集</h2>
        <p class="section-subtitle">glossary</p>
        <p class="description">経済用語を分かりやすく解説いたします。</p>
      </div>

      <!-- Search and Filter -->
      <div class="search-section">
        <div class="search-box">
          <input 
            type="text" 
            v-model="searchQuery" 
            placeholder="用語を検索..." 
            class="search-input"
          />
          <button class="search-btn">検索</button>
        </div>
      </div>

      <!-- Alphabetical Index -->
      <div class="alphabetical-index">
        <button 
          v-for="letter in alphabet" 
          :key="letter"
          :class="['letter-btn', { active: selectedLetter === letter }]"
          @click="selectLetter(letter)"
        >
          {{ letter }}
        </button>
      </div>

      <!-- Glossary List -->
      <div class="glossary-list" v-if="!loading">
        <div class="glossary-categories">
          <!-- あ行 -->
          <div class="category-section" v-if="getCategoryTerms('あ').length > 0">
            <h3 class="category-title">あ行</h3>
            <div class="terms-grid">
              <div 
                v-for="term in getCategoryTerms('あ')" 
                :key="term.id"
                class="term-card"
                @click="toggleTerm(term.id)"
              >
                <div class="term-header">
                  <h4 class="term-name">{{ term.name }}</h4>
                  <span class="toggle-icon" :class="{ open: openTerms.includes(term.id) }">
                    <svg width="16" height="16" viewBox="0 0 16 16">
                      <path d="M4 6L8 10L12 6" stroke="currentColor" stroke-width="2" fill="none"/>
                    </svg>
                  </span>
                </div>
                <transition name="slide">
                  <div v-if="openTerms.includes(term.id)" class="term-definition">
                    <p>{{ term.definition }}</p>
                    <div v-if="term.example" class="term-example">
                      <strong>例：</strong>{{ term.example }}
                    </div>
                  </div>
                </transition>
              </div>
            </div>
          </div>

          <!-- か行 -->
          <div class="category-section" v-if="getCategoryTerms('か').length > 0">
            <h3 class="category-title">か行</h3>
            <div class="terms-grid">
              <div 
                v-for="term in getCategoryTerms('か')" 
                :key="term.id"
                class="term-card"
                @click="toggleTerm(term.id)"
              >
                <div class="term-header">
                  <h4 class="term-name">{{ term.name }}</h4>
                  <span class="toggle-icon" :class="{ open: openTerms.includes(term.id) }">
                    <svg width="16" height="16" viewBox="0 0 16 16">
                      <path d="M4 6L8 10L12 6" stroke="currentColor" stroke-width="2" fill="none"/>
                    </svg>
                  </span>
                </div>
                <transition name="slide">
                  <div v-if="openTerms.includes(term.id)" class="term-definition">
                    <p>{{ term.definition }}</p>
                    <div v-if="term.example" class="term-example">
                      <strong>例：</strong>{{ term.example }}
                    </div>
                  </div>
                </transition>
              </div>
            </div>
          </div>

          <!-- その他のカテゴリも同様に -->
          <div class="category-section" v-for="category in ['さ', 'た', 'な', 'は', 'ま', 'や', 'ら', 'わ', 'A', '数字']" :key="category" v-if="getCategoryTerms(category).length > 0">
            <h3 class="category-title">{{ getCategoryTitle(category) }}</h3>
            <div class="terms-grid">
              <div 
                v-for="term in getCategoryTerms(category)" 
                :key="term.id"
                class="term-card"
                @click="toggleTerm(term.id)"
              >
                <div class="term-header">
                  <h4 class="term-name">{{ term.name }}</h4>
                  <span class="toggle-icon" :class="{ open: openTerms.includes(term.id) }">
                    <svg width="16" height="16" viewBox="0 0 16 16">
                      <path d="M4 6L8 10L12 6" stroke="currentColor" stroke-width="2" fill="none"/>
                    </svg>
                  </span>
                </div>
                <transition name="slide">
                  <div v-if="openTerms.includes(term.id)" class="term-definition">
                    <p>{{ term.definition }}</p>
                    <div v-if="term.example" class="term-example">
                      <strong>例：</strong>{{ term.example }}
                    </div>
                  </div>
                </transition>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div v-if="loading" class="loading">
        読み込み中...
      </div>
    </div>

    <!-- Company CTA Section -->
    <section class="company-cta-section">
      <div class="container">
        <div class="cta-content">
          <h2>株式会社ちくぎん地域経済研究所</h2>
          <p class="cta-description">様々な分野の調査研究を通じ、企業活動などをサポートします。</p>
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
  name: "GlossaryPage",
  components: {
    Navigation,
    FooterComplete
  },
  data() {
    return {
      loading: false,
      searchQuery: '',
      selectedLetter: 'all',
      openTerms: [],
      alphabet: ['あ', 'か', 'さ', 'た', 'な', 'は', 'ま', 'や', 'ら', 'わ', 'A', '数字'],
      glossaryTerms: [
        {
          id: 1,
          name: 'GDP（国内総生産）',
          category: 'A',
          definition: 'Gross Domestic Productの略。一定期間内に国内で生産された財・サービスの付加価値の総額。経済の規模や成長率を測る重要な指標。',
          example: '日本のGDPは約500兆円（2023年）'
        },
        {
          id: 2,
          name: 'インフレーション',
          category: 'あ',
          definition: '物価が継続的に上昇する現象。通貨の価値が下がり、同じ金額で購入できる物やサービスの量が減少する。',
          example: '年間2%のインフレ率であれば、100円の商品が翌年102円になる'
        },
        {
          id: 3,
          name: '金融政策',
          category: 'か',
          definition: '中央銀行が通貨供給量や金利を調節して、経済の安定と成長を図る政策。',
          example: '日本銀行による政策金利の引き上げや引き下げ'
        },
        {
          id: 4,
          name: '産業クラスター',
          category: 'さ',
          definition: '特定の産業分野において、企業、研究機関、教育機関などが地理的に集積し、相互に連携しながら競争力を高める地域。',
          example: 'シリコンバレーのIT産業クラスター'
        },
        {
          id: 5,
          name: '地域経済',
          category: 'た',
          definition: '特定の地域における経済活動の総体。地域の産業構造、雇用、所得水準などを含む。',
          example: '九州地域の自動車産業や半導体産業'
        },
        {
          id: 6,
          name: '日銀短観',
          category: 'な',
          definition: '日本銀行が四半期ごとに実施する企業短期経済観測調査。企業の業況判断や設備投資計画などを調査。',
          example: '大企業製造業の業況判断DI（業況が「良い」と答えた企業の割合から「悪い」と答えた企業の割合を差し引いた値）'
        },
        {
          id: 7,
          name: 'ファンダメンタルズ',
          category: 'は',
          definition: '経済の基礎的条件。GDP成長率、インフレ率、失業率、財政収支、経常収支など経済の基本的な指標群。',
          example: '企業の業績予想や投資判断の基礎となる経済指標'
        },
        {
          id: 8,
          name: 'マクロ経済',
          category: 'ま',
          definition: '国や地域全体の経済を対象とした経済学の分野。GDP、雇用、物価、金利などの総合的な動向を分析。',
          example: '政府の財政政策や中央銀行の金融政策の効果分析'
        }
      ]
    };
  },
  computed: {
    filteredTerms() {
      if (!this.searchQuery) {
        return this.glossaryTerms;
      }
      const query = this.searchQuery.toLowerCase();
      return this.glossaryTerms.filter(term => 
        term.name.toLowerCase().includes(query) ||
        term.definition.toLowerCase().includes(query)
      );
    }
  },
  methods: {
    selectLetter(letter) {
      this.selectedLetter = letter;
    },
    getCategoryTerms(category) {
      return this.filteredTerms.filter(term => term.category === category);
    },
    getCategoryTitle(category) {
      const titles = {
        'あ': 'あ行',
        'か': 'か行', 
        'さ': 'さ行',
        'た': 'た行',
        'な': 'な行',
        'は': 'は行',
        'ま': 'ま行',
        'や': 'や行',
        'ら': 'ら行',
        'わ': 'わ行',
        'A': 'アルファベット',
        '数字': '数字'
      };
      return titles[category] || category;
    },
    toggleTerm(termId) {
      const index = this.openTerms.indexOf(termId);
      if (index > -1) {
        this.openTerms.splice(index, 1);
      } else {
        this.openTerms.push(termId);
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

.glossary-header {
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
  margin-bottom: 15px;
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

.description {
  color: #666;
  font-size: 1rem;
}

/* Search Section */
.search-section {
  margin-bottom: 40px;
}

.search-box {
  display: flex;
  max-width: 500px;
  margin: 0 auto;
  gap: 10px;
}

.search-input {
  flex: 1;
  padding: 12px 20px;
  border: 2px solid #dee2e6;
  border-radius: 25px;
  font-size: 1rem;
  outline: none;
  transition: border-color 0.3s;
}

.search-input:focus {
  border-color: #da5761;
}

.search-btn {
  background: #da5761;
  color: white;
  border: none;
  padding: 12px 25px;
  border-radius: 25px;
  cursor: pointer;
  font-size: 1rem;
  transition: background 0.3s;
}

.search-btn:hover {
  background: #c44853;
}

/* Alphabetical Index */
.alphabetical-index {
  display: flex;
  justify-content: center;
  gap: 10px;
  margin-bottom: 40px;
  flex-wrap: wrap;
}

.letter-btn {
  background: #f8f9fa;
  border: 1px solid #dee2e6;
  padding: 8px 16px;
  border-radius: 20px;
  cursor: pointer;
  transition: all 0.3s;
  font-size: 0.9rem;
  color: #666;
  min-width: 45px;
}

.letter-btn.active,
.letter-btn:hover {
  background: #da5761;
  color: white;
  border-color: #da5761;
}

/* Glossary List */
.glossary-categories {
  display: flex;
  flex-direction: column;
  gap: 40px;
}

.category-section {
  background: white;
  border-radius: 15px;
  padding: 30px;
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.category-title {
  font-size: 1.5rem;
  color: #333;
  margin-bottom: 25px;
  font-weight: bold;
  padding-bottom: 10px;
  border-bottom: 2px solid #da5761;
}

.terms-grid {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.term-card {
  background: #f8f9fa;
  border-radius: 10px;
  padding: 20px;
  cursor: pointer;
  transition: all 0.3s;
  border-left: 4px solid #da5761;
}

.term-card:hover {
  background: #e9ecef;
  transform: translateX(5px);
}

.term-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.term-name {
  font-size: 1.1rem;
  color: #333;
  font-weight: 600;
}

.toggle-icon {
  color: #666;
  transition: transform 0.3s;
}

.toggle-icon.open {
  transform: rotate(180deg);
}

.term-definition {
  margin-top: 15px;
  padding-top: 15px;
  border-top: 1px solid #dee2e6;
}

.term-definition p {
  color: #666;
  line-height: 1.6;
  margin-bottom: 10px;
}

.term-example {
  background: #e8f4f8;
  padding: 10px 15px;
  border-radius: 5px;
  font-size: 0.9rem;
  color: #555;
}

.loading {
  text-align: center;
  padding: 40px;
  color: #666;
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
  max-height: 300px;
}

/* Company CTA Section */
.company-cta-section {
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

.cta-description {
  font-size: 1.1rem;
  margin-bottom: 30px;
  color: rgba(255,255,255,0.9);
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
  
  .search-box {
    flex-direction: column;
  }
  
  .alphabetical-index {
    gap: 5px;
  }
  
  .letter-btn {
    padding: 6px 12px;
    font-size: 0.8rem;
    min-width: 35px;
  }
  
  .category-section {
    padding: 20px;
  }
  
  .term-header {
    flex-direction: column;
    align-items: flex-start;
    gap: 10px;
  }
}

@media (max-width: 480px) {
  .term-card {
    padding: 15px;
  }
  
  .term-name {
    font-size: 1rem;
  }
  
  .term-definition p {
    font-size: 0.9rem;
  }
}
</style>