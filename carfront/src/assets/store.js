import { createStore } from 'vuex';

export default createStore({
  state() {
    return {
      token: '',
      user: null,
    }
  },
  mutations: {
    setToken(state, token) {
      state.token = token
    },
    setUser(state, user) {
      state.user = user
    },
    clearToken(state) {
      state.token = ''
    },
    clearUser(state) {
      state.user = null
    }
  }
})
