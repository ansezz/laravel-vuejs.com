import loginQql from '@/graphql/queries/auth/login.graphql';
import signupQql from '@/graphql/queries/auth/signup.graphql';
import meQql from '@/graphql/queries/auth/me.graphql';

export const state = () => ({
  me: null,
  me_token: {
    access_token: null,
    expires_at: null
  }
})

export const mutations = {
  //Set the latest news to state
  SET_ME: (state, val) => {
    state.me = val
  },

  SET_ME_TOKEN: (state, val) => {
    state.me_token = val
  },
}

export const actions = {
  //Get the latest news
  async LOAD_ME({commit}) {
    await this.app.apolloProvider.defaultClient.query({query: meQql})
      .then(({data}) => {
        commit('SET_ME', data.me)
      }).catch((error) => {
        console.log(error)
      })
  },
  async LOGIN({commit}, params) {
    await this.app.apolloProvider.defaultClient.query({query: loginQql, variables: params})
      .then(async ({data}) => {
        if (data.login) {
          await this.app.$apolloHelpers.onLogin(data.login.access_token)
          commit('SET_ME_TOKEN', data.login)
          this.dispatch('auth/LOAD_ME')
        }
      }).catch((error) => {
        console.log(error)
      })
  },
  async SIGNUP({commit}, params) {
    await this.app.apolloProvider.defaultClient.mutate({mutation: signupQql, variables: params})
      .then(({data}) => {
        console.log(data)
      }).catch((error) => {
        console.log(error)
      })
  },
}
