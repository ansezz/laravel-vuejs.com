<template>
  <component :is="this.$store.state.platform"/>
</template>

<script>
  export default {
    layout: ({store}) => store.state.platform,
    components: {
      mobile: () => import(`~/views/mobile/page/faq`),
      web: () => import(`~/views/web/page/faq`)
    }
  }
</script>

<style>
</style>
