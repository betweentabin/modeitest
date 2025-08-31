# Vercel + Railway API接続診断

## 環境情報
- **フロントエンド URL**: https://modeitest.vercel.app
- **バックエンド API URL**: https://heroic-celebration-production.up.railway.app
- **日時**: 2025年8月31日

## 診断結果

### ✅ 良好な点

1. **CORS設定は適切**
   ```php
   // laravel-backend/config/cors.php
   'allowed_origins_patterns' => [
       '/^https:\/\/.*\.vercel\.app$/',  // ✅ modeitest.vercel.appは許可される
   ]
   ```

2. **Vercelサイトは正常稼働**
   - HTTPSで正常にアクセス可能
   - ステータスコード: 200 OK

3. **Railway APIも正常稼働**
   - エンドポイントは応答している
   - ステータスコード: 200 OK

### ⚠️ 問題の可能性

APIエラーが発生している原因として考えられるもの：

## 1. Vercel環境変数の未設定

### 確認方法
Vercelダッシュボード → Settings → Environment Variables

### 必要な設定
```env
# どちらか一つを設定（Vue2の場合）
VUE_APP_API_URL=https://heroic-celebration-production.up.railway.app

# または（Vite使用の場合）
VITE_API_URL=https://heroic-celebration-production.up.railway.app
```

### 設定手順
1. https://vercel.com/dashboard にログイン
2. `modeitest`プロジェクトを選択
3. Settings → Environment Variables
4. 以下を追加：
   - Key: `VUE_APP_API_URL`
   - Value: `https://heroic-celebration-production.up.railway.app`
   - Environment: Production, Preview, Development すべてにチェック
5. 「Save」をクリック
6. **重要**: 再デプロイが必要
   ```bash
   vercel --prod
   ```

## 2. フロントエンドコードの確認

### src/config/api.js の確認
```javascript
// 現在の設定
const API_CONFIG = {
  development: {
    baseURL: 'https://heroic-celebration-production.up.railway.app',
  },
  production: {
    baseURL: 'https://heroic-celebration-production.up.railway.app',
  }
}

// 環境変数を使用するように修正する場合
const API_CONFIG = {
  development: {
    baseURL: process.env.VUE_APP_API_URL || 'https://heroic-celebration-production.up.railway.app',
  },
  production: {
    baseURL: process.env.VUE_APP_API_URL || 'https://heroic-celebration-production.up.railway.app',
  }
}
```

## 3. ブラウザでの確認方法

### デバッグ手順
1. https://modeitest.vercel.app を開く
2. F12で開発者ツールを開く
3. Consoleタブで以下を確認：
   ```javascript
   // APIのベースURLを確認
   console.log(window.location.origin)
   // → https://modeitest.vercel.app
   
   // フェッチのテスト
   fetch('https://heroic-celebration-production.up.railway.app/api/publications')
     .then(res => res.json())
     .then(data => console.log(data))
     .catch(err => console.error(err))
   ```

4. Networkタブで以下を確認：
   - APIリクエストのURL
   - レスポンスステータス
   - エラーメッセージ

### よくあるエラーパターン

| エラーメッセージ | 原因 | 解決方法 |
|---------------|------|---------|
| `CORS policy: No 'Access-Control-Allow-Origin'` | CORS設定の問題 | Laravel側のCORS設定確認 |
| `Failed to fetch` | ネットワークエラー | API URLが正しいか確認 |
| `404 Not Found` | エンドポイントが存在しない | APIパスを確認 |
| `500 Internal Server Error` | サーバーエラー | Railwayのログを確認 |

## 4. 応急処置

現在、フロントエンドはAPIエラー時にフォールバックデータを使用するように設定されています。これにより：
- ✅ サイトは正常に表示される
- ✅ ユーザー体験は維持される
- ⚠️ ただし、実際のデータは表示されない

## 推奨アクション

1. **即座に実施**
   - Vercel環境変数の設定
   - 再デプロイ

2. **確認作業**
   - ブラウザコンソールでエラー詳細を確認
   - NetworkタブでAPIリクエストの詳細を確認

3. **報告事項**
   - 具体的なエラーメッセージ
   - Networkタブのスクリーンショット
   - Consoleタブのエラー内容

## テストコマンド

### ローカルでのテスト
```bash
# APIの疎通確認
curl https://heroic-celebration-production.up.railway.app/api/publications

# CORSヘッダーの確認
curl -H "Origin: https://modeitest.vercel.app" \
     -H "Access-Control-Request-Method: GET" \
     -X OPTIONS \
     https://heroic-celebration-production.up.railway.app/api/publications \
     -v
```

### Vercel CLIでの確認
```bash
# 環境変数の確認
vercel env ls

# ログの確認
vercel logs
```

## まとめ

**最も可能性が高い原因**: Vercel側の環境変数が未設定

**解決手順**:
1. Vercelダッシュボードで環境変数を設定
2. 再デプロイ
3. ブラウザでアクセスして確認

これで問題が解決しない場合は、ブラウザのコンソールエラーの詳細を教えてください。