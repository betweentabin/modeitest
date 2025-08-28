module.exports = {
  publicPath : './',
  devServer: {
    host: '0.0.0.0',
    port: 8082,
    open: false,
    hot: true,
    disableHostCheck: true,
    watchOptions: {
      poll: true,
      ignored: /node_modules/
    }
  }
}