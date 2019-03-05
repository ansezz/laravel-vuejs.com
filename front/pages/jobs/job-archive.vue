<template>
    <component :is="this.$store.state.platform" />
</template>

<script>
    export default {
        layout: ({
            store
        }) => store.state.platform,
        components: {
            mobile: () => import(`~/views/mobile/jobs/job-archive`),
            web: () => import(`~/views/web/jobs/job-archive`)
        }
    }

</script>

<style>
</style>
