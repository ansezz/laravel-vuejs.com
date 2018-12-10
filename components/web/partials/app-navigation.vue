<template>
  <div :class="{ 'is-visible' : navigation.visibility }">
    <div class="navigation-overlay is-fixed:all has-index:80" @click="toggleNavigationVisibility"/>
    <nav @click="toggleNavigationVisibility" class="navigation is-fixed:left  has-index:90">
      test
    </nav>
  </div>
</template>

<script>
import { mapActions } from "vuex"

export default {
  name: "AppNavigation",
  computed: {
    navigation() {
      return this.$store.state.navigation
    }
  },
  methods: {
    ...mapActions(["toggleNavigationVisibility"])
  }
}
</script>

<style lang="stylus" scoped>
  .navigation
    width 300px
    background-color #fff
    transition .25s transform
    transform translate3d(-100%, 0, 0)

    .is-visible &
      transform translate3d(0, 0, 0)

  .navigation-overlay
    visibility hidden
    background-color rgba($tertiary, .3)
    opacity 0
    cursor pointer
    transition .25s all

    .is-visible &
      visibility visible
      opacity 1

    &:hover
      background-color rgba($tertiary, .4)
</style>
