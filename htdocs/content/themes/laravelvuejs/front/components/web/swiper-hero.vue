<template>
  <div class="container">
    <div class="row swiper-hero is-relative">
      <header class="swiper-schedules is-absolute:left has-index:10 has-background:primary"></header>

      <header class="swiper-schedules is-absolute:left has-index:40" v-swiper:schedulesSwiper="swiper.schedules"
              ref="schedulesSwiper">
        <div class="schedule-button:prev">
          <i class="fa fa-angle-up"></i>
        </div>
        <ul class="swiper-wrapper">
          <li class="swiper-slide schedule-item" v-for="(item, index) in schedules" :key="index">
            <h4 class="schedule-title">
              <span v-html="item"></span>
              <time>18:00</time>
            </h4>
          </li>
        </ul>
        <div class="schedule-button:next">
          <i class="fa fa-angle-down"></i>
        </div>
      </header>

      <main class="swiper-programs is-relative has-index:20 has-background:secondary"
            v-swiper:programsSwiper="swiper.programs" ref="programsSwiper">
        <div class="swiper-wrapper">
          <nuxt-link class="swiper-slide program-item is-relative" v-for="(item, index) in programs" tag="li" :to="item"
                     :key="index">
            <a class="program-anchor is-flex has-align:center">
              <img class="program-image is-absolute:all z-index:10"
                   :src="'https://unsplash.it/1015/470?random=' + index" alt="">
              <div class="program-details is-absolute z-index:20">
                <h4 class="program-title" v-html="item"></h4>
                <p class="program-description">برنامج ثقافي ترفيهي منوع يستقبل منتصرمن خلاله فنانين ومبدعين هواة ونجوم
                  في مجالات عدة.</p>
                <i class="program-icon fa fa-plus"></i>
              </div>
            </a>
          </nuxt-link>
        </div>
      </main>

      <footer class="swiper-episodes is-absolute has-index:30 has-background:gray">
        <h4 class="episodes-heading">آخر الحلقات</h4>

        <div v-swiper:episodesSwiper="swiper.episodes" ref="episodesSwiper">
          <div class="swiper-wrapper">
            <div class="swiper-slide" v-for="(item, index) in [0,1,2,3,4]" :key="index">
              <ul class="episodes-list">
                <nuxt-link class="episode-item" v-for="(item, index) in episodes" tag="li" :to="item" :key="index">
                  <a class="episode-anchor is-flex has-align:center">
                    <i class="episode-icon fa fa-play" aria-hidden="true"></i>
                    <h5 class="episode-title">
                      <span v-html="item"></span>
                      <time class="episode-duration">3m 45s</time>
                    </h5>
                  </a>
                </nuxt-link>
              </ul>
            </div>
          </div>
        </div>

      </footer>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'SwiperHero',

    data() {
      return {
        swiper: {
          schedules: {
            centeredSlides: true,
            direction: 'vertical',
            slidesPerView: 5,
            slideToClickedSlide: true,
            touchRatio: 0,
            navigation: {
              prevEl: '.schedule-button\\:prev',
              nextEl: '.schedule-button\\:next'
            }
          },
          programs: {
            touchRatio: 0,
            direction: 'vertical'
          },
          episodes: {
            touchRatio: 0
          }
        },
        episodes: [
          'بدايات الغزو الإسرائيلي للبنان',
          'إنهيار الإتحاد السوفياتي',
          'التحولات الفكرية والعلمية والفنية :الحركة الإنسية',
          'الاكتشافات الجغرافية وظاهرة الميركنتيلية',
          'الثورات الإجتماعية و السياسية : الثورة الفرنسية'
        ],
        programs: [
          'بصراحة',
          'عناوين الصحف المغاربية',
          'صباحيات مغاربية',
          'سينما بلال مرميد',
          'موجز الأنباء باللغة العربية'
        ],
        schedules: ['الإثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة']
      }
    },

    mounted() {
      this.$nextTick(() => {
        const schedulesSwiper = this.$refs.schedulesSwiper.swiper
        const programsSwiper = this.$refs.programsSwiper.swiper
        const episodesSwiper = this.$refs.episodesSwiper.swiper

        schedulesSwiper.controller.control = programsSwiper
        programsSwiper.controller.control = episodesSwiper
        episodesSwiper.controller.control = programsSwiper
      })
    }
  }
</script>

