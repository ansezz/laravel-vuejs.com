<template>
    <section class="subscribe">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="subscribe-info">
                        <h3>Stay in Touch</h3>
                        <p>Sign up for our newsletter, and we'll send you news and tutorials on web design, coding, business, and more!</p>
                    </div>
                </div>
                <div class="col-sm-6">
                    <app-form class="subscribe-form">
                        <div class="form-group">
                            <input type="email" class="form-control" placeholder="E-mail">
                            <div class="img">
                                <img src="@/assets/images/icons-email.png" alt="#">
                            </div>
                        </div>
                        <template slot="actions">
                            <button class="button" type="submit">Subscribe</button>
                            <button class="button no-background" type="submit">Advenced subscribe</button>
                        </template>
                    </app-form>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
  name: "AppSubscribe",

  props: {},
  data() {
    return {}
  },
  mounted() {}
}
</script>

<style lang="stylus" scoped>
  .subscribe
    padding 50px 0
    background-color $secondary
    .subscribe-info
        color #FFF
        h3
            font-size 24px
            font-weight 400
            line-height 1.4
            margin-bottom 10px
        p
            margin-bottom 0
            font-size 16px
            font-weight 300
            opacity 0.8
</style>
