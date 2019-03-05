<template>
    <section class="create-job-container">
        <breadcrumb :pages="breadcrumbsData" />
        <app-create-job />
    </section>
</template>

<script>
    export default {
        name: "CreateJob",
        components: {
            Breadcrumb:   () => import('@/components/shared/partials/elements/breadcrumb'),
            AppCreateJob: () => import('@/components/web/partials/app-create-job')
        },
        data() {
            return {
                breadcrumbsData: [{
                        name: 'Home',
                        link: "/"
                    },
                    {
                        name: 'Create Job',
                        link: "/page/create-job"
                    }
                ]
            }
        }
    }

</script>

<style lang="stylus" scoped>
    .create-job-container
        padding-bottom 120px
</style>
