export default function (context) {
  context.store.dispatch("post/LOAD_POSTS", {
    count: context.query.count,
    page: context.query.page,
    sort_by: context.query.sort_by,
  })
  return context.store.dispatch("post/LOAD_FEATURED_POSTS")
}
