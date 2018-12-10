import { DEFAULT_LANG } from "~/config"

export default ({app}) => {
  let lang = DEFAULT_LANG

  let request = (endpoint, params) => {
    console.log(" request " + endpoint)
    return app.$axios.$get(endpoint, {params})
    // .then(response => response ? response.data : null)
  }

  let search = params => request(`${lang}/search/`, params)

  let post = {
    list: params => request(`${lang}/post/`, params),

    singular: (slug, params) => request(`${lang}/post/${slug}/`, params),

    category: (slug, params) =>
      request(`${lang}/post/category/${slug}/`, params),

    featured: params => request(`${lang}/post/featured/`, params)
  }

  let page = {
    list: params => request(`${lang}/page/`, params),
    singular: (slug, params) => request(`${lang}/page/${slug}/`, params)
  }

  let settings = {
    all: params => request(`${lang}/settings`, params)
  }

  app.$http = {
    search,
    post,
    page,
    settings
  }
}
