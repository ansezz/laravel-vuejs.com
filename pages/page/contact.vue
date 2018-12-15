<template>
  <component :is="this.$store.state.platform"/>
</template>

<script>
  export default {
    layout: ({store}) => store.state.platform,
    components: {
      mobile: () => import(`~/views/mobile/page/contact`),
      web: () => import(`~/views/web/page/contact`)
    }
  }
</script>

<style>
</style>
