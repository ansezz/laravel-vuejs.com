export default function(context) {
  let platform = context.isMobileOrTablet ? 'mobile' : 'web'
  context.store.commit('SET_PLATFORM', {platform: platform})
}
