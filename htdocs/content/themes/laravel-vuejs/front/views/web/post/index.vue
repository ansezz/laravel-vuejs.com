<template lang="html">
  <article v-if="article" class="article">
    <container>
      <breadcrumb :items="breadcrumbItems"/>

      <ul class="article-information is-relative is-flex has-align:center has-justify:between has-width:fluid">
        <li class="article-author">
          <nuxt-link :to="'/'" class="is-flex has-align:center">
            <div class="article-author:avatar embed:square">
              <img :src="article.author.avatar"/>
            </div>
            <span class="article-author:name" v-html="article.author.name"/>
          </nuxt-link>
        </li>
        <li class="article-category is-absolute:center is-flex has-align:center">
          <i class="article-information:icon ion-ios-folder"/>
          <nuxt-link :to="'/'" v-html="article['main-category']"/>
        </li>
        <li class="article-publish is-flex has-align:center">
          <i class="article-information:icon ion-ios-time"/>
          <time :datetime="article.created" v-html="$moment(article.created).fromNow()"/>
        </li>
      </ul>

    </container>
      
    <container small>
      <h1 class="article-title has-width:fluid" v-html="article.title"/>
    </container>

    <container class="is-relative" small>

      <thumbnail class="article-image" :src="article.image" :alt="article.title"/>

      <div class="article-sticky:left is-absolute has-height:fluid">
        <social-sharing :url="'/'"
                        :title="article.title"
                        :description="article.excerpt"
                        :quote="article.excerpt"
                        hashtags="laravel,vuejs"
                        twitter-user="LaravelVueJs"
                        network-tag="li"
                        inline-template>
          <ul class="article-share is-sticky:top is-flex has-align:center">
            <network class="facebook" network="facebook">
              <i class="ion-logo-facebook"/> Facebook
            </network>
            <network class="twitter" network="twitter">
              <i class="ion-logo-twitter"/> Twitter
            </network>
            <network class="linkedin" network="linkedin">
              <i class="ion-logo-linkedin"/> LinkedIn
            </network>
          </ul>
        </social-sharing>
      </div>

      <div class="article-sticky:right is-absolute has-height:fluid">
        <ul class="article-actions is-sticky:top">
          <li>test</li>
        </ul>
      </div>

      <div class="article-content" v-html="article.content" />

    </container>
  </article>
</template>

<script>
export default {
  components: {},
  name: "post",
  computed: {
    article() {
      return this.$store.state.post.single
    },
    breadcrumbItems() {
      return [
        {
          title: "Home",
          href: "/"
        },
        {
          title: this.article["main-category"],
          href: "/"
        },
        {
          title: this.article.title,
          href: this.article.slug,
          isActive: true
        }
      ]
    }
  }
}
</script>

<style lang="stylus" scoped>
  .article-information
    margin 20px 0 40px

  .article-information\\:icon
    margin-right 10px
    color $secondary
    font-size 16px

  .article-category
    color $secondary
    text-transform uppercase
    letter-spacing 2px
    font-weight 600
    font-size 12px

  .article-publish
    color rgba(#616D82, .8)
    font-size 14px

  .article-author\\:avatar
    margin-right 10px
    size 40px
    background-color rgba($tertiary, .05)
    radius 50%

    img
      object-fit cover

  .article-author\\:name
    color $tertiary
    font-weight bold
    font-size 14px

  .article-title
    margin-bottom 40px
    color $tertiary
    text-align center
    font-size 28px

  .article-sticky\\:left
  .article-sticky\\:right
    top 0
    width 40px

    .is-sticky\\:top
      top 100px
      width 100%

  .article-sticky\\:left
    left -70px

  .article-sticky\\:right
    right -70px

  .article-share
    writing-mode vertical-rl
    text-orientation mixed

    & >>> li
      margin-bottom 40px
      color $secondary
      text-transform uppercase
      letter-spacing 2px
      font-weight 600
      font-size 12px
      cursor pointer

      i
        font-size 20px

      &.facebook i
        color $facebook

      &.twitter i
        color $twitter

      &.linkedin i
        color $linkedin

  .article-image
    margin-bottom 40px

  .article-content
    color #616D82
    // font-weight 300
    font-size 18px
    line-height 28px

    & >>> p
      margin 0 0 18px
</style>
