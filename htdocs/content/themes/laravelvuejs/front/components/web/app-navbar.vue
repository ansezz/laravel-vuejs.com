<template>
  <nav class="navbar">
    <div class="container">
      <search class="navbar-search"/>
      <navbar-list/>
      <language-list/>
      <ul class="navbar-social">
        <li v-for="item in ['facebook' ,'twitter', 'youtube-play', 'instagram']" :key="item">
          <a href="#" target="_blank">
            <i class="fa" :class="'fa-' + item"></i>
          </a>
        </li>
      </ul>
    </div>
  </nav>
</template>

<script>
  import Search from '@/components/web/partials/search'
  import NavbarList from '@/components/web/navbar/navbar-list'
  import LanguageList from '@/components/web/partials/language-list'

  export default {
    name: 'AppNavbar',
    components: {
      Search,
      NavbarList,
      LanguageList
    }
  }
</script>

<style lang="stylus" scoped>
  .navbar
    background-color #fff

  .container
    height 45px

  .navbar-search
    width 380px
    height 100%

    & >>> .search-input
      padding 0 45px 0 15px
      size 100%
      background-color $gray
      color rgba($secondary, 1)
      font-size 19px

      &::placeholder
        color rgba($secondary, .6)

  .navbar-social
    display flex
    align-items center
    margin-left 20px

    a
      color rgba($secondary, 1)
      font-size 16px
      transition .25s color

      &:hover
        color rgba($secondary, .6)

    & li:not(:last-child)
      margin-right 20px
</style>
