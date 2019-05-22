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
          title: 'Notification',
          description: 'Manage your notification settings',
          type: 'website'
        }
      }
    },
    components: {
      mobile: () => import(`~/views/mobile/auth/notification`),
      web: () => import(`~/views/web/auth/notification`)
    }
  }
</script>

<style>
</style>
