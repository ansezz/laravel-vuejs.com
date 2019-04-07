<!--laravelvuejs_Home_M.png-->
<template>
    <section class="app-login">
        <app-login />
    </section>
</template>

<script>
  export default {
    components: {
        AppLogin: () => import('@/components/mobile/partials/app-login'),
    },
    name: "Login"
  }
</script>

<style lang="stylus" scoped>
    .app-login
        padding 65px 0
</style>
