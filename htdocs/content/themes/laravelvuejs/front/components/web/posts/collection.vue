<template lang="html">
  <section class="section">
    <div class="container">
      <div v-if="news" class="columns is-multiline">
        <div class="column is-one-third" v-for="(news,index) in news.data" :key="index">
          <Card :image="news.thumbnail" :title="news.title" :time="news.created" :link="'post/'+news.slug"/>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
  import Card from '~/components/parts/web/card'

  export default {
    components: {
      Card
    },
    computed: {
      news() {
        return this.$store.state.news.latest_news
      }
    },

  }
</script>

<style lang="css">
</style>
