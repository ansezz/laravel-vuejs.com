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
        <div class="menu-body">
          <ul>
            <li v-for="(item ,key) in main_menu" :key="key">
              <nuxt-link :to="item.url">{{item.name}}</nuxt-link>
            </li>
            <li v-for="(item ,key) in second_menu" :key="key">
              <nuxt-link :to="item.url">{{item.name}}</nuxt-link>
            </li>
        </ul>
        </div>
      </div>
    </header>
</template>

<script>
    export default {
        name: 'AppNavbar',
        components: {
        },
        computed: {
            main_menu() {
                return this.$store.state.main_menu;
            },
            second_menu() {
                return this.$store.state.second_menu;
            }
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
  .menu-body
    height 90%
    overflow-y scroll
    ul
      padding 15px 30px
      li
        padding-bottom 10px
        border-bottom 1px solid #EEE
        margin-bottom 10px
        &:last-child
          margin-bottom 0
          border-bottom 0
        a
          color #616d82
          font-size 16px
          line-height 30px
          display block
</style>
