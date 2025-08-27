<template>
  <AdminLayout>
    <div class="dashboard">
      <!-- ページヘッダー -->
      <div class="page-header">
        <h1 class="page-title">会員管理</h1>
      </div>

      <!-- 地域フィルター -->
      <div class="region-filter">
        <div class="region-tabs">
          <button 
            v-for="region in regions" 
            :key="region"
            @click="selectedRegion = region"
            :class="['region-tab', { active: selectedRegion === region }]"
          >
            {{ region }}
          </button>
        </div>
      </div>

      <!-- 業種フィルター -->
      <div class="industry-filter">
        <div class="industry-grid">
          <button 
            v-for="industry in industries" 
            :key="industry"
            @click="toggleIndustry(industry)"
            :class="['industry-btn', { active: selectedIndustries.includes(industry) }]"
          >
            {{ industry }}
          </button>
        </div>
      </div>

      <!-- データテーブル -->
      <div class="table-container">
        <div v-if="loading" class="loading">読み込み中...</div>
        <div v-else-if="error" class="error">{{ error }}</div>
        <div v-else class="table-wrapper">
          <table class="data-table">
            <thead>
              <tr>
                <th>会社名</th>
                <th>概要</th>
                <th>資本金</th>
                <th>お困りごと</th>
                <th>備考</th>
                <th>管理</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="member in filteredMembers" :key="member.id">
                <td class="company-name">{{ member.companyName }}</td>
                <td class="overview">{{ member.overview }}</td>
                <td class="capital">{{ member.capital }}</td>
                <td class="concern">{{ member.concern }}</td>
                <td class="note">{{ member.note }}</td>
                <td>
                  <button @click="viewDetails(member)" class="detail-btn">詳細を確認</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- ページネーション -->
      <div class="pagination">
        <span class="page-info">1 2 3 .... 99 最後</span>
      </div>
    </div>
  </AdminLayout>
</template>

<script>
import AdminLayout from './AdminLayout.vue'

export default {
  name: 'MemberManagement',
  components: {
    AdminLayout
  },
  data() {
    return {
      members: [
        {
          id: 1,
          companyName: 'ちくぎん地域経済研究所',
          overview: '製造業',
          capital: '1,000,000,000円',
          concern: 'ウェブサイトの保守運用',
          note: 'ＸＸＸＸＸＸ'
        },
        {
          id: 2,
          companyName: 'ちくぎん地域経済研究所',
          overview: '製造業',
          capital: '1,000,000,000円',
          concern: 'ウェブサイトの保守運用',
          note: 'ＸＸＸＸＸＸ'
        },
        {
          id: 3,
          companyName: 'ちくぎん地域経済研究所',
          overview: '製造業',
          capital: '1,000,000,000円',
          concern: 'ウェブサイトの保守運用',
          note: 'ＸＸＸＸＸＸ'
        },
        {
          id: 4,
          companyName: 'ちくぎん地域経済研究所',
          overview: '製造業',
          capital: '1,000,000,000円',
          concern: 'ウェブサイトの保守運用',
          note: 'ＸＸＸＸＸＸ'
        },
        {
          id: 5,
          companyName: 'ちくぎん地域経済研究所',
          overview: '製造業',
          capital: '1,000,000,000円',
          concern: 'ウェブサイトの保守運用',
          note: 'ＸＸＸＸＸＸ'
        }
      ],
      regions: ['福岡', '佐賀', '長崎', '大分', '熊本', '宮崎', '鹿児島'],
      industries: [
        '全て', '製造業', '鉱業', '建設業', '運輸交通業', '官公署',
        '貨物取扱業', '農林業', '畜産・水産業', '商業', '金融・広告業', '清掃・倉業',
        '映画・演劇業', '通信業', '教育・研究業', '保健衛生業', '接客娯楽業', 'その他の事業'
      ],
      selectedRegion: '福岡',
      selectedIndustries: ['全て'],
      loading: false,
      error: ''
    }
  },
  computed: {
    filteredMembers() {
      let result = this.members
      
      // 業種フィルタリング
      if (!this.selectedIndustries.includes('全て') && this.selectedIndustries.length > 0) {
        result = result.filter(member => 
          this.selectedIndustries.includes(member.overview)
        )
      }
      
      return result
    }
  },
  methods: {
    toggleIndustry(industry) {
      if (industry === '全て') {
        this.selectedIndustries = ['全て']
      } else {
        const index = this.selectedIndustries.indexOf(industry)
        if (index > -1) {
          this.selectedIndustries.splice(index, 1)
        } else {
          this.selectedIndustries.push(industry)
        }
        
        // 「全て」を除外
        const allIndex = this.selectedIndustries.indexOf('全て')
        if (allIndex > -1) {
          this.selectedIndustries.splice(allIndex, 1)
        }
        
        // 何も選択されていなければ「全て」を選択
        if (this.selectedIndustries.length === 0) {
          this.selectedIndustries = ['全て']
        }
      }
    },
    viewDetails(member) {
      console.log('View details:', member)
    }
  }
}
</script>

