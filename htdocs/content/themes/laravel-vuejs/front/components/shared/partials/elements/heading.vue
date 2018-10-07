<template>
  <h3 class="heading" :class="{ 'is-vertical' : vertical }">
     <slot/> 
  </h3>
</template>

<script>
  export default {
    name: 'Heading',
    props: {
      vertical: {
        type: Boolean,
        default: false,
      },
    },
  }
</script>

<style lang="stylus" scoped>
  .heading
    margin 30px 0
    color $secondary
    font-weight bold
    font-size 16px

    &::before
    &::after
      margin 0 8px
      font-weight 400
      font-size 20px
      opacity .5

    &::before
      content '{{'

    &::after
      content '}}'
</style>
