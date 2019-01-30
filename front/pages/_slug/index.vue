<template>
  <component :is="this.$store.state.platform"/>
</template>

<script>
  export default {
    layout: ({store}) => store.state.platform,

    middleware: ["post"],
    computed: {
      post() {
        return this.$store.state.post.single
      }
    },
    head() {
      return {
        title: this.post.title,
        meta: [
          {hid: 'description', name: 'description', content: this.post.excerpt}
        ]
      }
    },
    components: {
      mobile: () => import(`~/views/mobile/post`),
      web: () => import(`~/views/web/post`)
    }
  }
</script>

<style>
</style>
