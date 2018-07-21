<template>
  <div>
    <HomeHeader/>
    <PostsCollection/>
  </div>
</template>

<script>
  import HomeHeader from '~/components/mobile/headers/home'
  import PostsCollection from '~/components/mobile/posts/collection'

  export default {
    components: {
      HomeHeader,
      PostsCollection
    },
    name: "index"
  }
</script>

<style scoped>

</style>
