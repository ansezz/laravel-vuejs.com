<template>
  <component :is="this.$store.state.platform"/>
</template>

<script>
  export default {
    layout: ({store}) => store.state.platform,

    middleware: ["tag"],
    computed: {
      tag() {
        return this.$store.state.tag.tag
      }
    },
    head() {
      return {
        title: this.tag.name,
        meta: [
          {hid: 'description', name: 'description', content: this.tag.name}
        ]
      }
    },
    components: {
      mobile: () => import(`~/views/mobile/tag/archive`),
      web: () => import(`~/views/web/tag/archive`)
    }
  }
</script>

<style>
</style>
