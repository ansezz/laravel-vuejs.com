<template>
  <component :is="this.$store.state.platform"/>
</template>

<script>
  import seo from '@/mixins/seo'

  export default {
    layout: ({store}) => store.state.platform,
    mixins: [seo],
    middleware: ["category"],
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
