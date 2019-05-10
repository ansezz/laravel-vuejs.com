<!--laravelvuejs_Home_M.png-->
<template>
  <section class="app-signup">
    <AppSignup/>
  </section>
</template>

<script>
  import AppSignup from "@/components/mobile/partials/app-signup"

  export default {
    components: {
      AppSignup
    },
    name: "SignUp"
  }
</script>

<style lang="stylus" scoped>
  .app-signup
    padding 65px 0
</style>
