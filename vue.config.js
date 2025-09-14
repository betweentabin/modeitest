module.exports = {
  publicPath: './',
  devServer: {
    // Vercel の `/storage/*` リライトをローカルでも再現
    // ENV があればそれを優先（例: http://127.0.0.1:8000 や 本番API）
    proxy: {
      '^/storage': {
        target: process.env.VUE_APP_API_URL || 'https://heroic-celebration-production.up.railway.app',
        changeOrigin: true,
        secure: false,
      },
    },
    historyApiFallback: {
      rewrites: [
        { from: /.*/, to: '/index.html' }
      ]
    }
  }
}
