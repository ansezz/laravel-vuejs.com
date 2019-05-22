<template>
    <component :is="this.$store.state.platform" />
</template>

<script>
    export default {
        layout: ({
            store
        }) => store.state.platform,
        components: {
            mobile: () => import(`~/views/mobile/jobs/single-profile`),
            web: () => import(`~/views/web/jobs/single-profile`)
        }
    }

</script>

<style>
</style>
