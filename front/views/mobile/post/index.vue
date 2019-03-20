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
            <h5 class="name">Alex JIG</h5>
            <span class="role">Collaborator</span>
          </div>
          <div class="category is-flex">
            <img src="@/assets/images/icons-category.svg" alt="LV">
            <h1>{{ post.categories[0].name }}</h1>
          </div>
        </div>
        <div class="date-time">
            <img src="@/assets/images/icons-clock.svg" alt="LV">
            <span>3 Minutes ago. 12 JUI 2018. 13:55</span>
          </div>
      </div>
    </div>
    <div class="mobile-container">
      <div class="post-content">
        <ul class="actions-list is-flex">
            <div class="is-flex">
              <li><a href="#"><img src="@/assets/images/zoom-in-colored.svg" alt="LV"></a></li>
              <li><a href="#"><img src="@/assets/images/zoom-out.svg" alt="LV"></a></li>
            </div>
            <!-- <li><a href="#"><img src="@/assets/images/icons-star-2.svg" alt="LV"></a></li> -->
          </ul>
        <h1 class="text-center">{{ post.title.substring(0, 45) }}</h1>
        <!--<p>{{ post.excerpt }}</p>-->
        <p>Ah, those warm summer months are the best, aren’t they? And not just because they’re synonymous with lounging poolside or trekking down to the river with family and friends. There’s just something about this time of year that makes it perfect for setting and accomplishing goals, or tackling that special project that’s been at the back of your mind.</p>
        <p>I don’t know if it’s the heat, or the long days, or maybe just that extra touch of playfulness that seems to tickle folks between Spring and Fall. But there’s just something about the summertime that is perfect for finally cleaning out the garage, or taking a class, or picking up a new hobby.</p>
        <div class="image-container">
            <div class="thumbnail-area">
              <thumbnail  :src="post.image_url" :alt="post.title" :to="post.url"/>
              <span class="copyright">&copy; 2018. Copyrights</span>
            </div>
        </div>
        <p>It’s an ideal time for learning some new code skills or building on the ones you already have. Think about it: If you set your mind to it, I mean really committed yourself to doing something awesome, how much could you learn in a single summer? What sorts of cool projects could you build in that time?</p>
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
        <p>If you have your sights set on learning some code and upping your web dev game, here are some great tips and tricks to help you on your way and keep you focused amid those many tantalizing and/or obligatory summertime distractions.</p>
        <div class="pre-box">
          <div class="pre-header">JS</div>
          <pre>
  new Vue({
    el: '#app',
    components: { toogle },
    date: {
      buttonPressed: false
    },
    methods: {
      click(fn) {
        this.buttonPressed = true
        fn()
      },
    },
  });
          </pre>
        </div>
        <p>The summertime sure has its fair share of distractions. The kids are out of school. There are concerts and festivals that beckon. Nature’s in full bloom and enticing us to its beaches and parks. With a million fun and distracting things going on all around us, it can be incredibly difficult to stay focused at times. But where there’s a will, there’s a way — and where there’s a problem, there’s an opportunity for a solution. Like investing in a pair of noise-cancelling headphones, or taking up some mindfulness exercises and practices to quiet and calm the mind and increase your control over your actions, thoughts, and decisions.</p>
        <ul class="share-links">
          <li>
              <a href="#" class="facebook">
                  <i class="fa fa-facebook"></i>
                  <span>Facebook</span>
              </a>
          </li>
          <li>
              <a href="#" class="twitter">
                <i class="fa fa-twitter"></i>
                <span>Twitter</span>
              </a>
          </li>
          <li>
              <a href="#" class="whatssap">
                <i class="fa fa-whatsapp"></i>
                <span>Whats App</span>
              </a>
          </li>
        </ul>
        <!-- <div class="swiper-area">
          <heading>Source</heading>
          <ul>
            <li>Treehouse Team</li>
            <li>Laravel.com</li>
          </ul>
          <app-jobs-swiper />
        </div> -->
        <div class="ads">720x90px</div>
      </div>
    </div>
    <div class="has-bg">
      <div class="single-post-container">
        <app-featured />
      </div>
    </div>
    <div class="single-post-container has-p-45-120">
      <app-comment-area />
    </div>
  </section>
</template>

<script>
  export default {
    components: {
      Breadcrumb: () => import('@/components/shared/partials/elements/breadcrumb'),
      ArticleItem: () =>  import("@/components/shared/partials/elements/article-item"),
      // AppJobsSwiper: () =>  import("@/components/mobile/partials/app-jobs-swiper"),
      AppFeatured: () =>  import("@/components/mobile/partials/app-featured"),
      AppCommentArea: () =>  import("@/components/mobile/partials/app-comment-area")
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
            name: this.post.categories[0].name,
            link: '/'
          },
          {
            name: this.post.title.substring(0, 35)
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
      margin-bottom 20px
    p
      font-size 18px
      line-height 28px
      color #616d82
      margin-bottom 20px
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
    display grid
    grid-template-columns repeat(3, 1fr)
    margin 0 -30px 40px
    li
        a
            display flex
            align-items center
            justify-content center
            color #FFF
            font-size 12px
            font-weight 500
            letter-spacing 1px
            text-transform uppercase
            padding 10px
            &.facebook
              background-color #3B5998
            &.twitter
              background-color #38A1F3
            &.whatssap
              background-color #25D366
            .fa
              margin-right 10px
              padding-top 3px
              font-size 14px
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

</style>
