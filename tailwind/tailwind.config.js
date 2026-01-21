module.exports = {
  content: [
    '../*.php',
    '../**/*.php',
    '../assets/js/**/*.js',
    '../template-parts/**/*.php',
    '../inc/**/*.php'
  ],
  theme: {
    extend: {
     maxWidth: {
        '8xl': '88rem',      // 1408px
        '9xl': '96rem',      // 1536px
        'prose': '65ch',     // 阅读优化的宽度
        'content': '1200px', // 自定义内容宽度
        'reading': '800px',  // 阅读宽度
      }

    }
  },
  plugins: []
}

