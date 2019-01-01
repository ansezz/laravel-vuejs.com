<template>
  <section class="news-letter-container">
    <breadcrumb />
    <app-newsletter />
    <div class="container">
        <app-featured />
    </div>
  </section>
</template>

<script>
    export default {
        name: "NewsLetter",
        components: {
            Breadcrumb: () => import('@/components/shared/partials/elements/breadcrumb'),
            AppNewsletter : () => import('@/components/web/partials/app-newsletter'),
            AppFeatured: () => import('@/components/web/partials/app-featured'),
        }
    }
</script>

<style lang="stylus" scoped>
    .news-letter-container
        .featured-articles
            padding 0 0 120px
</style>
