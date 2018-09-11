<template>
  <header class="header has-background:secondary is-clipped">
    <div class="container">
      <div class="row header-primary is-flex has-align:center">
        <button class="navigation-switcher">
          <i class="fa fa-bars"></i>
        </button>
        <nuxt-link class="header-brand" to="/">
          <img src="@/assets/images/brand.white.svg" alt="">
        </nuxt-link>
        <ul class="header-list is-flex has-align:center has-justify:around">
          <nuxt-link v-for="(name, index) in ['الرئيسية', 'أخبار', 'البرامج', 'الجدولة', 'نشرات الأخبار', 'روسيا2018']"
                     tag="li" :to="name" :key="index">
            <a>{{ name }}</a>
          </nuxt-link>
        </ul>
      </div>
      <div class="row header-secondary">
        <div class="column:right is-flex:column">
          <div class="row is-flex has-justify:between is-relative has-index:20">
            <ul class="tabs-list is-flex ">
              <li class="tab-item is-flex has-align:center has-justify:center"
                  v-for="(item, index) in ['الإذاعة المغاربية', 'الإذاعة الإفريقية']"
                  v-html="item"
                  :key="index"
                  :class="{ 'is-active' : tab == index }"
                  @click="tab = index">
              </li>
            </ul>

            <ul class="header-hashtags is-flex has-align:center">
              <nuxt-link v-for="(name, index) in ['رياضة', 'Sport', 'المغرب']" tag="li" :to="name" :key="index">
                <a>{{ name }}</a>
              </nuxt-link>
            </ul>
          </div>

          <ul class="players-list is-relative has-index:10">
            <li class="player-item is-absolute:all"
                v-for="(item, index) in ['الإذاعة المغاربية', 'الإذاعة الإفريقية']"
                v-html="item"
                v-show="tab == index"
                :key="index">
            </li>
          </ul>
        </div>

        <div class="column:left">
          <div class="swiper-webradios is-relative is-clipped has-background:white">
            <h4 class="webradios-heading is-absolute:top">
              <span class="has-color:secondary">Web</span>
              <span class="has-color:primary">radios</span>
            </h4>
            <div class="is-absolute:all" v-swiper:webradiosSwiper="swiper.webradios">
              <ul class="swiper-wrapper">
                <nuxt-link class="swiper-slide webradio-item is-flex has-justify:center has-align:center"
                           v-for="(name, index) in ['jazz', 'lounge', 'classique', 'nayda', 'andalouse']"
                           tag="li"
                           :to="name"
                           :key="index">
                  <a>
                    <img class="webradio-image" :src="'https://unsplash.it/79/79?random=' + index" alt="">
                  </a>
                </nuxt-link>
              </ul>
              <div class="swiper-pagination"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
</template>

<script>
  export default {
    name: 'AppHeader',
    components: {},
    data() {
      return {
        swiper: {
          webradios: {
            pagination: {
              el: '.swiper-pagination',
              dynamicBullets: true
            }
          }
        },
        tab: 0
      }
    },
    mounted() {
    }
  }
</script>

<style lang="stylus" scoped>
  .is-flex
    img
      border-radius 50%

  .header-primary
    height 100px

  .navigation-switcher
    margin-right 20px
    size 35px
    color rgba(#fff, .3)
    font-size 30px
    transition .25s color

    &:hover
      color rgba(#fff, .45)

  .header-brand
    flex 0 0 250px
    margin-right 20px
    width 250px

  .header-list
    flex 1 0 auto

    a
      display flex
      flex-direction column
      align-items center
      color rgba(#fff, 1)
      font-weight bold
      font-size 18px
      line-height 2
      transition .25s color

      &:after
        width 0
        height 2px
        background-color #fff
        content ''
        transition .25s width

    li.nuxt-link-exact-active
    a:hover
      color rgba(#fff, .8)

      &:after
        width 10px

  .column\\:left
    flex 0 0 175px
    width 175px

  .column\\:right
    flex 1 0 auto

  .header-hashtags
    li
      margin-right 15px

    a
      color #fff
      font-size 13px
      transition .25s color

      &:before
        content '#'

      &:hover
        color rgba(#fff, .8)

  .tab-item
    margin-right 7px
    width 160px
    height 45px
    border-top 2px solid transparent
    background-color $tertiary
    color #fff
    font-weight bold
    font-size 14px
    opacity .3
    cursor pointer
    transition .35s border-color, .35s opacity
    radius-top 3px

    &.is-active
      border-color $primary
      opacity 1

  .player-item
    background-color $tertiary
    box-shadow 0 6px 35px 0 rgba(0, 0, 0, .25)

  .swiper-webradios
    height 203px

    .swiper-container
      margin-top 20px

  .webradios-heading
    margin-top 15px
    text-align center
    font-weight bold
    font-size 25px

  .swiper-pagination >>> .swiper-pagination-bullet-active
    background-color $primary

  .players-list
    flex 1 0 auto

</style>
