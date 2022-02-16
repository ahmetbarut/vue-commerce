module.exports = {
  content: [
    './src/**/*.{vue,js,jsx,ts,tsx}',
    "./node_modules/flowbite/**/*.js"
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require('flowbite/plugin'),
  ],
}
