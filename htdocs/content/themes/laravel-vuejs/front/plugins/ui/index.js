import Vue from "vue"

// Grid
import Container from "@/components/shared/partials/grid/container.vue"
Vue.component("Container", Container)

import Row from "@/components/shared/partials/grid/row.vue"
Vue.component("Row", Row)

import Column from "@/components/shared/partials/grid/column.vue"
Vue.component("Column", Column)

// Elements
import Breadcrumb from "@/components/shared/partials/elements/breadcrumb"
Vue.component("Breadcrumb", Breadcrumb)

import Thumbnail from "@/components/shared/partials/elements/thumbnail"
Vue.component("Thumbnail", Thumbnail)

import ArticleItem from "@/components/shared/partials/elements/article-item"
Vue.component("ArticleItem", ArticleItem)

import AppForm from "@/components/shared/partials/form/app-form"
Vue.component("AppForm", AppForm)

import AppControl from "@/components/shared/partials/form/app-control"
Vue.component("AppControl", AppControl)
