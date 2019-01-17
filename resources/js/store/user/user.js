// export const AUTH_REQUEST = 'AUTH_REQUEST'
// export const AUTH_SUCCESS = 'AUTH_SUCCESS'
// export const AUTH_ERROR = 'AUTH_ERROR'
// export const AUTH_LOGOUT = 'AUTH_LOGOUT'

// const state = { token: localStorage.getItem('user-token') || '', status: '', hasLoadedOnce: false }

const state = () => ({
    userInfo: localStorage.getItem('user-info'),
    token: localStorage.getItem('user-token') || ''
});

const getters = {
    getUserInfo: state => state.userInfo,
    isAuthenticated: state => !!state.token,
};

const actions = {
    authUser(context, info) {
        let userInfo = JSON.stringify(info);
        localStorage.setItem('user-info', userInfo);
        context.commit('authUser', info);
    },
    logOut(context, info) {
        localStorage.removeItem('user-info');
        context.commit('authUser', info);
    }
}

const mutations = {
    authUser(state, payload) {
        state.userInfo = payload;
        state.token = true;
    },
    logOut(state, payload) {
        state.userInfo = null;
        state.token = null;
    }
}

export default {
  state,
  getters,
  actions,
  mutations,
}