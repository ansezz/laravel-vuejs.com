import { DEFAULT_LANG } from '~/config'

export default ({app}) => {

  let lang = DEFAULT_LANG

  let request = (endpoint, params) => {
    return app.$axios.$get(endpoint, {params})
    // .then(response => response ? response.data : null)
  }

// - Search
  let search = (params) => request(`${lang}/search/`, params)

// - Search
  let live = (params) => request(`${lang}/live/`, params)

// - Channels
  let channels = {
    // - All channels:
    all: (params) => request(`channels/`, params)
  }


// - Menu
  let menu = {

    // - All menus:
    all: (params) => request(`menus/`, params),

    // - Singular menu:
    singular: (slug, params) => request(`menus/${slug}/`, params),

  }

// - Archive
  let archive = {

    // - All author posts:
    author: (username, params) => request(`${lang}/authors/${username}/`, params),

    // - All Category posts:
    category: (slug, params) => request(`${lang}/categories/${slug}/`, params),

    // - All tag news:
    tag: (slug, params) => request(`${lang}/tags/${slug}/`, params)

  }

// News
  let news = {

    // - Singular news:
    singular: (slug, params) => request(`${lang}/news/${slug}/`, params),

    // - Category news:
    category: (slug, params) => request(`${lang}/categories/${slug}/news/`, params),

    // - Latest news:
    latest: (params) => request(`${lang}/news/latest/`, params),

    // - Related news:
    related: (slug, params) => request(`${lang}/news/${slug}/related/`, params),

    // - Featured news:
    featured: (params) => request(`${lang}/news/featured/`, params),

    // - Breaking news:
    breaking: (params) => request(`${lang}/news/breaking/`, params)

  }


// Videos
  let videos = {

    // - Singular videos:
    singular: () => {
    },

    // - Category videos:
    category: (slug, params) => request(`${lang}/categories/${slug}/videos/`, params),

    // - Latest videos:
    latest: (params) => request(`${lang}/videos/latest/`, params),

    // - Related videos:
    related: () => {
    },

  }

// - settings
  let settings = {

    // - Home Blocks:
    homeBlocks: (params) => request(`${lang}/settings/home-blocks`, params)

  }


  app.$http = {
    news
  }
}
