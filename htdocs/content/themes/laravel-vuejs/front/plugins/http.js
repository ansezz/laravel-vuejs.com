import { DEFAULT_LANG } from '~/config'

export default ({app}) => {

  let lang = DEFAULT_LANG

  let request = (endpoint, params) => {
    return app.$axios.$get(endpoint, {params})
    // .then(response => response ? response.data : null)
  }

  let search = (params) => request(`${lang}/search/`, params)

  let posts = {

    list: (params) => request(`${lang}/posts/`, params),

    singular: (slug, params) => request(`${lang}/posts/${slug}/`, params),

    category: (slug, params) => request(`${lang}/posts/category/${slug}/`, params),

    featured: (params) => request(`${lang}/posts/featured/`, params),

  }

  let settings = {

    all: (params) => request(`${lang}/settings`, params)

  }


  app.$http = {
    search,
    posts,
    settings
  }
}
