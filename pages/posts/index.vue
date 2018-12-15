<template>
  <component :is="this.$store.state.platform"/>
</template>

<script>
  export default {
    layout: ({store}) => store.state.platform,

    middleware: ["posts"],

    components: {
      mobile: () => import(`~/views/mobile/post/archive.vue`),
      web: () => import(`~/views/web/post/archive.vue`)
    }
  }
</script>

<style>
</style>
