export default function (context) {
  context.store.dispatch("post/LOAD_POSTS", {
    count: context.query.count,
    page: context.query.page,
    sort_by: context.query.sort_by,
  })
  context.store.dispatch("post/LOAD_POPULAR_POSTS")
  return context.store.dispatch("post/LOAD_FEATURED_POSTS")
}
