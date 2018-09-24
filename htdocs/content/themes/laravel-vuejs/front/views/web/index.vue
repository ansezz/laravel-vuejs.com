<!--laravelvuejs_Home_M.png-->
<template>
  <section>
    
    <app-header/>

    <container>

      <column large>
        <app-feed v-if="feed" :articles="feed.posts"/>
      </column>

      <column class="is-relative" small>
        <div class="is-sticky:top">
          <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Assumenda quidem ipsum aperiam doloremque pariatur exercitationem amet excepturi nemo veritatis atque? Commodi, aspernatur sed! Maiores explicabo, consequatur libero at expedita molestias.</p>
        </div>
      </column>

    </container>
  </section>
</template>

<script>
import AppHeader from "@/components/web/partials/app-header"
import AppFeed from "@/components/web/partials/app-feed"

export default {
  name: "index",
  components: { AppHeader, AppFeed },
  data() {
    return {}
  },
  computed: {
    feed() {
      return this.$store.state.post.featured
    }
  }
}
</script>

<style lang="stylus" scoped>
</style>
