<template>
  <div class="filters">
    <div class="filter-group">
      <select name="showen-posts" aria-label="count" @change="action" v-model="filter.count">
        <option value="12">show 12 posts</option>
        <option value="24">show 24 posts</option>
        <option value="48">show 48 posts</option>
      </select>
    </div>
    <div class="filter-group">
      <select name="most-popular" aria-label="Sort by" @change="action" v-model="filter.sort_by">
        <option value="latest">Latest first</option>
        <option value="oldest">Oldest first</option>
        <option value="popular">Popular first</option>
      </select>
    </div>
  </div>
</template>

<script>
  export default {
    components: {},
    name: "filters",
    computed: {},
    methods: {},
    props: {
      filter: Object,
      action: Function
    },
    mounted() {
      this.filter.count = this.$route.query.count ?? 12
      this.filter.sort_by = this.$route.query.sort_by ?? 'latest'
      this.page = this.$route.query.page ?? 1
    },
    data() {
      return {}
    }
  }

</script>

<style lang="stylus" scoped>
  .filters
    display flex
    align-items center

    .filter-group
      position relative
      margin-right 45px

      &:after
        content "\f0d7"
        font-family "FontAwesome"
        color $secondary
        padding-left 15px

      &:last-child
        margin-right 0

      select
        font-size 12px
        font-weight 600
        letter-spacing 2px
        color $secondary
        text-transform uppercase
        border 0
        background-color transparent
        outline none
        -webkit-appearance none
        -moz-appearance none
        appearance none
</style>
