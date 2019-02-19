<template>
    <component :is="this.$store.state.platform" />
</template>

<script>
    export default {
        layout: ({
            store
        }) => store.state.platform,
        components: {
            mobile: () => import(`~/views/mobile/jobs/companies`),
            web: () => import(`~/views/web/jobs/companies`)
        }
    }

</script>

<style>
</style>
