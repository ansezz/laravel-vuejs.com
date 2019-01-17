var webpack = require('webpack') // Do not forget to add this dependency, or else you will get an error

require("dotenv").config()
// const axios = require("axios")
const resolve = require("path").resolve

module.exports = {
  modules: [
    '@nuxtjs/apollo',
    "@nuxtjs/axios",
    "@nuxtjs/dotenv",
    "@nuxtjs/font-awesome",
    //"@nuxtjs/google-analytics",
    "@nuxtjs/sitemap",
    "@nuxtjs/pwa",
    "@nuxtjs/moment",
    "@nuxtjs/webpackmonitor",
    "nuxt-device-detect",
    // @TODO enable component cache only in prod
    // ['@nuxtjs/component-cache', {maxAge: 1000 * 60 * 60}],
    /*["@nuxtjs/google-tag-manager", {
        id: process.env.GOOGLE_TAG_MANAGER
    }]*/
  ],
  // Give apollo module options
  apollo: {
    // required
    clientConfigs: {
      default: {
        httpEndpoint: process.env.GRAPHQL_URL,
        // wsEndpoint: process.env.GRAPHQL_WS
      }
    }
  },
  /* sitemap: {
     path: "/sitemap.xml",
     // hostname: 'https://example.com',
     cacheTime: 1000 * 60 * 15,
     gzip: true,
     generate: false, // Enable me when using nuxt generate
     exclude: [
       // '/cms/!**'
     ],
     routes() {
       return axios
         .get(process.env.SITE_MAP_URL)
         .then(res => res.data.data.data.map(post => "/" + post.slug))
     }
   },*/
  /*"google-analytics": {
      id: process.env.GOOGLE_ANALYTICS
  },*/
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
    middleware: "platform"
  },
  /*
   ** Headers of the page
   */
  head: {
    title: "Nuxt Demo",
    meta: [
      {
        charset: "utf-8"
      },
      {
        name: "viewport",
        content: "width=device-width, initial-scale=1"
      },
      {
        hid: "description",
        name: "description",
        content: "Nuxt.js project"
      }
    ],
    htmlAttrs: {
      dir: "ltr"
    },
    link: [
      {
        rel: "icon",
        type: "image/x-icon",
        href: "/favicon.ico"
      },
    ],
    script: []
  },
  /*
   ** Customize the progress bar color
   */
  loading: {
    color: "#63F9E6"
  },
  // @TODO : custom loading
  //  loading: '~/components/loading.vue'

  /*
   ** Build configuration
   */
  build: {
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
    {
      src: "~/plugins/ui"
    },
    {
      src: "~/plugins/http"
    },
    {
      src: "~/plugins/social-sharing"
    },
    {
      src: "~/plugins/swiper",
      ssr: false
    },
    {
      src: "~/plugins/lazyload",
      ssr: false
    },
    {
      src: '~/plugins/vue-tags-input',
      ssr: false
    }
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
