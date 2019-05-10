<template>
  <component :is="this.$store.state.platform"/>
</template>

<script>
  export default {
    layout: ({store}) => store.state.platform,
    components: {
      mobile: () => import(`~/views/mobile/jobs/create-job`),
      web: () => import(`~/views/web/jobs/create-job`)
    }
  }
</script>

<style>
</style>
