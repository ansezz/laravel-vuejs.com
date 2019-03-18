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
                    title: '🚀 Privacy Policy ',
                    description: 'Privacy Policy page',
                    image: '',
                    url: 'https://laravel-vuejs.com/privacy-policy',
                    type: 'website',
                }
            },
        },
        components: {
            mobile: () => import(`~/views/mobile/page/privacy-policy`),
            web: () => import(`~/views/web/page/privacy-policy`)
        }
    }
</script>

<style>
</style>
