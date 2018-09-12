export default function(context) {

  return context.store.dispatch('post/LOAD_FEATURED_POSTS')
}
