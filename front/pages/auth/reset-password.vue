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
          title: 'Reset your password',
          description: 'Reset your password',
          type: 'website'
        }
      }
    },
    layout: ({store}) => store.state.platform,
    middleware: ['guest'],
    components: {
      mobile: () => import(`~/views/mobile/auth/reset-password`),
      web: () => import(`~/views/web/auth/reset-password`)
    }
  }
</script>

<style>
</style>
