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
          title: 'Contact us',
          description: 'Contact us page',
          type: 'website'
        }
      }
    },
    layout: ({store}) => store.state.platform,
    components: {
      mobile: () => import(`~/views/mobile/page/contact`),
      web: () => import(`~/views/web/page/contact`)
    }
  }
</script>

<style>
</style>
