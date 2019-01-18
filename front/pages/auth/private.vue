<template>
  <component :is="this.$store.state.platform"/>
</template>

<script>
  export default {
    layout: ({store}) => store.state.platform,
    middleware: 'auth',
    components: {
      mobile: () => import(`~/views/mobile/auth/private`),
      web: () => import(`~/views/web/auth/private`)
    }
  }
</script>

<style>
</style>
