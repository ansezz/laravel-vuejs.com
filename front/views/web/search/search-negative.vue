<!--laravelvuejs_Home_M.png-->
<template>
    <section class="search-area">
        <div class="medium-container">
            <div class="search-header is-flex is-center is-column">
                <img src="@/assets/images/icons-search.svg" alt="LV">
                <h1 class="search-title">Search for: htyt</h1>
                <span class="number-found">0 Results</span>
            </div>
            <div class="search-form">
                <form class="form is-flex">
                    <div class="form-group">
                        <select name="type" class="form-control has-custom">
                            <option value="1">Type</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control has-custom" placeholder="use another keyword">
                        <img src="@/assets/images/icons-search.svg" alt="LV">
                    </div>
                </form>
            </div>
            <div class="search-error text-center">
                <p>Sorry. but we didn’t anything. Please try again with deferent keywords.</p>
                <div class="error-img">
                    <img src="@/assets/images/search-error.png" alt="LV">
                </div>
            </div>
            <app-featured />
        </div>
    </section>
</template>

<script>
  export default {
    components: {
        AppFeatured: () => import('@/components/web/partials/app-featured')
    },
    name: "Search-Negative"
  }
</script>

<style lang="stylus" scoped>
    .search-title
        margin 10px 0
    .featured-articles
        padding 40px 0 0 !important
        &:after
            display none
</style>
