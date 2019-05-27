<template>
  <component :is="this.$store.state.platform"/>
</template>

<script>
  import seo from '@/mixins/seo'

  export default {
    layout: ({store}) => store.state.platform,
    mixins: [seo],
    middleware: ["category"],
    async asyncData({error, store}) {
      if (!store.state.category.category)
        error({statusCode: 404, message: 'Category not found or deleted'})
    },
    computed: {
      seo() {
        return {
          title: this.category.name,
          description: this.category.description,
          type: 'website'
        }
      },
      category() {
        return this.$store.state.category.category
      }
    },
    components: {
      mobile: () => import(`~/views/mobile/category/archive`),
      web: () => import(`~/views/web/category/archive`)
    }
  }
</script>

<style>
</style>
