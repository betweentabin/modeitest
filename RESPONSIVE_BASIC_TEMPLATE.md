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
    padding: 50px 30px !important;
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

#### コンテンツヘッダー調整
```css
@media (max-width: 1150px) {
  /* コンテンツヘッダーのギャップ調整 */
  .content-header {
    gap: 25px !important;
  }
  
  /* ページタイトル */
  .page-title {
    font-size: 32px !important;
  }
  
  /* 装飾テキスト */
  .decoration-text,
  .title-english {
    font-size: 18px !important;
  }
}
```

### 2. 900px以下（タブレット）

#### レイアウト変更
```css
@media (max-width: 900px) {
  /* セクションのパディング調整 */
  .section {
    padding: 30px 20px !important;
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
    height: 280px !important;
  }
  
  /* 角丸の調整 */
  .image {
    border-radius: 20px 20px 0 0 !important;
  }
  
  .text {
    border-radius: 0 0 20px 20px !important;
    padding: 35px !important;
  }
}
```

#### フォントサイズ調整
```css
@media (max-width: 900px) {
  /* セクションタイトル */
  .section-title {
    font-size: 29px !important;
  }

  /* ディバイダーテキスト */
  .divider-text {
    font-size: 17px !important;
  }

  /* メインヘッドライン */
  .main-headline {
    font-size: 44px !important;
  }
  
  /* 説明文 */
  .description {
    font-size: 17px !important;
  }
  
  /* 見出し */
  .heading {
    font-size: 20px !important;
  }
  
  /* 詳細テキスト */
  .details {
    font-size: 17px !important;
  }
}
```

#### コンテンツヘッダー調整
```css
@media (max-width: 900px) {
  /* コンテンツヘッダーのギャップ調整 */
  .content-header {
    gap: 22px !important;
  }
  
  /* ページタイトル */
  .page-title {
    font-size: 29px !important;
  }
  
  /* 装飾テキスト */
  .decoration-text,
  .title-english {
    font-size: 17px !important;
  }
}
```

### 3. 768px以下（タブレット縦向き）

#### レイアウト変更
```css
@media (max-width: 768px) {
  /* セクションのパディング調整 */
  .section {
    padding: 30px 20px !important;
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
    height: 250px !important;
  }
  
  /* 角丸の調整 */
  .image {
    border-radius: 20px 20px 0 0 !important;
  }
  
  .text {
    border-radius: 0 0 20px 20px !important;
    padding: 30px !important;
  }
}
```

#### フォントサイズ調整
```css
@media (max-width: 768px) {
  /* セクションタイトル */
  .section-title {
    font-size: 27px !important;
  }

  /* ディバイダーテキスト */
  .divider-text {
    font-size: 16px !important;
  }

  /* メインヘッドライン */
  .main-headline {
    font-size: 40px !important;
  }
  
  /* 説明文 */
  .description {
    font-size: 16px !important;
  }
  
  /* 見出し */
  .heading {
    font-size: 19px !important;
  }
  
  /* 詳細テキスト */
  .details {
    font-size: 16px !important;
  }
}
```

#### コンテンツヘッダー調整
```css
@media (max-width: 768px) {
  /* コンテンツヘッダーのギャップ調整 */
  .content-header {
    gap: 20px !important;
  }
  
  /* ページタイトル */
  .page-title {
    font-size: 27px !important;
  }
  
  /* 装飾テキスト */
  .decoration-text,
  .title-english {
    font-size: 16px !important;
  }
}
```

### 4. 480px以下（スマートフォン）

#### レイアウト変更
```css
@media (max-width: 480px) {
  /* セクションのパディング調整 */
  .section {
    padding: 20px 15px !important;
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
    height: 200px !important;
  }
  
  /* 角丸の調整 */
  .image {
    border-radius: 15px 15px 0 0 !important;
  }
  
  .text {
    border-radius: 0 0 15px 15px !important;
    padding: 20px !important;
  }
}
```

#### フォントサイズ調整
```css
@media (max-width: 480px) {
  /* セクションタイトル */
  .section-title {
    font-size: 22px !important;
  }

  /* ディバイダーテキスト */
  .divider-text {
    font-size: 13px !important;
  }

  /* メインヘッドライン */
  .main-headline {
    font-size: 32px !important;
  }
  
  /* 説明文 */
  .description {
    font-size: 13px !important;
  }
  
  /* 見出し */
  .heading {
    font-size: 18px !important;
  }
  
  /* 詳細テキスト */
  .details {
    font-size: 13px !important;
  }
}
```

#### コンテンツヘッダー調整
```css
@media (max-width: 480px) {
  /* コンテンツヘッダーのギャップ調整 */
  .content-header {
    gap: 18px !important;
  }
  
  /* ページタイトル */
  .page-title {
    font-size: 22px !important;
  }
  
  /* 装飾テキスト */
  .decoration-text,
  .title-english {
    font-size: 13px !important;
  }
}
```

## 統一フォントサイズスケール

### セクションタイトル
- デスクトップ: 36px
- 1150px以下: 32px
- 900px以下: 29px
- 768px以下: 27px
- 480px以下: 22px

### 説明文・詳細テキスト
- デスクトップ: 20px
- 1150px以下: 18px
- 900px以下: 17px
- 768px以下: 16px
- 480px以下: 13px

### メインヘッドライン
- デスクトップ: 48px
- 1150px以下: 44px
- 900px以下: 40px
- 768px以下: 36px
- 480px以下: 32px

