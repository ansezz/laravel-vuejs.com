<template>
  <nuxt-link class="article-image is-relative is-clipped embed:wide" v-lazy-container="{ selector: 'img' }" :to="href">
    <!-- <img v-if="src" class="is-absolute:all" :data-src="src" :alt="alt"> -->
    <img class="is-absolute:all" :data-src="src" :alt="alt">

    <span class="article-loader">
      <span/>
    </span>
    <span class="article-fallback">error</span>
  </nuxt-link>
</template>

<script>
export default {
  name: "AppThumbnail",
  props: {
    src: {
      type: String,
      default: null
    },
    href: {
      type: String,
      default: null
    },
    alt: {
      type: String,
      default: null
    }
  }
}
</script>

<style lang="stylus" scoped>
  .article-image
    display flex
    justify-content center
    align-items center
    background-color rgba($tertiary, .05)
    background-size 50%

    img
      opacity 0
      transition .25s opacity
      object-fit cover

    img[lazy=error]
      opacity 0

      ~ .article-loader
        opacity 0

      ~ .article-fallback
        opacity 1

    img[lazy=loading]
      opacity 0

      ~ .article-loader
        opacity 1

    img[lazy=loaded]
      opacity 1

      ~ .article-loader
        opacity 0

  .article-loader
  .article-fallback
    display flex
    justify-content center
    align-items center
    opacity 0

  .article-loader span
    position relative
    animation loading 1.5s infinite cubic-bezier(.15, .6, .9, .1)

    &
    &::before
    &::after
      size 10px
      background-color rgba($tertiary, .25)
      radius 50%

    &::before
    &::after
      position absolute
      top 0
      display inline-block
      content ''

    &::before
      left -16px
      animation loadingBefore 1.5s infinite ease-in-out

    &::after
      left -32px
      animation loadingAfter 1.5s infinite cubic-bezier(.4, 0, 1, 1)

  @keyframes loading
    0%
      left calc(-50% - 5px)

    75%
      left calc(50% + 105px)

    100%
      left calc(50% + 105px)

  @keyframes loadingBefore
    0%
      left -50px

    50%
      left -16px

    75%
      left -50px

    100%
      left -50px

  @keyframes loadingAfter
    0%
      left -100px

    50%
      left -32px

    75%
      left -100px

    100%
      left -100px
</style>
