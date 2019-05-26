<template>
  <div class="app">
    <Navbar/>
    <app-navigation/>
    <app-main>
      <nuxt :nuxt-child-key="$route.fullPath"/>
    </app-main>
    <div class="container">
      <adsbygoogle/>
    </div>
    <app-subscribe/>
    <app-footer/>
  </div>
</template>

<script>
  import AppFooter from "@/components/web/partials/app-footer";
  import AppNavigation from "@/components/web/partials/app-navigation";
  import AppMain from "@/components/web/partials/app-main";
  import AppSubscribe from "@/components/web/partials/app-subscribe";
  import { mapActions } from "vuex";

  export default {
    components: {
      Navbar: () => import("@/components/organisms/navbar"),
      AppFooter,
      AppNavigation,
      AppMain,
      AppSubscribe
    },
    methods: {
      ...mapActions({
        setToken: "auth/SET_TOKEN"
      })
    },
    data() {
      return {};
    },
    created() {
      if (this.$route.query.token) {
        console.log(this.$route.query.token);
        this.setToken(this.$route.query.token);
      }
    }
  };
</script>

<style lang="stylus">
  .app
    min-height 100vh
</style>
