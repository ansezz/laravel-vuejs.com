import loginQql from '@/graphql/queries/auth/login.graphql';
import logoutQql from '@/graphql/queries/auth/logout.graphql';
import signupQql from '@/graphql/queries/auth/signup.graphql';
import meQql from '@/graphql/queries/auth/me.graphql';

export const state = () => ({
  loggedIn: false,
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

  SET_LOGGED_IN: (state, val) => {
    state.loggedIn = val
  },
}

export const actions = {
  //Get the latest news
  async LOAD_ME({commit}) {
    await this.app.apolloProvider.defaultClient.query({query: meQql})
      .then(({data}) => {
        if (data.me) {
          commit('SET_ME', data.me)
          commit('SET_LOGGED_IN', true)
        }
      }).catch((error) => {
        console.log(error)
      })
  },
  async LOGIN({commit}, params) {
    return await this.app.apolloProvider.defaultClient.query({query: loginQql, variables: params})
      .then(async ({data}) => {
        if (data.login) {
          await this.app.$apolloHelpers.onLogin(data.login.access_token)
          commit('SET_ME_TOKEN', data.login)
          commit('SET_LOGGED_IN', true)
          this.$router.push('/')
        }
        return false
      })
  },
  async LOGOUT({commit}) {
    await this.app.apolloProvider.defaultClient.query({query: logoutQql})
      .then(async ({data}) => {
        commit('SET_LOGGED_IN', false)
        await this.app.$apolloHelpers.onLogout()
        this.$router.push('/')
      }).catch((error) => {
        console.log(error)
      })
  },
  async SIGNUP({commit}, params) {
    await this.app.apolloProvider.defaultClient.mutate({mutation: signupQql, variables: params})
      .then(({data}) => {
        if (data.signup)
          this.$router.push('/auth/login')
      })
  },
}
