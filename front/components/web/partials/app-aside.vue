<template>
    <section class="sidebar">
        <aside class="aside">
            <div class="aside-block">
                <heading>Follow us</heading>
                <div class="widget">
                    <ul class="social-media">
                        <li v-for="(item, index) in ['rss', 'youtube', 'instagram', 'twitter', 'facebook']" :key="index"     :class="item">
                            <nuxt-link to="/"><i :class="`fa fa-${item}`" /></nuxt-link>
                        </li>
                    </ul>
                </div>
                <app-popular-posts />
                <app-subscribe-form />
              <div class="widget last-widget">
                      <adsbygoogle />
              </div>
              <div class="widget last-widget">
                <div class="ads">300x250</div>
              </div>
            </div>
        </aside>
    </section>
</template>

<script>
    import AppSubscribeForm from "@/components/web/partials/app-subscribe-form"
    import AppPopularPosts from "@/components/web/partials/app-popular-posts"
    export default {
        name: 'AppAside',
        components: {
            AppSubscribeForm,
            AppPopularPosts
        },
    }
</script>

<style lang="stylus" scoped>
    .sidebar
        width 300px
        .heading
            margin-bottom 30px
        .widget
            margin-bottom 63px
            &.last-widget
                margin-bottom 0
        .social-media
            display flex
            align-items center
            li
                padding-right 20px
                a
                    display block
                    width 16px
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
                &:last-child
                    padding-right 0
        .ads
            width 100%
            height 250px
            display flex
            align-items center
            justify-content center
            background-color #3abbff
            font-size 24px
            color $white
</style>
