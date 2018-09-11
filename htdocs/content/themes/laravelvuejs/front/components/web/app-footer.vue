<template>
  <footer class="footer">
    <div class="container">
      <frequencies/>
    </div>
    <div class="container:small">
      <div class="row footer-application">
        <p>ماذا تنتظر ؟ قم بتحمل تطبيق مجانا laravelvuejs على</p>
      </div>
      <ul class="row footer-list">
        <nuxt-link v-for="(name, index) in pages" tag="li" :to="name" :key="index">
          <a>{{ name }}</a>
        </nuxt-link>
      </ul>
      <div class="row footer-play is-flex has-justify:center">
        <button class="is-relative is-flex has-align:center has-justify:between">
          <span>إستمع الآن</span>
          <i class="is-absolute:center fa fa-play" aria-hidden="true"></i>
          <span>Écouter</span>
        </button>
      </div>
      <div class="row is-flex:column has-align:center">

        <nuxt-link class="footer-brand" to="/">
          <img src="@/assets/images/brand.white.svg" alt="">
        </nuxt-link>

        <ul class="footer-social">
          <li v-for="item in ['facebook' ,'twitter', 'youtube-play', 'instagram']" :key="item">
            <a href="#" target="_blank">
              <i class="fa" :class="'fa-' + item"></i>
            </a>
          </li>
        </ul>

        <p class="footer-copy">&copy; 2018 ميدي1 - جميع الحقوق محفوظة</p>

      </div>
    </div>
  </footer>
</template>

<script>
  import Frequencies from '@/components/web/partials/frequencies'

  export default {
    name: 'AppFooter',
    components: {Frequencies},
    data() {
      return {
        pages: [
          'أخبار',
          'البرامج',
          'الجدولة',
          'نشرات الأخبار ',
          'إهداء',
          'نشرات الأخبار',
          'أرشيف',
          'الترددات',
          'إهداء',
          'نشرات الأخبار',
          'أرشيف',
          'الترددات'
        ]
      }
    }
  }
</script>

<style lang="stylus" scoped>
  .footer
    margin-top 70px
    background-color $secondary

  .frequencies
    margin-top -44px

  .footer-application
    padding 35px 0
    border-bottom 1px solid rgba($gray, .08)

    p
      color #fff
      font-size 20px

  .footer-list
    display grid
    padding 45px 130px 80px
    width 100%
    border-bottom 1px solid rgba($gray, .08)
    grid-template-columns repeat(3, 1fr)
    grid-gap 30px 15px

    a
      color #fff
      font-size 17px
      truncate true

      &:hover
        color $primary

  .footer-play
    transform translateY(-50%)

    button
      padding 0 55px 0 35px
      width 310px
      height 60px
      border-radius 3px
      background-color #fff
      box-shadow 0 0 0 15px $secondary
      color $secondary
      font-weight bold
      font-size 16px
      transition .25s background-color

      &:hover
        background-color darken(#fff, 10%)

      &:hover i:after
        transform scale(1.05)

    i
      display flex
      justify-content center
      align-items center
      padding-left 2px /* rtl:ignore */
      size 45px
      background-color $primary
      color #fff
      line-height 45px
      radius 50%

      &:after
        position absolute
        top -2px
        right -2px
        bottom -2px
        left -2px
        border 1px solid $primary
        content ''
        transition .25s transform $ease-in-out-quad
        radius 50%

  .footer-brand
    margin-bottom 30px
    width 250px
    opacity .3
    transition .25s opacity

    img
      filter brightness(100)

    &:hover
      opacity .6

  .footer-social
    display flex
    margin-bottom 30px

    a
      color rgba(#fff, .3)
      font-size 18px
      transition .25s color

      &:hover
        color rgba(#fff, .6)

    & li:not(:last-child)
      margin-right 20px

  .footer-copy
    margin-bottom 35px
    color rgba(#cbd2d5, .5)
    font-size 14px
    line-height 1.2
</style>
