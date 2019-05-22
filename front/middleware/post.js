export default function (context) {
  return context.store.dispatch('post/LOAD_POST', {slug: context.params.slug})
}
