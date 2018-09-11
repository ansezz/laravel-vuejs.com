
export const state = () => ({
  platform: '',
})

export const mutations = {
  //Set the latest news to state
  SET_PLATFORM: (state, {platform}) => {
    state.platform = platform
  },
}
