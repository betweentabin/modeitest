# 開発優先順位と課題整理

## 現在の状況

### 完了済み機能
1. ✅ 会員システムの基本実装
   - 会員ランク管理（Basic/Standard/Premium）
   - アクセス制御機能
   - PublicationCardコンポーネント
   - useMemberAuth composable

2. ✅ 文字化け修正
   - 各ページの文字化けを修正済み

3. ✅ フッターナビゲーション修正
   - /seminars と /contact のルート修正済み

### 現在の課題

#### 1. Vue 2 構文エラー（最優先）
**影響範囲：** 全体のアプリケーション動作
**問題点：**
- Vue 3の構文が混在している
- Composition APIとOptions APIの混在
- テンプレート構文の不整合

**修正対象ファイル：**
- `/src/views/UpgradePage.vue` - Vue 3構文の使用
- `/src/views/MyAccountPage.vue` - 確認必要
- `/src/composables/useMemberAuth.js` - Vue 2対応確認

#### 2. Laravel API問題（高優先度）
**影響範囲：** バックエンド連携全般
**問題点：**
- Railway環境でのAPIエンドポイント接続エラー
- CORSの設定問題の可能性
- ルーティングの不整合

**確認項目：**
- `.env` ファイルのAPI URL設定
- Laravel側のCORS設定
- APIルートの正確性

#### 3. フロントエンドのAPI統合（中優先度）
**影響範囲：** データ取得・更新機能
**確認項目：**
- mockServerからの移行状況
- APIフォールバック機能の実装
- エラーハンドリング

## 推奨実行順序

### Phase 1: Vue 2構文修正（即座に実行）
1. **UpgradePage.vueの修正**
   ```javascript
   // 修正前（Vue 3）
   import { ref, computed, onMounted } from 'vue'
   
   // 修正後（Vue 2）
   export default {
     data() {
       return { ... }
     },
     computed: { ... },
     mounted() { ... }
   }
   ```

2. **MyAccountPage.vueの確認と修正**
   - 同様にVue 2構文への変換

3. **useMemberAuth.jsの互換性確認**
   - Vue 2での動作確認
   - 必要に応じて書き換え

### Phase 2: API問題の診断（Vue修正後）
1. **現在のAPI設定確認**
   ```bash
   # 確認コマンド
   cat .env | grep API
   npm run dev # ローカルでの動作確認
   ```

2. **エラーログの収集**
   - ブラウザコンソールのエラー
   - ネットワークタブでのAPIコール確認

3. **フォールバック実装**
   ```javascript
   // APIコールのフォールバック例
   async fetchData() {
     try {
       // 本番API
       return await api.get('/endpoint')
     } catch (error) {
       // mockServerへフォールバック
       return mockServer.getData()
     }
   }
   ```

### Phase 3: 統合テスト（Phase 1,2完了後）
1. **ローカル環境テスト**
   - 全ページの動作確認
   - API連携の確認

2. **本番環境デプロイ準備**
   - ビルドエラーの解消
   - 環境変数の設定確認

## 決定事項が必要な項目

### 1. API戦略
- **オプションA**: Laravel APIの修正を優先
  - メリット: 本格的なバックエンド連携
  - デメリット: 時間がかかる可能性

- **オプションB**: mockServerを継続使用
  - メリット: すぐに動作可能
  - デメリット: 実データ連携なし

- **オプションC**: ハイブリッド（推奨）
  - mockServerをフォールバックとして維持
  - 段階的にAPIへ移行

### 2. Vue バージョン
- **現状維持（Vue 2）**: 安定性重視
- **Vue 3へ移行**: 将来性重視（大規模な書き換えが必要）

## 次のアクション

### 即座に実行すべきタスク
1. ✅ この文書の作成（完了）
2. ⏳ UpgradePage.vueのVue 2構文への書き換え
3. ⏳ MyAccountPage.vueの構文確認と修正
4. ⏳ 開発サーバーでの動作確認

### 判断待ちタスク
- Laravel API修正方針の決定
- デプロイ戦略の確定

## テスト項目チェックリスト

### 機能テスト
- [ ] 会員ログイン機能
- [ ] 会員ランクによるアクセス制御
- [ ] 刊行物のダウンロード
- [ ] アップグレード画面の表示
- [ ] マイアカウントページ

### ナビゲーションテスト
- [ ] フッターリンク（セミナー）
- [ ] フッターリンク（お問い合わせ）
- [ ] ヘッダーナビゲーション
- [ ] ログイン後のリダイレクト

### API連携テスト
- [ ] ログインAPI
- [ ] 会員情報取得
- [ ] 刊行物一覧取得
- [ ] セミナー情報取得

## リスクと対策

### リスク1: Vue構文エラーによるビルド失敗
**対策**: 段階的な修正とテスト

### リスク2: API接続不可による機能停止
**対策**: mockServerフォールバック機能の維持

### リスク3: デプロイ後の不具合
**対策**: ステージング環境での十分なテスト

---

最終更新: 2025-08-28
次回レビュー予定: Vue 2構文修正完了後