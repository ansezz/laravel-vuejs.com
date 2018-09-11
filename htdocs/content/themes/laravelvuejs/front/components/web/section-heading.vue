<template>
  <h3 class="section-heading" :class="{ 'is-white' : white }" v-html="title"></h3>
</template>

<script>
  export default {
    name: 'SectionHeading',

    props: {
      title: String,
      white: Boolean
    }
  }
</script>

<style lang="stylus" scoped>
  .section-heading
    display flex
    flex-direction column
    align-items center
    margin-top 60px
    margin-bottom 10px
    color $secondary
    font-weight bold
    font-size 28px

    &:before
      margin-bottom 15px
      width 29px
      height 5px
      background-color $primary
      content ''

    &.is-white
      color #fff
</style>
