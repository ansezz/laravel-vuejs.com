<template>
  <component :is="this.$store.state.platform"/>
</template>

<script>
  export default {
    layout: ({store}) => store.state.platform,

    middleware: ["category"],

    components: {
      mobile: () => import(`~/views/mobile/category/archive`),
      web: () => import(`~/views/web/category/archive`)
    }
  }
</script>

<style>
</style>
