<template lang="html">
  <div>
    <h1>{{post.title}}</h1>
    <pre>
    {{post}}
  </pre>
  </div>
</template>

<script>
  export default {
    components: {},
    name: 'post',
    computed: {
      post() {
        return this.$store.state.post.single
      }
    },
  }

</script>

<style lang="stylus" scoped>
</style>
