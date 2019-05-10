<template>
  <component :is="this.$store.state.platform"/>
</template>

<script>
  export default {
    layout: ({store}) => store.state.platform,
    components: {
      mobile: () => import(`~/views/mobile/page/about`),
      web: () => import(`~/views/web/page/about`)
    }
  }
</script>

<style>
</style>
