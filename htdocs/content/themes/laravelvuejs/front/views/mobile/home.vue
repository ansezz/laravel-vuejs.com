<!--laravelvuejs_Home_M.png-->
<template>

  <section class="mobile-view-home">

    <!-- Start Live Section -->

    <div class="live-section">
      <div class="live-box">
        <div class="right-area">
          <div class="live-hint">المباشر</div>
          <h2>بصراحة</h2>
          <p>برنامج ثقافي ترفيهي منوع يستقبل منتصرمن خلاله فنانين ومبدعين هواة ونجوم في مجالات عدة.</p>
          <a href="#" class="play-button"><i class="fa fa-play"></i></a>
        </div>
      </div>
    </div>

    <!-- End Live Section -->

    <!-- Start Web Radio Section -->

    <div class="webradios has-padding">
      <div class="heading">
        <h2>Webradios</h2>
      </div>
      <div class="webradios-list">
        <div class="webradio">
          <img src="@/assets/images/jazz.png" alt="#">
        </div>
        <div class="webradio">
          <img src="@/assets/images/jazz.png" alt="#">
        </div>
        <div class="webradio">
          <img src="@/assets/images/jazz.png" alt="#">
        </div>
        <div class="webradio">
          <img src="@/assets/images/jazz.png" alt="#">
        </div>
      </div>
    </div>

    <!-- End Web Radio Section -->

    <!-- Start News Section -->

    <div class="news-section has-padding">
      <div class="heading white-heading">
        <h2>النشرات الإخبارية</h2>
      </div>
      <div class="posts">
        <div class="post">
          <div class="post-thumbnail">
            <img src="@/assets/images/post-1.png">
          </div>
          <div class="post-body">
            <span>الإثنين  12 يونيو 2018</span>
            <h4>آخر نشرة إخبارية</h4>
          </div>
          <a href="#" class="play-button">
            <i class="fa fa-play"></i>
          </a>
        </div>
      </div>
      <a href="#" class="more-post-button">+</a>
    </div>

    <!-- End News Section -->

    <!-- Start Programms Section -->

    <div class="programs has-padding">
      <div class="container">
        <div class="heading">
          <h2>أقوى البرامج</h2>
        </div>
        <div class="program">
          <div class="program-box">
            <div class="program-content">
              <h2>بصراحة</h2>
              <p>برنامج ثقافي ترفيهي منوع يستقبل منتصرمن خلاله فنانين ومبدعين هواة ونجوم في مجالات عدة.</p>
              <div class="day">الأربعاء <span>18:00</span></div>
              <a href="#" class="program-link">+</a>
            </div>
          </div>
          <div class="program-body">
            <div class="heading heading-without-before">
              <h2>آخر الحلقات</h2>
            </div>
            <ul class="latest-news">
              <li>
                <div class="left-area">
                  <a href="#" class="play-button">
                    <i class="fa fa-play"></i>
                  </a>
                </div>
                <div class="right-area">
                  <h4>بدايات الغزو الإسرائيلي للبنان</h4>
                  <span>3m 45s</span>
                </div>
              </li>
              <li>
                <div class="left-area">
                  <a href="#" class="play-button">
                    <i class="fa fa-play"></i>
                  </a>
                </div>
                <div class="right-area">
                  <h4>بدايات الغزو الإسرائيلي للبنان</h4>
                  <span>3m 45s</span>
                </div>
              </li>
              <li>
                <div class="left-area">
                  <a href="#" class="play-button">
                    <i class="fa fa-play"></i>
                  </a>
                </div>
                <div class="right-area">
                  <h4>بدايات الغزو الإسرائيلي للبنان</h4>
                  <span>3m 45s</span>
                </div>
              </li>
            </ul>
          </div>
        </div>
        <div class="program">
          <div class="program-box">
            <div class="program-content">
              <h2>بصراحة</h2>
              <p>برنامج ثقافي ترفيهي منوع يستقبل منتصرمن خلاله فنانين ومبدعين هواة ونجوم في مجالات عدة.</p>
              <div class="day">الأربعاء <span>18:00</span></div>
              <a href="#" class="program-link">+</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- End Programms Section -->

  </section>

</template>

<script>
  export default {
    components: {},
    name: "home"
  }
</script>

<style lang="stylus" scoped>

  // Global Styles
  .container
    padding 0 15px

  .live-section

    .live-box
      background-image: url('../../assets/images/women-bg.png')
      background-size cover
      background-position center
      background-repeat no-repeat
      font-family $family-sans-serif
      color #FFF

      .right-area
        padding 60px 100px 60px 60px
        .live-hint
          display inline-block
          border 1px solid #fff
          padding 5px 15px 5px 25px
          position relative
          font-size 10px
          border-radius 2px
          margin-bottom 5px

          &:after
            content ""
            height 8px
            width 8px
            position absolute
            top 51%
            left 10px
            border-radius 50%
            transform translateY(-50%)
            background-color $primary

        h2
          font-size 35px
          font-weight 700
          margin-bottom 5px

        p
          font-size: 10px
          margin-bottom 20px
          padding-right 40px

        .play-button
          display inline-block
          width 50px
          height 50px
          border-radius 50%
          background-color #FFF
          color $primary
          font-size: 25px
          line-height 50px
          text-align center

          .fa
            margin-right 5px

  // Heading Style
  .heading
    margin-bottom 30px
    text-align center

    &.white-heading

      h2
        color #FFF

        &:before
          background-color #FFF

    h2
      color $secondary
      font-size 25px
      font-weight 600

      &:before
        content ""
        display block
        width 18px
        height 3px
        background-color $primary
        margin auto auto 5px

  // Spacing Between Sections
  .has-padding
    padding 35px 0

  // Webradios Section
  .webradios-list
    display flex
    align-items center
    justify-content center

    .webradio
      padding-left 25px

      &:first-child
        padding-left 0

  // News Section
  .news-section
    background-color $primary

  .posts

    .post
      position relative

      .post-body
        position absolute
        top 0
        right 0
        height 100%
        width 100%
        display flex
        flex-direction column
        justify-content flex-end
        padding 0 20px 35px

        span
          color $primary
          margin-bottom 5px
          font-size 15px

        h4
          color #FFF
          font-size 25px
          font-weight 700

      .play-button
        position absolute
        width 50px
        height 50px
        background-color #FFF
        line-height 50px
        text-align center
        color $primary
        right 30px
        border-radius 50%
        font-size 25px
        bottom -20px

        .fa
          margin-right 5px

  .more-post-button
    color rgba(255, 255, 255, .6)
    display block
    width 50px
    height 50px
    border 1px solid rgba(255, 255, 255, .6)
    margin 40px auto 0
    text-align center
    line-height 45px
    font-size 30px

  // Programms Section
  .program
    margin-bottom 15px

    &:first-child
      margin-bottom 0

    .program-box
      padding 60px
      position relative

      .program-content
        background-image: url('../../assets/images/women-bg.png')
        background-size cover
        background-position center
        background-repeat no-repeat
        color #FFF

        h2
          font-size 35px
          font-weight 700
          margin-bottom 15px

        p
          font-size: 12px
          margin-bottom 20px
          padding-right 80px

        .day
          display inline-block
          border 1px solid #FFF
          padding 8px 10px
          border-radius 2px
          font-size 14px

        span
          color $primary
          font-weight 600
          font-size 15px
          display inline-block
          padding-left 5px

        .program-link
          position absolute
          bottom 0
          right 0
          width 50px
          height 50px
          background-color $primary
          color #FFF
          line-height 45px
          text-align center
          font-size 25px


</style>
