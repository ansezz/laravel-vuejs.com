<template>
  <div class="app">
    <!--<github-corner/>-->
    <Navbar/>
    <app-navigation/>
    <main>
      <nuxt/>
    </main>
    <div class="container">
      <adsbygoogle  class="adsbygoogle" :pageLevelAds="true"/>
    </div>
    <div class='onesignal-customlink-container'></div>
    <app-subscribe/>
    <app-footer/>
    <div class="container">
      <adsbygoogle  class="adsbygoogle" :pageLevelAds="true"/>
    </div>
  </div>
</template>

<script>
  import AppFooter from "@/components/mobile/partials/app-footer";
  import AppNavigation from "@/components/web/partials/app-navigation";
  import AppSubscribe from "@/components/mobile/partials/app-subscribe";

  export default {
    components: {
      Navbar: () => import("@/components/organisms/navbar"),
      AppNavigation,
  // githubCorner: () => import("@/components/shared/partials/elements/github-corner"),
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
