<!--laravelvuejs_Home_M.png-->
<template>
  <section>
    <h1>Login Web</h1>
    <button class="button button-green" @click="logout"> Logout</button>
  </section>
</template>

<script>
  import {mapActions} from 'vuex'

  export default {
    components: {},
    methods: {
      ...mapActions({
        logout: 'auth/LOGOUT',
      }),
    },
    name: "Login"
  }
</script>

<style lang="stylus" scoped>
</style>
