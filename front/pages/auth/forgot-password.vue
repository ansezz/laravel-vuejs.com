<template>
  <component :is="this.$store.state.platform"/>
</template>

<script>
  import seo from '@/mixins/seo'

  export default {
    layout: ({store}) => store.state.platform,
    middleware: ['guest'],
    mixins: [seo],
    computed: {
      seo() {
        return {
          title: 'Forget my password',
          description: 'Forget my password',
          type: 'website'
        }
      }
    },
    components: {
      mobile: () => import(`~/views/mobile/auth/forgot-password`),
      web: () => import(`~/views/web/auth/forgot-password`)
    }
  }
</script>

<style>
</style>
