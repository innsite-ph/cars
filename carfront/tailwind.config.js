module.exports = {
    mode: 'jit',
    content: ['./index.html', './src/**/*.{vue,js,ts,jsx,tsx}'], // change `purge` to `content`
    darkMode: 'media', // change `false` to `'media'`
    theme: {
      extend: {},
    },
    variants: {
      extend: {},
    },
    plugins: [],
  }
