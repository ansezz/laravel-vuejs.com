<template>
  <component :is="this.$store.state.platform"/>
</template>

<script>
  import seo from '@/mixins/seo'

  export default {
    mixins: [seo],
    layout: ({store}) => store.state.platform,
    middleware: ["post"],
    computed: {
      post() {
        return this.$store.state.post.single
      },
      seo() {
        return {
          title: this.post.title,
          description: this.post.excerpt,
          image: this.post.image_url,
          url: this.post.url,
          type: 'article',
        }
      }
    },
    components: {
      mobile: () => import(`~/views/mobile/post`),
      web: () => import(`~/views/web/post`)
    }
  }
</script>

<style>
</style>
