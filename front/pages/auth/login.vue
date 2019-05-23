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
          title: 'Login to your account',
          description: 'Login to your account',
          type: 'website'
        }
      }
    },
    layout: ({store}) => store.state.platform,
    middleware: ['guest'],
    components: {
      mobile: () => import(`~/views/mobile/auth/login`),
      web: () => import(`~/views/web/auth/login`)
    }
  }
</script>

<style>
</style>
