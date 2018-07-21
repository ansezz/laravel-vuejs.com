export default function(context) {

  let platform = context.isMobile ? 'mobile' : 'desktop'
  context.store.commit('SET_PLATFORM', {platform: platform})

}
