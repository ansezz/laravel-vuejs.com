export default function(context) {

  return context.store.dispatch('news/LOAD_NEWS_LATEST')

}
