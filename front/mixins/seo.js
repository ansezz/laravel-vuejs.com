let config = {
  siteName: 'Laravel-VueJs.com',
  twitter: '@LaravelVueJs',
  fbAppId: '111025849614074',
  themeColor: '#42b883',
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

        {name: 'fb:app_id', content: config.fbAppId},
        {name: 'author', content: this.seo.url},
        {name: 'publisher', content: this.seo.url},
        {name: 'apple-mobile-web-app-title', content: this.seo.title},
        {name: 'theme-color', content: config.themeColor},

        // The list of types is available here: http://ogp.me/#types
        {name: 'og:type', content: this.seo.type},
        // Should the the same as your canonical link, see below.
        {name: 'og:url', content: this.seo.url},
        {name: 'og:image', content: this.seo.image},
        // Often the same as your meta description, but not always.
        {name: 'og:description', content: this.seo.description},
        {name: 'og:title', content: this.seo.title},
        {name: 'og:site_name', content: config.siteName},
        {name: 'og:locale', content: this.seo.locale},

        // Twitter card
        {name: 'twitter:card', content: 'summary_large_image'},
        {name: 'twitter:site', content: this.seo.url},
        {name: 'twitter:title', content: this.seo.title},
        {name: 'twitter:description', content: this.seo.description},
        // Your twitter handle, if you have one.
        {name: 'twitter:creator', content: config.twitter},
        {name: 'twitter:image', content: this.seo.image},
        {name: 'twitter:image:src', content: this.seo.image},

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
