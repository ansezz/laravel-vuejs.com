<template lang="html">
    <section class="posts-container">
        <breadcrumb :pages="breadcrumbsData()"/>
        <div class="mobile-container">
            <div class="single-page-header">
                <div class="is-flex">
                    <div class="author is-flex">
                        <div class="img-wrp">
                            <img src="@/assets/images/brackets.png" alt="LV">
                        </div>
                        <h5 class="name">{{post.user.name}}</h5>
                        <!--<span class="role">Collaborator</span>-->
                    </div>
                    <div class="date-time">
                      <i class="fa fa-clock-o"></i>
                      <span>{{post.time_ago}}</span>
                    </div>
                    <!-- <div class="category is-flex" v-if="post.categories[0]">
                        <i class="fa fa-folder-o"></i>
                        <h1>{{ post.categories[0].name }}</h1>
                    </div> -->
                </div>
            </div>
        </div>
      <div class="mobile-container">
            <div class="post-content">
                <ul class="actions-list is-flex">
                    <div class="is-flex">
                        <!--<li><a href="#"><img src="@/assets/images/zoom-in-colored.svg" alt="LV"></a></li>-->
                        <!--<li><a href="#"><img src="@/assets/images/zoom-out.svg" alt="LV"></a></li>-->
                        <!-- <li><a href="#"><img src="@/assets/images/icons-star-2.svg" alt="LV"></a></li> -->
                    </div>
                </ul>
                <h1 class="text-center">{{ post.title }}</h1>
                <div class="grid-container">
                  <adsbygoogle  class="adsbygoogle" :pageLevelAds="true"/>
                </div>
                <p>{{ post.excerpt }}</p>
                <div class="image-container">
                    <div class="thumbnail-area">
                        <thumbnail :src="post.image_url" :alt="post.title" :to="post.url"/>
                        <!--<span class="copyright">&copy; 2018. Copyrights</span>-->
                    </div>
                </div>
                <adsbygoogle  class="adsbygoogle" :pageLevelAds="true"/>
                <div v-html="post.content" id="content"></div>
                <adsbygoogle  class="adsbygoogle" :pageLevelAds="true"/>
                <div class="grid-container">
                    <div class="grid-articles">
                        <template v-for="(item, key) in related.second">
                            <article-item :title="item.title"
                                          :image="item.image_url"
                                          :key="key"
                                          :to="{ name: 'slug', params: { slug: item.slug }}"
                                          horizontal
                            />
                        </template>
                    </div>
                </div>
                <h4>Tags : </h4>
                <br>
                <div class="tags">
                    <nuxt-link aria-label="Link LV" v-for="tag in post.tags" :key="tag.id" :to="{name: 'tag-slug', params : {slug : tag.slug}}" >
                        {{tag.name}}
                    </nuxt-link>
                </div>
                <social-sharing :url="$parent.seo.url"
                                :title="$parent.seo.title"
                                :description="$parent.seo.description"
                                :media="$parent.seo.image"
                                :hashtags="$parent.hashTags"
                                twitter-user="laravelvuejs"
                                inline-template
                                network-tag="li"
                                v-if="ready"
                >

                    <ul class="share-links">
                        <network network="facebook" class="facebook">
                            <a class="facebook">
                                <i class="fa fa-facebook"></i>
                            </a>
                        </network>
                        <network network="twitter" class="twitter">
                            <a class="twitter">
                                <i class="fa fa-twitter"></i>
                            </a>
                        </network>
                        <network network="whatsapp" class="whatsapp">
                            <a class="whatsapp">
                                <i class="fa fa-whatsapp"></i>
                            </a>
                        </network>
                        <network network="telegram" class="telegram">
                            <a class="telegram">
                                <i class="fa fa-telegram"></i>
                            </a>
                        </network>
                        <network network="reddit" class="reddit">
                            <a class="reddit">
                                <i class="fa fa-reddit"></i>
                            </a>
                        </network>
                        <network network="linkedin" class="linkedin">
                            <a class="linkedin">
                                <i class="fa fa-linkedin"></i>
                            </a>
                        </network>
                    </ul>
                </social-sharing>
            </div>
        </div>
      <div class="single-post-container has-p-45-120">
        <div class="comment-container" v-if="ready">
          <vue-disqus shortname="laravel-vuejs-com"
                      :identifier="post.slug"
                      :title="post.title"
                      :url="this.post.url">
          </vue-disqus>
        </div>
      </div>
      <adsbygoogle  class="adsbygoogle" :pageLevelAds="true"/>
      <div class="has-bg">
            <div class="single-post-container">
                <app-featured title="Related Posts" :items="related.last"/>
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        components: {
            Breadcrumb: () => import('@/components/shared/partials/elements/breadcrumb'),
            ArticleItem: () => import("@/components/shared/partials/elements/article-item"),
            // AppJobsSwiper: () =>  import("@/components/mobile/partials/app-jobs-swiper"),
            AppFeatured: () => import("@/components/mobile/partials/app-featured"),
            // AppCommentArea: () =>  import("@/components/mobile/partials/app-comment-area")
        },
        name: 'post',
        computed: {
            post() {
                return this.$store.state.post.single
            },
            related() {
                return {
                    first: this.$store.state.post.single.related_posts.slice(0, 2),
                    second: this.$store.state.post.single.related_posts.slice(2, 4),
                    last: this.$store.state.post.single.related_posts.slice(4),
                }
            },
        },
        created () {
          this.$nextTick(function () {
            this.ready = true
          })
        },
        data() {
            return {
                ready : false,
                breadcrumbsData: () => [
                    {
                        name: 'Home',
                        link: "/"
                    },
                    {
                        name: this.post.categories[0] ? this.post.categories[0].name : 'Category',
                        link: this.post.categories[0] ? {name: 'category-slug', params : {slug : this.post.categories[0].slug}} : null
                    }
                ]
            }
        }
    }

