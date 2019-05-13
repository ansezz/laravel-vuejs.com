<template>
  <nuxt-link :to="to" class="article-image" v-lazy-container="{ selector: 'img' }">
    <img v-if="src" :data-src="src" :alt="alt">
    <span class="post-loader">
      <span class="sk-cube1 sk-cube"></span>
      <span class="sk-cube2 sk-cube"></span>
      <span class="sk-cube4 sk-cube"></span>
      <span class="sk-cube3 sk-cube"></span>
    </span>
    <span class="post-error"></span>
  </nuxt-link>
</template>

<script>
  export default {
    name: "Thumbnail",
    props: {
      to: [String, Object],
      paramValue: {
        type: String,
        default: null
      },
      src: {
        type: String,
        default: null
      },
      alt: {
        type: String,
        default: null
      }
    }
  };
</script>

<style lang="stylus" scoped>
  .post-loader
    position absolute
    width 30px
    height 30px
    transition opacity .25s ease-in-out
    transform rotateZ(45deg)

    .sk-cube
      position relative
      float left
      width 50%
      height 50%
      transform scale(1.1)

      &:before
        position absolute
        top 0
        left 0
        width 100%
        height 100%
        background-color rgba(56, 68, 87, .5)
        content ''
        transform-origin 100% 100%
        animation sk-foldCubeAngle 2.4s infinite linear both

      &.sk-cube2
        transform scale(1.1) rotateZ(90deg)

        &:before
          animation-delay .3s

      &.sk-cube3
        transform scale(1.1) rotateZ(180deg)

        &:before
          animation-delay .6s

      &.sk-cube4
        transform scale(1.1) rotateZ(270deg)

        &:before
          animation-delay .9s

  @keyframes sk-foldCubeAngle
    0%
    10%
      opacity 0
      transform perspective(140px) rotateX(-180deg)
      -webkit-transform perspective(140px) rotateX(-180deg)

    25%
    75%
      opacity 1
      transform perspective(140px) rotateX(0)
      -webkit-transform perspective(140px) rotateX(0)

    90%
    100%
      opacity 0
      transform perspective(140px) rotateY(180deg)
      -webkit-transform perspective(140px) rotateY(180deg)

  .post-error
    position absolute
    color #FFF
    font-size 14px
    opacity 0
    transition opacity .25s ease-in-out

    &:before
      display block
      margin auto
      width 40px
      height 40px
      background-image url('../../../../assets/images/broken-pic.png')
      background-size contain
      content ''

  .article-image
    position relative
    display flex
    justify-content center
    align-items center
    overflow hidden
    padding 0
    width 100%
    height 136px
    background-color rgba($tertiary, .05)
    background-size 50%

    img
      position absolute
      top 0
      bottom 0
      left 0
      width 100%
      height 100%
      opacity 0
      transition opacity .25s ease-in-out, transform .5s ease-in-out
      object-fit cover

      &[lazy=error]
        opacity 0

        ~.post-loader
          opacity 0

        ~.post-error
          opacity 1

      &[lazy=loading]
        opacity 0

        ~.post-loader
          opacity 1

      &[lazy=loaded]
        opacity 1

        ~.post-loader
          opacity 0

    &.small
      img
        &[lazy=error]
          ~.post-error
            font-size 10px

            &:before
              width 25px
              height 25px
</style>
