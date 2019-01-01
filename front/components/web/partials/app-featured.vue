<template>
    <section class="featured-articles">
        <div class="container">
            <heading>Featured Posts</heading>
            <div class="posts-grid">
                <article-item title="Promises, promises: A quick introduction to JavaScript concurrency" />
                <article-item title="Treehouse is Oregon Tech’s Most Disruptive" />
                <article-item title="In defense of the modern storyboard" />
                <article-item title="New Outer Array Functions Coming to PHP 7.3" />
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
        data() {
            return {
            }
        }
    }

</script>

<style lang="stylus" scoped>
    .featured-articles
        position relative
        padding 60px 0
        &:after
            content ""
            height 1px
            width 1040px
            background-color $gray
            position absolute
            bottom 0
            left 50%
            transform translateX(-50%)
    
    .posts-grid
        display grid
        grid-template-columns repeat(4, 1fr)
        grid-gap 10px
        margin-top 30px
</style>