</script>

<style lang="stylus" scoped>
  .single-page-header
    padding 20px 0 30px
    > .is-flex
      padding-bottom 10px
    .author
      justify-content end
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
        width 60px
        overflow hidden
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
      .fa
          color $secondary
          font-size 16px
    .date-time
      span
        color rgba(#616d82, .8)
        font-size 14px
        font-weight 400
        display inline-block
        margin-left 10px
        padding-top 3px
      .fa
        color $secondary
        font-size 16px
  .post-content
    h1
      font-size 28px
      color #384457
      font-weight 500
      margin-bottom 20px
    p
      font-size 18px
      line-height 28px
      color #616d82
      margin-bottom 20px
      & >>>
        img
          max-width 100%
          margin 10px 0
          height auto
        a
          word-break break-all
    & >>>
      img
        max-width 100%
        height auto
      code
        word-break break-all
    .thumbnail-area
      margin-bottom 20px
      .article-image
        margin-bottom 10px
      .copyright
        font-size 14px
        color rgba(#616d82, .8)
        font-weight 400
    .grid-articles
      display grid
      grid-template-columns repeat(1, 1fr)
      grid-gap 20px
      margin 20px 0
    .pre-box
      padding 20px 0
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
        margin-bottom 0
    .swiper-area
      margin 20px 0 30px
      .heading
        padding-bottom 20px
      ul
        padding-left 10px
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
    width 300px
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
  .has-p-45-120
    padding 35px 0 60px

 .share-links
    position fixed
    bottom 0
    width 100%
    display grid
    grid-template-columns repeat(6, 1fr)
    margin 0 -20px 0
    z-index 1
    & >>>
      li
        display flex
        align-items center
        justify-content center
        font-weight 500
        letter-spacing 1px
        text-transform uppercase
        padding 10px
        a
          color #FFF
        &.facebook
          background-color #3B5998
        &.twitter
          background-color #38A1F3
        &.whatsapp
          background-color #25D366
        &.telegram
          background-color #0088cc
        &.linkedin
          background-color #0077b5
        &.reddit
          background-color #ff4500
        .fa
          padding-top 3px
          font-size 20px
        span
          padding-top 3px
.actions-list
  margin-bottom 20px
  .is-flex
  li
    margin-right 10px
    &:last-child
      margin-right 0
  li
      a
          display flex
          align-items center
          justify-content center
          width 40px
          height 40px
          border-radius 50%
          background-color rgba($secondary, .05)
      &:last-child
          margin-bottom 0


.tags
  a
      border 1px solid $secondary
      display inline-block
      background #FFF
      -webkit-box-shadow 0 1px 1px 0 rgba(180,180,180,0.1)
      box-shadow 0 1px 1px 0 rgba(180,180,180,0.1)
      -webkit-transition all .1s ease-in-out
      -moz-transition all .1s ease-in-out
      -o-transition all .1s ease-in-out
      -ms-transition all .1s ease-in-out
      transition all .1s ease-in-out
      border-radius 2px
      margin 0 3px 6px 0
      padding 5px 10px
      &:hover
          border-color $primary
          color $secondary
          font-weight 500

  #content
  & /deep/
      a.cs-btn.cs-btn-default
      a.cs-btn.cs-btn-Default
          padding 10px
          margin 2px
          display block
          text-align center
.comment-container
  padding 0 30px

</style>
