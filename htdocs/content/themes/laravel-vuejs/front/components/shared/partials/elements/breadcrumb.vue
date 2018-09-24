<template>
  <nav class="breadcrumb has-width:fluid">
    <ul class="breadcrumb-list is-flex has-align:center has-justify:center">
      <li v-for="(item, index) in items" :key="index" class="breadcrumb-item" :class="{ 'is-active' : item.isActive }">
        <nuxt-link class="breadcrumb-anchor" :to="item.href" v-html="item.title"/>
      </li>
    </ul>
  </nav>
</template>

<script>
export default {
  name: "breadcrumb",
  props: {
    items: {
      type: Array,
      default: () => []
    }
  }
}
</script>

<style lang="stylus" scoped>
  .breadcrumb
    margin 20px 0

  .breadcrumb-item
    &:not(:last-child):after
      display inline-flex
      justify-content center
      align-items center
      margin 0 6px
      padding-left 2px
      size 20px
      background-color $primary
      color $secondary
      content '\f3d1'
      font-size 12px
      font-family 'Ionicons'
      radius 50%

    &.is-active .breadcrumb-anchor
      font-weight bold

  .breadcrumb-anchor
    color $secondary
    font-size 12px
    opacity .8
</style>
