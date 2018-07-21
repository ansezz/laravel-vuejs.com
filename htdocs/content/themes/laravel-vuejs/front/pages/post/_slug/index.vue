<template>
  <component :is="this.$store.state.platform"/>
</template>

<script>
  export default {
    layout: ({store}) => store.state.platform,

    middleware: ['post'],

    components: {
      mobile: () => import(`~/views/mobile/post.vue`),
      desktop: () => import(`~/views/web/post.vue`)
    },
    head() {
      return {
        title: this.$store.state.news.current_post.title,
        meta: [
          {hid: 'description', name: 'description', content: this.$store.state.news.current_post.title}
        ]
      }
    }
  }
</script>

<style>
</style>
