export default function(context) {
  return context.store.dispatch('news/LOAD_POST_CURRENT', {slug: context.params.slug})
}
