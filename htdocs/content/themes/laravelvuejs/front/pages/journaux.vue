<template>
  <component :is="this.$store.state.platform"/>
</template>

<script>
  export default {
    layout: ({store}) => store.state.platform,

    middleware: ['home'],

    components: {
      mobile: () => import(`~/views/mobile/journaux.vue`),
      web: () => import(`~/views/web/journaux.vue`)
    }
  }
</script>

<style>
</style>
