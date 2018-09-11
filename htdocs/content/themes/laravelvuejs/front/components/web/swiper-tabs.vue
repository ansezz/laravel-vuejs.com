<template>
  <div class="row swiper-tabs">
    <div class="row is-flex has-justify:center">
      <ul class="tabs-list is-flex ">
        <li class="tab-item is-flex has-align:center has-justify:center"
            v-for="(item, index) in ['النشرات الإخبارية', 'الإذاعة أقوى اللحظات']"
            v-html="item"
            :key="index"
            :class="{ 'is-active' : tab == index }"
            @click="tab = index">
        </li>
      </ul>
    </div>

    <div class="row">
      <swiper-tab v-for="(item, index) in ['النشرات الإخبارية', 'الإذاعة أقوى اللحظات']" v-show="tab == index"
                  :key="index" :data="articles"/>
    </div>
  </div>
</template>

<script>
  import SwiperTab from '@/components/web/swiper-tab'

  export default {
    name: 'SwiperTabs',
    components: {
      SwiperTab
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
  .swiper-tabs
    margin-top 55px

  .tab-item
    width 245px
    height 55px
    background-color #fff
    color $gray
    color rgba(#cacaca, .8)
    font-weight bold
    font-size 18px
    cursor pointer

    &:not(:last-child)
      margin-right 5px

    &.is-active
      background-color $primary
      color #fff
</style>
