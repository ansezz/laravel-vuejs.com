<template>
  <component :is="this.$store.state.platform"/>
</template>

<script>
  import seo from '@/mixins/seo'

  export default {
    mixins: [seo],
    layout: ({store}) => store.state.platform,
    middleware: ["home"],
    computed: {
      seo() {
        return {
          title: '🚀 Home ',
          description: 'Home page',
          image: '',
          type: 'website',
        }
      },
    },
    components: {
      mobile: () => import(`~/views/mobile`),
      web: () => import(`~/views/web`)
    }
  }
</script>

<style>
</style>
