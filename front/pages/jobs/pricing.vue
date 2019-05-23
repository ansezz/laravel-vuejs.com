<template>
  <component :is="this.$store.state.platform"/>
</template>

<script>
  export default {
    layout: ({store}) => store.state.platform,
    components: {
      mobile: () => import(`~/views/mobile/jobs/pricing`),
      web: () => import(`~/views/web/jobs/pricing`)
    }
  }
</script>

<style>
</style>
