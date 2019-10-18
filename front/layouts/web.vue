<template>
  <div class="app">
    <github-corner/>
    <Navbar/>
    <app-navigation/>
    <app-main>
      <div class="info-wrap-right" v-if="show_sticky_ads">
        <adsbygoogle  class="adsbygoogle info" :pageLevelAds="true" />
      </div>
      <div class="info-wrap-left" v-if="show_sticky_ads">
        <adsbygoogle  class="adsbygoogle info" :pageLevelAds="true"/>
      </div>
      <nuxt :nuxt-child-key="$route.fullPath"/>
    </app-main>
    <div class='onesignal-customlink-container'></div>
    <app-subscribe/>
    <app-footer/>
    <div class="container">
      <adsbygoogle  class="adsbygoogle" :pageLevelAds="true"/>
    </div>
  </div>
</template>

<script>
  import AppFooter from "@/components/web/partials/app-footer";
  import AppNavigation from "@/components/web/partials/app-navigation";
  import AppMain from "@/components/web/partials/app-main";
  import AppSubscribe from "@/components/web/partials/app-subscribe";
  import {mapActions} from "vuex";

  export default {
    components: {
      Navbar: () => import("@/components/organisms/navbar"),
      githubCorner: () => import("@/components/shared/partials/elements/github-corner"),
      AppFooter,
      AppNavigation,
      AppMain,
      AppSubscribe
    },
    methods: {
      ...mapActions({
        setToken: "auth/SET_TOKEN"
      }),
      reportWindowSize(){
          if(document.body.clientWidth >= 1400){
              this.show_sticky_ads = true;
          }else{
              this.show_sticky_ads = false;
          }
      }
    },
    data() {
        return {
            show_sticky_ads: false,
        };
    },
    mounted() {
        window.addEventListener('resize', this.reportWindowSize);
        this.reportWindowSize()
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


  .info-wrap-left
    position fixed
    top 100px
    bottom 606
    left 0
    z-index 1
  .info-wrap-right
    position fixed
    top 100px
    right 0
    z-index 1
    bottom 606

  .info
    width 160px
    height 600px
    margin-bottom 20px

</style>
