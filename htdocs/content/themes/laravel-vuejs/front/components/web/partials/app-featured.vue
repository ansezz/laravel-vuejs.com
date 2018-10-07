<template>
  <section class="featured is-relative has-width:fluid">
    <heading class="is-absolute:top">Featured articles</heading>
    <div class="swiper:articles">
      <div class="is-relative" v-swiper:articlesSwiper="swiper.articles">
        <div class="swiper-wrapper">
          <article-item class="swiper-slide" v-for="(article, index) in articles"
                        :key="index"
                        :index="index"
                        :title="article.title"
                        :description="(index === 0) ? article.excerpt : null"
                        :image="article.image"
                        :href="article.slug"/>
        </div>
        <button class="swiper-button:prev" slot="button-prev">
          <i class="ion-ios-arrow-back"/>
        </button>
        <button class="swiper-button:next" slot="button-next">
          <i class="ion-ios-arrow-forward"/>
        </button>
      </div>
    </div>

  </section>
</template>

<script>
  export default {
    name: 'AppFeatured',

    props: {
      articles: {
        type: Array,
        required: true,
      },
    },

    data() {
      return {
        swiper: {
          articles: {
            slidesPerView: 4,
            spaceBetween: 20,
            navigation: {
              nextEl: '.swiper-button\\:next',
              prevEl: '.swiper-button\\:prev',
            },
          },
        },
      }
    },
  }
</script>

<style lang="stylus" scoped>
  .featured
    padding-bottom 20px
    border-bottom 1px solid $gray

  .swiper-container
    padding-top 84px

  .article >>> .article-title
    color $tertiary
    font-size 16px

  .swiper-button\\:prev
  .swiper-button\\:next
    position absolute
    top 32px
    bottom initial
    left initial
    display flex
    justify-content center
    align-items center
    size 20px
    background-color $primary
    font-size 12px
    radius 50%

    &.swiper-button-disabled
      opacity .6
      cursor not-allowed

  .swiper-button\\:prev
    right 30px
    padding-right 1px

  .swiper-button\\:next
    right 0
    padding-left 1px
</style>
