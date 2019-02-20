<template lang="html">
    <section class="posts-container">
        <breadcrumb v-if="post" :pages="breadcrumbsData()"/>
        <div class="container" v-if="post">
            <div class="single-page-header is-flex">
                <div class="author is-flex" v-if="post.user">
                    <div class="img-wrp">
                        <img src="@/assets/images/brackets.png" alt="LV">
                    </div>
                    <h5 class="name">{{post.user.name}}</h5>
                    <span class="role">Collaborator</span>
                </div>
                <div class="category is-flex" v-if="post.categories[0]">
                    <img src="@/assets/images/icons-category.svg" alt="LV">
                    <h1>{{ post.categories[0].name }}</h1>
                </div>
                <div class="date-time">
                    <img src="@/assets/images/icons-clock.svg" alt="LV">
                    <span>{{post.created_at}}</span>
                </div>
            </div>
        </div>
        <div class="single-post-container">
            <div class="post-content">
                <h1 class="text-center">{{ post.title.substring(0, 45) }}</h1>
                <p v-html="post.excerpt"></p>
                <div class="image-container">
                    <ul class="share-links">
                        <li>
                            <a href="#">
                                <img src="@/assets/images/icons-facebook-light.svg" alt="LV">
                                <span>Facebook</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <img src="@/assets/images/icons-twitter-light.svg" alt="LV">
                                <span>Twitter</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <img src="@/assets/images/icons-whats-app.svg" alt="LV">
                                <span>Whats App</span>
                            </a>
                        </li>
                    </ul>
                    <div class="thumbnail-area">
                        <thumbnail :src="post.image_url" :alt="post.title" :to="post.url"/>
                        <span class="copyright">&copy; 2018. Copyrights</span>
                    </div>
                    <ul class="actions-list">
                        <li><a href="#"><img src="@/assets/images/zoom-in-colored.svg" alt="LV"></a></li>
                        <li class="m-b-40"><a href="#"><img src="@/assets/images/zoom-out.svg" alt="LV"></a></li>
                        <li><a href="#"><img src="@/assets/images/icons-star-2.svg" alt="LV"></a></li>
                    </ul>
                </div>
                <p v-html="post.content"></p>
                <div class="grid-container">
                    <div class="grid-articles">
                        <article-item
                                title="New Blade Directives Coming to Laravel 5.6"
                                image=""
                                to="/"
                                horizontal
                        />
                        <article-item
                                title="Displaying the Weather With Serverless and Colors"
                                image=""
                                to="/"
                                horizontal
                        />
                    </div>
                </div>
                <p>If you have your sights set on learning some code and upping your web dev game, here are some great
                    tips and tricks to help you on your way and keep you focused amid those many tantalizing and/or
                    obligatory summertime distractions.</p>


                <div class="swiper-area">
                    <heading>Source</heading>
                    <ul>
                        <li>Treehouse Team</li>
                        <li>Laravel.com</li>
                    </ul>
                    <app-jobs-swiper/>
                </div>
                <div class="ads">720x90px</div>
            </div>
        </div>
        <div class="has-bg">
            <div class="single-post-container">
                <app-featured/>
            </div>
        </div>
        <div class="single-post-container has-p-45-120">
            <app-comment-area/>
        </div>
    </section>
</template>

<script>
    export default {
        components: {
            Breadcrumb: () => import('@/components/shared/partials/elements/breadcrumb'),
            ArticleItem: () => import("@/components/shared/partials/elements/article-item"),
            AppJobsSwiper: () => import("@/components/web/partials/app-jobs-swiper"),
            AppFeatured: () => import("@/components/web/partials/app-featured"),
            AppCommentArea: () => import("@/components/web/partials/app-comment-area"),
        },
        name: 'post',
        computed: {
            post() {
                return this.$store.state.post.single
            }
        },
        data() {
            return {
                breadcrumbsData: () => [
                    {
                        name: 'Home',
                        link: "/"
                    },
                    {
                        name: this.post.categories[0] ? this.post.categories[0].name : '',
                        link: '/'
                    },
                    {
                        name: this.post.title.substring(0, 45)
                    }
                ]
            }
        }
    }

