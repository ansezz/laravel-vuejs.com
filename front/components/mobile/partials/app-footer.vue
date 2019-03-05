<template>
    <footer class="footer">
      <div class="mobile-container">
        <ul class="footer-menu">
          <li class="parent">
            <nuxt-link to="/">Blog</nuxt-link>
          </li>
          <li class="parent">
            <nuxt-link to="/">Jobs</nuxt-link>
            <ul>
              <li>
                <nuxt-link to="/">Latest Jobs</nuxt-link>
              </li>
              <li>
                <nuxt-link to="/">Create job</nuxt-link>
              </li>
              <li>
                <nuxt-link to="/">Pricing</nuxt-link>
              </li>
              <li>
                <nuxt-link to="/">Products</nuxt-link>
              </li>
              <li>
                <nuxt-link to="/">Courses</nuxt-link>
              </li>
            </ul>
          </li>
        </ul>
        <ul class="main-menu">
          <li>
            <nuxt-link to="/about">About</nuxt-link>
          </li>
          <li>
            <nuxt-link to="/">Terms & Conditions</nuxt-link>
          </li>
          <li>
            <nuxt-link to="/">Privacy Policy</nuxt-link>
          </li>
          <li>
            <nuxt-link to="/">Support Center</nuxt-link>
          </li>
          <li>
            <nuxt-link to="/newsletter">Newsletter</nuxt-link>
          </li>
        </ul>
        <div class="sign-up">
          <nuxt-link to="/" class="button has-icon">
            <img src="@/assets/images/icons-user.png" alt="LV">
            <span>Sign up/in</span>
          </nuxt-link>
        </div>
        <div class="footer-bottom">
          <nuxt-link class="footer-logo" to="/">
              <img src="@/assets/images/logo-grey.png" alt="LV">
          </nuxt-link>
          <ul class="social-media">
              <li class="rss"><a href="#"><i class="fa fa-rss"></i></a></li>
              <li class="youtube"><a href="#"><i class="fa fa-youtube"></i></a></li>
              <li class="instagram"><a href="#"><i class="fa fa-instagram"></i></a></li>
              <li class="twitter"><a href="#"><i class="fa fa-twitter"></i></a></li>
              <li class="facebook"><a href="#"><i class="fa fa-facebook"></i></a></li>
          </ul>
          <p class="copyright">&copy; 2018 Treehouse Island, Inc.</p>
        </div>
      </div>
    </footer>
</template>

<script>
    export default {
        name: 'AppFooter',
        components: {
        },
        data() {
            return {

            }
        }
    }

</script>

<style lang="stylus" scoped>
  .footer
    padding 60px 0 80px
    border-bottom 5px solid $primary
    ul.main-menu,
    ul.footer-menu
      li
        a
          color #616d82
          font-size 16px
          line-height 30px
          display block
        &.parent
          padding-bottom 20px
          border-bottom 2px solid #ebeef2
          margin-bottom 20px
          &:last-child
            padding-bottom 0
            margin-bottom 0
          > a
              color $secondary
              font-weight 700
              display flex
              align-items center
              line-height inherit !important
              &:before
                content "\f0da"
                font-family "FontAwesome"
                margin-right 20px
                font-size 13px
          ul
            padding 10px 0 0 25px
      &.footer-menu
        li
          a
            line-height 50px
      &.main-menu
        padding 60px 0 60px 25px
  .button
    width 100%
    span
      padding-top 4px
  .footer-bottom
    padding 80px 0 0
    text-align center
    .footer-logo
      display block
    .social-media
      display flex
      align-items center
      justify-content center
      padding 30px 0
      li
        padding-right 20px
        &:last-child
          padding-right 0
        a
            display block
            width 16px
            height 16px
            font-size 16px
        &.rss
            a
                color #ff6f00
        &.youtube
            a
                color #e54c4b
        &.instagram
            a
                color #3897f0
        &.twitter
            a
                color #1da1f2
        &.facebook
            a
                color #3b5998
  .copyright
      color #616d82
      font-size 14px
      margin-bottom 0
      opacity .8
</style>
