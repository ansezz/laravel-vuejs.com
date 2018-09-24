<template>
  <form class="form">
    <header class="form-header">
      <slot name="header"/>
    </header>
    <main class="form-controls">
      <slot/>
    </main>
    <footer class="form-actions">
      <slot name="actions"/>
    </footer>
  </form>
</template>

<script>
export default {
  name: "AppForm",
  props: {}
}
</script>

<style lang="stylus" scoped>
  .form-controls
    display grid
    grid-gap 15px
    grid-template-columns repeat(2, 1fr)

  .form-actions
    display flex
    justify-content space-between
    align-items center
    margin-top 15px

    &:empty
      display none

  .form-header
    margin-bottom 20px

    &:empty
      display none
</style>
