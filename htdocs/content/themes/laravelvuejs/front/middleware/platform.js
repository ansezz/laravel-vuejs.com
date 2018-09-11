export default function(context) {
  let platform = context.isMobile ? 'mobile' : 'web'
  context.store.commit('SET_PLATFORM', {platform: platform})
}
