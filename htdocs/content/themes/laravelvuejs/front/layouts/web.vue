<template>
  <div class="app has-background:gray">
    <app-navbar/>
    <app-header/>
    <main class="main">
      <nuxt/>
    </main>
    <app-footer/>
  </div>
</template>

<script>
  import AppNavbar from '@/components/web/app-navbar'
  import AppHeader from '@/components/web/app-header'
  import AppFooter from '@/components/web/app-footer'

  export default {
    components: {
      AppNavbar,
      AppHeader,
      AppFooter
    }
  }
</script>

<style lang="stylus">
  @lost flexbox flex
  .app
    display flex
    flex-direction column
    min-height 100vh

  .main
    flex 1

  .container
    lost-center 1200px 15px

  .container\\:small
    lost-center 950px 15px

  .row
    width 100%
    lost-center 100% 0

  .article-image
    object-fit cover
</style>
