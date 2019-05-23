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
          title: '🚀 Products ',
          description: 'Products page',
          type: 'website',
        }
      },
    },
    components: {
      mobile: () => import(`~/views/mobile/page/products`),
      web: () => import(`~/views/web/page/products`)
    }
  }

</script>

<style>
</style>
