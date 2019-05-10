<template>
  <component :is="this.$store.state.platform"/>
</template>

<script>
  export default {
    layout: ({store}) => store.state.platform,
    middleware: ['guest'],
    components: {
      mobile: () => import(`~/views/mobile/auth/signup`),
      web: () => import(`~/views/web/auth/signup`)
    }
  }
</script>

<style>
</style>
