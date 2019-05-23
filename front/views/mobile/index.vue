<!--laravelvuejs_Home_M.png-->
<template>
  <section class="home-page-mobile">
    <app-featured />
    <app-feed />
  </section>
</template>

<script>
  export default {
     components: {
      AppFeatured: () => import('@/components/mobile/partials/app-featured'),
      AppFeed: () => import('@/components/mobile/partials/app-feed'),
    },
    name: "index"
  }
</script>

<style lang="stylus" scoped>
  .home-page-mobile
    padding-top 30px
</style>
