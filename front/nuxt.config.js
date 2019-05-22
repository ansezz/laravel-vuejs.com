var webpack = require('webpack') // Do not forget to add this dependency, or else you will get an error
// const BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin;

require("dotenv").config()
// const axios = require("axios")
const resolve = require("path").resolve

module.exports = {
  modules: [
    '@nuxtjs/onesignal',
    "@nuxtjs/pwa",
    '@nuxtjs/apollo',
    "@nuxtjs/axios",
    "@nuxtjs/dotenv",
    "@nuxtjs/font-awesome",
    "@nuxtjs/toast",
    "@nuxtjs/google-analytics",
    '@nuxtjs/google-adsense',
    "@nuxtjs/sitemap",
    "@nuxtjs/moment",
    "@nuxtjs/webpackmonitor",
    "nuxt-device-detect",
    '@nuxtjs/sentry',
    // @TOD : create Creating an experiment fro google optimize
    /*'nuxt-google-optimize',*/
    // @TODO enable component cache only in prod
    // ['@nuxtjs/component-cache', {maxAge: 1000 * 60 * 60}],
    /*["@nuxtjs/google-tag-manager", {
        id: process.env.GOOGLE_TAG_MANAGER
    }]*/
  ],
  // Optional options
  googleOptimize: {
    // experimentsDir: '~/experiments',
    // maxAge: 60 * 60 * 24 * 7 // 1 Week
    // pushPlugin: true,
  },
  // @TODO : this.$sentry.captureException(new Error('example'))
  sentry: {
    dsn: 'https://05823801c6c64430a9716187dc90f7bd@sentry.io/188197', // Enter your project's DSN here
    config: {}, // Additional config
  },
  oneSignal: {
    init: {
      appId: '0574cfe4-d2e3-403d-b7b5-875f56652248',
      allowLocalhostAsSecureOrigin: true,
      welcomeNotification: {
        disable: true
      }
    }
  },
  toast: {
    position: 'top-center',
    duration: 4000
  },
  'google-adsense': {
    id: process.env.GOOGLE_ADSENSE
  },
  // Give apollo module options
  apollo: {
    errorHandler: '~/plugins/apollo-error-handler.js',
    // required
    clientConfigs: {
      default: {
        fetchPolicy: 'no-cache',
        httpEndpoint: process.env.GRAPHQL_URL,
        // wsEndpoint: process.env.GRAPHQL_WS
      }
    }
  },
  "google-analytics": {
    id: process.env.GOOGLE_ANALYTICS
  },
  axios: {
    baseURL: process.env.API_URL,
    headers: {
      "X-Requested-With": "XMLHttpRequest"
    },
    withCredentials: false
  },
  manifest: {
    name: "Laravel-VueJs.com",
    short_name: "Laravel-VueJs.com",
    title: "Laravel-VueJs.com",
    "og:title": "Laravel-VueJs.com",
    description: "Laravel-VueJs.com",
    "og:description": "Laravel-VueJs.com",
    lang: "en",
    theme_color: "#42b883",
    background_color: "#35495e"
  },
  router: {
    middleware: ["platform", "global"]
  },
  /*
   ** Headers of the page
   */
  head: {
    titleTemplate: '%s  ←  Laravel-VueJs.com > Beta',
    title: "Laravel-VueJs.com",
    meta: [
      {charset: "utf-8"}, {name: "viewport", content: "width=device-width, initial-scale=1"}
    ],
    htmlAttrs: {dir: "ltr"},
    link: [
      {rel: "icon", type: "image/x-icon", href: "/favicon.ico"}
    ]
  },
  /*
   ** Customize the progress bar color
   */
  loading: {
    color: "#6936D3",
    height: '10px',
    continuous: true
  },
  // @TODO : custom loading
  //  loading: '~/components/loading.vue'

  /*
   ** Build configuration
   */
  build: {
//    analyze: true,
    babel: {
      plugins: ['@babel/plugin-proposal-nullish-coalescing-operator']
    },
    plugins: [
      new webpack.LoaderOptionsPlugin({
        options: {
          stylus: {
            import: [
              resolve(__dirname, "./assets/stylus/index.styl"),
              "~rupture/rupture/index.styl"
            ]
          }
        }
      })
    ],
    postcss: {
      // Add plugin names as key and arguments as value
      // Install them before as dependencies with npm or yarn
      plugins: {
        // Disable a plugin by passing false as value
        'postcss-rtl': {},
        'lost': {},
      },
    },
    extend(config, {isDev, isClient}) {
    }
  },

  //
  plugins: [
    // new BundleAnalyzerPlugin(),
    {src: "~/plugins/ui"},
    {src: '~/plugins/disqus'},
    {src: "~/plugins/http"},
    {src: "~/plugins/utils"},
    {src: "~/plugins/social-sharing"},
    {src: "~/plugins/swiper", ssr: false},
    {src: "~/plugins/vee-validate", ssr: false},
    {src: "~/plugins/lazyload", ssr: false},
    {src: '~/plugins/vue-tags-input', ssr: false},
    {src: '~/plugins/infinite-loading', ssr: false}
  ],

  css: [
    "swiper/dist/css/swiper.css",
    "ionicons/dist/css/ionicons.min.css",
    "bootstrap/dist/css/bootstrap.css",
    "~/assets/AvenirNextLTPro.css"
  ],

  // yarn nuxt build --webpackmonitor --analyze
  webpackMonitor: {
    capture: true, // -> default 'true'
    // target: '../monitor/myStatsStore.json', // default -> '../monitor/stats.json'
    launch: true, // -> default 'false'
    port: 3030, // default -> 8081
    excludeSourceMaps: true // default 'true'
  }
}
