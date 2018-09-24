<template>
  <section class="feed">

    <div class="articles-list">
      <article-item v-for="(article, index) in articles"
                    :key="index"
                    :index="index"
                    :title="article.title"
                    :description="article.excerpt"
                    :image="article.image"
                    :href="article.slug"/>
    </div>

    <div v-if="infinite">load more</div>

    <div v-else>pagination</div>

  </section>
</template>

<script>
export default {
  name: "AppFeed",

  props: {
    articles: {
      type: Array,
      required: true
    },
    infinite: {
      type: Boolean,
      default: false
    }
  },

  data() {
    return {}
  },
  mounted() {}
}
</script>

<style lang="stylus" scoped>
  .articles-list
    display grid
    grid-template-columns repeat(2, 1fr)
    grid-gap 20px

    .article:nth-child(1)
      width calc(100% + 97px)
      grid-row span 2

    .article:nth-child(2)
    .article:nth-child(3)
      margin-left auto
      width calc(100% - 97px)

      & >>> .article-title
        font-size 16px
</style>
