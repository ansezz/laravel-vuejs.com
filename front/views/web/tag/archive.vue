<!--waiting designer-->
<template>
  <section class="posts-container">
    <breadcrumb :pages="breadcrumbsData()"/>
    <div class="container">
      <div class="post-heading-filters">
        <div class="post-heading">
          <div class="user-avatar">
            <i class="fa fa-folder-o"></i>
          </div>
          <h1 v-if="tag">{{tag.name}}</h1>
        </div>
        <filters route-name="tag-slug"></filters>
      </div>
      <div class="article-grid">
        <article-item v-for="item in postsByTag.data"
                      :title="item.title"
                      :image="item.image_url"
                      :description="item.excerpt"
                      :key="item.id"
                      :to="{ name: 'slug', params: { slug: item.slug }}"
        />
      </div>

      <div class="text-center">
        <button @click="showMore()" class="button"
                v-if="hasMorePages && !show_more">
          {{ $apollo.queries.postsByTag.loading ? 'Loading ...' : 'Show more'}}
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
  import postsQql from '@/graphql/queries/tag/posts.graphql';

  export default {
    components: {
      filters: () => import('@/components/shared/partials/elements/filters'),
      Breadcrumb: () => import('@/components/shared/partials/elements/breadcrumb'),
      ArticleItem: () => import('@/components/shared/partials/elements/article-item')
    },
    name: "tag-posts",
    apollo: {
      postsByTag: {
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
      tag() {
        return this.$store.state.tag.tag
      },
      hasMorePages() {
        return this.postsByTag && this.postsByTag.paginatorInfo && this.postsByTag.paginatorInfo.hasMorePages;
      }
    },
    methods: {
      showMore($state) {
        if (!this.hasMorePages || this.$apollo.queries.postsByTag.loading) {
          return true
        }

        this.page++

        this.$apollo.queries.postsByTag.fetchMore({
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
              if (fetchMoreResult.postsByTag.paginatorInfo.hasMorePages)
                $state.loaded();
              else
                $state.complete();
            }

            this.show_more = true;
            fetchMoreResult.postsByTag.data = [...previousResult.postsByTag.data, ...fetchMoreResult.postsByTag.data];
            return fetchMoreResult;
          },
        })
      }
    },
    data() {
      return {
        postsByTag: {},
        show_more: false,
        page: 1,
        breadcrumbsData: () => [{
          name: 'Home',
          link: "/"
        },
          {
            name: 'Tag'
          },
          {
            name: this.tag.name
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
        align-items center
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
        .fa
          font-size 20px
          color $secondary
          margin-top 5px

    .filters
        display flex
        align-items center

        .filter-group
            position relative
            margin-right 45px

            &:after
                content "\f0d7"
                font-family "FontAwesome"
                color $secondary
                padding-left 15px

            &:last-child
                margin-right 0

            select
                font-size 12px
                font-weight 600
                letter-spacing 2px
                color $secondary
                text-transform uppercase
                border 0
                background-color transparent
                outline none
                -webkit-appearance none
                -moz-appearance none
                appearance none

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

    .text-center,
    .show-more
      padding-top 40px
</style>
