<template>
  <component :is="this.$store.state.platform"/>
</template>

<script>
  export default {
    layout: ({store}) => store.state.platform,
    components: {
      mobile: () => import(`~/views/mobile/auth/account`),
      web: () => import(`~/views/web/auth/account`)
    }
  }
</script>

<style>
</style>
