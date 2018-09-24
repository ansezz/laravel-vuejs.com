<!--laravelvuejs_Home_M.png-->
<template>
  <section>
    
    <app-header/>

    <app-container>

      <app-column large>
        <app-feed :articles="articles"/>
      </app-column>

      <app-column class="is-relative" small>
        <div class="is-sticky:top">
          <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Assumenda quidem ipsum aperiam doloremque pariatur exercitationem amet excepturi nemo veritatis atque? Commodi, aspernatur sed! Maiores explicabo, consequatur libero at expedita molestias.</p>
        </div>
      </app-column>

    </app-container>
  </section>
</template>

<script>
import AppHeader from "@/components/web/partials/app-header"
import AppFeed from "@/components/web/partials/app-feed"

export default {
  name: "index",
  components: { AppHeader, AppFeed },
  data() {
    return {
      articles: [
        {
          title:
            "Promises, promises: A quick introduction to JavaScript concurrency",
          description:
            "Sign up for our newsletter, and we'll send you news and tutorials on web design, coding, business, and more!"
        },
        {
          title: "Laravel Query Builder",
          description:
            "Sign up for our newsletter, and we'll send you news and tutorials on web design, coding, business, and more!"
        },
        {
          title:
            "Laravel 5.6 Dynamic Rate Limiting Provides Per-User Request Throttling",
          description: ""
        },
        {
          title: "Laravel Relationship Events",
          description: ""
        },
        {
          title: "Eventy: WordPress-like Actions and Filters for Laravel",
          description: ""
        },
        {
          title:
            "Promises, promises: A quick introduction to JavaScript concurrency",
          description: ""
        },
        {
          title: "How learning to code changed my life",
          description: ""
        },
        {
          title: "Your First Hackathon: A Survival Guide",
          description: ""
        },
        {
          title:
            "Student Success: How Treehouse helped George Lambert get out of a cubicle to form his own company",
          description: ""
        }
      ]
    }
  }
}
</script>

<style lang="stylus" scoped>
</style>
