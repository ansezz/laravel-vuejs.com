<template lang="html">
  <div class="card" @click="$router.push(link)" style="cursor:pointer;">
    <div class="card-image">
      <figure class="image is-4by3">
        <img :src="image" alt="Placeholder image">
      </figure>
    </div>
    <div class="card-content">
      <div class="media">
        <div class="media-content">
          <p class="title is-4" v-html="title"></p>
        </div>
      </div>

      <div class="content">
        <time datetime="2016-1-1" v-html="time"></time>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    props: ["image", "title", "time", "link"]
  }
</script>

<style lang="css">
</style>
