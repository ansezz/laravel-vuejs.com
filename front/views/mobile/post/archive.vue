<template>
    <section class="posts-container">
        <breadcrumb :pages="breadcrumbsData"/>
        <div class="container">
            <div class="post-heading-filters">
                <div class="post-heading">
                    <div class="user-avatar">
                        <img src="@/assets/images/icons-category.svg" alt="LV">
                    </div>
                    <h1>Posts</h1>
                </div>
                <filters :filter.sync="filter" :action.sync="filterChange"></filters>
            </div>
            <div class="article-grid">
                <template v-for="(item, key) in posts.data">
                    <article-item :title="item.title"
                                  :image="item.image_url"
                                  :description="item.excerpt"
                                  :key="key"
                                  :to="{ name: 'slug', params: { slug: item.slug }}"
                    />
                </template>
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
        components: {
            filters: () => import('@/components/shared/partials/elements/filters'),
            Breadcrumb: () => import('@/components/shared/partials/elements/breadcrumb'),
            ArticleItem: () => import('@/components/shared/partials/elements/article-item'),
            InfiniteLoading
        },
        name: "posts",
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
        computed: {
            hasMorePages() {
                return this.posts.paginatorInfo && this.posts.paginatorInfo.hasMorePages;
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
        mounted() {
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
                breadcrumbsData: [
                    {
                        name: 'Home',
                        link: "/"
                    },
                    {
                        name: 'Posts',
                        link: "/posts"
                    }
                ]
            }
        }
    }

</script>

<style lang="stylus" scoped>
    .posts-container
        padding-bottom 120px

    .post-heading-filters
        position relative
        height 60px
        overflow hidden
        display flex
        align-items flex-end
        justify-content flex-end
        margin 60px 0 40px

    .post-heading
        position absolute
        left 50%
        transform translateX(-50%)
        text-align center

        h1
            font-size 28px
            font-weight 600
            color $tertiary
            margin-top 10px
            line-height 1

    .article-grid
        display grid
        grid-template-columns repeat(4, 1fr)
        grid-gap 40px 10px

    .ads
        width 900px
        height 250px
        display flex
        align-items center
        justify-content center
        background-color transparent
        font-size 24px
        color $white
        margin 60px auto

    .adsbygoogle
        margin 15px 0

</style>
