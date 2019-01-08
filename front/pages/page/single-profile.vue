<template>
    <component :is="this.$store.state.platform" />
</template>

<script>
    export default {
        layout: ({
            store
        }) => store.state.platform,
        components: {
            mobile: () => import(`~/views/mobile/page/single-profile`),
            web: () => import(`~/views/web/page/single-profile`)
        }
    }

</script>

<style>
</style>
