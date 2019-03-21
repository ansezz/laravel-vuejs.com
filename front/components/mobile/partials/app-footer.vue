<template>
    <footer class="footer">
        <div class="mobile-container">
            <ul class="footer-menu">
                <li class="parent">
                    <nuxt-link to="/">Blog</nuxt-link>
                    <ul>
                        <li v-for="(item ,key) in main_menu" :key="key">
                            <nuxt-link :to="item.url">{{item.name}}</nuxt-link>
                        </li>
                    </ul>
                </li>
                <!--<li class="parent">
                    <nuxt-link to="/">Jobs</nuxt-link>
                </li>-->
            </ul>
            <ul class="main-menu">
                <li v-for="(item ,key) in second_menu" :key="key">
                    <nuxt-link :to="item.url">{{item.name}}</nuxt-link>
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
    </footer>
</template>

<script>
    export default {
        name: 'AppFooter',
        components: {},
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
        data() {
            return {}
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
            flex-wrap wrap
            padding 30px 0 25px

            li
                padding-right 20px
                padding-bottom 5px

                &:last-child
                    padding-right 0

                a
                    display block
                    width 16px
                    height 16px
                    font-size 17px
                    color #311d5a
    .copyright
        color #616d82
        font-size 14px
        margin-bottom 0
        opacity .8
</style>
