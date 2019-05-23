<template>
  <div class="app">
    <app-navbar/>
    <adsbygoogle/>
    <main>
      <nuxt/>
    </main>
    <div class="container">
      <adsbygoogle/>
    </div>
    <div class='onesignal-customlink-container'></div>
    <app-subscribe/>
    <app-footer/>
    <div class="container">
      <adsbygoogle/>
    </div>
  </div>
</template>

<script>
  import AppNavbar from "@/components/mobile/partials/app-navbar";
  import AppFooter from "@/components/mobile/partials/app-footer";
  import AppSubscribe from "@/components/mobile/partials/app-subscribe";
  export default {
    components: {
      AppNavbar,
      AppFooter,
      AppSubscribe
    },
    data() {
      return {};
    },
    methods: {}
  };
</script>

<style lang="stylus" scoped>
  .app
    min-height 100vh
</style>
