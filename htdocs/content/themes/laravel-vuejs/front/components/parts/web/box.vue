<template lang="html">
  <div class="box">
    <article class="media">
      <div class="media-left">
        <figure class="image is-64x64">
          <img :src="image" alt="Image">
        </figure>
      </div>
      <div class="media-content">
        <div class="content" v-html="content">

        </div>
        <nav class="level">
          <div class="level-left">
            <a class="level-item" aria-label="reply">
              <span class="icon is-small">
                <i class="mdi mdi-share" aria-hidden="true"></i>
              </span>
            </a>
            <a class="level-item" aria-label="retweet">
              <span class="icon is-small">
                <i class="mdi mdi-twitter-retweet" aria-hidden="true"></i>
              </span>
            </a>
            <a class="level-item" aria-label="like">
              <span class="icon is-small">
                <i class="mdi mdi-cards-heart" aria-hidden="true"></i>
              </span>
            </a>
          </div>
        </nav>
      </div>
    </article>
  </div>
</template>

<script>
  export default {
    props: ["image", "content"]
  }
</script>

<style lang="css">
</style>
