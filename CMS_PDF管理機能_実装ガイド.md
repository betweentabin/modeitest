# CMS刊行物PDF管理機能 実装ガイド

## 📋 概要
CMSで刊行物にPDFファイルを追加・管理し、公開ページでダウンロード可能にする機能の実装ガイド

## 🎯 実装済み機能

### 1. バックエンド（Laravel）

#### PublicationManagementController
```php
// app/Http/Controllers/Admin/PublicationManagementController.php

主要メソッド:
- store(): 刊行物作成（PDF/画像アップロード含む）
- update(): 刊行物更新（PDF/画像の更新含む）
- uploadPdf(): 単独でPDFをアップロード
- deletePdf(): PDFファイルを削除
- destroy(): 刊行物削除（関連ファイルも削除）
```

#### 対応フィールド
- `file_url`: PDFファイルのURL
- `file_size`: ファイルサイズ（MB）
- `membership_level`: アクセス制限レベル（free/standard/premium）
- `is_downloadable`: ダウンロード可否
- `cover_image`: カバー画像URL

### 2. APIルート設定

```php
// routes/api.php

// 管理者用エンドポイント（認証必要）
Route::prefix('admin')->middleware(['auth:sanctum', 'is.admin'])->group(function () {
    Route::prefix('publications')->group(function () {
        Route::get('/', [PublicationManagementController::class, 'index']);
        Route::post('/', [PublicationManagementController::class, 'store']);
        Route::get('/{id}', [PublicationManagementController::class, 'show']);
        Route::put('/{id}', [PublicationManagementController::class, 'update']);
        Route::delete('/{id}', [PublicationManagementController::class, 'destroy']);
        Route::post('/{id}/upload-pdf', [PublicationManagementController::class, 'uploadPdf']);
        Route::delete('/{id}/pdf', [PublicationManagementController::class, 'deletePdf']);
    });
});
```

### 3. フロントエンド実装

#### 刊行物詳細ページ（PublicationDetailPage.vue）
- PDFダウンロードボタン実装済み
- 会員ランク制限機能実装済み
- アクセス権限チェック実装済み

## 🔧 管理画面の認証エラー解決

### 問題の症状
```
GET https://heroic-celebration-production.up.railway.app/login 401 (Unauthorized)
```

### 解決方法

#### 1. デフォルト管理者アカウント
```
メールアドレス: admin@chikugin-cri.co.jp
パスワード: admin123
```

#### 2. APIクライアントの認証トークン処理確認

```javascript
// src/services/apiClient.js

// 管理者トークンの設定
setAdminToken(token) {
    localStorage.setItem('adminToken', token);
    this.adminToken = token;
}

// リクエストヘッダーに認証トークンを追加
if (this.adminToken) {
    headers['Authorization'] = `Bearer ${this.adminToken}`;
}
```

#### 3. 管理画面コンポーネントでの認証処理

```javascript
// 管理画面コンポーネントの mounted() で認証チェック
async mounted() {
    const adminToken = localStorage.getItem('adminToken');
    if (!adminToken) {
        this.$router.push('/admin/login');
        return;
    }
    
    // APIクライアントにトークンを設定
    apiClient.setAdminToken(adminToken);
    
    // データ取得
    await this.loadData();
}
```

## 📝 使用方法

### 1. 刊行物の新規作成（PDFファイル付き）

```javascript
// FormDataを使用してファイルアップロード
const formData = new FormData();
formData.append('title', '経済レポート2025');
formData.append('description', 'レポートの説明');
formData.append('category', 'research');
formData.append('type', 'pdf');
formData.append('publication_date', '2025-01-01');
formData.append('membership_level', 'standard');
formData.append('is_published', true);
formData.append('is_downloadable', true);
formData.append('pdf_file', pdfFile); // ファイルオブジェクト
formData.append('cover_image', imageFile); // 画像ファイル

// APIリクエスト
const response = await apiClient.post('/api/admin/publications', formData, {
    headers: {
        'Content-Type': 'multipart/form-data'
    }
});
```

### 2. 既存の刊行物にPDFを追加

```javascript
const formData = new FormData();
formData.append('pdf_file', pdfFile);

const response = await apiClient.post(
    `/api/admin/publications/${publicationId}/upload-pdf`,
    formData,
    {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    }
);
```

