<template>
  <component :is="this.$store.state.platform"/>
</template>

<script>
  export default {
    layout: ({store}) => store.state.platform,

    middleware: ['home'],

    components: {
      mobile: () => import(`~/views/mobile/grille.vue`),
      web: () => import(`~/views/web/grille.vue`)
    }
  }
</script>

<style>
</style>
