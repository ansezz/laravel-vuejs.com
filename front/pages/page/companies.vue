<template>
    <component :is="this.$store.state.platform" />
</template>

<script>
    export default {
        layout: ({
            store
        }) => store.state.platform,
        components: {
            mobile: () => import(`~/views/mobile/page/companies`),
            web: () => import(`~/views/web/page/companies`)
        }
    }

</script>

<style>
</style>
