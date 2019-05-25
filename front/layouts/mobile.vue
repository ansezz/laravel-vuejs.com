<template>
  <div class="app">
    <!--<github-corner/>-->
    <app-navbar/>
    <main>
      <nuxt/>
    </main>
    <div class="container">
      <adsbygoogle  class="adsbygoogle"/>
    </div>
    <div class='onesignal-customlink-container'></div>
    <app-subscribe/>
    <app-footer/>
    <adsbygoogle  class="adsbygoogle" :pageLevelAds="true"/>
  </div>
</template>

<script>
  import AppNavbar from "@/components/mobile/partials/app-navbar";
  import AppFooter from "@/components/mobile/partials/app-footer";
  import AppSubscribe from "@/components/mobile/partials/app-subscribe";

  export default {
    components: {
      // githubCorner: () => import("@/components/shared/partials/elements/github-corner"),
      AppNavbar,
      AppFooter,
      AppSubscribe
    },
    data() {
      return {};
    },
    mounted() {
    },
    methods: {}
  };
</script>

<style lang="stylus" scoped>
  .app
    min-height 100vh
</style>
