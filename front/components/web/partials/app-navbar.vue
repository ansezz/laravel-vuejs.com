<template>
    <nav class="navbar">
        <div class="container">
            <div class="navbar-container">
                <ul class="navbar-list">
                    <li>
                        <a href="#" @click.prevent="toggleNavigationVisibility">
                            <img src="@/assets/images/icons-menu.png" alt="LV">
                            <span>Menu</span>
                        </a>
                    </li>
                    <li>
                        <a @click.prevent="toggleSearchVisibility" href="#">
                            <img src="@/assets/images/icons-search.png" alt="LV">
                            <span>Search</span>
                        </a>
                    </li>
                </ul>

                <nuxt-link class="navbar-logo" to="/">
                    <img src="@/assets/images/logo.png" alt="LV">
                </nuxt-link>

                <ul class="navbar-list">
                    <li>
                        <nuxt-link to="/page/newsletter">
                            <img src="@/assets/images/icons-email.png" alt="LV">
                            <span>Newsletter</span>
                        </nuxt-link>
                    </li>
                    <li v-if="loggedIn && me">
                        <nuxt-link to="/auth/account">
                            <img src="@/assets/images/icons-user.png" :alt="me.name">
                            <span>{{me.name}}</span>
                        </nuxt-link>
                    </li>
                    <li v-else>
                        <nuxt-link to="/auth/signup">
                            <img src="@/assets/images/icons-user.png" alt="LV">
                            <span>Sign up/in</span>
                        </nuxt-link>
                    </li>
                </ul>
            </div>
        </div>
        <app-search></app-search>
    </nav>
</template>

<script>
    import {mapActions, mapMutations} from 'vuex'
    import AppSearch from '@/components/web/partials/app-search';

    export default {
        name: 'AppNavbar',
        components: {
            AppSearch
        },
        data() {
            return {}
        },
        watch: {
            $route: function () {
                this.setNavigationVisibility(false)
                this.setSearchVisibility(false)
            }
        },
        computed: {
            me() {
                return this.$store.state.auth.me
            },
            loggedIn() {
                return this.$store.state.auth.loggedIn
            }
        },
        methods: {
            ...mapMutations({
                setNavigationVisibility: 'SET_NAVIGATION_VISIBILITY',
                setSearchVisibility: 'SET_SEARCH_VISIBILITY'
            }),
            ...mapActions(['toggleNavigationVisibility', 'toggleSearchVisibility']),
        },
    }

</script>

<style lang="stylus" scoped>
    .navbar
        border 0
        border-radius 0
        margin-bottom 0

        .navbar-container
            display flex
            align-items center
            justify-content space-between
            border-bottom 5px solid $primary
            height 70px

            .navbar-list
                display flex
                align-items center

                li
                    padding-right 42px

                    &:last-child
                        padding-right 0

                    a
                        font-size 12px
                        color $secondary
                        font-weight 600
                        text-transform uppercase
                        display flex
                        align-items center
                        letter-spacing 1px

                        img
                            margin-right 12px

                        span
                            margin-top 4px

</style>
