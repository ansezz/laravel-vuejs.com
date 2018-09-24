<template>
  <article class="article" :class="{ 'is-horizontal' : horizontal }">
    <header>
      <thumbnail :src="image" :href="href" :alt="title"/>
    </header>
    <main class="article-main">
      <h1 class="article-title" v-html="title"/>
      <p v-if="description" class="article-description" v-html="description"/>
    </main>
    <footer>

    </footer>
  </article>
</template>

<script>
export default {
  name: "ArticleItem",
  props: {
    horizontal: {
      type: Boolean,
      default: false
    },
    title: {
      type: String,
      default: null
    },
    description: {
      type: String,
      default: null
    },
    href: {
      type: String,
      default: null
    },
    image: {
      type: String,
      default: null
    }
  }
}
</script>

<style lang="stylus" scoped>
  .article-main
    padding 12px

  .article-title
    color $tertiary
    font-size 20px

  .article-description
    color rgba($tertiary, .6)
    font-size 18px
    line-height 28px
</style>
