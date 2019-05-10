<!--laravelvuejs_Home_M.png-->
<template>
  <section class="reset-password">
    <app-reset-password />
  </section>
</template>

<script>
  export default {
    components: {
        AppResetPassword: () => import('@/components/mobile/partials/app-reset-password'),
    },
    name: "ResetPassword"
  }
</script>

<style lang="stylus" scoped>
    .reset-password
        padding 65px 0
</style>
