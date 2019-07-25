let config = {
  siteName: 'Laravel-VueJs.com',
  twitter: '@LaravelVueJs',
  fbAppId: '111025849614074',
  themeColor: '#42b883',
  local: 'en',
}

// seo.url
// seo.title
// seo.description
// seo.img
// seo.locale
// seo.twitter
// seo.themeColor

const seo = {
  methods: {
    // Add meta tags to head
    tags() {
      let tags = [];

      if (this.seo.tags)
        this.seo.tags.forEach((tag) => {
          tags.push({
            name: 'article:tag',
            content: tag.name
          })
        })

      return tags;
    }
  },
  head() {
    return {
      title: this.seo.title,
      meta: [
        {hid: 'description', name: 'description', content: this.seo.description},
        // OpenGraph data (Most widely used)

        {hid: 'fb:app_id', property: 'fb:app_id', content: config.fbAppId},
        {name: 'author', content: this.seo.url},
        {name: 'publisher', content: this.seo.url},
        {hid: 'apple-mobile-web-app-title', name: 'apple-mobile-web-app-title', content: this.seo.title},
        {name: 'theme-color', content: config.themeColor},

        // The list of types is available here: http://ogp.me/#types
        {hid: 'og:type', property: 'og:type', content: this.seo.type},
        // Should the the same as your canonical link, see below.
        {hid: 'og:url', property: 'og:url', content: this.seo.url},
        {hid: 'og:image', property: 'og:image', content: this.seo.image},
        // Often the same as your meta description, but not always.
        {hid: 'og:description', property: 'og:description', content: this.seo.description},
        {hid: 'og:title', property: 'og:title', content: this.seo.title},
        {hid: 'og:site_name', property: 'og:site_name', content: config.siteName},
        {hid: 'og:locale', property: 'og:locale', content: config.locale},

        // Twitter card
        {hid: 'twitter:card', name: 'twitter:card', content: 'summary_large_image'},
        {hid: 'twitter:site', name: 'twitter:site', content: this.seo.url},
        {hid: 'twitter:title', name: 'twitter:title', content: this.seo.title},
        {hid: 'twitter:description', name: 'twitter:description', content: this.seo.description},
        // Your twitter handle, if you have one.
        {hid: 'twitter:creator', name: 'twitter:creator', content: config.twitter},
        {hid: 'twitter:image', name: 'twitter:image', content: this.seo.image},
        {hid: 'twitter:image:src', name: 'twitter:image:src', content: this.seo.image},

        // Google / Schema.org markup:
        {itemprop: 'name', content: this.seo.title},
        {itemprop: 'description', content: this.seo.description},
        {itemprop: 'image', content: this.seo.image},
        ...this.tags()
      ]
    }
  },
}

export default seo
