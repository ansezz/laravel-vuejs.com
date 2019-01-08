<template>
    <div class="jobs-grid">
        <div class="job">
            <div class="job-left-area">
                <thumbnail />
                <div class="job-name-date">
                    <h4>New Blade Directives Coming to Laravel 5.6</h4>
                    <span class="date">24 JUL 2018</span>
                </div>
            </div>
            <div class="job-right-area">
                <ul>
                    <li>
                        <label>Location</label>
                        <span>Düsseldorf, Germany</span>
                    </li>
                    <li>
                        <label>Job type</label>
                        <span class="featured">Full-time</span>
                    </li>
                </ul>
            </div>
            <nuxt-link to="/" class="is-absolute" />
        </div>
        <div class="job">
            <div class="job-left-area">
                <thumbnail />
                <div class="job-name-date">
                    <h4>New Blade Directives Coming to Laravel 5.6</h4>
                    <span class="date">24 JUL 2018</span>
                </div>
            </div>
            <div class="job-right-area">
                <ul>
                    <li>
                        <label>Location</label>
                        <span>Düsseldorf, Germany</span>
                    </li>
                    <li>
                        <label>Job type</label>
                        <span class="featured">Full-time</span>
                    </li>
                </ul>
            </div>
            <nuxt-link to="/" class="is-absolute" />
        </div>
        <div class="job">
            <div class="job-left-area">
                <thumbnail />
                <div class="job-name-date">
                    <h4>New Blade Directives Coming to Laravel 5.6</h4>
                    <span class="date">24 JUL 2018</span>
                </div>
            </div>
            <div class="job-right-area">
                <ul>
                    <li>
                        <label>Location</label>
                        <span>Düsseldorf, Germany</span>
                    </li>
                    <li>
                        <label>Job type</label>
                        <span class="featured">Full-time</span>
                    </li>
                </ul>
            </div>
            <nuxt-link to="/" class="is-absolute" />
        </div>
        <div class="job">
            <div class="job-left-area">
                <thumbnail />
                <div class="job-name-date">
                    <h4>New Blade Directives Coming to Laravel 5.6</h4>
                    <span class="date">24 JUL 2018</span>
                </div>
            </div>
            <div class="job-right-area">
                <ul>
                    <li>
                        <label>Location</label>
                        <span>Düsseldorf, Germany</span>
                    </li>
                    <li>
                        <label>Job type</label>
                        <span class="featured">Full-time</span>
                    </li>
                </ul>
            </div>
            <nuxt-link to="/" class="is-absolute" />
        </div>
        <div class="job">
            <div class="job-left-area">
                <thumbnail />
                <div class="job-name-date">
                    <h4>New Blade Directives Coming to Laravel 5.6</h4>
                    <span class="date">24 JUL 2018</span>
                </div>
            </div>
            <div class="job-right-area">
                <ul>
                    <li>
                        <label>Location</label>
                        <span>Düsseldorf, Germany</span>
                    </li>
                    <li>
                        <label>Job type</label>
                        <span class="featured">Full-time</span>
                    </li>
                </ul>
            </div>
            <nuxt-link to="/" class="is-absolute" />
        </div>
        <div class="job">
            <div class="job-left-area">
                <thumbnail />
                <div class="job-name-date">
                    <h4>New Blade Directives Coming to Laravel 5.6</h4>
                    <span class="date">24 JUL 2018</span>
                </div>
            </div>
            <div class="job-right-area">
                <ul>
                    <li>
                        <label>Location</label>
                        <span>Düsseldorf, Germany</span>
                    </li>
                    <li>
                        <label>Job type</label>
                        <span class="featured">Full-time</span>
                    </li>
                </ul>
            </div>
            <nuxt-link to="/" class="is-absolute" />
        </div>
        <div class="job">
            <div class="job-left-area">
                <thumbnail />
                <div class="job-name-date">
                    <h4>New Blade Directives Coming to Laravel 5.6</h4>
                    <span class="date">24 JUL 2018</span>
                </div>
            </div>
            <div class="job-right-area">
                <ul>
                    <li>
                        <label>Location</label>
                        <span>Düsseldorf, Germany</span>
                    </li>
                    <li>
                        <label>Job type</label>
                        <span class="featured">Full-time</span>
                    </li>
                </ul>
            </div>
            <nuxt-link to="/" class="is-absolute" />
        </div>
        <div class="job">
            <div class="job-left-area">
                <thumbnail />
                <div class="job-name-date">
                    <h4>New Blade Directives Coming to Laravel 5.6</h4>
                    <span class="date">24 JUL 2018</span>
                </div>
            </div>
            <div class="job-right-area">
                <ul>
                    <li>
                        <label>Location</label>
                        <span>Düsseldorf, Germany</span>
                    </li>
                    <li>
                        <label>Job type</label>
                        <span class="featured">Full-time</span>
                    </li>
                </ul>
            </div>
            <nuxt-link to="/" class="is-absolute" />
        </div>
    </div>
</template>

<script>
    export default {
        name: 'AppJobs'
    }

</script>

<style lang="stylus" scoped>
    .jobs-grid
        display grid
        grid-gap 10px
    .job
        position relative
        border 2px solid #ebeef2
        padding 20px
        display flex
        align-items center
        justify-content space-between
    .job-left-area
        display flex
        align-items center
        padding-right 20px
        .article-image
            height 81px
            width 150px
            margin-right 20px
        .job-name-date
            width 232px
            h4
                font-size 16px
                color #384457
                font-weight 500
                margin-bottom 5px
                line-height 1.5
            .date
                font-size 14px
                color #616d82
                opacity .8
    .job-right-area
        ul
            display flex
            align-items center
            li
                padding-right 25px
                &:last-child
                    padding-right 0
                label
                    color #384457
                    font-size 14px
                    font-weight 500
                span
                    display block
                    font-size 14px
                    color #616d82
                    opacity .8
                    &.featured
                        height 30px
                        width 70px
                        background-color rgba($secondary, .1)
                        display flex
                        align-items center
                        justify-content center
</style>
