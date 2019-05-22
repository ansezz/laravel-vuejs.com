export default async function (context) {
    return await Promise.all([
        context.store.dispatch("post/LOAD_POPULAR_POSTS"),
        context.store.dispatch("post/LOAD_POSTS", {
            count: 13,
            page: 1,
            sort_by: 'latest',
        }),
        context.store.dispatch("post/LOAD_FEATURED_POSTS")
    ]);
}
