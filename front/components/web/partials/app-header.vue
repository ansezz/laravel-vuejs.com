<template>
    <section class="app-header">
        <div class="container">
            <div class="app-header-flexed">
                <app-articles-swiper />
                <app-sign-up-form />
            </div>
        </div>
    </section>
</template>

<script>
    import AppArticlesSwiper from "@/components/web/partials/app-articles-swiper"
    import AppSignUpForm from "@/components/web/partials/app-sign-up-form"
    export default {
        name: 'AppHeader',
        components: {
            AppArticlesSwiper,
            AppSignUpForm
        },
        data() {
            return {
                
            }
        }
    }

</script>

<style lang="stylus" scoped>
    .app-header
        background-color $tertiary
        padding 60px 0
        .app-header-flexed
            display flex
            justify-content space-between
</style>
