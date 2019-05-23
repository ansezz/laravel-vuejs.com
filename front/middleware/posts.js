export default function (context) {
  return context.store.dispatch('post/LOAD_POSTS', {
    count: context.query.count,
    page: context.query.page,
    sort_by: context.query.sort_by,
  })
}
