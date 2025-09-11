# ブロック型CMS実装ガイド

## 📊 現在の状態

### ✅ 完了済み

#### 1. データベース構築（PostgreSQL on Railway）
```sql
-- 作成済みテーブル
- block_types      : ブロックタイプ定義（12種類）
- cms_pages       : ページマスタ（ULID使用）
- page_blocks     : ページブロック
- reusable_blocks : 再利用可能ブロック
- block_versions  : バージョン履歴
- cms_media       : 画像DB保存（BYTEA）
- page_media      : ページ画像関連
```

#### 2. ブロックタイプ（12種類）
- 📌 heading - 見出し
- 📝 text - テキスト
- 🖼️ image - 画像
- ⬚⬚ columns - カラム
- </> html - HTML
- ↕️ spacer - スペーサー
- 🔘 button - ボタン
- 📋 list - リスト
- 📊 table - テーブル
- 📂 accordion - アコーディオン
- 🎬 video - 動画
- 🃏 card - カード

### 🔧 システム構成

```
┌─────────────────────────────────────┐
│         Vue.js Frontend             │
│  ┌─────────────────────────────┐   │
│  │   Block Editor Component     │   │
│  │  - Drag & Drop              │   │
│  │  - Real-time Preview        │   │
│  └─────────────────────────────┘   │
└─────────────────────────────────────┘
                 ↓↑
┌─────────────────────────────────────┐
│        Laravel Backend API          │
│  ┌─────────────────────────────┐   │
│  │   /api/v2/cms/pages         │   │ ← 編集用
│  │   /api/v2/cms/blocks        │   │
│  │   /api/v2/cms/media         │   │
│  ├─────────────────────────────┤   │
│  │   /api/v1/pages/{slug}      │   │ ← 公開用
│  └─────────────────────────────┘   │
└─────────────────────────────────────┘
                 ↓↑
┌─────────────────────────────────────┐
│      PostgreSQL (Railway)           │
│  - ULID for primary keys            │
│  - JSONB for content                │
│  - BYTEA for images                 │
└─────────────────────────────────────┘
```

## 🚀 次のステップ

### 1. Laravel API実装

#### A. モデル作成
```bash
php artisan make:model CmsPage
php artisan make:model PageBlock
php artisan make:model BlockType
php artisan make:model CmsMedia
```

#### B. コントローラー作成
```bash
php artisan make:controller Api/Admin/CmsV2Controller
php artisan make:controller Api/CmsPublicController
```

#### C. ルート定義
```php
// routes/api.php

// 管理者用（v2）
Route::prefix('admin/cms-v2')->middleware('auth:sanctum')->group(function () {
    Route::get('/pages', [CmsV2Controller::class, 'index']);
    Route::post('/pages', [CmsV2Controller::class, 'store']);
    Route::get('/pages/{id}', [CmsV2Controller::class, 'show']);
    Route::put('/pages/{id}', [CmsV2Controller::class, 'update']);
    Route::delete('/pages/{id}', [CmsV2Controller::class, 'destroy']);
    
    Route::get('/pages/{pageId}/blocks', [CmsV2Controller::class, 'getBlocks']);
    Route::post('/pages/{pageId}/blocks', [CmsV2Controller::class, 'addBlock']);
    Route::put('/blocks/{id}', [CmsV2Controller::class, 'updateBlock']);
    Route::delete('/blocks/{id}', [CmsV2Controller::class, 'deleteBlock']);
    
    Route::post('/media', [CmsV2Controller::class, 'uploadMedia']);
});

// 公開用（v1）
Route::get('/v1/pages/{slug}', [CmsPublicController::class, 'show']);
```

### 2. Vue.js ブロックエディタコンポーネント

