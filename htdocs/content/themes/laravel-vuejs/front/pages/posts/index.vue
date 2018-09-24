<template>
  <component :is="this.$store.state.platform"/>
</template>

<script>
export default {
  layout: ({ store }) => store.state.platform,

  middleware: ["posts"],

  components: {
    mobile: () => import(`~/views/mobile/post/archive.vue`), // eslint-disable-line
    web: () => import(`~/views/web/post/archive.vue`) // eslint-disable-line
  }
}
</script>

<style>
</style>
