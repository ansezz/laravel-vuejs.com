<template>
    <nav class="navbar">
        <div class="container">
           <div class="navbar-container">
                <ul class="navbar-list">
                    <li>
                        <a href="#" @click.prevent="toggleNavigationVisibility">
                            <img src="@/assets/images/icons-menu.png" alt="LV">
                            <span>Menu</span>
                        </a>
                    </li>
                    <li>
                        <a @click.prevent="search = true" href="#">
                          <img src="@/assets/images/icons-search.png" alt="LV">
                          <span>Search</span>
                        </a>
                    </li>
                </ul>

                <nuxt-link class="navbar-logo" to="/">
                    <img src="@/assets/images/logo.png" alt="LV">
                </nuxt-link>

                <ul class="navbar-list">
                    <li>
                        <nuxt-link to="/page/newsletter">
                            <img src="@/assets/images/icons-email.png" alt="LV">
                            <span>Newsletter</span>
                        </nuxt-link>
                    </li>
                    <li v-if="loggedIn && me">
                        <nuxt-link to="/auth/account">
                            <img src="@/assets/images/icons-user.png" :alt="me.name">
                            <span>{{me.name}}</span>
                        </nuxt-link>
                    </li>
                    <li v-else>
                        <nuxt-link to="/auth/signup">
                            <img src="@/assets/images/icons-user.png" alt="LV">
                            <span>Sign up/in</span>
                        </nuxt-link>
                    </li>
                </ul>
           </div>
        </div>
        <div class="search-container" :class="search ? 'open-search' : '' ">
          <div class="container">
            <form action="#" method="POST" class="search-form">
              <div class="form-group">
                <input type="text" name="s" class="form-control" placeholder="Search" @keyup="searching = true">
                <i class="fa" :class="searching ? 'fa-spin fa-spinner' : 'fa-search' "/>
              </div>
              <ul class="search-result">
                <li class="is-relative">
                  <div class="search-thumb">
                    <img src="@/assets/images/preview.png" alt="LV" />
                  </div>
                  <div class="search-info">
                    <h3>Firebase Realtime Admin Dashboard – Vue.js</h3>
                    <span>
                      <i class="fa fa-clock-o"></i>
                      1 week ago
                    </span>
                  </div>
                  <nuxt-link to="/" class="is-absolute" />
                </li>
              </ul>
            </form>
            <div @click.prevent="search = false" class="close-search">
              <img src="@/assets/images/close-button.png" alt="LV">
            </div>
          </div>
        </div>
    </nav>
</template>

<script>
  import {mapActions} from 'vuex'
  import { log } from 'util';

  export default {
      name: 'AppNavbar',
      data() {
        return {
          search: false,
          searching: false
        }
      },
      watch: {
        search: function() {
          this.search ? document.querySelector('html').classList.add('no-scroll') : document.querySelector('html').classList.remove('no-scroll')
        }
      },
      computed :{
        me () {
          return this.$store.state.auth.me
        },
        loggedIn () {
          return this.$store.state.auth.loggedIn
        }
      },
      methods: {
          ...mapActions(['toggleNavigationVisibility']),
      },
  }

</script>

<style lang="stylus" scoped>
    .search-container
      position fixed
      top 0
      left 0
      width 100%
      height 100%
      background-color rgba(0, 0, 0, .9)
      z-index 100
      display none
      align-items center
      justify-content center
      &.open-search
        display flex
      .form-group
        margin-bottom 0
        position relative
        .form-control
          height 80px
          border 0
          border-radius 0
          font-size 25px
          font-weight 600
          background-color #3e383e
          padding-left 20px
          box-shadow none
          color #969393
          &::placeholder
            color #969393
        .fa
          position absolute
          top 0
          right 0
          width 100px
          height 100%
          display flex
          align-items center
          justify-content center
          font-size 25px
          color #969393
      .close-search
        position absolute
        top 100px
        right 150px
        cursor pointer
        img
          width 25px
          height 25px
      .search-result
        background-color #3e383e
        padding 0 20px 20px
        &:hover
          .search-info
            h3
              color $primary
        li
          display flex
          align-items center
        .search-thumb
          width 110px
          margin-right 20px
          img
            width 100%
        h3
          font-size 18px
          color #FFF
          font-weight 600
          margin-bottom 10px
          transition all .35s ease-in-out
        span
          color #b3a7a7
    .navbar
        border 0
        border-radius 0
        margin-bottom 0
        .navbar-container
            display flex
            align-items center
            justify-content space-between
            border-bottom 5px solid $primary
            height 70px
            .navbar-list
                display flex
                align-items center
                li
                    padding-right 42px
                    &:last-child
                        padding-right 0
                    a
                        font-size 12px
                        color $secondary
                        font-weight 600
                        text-transform uppercase
                        display flex
                        align-items center
                        letter-spacing 1px
                        img
                            margin-right 12px
                        span
                            margin-top 4px

</style>
