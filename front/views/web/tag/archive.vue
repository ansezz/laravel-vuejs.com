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
          <h1 v-if="tag">{{tag.name}}</h1>
        </div>
        <div class="filters">
          <div class="filter-group">
            <select name="showen-posts">
              <option value="1">show 16 posts</option>
              <option value="1">show 16 posts</option>
              <option value="1">show 16 posts</option>
            </select>
          </div>
          <div class="filter-group">
            <select name="most-popular">
              <option value="2">Most popular first</option>
              <option value="2">Most popular first</option>
              <option value="2">Most popular first</option>
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
        />
      </div>
      <div class="ads has-m">900x250</div>
      <div class="article-grid">
        <article-item v-for="item in posts"
                      :title="item.title"
                      :image="item.image_url"
                      :description="item.excerpt"
                      :key="item.id"
        />
      </div>
      <pagination/>
    </div>
  </section>
</template>

<script>
  export default {
    components: {
      Breadcrumb: () => import('@/components/shared/partials/elements/breadcrumb'),
      ArticleItem: () => import('@/components/shared/partials/elements/article-item'),
      Pagination: () => import('@/components/shared/partials/elements/pagination')
    },
    name: "tag-posts",
    computed: {
      posts() {
        return this.$store.state.tag.posts.data
      },
      tag() {
        return this.$store.state.tag.tag
      }
    },
    data() {
      return {
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
