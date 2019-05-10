<template>
    <section class="app-newsletter">
        <div class="newsletter-box">
            <header>
                <div class="user-avatar">
                    <img src="@/assets/images/icons-email.png" alt="LV">
                </div>
                <h1>Contact us || Hire us</h1>
                <p>Send us a message, Explain to us what you need !</p>
            </header>
            <form action="/">
                <div class="form-group">
                    <input type="text" name="name" class="form-control has-custom" placeholder="Full Name" />
                </div>
                <div class="form-group m-20">
                    <input type="email" name="email" class="form-control has-custom" placeholder="Your E-mail" />
                </div>
                <div class="form-group m-20">
                    <input type="text" name="subject" class="form-control has-custom" placeholder="Subject" />
                </div>
                <div class="form-group m-20">
                    <textarea class="form-control has-custom" name="message" placeholder="Your Message" style="min-height: 200px;"></textarea>
                </div>
                <div class="form-actions">
                    <button class="button" type="submit" name="subscribe">Send</button>
                </div>
            </form>
        </div>
    </section>
</template>

<script>
export default {
    name: "AppNewsletter",
}
</script>

<style lang="stylus" scoped>
    .app-newsletter
        padding 62px 0 70px
    .newsletter-box
        width 500px
        margin auto
        header
            text-align center
            margin-bottom 40px
            h1
                font-size 28px
                font-weight 600
                color $tertiary
                margin 10px 0
                line-height 1.4
            p
                margin-bottom 0
                font-size 18px
                color #616d82
                line-height 1.56
        .form-group
            margin-bottom 10px
            &.m-20
                margin-bottom 20px
    .cats
        display flex
        align-items center
        margin-bottom 20px
        .checking
            padding-right 20px
            &:last-child
                padding-right 0
        & >>>
                .checking
                    margin-bottom 0
                    label
                        &:before
                            top 2px !important
                        &:after
                            top 4px !important
</style>
