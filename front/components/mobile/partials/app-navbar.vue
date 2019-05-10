<template>
    <header class="header is-flex">
      <div class="menu-open" @click="menu = true">
        <i class="fa fa-bars"></i>
      </div>
      <div class="logo">
        <nuxt-link to="/">
          <img src="@/assets/images/logo.png" alt="LV">
        </nuxt-link>
      </div>
      <div class="user">
        <nuxt-link to="/auth/signup">
          <i class="fa fa-user"></i>
        </nuxt-link>
      </div>
      <div :class="[menu ? 'opened': '' ,'menu']">
        <div class="menu-header is-flex">
          <div class="logo">
            <nuxt-link to="/">
              <img src="@/assets/images/logo.png" alt="LV">
            </nuxt-link>
          </div>
          <div class="is-flex">
            <div class="search" @click.prevent="toggleSearchVisibility">
              <i class="fa fa-search"></i>
            </div>
            <div class="close-menu" @click="menu = false">
              <img src="@/assets/images/cancel.png" alt="LV">
            </div>
          </div>
        </div>
        <div class="menu-body">
          <ul>
            <li v-for="(item ,key) in main_menu" :key="key">
              <nuxt-link :to="item.url">{{item.name}}</nuxt-link>
            </li>
          </ul>
          <ul class="second-menu">
            <li v-for="(item ,key) in second_menu" :key="key">
                <nuxt-link :to="item.url">{{item.name}}</nuxt-link>
              </li>
          </ul>
          <ul class="social-media">
            <li v-for="(item, index) in social_media" :key="index"
                :class="item.class">
                <a :href="item.href" target="_blank">
                    <i class="fa" :class="'fa-'+item.class"/>
                </a>
            </li>
          </ul>
        </div>
      </div>
      <app-search />
    </header>
</template>

<script>
    import {mapActions, mapMutations} from 'vuex'
    import AppSearch from '@/components/mobile/partials/app-search';
    export default {
        name: 'AppNavbar',
        components: {
          AppSearch
        },
        computed: {
            main_menu() {
                return this.$store.state.main_menu;
            },
            second_menu() {
                return this.$store.state.second_menu;
            },
            social_media() {
                return this.$store.state.social_media;
            }
        },
        watch: {
          $route: function () {
                this.setSearchVisibility(false)
                this.menu = false
            }
        },
        methods: {
            ...mapMutations({
                setSearchVisibility: 'SET_SEARCH_VISIBILITY'
            }),
            ...mapActions(['toggleSearchVisibility']),
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
    .fa
      font-size 15px
      color $secondary
      &.fa-search
        font-size 18px
        margin-top 3px
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
      margin-left 20px
      img
        width 15px
  .menu-body
    height 90%
    overflow-y scroll
    padding-bottom 40px
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
      &.second-menu
        li
          border-bottom 0
          margin-bottom 0
          padding-bottom 5px
          a
            font-size 15px
      &.social-media
        display flex
        align-items center
        flex-wrap wrap
        justify-content center
        li
          padding-bottom 5px
          padding-right 10px
          margin-bottom 0
          border-bottom 0
          &:last-child
            padding-right 0
</style>
