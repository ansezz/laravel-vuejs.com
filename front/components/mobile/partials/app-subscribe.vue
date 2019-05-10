<template>
  <section class="mobile-subscribe" v-if="!loggedIn">
    <div class="mobile-container">
      <div class="subscribe-info">
        <h3>Stay in Touch</h3>
        <p>Sign up for our newsletter, and we'll send you news and tutorials on web design, coding, business, and
          more!</p>
      </div>
      <app-form class="subscribe-form">
        <div class="alert alert-success" role="alert" v-if="message">
          {{message}}
        </div>
        <div class="form-group">
          <input type="email" class="form-control" placeholder="E-mail" v-model="email">
          <div class="img">
            <i class="fa fa-envelope"></i>
          </div>
        </div>
        <template slot="actions">
          <button class="button" type="submit" @click.prevent="subscribe">Subscribe</button>
          <button class="button no-background" type="submit">Advenced subscribe</button>
        </template>
      </app-form>
    </div>
  </section>
</template>

<script>
  import subscribeQql from '@/graphql/mutations/subscribe.graphql';

  export default {
    name: "AppSubscribe",
    props: {},
    data() {
      return {
        email: '',
        message: null
      }
    },
    computed :{
      loggedIn() {
        return this.$store.state.auth.loggedIn;
      }
    },
    methods: {
      subscribe() {
        if (!this.email)
          return;

        let variables = {email: this.email};
        this.message = null;
        this.$apollo.mutate({mutation: subscribeQql, variables})
          .then((data) => {
            this.message = data.data.subscribe
          })
      }
    },
    mounted() {
    }
  }
</script>

<style lang="stylus" scoped>
  .mobile-subscribe
    padding 50px 0
    background-color $secondary

    .subscribe-info
      color #FFF
      margin-bottom 30px

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
    .subscribe-form
      &/deep/
        .form-controls
          margin-bottom 0
          .form-group
            .form-control
              height 50px
        .form-actions
          flex-direction column
          .button
            width 100%
            height 50px
            margin-bottom 30px
            &.no-background
              height auto
              margin-bottom 0
</style>
