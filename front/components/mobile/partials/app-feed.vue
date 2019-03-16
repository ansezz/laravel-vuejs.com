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

            <div class="adsbygoogle">
                <adsbygoogle/>
            </div>

            <button @click="showMore()"
                    v-if="hasMorePages && !show_more">
                {{ $apollo.queries.posts.loading ? 'Loading ...' : 'Show more'}}
            </button>

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
    import InfiniteLoading from 'vue-infinite-loading';

    export default {
        name: 'AppFeed',
        components: {
            InfiniteLoading
        },
        apollo: {
            posts: {
                query: postsQql,
                variables() {
                    // Initial variables
                    return {
                        count: 12,
                        page: 1,
                        sort_by: 'latest'
                    }
                }
            },
        },
        data() {
            return {
                posts: {},
                show_more: false,
                filter: {
                    page: 1,
                    sort_by: 'latest',
                    count: 12,
                },
            }
        },
        methods: {
            showMore($state) {
                if (!this.hasMorePages || this.$apollo.queries.posts.loading) {
                    return true
                }

                this.filter.page++

                this.$apollo.queries.posts.fetchMore({
                    // New variables
                    variables: {
                        count: this.filter.count,
                        page: this.filter.page,
                        sort_by: this.filter.sort_by
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
            filterChange() {
                this.$router.push({
                    name: 'posts',
                    query: {count: this.filter.count, sort_by: this.filter.sort_by, page: 1}
                })
            }
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
</style>