<style scoped>
.dashboard {
  background-color: white;
  border-radius: 8px;
  overflow: hidden;
}

.page-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 20px 24px;
  border-bottom: 1px solid #e5e5e5;
}

.page-title {
  font-size: 24px;
  font-weight: 600;
  color: #333;
  margin: 0;
}

.region-filter {
  padding: 16px 24px;
  border-bottom: 1px solid #e5e5e5;
}

.region-tabs {
  display: flex;
  gap: 24px;
}

.region-tab {
  background: none;
  border: none;
  font-size: 14px;
  color: #666;
  cursor: pointer;
  padding: 8px 0;
  border-bottom: 2px solid transparent;
  transition: all 0.2s;
}

.region-tab.active {
  color: #333;
  border-bottom-color: #da5761;
  font-weight: 600;
}

.region-tab:hover {
  color: #333;
}

.industry-filter {
  padding: 16px 24px;
  border-bottom: 1px solid #e5e5e5;
}

.industry-grid {
  display: grid;
  grid-template-columns: repeat(6, 1fr);
  gap: 8px;
}

.industry-btn {
  background-color: #f0f0f0;
  border: 1px solid #d0d0d0;
  border-radius: 4px;
  padding: 8px 12px;
  font-size: 12px;
  color: #333;
  cursor: pointer;
  transition: all 0.2s;
  text-align: center;
}

.industry-btn.active {
  background-color: #da5761;
  color: white;
  border-color: #da5761;
}

.industry-btn:hover {
  background-color: #e8e8e8;
}

.industry-btn.active:hover {
  background-color: #c44853;
}

.table-container {
  overflow-x: auto;
}

.loading, .error {
  padding: 40px;
  text-align: center;
  color: #666;
}

.error {
  color: #da5761;
}

.data-table {
  width: 100%;
  border-collapse: collapse;
}

.data-table th {
  background-color: #f8f8f8;
  border-bottom: 1px solid #e5e5e5;
  padding: 12px 16px;
  text-align: left;
  font-weight: 600;
  font-size: 14px;
  color: #333;
}

.data-table td {
  border-bottom: 1px solid #e5e5e5;
  padding: 16px;
  font-size: 14px;
}

.company-name {
  color: #333;
  font-weight: 500;
}

.overview {
  color: #666;
}

.capital {
  color: #666;
}

.concern {
  color: #666;
  max-width: 200px;
}

.note {
  color: #666;
}

.detail-btn {
  background-color: #333;
  color: white;
  border: none;
  padding: 6px 12px;
  border-radius: 4px;
  font-size: 12px;
  cursor: pointer;
  transition: background-color 0.2s;
}

.detail-btn:hover {
  background-color: #555;
}

.pagination {
  padding: 16px 24px;
  text-align: center;
  border-top: 1px solid #e5e5e5;
}

.page-info {
  font-size: 14px;
  color: #da5761;
}

@media (max-width: 768px) {
  .industry-grid {
    grid-template-columns: repeat(3, 1fr);
  }
  
  .region-tabs {
    flex-wrap: wrap;
    gap: 12px;
  }
}
</style>
