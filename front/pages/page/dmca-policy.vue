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
          title: '🚀 Dmca Policy ',
          description: 'Dmca Policy page',
          type: 'website',
        }
      },
    },
    components: {
      mobile: () => import(`~/views/mobile/page/dmca-policy`),
      web: () => import(`~/views/web/page/dmca-policy`)
    }
  }
</script>

<style>
</style>
