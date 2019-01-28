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
        <div class="filters">
          <div class="filter-group">
            <select name="showen-posts" aria-label="count" v-model="count" @change="filterChange">
              <option value="8">show 8 posts</option>
              <option value="16">show 16 posts</option>
              <option value="32">show 32 posts</option>
            </select>
          </div>
          <div class="filter-group">
            <select name="most-popular" aria-label="Sort by" @change="filterChange" v-model="sort_by">
              <option value="latest">Latest first</option>
              <option value="oldest">Oldest first</option>
              <option value="popular">Popular first</option>
            </select>
          </div>
        </div>
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
        console.log(page)
        this.$router.push({name: 'posts', query: {count: this.count, sort_by: this.sort_by, page: page}})
      },
      filterChange() {
        this.$router.push({name: 'posts', query: {count: this.count, sort_by: this.sort_by}})
      }
    },
    mounted() {
      this.count = this.$route.query.count ?? 8
      this.page = this.$route.query.page ?? 1
      this.sort_by = this.$route.query.sort_by ?? 'latest'
    },
    data() {
      return {
        sort_by: 'latest',
        count: 8,
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
</style>
