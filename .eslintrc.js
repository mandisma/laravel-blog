module.exports = {
  env: {
    browser: true,
    es2021: true,
    commonjs: true
  },
  extends: [
    // 'eslint:recommended',
    'standard',
    'plugin:vue/essential'
  ],
  parserOptions: {
    ecmaVersion: 12,
    sourceType: 'module'
  },
  plugins: [
    'vue'
  ],
  rules: {
    'no-undef': 'off'
  }
}
