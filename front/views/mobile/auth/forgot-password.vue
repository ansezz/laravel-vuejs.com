<template>
    <section class="forgot-password">
        <app-forgot-password />
    </section>
</template>

<script>
export default {
    name: "ForgotPassword",
    components: {
        AppForgotPassword: () => import('@/components/mobile/partials/app-forgot-password'),
    },
    props: {}
}
</script>

<style lang="stylus" scoped>
    .forgot-password
        padding 65px 0
</style>
