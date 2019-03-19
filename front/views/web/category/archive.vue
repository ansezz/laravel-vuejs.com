<!--waiting designer-->
<template>
    <section class="posts-container">
        <breadcrumb :pages="breadcrumbsData()"/>
        <div class="container">
            <div class="post-heading-filters">
                <div class="post-heading">
                    <div class="user-avatar">
                        <img src="@/assets/images/icons-category.svg" alt="LV">
                    </div>
                    <h1 v-if="category">{{category.name}}</h1>
                </div>
                <filters route-name="category-slug"></filters>
            </div>
            <div class="article-grid">
                <article-item v-for="item in postsByCategory.data"
                              :title="item.title"
                              :image="item.image_url"
                              :description="item.excerpt"
                              :key="item.id"
                              :to="{ name: 'slug', params: { slug: item.slug }}"
                />
            </div>

            <button @click="showMore()"
                    v-if="hasMorePages && !show_more">
                {{ $apollo.queries.postsByCategory.loading ? 'Loading ...' : 'Show more'}}
            </button>

            <no-ssr>
                <infinite-loading @infinite="showMore"
                                  v-if="show_more"></infinite-loading>
            </no-ssr>
        </div>
    </section>
</template>

<script>

    import postsQql from '@/graphql/queries/category/posts.graphql';
    import InfiniteLoading from 'vue-infinite-loading';

    export default {
        components: {
            filters: () => import('@/components/shared/partials/elements/filters'),
            Breadcrumb: () => import('@/components/shared/partials/elements/breadcrumb'),
            ArticleItem: () => import('@/components/shared/partials/elements/article-item'),
            InfiniteLoading
        },
        name: "category-posts",
        apollo: {
            postsByCategory: {
                query: postsQql,
                variables() {
                    // Initial variables
                    return {
                        count: this.$route.query.count ?? 12,
                        sort_by: this.$route.query.sort_by ?? 'latest',
                        s: this.$route.query.s,
                        slug: this.$route.params.slug
                    }
                }
            },
        },
        computed: {
            category() {
                return this.$store.state.category.category
            },
            hasMorePages() {
                return this.postsByCategory && this.postsByCategory.paginatorInfo && this.postsByCategory.paginatorInfo.hasMorePages;
            }
        },
        methods: {
            showMore($state) {
                if (!this.hasMorePages || this.$apollo.queries.postsByCategory.loading) {
                    return true
                }

                this.page++

                this.$apollo.queries.postsByCategory.fetchMore({
                    // New variables
                    variables: {
                        count: this.$route.query.count ?? 12,
                        sort_by: this.$route.query.sort_by ?? 'latest',
                        s: this.$route.query.s,
                        page: this.page,
                        slug: this.$route.params.slug
                    },
                    // Transform the previous result with new data
                    updateQuery: (previousResult, {fetchMoreResult}) => {
                        if (!fetchMoreResult)
                            return previousResult;

                        if ($state) {
                            if (fetchMoreResult.postsByCategory.paginatorInfo.hasMorePages)
                                $state.loaded();
                            else
                                $state.complete();
                        }

                        this.show_more = true;
                        fetchMoreResult.postsByCategory.data = [...previousResult.postsByCategory.data, ...fetchMoreResult.postsByCategory.data];
                        return fetchMoreResult;
                    },
                })
            }
        },
        data() {
            return {
                postsByCategory: {},
                show_more: false,
                page: 1,
                breadcrumbsData: () => [
                    {
                        name: 'Home',
                        link: "/"
                    },
                    {
                        name: 'Category'
                    },
                    {
                        name: this.category.name
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
        background-color #3abbff
        font-size 24px
        color $white
        margin 60px auto
</style>
