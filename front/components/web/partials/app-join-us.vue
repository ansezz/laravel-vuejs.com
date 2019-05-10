<template>
    <div class="join-us-p">
        <div class="join-us-box text-center">
            <h3>Join us now!</h3>
            <p>You think you can make it better?</p>
            <nuxt-link to="/page/contact-us" class="button white-button">Send us your greats</nuxt-link>
        </div>
        <div class="join-us-svg">
            <img src="@/assets/images/group.svg" alt="LV">
        </div>
    </div>
</template>

<script>
    export default {
        name: "AppJoinUs"
    }

</script>

<style lang="stylus" scoped>
    .join-us-p
        padding 0 40px
        display flex
        align-items center
        justify-content space-between
    .join-us-box
        h3
            font-size 24px
            color #384457
            margin-bottom 10px
        p
            font-size 14px
            color #616d82
            opacity .8
            margin-bottom 40px
    .join-us-svg
        width 433px
        img
            width 100%
</style>
