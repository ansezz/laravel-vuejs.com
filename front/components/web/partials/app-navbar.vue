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
                        <nuxt-link to="/search">
                            <img src="@/assets/images/icons-search.png" alt="LV">
                            <span>Search</span>
                        </nuxt-link>
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
                    <li>
                        <nuxt-link to="/auth/signup">
                            <img src="@/assets/images/icons-user.png" alt="LV">
                            <span>Sign up/in</span>
                        </nuxt-link>
                    </li>
                </ul>
           </div>
        </div>
    </nav>
</template>

<script>
    import {
        mapActions
    } from 'vuex'

    export default {
        name: 'AppNavbar',
        methods: {
            ...mapActions(['toggleNavigationVisibility']),
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
