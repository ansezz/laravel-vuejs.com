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
          title: '🚀 Privacy Policy ',
          description: 'Privacy Policy page',
          type: 'website',
        }
      },
    },
    components: {
      mobile: () => import(`~/views/mobile/page/privacy-policy`),
      web: () => import(`~/views/web/page/privacy-policy`)
    }
  }
</script>

<style>
</style>
