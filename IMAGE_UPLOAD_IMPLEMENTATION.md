# CMS画像アップロード機能実装ドキュメント

## 概要
各ページの画像ファイルをCMSの管理画面から変更できる機能を実装しました。

## 実装内容

### 1. バックエンド（Laravel）

#### APIエンドポイント
`/laravel-backend/routes/api.php`に以下のエンドポイントを追加：
- `POST /api/admin/pages/{pageKey}/upload-image` - 画像アップロード
- `DELETE /api/admin/pages/{pageKey}/delete-image` - 画像削除

#### コントローラー
`/laravel-backend/app/Http/Controllers/Api/PageContentController.php`に追加した機能：

1. **uploadImage()メソッド**
   - 画像ファイルのバリデーション（形式、サイズ制限5MB）
   - 画像タイプ: hero（ヒーロー画像）、content（コンテンツ画像）、gallery（ギャラリー画像）
   - ファイルをpublic/pages/{pageKey}ディレクトリに保存
   - page_contentsテーブルのcontentフィールド（JSON）に画像情報を保存

2. **deleteImage()メソッド**
   - 指定されたタイプの画像をストレージから削除
   - データベースの画像情報も削除

### 2. フロントエンド（Vue.js）

#### 管理画面
`/src/views/admin/PageEditForm.vue`を更新：

1. **画像アップロード UI**
   - 3種類の画像タイプごとにアップロードセクション
   - ファイル選択とプレビュー表示
   - 削除ボタン

2. **実装した機能**
   - handleImageChange(): 画像アップロード処理
   - deleteImage(): 画像削除処理
   - getImageUrl(): 画像URLの取得

#### ページ表示
`/src/components/AboutPage.vue`を更新：

1. **画像表示の動的化**
   - CMSから取得した画像を表示
   - hero画像を背景に設定
   - content画像をミッションセクションに表示
   - フォールバック（デフォルト画像）対応

### 3. ストレージ設定

Laravelのストレージシンボリックリンクを作成：
```bash
php artisan storage:link
```

これにより、`storage/app/public`が`public/storage`にリンクされ、アップロードした画像がWebからアクセス可能になります。

## 使用方法

### 管理者側

1. 管理画面にログイン
2. ページ管理から編集したいページを選択
3. 画像管理セクションで画像をアップロード
   - ヒーロー画像: ページ上部の大きな背景画像
   - コンテンツ画像: 本文中で使用する画像
   - ギャラリー画像: ギャラリーセクション用の画像
4. 保存ボタンをクリック

### 利用者側

- ページアクセス時に自動的にCMSから画像が取得・表示される
- 画像が設定されていない場合はデフォルト画像が表示される

## 画像の保存場所

- 物理パス: `/laravel-backend/storage/app/public/pages/{pageKey}/`
- アクセスURL: `http://localhost:8000/storage/pages/{pageKey}/{filename}`

## セキュリティ対策

1. **ファイルバリデーション**
   - 許可される形式: jpeg, png, jpg, gif, svg, webp
   - 最大サイズ: 5MB

2. **認証**
   - 画像アップロード/削除は管理者権限が必要
   - Sanctum認証とis.adminミドルウェアで保護

3. **ファイル名**
   - アップロード時にタイムスタンプを付けてユニークな名前に変更
   - スラッグ化して安全なファイル名に変換

## 今後の拡張案

1. **画像最適化**
   - アップロード時の自動リサイズ
   - WebP形式への自動変換

2. **複数画像対応**
   - ギャラリー画像の複数枚対応
   - ドラッグ&ドロップでの並び替え

3. **画像管理機能**
   - 画像の一覧表示
   - 未使用画像の自動削除
   - 画像のメタデータ（alt属性、キャプション）管理

4. **CDN対応**
   - CloudFrontやCloudflareとの連携
   - 画像の遅延読み込み実装