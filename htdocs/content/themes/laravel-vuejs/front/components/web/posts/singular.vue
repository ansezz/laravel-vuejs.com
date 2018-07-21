<template lang="html">
  <div v-if="post">
    <Hero :title="post.title" :subtitle="post.author" type="success"/>
    <div class="container">
      <div class="content">
        <figure v-if="post.large">
          <img :src="post.large">
        </figure>
        <p v-html="post.content"></p>
      </div>
    </div>
  </div>
</template>

<script>
  import Hero from '~/components/parts/web/hero'

  export default {
    components: {
      Hero
    },
    computed: {
      post() {
        return this.$store.state.news.current_post
      }
    },
  }
</script>

<style lang="css">
</style>
