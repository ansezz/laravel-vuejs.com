<template>
  <component :is="this.$store.state.platform"/>
</template>

<script>
  export default {
    layout: ({store}) => store.state.platform,

    middleware: ['post'],

    components: {
      mobile: () => import(`~/views/mobile/episode/archive.vue`),
      web: () => import(`~/views/web/episode/archive.vue`)
    }
  }
</script>

<style>
</style>
