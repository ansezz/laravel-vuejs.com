<template>
  <div class="row has-width:fluid">
    <slot/>
  </div>
</template>

<script>
export default {
  name: "AppRow"
}
</script>

<style lang="stylus" scoped>
  @lost flexbox flex
  .row
    lost-center 100% 0
</style>
