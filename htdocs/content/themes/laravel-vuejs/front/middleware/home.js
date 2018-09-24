export default function(context) {
  context.store.dispatch("post/LOAD_POSTS")
  return context.store.dispatch("post/LOAD_FEATURED_POSTS")
}
