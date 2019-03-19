<template>
    <header class="header is-flex">
      <div class="menu-open" @click="menu = true">
        <img src="@/assets/images/icons-menu.png" alt="LV">
      </div>
      <div class="logo">
        <nuxt-link to="/">
          <img src="@/assets/images/logo.png" alt="LV">
        </nuxt-link>
      </div>
      <div class="user">
        <nuxt-link to="/">
          <img src="@/assets/images/icons-user.png" alt="LV">
        </nuxt-link>
      </div>
      <div :class="[menu ? 'opened': '' ,'menu']">
        <div class="menu-header is-flex">
          <div class="logo">
            <nuxt-link to="/">
              <img src="@/assets/images/logo.png" alt="LV">
            </nuxt-link>
          </div>
          <div class="close-menu" @click="menu = false">
            <img src="@/assets/images/cancel.png" alt="LV">
          </div>
        </div>
      </div>
    </header>
</template>

<script>
    export default {
        name: 'AppNavbar',
        components: {
        },
        data() {
            return {
              menu: false
            }
        }
    }

</script>

<style lang="stylus" scoped>
  .header
    padding 18px 30px
    border-bottom 5px solid $primary
  .menu
    width 100%
    position fixed
    top 0
    left -100%
    background-color #FFF
    height 100vh
    z-index 2
    transition left .35s ease-in-out
    &.opened
      left 0
  .menu-header
    padding 18px 30px
    border-bottom 5px solid $primary
    .close-menu
      img
        width 15px
</style>
