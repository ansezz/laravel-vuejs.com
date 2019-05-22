<template>
  <component :is="this.$store.state.platform"/>
</template>

<script>
  export default {
    layout: ({store}) => store.state.platform,
    components: {
      mobile: () => import(`~/views/mobile/search/search-negative`),
      web: () => import(`~/views/web/search/search-negative`)
    }
  }
</script>

<style>
</style>
