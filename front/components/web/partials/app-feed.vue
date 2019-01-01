<template>
    <section class="feed">
        <heading>Third Category</heading>
        <div class="articles-list">
            <article-item
                title="Promises, promises: A quick introduction to JavaScript concurrency"
                description="Sign up for our newsletter, and we'll send you news and tutorials on web design, coding, business, and more!" />
            <article-item title="Laravel Query Builder" />
            <article-item title="Laravel 5.6 Dynamic Rate Limiting Provides Per-User Request Throttling" />
            <article-item title="Laravel Relationship Events" />
            <article-item title="Eventy: WordPress-like Actions and Filters for Laravel" />
            <article-item title="Promises, promises: A quick introduction to JavaScript concurrency" />
            <article-item title="How learning to code changed my life" />
            <article-item title="Your First Hackathon: A Survival Guide" />
            <article-item
                title="Student Success: How Treehouse helped George Lambert get out of a cubicle to form his own company" />
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