#### A. コンポーネント構造
```
src/components/admin/BlockEditor/
├── BlockEditor.vue          # メインエディタ
├── BlockList.vue            # ブロックリスト
├── BlockItem.vue            # 個別ブロック
├── BlockToolbar.vue         # ツールバー
├── blocks/
│   ├── HeadingBlock.vue
│   ├── TextBlock.vue
│   ├── ImageBlock.vue
│   ├── ColumnsBlock.vue
│   ├── HtmlBlock.vue
│   ├── SpacerBlock.vue
│   ├── ButtonBlock.vue
│   ├── ListBlock.vue
│   ├── TableBlock.vue
│   ├── AccordionBlock.vue
│   ├── VideoBlock.vue
│   └── CardBlock.vue
└── preview/
    └── PagePreview.vue      # 実DOMプレビュー
```

#### B. 主要機能
- ドラッグ&ドロップでブロック順序変更
- リアルタイムプレビュー（iframe + PostMessage）
- 画像アップロード（Base64 → BLOB保存）
- ブロックのネスト（親子関係）
- バージョン履歴管理
- 自動保存

### 3. 実装優先順位

1. **Phase 1: 基本機能**（1週間）
   - [ ] Laravel APIの基本CRUD
   - [ ] Vue.js エディタの骨組み
   - [ ] 3つの基本ブロック（heading, text, image）

2. **Phase 2: エディタ機能**（1週間）
   - [ ] ドラッグ&ドロップ
   - [ ] リアルタイムプレビュー
   - [ ] 画像アップロード

3. **Phase 3: 拡張機能**（1週間）
   - [ ] 全12種類のブロック実装
   - [ ] バージョン管理
   - [ ] 再利用可能ブロック

4. **Phase 4: 統合**（3日）
   - [ ] 既存ページの移行
   - [ ] 管理画面への統合
   - [ ] テスト&デバッグ

## 📝 使用方法

### ページ作成
```javascript
// 新規ページ作成
const newPage = {
  page_key: 'about-us',
  title: '会社概要',
  blocks: [
    {
      type: 'heading',
      content: { text: '会社概要', level: 1 }
    },
    {
      type: 'text',
      content: { content: '<p>弊社について...</p>' }
    }
  ]
};

await api.post('/admin/cms-v2/pages', newPage);
```

### ブロック追加
```javascript
// ブロック追加
const newBlock = {
  block_type_id: 'heading_type_id',
  content: { text: '新しい見出し', level: 2 },
  sort_order: 1
};

await api.post(`/admin/cms-v2/pages/${pageId}/blocks`, newBlock);
```

### 画像アップロード
```javascript
// 画像アップロード
const formData = new FormData();
formData.append('image', file);
formData.append('alt_text', '画像の説明');

const response = await api.post('/admin/cms-v2/media', formData);
const mediaId = response.data.id;

// 画像ブロック作成
const imageBlock = {
  block_type_id: 'image_type_id',
  content: { media_id: mediaId, alignment: 'center' }
};
```

## 🔒 セキュリティ考慮事項

1. **認証・認可**
   - 編集APIは管理者のみアクセス可能
   - Sanctum認証使用

2. **入力検証**
   - JSON Schema によるブロックコンテンツ検証
   - XSS対策（HTMLサニタイズ）

3. **画像処理**
   - ファイルサイズ制限（10MB）
   - MIMEタイプ検証
   - 画像リサイズ処理

## 🎯 目標

このブロック型CMSにより以下を実現：

1. **柔軟性**: どんなページレイアウトも構築可能
2. **再利用性**: ブロックの使い回し
3. **保守性**: 構造化されたコンテンツ
4. **拡張性**: 新しいブロックタイプの追加が容易
5. **UX向上**: 直感的な編集体験

## 📚 参考資料

- [ULID Specification](https://github.com/ulid/spec)
- [JSON Schema](https://json-schema.org/)
- [Vue.js Composition API](https://vuejs.org/guide/extras/composition-api-faq.html)
- [Laravel API Resources](https://laravel.com/docs/10.x/eloquent-resources)