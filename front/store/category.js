import postsQql from '@/graphql/queries/category/posts.graphql';
import categoryQql from '@/graphql/queries/category/bySlug.graphql';

export const state = () => ({
  category: null,
  posts: []
})

export const mutations = {
  SET_CATEGORY: (state, val) => {
    state.category = val
  },

  SET_POSTS: (state, val) => {
    state.posts = val
  },
}

export const actions = {
  async LOAD_POSTS({commit, state}, {slug}) {
    if (state.category) {
      let variables = {count: 8, slug};
      await this.app.apolloProvider.defaultClient.query({query: postsQql, variables})
        .then(({data}) => {
          commit('SET_POSTS', data.postsByCategory)
        }).catch((error) => {
          console.log(error)
        })
    }
  },
  async LOAD_CATEGORY({commit}, {slug}) {
    let variables = {slug};
    await this.app.apolloProvider.defaultClient.query({query: categoryQql, variables})
      .then(({data}) => {
        commit('SET_CATEGORY', data.categoryBySlug)
      }).catch((error) => {
        console.log(error)
      })
  },
}
