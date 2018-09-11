<template>
  <div class="is-flex:column is-relative has-background:secondary">

    <div class="grid-background is-absolute:bottom has-background:gray has-index:10"></div>

    <section-heading title="شبكة البرامج" white/>

    <div class="container has-width:fluid is-relative has-index:20">
      <ul class="tabs-list is-flex is-relative has-index:10">
        <li class="tab-item is-flex:column has-align:center has-justify:center"
            v-for="(item, index) in ['الإثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت', 'الأحد']"
            :key="index"
            :class="{ 'is-active' : tab == index }"
            @click="tab = index">
          <span>{{ item }}</span>
          <time>11/07</time>
        </li>
      </ul>
      <div class="row"
           v-for="(item, index) in ['الإثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت', 'الأحد']"
           :key="index">
        <swiper-grid v-show="tab == index" :data="articles"/>
      </div>
    </div>

  </div>
</template>

<script>
  import SectionHeading from '@/components/web/section-heading'
  import SwiperGrid from '@/components/web/swiper-grid'

  export default {
    name: 'SwiperCalendar',
    components: {
      SectionHeading,
      SwiperGrid
    },
    data() {
      return {
        tab: 0,
        articles: [
          'بدايات الغزو الإسرائيلي للبنان',
          'إنهيار الإتحاد السوفياتي',
          'التحولات الفكرية والعلمية والفنية :الحركة الإنسية',
          'الاكتشافات الجغرافية وظاهرة الميركنتيلية',
          'الثورات الإجتماعية و السياسية : الثورة الفرنسية',
          'التحولات السريعة و التحولات البطيئة لمجموعة كيميائية',
          'التتبع الزمني لتحول - سرعة التفاعل',
          'حالة توازن مجموعة كيميائية'
        ]
      }
    },
    mounted() {
    }
  }
</script>

<style lang="stylus" scoped>
  .grid-background
    height 250px

  .container
    padding 0 35px

  .tabs-list
    display grid
    margin-top 60px
    margin-left 125px
    width 100%
    grid-template-columns repeat(7, 1fr)
    grid-gap 2px

  .tab-item
    height 70px
    color rgba(#fff, .4)
    font-size 16px
    cursor pointer

    span
      margin-top 8px
      margin-bottom 3px

    time
      font-weight bold
      font-size 14px

    &.is-active
      background-color #fff
      color $secondary
      radius-top 2px
</style>
