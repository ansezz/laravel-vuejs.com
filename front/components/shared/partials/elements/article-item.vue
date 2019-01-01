<template>
    <article class="post" :class="{ 'is-horizontal' : horizontal }">
        <header>
            <thumbnail :src="image" :alt="title"/>
        </header>
        <main class="article-main">
            <h3 class="article-title" v-html="title"/>
            <p v-if="description" class="article-description" v-html="description"/>
        </main>
    </article>
</template>

<script>
export default {
  name: "ArticleItem",
  props: {
    horizontal: {
        type: Boolean,
        default: false
    },
    title: {
        type: String,
        default: null
    },
    description: {
        type: String,
        default: null
    },
    href: {
        type: String,
        default: null
    },
    image: {
        type: String,
        default: null
    },
    thumb: {
        type: Boolean,
        default: null
    }  
  }
}
</script>

<style lang="stylus" scoped>
    .post
        position relative
        .article-main
            padding 10px 10px 0
            .article-title
                color $tertiary
                font-size 20px
                line-height 1.4
            .article-description
                color rgba($tertiary, .6)
                font-size 18px
                line-height 1.56
                margin-top 10px
                margin-bottom 0
        &.is-horizontal
            display flex
            align-items center
            margin-bottom 10px
            &:last-child
                margin-bottom 0
            header
                width 150px
            >>> .article-image
                height 81px
            .article-main
                padding 0 0 0 10px
                width 140px
                .article-title
                    font-size 14px
                    font-weight 500
</style>
