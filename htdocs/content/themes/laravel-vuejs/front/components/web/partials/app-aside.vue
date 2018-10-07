<template>
    <column class="is-relative" small>
      <aside class="aside is-sticky:top">
        
        <div class="aside-block">
          <heading>Follow us</heading>
          <div class="aside-block:content">

            <ul class="social">
              <li v-for="(item, index) in ['facebook', 'twitter', 'instagram', 'youtube', 'rss']" :key="index" :class="item">
                <i :class="`ion-logo-${item}`"/>
              </li>
            </ul>
          </div>
        </div>

      </aside>
    </column>
</template>

<script>
  export default {
    name: 'AppAside',
  }
</script>

<style lang="stylus" scoped>
  .aside
    top 100px
</style>
