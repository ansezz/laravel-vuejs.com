<template>
  <component :is="this.$store.state.platform"/>
</template>

<script>
  export default {
    layout: ({store}) => store.state.platform,
    components: {
      mobile: () => import(`~/views/mobile/page/hire-us`),
      web: () => import(`~/views/web/page/hire-us`)
    }
  }
</script>

<style>
</style>
