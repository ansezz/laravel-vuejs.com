<template>
  <component :is="this.$store.state.platform"/>
</template>

<script>
  export default {
    layout: ({store}) => store.state.platform,
    components: {
      mobile: () => import(`~/views/mobile/page/create-job`),
      web: () => import(`~/views/web/page/create-job`)
    }
  }
</script>

<style>
</style>
