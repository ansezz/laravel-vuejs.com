<template>
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div class="footer-box">
                        <nuxt-link class="footer-logo" to="/">
                            <img src="@/assets/images/logo-grey.png" alt="LV">
                        </nuxt-link>
                        <ul class="social-media">
                            <li v-for="(item, index) in social_media" :key="index"
                                :class="item.class">
                                <a :href="item.href" target="_blank">
                                    <i class="fa" :class="'fa-'+item.class"/>
                                </a>
                            </li>
                        </ul>
                        <p class="copyright">&copy; 2019 Laravel & VueJs.</p>
                    </div>
                </div>
                <div class="col-sm-8 col-sm-offset-1">
                    <div class="footer-boxes">
                        <div class="footer-box">
                            <ul class="items">
                                <li class="item-heading">
                                    <span>Blog</span>
                                </li>
                                <li v-for="(item ,key) in main_menu" :key="key">
                                    <nuxt-link :to="item.url">{{item.name}}</nuxt-link>
                                </li>
                            </ul>
                        </div>
                        <div class="footer-box">
                            <!--<ul class="items">
                                <li class="item-heading">
                                    <span>Jobs</span>
                                </li>
                                <li><a href="#">Latest Jobs</a></li>
                                <li><a href="#">Create job</a></li>
                                <li><a href="#">Pricing</a></li>
                                <li><a href="#">Products</a></li>
                                <li><a href="#">Courses</a></li>
                            </ul>-->
                        </div>
                        <div class="footer-box">
                            <ul class="items last-items">
                                <li v-for="(item ,key) in second_menu" :key="key">
                                    <nuxt-link :to="item.url">{{item.name}}</nuxt-link>
                                </li>
                            </ul>
                            <nuxt-link class="button has-icon has-ex-w" to="/auth/login">
                                <img src="@/assets/images/icons-user.png" alt="LV">
                                <span>Sign up/in</span>
                            </nuxt-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</template>

<script>
    export default {
        name: 'AppFooter',
        data() {
            return {}
        },
        watch: {},
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
        methods: {},
    }

</script>

<style lang="stylus" scoped>
    .footer
        padding 60px 0
        border-top 1px solid #EEE

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
