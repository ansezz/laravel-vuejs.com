<template>
    <div class="app">
        <app-navbar />
        <app-navigation />
        <app-main>
            <nuxt />
        </app-main>
        <div class="container">
          <adsbygoogle/>
        </div>
        <app-subscribe />
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="footer-box">
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
                    <div class="col-sm-8 col-sm-offset-1">
                        <div class="footer-boxes">
                            <div class="footer-box">
                                <ul class="items">
                                    <li class="item-heading">
                                        <span>Blog</span>
                                    </li>
                                    <li class="active"><a href="#">Tutorials</a></li>
                                    <li><a href="#">Packages</a></li>
                                    <li><a href="#">Podcast</a></li>
                                    <li><a href="#">Searches</a></li>
                                    <li><a href="#">News</a></li>
                                </ul>
                            </div>
                            <div class="footer-box">
                                <ul class="items">
                                    <li class="item-heading">
                                        <span>Jobs</span>
                                    </li>
                                    <li><a href="#">Latest Jobs</a></li>
                                    <li><a href="#">Create job</a></li>
                                    <li><a href="#">Pricing</a></li>
                                    <li><a href="#">Products</a></li>
                                    <li><a href="#">Courses</a></li>
                                </ul>
                            </div>
                            <div class="footer-box">
                                <ul class="items last-items">
                                    <li><a href="#">About</a></li>
                                    <li><a href="#">Terms & Conditions</a></li>
                                    <li><a href="#">Privacy Policy</a></li>
                                    <li><a href="#">Support Center</a></li>
                                    <li><a href="#">Newsletter</a></li>
                                </ul>
                                <nuxt-link class="button has-icon has-ex-w" to="/">
                                    <img src="@/assets/images/icons-user.png" alt="LV">
                                    <span>Sign up/in</span>
                                </nuxt-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
    .app
        min-height 100vh
    .footer
        padding 60px 0
        .footer-box
            width 200px
            .footer-logo
                display block
            .social-media
                display flex
                align-items center
                justify-content space-between
                padding 40px 0 60px
                li
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
            .items
                position relative
                padding-left 40px
                li
                    a
                        font-size 16px
                        color #616d82
                        line-height 30px
                    &.item-heading
                        transform rotate(90deg)
                        position absolute
                        top 10px
                        left -10px
                        display flex
                        align-items center
                        font-weight 700
                        color $secondary
                        span
                            font-size 16px
                            display block
                &.last-items
                    padding-left 0
                    padding-bottom 45px
        .footer-boxes
            display grid
            grid-template-columns repeat(3, 1fr)

</style>
