<template>
  <component :is="this.$store.state.platform"/>
</template>

<script>
  import seo from '@/mixins/seo'

  export default {
    mixins: [seo],

    layout: ({store}) => store.state.platform,

    middleware: ["tag"],
    computed: {
      seo() {
        return {
          title: this.tag.name,
          description: this.tag.name,
          type: 'website',
        }
      },
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
