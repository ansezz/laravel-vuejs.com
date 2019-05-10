<template>
  <component :is="this.$store.state.platform"/>
</template>

<script>
  export default {
    layout: ({store}) => store.state.platform,
    components: {
      mobile: () => import(`~/views/mobile/page/newsletter`),
      web: () => import(`~/views/web/page/newsletter`)
    }
  }
</script>

<style>
</style>
