let config = {
  site_name: 'Laravel-VueJs.com',
  twitter: '@LaravelVueJs',
  fb_app_id: '111025849614074',
}

export default {
  head() {
    return {
      title: this.seo.title,
      meta: [
        {hid: 'description', name: 'description', content: this.seo.description},
        // OpenGraph data (Most widely used)
        {property: 'og:title', content: this.seo.title},
        {property: 'og:site_name', content: config.site_name},
        {property: 'fb:app_id', content: config.fb_app_id},
        // The list of types is available here: http://ogp.me/#types
        {property: 'og:type', content: this.seo.type},
        // Should the the same as your canonical link, see below.
        {property: 'og:url', content: this.seo.url},
        {property: 'og:image', content: this.seo.image},
        // Often the same as your meta description, but not always.
        {property: 'og:description', content: this.seo.description},

        // Twitter card
        {name: 'twitter:card', content: 'summary_large_image'},
        {name: 'twitter:site', content: this.seo.url},
        {name: 'twitter:title', content: this.seo.title},
        {name: 'twitter:description', content: this.seo.description},
        // Your twitter handle, if you have one.
        {name: 'twitter:creator', content: config.twitter},
        {name: 'twitter:image:src', content: this.seo.image},

        // Google / Schema.org markup:
        {itemprop: 'name', content: this.seo.title},
        {itemprop: 'description', content: this.seo.description},
        {itemprop: 'image', content: this.seo.image}
      ]
    }
  },
}
