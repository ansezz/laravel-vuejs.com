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
                <heading>Popular Posts</heading>
                <div class="widget">
                    <article-item horizontal title="New Blade Directives Coming to Laravel 5.6"  to="/"/>
                    <article-item horizontal title="Laravel 5.6 adds the Collision Package for CLI Error Reporting" to="/"/>
                    <article-item horizontal title="Laravel Manchester Meetup" to="/"/>
                </div>
                <div class="widget">
                    <heading>Subsribe</heading>
                    <app-form class="subscribe-widget">
                       <template slot="desc">
                            <p>Sign up for our newsletter, and we'll send you news and tutorials on web design, coding, business, and more!</p>
                        </template>
                        <div class="form-group">
                            <input type="email" class="form-control" placeholder="E-mail">
                            <div class="img">
                                <img src="@/assets/images/icons-email.png" alt="#">
                            </div>
                        </div>
                        <template slot="actions">
                            <button class="button" type="submit">Subscribe</button>
                        </template>
                    </app-form>
                </div>
                <div class="widget last-widget">
                    <div class="ads">300x250</div>
                </div>
            </div>
        </aside>
    </section>
</template>

<script>
    import ArticleItem from "@/components/shared/partials/elements/article-item"
    export default {
        name: 'AppAside',
        components: {
            ArticleItem
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
        .subscribe-widget
            p
                font-size 14px
                font-weight 400
                color $tertiary
                margin-bottom 20px
                opacity .8
            .form-control
                background-color rgba($secondary, .03)
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
