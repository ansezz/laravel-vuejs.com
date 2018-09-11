<template>
  <div class="" v-swiper:articlesSwiper="swiper.options">
    <div class="swiper-background is-absolute:all has-background:primary"></div>
    <div class="swiper-wrapper articles-list">
      <article v-for="(item, index) in data" class="swiper-slide article-item has-background:secondary" :key="index">
        <div class="article-wrapper">
          <header class="article-header is-clipped is-absolute:all z-index:10">
            <img class="article-image is-absolute:all" :src="'https://unsplash.it/455/340?random=' + index" alt="">
          </header>
          <main class="article-main is-absolute:bottom has-index:20">
            <div class="article-meta">
              <time class="article-publish" v-html="'الإثنين  12 يونيو 2018'"></time>
            </div>
            <h3 class="article-title">
              <nuxt-link to="/" v-html="item"></nuxt-link>
            </h3>
          </main>
          <footer class="article-footer">
          </footer>
        </div>
        <nuxt-link class="article-anchor is-absolute:all has-index:30" to="/"></nuxt-link>
      </article>
    </div>
    <div class="articles-button:prev">
      <i class="fa fa-angle-right"></i>
    </div>
    <div class="articles-button:next">
      <i class="fa fa-angle-left"></i>
    </div>
    <nuxt-link to="/" class="articles-button:more has-index:10">المزيد من النشرات</nuxt-link>
  </div>
</template>

<script>
  export default {
    name: 'SwiperTab',

    props: {
      data: Array
    },

    data() {
      return {
        swiper: {
          options: {
            spaceBetween: 25,
            observer: true,
            observeParents: true,
            slidesPerView: 'auto',
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
  .article-item
    width 455px
    height 340px

  .swiper-background
    margin 0 55px

  .swiper-container
    padding 100px

  .article-item
    &:hover
      .article-image
        filter blur(2px)
        opacity .66
        transform scale(1.05)

      .article-main
        transform translateY(-4px)

  .article-image
    opacity .88
    transition-timing-function $ease-in-out-quad
    transition-duration .25s
    transition-property filter, opacity, transform

  .article-main
    margin 25px
    transition .25s transform $ease-in-out-quad

  .article-publish
    display block
    margin-bottom 8px
    color $primary
    font-size 13px

  .article-title a
    color #fff
    font-size 34px

  .articles-button
    position absolute
    top 55px
    z-index 10
    display flex
    justify-content center
    align-items center
    size 40px
    border 1px solid #fff
    background-color rgba(#fff, 1)
    color $primary
    font-size 20px
    cursor pointer
    transition .25s background-color, .25s opacity, .25s color
    transform translateY(-50%)

    &.swiper-button-disabled
      background-color rgba(#fff, 0)
      color #fff
      opacity .8
      cursor not-allowed

  .articles-button\\:prev
    @extends .articles-button

    left calc(50% - 42px)

  .articles-button\\:next
    @extends .articles-button

    left calc(50% + 2px)

  .articles-button\\:more
    position absolute
    bottom 20px
    left 50%
    display flex
    flex-direction column
    align-items center
    color #fff
    font-size 15px
    opacity .7
    transition .25s opacity
    transform translateX(-50%)

    &:after
      margin-top 5px
      width 20px
      height 2px
      background-color #fff
      content ''
      transition .25s width $ease-in-out-quad

    &:hover
      color #fff
      opacity 1

      &:after
        width 80%
</style>
