<template>
    <section class="feed">
        <heading>Third Category</heading>
        <div class="articles-list">
            <article-item v-for="item in posts"
                :title="item.title"
                :image="item.image_url"
                :description="item.excerpt"
                :key="item.id"
                 :to="{ name: 'slug', params: { slug: item.slug }}"
            />
        </div>
        <pagination />
    </section>
</template>

<script>
  export default {
    name: 'AppFeed',
    components: {
        pagination: () => import('@/components/shared/partials/elements/pagination'),
    },
    data() {
      return {}
    },
    computed: {
      posts() {
        return this.$store.state.post.posts.data
      }
    },
    mounted() {},
  }
</script>

<style lang="stylus" scoped>
    .feed
        width calc(100% - 300px)
        padding-right 20px
    .articles-list
        display grid
        grid-template-columns repeat(2, 1fr)
        grid-gap 20px
        margin-top 30px
    .post
        &:nth-child(1)
            width calc(100% + 97px)
            grid-row span 2
            >>>
                .article-image
                    height 240px

        &:nth-child(2)
        &:nth-child(3)
            margin-left auto
            width calc(100% - 97px)
            >>> .article-main
                .article-title
                    font-size 16px
        &:nth-child(n + 4)
            >>> .article-image
                height 188px
</style>
