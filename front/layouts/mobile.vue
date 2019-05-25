<template>
  <div class="app">
    <Navbar/>
    <app-navigation/>
    <main>
      <nuxt/>
    </main>
    <app-subscribe/>
    <app-footer/>
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
