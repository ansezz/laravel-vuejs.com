<template>
  <ul class="navbar-list is-flex has-align:center has-height:fluid">
    <nuxt-link v-for="(name, index) in ['اتصل بنا', 'الترددات', 'الجدولة']" tag="li" :to="name" :key="index">
      <a>{{ name }}</a>
    </nuxt-link>
  </ul>
</template>

<script>
  export default {
    name: 'NavbarList'
  }
</script>

<style lang="stylus" scoped>
  .navbar-list
    margin-right auto
    padding-left 15px
    li
      margin 0 15px

    a
      color $secondary
      font-size 14px
</style>
