<template>
  <component :is="this.$store.state.platform"/>
</template>

<script>
  export default {
    layout: ({store}) => store.state.platform,
    components: {
      mobile: () => import(`~/views/mobile/search/search-positive`),
      web: () => import(`~/views/web/search/search-positive`)
    }
  }
</script>

<style>
</style>
