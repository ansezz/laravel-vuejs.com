<template>
  <component :is="this.$store.state.platform"/>
</template>

<script>
  export default {
    layout: ({store}) => store.state.platform,
    components: {
      mobile: () => import(`~/views/mobile/auth/login`),
      web: () => import(`~/views/web/auth/login`)
    }
  }
</script>

<style>
</style>
