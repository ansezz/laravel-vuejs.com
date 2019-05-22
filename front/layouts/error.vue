<template>
    <div class="error-page">
        <div class="error-thumb">
            <img src="@/assets/images/404.png" alt="LV">
        </div>
        <div class="error-body">
            <pre>{{error}}</pre>
            <h1 v-if="error.statusCode === 404">Mate, page not found!</h1>
            <h1 v-else>An error occurred</h1>
            <p>You might not have permissions to see this page or isn’t exists anymore.</p>
            <nuxt-link to="/" class="button has-icon">
                <img src="@/assets/images/icons-report.svg" alt="LV">
                <span>report this to our team</span>
            </nuxt-link>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['error'],
        layout: ({store}) => store.state.platform
    }
</script>

<style lang="stylus" scoped>
    .error-page
        padding 120px 0
        @media (max-width 768px)
          padding 60px 20px

        .error-thumb
            text-align center
            margin-bottom 60px
            @media (max-width 768px)
              margin-bottom 30px

        .error-body
            text-align center
            width 460px
            margin auto
            @media (max-width 768px)
              width 100%

            h1
                color $tertiary
                font-size 28px
                font-weight 600
                margin-bottom 10px
                line-height 1.4

            p
                font-size 14px
                color #616d82
                opacity .8
                margin-bottom 40px

            .button
                width 280px
                margin auto
</style>
