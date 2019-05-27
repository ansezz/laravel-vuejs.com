import Vue from 'vue'

Vue.mixin({
  computed: {
    platform() {
      return this.$store.state.platform
    },
  },

  methods: {
    isWeb() {
      return this.platform == 'web' ? true : false
    },
    isMobile() {
      return this.platform == 'mobile' ? true : false
    },
  },
})
