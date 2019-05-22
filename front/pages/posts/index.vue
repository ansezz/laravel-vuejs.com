<template>
  <component :is="this.$store.state.platform"/>
</template>

<script>
  import seo from '@/mixins/seo'

  export default {
    layout: ({store}) => store.state.platform,
    middleware: ["posts"],
    mixins: [seo],
    computed: {
      seo() {
        return {
          title: '🚀 Posts ',
          description: 'Posts',
          type: 'website',
        }
      },
    },
    components: {
      mobile: () => import(`~/views/mobile/post/archive.vue`),
      web: () => import(`~/views/web/post/archive.vue`)
    }
  }
</script>

<style>
</style>
