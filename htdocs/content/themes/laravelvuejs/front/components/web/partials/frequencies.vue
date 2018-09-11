<template>
  <div class="frequencies row is-flex has-align:end">
    <header class="frequencies-header is-relative has-index:10">
      <h3 class="frequencies-heading is-flex has-align:center">الترددات</h3>
    </header>
    <div class="swiper-frequencies" v-swiper:frequenciesSwiper="swiper.options">
      <div class="swiper-wrapper">
        <div class="swiper-slide" v-for="(item, index) in frequencies" :key="index">
          <h4 class="frequency-heading is-flex has-align:center">{{ item.city }}</h4>
          <p class="frequency-mhz is-flex has-align:center">{{ item.frequency }}</p>
        </div>
      </div>
      <div class="frequencies-button:prev">
        <i class="fa fa-angle-right"></i>
      </div>
      <div class="frequencies-button:next">
        <i class="fa fa-angle-left"></i>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'Frequencies',
    data() {
      return {
        swiper: {
          options: {
            slidesPerView: 'auto',
            spaceBetween: 0,
            navigation: {
              prevEl: '.frequencies-button\\:prev',
              nextEl: '.frequencies-button\\:next'
            }
          }
        },
        frequencies: [
          {city: 'اعزانن', frequency: '89,6 Mhz'},
          {city: 'اكادير', frequency: '104,6 Mhz'},
          {city: 'اكدز', frequency: '97,0 MHz'},
          {city: 'الحسيمة', frequency: '88,5 MHz'},
          {city: 'أولوز', frequency: '96,2 MHz'},
          {city: 'أركانة', frequency: '103,3 Mhz'},
          {city: 'بني ملال', frequency: '102,9 MHz'},
          {city: 'برشيد', frequency: '87,6 MHz'},
          {city: 'بوعرفة', frequency: '97,2 MHz'},
          {city: 'بودنيب', frequency: '105,1 MHz'},
          {city: 'بوجدور', frequency: '97,0 MHz'},
          {city: 'بوكراع', frequency: '99,7 Mhz'},
          {city: 'بولمان', frequency: '97,0 MHz'},
          {city: 'بومالن دادس', frequency: '96,9 MHz'}
        ]
      }
    }
  }
</script>

<style lang="stylus" scoped>
  .frequencies
    flex-wrap nowrap

  .swiper-frequencies
    margin-left -88px
    padding-left 88px

  .frequencies-heading
    padding 0 25px
    width 222px
    height 73px
    border 1px solid rgba($secondary, .15)
    background-color #fff
    font-size 29px

  .swiper-slide
    width 230px
    background-color #fff
    box-shadow -1px 0 0 0 rgba($secondary, .15)

  .frequency-heading
  .frequency-mhz
    padding 0 25px

  .frequency-heading
    height 44px
    background-color $primary
    color #fff
    font-size 20px

  .frequency-mhz
    height 73px
    color $secondary
    font-weight bold
    font-size 21px

  .frequencies-button
    position absolute
    top 0
    z-index 10
    display flex
    justify-content center
    align-items center
    size 44px
    border 1px solid rgba($secondary, .15)
    border-bottom none
    background-color #fff
    color $secondary
    font-size 20px
    cursor pointer
    transition .25s color

    &.swiper-button-disabled
      color rgba($secondary, .4)
      cursor not-allowed

  .frequencies-button\\:prev
    @extends .frequencies-button

    left 0

  .frequencies-button\\:next
    @extends .frequencies-button

    left 44px
</style>
