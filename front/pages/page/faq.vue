<template>
  <component :is="this.$store.state.platform"/>
</template>

<script>
  import seo from '@/mixins/seo'

  export default {
    layout: ({store}) => store.state.platform,
    mixins: [seo],
    computed: {
      seo() {
        return {
          title: '🚀 FAQ ',
          description: 'FAQ page',
          type: 'website',
        }
      },
    },
    components: {
      mobile: () => import(`~/views/mobile/page/faq`),
      web: () => import(`~/views/web/page/faq`)
    }
  }
</script>

<style>
</style>
