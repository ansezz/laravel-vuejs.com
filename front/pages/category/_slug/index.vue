<template>
  <component :is="this.$store.state.platform"/>
</template>

<script>
  export default {
    layout: ({store}) => store.state.platform,

    middleware: ["category"],
    computed: {
      category() {
        return this.$store.state.category.category
      }
    },
    head() {
      return {
        title: this.category.name,
        meta: [
          {hid: 'description', name: 'description', content: this.category.description}
        ]
      }
    },
    components: {
      mobile: () => import(`~/views/mobile/category/archive`),
      web: () => import(`~/views/web/category/archive`)
    }
  }
</script>

<style>
</style>
