<template>
    <nav class="breadcrumbs">
        <ul class="breadcrumb-list">
            <li class="breadcrumb-item">
                <nuxt-link class="breadcrumb-anchor" to="/">Home</nuxt-link>
            </li>
            <li class="breadcrumb-item is-active">
                <nuxt-link class="breadcrumb-anchor" to="/">Newsletter</nuxt-link>
            </li>
        </ul>
    </nav>
</template>

<script>
export default {
    name: "breadcrumb",
}
</script>

<style lang="stylus" scoped>
    .breadcrumbs
        margin 20px 0 0
        
    .breadcrumb-list
        display flex
        align-items center
        justify-content center
        
    .breadcrumb-item
        display flex
        align-items center
        &:not(:last-child):after
            display block
            margin 0 5px
            width 20px
            height 20px
            content ""
            background-image url('../../../../assets/images/icons-next.svg')

    &.is-active .breadcrumb-anchor
        font-weight bold

    .breadcrumb-anchor
        color $secondary
        font-size 12px
        opacity .8
</style>
