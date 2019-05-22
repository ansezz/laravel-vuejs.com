<template>
    <section class="featured-articles">
        <div class="mobile-container">
            <heading>Featured Posts</heading>
            <div class="posts-grid">
              <article-item v-for="item in featured"
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
    import ArticleItem from "@/components/shared/partials/elements/article-item"
    export default {
        name: 'AppFeatured',
        components: {
            ArticleItem
        },
      computed: {
        featured() {
          return this.$store.state.post.featured.data
        },
      },
        data() {
            return {
            }
        }
    }

</script>

<style lang="stylus" scoped>
    .featured-articles
        position relative
        padding 35px 0

    .posts-grid
        display grid
        grid-template-columns repeat(1, 1fr)
        grid-gap 20px 10px
        margin-top 30px
</style>
