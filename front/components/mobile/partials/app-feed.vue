<template>
  <section class="feed">
    <div class="mobile-container">
      <heading>Latest Posts</heading>
      <div class="articles-list">
        <article-item v-for="item in posts"
                      :title="item.title"
                      :image="item.image_url"
                      :description="item.excerpt"
                      :key="item.id"
                      :to="{ name: 'slug', params: { slug: item.slug }}"
        />
      </div>
    </div>
  </section>
</template>

<script>
  export default {
    name: 'AppFeed',
    components: {
    },
    data() {
      return {}
    },
    methods: {
      changePage(page) {
        this.$router.push({name: 'posts', query: {page: page}})
      },
    },
    computed: {
      posts() {
        return this.$store.state.post.posts.data
      },
    }
  }
</script>

<style lang="stylus" scoped>
  .feed
    margin-bottom 30px
  .articles-list
    display grid
    grid-template-columns repeat(1, 1fr)
    grid-gap 20px
    margin-top 30px
</style>
