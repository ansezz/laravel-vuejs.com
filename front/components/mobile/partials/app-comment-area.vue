<template>
  <div class="comment-container">
    <div class="mobile-container">
    <div class="comments-header">
      <div class="title-count is-flex">
        <heading>friends’ comments</heading>
        <span>3 Comments</span>
      </div>
      <div class="show">
        <select name="show" class="form-control has-custom">
          <option value="3">show 3 comments</option>
          <option value="4">show 4 comments</option>
          <option value="5">show 5 comments</option>
        </select>
      </div>
    </div>
    <ul class="comments">
      <li class="comment">
          <div class="comment-header">
            <div class="comment-info">
              <div class="img-wrp">
                <img src="@/assets/images/brackets.png" alt="LV">
              </div>
              <h5>Adil Mohamed</h5>
              <span class="date">1 Day ago.    12 JUI 2018.    13:55</span>
            </div>
            <div class="reply">
              <a href="#" class="reply-btn">
                <img src="@/assets/images/icons-reply.svg" alt="LV">
                <span>Reply</span>
              </a>
            </div>
          </div>
          <div class="comment-body">
            <p>Then why’d keep calling it serverless? Just call it cloud hosting, which is exactly what it is..</p>
          </div>
      </li>
      <li class="comment has-children">
          <div class="comment-header">
            <div class="comment-info">
              <div class="img-wrp">
                <img src="@/assets/images/brackets.png" alt="LV">
              </div>
              <h5>Salwa (dev546)</h5>
              <span class="date">1 Day ago.    12 JUI 2018.    13:55</span>
            </div>
            <div class="reply">
              <a href="#" class="reply-btn">
                <img src="@/assets/images/icons-reply.svg" alt="LV">
                <span>Reply</span>
              </a>
            </div>
          </div>
          <div class="comment-body">
            <p>If people who were mostly engineers, as opposed to mostly marketers, popularized the terminology, there probably wouldn’t need to be an explanation every time the term came up because the term would be self explanatory (at least among the people discussing it).</p>
          </div>
          <ul class="children">
            <li class="comment">
              <div class="comment-header">
                <div class="comment-info">
                  <div class="img-wrp">
                    <img src="@/assets/images/brackets.png" alt="LV">
                  </div>
                  <h5>Adil Mohamed</h5>
                  <span class="date">1 Day ago.    12 JUI 2018.    13:55</span>
                </div>
                <div class="reply">
                  <a href="#" class="reply-btn">
                    <img src="@/assets/images/icons-reply.svg" alt="LV">
                    <span>Reply</span>
                  </a>
                </div>
              </div>
              <div class="comment-body">
                <p>Then why’d keep calling it serverless? Just call it cloud hosting, which is exactly what it is..</p>
              </div>
          </li>
          </ul>
      </li>
    </ul>
    <div class="comment-form">
      <heading>Leave a comment</heading>
      <form action="#" method="POST">
        <div class="inputs">
          <div class="form-group"><input type="text" name="name" placeholder="Your Name" class="form-control has-custom"></div>
          <div class="form-group"><input type="email" name="email" placeholder="E-mail" class="form-control has-custom"></div>
        </div>
        <div class="form-group">
          <textarea name="comment" class="form-control has-custom" placeholder="What’s in your head?" rows="4"></textarea>
        </div>
        <div class="actions">
          <div class="checking">
            <input type="checkbox" id="checked" class="check">
            <label for="checked">Subscribe me to the newsletter</label>
          </div>
          <button type="submit" name="publish" class="button">Publish</button>
        </div>
      </form>
    </div>
  </div>
  </div>
</template>

<script>
    export default {
        name: "AppCommentArea",
        data() {
            return {
            }
        }
    }

</script>

<style lang="stylus" scoped>
  .comment-container
    .comments-header
      margin-bottom 30px
    .title-count
      margin-bottom 10px
      span
        color rgba(#616d82, .8)
        font-size 14px
        display inline-block
        padding-left 10px
    .show
      .has-custom
        background-color transparent
        padding 0 15px 0 0
        border 0
  .comments
    .comment
      padding 20px
      border 1px solid #ebeef2
      margin-bottom 20px
      &.has-children
        .children
          padding 20px 0 0
          .comment
            &:last-child
              margin-bottom 0
      .comment-header
        text-align center
        margin-bottom 20px
        .comment-info
          margin-bottom 10px
        .img-wrp
          width 40px
          height 40px
          display flex
          align-items center
          justify-content center
          background-color rgba(#384457, .05)
          border-radius 50%
          margin auto
          img
            width 15px
        h5
          color #384457
          font-size 14px
          font-weight 600
          margin 10px 0
        .date
          color rgba(#616d82, .8)
          font-size 14px
        .reply-btn
          span
            display inline-block
            font-size 12px
            font-weight 600
            color $secondary
            text-transform uppercase
            letter-spacing 2px
            margin-left 5px
      .comment-body
        text-align center
        p
          margin-bottom 0
          font-size 18px
          line-height 28px
          color #616d82
  .comment-form
    padding-top 10px
    form
      padding-top 20px
      .inputs
        display grid
        grid-template-columns repeat(1, 1fr)
        grid-gap 20px
        margin-bottom 20px
      .form-group
        margin-bottom 0
        textarea
          height auto
      .actions
        margin-top 20px
        .checking
          margin-bottom 20px
          label
            padding-top 2px
        .button
          width 100%
</style>
