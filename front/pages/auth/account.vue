<template>
  <component :is="this.$store.state.platform"/>
</template>

<script>
  import seo from '@/mixins/seo'

  export default {
    layout: ({store}) => store.state.platform,
    middleware: 'auth',
    mixins: [seo],
    computed: {
      seo() {
        return {
          title: 'My Account',
          description: 'Manage My account',
          type: 'website'
        }
      }
    },
    components: {
      mobile: () => import(`~/views/mobile/auth/account`),
      web: () => import(`~/views/web/auth/account`)
    }
  }
</script>

<style>
</style>
