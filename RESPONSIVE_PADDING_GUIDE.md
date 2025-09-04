# レスポンシブパディング設定ガイド

## 概要
このガイドは、Vue.jsコンポーネントのレスポンシブ対応におけるパディング設定の統一パターンについて説明します。
セクション全体の外側のパディングと、コンテンツエリアの内側のパディングを統一するための設定です。

## 統一されたパディングパターン

### 外パディング設定（セクション全体）
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

### 内パディング設定（コンテンツエリア）
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

## 使用方法

### 外パディング（セクション全体）
1. **「そのクラスを外パディング設定して」**と言う
2. **`.your-section-class` を対象クラス名に変更**
3. **セクション全体の外側パディング**が適用される

### 内パディング（コンテンツエリア）
1. **「そのクラスを内パディング設定して」**と言う
2. **`.your-content-class` を対象クラス名に変更**
3. **コンテンツエリアの内側パディング**が適用される

## パディング値の一覧

### 外パディング（セクション全体）
- **基本**: `padding: 70px 50px 50px`
- **1150px以下**: `padding: 50px 30px !important`
- **900px以下**: `padding: 30px 20px !important`
- **768px以下**: `padding: 30px 20px !important`
- **480px以下**: `padding: 20px 15px !important`

### 内パディング（コンテンツエリア）
- **基本**: `padding: 50px`
- **1150px以下**: `padding: 30px 20px !important`
- **900px以下**: `padding: 30px 20px !important`
- **768px以下**: `padding: 30px 20px !important`
- **480px以下**: `padding: 20px 15px !important`

## 実装例

### 外パディングの例
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

### 内パディングの例
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
2. **段階的な調整**: 各ブレークポイントで適切なパディング調整を行い、ユーザビリティを向上させる
3. **一貫性の維持**: パディングの調整パターンを統一し、プロジェクト全体の一貫性を保つ
4. **コンテンツの可読性**: デバイスサイズに応じて適切な余白を確保し、コンテンツの可読性を向上させる
5. **タッチ操作への配慮**: スマートフォン向けには適切なタッチ操作スペースを確保する
