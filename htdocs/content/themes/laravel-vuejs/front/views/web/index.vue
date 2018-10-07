<!--laravelvuejs_Home_M.png-->
<template>
  <section>
    
    <app-header/>

    <container>

      <row>
        <app-featured v-if="feed" :articles="feed.posts"/>
      </row>
     
      <row>
        <column large>
          <app-feed v-if="feed" :articles="feed.posts"/>
        </column>

        <app-aside />
      </row>

    </container>
  </section>
</template>

<script>
  export default {
    name: 'index',
    components: {
      AppHeader: () => import('@/components/web/partials/app-header'),
      AppFeatured: () => import('@/components/web/partials/app-featured'),
      AppFeed: () => import('@/components/web/partials/app-feed'),
      AppAside: () => import('@/components/web/partials/app-aside'),
    },
    data() {
      return {}
    },
    computed: {
      feed() {
        return this.$store.state.post.featured
      },
    },
  }
</script>

<style lang="stylus" scoped>
</style>
