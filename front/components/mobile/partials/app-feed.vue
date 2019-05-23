<template>
    <section class="feed">
        <div class="mobile-container">
            <heading>Latest Posts</heading>
            <div class="articles-list">
                <article-item v-for="item in posts.data"
                              :title="item.title"
                              :image="item.image_url"
                              :description="item.excerpt"
                              :key="item.id"
                              :to="{ name: 'slug', params: { slug: item.slug }}"
                />
            </div>

            <div class="text-center">
                <button @click="showMore()"
                        v-if="hasMorePages && !show_more" class="button">
                    {{ $apollo.queries.posts.loading ? 'Loading ...' : 'Show more'}}
                </button>
            </div>

            <no-ssr>
                <infinite-loading
                        @infinite="showMore"
                        v-if="show_more"></infinite-loading>
            </no-ssr>

        </div>
    </section>
</template>

<script>
    import postsQql from '@/graphql/queries/post/all.graphql';

    export default {
        name: 'AppFeed',
        components: {},
        apollo: {
            posts: {
                query: postsQql,
                variables() {
                    // Initial variables
                    return {
                        count: this.$route.query.count ?? 12,
                        sort_by: this.$route.query.sort_by ?? 'latest',
                        s: this.$route.query.s
                    }
                }
            },
        },
        data() {
            return {
                posts: {},
                show_more: false,
                page: 1
            }
        },
        methods: {
            showMore($state) {
                if (!this.hasMorePages || this.$apollo.queries.posts.loading) {
                    return true
                }

                this.page++

                this.$apollo.queries.posts.fetchMore({
                    // New variables
                    variables: {
                        count: this.$route.query.count ?? 12,
                        sort_by: this.$route.query.sort_by ?? 'latest',
                        s: this.$route.query.s,
                        page: this.page
                    },
                    // Transform the previous result with new data
                    updateQuery: (previousResult, {fetchMoreResult}) => {
                        if (!fetchMoreResult)
                            return previousResult;

                        if ($state) {
                            if (fetchMoreResult.posts.paginatorInfo.hasMorePages)
                                $state.loaded();
                            else
                                $state.complete();
                        }

                        this.show_more = true;
                        fetchMoreResult.posts.data = [...previousResult.posts.data, ...fetchMoreResult.posts.data];
                        return fetchMoreResult;
                    },
                })
            },
        },
        computed: {
            hasMorePages() {
                return this.posts.paginatorInfo && this.posts.paginatorInfo.hasMorePages;
            }
        },
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

    .text-center
        padding-top 20px
</style>
