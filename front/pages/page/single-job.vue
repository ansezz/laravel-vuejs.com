<template>
  <component :is="this.$store.state.platform"/>
</template>

<script>
  export default {
    layout: ({store}) => store.state.platform,
    components: {
      mobile: () => import(`~/views/mobile/page/single-job`),
      web: () => import(`~/views/web/page/single-job`)
    }
  }
</script>

<style>
</style>
