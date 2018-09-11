<template>
  <component :is="this.$store.state.platform"/>
</template>

<script>
  export default {
    layout: ({store}) => store.state.platform,

    middleware: ['post'],

    components: {
      mobile: () => import(`~/views/mobile/episode`),
      web: () => import(`~/views/web/episode`)
    }
  }
</script>

<style>
</style>
