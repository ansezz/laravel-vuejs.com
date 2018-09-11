<template>
  <div>
    <header>
      <div class="navbar">
        <div class="navbar-header">
          <div class="navbar-toggle">
            <a @click="openMenu">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </a>
          </div>
          <div class="logo-container">
            <a href="#"><img src="@/assets/images/brand.white.svg" alt="media1radio"></a>
          </div>
          <div v-if="!navOpened" class="search-container">
            <a href="javascript:;"><img src="@/assets/images/search.png" alt="search"></a>
          </div>
        </div>
      </div>

      <!-- Start Main Menu -->

      <div :class="navOpened ? 'menu open': 'menu'">
        <div class="menu-header">
          <div class="logo">
            <a href="#"><img src="@/assets/images/blue-brand.png" alt="media1radio"></a>
          </div>
          <form action="#" method="POST" class="search-form">
            <div class="form-group">
              <input type="text" name="search" placeholder="ابحث هنا..." class="form-control">
              <button type="submit" name="search-btn" class="search-btn">
                <img src="@/assets/images/search-img.png" alt="#">
              </button>
            </div>
          </form>
          <form action="#" method="POST" class="language-form">
            <button type="submit" name="arabic-lang" class="btn btn-solid">العربية</button>
            <button type="submit" name="french-lang" class="btn btn-bordred">Francais</button>
          </form>
        </div>
        <div class="menu-body">
          <ul class="main-menu">
            <li><a href="#">الرئيسية</a></li>
            <li><a href="#">أخبار</a></li>
            <li><a href="#">البرامج</a></li>
            <li><a href="#">الجدولة</a></li>
            <li><a href="#">نشرات الأخبار</a></li>
            <li><a href="#">روسيا2018</a></li>
            <li><a href="#" class="small-links">اتصل بنا</a></li>
            <li><a href="#" class="small-links">الترددات</a></li>
            <li><a href="#" class="small-links">الجدولة</a></li>
          </ul>
        </div>
        <ul class="menu-footer">
          <li>
            <a href="#">
              <i class="fa fa-facebook"></i>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="fa fa-twitter"></i>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="fa fa-youtube"></i>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="fa fa-instagram"></i>
            </a>
          </li>
        </ul>
      </div>

      <!-- End Main Menu -->
    </header>
    <main>
      <nuxt/>
    </main>
    <footer>
      Footer mobile
    </footer>
  </div>
</template>

<script>

  export default {

    data() {
      return {
        navOpened: false
      }
    },
    methods: {
      openMenu() {
        this.navOpened = !this.navOpened
      }
    }
  }

</script>

<style lang="stylus" scoped>

  body
    margin 0

  *
    box-sizing border-box
    font-family $family-sans-serif

  .navbar
    background-color $secondary

    .navbar-header
      padding 30px 20px
      overflow hidden
      position relative
      display flex
      align-items center
      justify-content space-between
      box-shadow 0 0 25px 0 rgba(0, 0, 0, .3)

      .navbar-toggle
        float left

        a
          .icon-bar
            background-color #FFF
            width 25px
            -webkit-transition all .35s ease-in-out
            -moz-transition all .35s ease-in-out
            -o-transition all .35s ease-in-out
            transition all .35s ease-in-out
            height 2px
            display block
            margin-bottom 6px
            &:last-child
              margin-bottom 0
            &:nth-child(2)
              width: 12.5px

      .logo-container
        position absolute
        max-width 210px
        top 50%
        right 50%
        transform translate(50%, -50%)

      .search-container
        float right
        width 25px

  .menu
    width 310px
    background-color #FFF
    box-shadow 0 0 10px 0 rgba(211, 206, 206, 0.2)
    position absolute
    top 0
    left -100%
    transition left .35s ease-in-out
    padding 0 25px 50px

    &.open
      left 0

    .menu-header
      padding 25px 0 10px

      .logo
        max-width 210px
        margin auto auto 25px

        a
          display block

      .search-form

        .form-group
          position relative

          .form-control
            background-color #f3f7f9
            width 100%
            padding 15px
            box-sizing border-box
            font-size 15px

          .search-btn
            position absolute
            top 0
            right 15px
            width 25px
            height 100%

      .language-form
        overflow hidden
        margin-top 25px

        .btn
          padding 10px
          width calc(100% / 2 - 4px)
          font-family $family-sans-serif
          float left
          border-radius 4px
          border: 1px solid transparent
          margin 0 2px

          &.btn-solid
            background-color $primary
            color #FFF
            font-weight 600
            border-color $primary

          &.btn-bordred
            border-color #c5c5c5
            color #c5c5c5

    .menu-body
      padding-bottom 15px

      .main-menu

        li

          a
            font-size 18px
            font-weight bold
            font-family $family-sans-serif
            color $secondary
            display block
            border-bottom 1px solid #f1e9e9
            padding 15px 0

            &.small-links
              font-weight 400
              border-bottom 0
              padding-bottom 10px

    .menu-footer
      display flex
      flex-direction row-reverse

      li
        padding-left 50px

        a
          color $secondary
          font-size 35px

      &:last-child
        padding-left 0

</style>
