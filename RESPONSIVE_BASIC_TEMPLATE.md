# レスポンシブ基本形テンプレート

## 概要
このテンプレートは、Vue.jsコンポーネントのレスポンシブ対応の基本形として使用します。
CompanyProfile.vueで実装されたレスポンシブ設定を基に作成されています。

## ブレークポイント構成

### 基本ブレークポイント
```css
/* デスクトップ（1150px超）: 基本スタイル */
/* 1150px以下: タブレット横向き */
@media (max-width: 1150px) { ... }

/* 900px以下: タブレット */
@media (max-width: 900px) { ... }

/* 768px以下: タブレット縦向き */
@media (max-width: 768px) { ... }

/* 480px以下: スマートフォン */
@media (max-width: 480px) { ... }
```

## 各ブレークポイントの実装パターン

### 1. 1150px以下（タブレット横向き）

#### レイアウト変更
```css
@media (max-width: 1150px) {
  /* セクションのパディング調整 */
  .section {
    padding: 50px 20px !important;
  }

  /* レイアウトの縦並び化 */
  .content {
    flex-direction: column !important;
    gap: 0 !important;
  }
  
  /* 要素の幅調整 */
  .image,
  .text {
    width: 100% !important;
  }
  
  /* 画像の高さ固定 */
  .image {
    height: 300px !important;
  }
  
  /* 角丸の調整 */
  .image {
    border-radius: 20px 20px 0 0 !important;
  }
  
  .text {
    border-radius: 0 0 20px 20px !important;
    padding: 40px !important;
  }
}
```

#### フォントサイズ調整
```css
@media (max-width: 1150px) {
  /* セクションタイトル */
  .section-title {
    font-size: 32px !important;
  }

  /* ディバイダーテキスト */
  .divider-text {
    font-size: 18px !important;
  }

  /* メインヘッドライン */
  .main-headline {
    font-size: 48px !important;
  }
  
  /* 説明文 */
  .description {
    font-size: 18px !important;
  }
  
  /* 見出し */
  .heading {
    font-size: 22px !important;
  }
  
  /* 詳細テキスト */
  .details {
    font-size: 18px !important;
  }
}
```

### 2. 900px以下（タブレット）

#### レイアウト調整
```css
@media (max-width: 900px) {
  /* 横スクロール無効化 */
  .page {
    overflow-x: hidden !important;
  }
  
  /* セクション幅の調整 */
  .section {
    width: 100% !important;
    overflow: hidden !important;
    min-width: auto !important;
  }
  
  /* コンテンツ幅の調整 */
  .content {
    width: 100% !important;
    max-width: 100% !important;
  }

  /* グリッドレイアウトの調整 */
  .grid-container {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    width: 100%;
  }

  /* ナビゲーション要素の非表示 */
  .nav-button {
    display: none;
  }
}
```

#### フォントサイズ調整
```css
@media (max-width: 900px) {
  .section-title {
    font-size: 29px !important;
  }

  .divider-text {
    font-size: 17px !important;
  }

  .main-headline {
    font-size: 42px !important;
  }

  .description {
    font-size: 17px !important;
  }

  .heading {
    font-size: 20px !important;
  }

  .details {
    font-size: 17px !important;
  }
}
```

### 3. 768px以下（タブレット縦向き）

#### レイアウト調整
```css
@media (max-width: 768px) {
  /* 完全な縦並び化 */
  .content {
    flex-direction: column !important;
    width: 100% !important;
    max-width: 100% !important;
  }
  
  /* セクション幅の最適化 */
  .section {
    width: 100% !important;
    overflow: hidden !important;
  }

  /* スクロール設定 */
  .scrollable {
    overflow-x: scroll;
  }
  
  /* フッター要素の調整 */
  .footer-links {
    flex-wrap: wrap;
    gap: 30px;
  }
}
```

#### フォントサイズ調整
```css
@media (max-width: 768px) {
  .section-title {
    font-size: 27px !important;
  }

  .divider-text {
    font-size: 16px !important;
  }

  .main-headline {
    font-size: 38px !important;
  }

  .description {
    font-size: 16px !important;
  }

  .heading {
    font-size: 19px !important;
  }

  .details {
    font-size: 16px !important;
  }
}
```

### 4. 480px以下（スマートフォン）

#### レイアウト調整
```css
@media (max-width: 480px) {
  /* セクションの調整 */
  .section {
    width: 100% !important;
    overflow: hidden !important;
    padding: 30px 20px !important;
    gap: 20px !important;
  }
  
  /* コンテンツの調整 */
  .content {
    width: 100% !important;
    max-width: 100% !important;
  }
  
  /* テキストの調整 */
  .text {
    padding: 30px 20px !important;
    gap: 20px !important;
  }

  /* 画像の調整 */
  .image {
    height: 200px !important;
  }

  /* セクションヘッダーの調整 */
  .section-header {
    gap: 20px !important;
    margin-bottom: 20px !important;
  }
}
```

#### フォントサイズ調整
```css
@media (max-width: 480px) {
  .section-title {
    font-size: 22px !important;
  }

  .main-headline {
    font-size: 25px !important;
  }
  
  .description {
    font-size: 13px !important;
  }
  
  .heading {
    font-size: 18px !important;
  }
  
  .details {
    font-size: 13px !important;
  }

  .divider-text {
    font-size: 13px !important;
  }
}
```

## フォントサイズの段階的変化パターン

### 基本パターン
```css
/* セクションタイトル */
36px → 32px → 29px → 27px → 22px

/* メインヘッドライン */
55px → 48px → 42px → 38px → 25px

/* 説明文・詳細・ディバイダーテキスト（統一） */
20px → 18px → 17px → 16px → 13px

/* 見出し */
24px → 22px → 20px → 19px → 18px

/* 特殊要素（履歴年など） */
48px → 48px → 42px → 38px → 35px
```

## 実装のポイント

### 1. !importantの使用
- 全てのレスポンシブ設定に!importantを付与
- 他のCSSルールとの競合を完全回避
- 確実なCSS適用を保証

### 2. 段階的な調整
- 各ブレークポイントで適切なサイズ調整
- 可読性の維持
- ユーザビリティの向上

### 3. レイアウトの最適化
- デバイスサイズに応じた最適なレイアウト
- 縦並び化によるモバイル対応
- 画像サイズの最適化

### 4. 一貫性の確保
- 関連要素のサイズ統一
- デザインの一貫性
- ユーザー体験の統一

## 使用例

### 新しいコンポーネントでの適用
```css
/* 基本スタイル（デスクトップ） */
.my-component {
  font-size: 20px;
  padding: 50px;
  width: 50%;
}

/* レスポンシブ対応 */
@media (max-width: 1150px) {
  .my-component {
    font-size: 18px !important;
    padding: 50px 20px !important;
    width: 100% !important;
  }
}

@media (max-width: 900px) {
  .my-component {
    font-size: 17px !important;
  }
}

@media (max-width: 768px) {
  .my-component {
    font-size: 16px !important;
  }
}

@media (max-width: 480px) {
  .my-component {
    font-size: 13px !important;
    padding: 30px 20px !important;
  }
}
```

## 注意事項

1. **!importantの過度な使用**: 必要最小限に留める
2. **パフォーマンス**: メディアクエリの最適化
3. **テスト**: 各ブレークポイントでの動作確認
4. **保守性**: コードの可読性と保守性のバランス

## まとめ

このテンプレートを使用することで、一貫性のあるレスポンシブ対応が実現できます。
各ブレークポイントでの適切な調整により、すべてのデバイスサイズで最適なユーザー体験を提供できます。
