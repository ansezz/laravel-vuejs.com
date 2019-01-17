<template>
  <component :is="this.$store.state.platform"/>
</template>

<script>
  export default {
    layout: ({store}) => store.state.platform,

    middleware: ["tag"],

    components: {
      mobile: () => import(`~/views/mobile/tag/archive`),
      web: () => import(`~/views/web/tag/archive`)
    }
  }
</script>

<style>
</style>
