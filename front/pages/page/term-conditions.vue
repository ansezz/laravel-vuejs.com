<template>
  <component :is="this.$store.state.platform"/>
</template>

<script>
  export default {
    layout: ({store}) => store.state.platform,
    components: {
      mobile: () => import(`~/views/mobile/page/term-conditions`),
      web: () => import(`~/views/web/page/term-conditions`)
    }
  }
</script>

<style>
</style>