### 3. 公開ページでのPDFダウンロード

```javascript
// PublicationDetailPage.vue

methods: {
    async handleDownload() {
        const requiredLevel = this.publication.membership_level || 'free';
        const canAccess = this.$store.getters['auth/canAccess'](requiredLevel);
        
        if (canAccess && this.publication.file_url) {
            // ダウンロード処理
            this.publication.download_count++;
            window.open(this.publication.file_url, '_blank');
        } else if (!this.$store.getters['auth/isAuthenticated']) {
            // ログイン画面へ
            this.$router.push('/login');
        } else {
            // アップグレード案内
            alert(`この刊行物は${this.getMembershipText(requiredLevel)}会員限定です。`);
            this.$router.push('/membership');
        }
    }
}
```

## 🗂️ ファイル保存構造

```
storage/app/public/
├── publications/
│   ├── pdfs/         # PDFファイル
│   │   └── *.pdf
│   └── covers/       # カバー画像
│       └── *.jpg/png
```

## ⚙️ 環境設定

### 1. ストレージリンクの作成
```bash
php artisan storage:link
```

### 2. ファイルサイズ制限の設定
```ini
# php.ini
upload_max_filesize = 20M
post_max_size = 25M
```

### 3. Nginxの設定（必要に応じて）
```nginx
client_max_body_size 25M;
```

## 🔒 セキュリティ考慮事項

1. **ファイルバリデーション**
   - MIMEタイプチェック（PDFのみ）
   - ファイルサイズ制限（20MB）
   - ウイルススキャン（オプション）

2. **アクセス制御**
   - 会員ランクによるダウンロード制限
   - 認証トークンの検証
   - ダウンロードログの記録

3. **ファイル保護**
   - 直接URLアクセスの防止（必要に応じて）
   - 一時的なダウンロードリンクの生成（オプション）

## 📊 データベース構造

### publicationsテーブル
```sql
- id: bigint
- title: varchar(255)
- description: text
- category: varchar(50)
- type: varchar(20) -- 'pdf', 'book', 'digital'
- publication_date: date
- file_url: varchar(255) -- PDFファイルのURL
- file_size: decimal(8,2) -- ファイルサイズ（MB）
- cover_image: varchar(255)
- membership_level: varchar(20) -- 'free', 'standard', 'premium'
- is_published: boolean
- is_downloadable: boolean
- download_count: integer
- view_count: integer
- created_at: timestamp
- updated_at: timestamp
```

## 🐛 トラブルシューティング

### 1. 認証エラーが発生する場合
```javascript
// デバッグ用：トークンの確認
console.log('Admin Token:', localStorage.getItem('adminToken'));

// トークンのリフレッシュ
await apiClient.refreshAdminToken();
```

### 2. ファイルアップロードが失敗する場合
- ファイルサイズ制限を確認
- ディレクトリの書き込み権限を確認
- `storage/app/public`ディレクトリが存在することを確認

### 3. PDFダウンロードができない場合
- `file_url`フィールドが正しく設定されているか確認
- ストレージリンクが作成されているか確認
- 会員ランク制限を確認

## 📱 レスポンシブ対応

モバイル端末でのPDFダウンロード処理:
```javascript
// iOS/Androidでの処理分岐
if (/iPhone|iPad|iPod|Android/i.test(navigator.userAgent)) {
    // モバイルの場合は新しいタブで開く
    window.open(this.publication.file_url, '_blank');
} else {
    // デスクトップの場合は直接ダウンロード
    const link = document.createElement('a');
    link.href = this.publication.file_url;
    link.download = `${this.publication.title}.pdf`;
    link.click();
}
```

## 🚀 今後の拡張案

1. **PDFプレビュー機能**
   - PDF.jsを使用したインライン表示
   - サムネイル生成

2. **アクセス統計**
   - ダウンロード数の詳細分析
   - 会員別アクセスログ

3. **一時URL生成**
   - セキュリティ強化のための時限付きURL
   - S3等の外部ストレージ対応

4. **バッチアップロード**
   - 複数PDFの一括アップロード
   - CSVインポート機能

---

更新日: 2025年9月1日
バージョン: 1.0.0