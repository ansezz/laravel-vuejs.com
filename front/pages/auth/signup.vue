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
          title: 'Create new account',
          description: 'Create new account now',
          type: 'website'
        }
      }
    },
    layout: ({store}) => store.state.platform,
    middleware: ['guest'],
    components: {
      mobile: () => import(`~/views/mobile/auth/signup`),
      web: () => import(`~/views/web/auth/signup`)
    }
  }
</script>

<style>
</style>
