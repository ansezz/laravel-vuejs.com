<template>
    <section>
        <div class="sign-up-form">
            <h3>Sign Up Now!</h3>
            <form action="#" method="post">
                <div class="form-group">
                    <input type="text" name="fullname" class="form-control has-custom" placeholder="Full Name">
                </div>
                <div class="form-group">
                    <input type="email" name="email" class="form-control has-custom" placeholder="E-Mail">
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control has-custom" placeholder="Password">
                </div>
                <ul class="form-status">
                    <li></li>
                    <li></li>
                    <li></li>
                </ul>
                <div class="checking">
                    <input type="checkbox" id="checked" class="check">
                    <label for="checked">I want to hear from you about products and services.</label>
                </div>
                <div class="form-actions">
                    <button type="submit" class="button" name="start">Start Now</button>
                    <nuxt-link class="button no-background" to="/">I have an account</nuxt-link>
                </div>
            </form>
        </div>
    </section>
</template>

<script>
    export default {
        name: 'AppSignUpForm',
    }

</script>

<style lang="stylus" scoped>
    .sign-up-form
        width 400px
        background-color #FFF
        padding 50px
        h3
            font-size 16px
            font-weight 500
            color #384457
            margin-bottom 20px
        form
            .form-group
                margin-bottom 10px
            .form-actions
                display flex
                align-items center
                justify-content space-between
                button
                    width 130px
                .no-background
                    color $secondary
</style>
