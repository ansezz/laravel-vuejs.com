<template>
  <ul class="language-list is-flex has-align:center has-height:fluid">
    <nuxt-link v-for="(language, index) in languages" tag="li" :to="language" :key="index">
      <a>{{ language }}</a>
    </nuxt-link>
  </ul>
</template>
h
<script>
  export default {
    name: 'LanguageList',
    data() {
      return {
        languages: ['العربية', 'Français']
      }
    }
  }
</script>

<style lang="stylus" scoped>
  .language-list
    padding-right 10px
    padding-left @padding-right
    border-right 1px solid rgba($secondary, .1)
    border-left @border-right

    li
      margin 0 15px

    a
      color $secondary
      font-size 13px
</style>
