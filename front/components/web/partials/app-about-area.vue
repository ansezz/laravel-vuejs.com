<template>
    <section class="about-us-area">
        <div class="container">
            <div class="about-us-container">
                <div class="about-caption">
                    <h1>Who We Are?</h1>
                    <p>Treehouse brings affordable technology education to people everywhere in order to help them achieve their dreams and change the world.</p>
                </div>
                <div class="about-us-men">
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        name: "AppAboutArea"
    }

</script>

<style lang="stylus" scoped>
    .about-us-area
        background-color #e5e7e6
        .about-us-container
            display flex
            align-items center
            padding 256px 0
            .about-caption
                width 450px
                h1
                    color #384457
                    font-size 28px
                    font-weight 600
                    margin-bottom 20px
                p
                    color #384457
                    font-size 24px
                    margin-bottom 0
</style>
