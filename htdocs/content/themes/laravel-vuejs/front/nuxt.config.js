require('dotenv').config()
const axios = require('axios')

module.exports = {
  modules: [
    '@nuxtjs/axios',
    'nuxt-device-detect',
    'nuxt-buefy',
    '@nuxtjs/pwa',
    '@nuxtjs/dotenv',
    '@nuxtjs/google-analytics',
    '@nuxtjs/sitemap',
    '@nuxtjs/webpackmonitor',
    // @TODO enable component cache only in prod
    // ['@nuxtjs/component-cache', {maxAge: 1000 * 60 * 60}],
    ['@nuxtjs/google-tag-manager', {id: process.env.GOOGLE_TAG_MANAGER}],

  ],
  sitemap: {
    path: '/sitemap.xml',
    // hostname: 'https://example.com',
    cacheTime: 1000 * 60 * 15,
    gzip: true,
    generate: false, // Enable me when using nuxt generate
    exclude: [
      // '/cms/**'
    ],
    routes() {
      return axios.get(process.env.SITE_MAP_URL)
        .then(res => res.data.data.data.map(post => '/' + post.slug))
    }
  },
  'google-analytics': {
    id: process.env.GOOGLE_ANALYTICS
  },
  axios: {
    baseURL: process.env.API_URL,
    headers: {
      'X-Requested-With': 'XMLHttpRequest'
    },
    withCredentials: false,
  },
  manifest: {
    name: 'Nuxt Demo',
    short_name: 'NuxtDemo',
    title: 'Nuxt Demo Title',
    'og:title': 'Nuxt Demo ogTitle',
    description: 'Nuxt Demo  appDescription',
    'og:description': 'Nuxt Demo  ogDescription',
    lang: 'en',
    theme_color: '#42b883',
    background_color: '#35495e'
  },
  router: {
    middleware: 'platform',
  },
  css: [],
  /*
  ** Headers of the page
  */
  head: {
    title: 'Nuxt Demo',
    meta: [
      {charset: 'utf-8'},
      {name: 'viewport', content: 'width=device-width, initial-scale=1'},
      {hid: 'description', name: 'description', content: 'Nuxt.js project'}
    ],
    link: [
      {rel: 'icon', type: 'image/x-icon', href: '/favicon.ico'},
      {rel: 'stylesheet', href: 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'}
    ],
    script: [],
  },
  /*
  ** Customize the progress bar color
  */
  loading: {color: '#3B8070'},
  // @TODO : custom loading
//  loading: '~/components/loading.vue'

  /*
  ** Build configuration
  */
  // build: {
  //   vendor: ['vue-i18n']
  // },
  //
  plugins: ['~/plugins/http'],
  // yarn nuxt build --webpackmonitor --analyze
  webpackMonitor: {
    capture: true, // -> default 'true'
    // target: '../monitor/myStatsStore.json', // default -> '../monitor/stats.json'
    launch: true, // -> default 'false'
    port: 3030, // default -> 8081
    excludeSourceMaps: true // default 'true'
  }
}
