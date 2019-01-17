<template>
    <div class="single-profile-container">
        <breadcrumb :pages="breadcrumbsData" />
        <div class="single-profile-header">
            <div class="container">
                <ul class="left-area">
                    <li>
                        <img src="@/assets/images/single-profile-icon.png" alt="LV">
                        <span>Beats Electrics</span>
                    </li>
                    <li>
                        <span>Morocco (+2)</span>
                        <img src="@/assets/images/icons-extern.svg" alt="LV">
                    </li>
                </ul>
                <div class="filters">
                    <div class="filter-group">
                        <select name="showen-posts">
                            <option value="1">show 16 posts</option>
                            <option value="1">show 16 posts</option>
                            <option value="1">show 16 posts</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <select name="most-popular">
                            <option value="2">Most popular first</option>
                            <option value="2">Most popular first</option>
                            <option value="2">Most popular first</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="actions">
                <form action="#" method="post">
                    <div class="search-input">
                        <input type="search" name="search" class="form-control has-custom" placeholder="*Keywords, Locations, Job titles..">
                        <img src="@/assets/images/icons-search.svg" alt="LV">
                    </div>
                    <div class="region-area">
                        <select name="region" class="form-control has-custom">
                            <option value="-1">Region</option>
                        </select>
                        <button class="button" type="submit">Search</button>
                    </div>
                </form>
            </div>
        </div>
        <section class="job-tabs">
            <div class="container">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Home1</a></li>
                    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Profile</a></li>
                    <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Messages</a></li>
                    <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Settings</a></li>
                </ul>
            </div>
        </section>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="home">1...</div>
    <div role="tabpanel" class="tab-pane" id="profile">2...</div>
    <div role="tabpanel" class="tab-pane" id="messages">3...</div>
    <div role="tabpanel" class="tab-pane" id="settings">4...</div>
  </div>
        <div class="container">
            <div class="content-wrapper">
                <div class="col-9">
                    <app-jobs />
                    <pagination/>  
                </div>
                <div class="col-3">
                    <app-latest-profiles />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "SigneProfile",
        components: {
            Breadcrumb: () => import('@/components/shared/partials/elements/breadcrumb'),
            Pagination: () => import('@/components/shared/partials/elements/pagination'),
            AppLatestProfiles: () => import('@/components/web/partials/app-latest-profiles'),
            AppJobs: () => import('@/components/web/partials/app-jobs')
        },
        data() {
            return {
                breadcrumbsData: [{
                        name: 'Home',
                        link: "/"
                    },
                    {
                        name: 'Companies',
                        link: "/"
                    },
                    {
                        name: 'Beats Electronics',
                        link: "/"
                    }
                ]
            }
        }
    }

</script>

<style lang="stylus" scoped>
    .single-profile-container
        padding-bottom 120px
    .content-wrapper
        display flex
        justify-content space-between
        padding-top 40px
        .col-9
            width 720px
            padding-right 20px
        .col-3
            width calc(100% - 720px)
    .single-profile-header
        margin-top 40px
        margin-bottom 20px
        height 70px
        display flex
        align-items center
        background-image linear-gradient(to top, rgba(135, 147, 167, .1), rgba(135,147,167,0))
    .actions
        form
            display flex
            align-items center
            justify-content space-between
            .search-input
                width 670px
                margin-right 10px
                position relative
                img
                    position absolute
                    top 50%
                    right 20px
                    transform translateY(-50%)
            .region-area
                width calc(100% - 680px)
                display flex
                align-items center
                select
                    margin-right 10px
        .container
            overflow hidden
    .left-area
        float left
        display flex
        align-items center
        li
            display flex
            align-items center
            font-size 24px
            color #384457
            padding-right 10px
            img
                padding-right 10px
            &:last-child
                padding-right 0
                padding-top 5px
                span
                    font-size 14px
                    color #616d82
                    opacity .8
                img
                    padding-right 0
                    padding-left 5px
                    cursor pointer
            
    .filters
        float right
        display flex
        align-items center
        height 34px

    .filter-group
        position relative
        margin-right 45px

        &:after
            content "\f0d7"
            font-family "FontAwesome"
            color $secondary
            padding-left 15px

        &:last-child
            margin-right 0

        select
            font-size 12px
            font-weight 600
            letter-spacing 2px
            color $secondary
            text-transform uppercase
            border 0
            background-color transparent
            outline none
            -webkit-appearance none
            -moz-appearance none
            appearance none    
</style>
