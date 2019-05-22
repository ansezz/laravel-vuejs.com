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
          title: 'Best Courses',
          description: 'Best Courses page',
          type: 'website'
        }
      }
    },
    layout: ({store}) => store.state.platform,
    components: {
      mobile: () => import(`~/views/mobile/page/courses`),
      web: () => import(`~/views/web/page/courses`)
    }
  }
</script>

<style>
</style>
