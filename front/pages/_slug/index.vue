<template>
  <component :is="this.$store.state.platform"/>
</template>

<script>
  import seo from '@/mixins/seo'

  export default {
    mixins: [seo],
    async asyncData({error, store}) {
      if (!store.state.post.single)
        error({statusCode: 404, message: 'Post not found or deleted'})
    },
    layout: ({store}) => store.state.platform,
    middleware: ["post"],
    computed: {
      post() {
        return this.$store.state.post.single
      },
      hashTags() {
        let tags = [];
        this.post.tags.forEach((tag) => {
          tags.push(tag.name)
        })
        return tags.join(',')
      },
      seo() {
        return {
          title: this.post.title,
          description: this.post.excerpt,
          image: this.post.image_url,
          url: this.post.url,
          tags: this.post.tags,
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
