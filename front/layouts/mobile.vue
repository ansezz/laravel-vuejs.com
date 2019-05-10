<template>
  <div class="mobile-app">
    <app-navbar />
    <main>
      <nuxt/>
    </main>
    <app-subscribe />
    <app-footer />
  </div>
</template>

<script>
  import AppNavbar from "@/components/mobile/partials/app-navbar"
  import AppFooter from "@/components/mobile/partials/app-footer"
  import AppSubscribe from "@/components/mobile/partials/app-subscribe"
  export default {
    components: {
      AppNavbar,
      AppFooter,
      AppSubscribe
    },
    data() {
      return {}
    },
    methods: {}
  }
</script>

<style lang="stylus" scoped>
  .mobile-app
    min-height 100vh
</style>
