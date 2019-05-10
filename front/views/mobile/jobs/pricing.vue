<template>
    <div class="pricing-container">
        <breadcrumb :pages="breadcrumbsData" />
    </div>
</template>

<script>
    export default {
        name: "Pricing",
        components: {
            Breadcrumb: () => import('@/components/shared/partials/elements/breadcrumb')
        },
        data() {
            return {
                breadcrumbsData: [{
                        name: 'Home',
                        link: "/"
                    },
                    {
                        name: 'Pricing',
                        link: "/"
                    }
                ]
            }
        }
    }

</script>

<style lang="stylus" scoped>
    .pricing-container
        padding-bottom 120px  
</style>
