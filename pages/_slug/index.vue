<template>
  <component :is="this.$store.state.platform"/>
</template>

<script>
export default {
  layout: ({ store }) => store.state.platform,

  middleware: ["post"],

  components: {
    mobile: () => import(`~/views/mobile/post`), // eslint-disable-line
    web: () => import(`~/views/web/post`) // eslint-disable-line
  }
}
</script>

<style>
</style>
