<template>
  <div class="podcasts is-relative has-background:gray">

    <div class="podcasts-background is-absolute:bottom has-background:secondary has-index:10"></div>

    <section-heading title="الأكثر إستماعاً"/>

    <div class="container has-background:gray is-relative has-index:20">
      <div class="podcasts-list has-width:fluid">
        <article v-for="(item, index) in articles" class="podcast-item is-relative" :key="index">
          <div class="podcast-wrapper is-flex has-align:start">
            <header class="podcast-header">
              <i class="podcast-icon fa fa-play"></i>
            </header>
            <main class="podcast-main">
              <div class="podcast-meta is-flex has-align:center">
                <time class="podcast-publish" v-html="'الإثنين  12 يونيو 2018'"></time>
                <nuxt-link class="podcast-category is-relative has-index:40" to="/">جولة العواصم</nuxt-link>
              </div>
              <h3 class="podcast-title">
                <nuxt-link to="/" v-html="item"></nuxt-link>
              </h3>
            </main>
          </div>
          <nuxt-link class="podcast-anchor is-absolute:all has-index:30" to="/"></nuxt-link>
        </article>
      </div>
    </div>
  </div>
</template>

<script>
  import SectionHeading from '@/components/web/section-heading'

  export default {
    name: 'PodcastsPopular',

    components: {
      SectionHeading
    },

    data() {
      return {
        articles: [
          'بدايات الغزو الإسرائيلي للبنان',
          'إنهيار الإتحاد السوفياتي',
          'التحولات الفكرية والعلمية والفنية :الحركة الإنسية',
          'الاكتشافات الجغرافية وظاهرة الميركنتيلية',
          'الثورات الإجتماعية و السياسية : الثورة الفرنسية',
          'التحولات السريعة و التحولات البطيئة لمجموعة كيميائية'
        ]
      }
    }
  }
</script>

<style lang="stylus" scoped>
  .podcasts
    padding-bottom 20px

  .container
    padding 50px

  .podcasts-list
    display grid
    counter-reset order
    grid-gap 50px
    grid-template-columns repeat(3, 1fr)

  .podcast-item
    height 100px

    &:before
      position absolute
      top 0
      right 0
      bottom 0
      display block
      width 100%
      color rgba($secondary, .05)
      content counter(order)
      counter-increment order
      text-align right
      font-weight bold
      font-style italic
      font-size 150px
      line-height 150px
      transition .25s transform

    &:hover
      &:before
        transform translate3d(-10px, 0, 0)

      .podcast-icon
        background-color $primary
        color #fff

  .podcast-main
    flex 1 1 auto

  .podcast-header
    margin-right 20px

  .podcast-icon
    display flex
    justify-content center
    align-items center
    padding-left 3px /* rtl:ignore */
    size 62px
    background-color #fff
    box-shadow 0 2px 48px 6px rgba(#000, .07)
    color $primary
    font-size 18px
    transition .35s color, .35s background-color
    radius 50%

  .podcast-meta
    margin-bottom 5px
    font-size 13px
    line-height 2

  .podcast-publish
    margin-right 20px
    color $primary

  .podcast-category
    color $secondary
    transition .25s color

    &:hover
      color $primary

  .podcast-title a
    color $secondary
    font-weight bold
    font-size 16px
    line-height 1.8

  .podcasts-background
    height 50%
</style>
