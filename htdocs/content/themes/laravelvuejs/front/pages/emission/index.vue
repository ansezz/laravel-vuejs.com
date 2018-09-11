<template>
  <component :is="this.$store.state.platform"/>
</template>

<script>
  export default {
    layout: ({store}) => store.state.platform,

    middleware: ['post'],

    components: {
      mobile: () => import(`~/views/mobile/emission/archive.vue`),
      web: () => import(`~/views/web/emission/archive.vue`)
    }
  }
</script>

<style>
</style>
