export default async function (context) {
  await context.store.dispatch('category/LOAD_CATEGORY', {slug: context.params.slug})
  await context.store.dispatch('category/LOAD_POSTS', {slug: context.params.slug})
  return true;
}
