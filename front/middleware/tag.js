export default async function (context) {
  return await Promise.all([
    context.store.dispatch('tag/LOAD_TAG', {slug: context.params.slug}),
    context.store.dispatch('tag/LOAD_POSTS', {slug: context.params.slug})
  ]);
}
