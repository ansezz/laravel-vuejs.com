<template>
  <section class="news-letter-container">
    <breadcrumb :pages="breadcrumbsData" />
    <app-hire-us />
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
            AppHireUs : () => import('@/components/web/partials/app-hire-us'),
            AppFeatured: () => import('@/components/web/partials/app-featured'),
        },
        data() {
            return {
                breadcrumbsData : [
                    { name: 'Home', link: "/" },
                    { name: 'newseletter', link: "/page/hire-us" }
                ]
            }
        }
    }
</script>

<style lang="stylus" scoped>
    .news-letter-container
        .featured-articles
            padding 0 0 120px
</style>
