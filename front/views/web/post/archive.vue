<template>
    <section class="posts-container">
        <breadcrumb :pages="breadcrumbsData"/>
        <div class="container">
            <div class="post-heading-filters">
                <div class="post-heading">
                    <div class="user-avatar">
                      <i class="fa fa-folder-o"></i>
                    </div>
                    <h1>Posts</h1>
                </div>
                <filters route-name="posts"></filters>
            </div>
          <adsbygoogle class="adsbygoogle" :pageLevelAds="true" />
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
            <adsbygoogle class="adsbygoogle" :pageLevelAds="true" />
            <div class="text-center">
                <button @click="showMore()"
                        v-if="hasMorePages && !show_more" class="button">
                    {{ $apollo.queries.posts.loading ? 'Loading ...' : 'Show more'}}
                </button>
            </div>

            <no-ssr>
                <infinite-loading @infinite="showMore"
                                  v-if="show_more" class="show-more"></infinite-loading>
            </no-ssr>
        </div>
    </section>
</template>

<script>
    import postsQql from '@/graphql/queries/post/all.graphql';

    export default {
        components: {
            filters: () => import('@/components/shared/partials/elements/filters'),
            Breadcrumb: () => import('@/components/shared/partials/elements/breadcrumb'),
            ArticleItem: () => import('@/components/shared/partials/elements/article-item')
        },
        name: "posts",
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

                this.page++;

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
        mounted() {
        },
        data() {
            return {
                posts: {},
                show_more: false,
                page: 1,
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
    .text-center,
    .show-more
      padding-top 40px

    .posts-container
        padding-bottom 120px

    .post-heading-filters
        position relative
        overflow hidden
        display flex
        align-items center
        justify-content space-between
        margin 60px 0 40px

    .post-heading
        text-align center
        display flex
        align-items center

        h1
            font-size 28px
            font-weight 600
            color $tertiary
            line-height 1
            margin-left 10px
        .fa
          font-size 20px
          color $secondary
          margin-top 5px

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
