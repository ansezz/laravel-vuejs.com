<!--waiting designer-->
<template>
  <section class="posts-container">
    <breadcrumb :pages="breadcrumbsData"/>
    <div class="mobile-container">
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
        <template v-for="(item) in posts">
          <article-item :title="item.title"
                        :image="item.image_url"
                        :description="item.excerpt"
                        :key="item.id"
                        :to="{ name: 'slug', params: { slug: item.slug }}"
          />
        </template>
      </div>
      <adsbygoogle/>
      <Pagination :data="paginator" @pagination-change-page="changePage"/>
      <div class="ads has-m">300x250</div>
    </div>
  </section>
</template>

<script>
  export default {
    components: {
      filters: () => import('@/components/shared/partials/elements/filters'),
      Breadcrumb: () => import('@/components/shared/partials/elements/breadcrumb'),
      ArticleItem: () => import('@/components/shared/partials/elements/article-item'),
      Pagination: () => import('@/components/shared/partials/elements/pagination/index')
    },
    name: "posts",
    computed: {
      posts() {
        return this.$store.state.post.posts.data
      },
      paginator() {
        return this.$store.state.post.posts.paginatorInfo
      }
    },
    methods: {
      changePage(page) {
        this.$router.push({name: 'posts', query: {count: this.filter.count, sort_by: this.filter.sort_by, page: page}})
      },
      filterChange() {
        this.$router.push({name: 'posts', query: {count: this.filter.count, sort_by: this.filter.sort_by}})
      }
    },
    mounted() {
    },
    data() {
      return {
        filter: {
          sort_by: 'latest',
          count: 8,
        },
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
  .posts-container
    padding-bottom 60px

  .post-heading-filters
    margin 20px 0 15px

    .post-heading
      text-align center
      margin-bottom 20px

      h1
        font-size 28px
        font-weight 600
        color $tertiary
        margin-top 10px
        line-height 1
    .filters
      flex-direction column
      &/deep/
        .filter-group
          margin-right 0
          width 100%
          display flex
          align-items center
          justify-content space-between
          height 40px
          &:after
            padding-left 0
          select
            width 100%

  .article-grid
    display grid
    grid-template-columns repeat(1, 1fr)
    grid-gap 20px 10px

  .ads
    width 300px
    height 250px
    display flex
    align-items center
    justify-content center
    background-color #3abbff
    font-size 24px
    color $white
    margin 40px auto
</style>
