<template>
  <component :is="this.$store.state.platform"/>
</template>

<script>
  export default {
    layout: ({store}) => store.state.platform,

    middleware: ["home"],

    head: {
      title: '🚀🚀 Home page🚀',
      meta: [
        {hid: 'description', name: 'description', content: 'Home page Larvel VueJs'}
      ]
    },
    components: {
      mobile: () => import(`~/views/mobile`),
      web: () => import(`~/views/web`)
    }
  }
</script>

<style>
</style>
