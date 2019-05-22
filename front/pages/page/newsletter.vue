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
          title: '🚀 Signup to our Newsletter ',
          description: 'Signup to our Newsletter',
          type: 'website',
        }
      },
    },
    components: {
      mobile: () => import(`~/views/mobile/page/newsletter`),
      web: () => import(`~/views/web/page/newsletter`)
    }
  }
</script>

<style>
</style>
