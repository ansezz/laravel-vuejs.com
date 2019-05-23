<template>
    <div v-swiper:mySwiper="jobs" class="swiper-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="tag-thumb is-flex">
                    <img src="@/assets/images/icons-tag.svg" alt="LV">
                </div>
                <h4>Codes, productivity, laravel, tutos</h4>
            </div>
            <div class="swiper-slide">
                <div class="tag-thumb is-flex">
                    <img src="@/assets/images/icons-tag.svg" alt="LV">
                </div>
                <h4>3D Design/Toy Design/Industrial Design</h4>
            </div>
            <div class="swiper-slide">
                <div class="tag-thumb is-flex">
                    <img src="@/assets/images/icons-tag.svg" alt="LV">
                </div>
                <h4>Jr. Graphic Designer</h4>
            </div>
        </div>
        <div class="navigation-buttons is-flex">
            <div class="swiper-button-next-slider">
                <div class="swipe">
                    <img src="@/assets/images/icons-next.svg" alt="LV">
                </div>
            </div>
            <div class="swiper-button-prev-slider">
                <div class="swipe">
                    <img src="@/assets/images/icons-next.svg" alt="LV">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "AppJobsSwiper",
        data() {
            return {
                jobs: {
                    slidesPerView: 1,
                    speed: 400,
                    autoplay: {
                        delay: 5000,
                    },
                    spaceBetween: 0,
                    navigation: {
                        nextEl: ".swiper-button-next-slider",
                        prevEl: ".swiper-button-prev-slider"
                    }
                }
            }
        }
    }

</script>

<style lang="stylus" scoped>
    .swiper-container
        padding 30px 0 40px
    .swiper-slide
        text-align center
    .tag-thumb
        width 45px
        height 45px
        border 2px solid $secondary
        border-radius 50%
        justify-content center
        margin auto auto 20px
    h4
        font-size 16px
        font-weight 400
        color #616d82
        line-height 30px
    .navigation-buttons
        position absolute
        left 0
        right 0
        z-index 1
        flex-direction row-reverse
        align-items baseline
        bottom 0
        justify-content center
    .swipe
        display flex
        align-items center
        span
            color $secondary
            font-size 12px
            font-weight 600
            letter-spacing 2px
            text-transform uppercase
            display block
    h6
        font-size 14px
        color #384457
        font-weight 500
        margin-top 10px
        line-height 1.4
    .swiper-button-prev-slider
      margin-right 10px
      img
        transform rotate(180deg)
    .swiper-button-next-slider,
    .swiper-button-prev-slider
        outline none
</style>
