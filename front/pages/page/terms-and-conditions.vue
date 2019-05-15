<template>
  <component :is="this.$store.state.platform"/>
</template>

<script>
  import seo from '@/mixins/seo'

  export default {
    mixins: [seo],
    layout: ({store}) => store.state.platform,
    computed: {
      seo() {
        return {
          title: '🚀 Terms and conditions ',
          description: 'Terms and conditions page',
          type: 'website',
        }
      },
    },
    components: {
      mobile: () => import(`~/views/mobile/page/terms-and-conditions`),
      web: () => import(`~/views/web/page/terms-and-conditions`)
    }
  }
</script>

<style>
</style>
