<template>
    <section>
        <app-about-area />
        <div class="small-container">
            <app-facts />
        </div>
        <div class="team-container" v-if="false">
            <div class="small-container">
                <app-team />
            </div>
        </div>
        <div class="join-us-container">
            <div class="small-container">
                <app-join-us />
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        components: {
            AppAboutArea: () => import('@/components/web/partials/app-about-area'),
            AppFacts: () => import('@/components/web/partials/app-facts'),
            AppTeam: () => import('@/components/web/partials/app-team'),
            AppJoinUs: () => import('@/components/web/partials/app-join-us')
        },
        name: "About"
    }

</script>

<style lang="stylus" scoped>
    .team-container
        border-top 1px solid #ebeef2
        padding 120px 0
    .join-us-container
        background-color $primary
        padding 63px 0
</style>