<style lang="stylus" scoped>
  .swiper-hero
    margin-top 20px
    margin-bottom 10px
    height 600px
    background-color #fff

  .swiper-schedules
    padding-right 100px
    width 160px + 65px
    pointer-events none

  .schedule-item
    display flex
    justify-content center
    align-items center
    cursor pointer
    pointer-events all

    &:before
    &:after
      position absolute
      top 50%
      right 0
      size 25px
      box-shadow 0 6px 18px 0 rgba(#fff, .28)
      content ''
      opacity .3
      transition .35s transform, .35s opacity, .35s width, .35s height
      transform scale(.7) translate3d(50%, -50%, 0)
      radius 50%

    &:before
      background-color #fff

    &:after
      border 1px solid #fff

    &.swiper-slide-active
      &:before
      &:after
        opacity 1
        transform scale(1) translate3d(50%, -50%, 0)

      &:after
        size 29px

      .schedule-title
        color rgba(#fff, 1)
        transform scale(1)

    &:not(.swiper-slide-active):hover
      &:before
      &:after
        opacity .7
        transform scale(.8) translate3d(50%, -50%, 0)

      .schedule-title
        color rgba(#fff, .8)
        transform scale(.8)

  .schedule-title
    display flex
    flex-direction column
    align-items center
    color rgba(#fff, .4)
    font-size 19px
    line-height 1.2
    transition .35s transform, .35s color
    transform scale(.7)

    time
      font-weight bold
      font-size 24px
      line-height 1.3

  .schedule-button
    position absolute
    right 0
    z-index 1000
    display flex
    justify-content center
    align-items center
    size 65px
    background-color $secondary
    color #fff
    font-size 26px
    cursor pointer
    transition .25s background-color
    pointer-events all

    &.swiper-button-disabled
      background-color $gray
      color rgba(#000, .2)
      cursor not-allowed

  .schedule-button\\:prev
    @extends .schedule-button

    top 0

  .schedule-button\\:next
    @extends .schedule-button

    bottom 0

  .swiper-episodes
    top 65px + 15px
    right 15px
    bottom 65px
    overflow hidden
    width 250px

    .swiper-container
      height calc(100% - 65px)

  .episodes-heading
    padding 0 25px
    height 65px
    color $secondary
    font-weight bold
    font-size 23px
    line-height 65px

  .episodes-list
    overflow-y auto
    height 100%

  .episode-item
    position relative
    margin 0 20px
    padding 15px 0

    &:not(:last-child)
      border-bottom 1px solid #eaeaea

  .episode-anchor
    &:before
      position absolute
      top 5px
      right -10px
      bottom 5px
      left -10px
      background-color rgba(#000, .03)
      content ''
      opacity 0
      transition .25s opacity
      radius 3px

    &:hover:before
      opacity 1

  .episode-icon
    display flex
    flex 0 0 54px
    justify-content center
    align-items center
    margin-right 15px
    padding-left 3px /* rtl:ignore */
    size 54px
    background-color #fff
    box-shadow 0 1px 22px 0 rgba(0, 0, 0, .13)
    color $primary
    font-size 20px
    radius 50%

  .episode-title
    color $secondary
    font-weight bold
    font-size 15px
    line-height 1.2

  .episode-duration
    display block
    margin-top 7px
    font-weight normal
    font-size 14px
    line-height 1.2

  .swiper-programs
    margin-top 65px
    margin-left 160px - 35px
    width 100%
    height 470px

    .swiper-wrapper
      box-shadow 0 6px 54px 0 rgba(#000, .15)

  .program-anchor
    size 100%

    &:hover
      .program-icon
        background-color $primary

      .program-details
        transform translate3d(-50px, -50%, 0)

  .program-image
    size 100%
    object-fit cover

  .program-details
    top 50%
    left 135px
    width 300px
    background-color $secondary
    transition .35s transform
    transform translate3d(0, -50%, 0)
    radius 2px

  .program-title
    padding 33px 33px 0
    color #fff
    font-weight bold
    font-size 45px

  .program-description
    margin-top 10px
    padding 0 66px 33px 33px
    color #fff
    font-size 13px
    line-height 1.6

  .program-icon
    position absolute
    right 15px
    bottom 15px
    display flex
    justify-content center
    align-items center
    size 33px
    background-color rgba(#fff, .1)
    color #fff
    font-size 12px
    transition .25s background-color
</style>
