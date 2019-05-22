<template>
  <component :is="this.$store.state.platform"/>
</template>

<script>
  export default {
    layout: ({store}) => store.state.platform,
    components: {
      mobile: () => import(`~/views/mobile/jobs/single-job`),
      web: () => import(`~/views/web/jobs/single-job`)
    }
  }
</script>

<style>
</style>
