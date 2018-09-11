<template>
  <div class="swiper-grid has-width:fluid is-relative">
    <div class="swiper-background has-background:white is-absolute:all z-index:10"></div>
    <div class="swiper-foreground has-background:white is-absolute:all z-index:20"></div>
    <div v-swiper:articlesSwiper="swiper.options">
      <div class="swiper-wrapper articles-list">
        <article v-for="(item, index) in data" class="swiper-slide article-item" :key="index">

          <div class="article-background has-background:gray is-absolute:all"></div>

          <div class="article-wrapper is-relative is-flex has-align:center has-height:fluid">
            <header class="article-header is-flex:column has-align:center has-justify:center is-relative z-index:20">
              <span>الآن</span>
              <time>15:00</time>
              <time>18:00</time>
            </header>
            <main class="article-main is-flex has-align:center">
              <div class="article-host:image is-relative">
                <img :src="'https://unsplash.it/110/110?random=' + index" alt="">
                <i class="article-icon fa fa-play"></i>
              </div>
              <div>
                <h3 class="article-title" v-html="item"></h3>
                <h3 class="article-host:name">
                  <nuxt-link to="/" v-html="item"></nuxt-link>
                </h3>
              </div>
            </main>
            <footer class="article-footer is-flex has-align:center">
              <div class="article-meta is-flex:column has-align:end">
                <time class="article-date">كل يوم أربعاء</time>
                <div class="is-flex">
                  <time class="article-time">19:50</time>
                  <time class="article-time">19:50</time>
                </div>
              </div>
            </footer>
          </div>
          <nuxt-link class="article-anchor is-absolute:all has-index:30" to="/"></nuxt-link>
        </article>
      </div>
      <div class="articles-button:prev">
        <i class="fa fa-angle-up"></i>
      </div>
      <div class="articles-button:next">
        <i class="fa fa-angle-down"></i>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'SwiperGrid',

    props: {
      data: Array
    },

    data() {
      return {
        swiper: {
          options: {
            observer: true,
            observeParents: true,
            slidesPerView: 3,
            spaceBetween: 0,
            direction: 'vertical',
            navigation: {
              prevEl: '.articles-button\\:prev',
              nextEl: '.articles-button\\:next'
            }
          }
        }
      }
    },
    mounted() {
    }
  }
</script>

<style lang="stylus" scoped>
  .swiper-grid
    margin-bottom 50px

  .swiper-container
    padding-top 30px
    padding-right 45px
    padding-bottom @padding-top
    width 100%
    height 480px + @padding-top + @padding-top

  .swiper-background
    margin-top 32.5px
    margin-bottom @margin-top

  .swiper-foreground
    margin-left 125px
    box-shadow 0 1px 22px 0 rgba(0, 0, 0, .13)

  .article-background
    opacity 0
    transition .25s opacity

  .article-item:hover
    .article-background
      opacity 1

    .article-icon
      background-color $gray

  .article-header
    flex 0 0 125px
    width 125px
    height 100%
    color $secondary
    font-size 16px
    line-height 1.2

    span
      display flex
      justify-content center
      align-items center
      margin-bottom 10px
      width 43px
      height 24px
      background-color $primary
      color #fff
      text-align center
      font-weight bold
      font-size 13px
      radius 2px

  .article-host\\:image
    flex 0 0 110px
    margin-right 45px

    img
      box-shadow 6px 6px 0 0 $primary
      radius 50%

  .article-icon
    position absolute
    right -6px
    bottom -6px
    display flex
    justify-content center
    align-items center
    size 50px
    background-color #fff
    color $primary
    font-size 20px
    transition .25s background-color

  .article-wrapper
    padding-right 35px

  .article-main
  .article-footer
    height 100%
    border-bottom 1px solid $gray

  .article-main
    flex 1 1 auto
    margin-left 85px

    &:before
    &:after
      position absolute
      top 50%
      left 125px
      size 17px
      background-color $primary
      box-shadow 0 6px 18px 0 rgba(0, 0, 0, .28)
      content ''
      transform translate3d(-50%, -50%, 0)
      radius 50%

    &:before
      size 21px
      border 1px solid $primary
      background-color transparent

  .article-footer
    flex 0 0 auto

  .article-title
    margin-bottom 10px
    color rgb(0, 35, 60)
    color $secondary
    font-weight bold
    font-size 25px

  .article-host\\:name a
    color $secondary
    font-size 15px

  .article-date
    margin-bottom 5px
    color $secondary
    font-size 14px

  .article-time
    margin-left 10px
    color $secondary
    font-weight bold
    font-size 16px

  .articles-button
    position absolute
    left 30px
    z-index 1000
    display flex
    justify-content center
    align-items center
    size 65px
    background-color $primary
    color #fff
    font-size 26px
    cursor pointer
    transition .25s background-color
    pointer-events all

    &.swiper-button-disabled
      background-color $gray
      color rgba(#000, .2)
      cursor not-allowed

  .articles-button\\:prev
    @extends .articles-button

    top 0

  .articles-button\\:next
    @extends .articles-button

    bottom 0
</style>
