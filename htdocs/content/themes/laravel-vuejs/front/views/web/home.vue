<template>
  <div>
    <HomeHeader/>
    <PostsCollection/>
  </div>
</template>

<script>
  import HomeHeader from '~/components/web/headers/home'
  import PostsCollection from '~/components/web/posts/collection'

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
