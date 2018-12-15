<template>
  <component :is="this.$store.state.platform"/>
</template>

<script>
  export default {
    layout: ({store}) => store.state.platform,
    components: {
      mobile: () => import(`~/views/mobile/auth/reset-password`),
      web: () => import(`~/views/web/auth/reset-password`)
    }
  }
</script>

<style>
</style>
