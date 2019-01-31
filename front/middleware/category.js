export default async function (context) {
  return await Promise.all([
    context.store.dispatch('category/LOAD_CATEGORY', {slug: context.params.slug}),
    context.store.dispatch('category/LOAD_POSTS', {slug: context.params.slug})
  ]);
}
