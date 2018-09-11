<template>
  <component :is="this.$store.state.platform"/>
</template>

<script>
  export default {
    layout: ({store}) => store.state.platform,

    middleware: ['post'],

    components: {
      mobile: () => import(`~/views/mobile/article`),
      web: () => import(`~/views/web/article`)
    }
  }
</script>

<style>
</style>
