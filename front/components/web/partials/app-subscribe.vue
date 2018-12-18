<template>
  <section class="subscribe has-background:secondary">
    <container>
      <column half>
        <h3>Stay in Touch</h3>
        <p>Sign up for our newsletter, and we'll send you news and tutorials on web design, coding, business, and more!</p>
      </column>
      <column half>
        <app-form class="subscribe-form">
          
          <app-control id="SubscribeEmail" type="email" placeholder="E-mail" icon="ion-ios-mail" wide light/>
          
          <template slot="actions">
            <button class="button:primary" type="submit">Subscribe</button>
            <button class="button has-color:white" type="submit">Advenced subscribe</button>
          </template>

        </app-form>
      </column>
    </container>
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
</style>
