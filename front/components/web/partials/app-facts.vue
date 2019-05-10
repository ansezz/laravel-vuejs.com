<template>
    <section class="app-facts">
        <div class="small-container">
            <div class="simple-heading">
                <h2 class="text-center">Some Facts..</h2>
                <p>Treehouse believes in the democratization of technical education. There are currently too many barriers, economical and psychological. Our students learn at their own pace and become job ready within months at a fraction of the cost.</p>
                <p>We are committed to making education accessible to students of all races, genders, sexual orientations, and socio-economic backgrounds.</p>
            </div>
            <ul class="facts-grid">
                <li class="fact">
                    <div class="fact-img">
                        <img src="@/assets/images/fac-1.png" alt="LV">
                    </div>
                    <div class="fact-info">
                        <span class="number">+3242</span>
                        <h5>Courses</h5>
                    </div>
                </li>
                <li class="fact">
                    <div class="fact-img">
                        <img src="@/assets/images/fac-2.png" alt="LV">
                    </div>
                    <div class="fact-info">
                        <span class="number">+546,879</span>
                        <h5>Minutes of Video</h5>
                    </div>
                </li>
                <li class="fact">
                    <div class="fact-img">
                        <img src="@/assets/images/fac-3.png" alt="LV">
                    </div>
                    <div class="fact-info">
                        <span class="number">+1,000,000</span>
                        <h5>Month Visites</h5>
                    </div>
                </li>
                <li class="fact">
                    <div class="fact-img">
                        <img src="@/assets/images/fac-4.png" alt="LV">
                    </div>
                    <div class="fact-info">
                        <span class="number">+6,698,420</span>
                        <h5>Persons Satisfied</h5>
                    </div>
                </li>
            </ul>
            <div class="links-action">
                <nuxt-link to="/" class="button">jobs offers</nuxt-link>
                <span>Or</span>
                <nuxt-link to="/" class="button">our news feed</nuxt-link>
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        name: "AppFacts"
    }

</script>

<style lang="stylus" scoped>
    .app-facts
        padding 120px 0
    .facts-grid
        display grid
        grid-template-columns repeat(4, 1fr)
        margin-bottom 60px
        .fact-img
            margin-bottom 15px
            height 74px
        span
            color #384457
            font-size 14px
            font-weight 600
        h5
            font-size 16px
            font-weight 700
            color $secondary
    .links-action
        display flex
        align-items center
        justify-content center
        span
            font-size 18px
            color #616d82
            display block
            margin 0 20px
            line-height 1.56
</style>
