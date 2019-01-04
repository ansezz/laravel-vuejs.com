<template>
    <section class="terms-container">
        <breadcrumb :pages="breadcrumbsData" />
        <div class="small-container">
           <header>
                <div class="user-avatar">
                    <img src="@/assets/images/icons-page.svg" alt="LV">
                </div>
                <h1>Terms & Conditions</h1>
            </header>
            <div class="terms-desc">
                <p>Ah, those warm summer months are the best, aren’t they? And not just because they’re synonymous with lounging poolside or trekking down to the river with family and friends. There’s just something about this time of year that makes it perfect for setting and accomplishing goals, or tackling that special project that’s been at the back of your mind.</p>
                <p>I don’t know if it’s the heat, or the long days, or maybe just that extra touch of playfulness that seems to tickle folks between Spring and Fall. But there’s just something about the summertime that is perfect for finally cleaning out the garage, or taking a class, or picking up a new hobby.</p>
                <p>It’s an ideal time for learning some new code skills or building on the ones you already have. Think about it: If you set your mind to it, I mean really committed yourself to doing something awesome, how much could you learn in a single summer? What sorts of cool projects could you build in that time?</p>
                <p>If you have your sights set on learning some code and upping your web dev game, here are some great tips and tricks to help you on your way and keep you focused amid those many tantalizing and/or obligatory summertime distractions.</p>
                <p>If you have your sights set on learning some code and upping your web dev game, here are some great tips and tricks to help you on your way and keep you focused amid those many tantalizing and/or obligatory summertime distractions.</p>
                <p>Ah, those warm summer months are the best, aren’t they? And not just because they’re synonymous with lounging poolside or trekking down to the river with family and friends. There’s just something about this time of year that makes it perfect for setting and accomplishing goals, or tackling that special project that’s been at the back of your mind.</p>
                <div class="p-ads">
                    <div class="paragrpahs">
                        <p>I don’t know if it’s the heat, or the long days, or maybe just that extra touch of playfulness that seems to tickle folks between Spring and Fall. But there’s just something about the summertime that is perfect for finally cleaning out the garage, or taking a class, or picking up a new hobby.</p>
                        <p>It’s an ideal time for learning some new code skills or building on the ones you already have. Think about it: If you set your mind to it, I mean really committed yourself to doing something awesome, how much could you learn in a single summer? What sorts of cool projects could you build in that time?</p>
                        <p>If you have your sights set on learning some code and upping your web dev game, here are some great tips and tricks to help you on your way and keep you focused amid those many tantalizing and/or obligatory summertime distractions.</p>
                        <p>Here are some great tips and tricks to help you on your way and keep you focused amid those many tantalizing.</p>
                    </div>
                    <div class="ads">300x600</div>
                </div>
            </div>
            <ul class="meta">
                <li>
                    <span>
                        <img src="@/assets/images/icons-clock.svg" alt="LV">
                        3 Minutes ago.
                    </span>
                    <span>12 JUI 2018.</span>
                    <span>13:55</span>
                </li>
            </ul>
        </div>
    </section>
</template>

<script>
    export default {
        name: "TermConditions",
        components: {
            Breadcrumb: () => import('@/components/shared/partials/elements/breadcrumb')
        },
        data() {
            return {
                breadcrumbsData: [{
                        name: 'Home',
                        link: "/"
                    },
                    {
                        name: 'Pages',
                        link: "/"
                    },
                    {
                        name: 'Terms & Conditions',
                        link: '/'
                    }
                ]
            }
        }
    }

</script>

<style lang="stylus" scoped>
    .terms-container
        padding-bottom 120px
    header
        text-align center
        margin 60px 0 30px
        h1
            font-size 28px
            font-weight 600
            color $tertiary
            margin 10px 0
            line-height 1.4
    .terms-desc
        p
            color #616d82
            font-size 18px
            line-height 28px
            margin-bottom 20px
    .p-ads
        display flex
        justify-content space-between
        .paragrpahs
            width 460px
    .ads
        width 300px
        height 600px
        display flex
        align-items center
        justify-content center
        background-color #3abbff
        font-size 24px
        color $white
    .meta
        margin-top 60px
        display flex
        justify-content center
        span
            color #616d82
            font-size 14px
            padding-right 15px
            opacity .8
            img
                padding-right 5px
            &:last-child
                padding-right 0
</style>
