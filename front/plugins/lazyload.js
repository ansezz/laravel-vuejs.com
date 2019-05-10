import Vue from "vue"
import VueLazyload from "vue-lazyload"

Vue.use(VueLazyload, {
  preLoad: 1.3,
  attempt: 1
})