### 見出し
- デスクトップ: 24px
- 1150px以下: 22px
- 900px以下: 20px
- 768px以下: 19px
- 480px以下: 18px

### ページタイトル
- デスクトップ: 36px
- 1150px以下: 32px
- 900px以下: 29px
- 768px以下: 27px
- 480px以下: 22px

### 装飾テキスト・英語タイトル
- デスクトップ: 20px
- 1150px以下: 18px
- 900px以下: 17px
- 768px以下: 16px
- 480px以下: 13px

## コンテンツヘッダーのギャップ設定

### 各ブレークポイントでのギャップ調整
- デスクトップ: 29px（基本）
- 1150px以下: 25px
- 900px以下: 22px
- 768px以下: 20px
- 480px以下: 18px

## パディング設定

### 統一されたパディングパターン
セクション全体の外側のパディングと、コンテンツエリアの内側のパディングを統一するための設定です。

#### 外パディング設定（セクション全体）
```css
/* デスクトップ（1150px超）: 基本スタイル */
.your-section-class {
  padding: 70px 50px 50px;
}

/* 1150px以下（タブレット横向き） */
@media (max-width: 1150px) {
  .your-section-class {
    padding: 50px 30px !important;
  }
}

/* 900px以下（タブレット） */
@media (max-width: 900px) {
  .your-section-class {
    padding: 30px 20px !important;
  }
}

/* 768px以下（タブレット縦向き） */
@media (max-width: 768px) {
  .your-section-class {
    padding: 30px 20px !important;
  }
}

/* 480px以下（スマートフォン） */
@media (max-width: 480px) {
  .your-section-class {
    padding: 20px 15px !important;
  }
}
```

#### 内パディング設定（コンテンツエリア）
```css
/* デスクトップ（1150px超）: 基本スタイル */
.your-content-class {
  padding: 50px;
}

/* 1150px以下（タブレット横向き） */
@media (max-width: 1150px) {
  .your-content-class {
    padding: 30px 20px !important;
  }
}

/* 900px以下（タブレット） */
@media (max-width: 900px) {
  .your-content-class {
    padding: 30px 20px !important;
  }
}

/* 768px以下（タブレット縦向き） */
@media (max-width: 768px) {
  .your-content-class {
    padding: 30px 20px !important;
  }
}

/* 480px以下（スマートフォン） */
@media (max-width: 480px) {
  .your-content-class {
    padding: 20px 15px !important;
  }
}
```

### 使用方法
新しいクラスにパディングを適用したい場合は：

#### 外パディング（セクション全体）
1. **「そのクラスを外パディング設定して」**と言う
2. **`.your-section-class` を対象クラス名に変更**
3. **セクション全体の外側パディング**が適用される

#### 内パディング（コンテンツエリア）
1. **「そのクラスを内パディング設定して」**と言う
2. **`.your-content-class` を対象クラス名に変更**
3. **コンテンツエリアの内側パディング**が適用される

### パディング値の一覧

#### 外パディング（セクション全体）
- **基本**: `padding: 70px 50px 50px`
- **1150px以下**: `padding: 50px 30px !important`
- **900px以下**: `padding: 30px 20px !important`
- **768px以下**: `padding: 30px 20px !important`
- **480px以下**: `padding: 20px 15px !important`

#### 内パディング（コンテンツエリア）
- **基本**: `padding: 50px`
- **1150px以下**: `padding: 30px 20px !important`
- **900px以下**: `padding: 30px 20px !important`
- **768px以下**: `padding: 30px 20px !important`
- **480px以下**: `padding: 20px 15px !important`

### 実装例

#### 外パディングの例
```css
/* 例：.my-section クラスに外パディングを適用 */
.my-section {
  padding: 70px 50px 50px;
}

@media (max-width: 1150px) {
  .my-section {
    padding: 50px 30px !important;
  }
}

@media (max-width: 900px) {
  .my-section {
    padding: 30px 20px !important;
  }
}

@media (max-width: 768px) {
  .my-section {
    padding: 30px 20px !important;
  }
}

@media (max-width: 480px) {
  .my-section {
    padding: 20px 15px !important;
  }
}
```

#### 内パディングの例
```css
/* 例：.my-content クラスに内パディングを適用 */
.my-content {
  padding: 50px;
}

@media (max-width: 1150px) {
  .my-content {
    padding: 30px 20px !important;
  }
}

@media (max-width: 900px) {
  .my-content {
    padding: 30px 20px !important;
  }
}

@media (max-width: 768px) {
  .my-content {
    padding: 30px 20px !important;
  }
}

@media (max-width: 480px) {
  .my-content {
    padding: 20px 15px !important;
  }
}
```

## 実装のポイント

1. **!importantの使用**: すべてのレスポンシブCSSプロパティに`!important`を付けて、確実にスタイルが適用されるようにする
2. **段階的な調整**: 各ブレークポイントで適切なサイズ調整を行い、ユーザビリティを向上させる
3. **一貫性の維持**: フォントサイズやレイアウトの調整パターンを統一し、プロジェクト全体の一貫性を保つ
4. **コンテンツヘッダーの配慮**: ページタイトルと装飾要素の間隔を適切に調整し、視認性を向上させる
5. **内パディングの統一**: テキストセクションやコンテンツエリアの内側のパディングを統一し、一貫したユーザー体験を提供する
