export default async function (context) {
  await context.store.dispatch('tag/LOAD_TAG', {slug: context.params.slug})
  await context.store.dispatch('tag/LOAD_POSTS', {slug: context.params.slug})
  return true;
}
