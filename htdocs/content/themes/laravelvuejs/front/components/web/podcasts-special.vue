<template>
  <div class="podcast is-relative has-index:40 has-background:secondary">
    <nuxt-link to="/" class="podcast-anchor is-absolute:all has-index:30"></nuxt-link>
    <div class="podcast-shape is-absolute:all"></div>
    <div class="container is-relative has-height:fluid">
      <header class="podcast-header is-relative">
        <img class="podcast-image is-absolute:bottom" src="../../assets/images/special.host.tmp.png" alt="">
      </header>
      <main class="podcast-main is-flex has-align:center">
        <div class="podcast-column">
          <i class="podcast-icon fa fa-play"></i>
        </div>
        <div class="podcast-column">
          <h3 class="podcast-title">مجلة البيئة والتنمية</h3>
          <nuxt-link to="/" class="podcast-author is-relative has-index:40">سناء المسعودي</nuxt-link>
          <div class="podcast-meta is-flex has-align:center">
            <time class="podcast-date">كل يوم أربعاء</time>
            <time class="podcast-time">19:50</time>
          </div>
        </div>
      </main>
      <nuxt-link to="/" class="podcast-button:more is-absolute has-index:40">المزيد من البودكاست</nuxt-link>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'PodcastsSpecial'
  }
</script>

<style lang="stylus" scoped>
  .podcast
    height 453px
    background-image linear-gradient(-48deg, $secondary 0, $tertiary 100%)

  .podcast-shape
    background-image url('../../assets/images/special.shape.png')
    background-position left
    background-repeat no-repeat
    transition .25s transform

  .podcast:hover
    .podcast-image
      transform translateX(-10px)

    .podcast-shape
      transform translateX(-30px)

    .podcast-icon
      &:after
        border 2px solid $primary
        transform scale(1.06)

  .podcast-image
    transition .25s transform

  .container
    display grid
    width 100%
    grid-template-columns repeat(3, 1fr)
    grid-gap 50px

  .podcast-main
    grid-column span 2

  .podcast-title
    margin-bottom 10px
    color #fff
    font-weight bold
    font-size 46px

  .podcast-author
    display inline-block
    margin-bottom 15px
    color #fff
    font-size 24px
    transition .25s color

    &:hover
      color $primary

  .podcast-meta
    line-height 20px

  .podcast-date
    margin-right 13px
    padding-right 13px
    border-right 1px solid rgba(#fff, .3)
    color #fff
    font-weight bold
    font-size 13px

  .podcast-time
    color $primary
    font-weight bold
    font-size 18px

  .podcast-icon
    position relative
    display flex
    justify-content center
    align-items center
    margin-right 40px
    padding-left 3px /* rtl:ignore */
    size 96px
    background-color $primary
    box-shadow 0 7px 12px 0 rgba(#000, .26)
    color #fff
    font-size 30px
    transition .25s background-color
    radius 50%

    &:after
      position absolute
      top -6px
      right -6px
      bottom -6px
      left -6px
      border 4px solid $primary
      content ''
      transition .25s transform, .25s border
      radius 50%

  .podcast-button\\:more
    right 0
    bottom 0
    width 160px
    height 38px
    background-color rgba(#fff, .1)
    color rgba(#fff, .6)
    text-align center
    font-size 13px
    line-height 38px
    transition .25s color, .25s background-color
    radius-top 3px

    &:hover
      background-color $primary
      color #fff
</style>
