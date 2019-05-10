<template>
    <div :class="{ 'is-visible' : navigation.visibility }" class="app-navigation">
        <nav class="navigation">
            <div class="navigation-header">
                <a @click.prevent="toggleNavigationVisibility" href="#" class="close-menu">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                        <path fill="#6936D3" fill-rule="evenodd"
                              d="M16 5.209L14.791 4 10 8.791 5.209 4 4 5.209 8.791 10 4 14.791 5.209 16 10 11.209 14.791 16 16 14.791 11.209 10z"/>
                    </svg>
                    <span>Menu</span>
                </a>
            </div>
            <div class="navigation-body">
                <ul class="items">
                    <li class="item-heading">
                        <span>Blog</span>
                    </li>
                    <li v-for="(item ,key) in main_menu" :key="key">
                        <nuxt-link :to="item.url">{{item.name}}</nuxt-link>
                    </li>
                </ul>
                <!-- <ul class="items has-separated">
                     <li class="item-heading">
                         <span>Jobs</span>
                     </li>
                     <li><a href="#">Latest Jobs</a></li>
                     <li><a href="#">Create job</a></li>
                     <li><a href="#">Pricing</a></li>
                     <li><a href="#">Products</a></li>
                     <li><a href="#">Courses</a></li>
                 </ul>-->
                <ul class="items last-items">
                    <li v-for="(item ,key) in second_menu" :key="key">
                        <nuxt-link :to="item.url">{{item.name}}</nuxt-link>
                    </li>
                </ul>
                <ul class="social-media">
                    <li v-for="(item, index) in social_media" :key="index"
                        :class="item.class">
                        <a :href="item.href" target="_blank">
                            <i class="fa" :class="'fa-'+item.class"/>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</template>

<script>
    import {mapActions} from "vuex"

    export default {
        name: "AppNavigation",
        computed: {
            navigation() {
                return this.$store.state.navigation
            },
            main_menu() {
                return this.$store.state.main_menu;
            },
            second_menu() {
                return this.$store.state.second_menu;
            },
            social_media() {
                return this.$store.state.social_media;
            }
        },
        methods: {
            ...mapActions(["toggleNavigationVisibility"])
        }
    }
</script>

<style lang="stylus" scoped>
    .app-navigation
        position fixed
        top 0
        left -100%
        width 100%
        background-color rgba($tertiary, .3)
        height 100vh
        transition .5s left
        z-index 10
        cursor pointer

        &.is-visible
            left 0

        .navigation
            width 300px
            height 100%
            background-color #FFF

            .navigation-header
                padding 25px 25px 60px

                .close-menu
                    display flex
                    align-items center
                    justify-content flex-end
                    font-size 12px
                    color $secondary
                    font-weight 600
                    text-transform uppercase
                    letter-spacing 1px

                    svg
                        margin-right 12px

            .navigation-body
                height calc(100% - 105px)
                overflow-y scroll

                &::-webkit-scrollbar
                    width 5px

                &::-webkit-scrollbar-thumb
                    background-color $secondary

                .items
                    position relative
                    padding 0 40px 0 82px
                    margin-bottom 50px

                    &.has-separated
                        padding-bottom 50px
                        border-bottom 1px solid #ebeef2

                    &.last-items
                        padding-left 32px

                    li
                        a
                            font-size 16px
                            color #616d82
                            line-height 30px

                        &.item-heading
                            transform rotate(90deg)
                            position absolute
                            top 10px
                            left 20px
                            display flex
                            align-items center
                            font-weight 700
                            color $secondary

                            span
                                font-size 16px
                                display block

                        &.active
                            a
                                color $secondary

                .social-media
                    display flex
                    align-items center
                    flex-wrap wrap
                    padding 0 32px 30px

                    li
                        padding-right 15px
                        margin-bottom 5px

                        &:last-child
                            padding-right 0

                        a
                            display block
                            width 16px
                            height 16px
                            font-size 17px
                            color #311d5a
</style>
