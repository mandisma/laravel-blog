const path = require('path')
const ESLintPlugin = require('eslint-webpack-plugin')
const StylelintPlugin = require('stylelint-webpack-plugin')

module.exports = {
  resolve: {
    alias: {
      '@': path.resolve('resources/js')
    }
  },
  plugins: [
    new ESLintPlugin({
      emitError: true,
      files: 'resources/js/**/*.{js,vue}'
    }),
    new StylelintPlugin({
      files: 'resources/css/**/*.{css,vue}'
    })
  ],
  rules: 
}
