<template>
  <component :is="this.$store.state.platform"/>
</template>

<script>
  export default {
    layout: ({store}) => store.state.platform,
    middleware: ['guest'],
    components: {
      mobile: () => import(`~/views/mobile/auth/forgot-password`),
      web: () => import(`~/views/web/auth/forgot-password`)
    }
  }
</script>

<style>
</style>
