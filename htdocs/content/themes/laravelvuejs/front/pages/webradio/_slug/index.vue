<template>
  <component :is="this.$store.state.platform"/>
</template>

<script>
  export default {
    layout: ({store}) => store.state.platform,

    middleware: ['post'],

    components: {
      mobile: () => import(`~/views/mobile/webradio.vue`),
      web: () => import(`~/views/web/webradio.vue`)
    }
  }
</script>

<style>
</style>
