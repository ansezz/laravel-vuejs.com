<template lang="html">
  <section class="posts-container">
    <breadcrumb :pages="breadcrumbsData()"/>
    <h1 v-if="post">{{post.title}}</h1>
    <pre>
    {{post}}
  </pre>
  </section>
</template>

<script>
  export default {
    components: {
      Breadcrumb: () => import('@/components/shared/partials/elements/breadcrumb'),
    },
    name: 'post',
    computed: {
      post() {
        return this.$store.state.post.single
      }
    },
    data() {
      return {
        breadcrumbsData: () => [
          {
            name: 'Home',
            link: "/"
          },
          {
            name: this.post.title
          }
        ]
      }
    }
  }

</script>

<style lang="stylus" scoped>
</style>
