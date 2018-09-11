<template>
  <component :is="this.$store.state.platform"/>
</template>

<script>
  export default {
    layout: ({store}) => store.state.platform,

    middleware: ['home'],

    components: {
      mobile: () => import(`~/views/mobile/home.vue`),
      web: () => import(`~/views/web/home.vue`)
    }
  }
</script>

<style>
</style>
