<template>
  <header class="header has-background:tertiary">
    <container>
      
      <column>

        <div class="swiper:thumbnail">
          <div class="is-relative embed:wide" ref="thumbnailSwiper" v-swiper:headerSwiper="swiper.thumbnail">
            <div class="swiper-wrapper is-absolute:all">
              <div class="swiper-slide" v-for="(article, index) in articles" :key="index">
                <thumbnail :src="`https://unsplash.it/450/290?random=${index}`" href="/article" :index="index" :alt="article.title"/>
              </div>
            </div>
            <button class="swiper-button:prev" slot="button-prev">
              <i class="ion-ios-arrow-up"/>
            </button>
            <button class="swiper-button:next" slot="button-next">
              <i class="ion-ios-arrow-down"/>
            </button>
          </div>
        </div>

        <div class="swiper:details">
          <div ref="detailsSwiper" v-swiper:detailsSwiper="swiper.details">
            <div class="swiper-wrapper">
              <div class="swiper-slide" v-for="(article, index) in articles" :key="index">
                <h1 class="article-title" v-html="article.title"/>
              </div>
            </div>
          </div>
        </div>

      </column>
      
      <column>
        <app-form class="header-form">
          
          <template slot="header">
            <h4 class="heading:4">Sign Up Now!</h4>
          </template>
          
          <app-control id="FullName" placeholder="Full name" wide/>
          <app-control id="Email" type="email" placeholder="E-mail" wide/>
          <app-control id="Password" type="password" placeholder="Password" wide/>
          
          <template slot="actions">
            <button class="button:primary" type="submit">Start now</button>
            <button class="button" type="submit">I have an account</button>
          </template>

        </app-form>
      </column>
    </container>
  </header>
</template>

<script>
  export default {
    name: 'AppHeader',
    data() {
      return {
        swiper: {
          thumbnail: {
            direction: 'vertical',
            navigation: {
              nextEl: '.swiper-button\\:next',
              prevEl: '.swiper-button\\:prev',
            },
          },
          details: {
            direction: 'vertical',
          },
        },
        articles: [
          {
            title:
              'Promises, promises: A quick introduction to JavaScript concurrency',
          },
          {
            title: 'Laravel Query Builder',
          },
          {
            title:
              'Laravel 5.6 Dynamic Rate Limiting Provides Per-User Request Throttling',
          },
          {
            title: 'Laravel Relationship Events',
          },
          {
            title: 'Eventy: WordPress-like Actions and Filters for Laravel',
          },
        ],
      }
    },
    mounted() {
      this.$nextTick(() => {
        const thumbnailSwiper = this.$refs.thumbnailSwiper.swiper
        const detailsSwiper = this.$refs.detailsSwiper.swiper
        thumbnailSwiper.controller.control = detailsSwiper
        detailsSwiper.controller.control = thumbnailSwiper
      })
    },
  }
</script>

<style lang="stylus" scoped>
  .header
    padding 60px 0

  .header .article-image
    background-color rgba($gray, .1)

  .header .column
    flex 0 0 50%
    margin 0 !important
    width 50%

  .swiper\\:details
    .swiper-container
      height 34px * 2

  .swiper\\:thumbnail
    overflow hidden
    margin-bottom 25px
    padding-right 30px

    .swiper-container
      overflow initial
      // margin-right 30px

  .swiper-button\\:prev
  .swiper-button\\:next
    position absolute
    right -30px
    bottom initial
    left initial
    size 20px
    background-color $primary
    font-size 13px
    radius 50%

    &.swiper-button-disabled
      opacity .6
      cursor not-allowed

  .swiper-button\\:prev
    top 0
    padding-bottom 2px

  .swiper-button\\:next
    top 30px
    padding-top 2px

  .article-title
    overflow hidden
    height 34px * 2
    color #fff
    font-weight 300
    font-size 28px
    line-height 33px

  .header-form
    margin-left auto
    padding 50px
    width 400px
    background-color #fff
</style>
