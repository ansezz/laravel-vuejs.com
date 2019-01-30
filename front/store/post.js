import postsQql from '@/graphql/queries/post/all.graphql';
import featuredPostsQql from '@/graphql/queries/post/featured.graphql';
import postBySlugQql from '@/graphql/queries/post/bySlug.graphql';

export const state = () => ({
  single: null,
  posts: [],
  featured: [],
  popular: []
})

export const mutations = {
  //Set the latest news to state
  SET_FEATURED_POSTS: (state, val) => {
    state.featured = val
  },
  SET_POPULAR_POSTS: (state, val) => {
    state.popular = val
  },

  SET_POST: (state, val) => {
    state.single = val
  },

  SET_POSTS: (state, val) => {
    state.posts = val
  },
}

export const actions = {
  async LOAD_FEATURED_POSTS({commit}) {
    let variables = {count: 8};
    await this.app.apolloProvider.defaultClient.query({query: featuredPostsQql, variables})
      .then(({data}) => {
        commit('SET_FEATURED_POSTS', data.featuredPosts)
      }).catch((error) => {
        console.log(error)
      })
  },
  LOAD_POSTS: async function ({commit}, variables) {
    Object.keys(variables).forEach(key => variables[key] === undefined ? delete variables[key] : '');
    if (!variables.count)
      variables.count = 8;

    await this.app.apolloProvider.defaultClient.query({query: postsQql, variables})
      .then(({data}) => {
        commit('SET_POSTS', data.posts)
      }).catch((error) => {
        console.log(error)
      })
  },
  LOAD_POPULAR_POSTS: async function ({commit}) {
    let variables = {
      count: 4,
      sort_by: 'popular',
    }
    await this.app.apolloProvider.defaultClient.query({query: postsQql, variables})
      .then(({data}) => {
        commit('SET_POPULAR_POSTS', data.posts)
      }).catch((error) => {
        console.log(error)
      })
  },
  async LOAD_POST({commit}, {slug}) {
    let variables = {slug};
    await this.app.apolloProvider.defaultClient.query({query: postBySlugQql, variables})
      .then(({data}) => {
        commit('SET_POST', data.postBySlug)
      }).catch((error) => {
        console.log(error)
      })
  },
}
