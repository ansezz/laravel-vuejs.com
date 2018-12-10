<template>
  <div class="app is-flex:column has-justify:start">
    <app-navbar/>
    <app-navigation/>
    <app-main>
      <nuxt/>
    </app-main>
    <app-subscribe/>
    <footer>
      Footer web
    </footer>
  </div>
</template>

<script>
import AppNavbar from "@/components/web/partials/app-navbar"
import AppNavigation from "@/components/web/partials/app-navigation"
import AppMain from "@/components/web/partials/app-main"
import AppSubscribe from "@/components/web/partials/app-subscribe"

export default {
  components: {
    AppNavbar,
    AppNavigation,
    AppMain,
    AppSubscribe
  },
  data() {
    return {}
  },
  methods: {}
}
</script>

<style lang="stylus">
  @import '../node_modules/hotory'

  .app
    // overflow-x hidden
    min-height 100vh

  .heading\\:4
    color $tertiary
    font-weight 600
    font-size 16px

  .button
  .button\\:primary
  .button\\:secondary
  .button\\:tertiary
    height 40px
    color $secondary
    text-transform uppercase
    letter-spacing 1.4px
    font-weight 600
    font-size 12px

    &.has-color\\:white
      color #fff

  .button\\:primary
  .button\\:secondary
  .button\\:tertiary
    padding 0 20px

  .button\\:primary
    background-color $primary

  .button\\:secondary
    background-color $secondary

  .button\\:tertiary
    background-color $tertiary
</style>
