<template>
  <nav class="navbar is-sticky:top has-index:80 has-background:white">
    <app-container class="is-relative">
      <app-row class="is-flex has-align:center has-justify:between">

        <ul class="navbar-list is-flex has-align:center">
          <li>
            <button @click="toggleNavigationVisibility">
              <i class="ion-ios-menu"/>
              Menu
            </button>
          </li>
          <li>
            <button>
              <i class="ion-ios-search"/>
              Search
            </button>
          </li>
        </ul>

        <nuxt-link class="navbar-brand is-absolute:center" to="/">
          <img class="has-height:fluid" src="https://upload.wikimedia.org/wikipedia/commons/thumb/0/08/Netflix_2015_logo.svg/2000px-Netflix_2015_logo.svg.png" alt="LV">
        </nuxt-link>

        <ul class="navbar-list is-flex has-align:center">
          <li>
            <button>
              <i class="ion-ios-mail"/>
              Newsletter
            </button>
          </li>
          <li>
            <button>
              <i class="ion-ios-contact"/>
              Sign up/in
            </button>
          </li>
        </ul>

      </app-row>
    </app-container>
  </nav>
</template>

<script>
import { mapActions } from "vuex"

export default {
  name: "AppNavbar",
  methods: {
    ...mapActions(["toggleNavigationVisibility"])
  }
}
</script>

<style lang="stylus" scoped>
  .navbar
    border-bottom 1px solid $gray

    .row
      margin-bottom -1px
      height 70px
      border-bottom 5px solid $primary

  .navbar-list
    li:not(:last-child)
      margin-right 40px

    button
      display flex
      align-items center
      color $secondary
      text-align center
      text-transform uppercase
      letter-spacing 2px
      font-size 12px

    i
      margin-right 10px
      font-size 18px

  .navbar-brand
    display block
    height 28px
</style>
