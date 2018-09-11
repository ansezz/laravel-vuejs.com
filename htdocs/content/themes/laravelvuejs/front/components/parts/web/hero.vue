<template lang="html">
  <section :class="'hero is-'+type">
    <div class="hero-body">
      <div class="container">
        <h1 class="title" v-html="title">

        </h1>
        <h2 class="subtitle" v-html="subtitle">

        </h2>
      </div>
    </div>
  </section>
</template>

<script>
  export default {
    props: ["type", "title", "subtitle"]
  }
</script>

<style lang="css">
</style>
