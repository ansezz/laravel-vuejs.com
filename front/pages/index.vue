<template>
  <component :is="this.$store.state.platform"/>
</template>

<script>
  import seo from '@/mixins/seo'

  export default {
    mixins: [seo],
    layout: ({store}) => store.state.platform,
    middleware: ["home"],
    asyncData() {
      return {
        seo: {
          title: 'The latest Articles , Q/A, Trends, Video, Jobs, Services, news, tutorials, plugins, packages, repositories, repository, Vue.Js Vue Laravel',
          description: 'Laravel VueJs The latest Articles , Q/A, Trends, Video, Jobs, Services, news, tutorials, plugins, packages, repositories, repository, Vue.Js Vue Laravel',
          image: '',
          type: 'website',
        }
      }
    },
    components: {
      mobile: () => import(`~/views/mobile`),
      web: () => import(`~/views/web`)
    }
  }
</script>

<style>
</style>
