<template>
    <div class="search-container" :class="{ 'open-search' : search.visibility }">
        <div class="container">
            <form class="search-form">
                <div class="form-group">
                    <input type="text" name="s" class="form-control" placeholder="Search" @keyup="searching = true">
                    <i class="fa" :class="searching ? 'fa-spin fa-spinner' : 'fa-search' "/>
                </div>
                <ul class="search-result">
                    <li class="is-relative">
                        <div class="search-thumb">
                            <img src="@/assets/images/preview.png" alt="LV"/>
                        </div>
                        <div class="search-info">
                            <h3>Firebase Realtime Admin Dashboard – Vue.js</h3>
                            <span>
                      <i class="fa fa-clock-o"></i>
                      1 week ago
                    </span>
                        </div>
                        <nuxt-link to="/" class="is-absolute"/>
                    </li>
                </ul>
            </form>
            <div @click.prevent="toggleSearchVisibility" class="close-search">
                <img src="@/assets/images/close-button.png" alt="LV">
            </div>
        </div>
    </div>
</template>

<script>
    import {mapActions} from 'vuex';

    export default {
        name: 'AppSearch',
        data() {
            return {
                searching: false
            }
        },
        watch: {},
        computed: {
            search() {
                return this.$store.state.search
            },
        },
        methods: {
            ...mapActions(['toggleSearchVisibility']),
        },
    }

</script>

<style lang="stylus" scoped>
    .search-container
        position fixed
        top 0
        left 0
        width 100%
        height 100%
        background-color rgba(0, 0, 0, .9)
        z-index 100
        display none
        align-items center
        justify-content center

        &.open-search
            display flex

        .form-group
            margin-bottom 0
            position relative

            .form-control
                height 80px
                border 0
                border-radius 0
                font-size 25px
                font-weight 600
                background-color #3e383e
                padding-left 20px
                box-shadow none
                color #969393

                &::placeholder
                    color #969393

            .fa
                position absolute
                top 0
                right 0
                width 100px
                height 100%
                display flex
                align-items center
                justify-content center
                font-size 25px
                color #969393

        .close-search
            position absolute
            top 100px
            right 150px
            cursor pointer

            img
                width 25px
                height 25px

        .search-result
            background-color #3e383e
            padding 0 20px 20px

            &:hover
                .search-info
                    h3
                        color $primary

            li
                display flex
                align-items center

            .search-thumb
                width 110px
                margin-right 20px

                img
                    width 100%

            h3
                font-size 18px
                color #FFF
                font-weight 600
                margin-bottom 10px
                transition all .35s ease-in-out

            span
                color #b3a7a7

</style>
