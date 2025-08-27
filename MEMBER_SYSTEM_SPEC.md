# 会員システム仕様書

## 概要
ちくぎん地域経済研究所の会員システムは、会員ランクに応じて刊行物などのコンテンツへのアクセスを制御するシステムです。
ダッシュボード型ではなく、コンテンツアクセス権限管理型のシンプルな設計となっています。

## 会員ランク体系

### 1. ゲスト（未ログイン）
- **アクセス可能コンテンツ**
  - 公開情報（お知らせ、セミナー情報など）
  - 無料公開の刊行物（サンプル版など）
- **制限事項**
  - スタンダード会員以上のコンテンツはサムネイルがぼやけて表示
  - ダウンロード不可

### 2. ベーシック会員
- **月額**: 無料または低価格帯
- **アクセス可能コンテンツ**
  - ゲストの全コンテンツ
  - ベーシック向け刊行物
  - 月次レポート（簡易版）
- **制限事項**
  - プレミアムコンテンツはサムネイルがぼやけて表示

### 3. スタンダード会員
- **月額**: 中価格帯
- **アクセス可能コンテンツ**
  - ベーシック会員の全コンテンツ
  - 四半期レポート
  - 業界分析レポート
  - セミナー資料（一部）
- **制限事項**
  - プレミアムコンテンツの一部制限

### 4. プレミアム会員
- **月額**: 高価格帯
- **アクセス可能コンテンツ**
  - 全刊行物へのフルアクセス
  - 特別調査レポート
  - セミナー動画アーカイブ
  - データダウンロード（Excel形式など）
  - 早期アクセス権

## UI/UX設計

### 刊行物一覧ページ

```
┌─────────────────────────────────────┐
│  刊行物一覧                           │
├─────────────────────────────────────┤
│  ┌──────┐ ┌──────┐ ┌──────┐      │
│  │      │ │ ぼやけ │ │ ぼやけ │      │
│  │ 公開 │ │  表示  │ │  表示  │      │
│  │      │ │ 🔒    │ │ 🔒    │      │
│  └──────┘ └──────┘ └──────┘      │
│   無料版   スタンダード プレミアム     │
└─────────────────────────────────────┘
```

### アクセス制限時の表示

#### ぼやけ表示の実装
```css
.restricted-content {
  position: relative;
  filter: blur(3px);
  pointer-events: none;
}

.restricted-overlay {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background: rgba(255, 255, 255, 0.9);
  padding: 20px;
  border-radius: 8px;
  text-align: center;
}
```

#### オーバーレイメッセージ
- ゲスト: "会員登録してアクセス"
- ベーシック会員: "スタンダード会員以上で閲覧可能"
- スタンダード会員: "プレミアム会員限定コンテンツ"

## 技術実装

### データ構造

#### 刊行物（Publications）
```javascript
{
  id: 1,
  title: "経営参考BOOK vol.52",
  description: "事業承継をテーマに解説",
  membershipLevel: "standard", // "free", "basic", "standard", "premium"
  file_url: "/files/management-book-52.pdf",
  thumbnail_url: "/images/thumb-52.jpg",
  is_published: true
}
```

#### 会員（Members）
```javascript
{
  id: 1,
  name: "山田太郎",
  email: "yamada@example.com",
  membershipType: "standard", // "basic", "standard", "premium"
  status: "active",
  expiryDate: "2025-12-31"
}
```

### アクセス制御ロジック

```javascript
// composables/useMemberAuth.js
export function canAccessContent(content, userMembership) {
  const levels = {
    'free': 0,
    'basic': 1,
    'standard': 2,
    'premium': 3
  };
  
  const contentLevel = levels[content.membershipLevel] || 0;
  const userLevel = levels[userMembership] || 0;
  
  return userLevel >= contentLevel;
}
```

### コンポーネント実装例

```vue
<!-- PublicationCard.vue -->
<template>
  <div class="publication-card">
    <div v-if="!canAccess" class="restricted-wrapper">
      <img :src="thumbnail" alt="" class="blurred-thumbnail">
      <div class="restricted-overlay">
        <Icon name="lock" />
        <p>{{ restrictionMessage }}</p>
        <button @click="showUpgradeModal">
          アップグレード
        </button>
      </div>
    </div>
    
    <div v-else class="accessible-content">
      <img :src="thumbnail" alt="">
      <h3>{{ publication.title }}</h3>
      <p>{{ publication.description }}</p>
      <button @click="download">
        ダウンロード
      </button>
    </div>
  </div>
</template>
```

## ユーザーフロー

### 1. ゲストユーザーのフロー
1. トップページ訪問
2. 刊行物ページへ遷移
3. 制限コンテンツを確認（ぼやけ表示）
4. 会員登録ボタンをクリック
5. 会員登録フォームへ

### 2. 会員ログインフロー
1. ログインページ（/login）へアクセス
2. メールアドレス・パスワード入力
3. ログイン成功後、元のページへリダイレクト
4. 会員ランクに応じたコンテンツ表示

### 3. アップグレードフロー
1. 制限コンテンツの「アップグレード」ボタンクリック
2. プラン比較ページ表示
3. アップグレードプラン選択
4. 決済情報入力
5. アップグレード完了

## セキュリティ考慮事項

### フロントエンド
- URLの直接アクセス防止
- トークンベースの認証（JWT）
- セッション管理

### バックエンド
- APIレベルでのアクセス制御
- ファイルダウンロードの認証チェック
- 有効期限チェック

## 実装優先順位

### Phase 1: 基本機能（MVP）
1. ✅ 会員登録・ログイン画面
2. ⬜ 会員認証機能（mockServer実装）
3. ⬜ 刊行物のアクセス制御
4. ⬜ ぼやけ表示の実装

### Phase 2: 会員ランク機能
1. ⬜ 会員ランクシステム
2. ⬜ コンテンツレベル設定
3. ⬜ アップグレード促進UI

### Phase 3: 管理機能
1. ⬜ 管理画面での会員ランク管理
2. ⬜ コンテンツの公開レベル設定
3. ⬜ アクセスログ・統計

## 想定される画面

### 必要な画面
- ✅ `/login` - 会員ログイン
- ✅ `/register` - 会員登録  
- ⬜ `/my-account` - マイアカウント（会員情報・プラン確認）
- ⬜ `/upgrade` - プランアップグレード
- 改修 `/publications` - 刊行物一覧（アクセス制御付き）

### 管理画面
- ✅ `/admin/members` - 会員管理（ランク設定含む）
- 改修 `/admin/publications` - 刊行物管理（公開レベル設定含む）

## 注意事項
- ダッシュボード型ではないため、ログイン後の専用ホーム画面は不要
- コンテンツへのアクセス権限が主目的
- シンプルでわかりやすいUI/UXを重視
- 段階的なアップグレード誘導を実装