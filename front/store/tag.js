import postsQql from '@/graphql/queries/tag/posts.graphql';
import tagQql from '@/graphql/queries/tag/bySlug.graphql';

export const state = () => ({
  tag: null,
  posts: []
})

export const mutations = {
  SET_TAG: (state, val) => {
    state.tag = val
  },

  SET_POSTS: (state, val) => {
    state.posts = val
  },
}

export const actions = {
  async LOAD_POSTS({commit}, {slug}) {
    let variables = {count: 8, slug};
    await this.app.apolloProvider.defaultClient.query({query: postsQql, variables})
      .then(({data}) => {
        commit('SET_POSTS', data.postsByTag)
      }).catch((error) => {
        console.log(error)
      })
  },
  async LOAD_TAG({commit}, {slug}) {
    let variables = {slug};
    await this.app.apolloProvider.defaultClient.query({query: tagQql, variables})
      .then(({data}) => {
        commit('SET_TAG', data.tagBySlug)
      }).catch((error) => {
        console.log(error)
      })
  },
}
