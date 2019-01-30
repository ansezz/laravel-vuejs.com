<!--waiting designer-->
<template>
  <section class="posts-container">
    <breadcrumb :pages="breadcrumbsData"/>
    <div class="container">
      <div class="post-heading-filters">
        <div class="post-heading">
          <div class="user-avatar">
            <img src="@/assets/images/icons-category.svg" alt="LV">
          </div>
          <h1>Tutorials</h1>
        </div>
        <filters :filter.sync="filter" :action.sync="filterChange"></filters>
      </div>
      <div class="article-grid">
        <article-item v-for="item in posts"
                      :title="item.title"
                      :image="item.image_url"
                      :description="item.excerpt"
                      :key="item.id"
                      :to="{ name: 'slug', params: { slug: item.slug }}"
        />
      </div>
      <Pagination :data="paginator" @pagination-change-page="changePage"/>
      <div class="ads has-m">900x250</div>
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
        breadcrumbsData: [{
          name: 'Home',
          link: "/"
        },
          {
            name: 'Categories',
            link: "/"
          },
          {
            name: 'Tutorials',
            link: "/post/archive"
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
