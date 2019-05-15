<template>
  <component :is="this.$store.state.platform"/>
</template>

<script>
  import seo from '@/mixins/seo'

  export default {
    mixins: [seo],
    computed: {
      seo() {
        return {
          title: 'About us',
          description: 'About us page',
          type: 'website'
        }
      }
    },
    layout: ({store}) => store.state.platform,
    components: {
      mobile: () => import(`~/views/mobile/page/about`),
      web: () => import(`~/views/web/page/about`)
    }
  }
</script>

<style>
</style>
