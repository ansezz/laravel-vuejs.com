<template>
    <div>
        <heading>Popular Posts</heading>
        <div class="widget">
            <article-item horizontal title="New Blade Directives Coming to Laravel 5.6" to="/"/>
            <article-item horizontal title="Laravel 5.6 adds the Collision Package for CLI Error Reporting" to="/" />
            <article-item horizontal title="Laravel Manchester Meetup" to="/" />
        </div>
    </div>
</template>

<script>
    import ArticleItem from "@/components/shared/partials/elements/article-item"
    export default {
        name: 'AppPopularPosts',
        components: {
            ArticleItem
        }
    }
</script>

<style lang="stylus" scoped>
    .heading
        margin-bottom 30px
    .widget
        margin-bottom 63px
        &.last-widget
            margin-bottom 0
</style>
