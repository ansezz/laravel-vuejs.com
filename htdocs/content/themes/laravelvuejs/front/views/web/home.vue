<!--laravelvuejs_Home1.5.jpg-->
<template>
  <section class="section-home has-background:gray">

    <swiper-hero/>

    <swiper-tabs/>

    <podcasts-special/>

    <podcasts-popular/>

    <swiper-section/>

    <swiper-calendar/>

  </section>
</template>

<script>
  import SwiperHero from '@/components/web/swiper-hero'
  import SwiperTabs from '@/components/web/swiper-tabs'
  import PodcastsSpecial from '@/components/web/podcasts-special'
  import PodcastsPopular from '@/components/web/podcasts-popular'
  import SwiperSection from '@/components/web/swiper-section'
  import SwiperCalendar from '@/components/web/swiper-calendar'

  export default {
    name: 'home',
    components: {
      SwiperHero,
      SwiperTabs,
      PodcastsSpecial,
      PodcastsPopular,
      SwiperSection,
      SwiperCalendar
    }
  }
</script>

<style lang="stylus" scoped>
</style>