</script>

<style lang="stylus" scoped>

    a.cs-btn
        padding 10px
        margin 10px
        border-radius 5px

    .single-post-container
        width 800px
        margin auto

    .image-container
        position relative
        display flex
        align-items flex-start
        width 870px

        .share-links
            transform rotate(90deg)
            position absolute
            left -255px
            top 210px
            display grid
            grid-template-columns repeat(3, 1fr)

            li
                margin-right 30px

                a
                    display flex
                    align-items center
                    color $secondary
                    font-size 12px
                    font-weight 600
                    letter-spacing 2px
                    text-transform uppercase

                    img
                        margin-right 10px

        .actions-list
            display flex
            flex-direction column
            margin-left 30px

            li
                margin-bottom 10px

                a
                    display flex
                    align-items center
                    justify-content center
                    width 40px
                    height 40px
                    border-radius 50%
                    background-color rgba($secondary, .05)

                &.m-b-40
                    margin-bottom 40px

                &:last-child
                    margin-bottom 0

    .grid-container
        width calc(100% - 180px)
        margin auto

    .single-page-header
        padding 40px 0 30px

        .author
            .img-wrp
                width 40px
                height 40px
                display flex
                align-items center
                justify-content center
                background-color rgba(#384457, .05)
                border-radius 50%

                img
                    width 13px

            .name
                font-size 14px
                font-weight 600
                color #384457
                margin 0 20px 0 10px

            .role
                font-size 14px
                color rgba(#616d82, .8)
                font-weight 400

        .category
            h1
                font-size 12px
                letter-spacing 2px
                color $secondary
                font-weight 600
                text-transform uppercase
                margin-left 10px
                padding-top 3px

        .date-time
            span
                color rgba(#616d82, .8)
                font-size 14px
                font-weight 400
                display inline-block
                margin-left 10px
                padding-top 3px

    .post-content
        h1
            font-size 28px
            color #384457
            font-weight 500
            margin-bottom 40px

        p
            font-size 18px
            line-height 28px
            color #616d82
            margin-bottom 20px

        .thumbnail-area
            margin-bottom 20px
            width 800px

            .article-image
                height 430px
                margin-bottom 10px

            .copyright
                font-size 14px
                color rgba(#616d82, .8)
                font-weight 400

        .grid-articles
            display grid
            grid-template-columns repeat(2, 1fr)
            grid-gap 20px
            margin 40px 0

        .pre-box
            padding 20px 0 40px

            .pre-header
                background-color $primary
                font-size 16px
                font-weight 700
                color $secondary
                padding 3px 20px 0

            pre
                background-color #384457
                border-radius 0
                border 0
                color #FFF
                font-size 16px
                font-weight 400
                font-family $family-sans-serif
                padding 20px
                height 327px
                overflow-y hidden

        .swiper-area
            margin 40px 0 10px

            .heading
                padding-bottom 20px

            ul
                padding-left 35px

                li
                    color #616d82
                    font-size 16px
                    padding-bottom 10px
                    display flex
                    align-items center

                    &:before
                        content ""
                        width 6px
                        height 6px
                        background-color #616d82
                        border-radius 50%
                        margin-right 20px

                    &:last-child
                        padding-bottom 0

    .ads
        width 720px
        height 90px
        display flex
        align-items center
        justify-content center
        color #FFF
        background-color #3abbff
        margin 0 auto 40px
        font-size 24px

    .has-bg
        background-color rgba(#6936d3, .03)

        .featured-articles
            &:after
                display none

        & /deep/
        .container
            width 100%

        .posts-grid
            grid-template-columns repeat(3, 1fr)

    .has-p-45-120
        padding 45px 0 120px

</style>
