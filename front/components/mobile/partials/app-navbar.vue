<template>
    <header class="header is-flex">
      <div class="menu-open">
        <img src="@/assets/images/icons-menu.png" alt="LV">
      </div>
      <div class="logo">
        <nuxt-link to="/">
          <img src="@/assets/images/logo.png" alt="LV">
        </nuxt-link>
      </div>
      <div class="user">
        <nuxt-link to="/">
          <img src="@/assets/images/icons-user.png" alt="LV">
        </nuxt-link>
      </div>
    </header>
</template>

<script>
    export default {
        name: 'AppNavbar',
        components: {
        },
        data() {
            return {

            }
        }
    }

</script>

<style lang="stylus" scoped>
  .header
    padding 18px 30px
    border-bottom 5px solid $primary
</style>
