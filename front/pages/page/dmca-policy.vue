<template>
    <component :is="this.$store.state.platform"/>
</template>

<script>
    import seo from '@/mixins/seo'

    export default {
        mixins: [seo],
        layout: ({store}) => store.state.platform,
        computed: {
            seo() {
                return {
                    title: '🚀 Dmca Policy ',
                    description: 'Dmca Policy page',
                    image: '',
                    url: 'https://laravel-vuejs.com/dmca-policy',
                    type: 'website',
                }
            },
        },
        components: {
            mobile: () => import(`~/views/mobile/page/dmca-policy`),
            web: () => import(`~/views/web/page/dmca-policy`)
        }
    }
</script>

<style>
</style>
