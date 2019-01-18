<template>
    <component :is="this.$store.state.platform" />
</template>

<script>
    export default {
        layout: ({
            store
        }) => store.state.platform,
        components: {
            mobile: () => import(`~/views/mobile/page/job-archive`),
            web: () => import(`~/views/web/page/job-archive`)
        }
    }

</script>

<style>
</style>
